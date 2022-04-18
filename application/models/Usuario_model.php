<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getUserById($id)
    {
        return $this->db->select('*')->where('id_usuario', $id)->get('usuario')->row();
    }

    public function getLastNameByDocumento($documento)
    {
        return $this->db->select('apellido')->where('documento', $documento)->get('usuario')->row('apellido');
    }

    public function getFirstNameByDocumento($documento)
    {
        return $this->db->select('nombre')->where('documento', $documento)->get('usuario')->row('nombre');
    }

    public function getIdByDocumento($documento)
    {
        return $this->db->select('id_usuario')->where('documento', $documento)->get('usuario')->row('id_usuario');
    }

    public function getPasswordById($id)
    {
        return $this->db->select('pass')->where('id_usuario', $id)->get('usuario')->row('pass');
    }

    public function getSaldoById($id)
    {
        return $this->db->select('saldo')->where('id_usuario', $id)->get('usuario')->row('saldo');
    }

    public function updatePassword($password)
    {
        $data = [
            'pass' => md5($password)
        ];

        $this->db->where('id_usuario', $this->session->userdata('id_usuario'));
        $this->db->update('usuario', $data);
        return true;
    }

    public function validateUser($documento, $password)
    {
        $this->db->where('documento', $documento);
        $this->db->where('pass', $password);
        return $this->db->get('usuario')->row();
    }

    public function getHistorialByIdUser($id)
    {
        return $this->db->select('*')->where('id_usuario', $id)->limit(15)->order_by('dia_comprado', 'DESC')->get('log_compra')->result();
    }
}
