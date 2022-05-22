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
        $idusuario = $this->session->userdata('id_usuario');
        $idPrecio = $this->db->select('id_precio')->where('id', $idusuario)->get('usuarios')->row('id_precio');
        $costoVianda = $this->db->select('costo')->where('id', $idPrecio)->get('precios')->row('costo');
        $saldo = $this->db->select('saldo')->where('id', $idusuario)->get('usuarios')->row('saldo');
        if ($saldo >= 180) {
            if ($this->db->insert('log_compra', $data)) {
                $saldo = $saldo - $costoVianda;
            }
            return $this->db->set('saldo', $saldo)->where('id', $this->session->userdata('id_usuario'))->update('usuarios');
        } else {
            return false;
        }
    }

    public function getCostoById($id)
    {
        $idPrecio = $this->db->select('id_precio')->where('id', $id)->get('usuarios')->row('id_precio');
        return $this->db->select('costo')->where('id', $idPrecio)->get('precios')->row('costo');
    }

    public function getComprasInRangeByIdUser($fecha_i, $fecha_f, $idusuario)
    {
        return $this->db->select('*')->where('id_usuario', $idusuario)->where('dia_comprado >=', $fecha_i)->where('dia_comprado <=', $fecha_f)->get('log_compra')->result();
    }

    public function removeCompra($idcompra, $idusuario)
    {
        $idPrecio = $this->db->select('id_precio')->where('id', $idusuario)->get('usuarios')->row('id_precio');
        $costoVianda = $this->db->select('costo')->where('id', $idPrecio)->get('precios')->row('costo');
        $saldo = $this->db->select('saldo')->where('id', $idusuario)->get('usuarios')->row('saldo');
        $saldo = $saldo + $costoVianda;

        $this->db->set('saldo', $saldo)->where('id', $idusuario)->update('usuarios');
        $this->db->delete('log_compra', array('id' => $idcompra));
    }
}
