<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Errores extends CI_Controller
{
	public function error404()
	{
		$data['is_admin'] = $this->session->userdata('is_admin');
		$data['titulo'] = 'Error 404';
		$this->load->view('general/error/404', $data);
	}
}
