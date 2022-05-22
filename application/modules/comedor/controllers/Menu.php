<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('menu_model');
    }

    public function index()
    {
        $data = [
            'titulo' => 'Menu',
            'menu' => $this->menu_model->getMenu()
        ];
        $this->load->view('usuario/header', $data);
        $this->load->view('menu', $data);
        $this->load->view('general/footer');
    }
}
