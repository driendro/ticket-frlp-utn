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

	public function index()
	{
		$id_usuario = $this->session->userdata('id_usuario');
		$nroDia = date('N');
		$proximo_lunes = time() + ((7 - ($nroDia - 1)) * 24 * 60 * 60);
		$proximo_lunes_fecha = date('Y-m-d', $proximo_lunes);
		$proximo_viernes = time() + ((7 - ($nroDia - 5)) * 24 * 60 * 60);
		$proximo_viernes_fecha = date('Y-m-d', $proximo_viernes);
		$usuario = $this->usuario_model->getUserById($id_usuario);

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
	}

	public function datos()
	{
		$totalCompra = $this->input->post('total');

		$id_usuario = $this->session->userdata('id_usuario');
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
					'precio' => 180,
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
		$dataRecivo['total'] = count(array_column($compras, 'id')) * 180;
		$dataRecivo['fechaHoy'] = date('d/m/Y', time());
		$dataRecivo['horaAhora'] = date('H:i:s', time());
		$dataRecivo['recivoNumero'] = implode(array_column($compras, 'id'));

		$subject = "Recibo de compra del comedor";
		$message = $this->load->view('general/correos/recibo_compra', $dataRecivo, true);

		if ($this->generalticket->smtpSendEmail($usuario->mail, $subject, $message))

			redirect(base_url('usuario'));
	}
}
