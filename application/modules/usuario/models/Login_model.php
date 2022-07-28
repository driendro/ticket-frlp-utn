<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function validateUser($documento, $password)
    {
        /*Usado en:
        index
        */
        $this->db->where('documento', $documento);
        $this->db->where('pass', $password);
        $query = $this->db->get('usuarios');
        if (!empty($query->row())) {
            return true;
        }
        return false;
    }

    public function getUserByDocumento($documento)
    {
        /*Usado en:
        index
        passwordRecoveryRequest
        */
        $this->db->select('*');
        $this->db->where('documento', $documento);
        $query = $this->db->get('usuarios');
        if (!empty($query)) {
            return $query->row();
        }
        return false;
    }

    public function getRecoveryByToken($token)
    {
        /*Usado en:
        passwordRecoveryRequest
        newPasswordRequest
        */
        $this->db->select('*');
        $this->db->where('token', $token);
        return $this->db->get('passrecovery')->row();
    }

    public function addLogPassrecovery($data)
    {
        /*Usado en:
        passwordRecoveryRequest
        */
        $this->db->insert('log_passrecovery', $data);
        $this->db->insert('passrecovery', $data);

        return true;
    }

    public function updatePasswordById($password, $iduser)
    {
        /*Usada en:
        newPasswordRequest
        */
        $data = [
            'pass' => md5($password)
        ];

        $this->db->where('id', $iduser);
        $this->db->update('usuarios', $data);
        return true;
    }

    public function deleteRecoverylogById($id)
    {
        /*Usada en:
        newPasswordRequest
        */
        $this->db->delete('passrecovery', ['id' => $id]);
        return true;
    }
}