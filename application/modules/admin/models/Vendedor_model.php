<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vendedor_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getUserById($id)
	{
		return $this->db->select('*')->where('id_vendedor', $id)->get('vendedor')->row();
	}

	public function getLastNameByDocumento($documento)
	{
		return $this->db->select('apellido')->where('dni', $documento)->get('vendedor')->row('apellido');
	}

	public function getFirstNameByDocumento($documento)
	{
		return $this->db->select('nombre')->where('dni', $documento)->get('vendedor')->row('nombre');
	}

	public function getDocumentoByNickName($nickName)
	{
		return $this->db->select('dni')->where('nombre_usuario', $nickName)->get('vendedor')->row('dni');
	}

	public function getIdByDocumento($documento)
	{
		return $this->db->select('id_vendedor')->where('dni', $documento)->get('vendedor')->row('id_vendedor');
	}

	public function getPasswordById($id)
	{
		return $this->db->select('pass')->where('id_vendedor', $id)->get('vendedor')->row('pass');
	}

	public function updatePassword($password)
	{
		$data = [
			'pass' => md5($password)
		];

		$this->db->where('id_vendedor', $this->session->userdata('id_vendedor'));
		$this->db->update('vendedor', $data);
		return true;
	}

	public function getHistoryById($idvendedor)
	{
		$this->db->select('*');
		$this->db->from('log_carga');
		$this->db->join('usuarios', 'log_carga.id_usuario=usuarios.id');
		$this->db->where('id_vendedor', $idvendedor);
		$this->db->limit(20);
		$query = $this->db->get();
		return $query->result();
	}

	public function getCargasByFechaForPDF($fecha)
	{
		$this->db->select('*');
		$this->db->from('log_carga');
		$this->db->join('vendedor', 'log_carga.id_vendedor=vendedor.id_vendedor');
		$this->db->join('usuarios', 'log_carga.id_usuario=usuarios.id');
		$this->db->where('fecha', $fecha);
		$query = $this->db->get();
		return $query->result();
	}

	public function validateVendedor($nickName, $password)
	{
		$this->db->where('nombre_usuario', $nickName);
		$this->db->where('pass', $password);
		return $this->db->get('vendedor')->row();
	}
}