<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('ticket_model');
        $this->load->model('usuario_model');
        $this->load->model('feriado_model');

        if(!$this->general->isLogged())
        {
            redirect(base_url('login'));
        }

        if(ini_get('date.timezone'))
        {
            date_default_timezone_set('America/Argentina/Buenos_Aires');
        }
    }

    public function index()
    {
		redirect(base_url('usuario'));
	}

    public function datos()
    {
        $totalCompra = $this->input->post('total');

        if($totalCompra > $this->usuario_model->getSaldoById($this->session->userdata('id_usuario')))
        {
            redirect(base_url('menu'));
        }

        for ($i = 0; $i <= 4; $i++)
        {
            $nroDia = date('N');
            $proximo = time() + ((7-$nroDia-$i) * 24 * 60 * 60);
            $proxima_fecha = date('Y-m-d', $proximo);


            $data = [
                'fecha' => date('Y-m-d', time()),
                'hora' => date('H:i:s', time()),
                'dia_comprado' => $proxima_fecha,
                'id_usuario' => $this->session->userdata('id_usuario'),
                'precio' => 180,
                'tipo' => $this->input->post('checkTipo'+$i), // 1, 2, 3, 4, 5
                'turno' => $this->input->post('radioTurno'+$i)
            ];

            if($this->ticket_model->addCompra($data))
            {
                redirect(base_url('usuario'));
            }
            else
            {
                redirect(base_url('usuario'));
            }
        }
    }
}