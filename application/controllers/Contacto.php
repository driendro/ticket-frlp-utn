<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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

        $this->load->view('header', $data);
        $this->load->view('contacto');
        $this->load->view('footer');
    }
}
