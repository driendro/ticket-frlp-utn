<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('America/Argentina/Buenos_Aires');

$config['modules_locations'] = [
	APPPATH . 'modules/' => '../modules/',
];

//SMTP
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.gmail.com';
$config['smtp_user'] = 'ticketwbfrlp@gmail.com';
$config['smtp_pass'] = 'jkklhudzrqkdbbnt';
$config['smtp_port'] = '587';
$config['smtp_crypto'] = 'tls';
$config['email_settings_sender'] = 'ticketweb@frlp.utn.edu.ar';
$config['email_settings_sender_name'] = 'TicketWeb';

// Configuracion de parametros

$config['apertura'] = '2022-04-04';
$config['cierre'] = '2022-12-09';
$config['vacaciones_i'] = '2022-07-17';
$config['vacaciones_f'] = '2022-07-31';
$config['dia_inicial'] = 1; //lunes
$config['dia_final'] = 7; //viernes
$config['hora_final'] = '12:00:00'; //hora del viernes de cierre de compra

//Set lenguage
setlocale(LC_ALL, "es_ES");