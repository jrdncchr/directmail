<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Download extends MY_Controller {

    function __construct()
    {
        parent::__construct(true);
    }

    public function properties($type)
    {
        $properties = array();
        $filter = $this->session->userdata('list_filter');
        if (isset($filter)) {
            $this->load->model('property_model');
            switch ($type) {
                case 'report_mailings' :
                    $where = array(
                            'p.status' => 'active', 
                            'p.deleted' => 0,
                            'p.next_mailing_date >=' => date('Y-m-d')
                        );
                    $properties = $this->property_model->get_properties($this->logged_user->company_id, $where, $filter, 'p.next_mailing_date');
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

}
