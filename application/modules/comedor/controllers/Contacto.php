<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contacto extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = [
            'titulo' => 'Contacto'
        ];

        $this->load->view('usuario/header', $data);
        $this->load->view('contacto');
        $this->load->view('general/footer');
    }
}
