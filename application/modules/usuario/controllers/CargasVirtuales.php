<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CargaVirtual extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('usuario_model');
        $this->load->model('cargavirtuales_model');

        if (!$this->session->userdata('is_user')) {
            if ($this->session->userdata('is_admin')) {
                redirect(base_url('logout'));
            }
            redirect(base_url('login'));
        }
    }


    public function ultimosMovimientos()
    {
        $data['titulo'] = 'Ultimos movimientos';

        $id_usuario = $this->session->userdata('id_usuario');
        $limit_por_pagina = 10;
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $total_records = count($this->usuario_model->getTransaccionesByIdUser($id_usuario));
        $start_index = floor($start_index / 10) * 10;


        $data['ultimo'] = floor($total_records / $limit_por_pagina) * 10;

        $data['compras'] = $this->usuario_model->getTransaccinesInRangeByIDUser($limit_por_pagina, $start_index, $id_usuario);
        //Esta parte arma los botones de la paginacion
        if ($start_index == 0) {
            //Si el id es 0, estamos en la primera pagina, y lo seteamos
            $data['primera'] = 1;
        } elseif ($start_index <= 10) {
            $links[] = [
                'id' => 0,
                'num' => floor($start_index / 10)
            ];
        } elseif ($start_index > 10) {
            $links[] = [
                'id' => $start_index - 10,
                'num' => floor($start_index / 10)
            ];
        }

        $links[] = [
            'id' => $start_index,
            'num' => floor($start_index / 10) + 1,
            'act' => 'active'
        ];

        if ($start_index + 10 <= $total_records) {
            $links[] = [
                'id' => $start_index + 10,
                'num' => floor($start_index / 10) + 2
            ];
        } else {
            $data['ultima'] = 1;
        }
        if ($total_records > $limit_por_pagina) {
            $data['links'] = $links;
        }

        $this->load->view('header', $data);
        $this->load->view('historial', $data);
        $this->load->view('general/footer');
    }
}