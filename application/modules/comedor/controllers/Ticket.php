<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ticket extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('ticket_model');
		$this->load->model('usuario/usuario_model');
		$this->load->model('feriado_model');

		if (!$this->session->userdata('is_user')) {
			redirect(base_url('login'));
		}
	}

	public function estadoComedor()
	{
		//Con esta funcion se verifica si el comedor se encuentra cerrado, definiendo los periodos
		//entre la fecha de apertura y cierre, y las vacaciones de invierno
		$hoy = date('Y-m-d', time());
		$apertura = $this->config->item('apertura');
		$vaca_ini = $this->config->item('vacaciones_i');
		$vaca_fin = $this->config->item('vacaciones_f');
		$cierre = $this->config->item('cierre');

		if ($hoy >= $apertura && $hoy <= $vaca_ini) {
			//Primer semestre
			return true;
		} elseif ($hoy >= $vaca_fin && $hoy <= $cierre) {
			//Segundo semestre
			return true;
		}
	}

	public function estadoCompra()
	{
		//Con esta funcion se verifica si el comedor habilitado para usarse, definindo los periodos
		// de compra entre el lunes y el jueves
		$hoy = date('N');
		$ahora = date('H:i:s', time());
		$dia_ini = $this->config->item('dia_inicial');
		$dia_fin = $this->config->item('dia_final');
		$hora_fin = $this->config->item('hora_final');

		if ($hoy >= $dia_ini && $hoy < $dia_fin) {
			//Si hoy esta entre el lunes y el jueves
			return true;
		} elseif ($hoy == $dia_fin && $ahora <= $hora_fin) {
			//y si es viernes hasta las 12:00AM
			return true;
		}
	}

	public function index()
	{
		$id_usuario = $this->session->userdata('id_usuario');
		$nroDia = date('N');
		$proximo_lunes = time() + ((7 - ($nroDia - 1)) * 24 * 60 * 60);
		$proximo_lunes_fecha = date('Y-m-d', $proximo_lunes);
		$proximo_viernes = time() + ((7 - ($nroDia - 5)) * 24 * 60 * 60);
		$proximo_viernes_fecha = date('Y-m-d', $proximo_viernes);
		$usuario = $this->usuario_model->getUserById($id_usuario);

		if ($this->estadoComedor()) {
			if ($this->estadoCompra()) {
				$data = [
					'titulo' => 'Comprar',
					'usuario' => $usuario,
					'feriados' => $this->feriado_model->getFeriadosInRange($proximo_lunes_fecha, $proximo_viernes_fecha),
					'comprados' => $this->ticket_model->getComprasInRangeByIdUser($proximo_lunes_fecha, $proximo_viernes_fecha, $id_usuario),
					'costoVianda' => $this->ticket_model->getCostoById($usuario->id)
				];

				$this->load->view('usuario/header', $data);
				$this->load->view('index', $data);
				$this->load->view('general/footer');
			} else {
				$data = [
					'titulo' => 'Comprar',
					'alerta' => "<p>Fuera del horario de compra</p><p>La compra se realiza desde el Lunes hasta el Viernes a las {$this->config->item('hora_final')}</p>"
				];

				$this->load->view('usuario/header', $data);
				$this->load->view('alerta_comedor_cerrado', $data);
				$this->load->view('general/footer');
			}
		} else {
			$data = [
				'titulo' => 'Comprar',
				'alerta' => '<p>El comedor no funciona en este Periodo</p>'
			];

			$this->load->view('usuario/header', $data);
			$this->load->view('alerta_comedor_cerrado', $data);
			$this->load->view('general/footer');
		}
	}

	public function datos()
	{
		$totalCompra = $this->input->post('total');

		$id_usuario = $this->session->userdata('id_usuario');
		$costoVianda = $this->ticket_model->getCostoById($id_usuario);
		$nroDia = date('N');
		$proximo_lunes = time() + ((7 - ($nroDia - 1)) * 24 * 60 * 60);
		$proximo_lunes_fecha = date('Y-m-d', $proximo_lunes);
		$proximo_viernes = time() + ((7 - ($nroDia - 5)) * 24 * 60 * 60);
		$proximo_viernes_fecha = date('Y-m-d', $proximo_viernes);

		if ($totalCompra > $this->usuario_model->getSaldoById($this->session->userdata('id_usuario'))) {
			redirect(base_url('menu'));
		}

		$dias = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes'];
		// carga de la comppra en la DB
		foreach ($dias as $id => $dia) {
			if ($this->input->post("check{$dia}")) {
				$nroDia = date('N');
				$proximo = time() + ((7 - $nroDia + ($id + 1)) * 24 * 60 * 60);

				$data = [
					'fecha' => date('Y-m-d', time()),
					'hora' => date('H:i:s', time()),
					'dia_comprado' => date('Y-m-d', $proximo),
					'id_usuario' => $this->session->userdata('id_usuario'),
					'precio' => $costoVianda,
					'tipo' => $this->input->post("selectTipo{$dia}"),
					'turno' => $this->input->post("selectTurno{$dia}"),
					'menu' => $this->input->post("selectMenu{$dia}"),
				];

				$this->ticket_model->addCompra($data);
			}
		}
		//Confeccion del correo del recivo
		$usuario = $this->usuario_model->getUserById($this->session->userdata('id_usuario'));
		$compras = $this->ticket_model->getComprasInRangeByIdUser($proximo_lunes_fecha, $proximo_viernes_fecha, $id_usuario);
		$dataRecivo['compras'] = $compras;
		$dataRecivo['total'] = count(array_column($compras, 'id')) * $costoVianda;
		$dataRecivo['fechaHoy'] = date('d/m/Y', time());
		$dataRecivo['horaAhora'] = date('H:i:s', time());
		$dataRecivo['recivoNumero'] = implode(array_column($compras, 'id'));

		$subject = "Recibo de compra del comedor";
		$message = $this->load->view('general/correos/recibo_compra', $dataRecivo, true);

		if ($this->generalticket->smtpSendEmail($usuario->mail, $subject, $message))

			redirect(base_url('usuario'));
	}
}
