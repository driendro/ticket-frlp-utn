<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function addCompra($data)
    {
        $saldo = $this->db->select('saldo')->where('id_usuario', $this->session->userdata('id_usuario'))->get('usuario')->row('saldo');
        if($saldo >= 180)
        {
            if($this->db->insert('log_compra', $data))
            {
                $saldo = $saldo - 180;
            }
            return $this->db->set('saldo', $saldo)->where('id_usuario', $this->session->userdata('id_usuario'))->update('usuario');
        }
        else
        {
            return false;
        }
    }

	public function getComprasInRange($fecha_i, $fecha_f)
	{
		return $this->db->select('*')->where('dia_comprado >=', $fecha_i)->where('dia_comprado <=', $fecha_f)->get('log_compra')->result();
	}

	public function removeCompra($idcompra, $idusuario)
    {
        $saldo = $this->db->select('saldo')->where('id_usuario', $idusuario)->get('usuario')->row('saldo');
		$saldo = $saldo+180;

		$this->db->set('saldo', $saldo)->where('id_usuario', $idusuario)->update('usuario');
		$this->db->delete('log_compra', array('id'=>$idcompra));
    }
}
