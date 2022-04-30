<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Carga_model extends CI_Model //Tabla -cargar_saldo-
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getCargasByNickname($nick)
	{
		return $this->db->select('*')->where('nombre_vendedor', $nick)->get('cargar_saldo')->result();
	}

	public function getCodCarga()
	{
		return $this->db->select('cod_carga')->get('cargar_saldo')->result();
	}

	public function addCargaLog($data)
	{
		$this->db->insert('cargar_saldo', $data);
	}
}