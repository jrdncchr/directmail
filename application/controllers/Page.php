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
            $this->load->model('user_model');
            $result = $this->user_model->login($auth);
            if ($result['success']) {
                $session = $this->session->userdata;
                var_dump($session);exit;
                redirect(base_url() . 'dashboard');
            } else {
                $this->session->set_flashdata('message', create_alert_message($result));
                $this->_render('page/login');
            }
        } else {
            $this->_render('page/login');
        }
    }

    public function register($client_key, $success = false)
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $info = $this->input->post();
            $this->load->model('user_model');
            $result = $this->user_model->register($info);
            if ($result['success']) {
                redirect(base_url() . 'register/' . $client_key . '/success');
            } else {
                var_dump($result);
            }
        } else {
            $this->load->model('client_model');
            $client = $this->client_model->get(array('client_key' => $client_key, 'deleted' => 0), false);
            if ($client) {
                $this->data['client'] = $client;
                if ($success) {
                    $this->_render('page/register_success');
                } else {
                    $this->_render('page/register');
                }
            } else {
                show_404();
            }
        }
    }

}
