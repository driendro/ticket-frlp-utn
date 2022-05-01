<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuario extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('usuario_model');
		$this->load->model('comedor/feriado_model');
		$this->load->model('comedor/ticket_model');

		if (!$this->session->userdata('is_user')) {
			if ($this->session->userdata('is_admin')) {
				redirect(base_url('logout'));
			}
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

		$data = [
			'titulo' => 'Comprar',
			'usuario' => $this->usuario_model->getUserById($id_usuario),
			'feriados' => $this->feriado_model->getFeriadosInRange($proximo_lunes_fecha, $proximo_viernes_fecha),
			'comprados' => $this->ticket_model->getComprasInRangeByIdUser($proximo_lunes_fecha, $proximo_viernes_fecha, $id_usuario)
		];

		$this->load->view('header', $data);
		$this->load->view('index', $data);
		$this->load->view('general/footer');
	}

	public function changePassword()
	{
		$data = [
			'titulo' => 'Cambio de contraseña'
		];

		if ($this->input->method() == 'post') {
			$password_anterior = $this->input->post('password_anterior');
			$password_nuevo = $this->input->post('password_nuevo');
			$password_confirmado = $this->input->post('password_confirmado');
			$password = $this->usuario_model->getPasswordById(
				$this->session->userdata('id_usuario')
			);
			if ($password == md5($password_anterior)) {
				if ($password_nuevo == $password_confirmado) {
					if ($this->usuario_model->updatePassword($password_nuevo)) {
						redirect(base_url('logout'));
					}
				}
			} else {
				redirect(base_url('usuario/cambio-password'));
			}
		} else {
			$this->load->view('header', $data);
			$this->load->view('change_password');
			$this->load->view('general/footer');
		}
	}

	public function historial()
	{
		$id_usuario = $this->session->userdata('id_usuario');
		$data = [
			'titulo' => 'Historial de compras',
			'compras' => $this->usuario_model->getHistorialByIdUser($id_usuario)
		];

		$this->load->view('header', $data);
		$this->load->view('historial', $data);
		$this->load->view('general/footer');
	}

	public function devolverCompra()
	{
		$id_usuario = $this->session->userdata('id_usuario');
		$nroDia = date('N');
		$proximo_lunes = time() + ((7 - ($nroDia - 1)) * 24 * 60 * 60);
		$proximo_lunes_fecha = date('Y-m-d', $proximo_lunes);
		$proximo_viernes = time() + ((7 - ($nroDia - 5)) * 24 * 60 * 60);
		$proximo_viernes_fecha = date('Y-m-d', $proximo_viernes);
		$data = [
			'titulo' => 'Devolucion de compras',
			'compras' => $this->ticket_model->getComprasInRangeByIdUser($proximo_lunes_fecha, $proximo_viernes_fecha, $id_usuario),
			'devolucion' => TRUE
		];

		if ($this->input->method() == 'post') {
			$id_compra = $this->input->post('compraId');
			$this->ticket_model->removeCompra($id_compra, $id_usuario);
			redirect(base_url('usuario/devolver_compra'));
		} else {
			$this->load->view('header', $data);
			$this->load->view('historial', $data);
			$this->load->view('general/footer');
		}
	}
}