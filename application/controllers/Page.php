<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends MY_Controller {

    function __construct()
    {
        parent::__construct();
    }

	public function index()
	{
        $this->login();
	}

    public function login()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $auth = $this->input->post();

        } else {
            $this->_render('login');
        }
    }

}
