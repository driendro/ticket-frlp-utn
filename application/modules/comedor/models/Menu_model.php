<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getMenu()
    {
        return $this->db->select('*')->get('menu')->result();
    }
}
