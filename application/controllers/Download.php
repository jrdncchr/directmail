<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Download extends MY_Controller {

    function __construct()
    {
        parent::__construct(true);
        $this->data['page_title'] = "Downloads";
    }

    public function properties($type)
    {
        $properties = array();
        $filter = $this->session->userdata('list_filter');
        $filter['status != '] = 'duplicate';
        if (isset($filter)) {
            $this->load->model('property_model');
            switch ($type) {
                case 'report_mailings' :
                    $where = array(
                            'p.deleted' => 0
                        );
                    $properties = $this->property_model->get_properties($this->logged_user->company_id, $where, $filter, 'pm.mailing_date');
                    break;
                case 'report_properties' :
                    $where = array( 
                        'p.deleted' => 0,
                    );
                    $properties = $this->property_model->get_properties($this->logged_user->company_id, $where, $filter);
                    break;
                case 'approval_properties' :
                    $where = array(
                        'p.status' => 'pending', 
                        'p.deleted' => 0
                    );
                    $properties = $this->property_model->get_properties($this->logged_user->company_id, $where, $filter);
                    break;
                case 'list_properties' :
                    $where = array(
                        'p.deleted' => 0,
                        'p.active' => 1
                    );
                    $properties = $this->property_model->get_properties($this->logged_user->company_id, $where, $filter);
            }
        } else {
            die('Cannot find filter, please contact administrator.');
        }
        $this->load->library('property_library');
        $this->property_library->download_list($type, $properties, $this->logged_user);
    }

    public function mailings($sub = "index")
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            if ($sub == 'download') {
                $filter = $this->input->post();
                // validate filter
                if ($filter['report_type'] == 'Date Range') {
                    if (strtotime($filter['to']) < strtotime($filter['from'])) {
                        $alert = create_alert_message(array('success' => false, 'message' => 'Date from cannot be greater than date to.'));
                        $this->session->set_flashdata('message', $alert);
                        $this->load->model('list_model');
                        $this->data['lists'] = $this->list_model->get(array('l.company_id' => $this->logged_user->company_id));
                        $this->_renderL('download/mailings');
                        return;
                    }
                }
                $this->load->library('download_library');
                $this->download_library->download_mailings($filter);
            } else {
                $action = $this->input->post('action');
            }
        } else {
            if ($sub == 'index') {
                $this->load->model('list_model');
                $this->data['lists'] = $this->list_model->get(array('l.company_id' => $this->logged_user->company_id));
                $this->_renderL('download/mailings');
            }
        }
    }

}
