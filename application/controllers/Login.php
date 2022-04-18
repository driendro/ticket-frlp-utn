<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('usuario_model');
    }

    public function index()
    {
        if($this->general->isLogged())
        {
            redirect(base_url('usuario'));
        }

        $data = [
            'titulo' => 'Login'
        ];

        if ($this->input->method() == 'post')
        {
            $documento = $this->input->post('documento');
            $password = $this->input->post('password');
            if($this->usuario_model->validateUser($documento, md5($password)))
            {
                $session = [
                    'id_usuario'  => $this->usuario_model->getIdByDocumento($documento),
                    'apellido' => $this->usuario_model->getLastNameByDocumento($documento),
                    'nombre' => $this->usuario_model->getFirstNameByDocumento($documento),
                    'logged_in' => TRUE
                ];
                $this->session->set_userdata($session);
                redirect(base_url('usuario'));
            }
            else
            {
                redirect(base_url('login'));
            }
        }
        else
        {
            $this->load->view('header', $data);
            $this->load->view('login');
            $this->load->view('footer');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url('login'),'refresh');
    }
}
