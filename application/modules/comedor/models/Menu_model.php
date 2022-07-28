<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getMenu()
    {
        /* USado en:
        index
        */
        $this->db->select('*');
        $query = $this->db->get('menu');
        return $query->result();
    }
}