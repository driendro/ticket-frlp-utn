<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Feriado_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getFeriado()
    {
        return $this->db->select('*')->get('feriado')->result();
    }

    public function getListFechasInRange($fecha_i, $fecha_f)
    {
        return $this->db->select('fecha')->where('fecha >=', $fecha_i)->where('fecha <=', $fecha_f)->get('feriado')->result();
    }

    public function getDetalle($fecha) //Y-m-d
    {
        return $this->db->select('detalle')->where('fecha', $fecha)->get('feriado')->row('detalle');
    }

    public function getFeriadosInRange($fecha_i, $fecha_f)
    {
        return $this->db->select('*')->where('fecha >=', $fecha_i)->where('fecha <=', $fecha_f)->get('feriado')->result();
    }
}
