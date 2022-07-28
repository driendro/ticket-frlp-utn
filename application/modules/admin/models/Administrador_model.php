<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Administrador_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAdminById($id)
    {
        /*Usado en:
        createVendedor
        */
        $this->db->select('*');
        $this->db->where('id_vendedor', $id);
        $query = $this->db->get('vendedores');
        return $query->row();
    }

    public function addNewVendedor($data)
    {
        /*Usado en:
        createVendedor
        */
        $this->db->insert('vendedores', $data);

        return true;
    }

    public function getCargaByIdvendedorForEmailCSV($idvendedor)
    {
        /*Usado en:
        confirmarCargasCVS
        */
        $this->db->select('*');
        $this->db->from('log_carga');
        $this->db->join('usuarios', 'log_carga.id_usuario=usuarios.id');
        $this->db->where('id_vendedor', $idvendedor);
        $this->db->order_by('log_carga.id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }

    public function addCargaLog($data)
    {
        /*Usado en:
        confirmarCargasCVS
        */
        $this->db->insert('log_carga', $data);
        return true;
    }

    public function addTransaccion($data)
    {
        /* Usdo en:
        confirmarCargasCVS
        */
        $this->db->insert('transacciones', $data);
        return $this->db->insert_id();
    }

    public function updateAndGetSaldoByUserId($iduser, $saldo)
    {
        /*Usado en:
        confirmarCargasCVS
        */
        $saldoActual = $this->db->select('saldo')->where('id', $iduser)->get('usuarios')->row('saldo');
        $saldoNuevo = $saldoActual + $saldo;

        $this->db->set('saldo', $saldoNuevo);
        $this->db->where('id', $iduser);
        $this->db->update('usuarios');
        return $saldoNuevo;
    }


    public function getUserByDocumento($documento)
    {
        /*Usado en:
        confirmarCargasCVS
        */
        $this->db->select('*');
        $this->db->where('documento', $documento);
        $query = $this->db->get('usuarios');
        return $query->row();
    }
}