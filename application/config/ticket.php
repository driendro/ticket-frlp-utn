<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('America/Argentina/Buenos_Aires');

$config['modules_locations'] = [
	APPPATH . 'modules/' => '../modules/',
];

/**
 *  SMTP
 */

$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.gmail.com';
$config['smtp_user'] = 'ticketwbfrlp@gmail.com';
$config['smtp_pass'] = 'Ch1ch0L74';
$config['smtp_port'] = '587';
$config['smtp_crypto'] = 'tls';
$config['email_settings_sender'] = 'ticketweb@frlp.utn.edu.ar';
$config['email_settings_sender_name'] = 'TicketWeb';