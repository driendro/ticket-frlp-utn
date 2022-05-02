<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('usuario_model');
	}

	public function index()
	{
		if ($this->session->userdata('is_user')) {
			if ($this->session->userdata('is_admin')) {
				redirect(base_url('logout'));
			}
			redirect(base_url('usuario'));
		}

		$data = [
			'titulo' => 'Login'
		];

		if ($this->input->method() == 'post') {
			$documento = $this->input->post('documento');
			$password = $this->input->post('password');
			if ($this->usuario_model->validateUser($documento, md5($password))) {
				$session = [
					'id_usuario'  => $this->usuario_model->getIdByDocumento($documento),
					'apellido' => $this->usuario_model->getLastNameByDocumento($documento),
					'nombre' => $this->usuario_model->getFirstNameByDocumento($documento),
					'is_user' => TRUE,
					'is_admin' => FALSE,
				];
				$this->session->set_userdata($session);
				redirect(base_url('usuario'));
			} else {
				redirect(base_url('login'));
			}
		} else {
			$this->load->view('header', $data);
			$this->load->view('login');
			$this->load->view('general/footer');
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url('login'), 'refresh');
	}

	public function recoveryPassword()
	{
		$data['titulo'] = 'Recuperacion de Contraseña';

		if ($this->input->method() == 'post') {
			$documento = $this->input->post('documento');
			$usuario = $this->usuario_model->getUserByDocumento($documento);

			if ($usuario) {
				//Crer Password aleatorio de la forma 3letras+3numeros
				$numeros_permitidos = '0123456789';
				$letras_permitidas = 'abcdefghijklmnopqrstuvwxyz';
				$num3 = substr(str_shuffle($numeros_permitidos), 0, 3);
				$pal3 = substr(str_shuffle($letras_permitidas), 0, 3);
				$password = "{$pal3}{$num3}";

				$data['nombre'] = $usuario->nombre;
				$data['apellido'] = $usuario->apellido;
				$data['dni'] = $usuario->documento;
				$data['password'] = $password;

				$subject = "Aquí está tu nueva contraseña para TickeWeb-FRLP";
				$message = $this->load->view('general/correos/cambio_contraseña', $data, true);

				if ($this->generalticket->smtpSendEmail($usuario->mail, $subject, $message)) {
					if ($this->usuario_model->updatePasswordById($password, $usuario->id_usuario)) {
						redirect(base_url('login'));
					}
				}
			} else {
				redirect(base_url('usuario/recovery'));
			}
		}

		$this->load->view('header', $data);
		$this->load->view('recovery');
		$this->load->view('general/footer');
	}
}