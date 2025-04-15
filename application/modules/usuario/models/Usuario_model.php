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
        /*Usado en:
        changePassword
        */
        $this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get('usuarios');
        return $query->row();
    }

    public function updatePassword($id_user, $password)
    {
        /*Usado en:
        changePassword
        */

        $this->db->set('pass', $password);
        $this->db->where('id', $id_user);
        $this->db->update('usuarios');
        return true;
    }

    public function getTransaccionesByIdUser($id)
    {
        /*Usado en:
        ultimosMovimientos
        */
        $this->db->select('*');
        $this->db->where('id_usuario', $id);
        $this->db->order_by('fecha', 'DESC');
        $query = $this->db->get('transacciones');
        return $query->result();
    }

    public function getTransaccinesInRangeByIDUser($limit, $start, $id_user)
    {
        /*Usado en:
        ultimosMovimientos
        */
        $this->db->select('*');
        $this->db->where('id_usuario', $id_user);
        $this->db->limit($limit, $start);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get("transacciones");

        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    public function createCargaVirtual($data)
    {
        $this->db->insert('cargasvirtuales', $data);
        return True;
    }

    public function getLinkByUserType($tipo_usuario) 
    {
        $this->db->select('*');
        $this->db->where('tipo_user', $tipo_usuario);
        $query = $this->db->get("linkpagos");
        return $query->result();
    }

    public function getLinkByID($id)
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get('linkpagos');
        return $query->row();
    }

    public function getCargasVirtualesByUserID($id_user)
    {
        $this->db->select('*');
        $this->db->where('usuario', $id_user);
        $this->db->where('estado', 'revision');
        $query = $this->db->get('cargasvirtuales');
        return $query->result();
    }
}