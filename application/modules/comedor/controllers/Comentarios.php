<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Comentarios extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('comentarios_model');
    }

    public function index() {
        $data = [
            'titulo' => 'Comentarios'
        ];

        $this->load->view('usuario/header', $data);
        $this->load->view('comentarios');
        $this->load->view('general/footer');
    }

    public function agregar_comentario() 
    {
        if (!$this->session->userdata('is_user')) {
            redirect(base_url('login'));
        } else {
            if ($this->input->method() == 'post'){

                $comentario = $this->input->post('comentario');

                $newComment = [
                    'id_usuario' => $this->session->userdata('id_usuario'),
                    'comentario' => $comentario,
                    'fecha' => date('Y-m-d', time()),
                    'hora' => date('H:i:s', time())
                ];
                $this->comentarios_model->guardar_comentario($newComment);

                redirect(base_url('comentarios'));

            } else {
                redirect(base_url('comentarios'));
            }
        }
        
    }
}