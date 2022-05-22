<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Carga_model extends CI_Model //Tabla -log_carga-
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getCargasByNickname($nick)
    {
        return $this->db->select('*')->where('vendedor', $nick)->get('log_carga')->result();
    }

    public function addCargaLog($data)
    {
        $this->db->insert('log_carga', $data);
    }
}
