<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vendedor extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('vendedor_model');
		$this->load->model('usuario/usuario_model');
		$this->load->model('carga_model');

		if ($this->session->userdata('is_user')) {
			redirect(base_url('usuario'));
		}

		if (!$this->session->userdata('is_admin')) {
			redirect(base_url('admin/login'));
		}
	}

	public function index()
	{
		$data = [
			'titulo' => 'Vendedor'
		];

		if ($this->input->method() == 'post') {
			$documento = $this->input->post('numeroDni');
			$usuario = $this->usuario_model->getUserByDocumento($documento);

			if ($usuario) {
				$data['usuario'] = $usuario;
				//Seteo el numero de documento como variable de sesion
				$this->session->set_flashdata('documento', $documento);
			} else {
				$data['usuario'] = FALSE;
			}

			$this->load->view('header', $data);
			$this->load->view('index', $data);
			$this->load->view('general/footer');
		} else {
			$this->load->view('header', $data);
			$this->load->view('index');
			$this->load->view('general/footer');
		}
	}

	public function cargarSaldo()
	{
		//$this->generalticket->smtpSendEmail('jorge.ronconi@gmail.com', 'Prueba 1', 'Hola mundo');

		if ($this->input->method() == 'post') {
			$documento = $this->input->post('dni'); //obtengo el numero de documento
			$carga = $this->input->post('carga'); // obtengo el monto a cargar
			$usuario = $this->usuario_model->getUserByDocumento($documento); //obtengo el user de ese dni
			$iduser = $usuario->id; //obtengo el id del user
			$this->usuario_model->updateSaldoByUserId($iduser, $carga); // modifico el salodo del usuario

			//Genero la carga en la tabla carga_saldo como log
			$cargaLog = [
				'fecha' => date('Y-m-d', time()),
				'hora' => date('H:i:s', time()),
				'id_usuario' => $iduser,
				'monto' => $carga,
				'id_vendedor' => $this->session->id_vendedor
			];
			$this->carga_model->addCargaLog($cargaLog);

			redirect(base_url('admin'));
		} else {
			redirect(base_url('admin'));
		}
	}

	public function createUser()
	{
		$data = [
			'titulo' => 'Nuevo Usuario'
		];

		// Verifico si se carga informacion en el formulario
		if ($this->input->method() == 'post') {
			// Si el methodo es POST, obtengo el dni y el legajo
			$numerodni = $this->input->post('dni');
			$legajo = $this->input->post('legajo');

			//Crer Password aleatorio de la forma 3letras+3numeros
			$numeros_permitidos = '0123456789';
			$letras_permitidas = 'abcdefghijklmnopqrstuvwxyz';
			$num3 = substr(str_shuffle($numeros_permitidos), 0, 3);
			$pal3 = substr(str_shuffle($letras_permitidas), 0, 3);
			$password = "{$pal3}{$num3}";

			//Asigno el costo de la vianda segun el tipo de usuario
			//1-Estudiante || 2-Becado || 3-Docente || 4-No Docente
			if ($this->input->post('beca') == 'Si') {
				$idPrecio = 2;
			} else {
				if ($this->input->post('claustro') == 'Estudiante') {
					$idPrecio = 1;
				} elseif ($this->input->post('claustro') == 'No Docente') {
					$idPrecio = 4;
				} elseif ($this->input->post('claustro') == 'Docente') {
					$idPrecio = 3;
				}
			};

			$newUser = [
				'tipo' => $this->input->post('claustro'),
				'legajo' => $legajo,
				'documento' => $numerodni,
				'pass' => md5($password),
				'nombre' => ucwords($this->input->post('nombre')),
				'apellido' => ucwords($this->input->post('apellido')),
				'especialidad' => $this->input->post('especialidad'),
				'mail' => strtolower($this->input->post('email')),
				'saldo' => $this->input->post('saldo'),
				'estado' => 1,
				'id_precio' => $idPrecio
			];
			if ($this->usuario_model->addNewUser($newUser)) {
				//Confeccion del correo del recivo
				$correo = $this->input->post('email');
				$dataCorreo['dni'] = $numerodni;
				$dataCorreo['apellido'] = $this->input->post('apellido');
				$dataCorreo['nombre'] = $this->input->post('nombre');
				$dataCorreo['password'] = $password;

				$subject = "Bienvenido al Comedor Universitario UTN-FRLP";
				$message = $this->load->view('general/correos/nuevo_usuario', $dataCorreo, true);
				$this->generalticket->smtpSendEmail($correo, $subject, $message);

				redirect(base_url('admin'));
			}
		} else {
			$this->load->view('header', $data);
			$this->load->view('crear_usuario', $data);
			$this->load->view('general/footer');
		}
	}

	public function updateUser()
	{
		$data = [
			'titulo' => 'Actualizar Usuario'
		];
		$iduser = $this->uri->segment(3);

		if (null == $this->usuario_model->getUserById($iduser)) {
			redirect(base_url('admin'));
		}

		$usuario = $this->usuario_model->getUserById($iduser);
		$data['usuario'] = $usuario;

		//Asigno el costo de la vianda segun el tipo de usuario
		//1-Estudiante || 2-Becado || 3-Docente || 4-No Docente
		if ($this->input->post('beca') == 'Si') {
			$idPrecio = 2;
		} else {
			if ($this->input->post('claustro') == 'Estudiante') {
				$idPrecio = 1;
			} elseif ($this->input->post('claustro') == 'No Docente') {
				$idPrecio = 4;
			} elseif ($this->input->post('claustro') == 'Docente') {
				$idPrecio = 3;
			}
		};

		// Verifico si se carga informacion en el formulario
		if ($this->input->method() == 'post') {
			$updateUser = [
				'tipo' => $this->input->post('claustro'),
				'legajo' => $this->input->post('legajo'),
				'documento' => $this->input->post('documento'),
				'nombre' => ucwords($this->input->post('nombre')),
				'apellido' => ucwords($this->input->post('apellido')),
				'tipo' => ucwords($this->input->post('claustro')),
				'especialidad' => ucwords($this->input->post('especialidad')),
				'mail' => strtolower($this->input->post('email')),
				'id_precio' => $idPrecio
			];

			if ($this->usuario_model->updateUserById($iduser, $updateUser)) {
				redirect(base_url('admin'));
			}
		} else {
			$this->load->view('header', $data);
			$this->load->view('modificar_usuario', $data);
			$this->load->view('general/footer');
		}
	}
}
