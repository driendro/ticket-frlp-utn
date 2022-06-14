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
        return $this->db->select('*')->where('id_vendedor', $id)->get('vendedores')->row();
    }

    public function getUserByUserName($nickName)
    {
        $this->db->select('*');
        $this->db->where('nombre_usuario', $nickName);
        $query = $this->db->get('vendedores')->row();
        return $query;
    }

    public function getFirstNameByUserName($nickName)
    {
        $this->db->select('nombre');
        $this->db->where('nombre_usuario', $nickName);
        $query = $this->db->get('vendedores')->row('nombre');
        return $query;
    }

    public function getIdByUserName($nickName)
    {
        $this->db->select('id_vendedor');
        $this->db->where('nombre_usuario', $nickName);
        $query = $this->db->get('vendedores')->row('id_vendedor');
        return $query;
    }

    public function getPasswordById($id)
    {
        return $this->db->select('pass')->where('id_vendedor', $id)->get('vendedores')->row('pass');
    }

    public function updatePassword($password)
    {
        $data = [
            'pass' => md5($password)
        ];

        $this->db->where('id_vendedor', $this->session->userdata('id_vendedor'));
        $this->db->update('vendedores', $data);
        return true;
    }

    public function getCargasByIdvendedor($idvendedor)
    {
        $this->db->select('*');
        $this->db->from('log_carga');
        $this->db->join('usuarios', 'log_carga.id_usuario=usuarios.id');
        $this->db->where('id_vendedor', $idvendedor);
        $this->db->limit(20);
        $this->db->order_by('log_carga.id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function getCargasByFechaForPDF($fecha)
    {
        $this->db->select('*');
        $this->db->from('log_carga');
        $this->db->join('vendedores', 'log_carga.id_vendedor=vendedores.id_vendedor');
        $this->db->join('usuarios', 'log_carga.id_usuario=usuarios.id');
        $this->db->order_by('log_carga.id', 'DESC');
        $this->db->where('fecha', $fecha);
        $query = $this->db->get();
        return $query->result();
    }

    public function getComprasByFechaForExls($fecha)
    {
        $this->db->select('*');
        $this->db->from('compra');
        $this->db->join('usuarios', 'compra.id_usuario=usuarios.id');
        $this->db->order_by('usuarios.apellido', 'DESC');
        $this->db->where('dia_comprado', $fecha);
        $query = $this->db->get();
        return $query->result();
    }

    public function validateVendedor($nickName, $password)
    {
        $this->db->where('nombre_usuario', $nickName);
        $this->db->where('pass', $password);
        return $this->db->get('vendedores')->row();
    }

    public function updateMenu($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('menu', $data);
        return true;
    }

    public function getMenu()
    {
        $this->db->select('*');
        $query = $this->db->get('menu');
        return $query->result();
    }

    public function addNewVendedor($data)
    {
        $this->db->insert('vendedores', $data);

        return true;
    }
}