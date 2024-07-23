<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Repartidor extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('repartidor_model');
    }

    public function buscar_compra_por_fecha_user()
    {
        $id_vendedor = $this->session->userdata('id_vendedor');
        $admin = $this->repartidor_model->getAdminById($id_vendedor);
        $data['titulo']='Entrega de Viandas';
        if ($admin->nivel == 2) {
            if ($this->input->method() == 'post') {
                $documento = $this->input->post('numeroDni');
                $fecha = date('Y-m-d', time());
                if ($usuario = $this->repartidor_model->getUserByDocumento($documento)){
                    $compra = $this->repartidor_model->getComprasByFechaAndUser($fecha,$usuario->id);
                    $repartidor = $this->repartidor_model->getAdminById($compra->id_repartidor);
                } else {
                    $usuario=False;
                    $compra=False;
                }
                $data['usuario'] = $usuario;
                $data['compra'] = $compra;
                $data['repartidor'] = $repartidor;
                $this->load->view('header', $data);
                $this->load->view('index', $data);
                $this->load->view('general/footer');
            } else {
                redirect(base_url('admin'));
            }

        } else {
            redirect(base_url('usuario'));
        }
    }

    public function entregar_compra_by_id()
    {
        $id_vendedor = $this->session->userdata('id_vendedor');
        $admin = $this->repartidor_model->getAdminById($id_vendedor);
        $data['titulo']='Entrega de Viandas';
        if ($admin->nivel == 2) {
            if ($this->input->method() == 'post') {
                $id_compra = $this->input->post('idCompra');
                $compra = $this->repartidor_model->getComprasByID($id_compra);
                $usuario = $this->repartidor_model->getUserByID($compra->id_usuario);
                $this->repartidor_model->updateCompraByID($id_compra, $id_vendedor);
                $compra = $this->repartidor_model->getComprasByID($id_compra);
                $repartidor = $this->repartidor_model->getAdminById($compra->id_repartidor);
                $data['usuario'] = $usuario;
                $data['repartidor'] = $repartidor;
                $data['compra'] = $compra;
                $this->load->view('header', $data);
                $this->load->view('index', $data);
                $this->load->view('general/footer');
            } else {
                redirect(base_url('admin'));
            }
        } else {
            redirect(base_url('usuario'));
        }
    }

    public function entregar_vianda()
    {
       $id_vendedor = $this->session->userdata('id_vendedor');
        $admin = $this->repartidor_model->getAdminById($id_vendedor);
        if ($admin->nivel == 2) {

        } else {
            redirect(base_url('usuario'));
        }
    }
}