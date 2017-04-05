<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends MY_Controller {

    function __construct()
    {
        parent::__construct(true);
        $this->data['page_title'] = "Reports";
    }

    public function mailings($sub = "index")
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            if ($sub == 'download') {
                $filter = $this->input->post();
                if (isset($filter['date_range']) && $filter['date_range'] !== '') {
                    $date_split = explode(' - ', $filter['date_range']);
                    $filter['from'] = $date_split[0];
                    $filter['to'] = $date_split[1];
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
                $this->_renderL('report/mailings');
            }
        }
    }

}