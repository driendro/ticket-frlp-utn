<?php
defined('BASEPATH') or exit('No direct script access allowed');

use    PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;

class Vendedor extends CI_Controller
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

    public function index()
    {
        $data = [
            'titulo' => 'Carga de Saldo'
        ];
        if ($this->input->method() == 'post') {
            $documento = $this->input->post('numeroDni');
            $usuario = $this->usuario_model->getUserByDocumento($documento);
            if ($usuario) {
                $data['usuario'] = $usuario;
                //Seteo el numero de documento como variable de sesion
                $this->session->set_flashdata('documento', $documento);
            } else {
                $data['usuario'] = FALSE;
            }

            $this->load->view('header', $data);
            $this->load->view('index', $data);
            $this->load->view('general/footer');
        } else {
            $this->load->view('header', $data);
            $this->load->view('index');
            $this->load->view('general/footer');
        }
    }

    public function correoCargaSaldo($id_vendedor)
    {
        $cargas = $this->vendedor_model->getCargasByIdvendedor($id_vendedor);

        $i = 1;
        foreach ($cargas as $a) {
            if ($i == 1) {
                //Solo tomo datos del primer elemento, que es la ultima carga del vendedor
                $data['codigo'] = $a->id;
                $data['fecha'] = date('d-m-Y', strtotime($a->fecha));
                $data['hora'] = $a->hora;
                $data['documento'] = $a->documento;
                $data['apellido'] = $a->apellido;
                $data['nombre'] = $a->nombre;
                $data['monto'] = $a->monto;
                $data['saldo'] = $a->saldo;
                $correo = $a->mail;
                $i = $i + 1;
            }
        }

        //Confeccion del correo del recibo
        $subject = "Carga de Saldo";
        $message = $this->load->view('general/correos/carga_saldo', $data, true);
        $this->generalticket->smtpSendEmail($correo, $subject, $message);

        return true;
    }

    public function cargarSaldo()
    {
        if ($this->input->method() == 'post') {
            $documento = $this->input->post('dni'); //obtengo el numero de documento
            $carga = $this->input->post('carga'); // obtengo el monto a cargar$data = [
            $data['titulo'] = 'Carga de Saldo';
            $data['usuario'] = $this->usuario_model->getUserByDocumento($documento);
            // Contro la validez del formulario
            $rules = [
                [
                    'field' => 'carga',
                    'label' => 'Saldo a Cargar',
                    'rules' => 'trim|required|differs[0]|max_length[4]',
                    'errors' => [
                        'required' => 'Debe ingresar un monto a cargar',
                        'differs' => 'El monto debe ser distinto de 0 (cero)',
                        'max_length' => 'El monto a cargar no debe superar los $9999'
                    ]
                ],
            ];
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('header', $data);
                $this->load->view('index', $data);
                $this->load->view('general/footer');
            } else {
                $usuario = $this->usuario_model->getUserByDocumento($documento); //obtengo el user de ese dni
                $iduser = $usuario->id; //obtengo el id del user
                $this->usuario_model->updateSaldoByUserId($iduser, $carga); // modifico el salodo del usuario

                //Genero la carga en la tabla carga_saldo como log
                $cargaLog = [
                    'fecha' => date('Y-m-d', time()),
                    'hora' => date('H:i:s', time()),
                    'id_usuario' => $iduser,
                    'monto' => $carga,
                    'id_vendedor' => $this->session->id_vendedor
                ];
                $this->carga_model->addCargaLog($cargaLog);
                $this->correoCargaSaldo($this->session->id_vendedor);

                redirect(base_url('admin'));
            }
        } else {
            redirect(base_url('admin'));
        }
    }

    public function createUser()
    {
        $data = [
            'titulo' => 'Nuevo Usuario'
        ];

        // Verifico si se carga informacion en el formulario
        if ($this->input->method() == 'post') {
            // Si el methodo es POST, obtengo el dni y el legajo
            // Verifico la informcion del formulario
            $rules = [
                [
                    'field' => 'saldo',
                    'label' => 'Saldo a Ingresar',
                    'rules' => 'trim|max_length[4]',
                    'errors' => [
                        'max_length' => 'El monto a cargar no debe superar los $9999'
                    ]
                ],
                [
                    'field' => 'legajo',
                    'label' => 'Legajo',
                    'rules' => 'trim|min_length[5]|required|max_length[6]|numeric|integer|is_unique[usuarios.legajo]',
                    'errors' => [
                        'max_length' => 'El %s debe contener entre 5 y 6 digitos',
                        'min_length' => 'El %s debe contener entre 5 y 6 digitos',
                        'required' => 'Debe ingresar un %s',
                        'numeric' => 'El %s debe ser un numero',
                        'integer' => 'El %s debe ser un entero',
                        'is_unique' => 'Ese %s ya esta registrado',
                    ]
                ],
                [
                    'field' => 'dni',
                    'label' => 'Documento',
                    'rules' => 'trim|max_length[8]|numeric|required|integer|is_unique[usuarios.documento]',
                    'errors' => [
                        'required' => 'Debe ingresar un %s',
                        'max_length' => 'El %s debe contener 5 numeros como maximo',
                        'numeric' => 'El %s debe ser un numero',
                        'integer' => 'El %s debe ser un entero',
                        'is_unique' => 'Ese %s ya esta registrado',
                    ]
                ],
                [
                    'field' => 'nombre',
                    'label' => 'Nombre',
                    'rules' => 'trim|max_length[50]|required',
                    'errors' => [
                        'max_length' => 'El %s debe contener como maximo 50 caracteres',
                        'required' => 'Debe ingresar un %s',
                    ]
                ],
                [
                    'field' => 'apellido',
                    'label' => 'Apellido',
                    'rules' => 'trim|max_length[50]|required',
                    'errors' => [
                        'max_length' => 'El %s debe contener como maximo 50 caracteres',
                        'required' => 'Debe ingresar un %s',
                    ]
                ],
                [
                    'field' => 'claustro',
                    'label' => 'Claustro',
                    'rules' => 'trim|in_list[Estudiante,Docente,No Docente]|required',
                    'errors' => [
                        'required' => 'Debe elegir un %s',
                        'in_list' => 'No es un %s valido',
                    ]
                ],
                [
                    'field' => 'email',
                    'label' => 'E-Mail',
                    'rules' => 'trim|valid_email|required|is_unique[usuarios.mail]',
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
                $this->load->view('crear_usuario', $data);
                $this->load->view('general/footer');
            } else {
                $numerodni = $this->input->post('dni');
                $legajo = $this->input->post('legajo');

                //Crer Password aleatorio de la forma 3letras+3numeros
                $numeros_permitidos = '0123456789';
                $letras_permitidas = 'abcdefghijklmnopqrstuvwxyz';
                $num3 = substr(str_shuffle($numeros_permitidos), 0, 3);
                $pal3 = substr(str_shuffle($letras_permitidas), 0, 3);
                $password = "{$pal3}{$num3}";

                //Asigno el costo de la vianda segun el tipo de usuario
                //1-Estudiante || 2-Becado || 3-Docente || 4-No Docente
                if ($this->input->post('beca') == 'Si') {
                    $idPrecio = 2;
                } else {
                    if ($this->input->post('claustro') == 'Estudiante') {
                        $idPrecio = 1;
                    } elseif ($this->input->post('claustro') == 'No Docente') {
                        $idPrecio = 4;
                    } elseif ($this->input->post('claustro') == 'Docente') {
                        $idPrecio = 3;
                    }
                };
                // Si la especialidad esta vacia, la guardo como null
                if ($this->input->post('especialidad') == "") {
                    $especialidad = null;
                } else {
                    $especialidad = $this->input->post('especialidad');
                }

                $newUser = [
                    'tipo' => $this->input->post('claustro'),
                    'legajo' => $legajo,
                    'documento' => $numerodni,
                    'pass' => md5($password),
                    'nombre' => ucwords($this->input->post('nombre')),
                    'apellido' => ucwords($this->input->post('apellido')),
                    'especialidad' => $especialidad,
                    'mail' => strtolower($this->input->post('email')),
                    'saldo' => $this->input->post('saldo'),
                    'estado' => 1,
                    'id_precio' => $idPrecio
                ];
                if ($this->usuario_model->addNewUser($newUser)) {
                    // realizamos la carga de saldo
                    $usuario = $this->usuario_model->getUserByDocumento($numerodni);

                    if ($this->input->post('saldo') != 0) {
                        $newCarga = [
                            'fecha' => date('Y-m-d', time()),
                            'hora' => date('H:i:s', time()),
                            'id_usuario' => $usuario->id,
                            'monto' => $this->input->post('saldo'),
                            'id_vendedor' => $this->session->id_vendedor
                        ];
                        $this->carga_model->addCargaLog($newCarga);
                        $this->correoCargaSaldo($this->session->id_vendedor);
                    }

                    //Confeccion del correo del recivo
                    $correo = $this->input->post('email');
                    $dataCorreo['dni'] = $numerodni;
                    $dataCorreo['apellido'] = $this->input->post('apellido');
                    $dataCorreo['nombre'] = $this->input->post('nombre');
                    $dataCorreo['password'] = $password;

                    $subject = "Bienvenido al Comedor Universitario UTN-FRLP";
                    $message = $this->load->view('general/correos/nuevo_usuario', $dataCorreo, true);
                    $this->generalticket->smtpSendEmail($correo, $subject, $message);

                    redirect(base_url('admin'));
                }
            }
        } else {
            $this->load->view('header', $data);
            $this->load->view('crear_usuario', $data);
            $this->load->view('general/footer');
        }
    }

    public function updateUser()
    {
        $data = [
            'titulo' => 'Actualizar Usuario'
        ];
        $iduser = $this->uri->segment(3);

        if (null == $this->usuario_model->getUserById($iduser)) {
            redirect(base_url('admin'));
        }

        $usuario = $this->usuario_model->getUserById($iduser);
        $data['usuario'] = $usuario;

        //Asigno el costo de la vianda segun el tipo de usuario
        //1-Estudiante || 2-Becado || 3-Docente || 4-No Docente
        if ($this->input->post('beca') == 'Si') {
            $idPrecio = 2;
        } else {
            if ($this->input->post('claustro') == 'Estudiante') {
                $idPrecio = 1;
            } elseif ($this->input->post('claustro') == 'No Docente') {
                $idPrecio = 4;
            } elseif ($this->input->post('claustro') == 'Docente') {
                $idPrecio = 3;
            }
        };

        // Verifico si se carga informacion en el formulario
        if ($this->input->method() == 'post') {
            // Verifico la informcion del formulario
            $unique_legajo =  '';
            $unique_documento =  '';
            $unique_email =  '';
            if ($this->input->post('legajo') != $usuario->legajo) {
                $unique_legajo =  '|is_unique[usuarios.legajo]';
            } elseif ($this->input->post('documento') != $usuario->documento) {
                $unique_documento = '|is_unique[usuarios.documento]';
            } elseif ($this->input->post('documento') != $usuario->documento) {
                $unique_email = '|is_unique[usuarios.mail]';
            }
            $rules = [
                [
                    'field' => 'legajo',
                    'label' => 'Legajo',
                    'rules' => "trim|min_length[5]|required|max_length[6]|numeric|integer{$unique_legajo}",
                    'errors' => [
                        'max_length' => 'El %s debe contener 5 y 6 digitos',
                        'min_length' => 'El %s debe contener 5 y 6 digitos',
                        'required' => 'Debe ingresar un %s',
                        'numeric' => 'El %s debe ser un numero',
                        'integer' => 'El %s debe ser un entero',
                        'is_unique' => 'Ese %s ya esta registrado',
                    ]
                ],
                [
                    'field' => 'documento',
                    'label' => 'Documento',
                    'rules' => "trim|max_length[8]|numeric|required|integer{$unique_documento}",
                    'errors' => [
                        'required' => 'Debe ingresar un %s',
                        'max_length' => 'El %s debe contener 5 numeros como maximo',
                        'numeric' => 'El %s debe ser un numero',
                        'integer' => 'El %s debe ser un entero',
                        'is_unique' => 'Ese %s ya esta registrado',
                    ]
                ],
                [
                    'field' => 'nombre',
                    'label' => 'Nombre',
                    'rules' => 'trim|max_length[50]|required',
                    'errors' => [
                        'max_length' => 'El %s debe contener como maximo 50 caracteres',
                        'required' => 'Debe ingresar un %s',
                    ]
                ],
                [
                    'field' => 'apellido',
                    'label' => 'Apellido',
                    'rules' => 'trim|max_length[50]|required',
                    'errors' => [
                        'max_length' => 'El %s debe contener como maximo 50 caracteres',
                        'required' => 'Debe ingresar un %s',
                    ]
                ],
                [
                    'field' => 'claustro',
                    'label' => 'Claustro',
                    'rules' => 'trim|in_list[Estudiante,Docente,No Docente]|required',
                    'errors' => [
                        'required' => 'Debe elegir un %s',
                        'in_list' => 'No es un %s valido',
                    ]
                ],
                [
                    'field' => 'email',
                    'label' => 'E-Mail',
                    'rules' => "trim|valid_email|required{$unique_email}",
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
                $this->load->view('modificar_usuario', $data);
                $this->load->view('general/footer');
            } else {
                $updateUser = [
                    'legajo' => $this->input->post('legajo'),
                    'documento' => $this->input->post('documento'),
                    'nombre' => ucwords($this->input->post('nombre')),
                    'apellido' => ucwords($this->input->post('apellido')),
                    'tipo' => ucwords($this->input->post('claustro')),
                    'especialidad' => ucwords($this->input->post('especialidad')),
                    'mail' => strtolower($this->input->post('email')),
                    'id_precio' => $idPrecio
                ];

                if ($this->usuario_model->updateUserById($iduser, $updateUser)) {
                    redirect(base_url('admin'));
                }
            }
        } else {
            $this->load->view('header', $data);
            $this->load->view('modificar_usuario', $data);
            $this->load->view('general/footer');
        }
    }

    public function descarcgarExcel()
    {
        $data = [
            'titulo' => 'Descarga de Planilla'
        ];
        if ($this->input->method() == 'post') {
            $strtime = strtotime($this->input->post('fecha'));
            $fecha_dowload = date('Y-m-d', $strtime);

            $filename = "Listado_{$fecha_dowload}.xlsx";
            $compras = $this->vendedor_model->getComprasByFechaForExls($fecha_dowload);
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'Legajo');
            $sheet->setCellValue('B1', 'Apellido');
            $sheet->setCellValue('C1', 'Nombre');
            $sheet->setCellValue('D1', 'Turno');
            $sheet->setCellValue('E1', 'Menu');
            $sheet->setCellValue('F1', 'Claustro');
            $rows = 2;
            foreach ($compras as $compra) {
                $usuario = $this->usuario_model->getUserById($compra->id_usuario);
                if ($usuario != null) {
                    $sheet->setCellValue("A{$rows}", $usuario->legajo);
                    $sheet->setCellValue("B{$rows}", $usuario->apellido);
                    $sheet->setCellValue("C{$rows}", $usuario->nombre);
                    $sheet->setCellValue("D{$rows}", $compra->turno);
                    $sheet->setCellValue("E{$rows}", $compra->menu);
                    $sheet->setCellValue("F{$rows}", $compra->tipo);
                    $rows++;
                }
            }
            header('Content-Type: application/vnd.ms-excel');
            header("Content-Disposition: attachment; filename={$filename}");
            $writer = new Xlsx($spreadsheet);
            $writer->save("php://output");
        } else {
            $this->load->view('header', $data);
            $this->load->view('descarga_planilla', $data);
            $this->load->view('general/footer');
        }
    }

    public function descargarInformes()
    {
        $id_vendedor = $this->session->userdata('id_vendedor');
        $fecha = date('Y-m-d');
        $cargas = $this->vendedor_model->getCargasByFechaForPDF($fecha);

        $data['cargas'] = $cargas;
        $data['vendedor'] = $this->vendedor_model->getUserById($id_vendedor);
        $data['total'] = array_sum(array_column($cargas, 'monto'));
        $data['fecha'] = date('d-m-Y');
        $data['cantidad'] = count(array_column($cargas, 'id'));

        $dompdf = new Dompdf();
        $dompdf->loadHtml($this->load->view('pdf_view/cajaDiaria', $data, true));
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("Cierre {$fecha}.pdf", array("Attachment" => 0)); //0 para ver, 1 para descargar
    }

    public function historialCargas()
    {
        $id_vendedor = $this->session->userdata('id_vendedor');
        $cargas = $this->vendedor_model->getCargasByIdvendedor($id_vendedor);

        $data = [
            'titulo' => 'Historial de cargas',
            'cargas' => $cargas
        ];

        $this->load->view('header', $data);
        $this->load->view('historial', $data);
        $this->load->view('general/footer');
    }

    public function updateMenu()
    {
        $menu = $this->vendedor_model->getMenu();

        $data['titulo'] = 'Actualizar Menu';
        $data['menu'] = $menu;

        if ($this->input->method() == 'post') {
            for ($i = 1; $i <= 5; $i++) {
                $this->form_validation->set_rules("basico_{$i}", 'Menu Basico', 'alpha_numeric_spaces', [
                    'alpha_numeric_spaces' => 'Solo deben contener caracteres alfanumerico',
                ]);
                $this->form_validation->set_rules("veggie_{$i}", 'Menu Veggie', 'alpha_numeric_spaces', [
                    'alpha_numeric_spaces' => 'Solo deben contener caracteres alfanumerico',
                ]);
            }
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('header', $data);
                $this->load->view('menu', $data);
                $this->load->view('general/footer');
            } else {
                for ($i = 1; $i <= 5; $i++) {
                    $menu_item['menu1'] = $this->input->post("basico_{$i}");
                    $menu_item['menu2'] = $this->input->post("veggie_{$i}");
                    $this->vendedor_model->updateMenu($i, $menu_item);
                }
                redirect(base_url('admin/menu'));
            }
        } else {
            $this->load->view('header', $data);
            $this->load->view('menu', $data);
            $this->load->view('general/footer');
        }
    }
}
