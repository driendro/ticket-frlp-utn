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
                        'rules' => 'trim|max_length[50]|alpha_numeric_spaces|required',
                        'errors' => [
                            'max_length' => 'El %s debe contener como maximo 50 caracteres',
                            'required' => 'Debe ingresar un %s',
                            'alpha_numeric_spaces' => 'Solo se aceptan letras en el %s',
                        ]
                    ],
                    [
                        'field' => 'apellido',
                        'label' => 'Apellido',
                        'rules' => 'trim|max_length[50]|alpha_numeric_spaces|required',
                        'errors' => [
                            'max_length' => 'El %s debe contener como maximo 50 caracteres',
                            'required' => 'Debe ingresar un %s',
                            'alpha_numeric_spaces' => 'Solo se aceptan letras en el %s',
                        ]
                    ],
                    [
                        'field' => 'documento',
                        'label' => 'Documento',
                        'rules' => 'trim|max_length[8]|numeric|required',
                        'errors' => [
                            'max_length' => 'El %s debe contener como maximo 8 digitos',
                            'required' => 'Debe ingresar un %s',
                            'numeric' => 'Solo se aceptan numeros %s',
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

                    $password = $this->input->post('documento');

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

    public function cargar_archivo_csv()
    {
        $data['uploadSuccess'] = array();
        $data['titulo'] = 'Carga CSV';

        if ($this->input->method() == 'post') {
            $mi_archivo = 'archivo_csv';
            $separador = $this->input->post('separador');
            $config['upload_path'] = "uploads";
            $config['file_name'] = "carga";
            $config['overwrite'] = TRUE;
            $config['allowed_types'] = "csv";
            $config['max_size'] = "50000";
            $config['max_width'] = "2000";
            $config['max_height'] = "2000";

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload($mi_archivo)) {
                //*** ocurrio un error
                $data['subidoError'] = $this->upload->display_errors();
                $this->load->view('header', $data);
                $this->load->view('carga_csv', $data);
                $this->load->view('general/footer');
            } else {
                $data['subidoCorrecto'] = $this->upload->data();
                $file = fopen('uploads/carga.csv', 'r');
                $head = fgetcsv($file, 0, $separador);
                while ((!feof($file)) && ($file != '')) {
                    $cargas[] = fgetcsv($file, 0, $separador);
                }
                fclose($file);

                $data['cargas'] = $cargas;

                $this->load->view('header', $data);
                $this->load->view('carga_csv', $data);
                $this->load->view('general/footer');
            }
        } else {
            $this->load->view('header', $data);
            $this->load->view('carga_csv', $data);
            $this->load->view('general/footer');
        }
    }

    public function confirmarCargasCVS()
    {
        if ($this->input->method() == 'post') {
            $i = 0;
            while ($this->input->post("documento_{$i}")) {
                $documento = $this->input->post("documento_{$i}");
                $monto = $this->input->post("monto_{$i}");
                $nombre = $this->input->post("nombre_{$i}");
                $apellido = $this->input->post("apellido_{$i}");
                $tipo = $this->input->post("tipo_{$i}");

                if ($this->usuario_model->getUserByDocumento($documento)) {
                    $usuario = $this->usuario_model->getUserByDocumento($documento); //obtengo el user de ese dni
                    $iduser = $usuario->id; //obtengo el id del user
                    $this->usuario_model->updateSaldoByUserId($iduser, $monto); // modifico el salodo del usuario
                    //Genero la carga en la tabla carga_saldo como log
                    $cargaLog = [
                        'fecha' => date('Y-m-d', time()),
                        'hora' => date('H:i:s', time()),
                        'id_usuario' => $iduser,
                        'monto' => $monto,
                        'id_vendedor' => $this->session->id_vendedor,
                        'formato' => $tipo
                    ];
                    $this->carga_model->addCargaLog($cargaLog);
                    // Correo
                    $cargas = $this->vendedor_model->getCargaByIdvendedorParaEmail($this->session->id_vendedor);

                    foreach ($cargas as $a) {
                        //Solo tomo datos del primer elemento, que es la ultima carga del vendedor
                        $data['fecha'] = date('d-m-Y', strtotime($a->fecha));
                        $data['hora'] = $a->hora;
                        $data['documento'] = $a->documento;
                        $data['apellido'] = $a->apellido;
                        $data['nombre'] = $a->nombre;
                        $data['monto'] = $a->monto;
                        $data['saldo'] = $a->saldo;
                        $data['tipo'] = $a->formato;
                        $correo = $a->mail;
                    }

                    //Confeccion del correo del recibo
                    $subject = "Carga de Saldo";
                    $message = $this->load->view('general/correos/carga_saldo', $data, true);
                    $this->generalticket->smtpSendEmail($correo, $subject, $message);
                } else {
                    $errores[] = array(
                        $documento,
                        $nombre,
                        $apellido,
                        $monto
                    );
                }
                $i++;
            }
            if (isset($errores)) {
                $data['errores'] = $errores;
            } else {
                $data['correcto'] = True;
            }
            $data['titulo'] = 'Carga CSV';
            $this->load->view('header', $data);
            $this->load->view('carga_csv', $data);
            $this->load->view('general/footer');
        } else {
            redirect(base_url('admin/csv_carga'));
        }
    }
}