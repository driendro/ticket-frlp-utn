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


/*
    public function getUserById($id)
    {
        return $this->db->select('*')->where('id', $id)->get('usuarios')->row();
    }

    public function getUserByLegajo($legajo)
    {
        return $this->db->select('*')->where('legajo', $legajo)->get('usuarios')->row();
    }

    public function getLastNameByDocumento($documento)
    {
        return $this->db->select('apellido')->where('documento', $documento)->get('usuarios')->row('apellido');
    }

    public function getFirstNameByDocumento($documento)
    {
        return $this->db->select('nombre')->where('documento', $documento)->get('usuarios')->row('nombre');
    }

    public function getIdByDocumento($documento)
    {
        return $this->db->select('id')->where('documento', $documento)->get('usuarios')->row('id');
    }

    public function getPasswordById($id)
    {
        return $this->db->select('pass')->where('id', $id)->get('usuarios')->row('pass');
    }

    public function getSaldoById($id)
    {
        return $this->db->select('saldo')->where('id', $id)->get('usuarios')->row('saldo');
    }

    public function updateSaldoByUserId($iduser, $saldo)
    {
        $saldoActual = $this->db->select('saldo')->where('id', $iduser)->get('usuarios')->row('saldo');
        $saldoNuevo = $saldoActual + $saldo;

        $this->db->set('saldo', $saldoNuevo)->where('id', $iduser)->update('usuarios');
    }

    public function updatePassword($password)
    {
        $data = [
            'pass' => md5($password)
        ];

        $this->db->where('id', $this->session->userdata('id_usuario'));
        $this->db->update('usuarios', $data);
        return true;
    }

    public function updatePasswordById($password, $iduser)
    {
        $data = [
            'pass' => md5($password)
        ];

        $this->db->where('id', $iduser);
        $this->db->update('usuarios', $data);
        return true;
    }

    public function deleteRecoverylogById($id)
    {
        $this->db->delete('passrecovery', ['id' => $id]);
        return true;
    }

    public function updateUserById($iduser, $data)
    {
        $this->db->where('id', $iduser)->update('usuarios', $data);
        return true;
    }

    public function getRecoveryByToken($token)
    {
        $this->db->select('*');
        $this->db->where('token', $token);
        return $this->db->get('passrecovery')->row();
    }

    public function getTransaccionesByIdUser($id)
    {
        $this->db->select('*');
        $this->db->where('id_usuario', $id);
        $this->db->order_by('fecha', 'DESC');
        $query = $this->db->get('transacciones');
        return $query->result();
    }

    public function getHistorial()
    {
        return $this->db->select('*')->order_by('dia_comprado', 'DESC')->get('compra')->result();
    }

    public function addLogPassrecovery($data)
    {
        $this->db->insert('log_passrecovery', $data);
        $this->db->insert('passrecovery', $data);

        return true;
    }

    public function getRecoveryByToken($token)
    {
        $this->db->select('*');
        $this->db->where('token', $token);
        return $this->db->get('passrecovery')->row();
    }

    public function addNewUser($data, $data_log)
    {
        $this->db->insert('usuarios', $data);
        $data_log['id_usuario'] = $this->db->select('id')->where('documento', $data['documento'])->get('usuarios')->row('id');
        $this->db->insert('log_alta_usuarios', $data_log);
        return true;
    }

    public function getTransaccinesInRangeByIDUser($limit, $start, $id_user)
    {
        $this->db->select('*');
        $this->db->where('id_usuario', $id_user);
        $this->db->limit($limit, $start);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get("transacciones");

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    */