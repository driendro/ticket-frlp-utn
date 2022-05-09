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

	public function passwordRecoveryRequest($documento)
	{
		$data['titulo'] = 'Recuperacion de Contraseña';
		$data['tipo'] = 'solicitud';

		if ($this->input->method() == 'post') {
			$usuario = $this->usuario_model->getUserByDocumento($documento);

			if ($usuario) {
				$token = md5($usuario->mail);
				if ($this->usuario_model->getRecoveryByToken($token)) {
					redirect(base_url('login'));
				} else {
					$data['tipo'] = 'solicitud';
					$data['nombre'] = $usuario->nombre;
					$data['apellido'] = $usuario->apellido;
					$data['dni'] = $usuario->documento;
					$data['link'] = base_url("usuario/recovery/{$token}");

					$subject = "Solicitud de restablecimineto de contraseña";
					$message = $this->load->view('general/correos/cambio_contraseña', $data, true);

					if ($this->generalticket->smtpSendEmail($usuario->mail, $subject, $message)) {
						$newLog = [
							'fecha' => date('Y-m-d', time()),
							'hora' => date('H:i:s', time()),
							'id_usuario' => $usuario->id,
							'token' => $token
						];
						$this->usuario_model->addLogPassrecovery($newLog);
						redirect(base_url('login'));
					}
				}
			} else {
				redirect(base_url('usuario/recovery'));
			}

			$this->load->view('header', $data);
			$this->load->view('recovery', $data);
			$this->load->view('general/footer');
		}
		$this->load->view('header', $data);
		$this->load->view('recovery', $data);
		$this->load->view('general/footer');
	}

	public function newPasswordRequest($recovery)
	{
		$data['tipo'] = 'cambio';
		$data['titulo'] = 'Cambio de Contraseña';

		if ($this->input->method() == 'post') {
			$pass1 = $this->input->post('password1');
			$pass2 = $this->input->post('password2');
			$token = $recovery->token;
			if ($pass1 == $pass2) {
				$iduser = $recovery->id_usuario;
				$this->usuario_model->updatePasswordById($pass1, $iduser);
				redirect(base_url('login'));
			} else {
				$data['alerta'] = 'Las contraseñas no coinciden';
				redirect(base_url("usuario/recovery/{$token}"));
			}
		} else {
			$this->load->view('header', $data);
			$this->load->view('recovery', $data);
			$this->load->view('general/footer');
		}
	}


	public function recoveryPassword()
	{
		$data['titulo'] = 'Recuperacion de Contraseña';
		$token_uri = $this->uri->segment(3);

		if ($token_uri != 'recovery') {
			$token_uri = $this->uri->segment(3);
			$recovery = $this->usuario_model->getRecoveryByToken($token_uri);
			if ($recovery != null) {
				$this->newPasswordRequest($recovery);
			} else {
				$data['tipo'] = 'null';
				$data['alerta'] = 'Solicitud de recuperacion no valida';

				$this->load->view('header', $data);
				$this->load->view('recovery', $data);
				$this->load->view('general/footer');
			}
		} else {
			// Si no le pasamos un token md5, mestra formulario para solicitar
			// el recovery de la password
			$documento = $this->input->post('documento');
			$this->passwordRecoveryRequest($documento);
		}
	}
}
