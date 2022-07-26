<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuario extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('usuario_model');
        $this->load->model('comedor/feriado_model');
        $this->load->model('comedor/ticket_model');

        if (!$this->session->userdata('is_user')) {
            if ($this->session->userdata('is_admin')) {
                redirect(base_url('logout'));
            }
            redirect(base_url('login'));
        }
    }

    public function estadoComedor()
    {
        //Con esta funcion se verifica si el comedor se encuentra cerrado, definiendo los periodos
        //entre la fecha de apertura y cierre, y las vacaciones de invierno
        $hoy = date('Y-m-d', time());
        $apertura = $this->config->item('apertura');
        $vaca_ini = $this->config->item('vacaciones_i');
        $vaca_fin = $this->config->item('vacaciones_f');
        $cierre = $this->config->item('cierre');

        if ($hoy >= $apertura && $hoy <= $vaca_ini) {
            //Primer semestre
            return true;
        } elseif ($hoy >= $vaca_fin && $hoy <= $cierre) {
            //Segundo semestre
            return true;
        }
    }

    public function estadoCompra()
    {
        //Con esta funcion se verifica si el comedor habilitado para usarse, definindo los periodos
        // de compra entre el lunes y el jueves
        $hoy = date('N');
        $ahora = date('H:i:s', time());
        $dia_ini = $this->config->item('dia_inicial');
        $dia_fin = $this->config->item('dia_final');
        $hora_fin = $this->config->item('hora_final');

        if ($hoy >= $dia_ini && $hoy < $dia_fin) {
            //Si hoy esta entre el lunes y el jueves
            return true;
        } elseif ($hoy == $dia_fin && $ahora <= $hora_fin) {
            //y si es viernes hasta las 12:00AM
            return true;
        }
    }

    public function changePassword()
    {
        $data = [
            'titulo' => 'Cambio de contraseña'
        ];

        if ($this->input->method() == 'post') {
            $rules = [
                [
                    'field' => 'password_anterior',
                    'label' => 'Contraseña',
                    'rules' => 'trim|required',
                    'errors' => [
                        'required' => 'Debe ingresar su %s actual.'
                    ]
                ],
                [
                    'field' => 'password_nuevo',
                    'label' => 'Contraseña Nueva',
                    'rules' => 'trim|required',
                    'errors' => [
                        'required' => 'Debe ingresar una %s.'
                    ]
                ],
                [
                    'field' => 'password_confirmado',
                    'label' => 'Contraseña',
                    'rules' => 'trim|matches[password_nuevo]',
                    'errors' => [
                        'matches' => 'Las contraseñas no coinciden.'
                    ]
                ]
            ];
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('header', $data);
                $this->load->view('change_password', $data);
                $this->load->view('general/footer');
            } else {
                $password_anterior = $this->input->post('password_anterior');
                $password_nuevo = $this->input->post('password_nuevo');
                $password_confirmado = $this->input->post('password_confirmado');
                $password = $this->usuario_model->getPasswordById(
                    $this->session->userdata('id_usuario')
                );
                if ($password == md5($password_anterior)) {
                    if ($password_nuevo == $password_confirmado) {
                        if ($this->usuario_model->updatePassword($password_nuevo)) {
                            redirect(base_url('logout'));
                        }
                    }
                } else {
                    redirect(base_url('usuario/cambio-password'));
                }
            }
        } else {
            $this->load->view('header', $data);
            $this->load->view('change_password');
            $this->load->view('general/footer');
        }
    }

    public function ultimosMovimientos()
    {
        $data['titulo'] = 'Ultimos movimientos';

        $id_usuario = $this->session->userdata('id_usuario');
        $id_usuario = 9;
        $limit_por_pagina = 10;
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $total_records = count($this->usuario_model->getTransaccionesByIdUser($id_usuario));

        $data['ultimo'] = floor($total_records / $limit_por_pagina) * 10;

        $data['compras'] = $this->usuario_model->getTransaccinesInRangeByIDUser($limit_por_pagina, $start_index, $id_usuario);
        if ($start_index == 0) {
            $data['primera'] = 1;
            $links[] = [
                'id' => 0,
                'num' => 1,
                'act' => 'active'
            ];
            $links[] = [
                'id' => 10,
                'num' => 2
            ];
            $links[] = [
                'id' => 20,
                'num' => 3
            ];
        } else {
            $links[] = [
                'id' => $start_index - 10,
                'num' => floor($start_index / 10)
            ];
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
        }
        $data['links'] = $links;

        $this->load->view('header', $data);
        $this->load->view('historial', $data);
        $this->load->view('general/footer');
    }
}