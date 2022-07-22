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
            if ($this->db->insert('compra', $data)) {
                $this->db->insert('log_compra', $data);
                $saldo = $saldo - $costoVianda;
                return $this->db->insert_id();
            }
            $this->db->set('saldo', $saldo)->where('id', $this->session->userdata('id_usuario'))->update('usuarios');
        } else {
            return false;
        }
    }

    public function getCostoById($id)
    {
        $idPrecio = $this->db->select('id_precio')->where('id', $id)->get('usuarios')->row('id_precio');
        return $this->db->select('costo')->where('id', $idPrecio)->get('precios')->row('costo');
    }

    public function getSaldoByIDUser($id_user)
    {
        $this->db->select('saldo');
        $this->db->where('id', $id_user);
        $query = $this->db->get('usuarios');
        return $query->row('saldo');
    }

    public function getComprasInRangeByIdUser($fecha_i, $fecha_f, $idusuario)
    {
        $this->db->select('*');
        $this->db->where('id_usuario', $idusuario);
        $this->db->where('dia_comprado >=', $fecha_i);
        $this->db->where('dia_comprado <=', $fecha_f);
        $query = $this->db->get('compra');
        return $query->result();
    }

    public function getComprasByIDTransaccion($id_trans)
    {
        $this->db->select('*');
        $this->db->where('transaccion_id', $id_trans);
        $query = $this->db->get('compra');
        return $query->result();
    }

    public function addTransaccion($data)
    {
        $this->db->insert('transacciones', $data);
        return $this->db->insert_id();
    }

    public function updateTransactionInCompraByID($id_compra, $id_trans)
    {
        $this->db->set('transaccion_id', $id_trans);
        $this->db->where('id', $id_compra);
        $this->db->update('compra');
    }

    public function updateTransactionInLogCompraByID($id_compra, $id_trans, $tipo_trans)
    {
        $array = [
            'transaccion_id' => $id_trans,
            'transaccion_tipo' => $tipo_trans
        ];
        $this->db->set($array);
        $this->db->where('id', $id_compra);
        $this->db->update('log_compra');
    }

    public function updateTransactionInCargaByID($id_carga, $id_trans)
    {
        $this->db->set('transaccion_id', $id_trans);
        $this->db->where('id', $id_carga);
        $this->db->update('log_carga');
    }

    public function removeCompra($idcompra, $idusuario)
    {
        $idPrecio = $this->db->select('id_precio')->where('id', $idusuario)->get('usuarios')->row('id_precio');
        $costoVianda = $this->db->select('costo')->where('id', $idPrecio)->get('precios')->row('costo');
        $saldo = $this->db->select('saldo')->where('id', $idusuario)->get('usuarios')->row('saldo');
        $saldo = $saldo + $costoVianda;

        $this->db->set('saldo', $saldo)->where('id', $idusuario)->update('usuarios');
        $this->db->delete('compra', array('id' => $idcompra));
    }
}