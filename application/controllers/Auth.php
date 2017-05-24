<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        if ($this->logged_user !== null) {
            redirect(base_url() . 'lists');
        }
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
                redirect(base_url() . 'lists');
            } else {
                $this->session->set_flashdata('message', create_alert_message($result));
                $this->_render('auth/login');
            }
        } else {
            $this->_render('auth/login');
        }
    }

    public function register($company_key, $success = false)
    {
        $this->load->model('company_model');
        $company = $this->company_model->get(array('company_key' => $company_key, 'deleted' => 0), false);
        $this->data['company'] = $company;

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $info = $this->input->post();
            $info['company_id'] = $company->id;
            $info['company_name'] = $company->name;

            $this->load->model('user_model');
            $result = $this->user_model->register($info);
            if ($result['success']) {
                redirect(base_url() . 'register/' . $company_key . '/success');
            } else {
                $this->data['info'] = $info;
                $this->session->set_flashdata('message', create_alert_message($result));
                $this->_render('auth/register');
            }
        } else {
            if ($company_key) {
                if ($success) {
                    $this->_render('auth/register_success');
                } else {
                    $this->_render('auth/register');
                }
            } else {
                show_404();
            }
        }
    }

    public function confirm($confirmation_key)
    {
        $this->load->model('user_model');
        $result = $this->user_model->confirm($confirmation_key);
        if ($result['success']) {
            $this->session->set_flashdata('message', create_alert_message($result));
            $this->login();
        } else {
            show_404();
        }
    }

    public function confirm_company($confirmation_key)
    {
        $this->load->model('user_model');
        $result = $this->user_model->confirm($confirmation_key);
        if ($result['success']) {
            $this->load->model('company_model');
            $this->company_model->save(array('id' => $result['company_id'], 'status' => 'active'));
            $this->session->set_flashdata('message', create_alert_message($result));
            $this->login();
        } else {
            show_404();
        }
    }

    public function not_found()
    {
        $this->output->set_status_header('404');
        $this->_render('not_found');
    }

    public function jordan_secret()
    {
        phpinfo();
    }

}
