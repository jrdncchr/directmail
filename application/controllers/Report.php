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
                $this->load->library('download_library');
                $this->download_library->download_mailings($filter);
            } else {
                $action = $this->input->post('action');
            }
        } else {
            if ($sub == 'index') {
                $this->load->library('dm_library');
                $this->data['lists'] = $this->dm_library->getListsForSelect2($this->logged_user->company_id);
                $this->_renderL('report/mailings');
            }
        }
    }

}