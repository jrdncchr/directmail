<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    function __construct()
    {
        parent::__construct(true);
    }

	public function index()
	{
        $this->_renderL('dashboard/index');
	}

    public function logout()
    {
        $this->session->sess_destroy();
        $this->user = null;
        redirect(base_url() . "login");
    }
}
