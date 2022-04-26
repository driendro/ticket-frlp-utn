<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginVendedor extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('vendedor_model');

		// Esta funcion controla si existe la variable de sesion 'is_admin' para
		// impedir que muestre el formulario de ingreso si ya esta logeado
		// if($this->session->userdata('is_admin'))
		// {
		// 	redirect(base_url('admin/index'));
		// }

    }


	public function Login()
    {
        if($this->session->userdata('is_admin'))
        {
			redirect(base_url('admin/index'));
        }
		if($this->session->userdata('is_user'))
		{
			redirect(base_url('logout'));
		}

        $data = [
            'titulo' => 'Login Vendedor'
        ];

        if ($this->input->method() == 'post')
        {
            $nickName = $this->input->post('nick-name');
            $password = $this->input->post('password');
			$nickName = strtolower($nickName);
			$documento = $this->vendedor_model->getDocumentoByNickName($nickName);

            if($this->vendedor_model->validateVendedor($nickName, md5($password)))
            {
                $session = [
                    'id_vendedor'  => $this->vendedor_model->getIdByDocumento($documento),
					'nick_name' => $nickName,
                    'apellido' => $this->vendedor_model->getLastNameByDocumento($documento),
                    'nombre' => $this->vendedor_model->getFirstNameByDocumento($documento),
					'is_user'=> FALSE,
					'is_admin'=> TRUE
                ];
                $this->session->set_userdata($session);
                redirect(base_url('admin/index'));
            }
            else
            {
                redirect(base_url('admin'));
            }
        }
        else
        {
            $this->load->view('vendedor/header', $data);
            $this->load->view('vendedor/login');
            $this->load->view('footer');
        }
    }
}
