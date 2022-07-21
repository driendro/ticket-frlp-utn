<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaction_init extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('transacciones_model');
    }

    public function index()
    {
        //Recorremos las fechas para realizar los registros en trasacciones
        $strtime = mktime(0, 0, 0, 6, 12, 2022); //'2022-06-12';
        $fecha_ini = date('Y-m-d', $strtime); //Cominenzo al 100% del comedor
        $fecha_fin = date('Y-m-d', time()); //El dia de hoy
        $allUser = $this->transacciones_model->getAllUser();

        $user_id = 1;
        $cantidad_user = count($allUser);

        while ($user_id <= $cantidad_user) { //Recorro los IDs de los usuarios
            $saldo = 0; //Inicio el Saldo del User en 0
            $fecha = $fecha_ini; //Asigno la primera fecha
            $i = 0; //Inicializo el contador de los dias
            while ($fecha <= $fecha_fin) { //Comparo la fecha de analisis con la de hoy
                //Obtengo todas las cargas del usuario en esa fecha
                $cargas_user = $this->transacciones_model->getCargasByFechaByIDUser($fecha, $user_id);
                //Recorro las cargas de ese usuario en ese dia
                foreach ($cargas_user as $key => $carga) {
                    $id_carga = $carga->id;
                    //Genero el array para insertar en al db transacciones
                    $transaction_carga = [
                        'fecha' => $carga->fecha,
                        'hora' => $carga->hora,
                        'id_usuario' => $user_id,
                        'monto' => $carga->monto
                    ];
                    //Verifico si es una devolucion o una carga
                    if ($carga->monto >= 0) {
                        $transaction_carga['transaccion'] = 'Carga de Saldo';
                    } else {
                        $transaction_carga['transaccion'] = 'Devolucion de Saldo';
                    };
                    //Calculo el saldo final de la transaccion y lo seteo
                    $saldo = $saldo + $carga->monto;
                    $transaction_carga['saldo'] = $saldo;
                    //Inserto la transaccion y obtengo su ID
                    $id_insert = $this->transacciones_model->addTransaccion($transaction_carga);
                    //Asigno el ID de la transaccion en la tabla log_cargas
                    $this->transacciones_model->updateTransactionInCargaByID($id_carga, $id_insert);
                };
                //Obtengo todas las compras del usuario en esa fecha
                $compras_user = $this->transacciones_model->getComprasByFechaByIDUser($fecha, $user_id);
                //Cuento las compras de la fecha
                $n_compras = count($compras_user);
                //Si existen compras
                if ($n_compras >= 1) {
                    //Genero los datos de la transaccion
                    $transaction_compra = [
                        'fecha' => $fecha,
                        'hora' => $this->transacciones_model->getHoraCompraByFechaByIDUser($fecha, $user_id),
                        'id_usuario' => $user_id,
                        'transaccion' => 'Compra',
                        'monto' => -180 * $n_compras,
                    ];
                    //Calculo el saldo final de la transaccion y lo seteo
                    $saldo = $saldo - 180 * $n_compras;
                    $transaction_compra['saldo'] = $saldo;
                    //Inserto la transaccion y obtengo su ID
                    $id_insert = $this->transacciones_model->addTransaccion($transaction_compra);
                };
                //recorro las compras y les asigno el id de la transaccion a cada una
                foreach ($compras_user as $key => $compra) {
                    $id_compra = $compra->id;
                    $this->transacciones_model->updateTransactionInCompraByID($id_compra, $id_insert);
                };
                //Paso $fecha al dia siguiente
                $i = $i + 1;
                $fecha = date('Y-m-d', $strtime + ($i * 24 * 60 * 60));
            }
            //Verificamos que el saldo obtenido sea el mismo que el del usuario
            if ($saldo !== $this->transacciones_model->getSaldoByIDUser($user_id)) {
                $errores[] = array(
                    $user_id,
                    $saldo,
                    $this->transacciones_model->getSaldoByIDUser($user_id)
                );
            }
            //Paso la Id siguiente
            $user_id = $user_id + 1;
        }
        $data['error'] = $errores;
        $this->load->view('transaccion', $data);
    }
}