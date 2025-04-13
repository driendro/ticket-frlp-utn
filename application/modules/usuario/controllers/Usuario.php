<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuario extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('usuario_model');

        if (!$this->session->userdata('is_user')) {
            if ($this->session->userdata('is_admin')) {
                redirect(base_url('logout'));
            }
            redirect(base_url('login'));
        }
    }

    public function changePassword()
    {
        $data = [
            'titulo' => 'Cambio de contraseña'
        ];
        $id_user = $this->session->userdata('id_usuario');
        $usuario = $this->usuario_model->getUserByID($id_user);
        $data['usuario'] = $usuario;

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
                $password = $usuario->pass;
                if ($password == md5($password_anterior)) {
                    if ($this->usuario_model->updatePassword($id_user, md5($password_nuevo))) {
                        $this->session->set_flashdata(
                            'success',
                            'Contraseña actualizada correctamente'
                        );
                        redirect(base_url('usuario/cambio-password'));
                    }
                } else {
                    $this->session->set_flashdata(
                        'error',
                        'Contraseña incorrecta'
                    );
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

    public function botones_de_pago()
    {
        $data = [
            'titulo' => 'Carga por Link de pago'
        ];
        $id_user = $this->session->userdata('id_usuario');
        $usuario = $this->usuario_model->getUserByID($id_user);
        $data['usuario'] = $usuario;
        $data['saldo'] = $usuario->saldo;
        $data['monto_acreditar'] = 2000;
        $data['links'] = $this->usuario_model->getLinkByUserType($usuario->tipo);

        $this->load->view('header', $data);
        $this->load->view('bonotes_pago', $data);
        $this->load->view('general/footer');
    }

    public function add_carga_virtual()
    {
        $id_user = $this->session->userdata('id_usuario');
        $usuario = $this->usuario_model->getUserByID($id_user);
        if ($this->input->method() == 'post') {
            $id_link = $this->input->post('id_link');
            $link_pago = $this->usuario_model->getLinkByID($id_link)
            $link_mp = 
        } else {
            $this->load->view('header', $data);
            $this->load->view('bonotes_pago', $data);
            $this->load->view('general/footer');
        }

        $data['usuario'] = $usuario;
        $data['saldo'] = $usuario->saldo;
        $data['monto_acreditar'] = 2000;
        $data['links'] = $this->usuario_model->getLinkByUserType($usuario->tipo);

    }

}