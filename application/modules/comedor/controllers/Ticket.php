<?php

use phpDocumentor\Reflection\PseudoTypes\True_;

defined('BASEPATH') or exit('No direct script access allowed');

class Ticket extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('ticket_model');
        $this->load->model('usuario/usuario_model');

        if (!$this->session->userdata('is_user')) {
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
        return true;
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
        return true;
    }

    public function index()
    {
        $id_usuario = $this->session->userdata('id_usuario');
        $nroDia = date('N');
        $proximo_lunes = time() + ((7 - ($nroDia - 1)) * 24 * 60 * 60);
        $proximo_lunes_fecha = date('Y-m-d', $proximo_lunes);
        $proximo_viernes = time() + ((7 - ($nroDia - 5)) * 24 * 60 * 60);
        $proximo_viernes_fecha = date('Y-m-d', $proximo_viernes);
        $usuario = $this->usuario_model->getUserById($id_usuario);

        if ($this->estadoComedor()) {
            if ($this->estadoCompra()) {
                $data = [
                    'titulo' => 'Comprar',
                    'usuario' => $usuario,
                    'feriados' => $this->ticket_model->getFeriadosInRange($proximo_lunes_fecha, $proximo_viernes_fecha),
                    'comprados' => $this->ticket_model->getComprasInRangeByIdUser($proximo_lunes_fecha, $proximo_viernes_fecha, $id_usuario),
                    'costoVianda' => $this->ticket_model->getCostoByID($usuario->id_precio)
                ];

                $this->load->view('usuario/header', $data);
                $this->load->view('index', $data);
                $this->load->view('general/footer');
            } else {
                $data = [
                    'titulo' => 'Comprar',
                    'alerta' => "<p>Fuera del horario de compra</p><p>La compra se realiza desde el Lunes hasta el Viernes a las {$this->config->item('hora_final')}</p>"
                ];

                $this->load->view('usuario/header', $data);
                $this->load->view('alerta_comedor_cerrado', $data);
                $this->load->view('general/footer');
            }
        } else {
            $data = [
                'titulo' => 'Comprar',
                'alerta' => '<p>El comedor no funciona en este Periodo</p>'
            ];

            $this->load->view('usuario/header', $data);
            $this->load->view('alerta_comedor_cerrado', $data);
            $this->load->view('general/footer');
        }
    }

    public function compra()
    {
        $totalCompra = $this->input->post('total');

        $id_usuario = $this->session->userdata('id_usuario');
        $usuario = $this->usuario_model->getUserById($id_usuario);
        $costoVianda = $this->ticket_model->getCostoByID($usuario->id_precio);
        $saldoUser = $usuario->saldo;
        $nroDia = date('N');

        if ($totalCompra > $saldoUser) {
            redirect(base_url('menu'));
        }

        $dias = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes'];
        // carga de la comppra en la DB
        $n_compras = 0;
        foreach ($dias as $id => $dia) {
            if ($this->input->post("check{$dia}")) {
                //obtenemos el saldo actualizado luego de cada compra
                $saldo = $this->ticket_model->getSaldoByIDUser($id_usuario);
                $nroDia = date('N');
                $proximo = time() + ((7 - $nroDia + ($id + 1)) * 24 * 60 * 60);

                $data_compra = [
                    'fecha' => date('Y-m-d', time()),
                    'hora' => date('H:i:s', time()),
                    'dia_comprado' => date('Y-m-d', $proximo),
                    'id_usuario' => $id_usuario,
                    'precio' => $costoVianda,
                    //'tipo' => $this->input->post("selectTipo{$dia}"),
                    'turno' => $this->input->post("selectTurno{$dia}"),
                    'menu' => $this->input->post("selectMenu{$dia}"),
                    'transaccion_id' => -$id_usuario //Seteamos un id unico y negativo para poder obtenerlas luego
                ];

                $data_log = [
                    'fecha' => date('Y-m-d', time()),
                    'hora' => date('H:i:s', time()),
                    'dia_comprado' => date('Y-m-d', $proximo),
                    'id_usuario' => $id_usuario,
                    'precio' => $costoVianda,
                    //'tipo' => $this->input->post("selectTipo{$dia}"),
                    'turno' => $this->input->post("selectTurno{$dia}"),
                    'menu' => $this->input->post("selectMenu{$dia}"),
                    'transaccion_tipo' => 'Compra',
                    'transaccion_id' => -$id_usuario //Seteamos un id unico y negativo para poder obtenerlas luego
                ];

                if ($this->ticket_model->addCompra($data_compra)) {
                    //Actualizamos el saldo
                    $this->ticket_model->updateSaldoByIDUser($id_usuario, $saldo - $costoVianda);
                    $this->ticket_model->addLogCompra($data_log);
                    $n_compras = $n_compras + 1;
                };
            }
        }
        //Si se generaron compras asiento la transaccion
        if ($n_compras > 0) {
            //Genero los datos de la transaccion
            $transaction_compra = [
                'fecha' => date('Y-m-d', time()),
                'hora' => date('H:i:s', time()),
                'id_usuario' => $id_usuario,
                'transaccion' => 'Compra',
                'monto' => -$costoVianda * $n_compras,
            ];
            //Calculo el saldo final de la transaccion y lo seteo
            $saldo = $saldoUser - $costoVianda  * $n_compras;
            $transaction_compra['saldo'] = $saldo;
            //Inserto la transaccion y obtengo su ID
            $id_insert = $this->ticket_model->addTransaccion($transaction_compra);
            //Obtenemos los registros en la tabla 'compra' con el id provisorio y lo actualizamos
            $compras = $this->ticket_model->getComprasByIDTransaccion(-$id_usuario);
            foreach ($compras as $compra) {
                $id_compra = $compra->id;
                $this->ticket_model->updateTransactionInCompraByID($id_compra, $id_insert);
            }
            //Obtenemos los registros en la tabla 'log_compra' con el id provisorio y lo actualizamos
            $logcompras = $this->ticket_model->getLogComprasByIDTransaccion(-$id_usuario);
            foreach ($logcompras as $compra) {
                $id_compra = $compra->id;
                $this->ticket_model->updateTransactionInLogCompraByID($id_compra, $id_insert);
            }
        }
        //Confeccion del correo del recivo
        $usuario = $this->usuario_model->getUserById($id_usuario);
        $compras = $this->ticket_model->getComprasByIDTransaccion($id_insert);
        $dataRecivo['compras'] = $compras;
        $dataRecivo['total'] = $costoVianda * $n_compras;
        $dataRecivo['fechaHoy'] = date('d/m/Y', time());
        $dataRecivo['horaAhora'] = date('H:i:s', time());
        $dataRecivo['recivoNumero'] = $id_insert;

        $subject = "Recibo de compra del comedor";
        $message = $this->load->view('general/correos/recibo_compra', $dataRecivo, true);

        if ($this->generalticket->smtpSendEmail($usuario->mail, $subject, $message)) {
            redirect(base_url('usuario'));
        }
    }

    public function devolverCompra()
    {
        if ($this->estadoComedor()) {
            if ($this->estadoCompra()) {
                $id_usuario = $this->session->userdata('id_usuario');
                $nroDia = date('N');
                $proximo_lunes = time() + ((7 - ($nroDia - 1)) * 24 * 60 * 60);
                $proximo_lunes_fecha = date('Y-m-d', $proximo_lunes);
                $proximo_viernes = time() + ((7 - ($nroDia - 5)) * 24 * 60 * 60);
                $proximo_viernes_fecha = date('Y-m-d', $proximo_viernes);
                $usuario = $this->usuario_model->getUserById($id_usuario);
                $saldoUser = $usuario->saldo;
                $data = [
                    'titulo' => 'Devolucion de compras',
                    'compras' => $this->ticket_model->getComprasInRangeByIdUser($proximo_lunes_fecha, $proximo_viernes_fecha, $id_usuario),
                    'devolucion' => TRUE
                ];

                if ($this->input->method() == 'post') {
                    $n_devolucion = 0;
                    foreach (range(0, 4) as $numero) {
                        if ($this->input->post("devolver_{$numero}")) {
                            $saldo = $this->ticket_model->getSaldoByIDUser($id_usuario);
                            $costoVianda = $this->ticket_model->getCostoById($usuario->id_precio);
                            $id_compra = $this->input->post("devolver_{$numero}");
                            $compra = $this->ticket_model->getCompraById($id_compra);
                            $data_log = [
                                'fecha' => date('Y-m-d', time()),
                                'hora' => date('H:i:s', time()),
                                'dia_comprado' => $compra->dia_comprado,
                                'id_usuario' => $id_usuario,
                                'precio' => $compra->precio,
                                //'tipo' => $compra->tipo,
                                'turno' => $compra->turno,
                                'menu' => $compra->menu,
                                'transaccion_tipo' => 'Devolucion', //Seteamos un id unico y negativo para poder obtenerlas luego
                                'transaccion_id' => -$id_usuario //Seteamos un id unico y negativo para poder obtenerlas luego
                            ];
                            if ($this->ticket_model->removeCompra($id_compra, $id_usuario)) {
                                $this->ticket_model->updateSaldoByIDUser($id_usuario, $saldo + $costoVianda);
                                $this->ticket_model->addLogCompra($data_log);
                                $n_devolucion = $n_devolucion + 1;
                            }
                        }
                    }
                    //Si se generaron compras asiento la transaccion
                    if ($n_devolucion > 0) {
                        //Genero los datos de la transaccion
                        $transaction_devolucion = [
                            'fecha' => date('Y-m-d', time()),
                            'hora' => date('H:i:s', time()),
                            'id_usuario' => $id_usuario,
                            'transaccion' => 'Devolucion',
                            'monto' => $costoVianda * $n_devolucion,
                        ];
                        //Calculo el saldo final de la transaccion y lo seteo
                        $saldo = $saldoUser + $costoVianda  * $n_devolucion;
                        $transaction_devolucion['saldo'] = $saldo;
                        //Inserto la transaccion y obtengo su ID
                        $id_insert = $this->ticket_model->addTransaccion($transaction_devolucion);
                        //Obtenemos los registros en la tabla 'log_compra' con el id provisorio y lo actualizamos
                        $logcompras = $this->ticket_model->getLogComprasByIDTransaccion(-$id_usuario);
                        foreach ($logcompras as $compra) {
                            $id_compra = $compra->id;
                            $this->ticket_model->updateTransactionInLogCompraByID($id_compra, $id_insert);
                        }
                    }
                    //Confeccion del correo del recivo
                    $usuario = $this->usuario_model->getUserById($id_usuario);
                    $compras = $this->ticket_model->getlogComprasByIDTransaccion($id_insert);
                    $dataRecivo['compras'] = $compras;
                    $dataRecivo['total'] = $costoVianda * $n_devolucion;
                    $dataRecivo['fechaHoy'] = date('d/m/Y', time());
                    $dataRecivo['horaAhora'] = date('H:i:s', time());
                    $dataRecivo['recivoNumero'] = $id_insert;

                    $subject = "Recibo de devolucion del comedor";
                    $message = $this->load->view('general/correos/recibo_devolucion', $dataRecivo, true);

                    if ($this->generalticket->smtpSendEmail($usuario->mail, $subject, $message))
                        redirect(base_url('usuario/devolver_compra'));
                } else {
                    $this->load->view('usuario/header', $data);
                    $this->load->view('usuario/devolver_compra', $data);
                    $this->load->view('general/footer');
                }
            } else {
                $data = [
                    'titulo' => 'Devolver Compras',
                    'alerta' => "<p>Fuera del horario de devolucion</p><p>La devolucion se realiza desde el Lunes hasta el Viernes a las {$this->config->item('hora_final')}</p>"
                ];

                $this->load->view('usuario/header', $data);
                $this->load->view('alerta_comedor_cerrado', $data);
                $this->load->view('general/footer');
            }
        } else {
            $data = [
                'titulo' => 'Devolver Compras',
                'alerta' => "<p>Comedor cerrado</p>"
            ];

            $this->load->view('usuario/header', $data);
            $this->load->view('alerta_comedor_cerrado', $data);
            $this->load->view('general/footer');
        }
    }
}