<?php
defined('BASEPATH') or exit('No direct script access allowed');

class General_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function smtpSendEmail($to, $subject, $message)
	{
		$this->load->library('email');

		$config = array(
			'protocol'  => 'smtp',
			'smtp_host' => $this->config->item('smtp_host'),
			'smtp_user' => $this->config->item('smtp_user'),
			'smtp_pass' => $this->config->item('smtp_pass'),
			'smtp_port' => $this->config->item('smtp_port'),
			'smtp_crypto' => $this->config->item('smtp_crypto'),
			'mailtype'  => 'html',
			'charset'   => 'utf-8'
		);
		$this->email->initialize($config);
		//$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");

		$this->email->to($to);
		$this->email->from($this->config->item('email_settings_sender'), $this->config->item('email_settings_sender_name'));
		$this->email->subject($subject);
		$this->email->message($message);

		return $this->email->send();
	}
}
