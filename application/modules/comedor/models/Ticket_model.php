<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ticket_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function addCompra($data)
	{
		$saldo = $this->db->select('saldo')->where('id', $this->session->userdata('id_usuario'))->get('usuarios')->row('saldo');
		if ($saldo >= 180) {
			if ($this->db->insert('log_compra', $data)) {
				$saldo = $saldo - 180;
			}
			return $this->db->set('saldo', $saldo)->where('id', $this->session->userdata('id_usuario'))->update('usuarios');
		} else {
			return false;
		}
	}

	public function getComprasInRangeByIdUser($fecha_i, $fecha_f, $idusuario)
	{
		return $this->db->select('*')->where('id_usuario', $idusuario)->where('dia_comprado >=', $fecha_i)->where('dia_comprado <=', $fecha_f)->get('log_compra')->result();
	}

	public function removeCompra($idcompra, $idusuario)
	{
		$saldo = $this->db->select('saldo')->where('id', $idusuario)->get('usuarios')->row('saldo');
		$saldo = $saldo + 180;

		$this->db->set('saldo', $saldo)->where('id', $idusuario)->update('usuarios');
		$this->db->delete('log_compra', array('id' => $idcompra));
	}
}