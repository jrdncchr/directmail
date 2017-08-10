<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    function __construct()
    {
        parent::__construct(true);
        $this->data['page_title'] = "Dashboard";
    }

    public function index()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $result = array('success' => false);
            $action = $this->input->post('action');
            $this->load->model('list_model');
            switch ($action) {
                case 'needs_action' :
                    $lists = $this->list_model->get(['l.company_id' => $this->logged_user->company_id], true, true);
                    echo json_encode(array('data' => $lists));
                    break;
                case 'check_list_permission' :
                    $list_id = $this->input->post('list_id');
                    if ($this->list_permissions[$list_id]->retrieve_action) {
                        $result['success'] = true;
                    }
                    echo json_encode($result);
                    break;
                default :
                    echo json_encode($result);
            }
        } else {
            $this->load->model('property_model');
            $where = array(
                'p.deleted' => 0
            );
            $filter['status_not_in'] = ['draft', 'duplicate'];
            $filter['date_range'] = "pm.mailing_date = '" . date('Y-m-d') . "'";
            $properties = $this->property_model->get_properties(
                $this->logged_user->company_id, 
                $where, 
                $filter
            );
            $this->data['properties_for_mailing_today'] = sizeof($properties);

            $this->load->model('backup_model');
            $this->data['last_backup_days'] = $this->backup_model->get_last_backup_days_count();

            $this->_renderL('dashboard/index');
        }
    }



    public function logout()
    {
        $this->session->sess_destroy();
        $this->user = null;
        redirect(base_url() . "login");
    }
}
