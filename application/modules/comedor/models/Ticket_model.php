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
        if ($this->db->insert('compra', $data)) {
            return true;
        } else {
            false;
        }
    }

    public function addLogCompra($data)
    {
        if ($this->db->insert('log_compra', $data)) {
            return true;
        } else {
            return false;
        }
    }

    public function updateSaldoByIDUser($id_user, $saldo_nuevo)
    {
        $this->db->set('saldo', $saldo_nuevo);
        $this->db->where('id', $id_user);
        if ($this->db->update('usuarios')) {
            return true;
        } else {
            return false;
        }
    }

    public function getCostoById($id)
    {
        $idPrecio = $this->db->select('id_precio')->where('id', $id)->get('usuarios')->row('id_precio');
        return $this->db->select('costo')->where('id', $idPrecio)->get('precios')->row('costo');
    }

    public function getCompraById($id)
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get('compra');
        return $query->result();
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
        $this->db->order_by('dia_comprado');
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

    public function getLogComprasByIDTransaccion($id_trans)
    {
        $this->db->select('*');
        $this->db->where('transaccion_id', $id_trans);
        $query = $this->db->get('log_compra');
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

    public function updateTransactionInLogCompraByID($id_compra, $id_trans)
    {
        $this->db->set('transaccion_id', $id_trans);
        $this->db->where('id', $id_compra);
        $this->db->update('log_compra');
    }

    public function updateTransactionInCargaByID($id_carga, $id_trans)
    {
        $this->db->set('transaccion_id', $id_trans);
        $this->db->where('id', $id_carga);
        $this->db->update('log_carga');
    }

    public function removeCompra($idcompra)
    {
        if ($this->db->delete('compra', ['id' => $idcompra])) {
            return true;
        } else {
            return false;
        }
    }
}