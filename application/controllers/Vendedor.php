<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendedor extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('vendedor_model');
        $this->load->model('usuario_model');

		// Esta funcion controla si existe la variable de sesion 'is_admin' para
		// impedir que muestre la vista a un user
		if(!$this->session->userdata('is_admin'))
		{
			redirect(base_url('usuario'));
		}
    }

	public function index()
    {
		$data = [
            'titulo' => 'Vendedor'
        ];

		if($this->input->method() == 'post')
		{
			$documento = $this->input->post('numeroDni');
			$usuario = $this->usuario_model->getUserByDocumento($documento);

			if($usuario)
			{
				$data['usuario'] = $usuario;
			}
			else
			{
				$data['usuario'] = FALSE;
			}

			$this->load->view('vendedor/header', $data);
			$this->load->view('vendedor/index', $data);
			$this->load->view('footer');

		}
		else
		{
			$this->load->view('vendedor/header', $data);
			$this->load->view('vendedor/index');
			$this->load->view('footer');
		}

    }

	public function crateUser()
	{
		$data = [
			'titulo' => 'Nuevo Usuario'
		];

		if ($this->input->method() == 'post')
        {
			null;
        }
        else
        {
            $this->load->view('vendedor/header', $data);
            $this->load->view('vendedor/crear_usuario.php');
            $this->load->view('footer');
        }
	}

/*
    public function changePassword()
    {
        $data = [
            'titulo' => 'Cambio de contraseña'
        ];

        if ($this->input->method() == 'post')
        {
            $password_anterior = $this->input->post('password_anterior');
            $password_nuevo = $this->input->post('password_nuevo');
            $password_confirmado = $this->input->post('password_confirmado');
            $password = $this->usuario_model->getPasswordById(
                $this->session->userdata('id_usuario'));
            if($password == md5($password_anterior))
            {
                if($password_nuevo == $password_confirmado)
                {
                    if($this->usuario_model->updatePassword($password_nuevo))
                    {
                        redirect(base_url('logout'));
                    }
                }
            }
            else
            {
                redirect(base_url('usuario/cambio-password'));
            }
        }
        else
        {
            $this->load->view('header', $data);
            $this->load->view('change_password');
            $this->load->view('footer');
        }
    }

    public function historial()
    {
        $data = [
            'titulo' => 'Historial de compras',
            'compras' => $this->usuario_model->getHistorialByIdUser(
                $this->session->userdata('id_usuario'))
        ];

        $this->load->view('header', $data);
        $this->load->view('historial', $data);
        $this->load->view('footer');
    } */
}
