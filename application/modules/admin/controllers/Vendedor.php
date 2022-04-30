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
				$this->session->set_flashdata('documento', $documento);
			} else {
				$data['usuario'] = FALSE;
			}

			$this->load->view('header', $data);
			$this->load->view('index', $data);
			$this->load->view('comedor/footer');
		} else {
			$this->load->view('header', $data);
			$this->load->view('index');
			$this->load->view('comedor/footer');
		}
	}

	public function cargarSaldo()
	{
		if ($this->input->method() == 'post') {
			$documento = $this->input->post('dni');
			$usuario = $this->usuario_model->getUserByDocumento($documento);
			$iduser = $usuario->id_usuario;
			$carga = $this->input->post('carga');
			$this->usuario_model->updateSaldoByUserId($iduser, $carga);
			$codCargaMax = max(array_column($this->carga_model->getCodCarga(), 'cod_carga'));

			$cargaLog = [
				'cod_carga' => $codCargaMax + 1,
				'fecha_y_hora' => date('Y-m-d H:i:s', time()),
				'id_usuario' => $iduser,
				'monto' => $carga,
				'nombre_vendedor' => $this->session->nick_name
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

			if ($this->usuario_model->getUserByDocumento($numerodni)) {
				// Verifico si el DNI ya existe como usuario
				redirect(base_url("{$password}"));
			};
			if ($this->usuario_model->getUserByLegajo($legajo)) {
				// Verifico si el Legajo ya existe como usuario
				redirect(base_url("{$legajo}"));
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
		} else {
			$this->load->view('header', $data);
			$this->load->view('crear_usuario', $data);
			$this->load->view('comedor/footer');
		}
	}

	public function updateUser()
	{
		$data = [
			'titulo' => 'Actualizar Usuario'
		];

		$documento = $this->session->flashdata('documento');
		$usuario = $this->usuario_model->getUserByDocumento($documento);
		$data['usuario'] = $usuario;

		// Verifico si se carga informacion en el formulario
		if ($this->input->method() == 'post') {
			null;
		} else {
			$this->load->view('header', $data);
			$this->load->view('modificar_usuario', $data);
			$this->load->view('comedor/footer');
		}
	}
}