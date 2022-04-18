<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
    * @return boolean
    */
    public function isLogged()
    {
        if ($this->session->userdata('logged_in'))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
