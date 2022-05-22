<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Administrador extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('vendedor_model');
        $this->load->model('usuario/usuario_model');
        $this->load->model('carga_model');

        if ($this->session->userdata('is_user')) {
            redirect(base_url('usuario'));
        }

        if (!$this->session->userdata('is_admin')) {
            redirect(base_url('admin/login'));
        }
    }

    public function createVendedor()
    {
        $id_vendedor = $this->session->userdata('id_vendedor');
        $admin = $this->vendedor_model->getUserById($id_vendedor);
        if ($admin->nivel == 1) {
            $data['titulo'] = 'Crear nuevo Vendedor';

            if ($this->input->method() == 'post') {
                $rules = [
                    [
                        'field' => 'nickName',
                        'label' => 'Nombre de Usuario',
                        'rules' => "trim|min_length[3]|required|max_length[20]|alpha|is_unique[vendedores.nombre_usuario]",
                        'errors' => [
                            'max_length' => 'El %s debe contener 3 y 20 letras',
                            'min_length' => 'El %s debe contener 3 y 20 letras',
                            'required' => 'Debe ingresar un %s',
                            'alpha' => 'El %s debe contener solo letras',
                            'is_unique' => 'Ese %s ya esta registrado',
                        ]
                    ],
                    [
                        'field' => 'nombre',
                        'label' => 'Nombre',
                        'rules' => 'trim|max_length[50]|alpha|required',
                        'errors' => [
                            'max_length' => 'El %s debe contener como maximo 50 caracteres',
                            'required' => 'Debe ingresar un %s',
                            'alpha' => 'Solo se aceptan letras en el %s',
                        ]
                    ],
                    [
                        'field' => 'apellido',
                        'label' => 'Apellido',
                        'rules' => 'trim|max_length[50]|alpha|required',
                        'errors' => [
                            'max_length' => 'El %s debe contener como maximo 50 caracteres',
                            'required' => 'Debe ingresar un %s',
                            'alpha' => 'Solo se aceptan letras en el %s',
                        ]
                    ],
                    [
                        'field' => 'email',
                        'label' => 'E-Mail',
                        'rules' => "trim|valid_email|required|is_unique[vendedores.mail]",
                        'errors' => [
                            'required' => 'Debe ingresar un %s',
                            'valid_email' => 'No es un %s valido',
                            'is_unique' => 'Ese %s ya esta registrado',
                        ]
                    ],
                ];
                $this->form_validation->set_rules($rules);
                if ($this->form_validation->run() == FALSE) {
                    $this->load->view('header', $data);
                    $this->load->view('crear_vendedor', $data);
                    $this->load->view('general/footer');
                } else {
                    //Crer Password aleatorio de la forma 3letras+3numeros
                    $numeros_permitidos = '0123456789';
                    $letras_permitidas = 'abcdefghijklmnopqrstuvwxyz';
                    $num3 = substr(str_shuffle($numeros_permitidos), 0, 3);
                    $pal3 = substr(str_shuffle($letras_permitidas), 0, 3);
                    $password = "{$pal3}{$num3}";

                    $newUser = [
                        'nombre_usuario' => $this->input->post('nickName'),
                        'pass' => md5($password),
                        'nombre' => ucwords($this->input->post('nombre')),
                        'apellido' => ucwords($this->input->post('apellido')),
                        'mail' => strtolower($this->input->post('email')),
                        'estado' => 1,
                        'nivel' => 0
                    ];

                    if ($this->vendedor_model->addNewVendedor($newUser)) {
                        //Confeccion del correo para el nuevo vendedor
                        $correo = $this->input->post('email');
                        $dataCorreo['apellido'] = $this->input->post('apellido');
                        $dataCorreo['nombre'] = $this->input->post('nombre');
                        $dataCorreo['nickName'] = $this->input->post('nickName');
                        $dataCorreo['lvl'] = 0;
                        $dataCorreo['password'] = $password;

                        $subject = "Bienvenido al Comedor Universitario UTN-FRLP";
                        $message = $this->load->view('general/correos/nuevo_vendedor', $dataCorreo, true);
                        $this->generalticket->smtpSendEmail($correo, $subject, $message);

                        redirect(base_url('admin'));
                    }
                }
            }

            $this->load->view('header', $data);
            $this->load->view('crear_vendedor', $data);
            $this->load->view('general/footer');
        } else {
            redirect(base_url('admin'));
        }
    }
}
