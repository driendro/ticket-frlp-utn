<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
        $this->load->view('header', $data);
        $this->load->view('menu', $data);
        $this->load->view('footer');
    }
}
