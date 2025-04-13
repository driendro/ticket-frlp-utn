<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CargasVirtuales_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function createCargaV($data)
    {
        $this->db->insert('cargasvirtuales', $data);
    }

    public function getLinkByUserType($tipo_usuario) 
    {
        $this->db->select('*');
        $this->db->where('tipo_user', $tipo_usuario);
        $query = $this->db->get("linkpagos");
        return $query->result();
    }

    // public function getCargaVByID($id)
    // {
    //     /*Usado en:
    //     index
    //     passwordRecoveryRequest
    //     */
    //     $this->db->select('*');
    //     $this->db->where('documento', $documento);
    //     $query = $this->db->get('usuarios');
    //     if (!empty($query)) {
    //         return $query->row();
    //     }
    //     return false;
    // }

    // public function getRecoveryByToken($token)
    // {
    //     /*Usado en:
    //     passwordRecoveryRequest
    //     newPasswordRequest
    //     */
    //     $this->db->select('*');
    //     $this->db->where('token', $token);
    //     return $this->db->get('passrecovery')->row();
    // }

    // public function addLogPassrecovery($data)
    // {
    //     /*Usado en:
    //     passwordRecoveryRequest
    //     */
    //     $this->db->insert('log_passrecovery', $data);
    //     $this->db->insert('passrecovery', $data);

    //     return true;
    // }

    // public function updatePasswordById($password, $iduser)
    // {
    //     /*Usada en:
    //     newPasswordRequest
    //     */
    //     $data = [
    //         'pass' => md5($password)
    //     ];

    //     $this->db->where('id', $iduser);
    //     $this->db->update('usuarios', $data);
    //     return true;
    // }

    // public function deleteRecoverylogById($id)
    // {
    //     /*Usada en:
    //     newPasswordRequest
    //     */
    //     $this->db->delete('passrecovery', ['id' => $id]);
    //     return true;
    // }

}