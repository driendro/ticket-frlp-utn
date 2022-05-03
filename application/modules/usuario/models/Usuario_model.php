<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuario_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getUserById($id)
	{
		return $this->db->select('*')->where('id', $id)->get('usuarios')->row();
	}

	public function getUserByDocumento($documento)
	{
		return $this->db->select('*')->where('documento', $documento)->get('usuarios')->row();
	}

	public function getUserByLegajo($legajo)
	{
		return $this->db->select('*')->where('legajo', $legajo)->get('usuarios')->row();
	}

	public function getLastNameByDocumento($documento)
	{
		return $this->db->select('apellido')->where('documento', $documento)->get('usuarios')->row('apellido');
	}

	public function getFirstNameByDocumento($documento)
	{
		return $this->db->select('nombre')->where('documento', $documento)->get('usuarios')->row('nombre');
	}

	public function getIdByDocumento($documento)
	{
		return $this->db->select('id')->where('documento', $documento)->get('usuarios')->row('id');
	}

	public function getPasswordById($id)
	{
		return $this->db->select('pass')->where('id', $id)->get('usuarios')->row('pass');
	}

	public function getSaldoById($id)
	{
		return $this->db->select('saldo')->where('id', $id)->get('usuarios')->row('saldo');
	}

	public function updateSaldoByUserId($iduser, $saldo)
	{
		$saldoActual = $this->db->select('saldo')->where('id', $iduser)->get('usuarios')->row('saldo');
		$saldoNuevo = $saldoActual + $saldo;

		$this->db->set('saldo', $saldoNuevo)->where('id', $iduser)->update('usuarios');
	}

	public function updatePassword($password)
	{
		$data = [
			'pass' => md5($password)
		];

		$this->db->where('id', $this->session->userdata('id_usuario'));
		$this->db->update('usuarios', $data);
		return true;
	}

	public function updatePasswordById($password, $iduser)
	{
		$data = [
			'pass' => md5($password)
		];

		$this->db->where('id', $iduser);
		$this->db->update('usuarios', $data);
		return true;
	}

	public function updateUserById($iduser, $data)
	{
		$this->db->where('id', $iduser)->update('usuarios', $data);
		return true;
	}

	public function validateUser($documento, $password)
	{
		$this->db->where('documento', $documento);
		$this->db->where('pass', $password);
		return $this->db->get('usuarios')->row();
	}

	public function getHistorialByIdUser($id)
	{
		return $this->db->select('*')->where('id', $id)->limit(15)->order_by('dia_comprado', 'DESC')->get('log_compra')->result();
	}

	public function addNewUser($data)
	{
		$this->db->insert('usuarios', $data);

		return true;
	}
}
