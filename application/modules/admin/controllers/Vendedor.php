<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendedor extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('vendedor_model');
        $this->load->model('usuario_model');

        if($this->session->userdata('is_user'))
        {
            redirect(base_url('usuario'));
        }

        if(!$this->session->userdata('is_admin'))
        {
            redirect(base_url('admin/login'));
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
            $numerodni = $this->input->post('dni');
            $legajo = $this->input->post('legajo');

            if($this->usuario_model->getUserByDocumento($numerodni))
            {
                redirect(base_url("{$numerodni}"));
            }
            if($this->usuario_model->getUserByLegajo($legajo))
            {
                redirect(base_url("{$legajo}"));
            }
            redirect(base_url('admin/nuevo_usuario'));
        }
        else
        {
            $this->load->view('vendedor/header', $data);
            $this->load->view('vendedor/crear_usuario.php');
            $this->load->view('footer');
        }
    }
}
