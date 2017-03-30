<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Download extends MY_Controller {

    function __construct()
    {
        parent::__construct(true);
        $this->data['page_title'] = "Downloads";
    }

    public function download($type)
    {
        $properties = array();
        $filter = $this->session->userdata('list_filter');
        $filter['status != '] = 'duplicate';
        if (isset($filter)) {
            $this->load->model('property_model');
            switch ($type) {
                case 'list_properties' :
                case 'downloads_properties' :
                    $where = array(
                        'p.deleted' => 0,
                        'p.active' => 1
                    );
                    break;
                case 'downloads_letters' :
                case 'downloads_postcards' :
                    $where = array(
                        'p.deleted' => 0,
                        'p.status !=' => 'duplicate',
                        'p.status !=' => 'draft' 
                    );
                    break;
            }
            $properties = $this->property_model->get_properties($this->logged_user->company_id, $where, $filter);
        } else {
            die('Cannot find filter, please contact administrator.');
        }
        $this->load->library('download_library');
        $this->download_library->download_list($type, $properties, $this->logged_user);
    }

    public function properties()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $action = $this->input->post('action');
            switch ($action) {
                case 'list':
                    $filter = $this->input->post('filter');
                    $this->load->library('property_library');
                    $filter = $this->property_library->setup_search_filter($filter);
                    $this->load->model('property_model');
                    $where = array( 
                        'p.deleted' => 0,
                        'p.active' => 1
                    );
                    $properties = $this->property_model->get_properties($this->logged_user->company_id, $where, $filter);
                    foreach ($properties as $p) {
                        $p->url = "";
                        $p->list_url = "";
                        if ($this->_checkListPermission($p->list_id, 'retrieve')) {
                            $p->url = base_url() . 'lists/property/' . $p->list_id . '/info/' . $p->id;
                            $p->list_url = base_url() . 'lists/info/' . $p->list_id;
                        }
                    }
                    echo json_encode(array('data' => $properties));
                    break;
                default:
                    echo json_encode(array('result' => false, 'message' => 'Action not found.'));
            }
        } else {
            $this->load->library('dm_library');
            $this->data['lists'] = $this->dm_library->getListsForSelect2($this->logged_user->company_id);
            $this->data['statuses'] = $this->dm_library->getStatusesForSelect2();
            $this->_renderL('download/properties');
        }
    }

    public function letters()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $action = $this->input->post('action');
            switch ($action) {
                case 'list':
                    $filter = $this->input->post('filter');
                    $this->load->library('property_library');
                    $filter = $this->property_library->setup_search_filter($filter);
                    $this->load->model('property_model');
                    $where = array(
                        'p.deleted' => 0,
                        'p.status !=' => 'duplicate',
                        'p.status !=' => 'draft' 
                    );
                    if (!isset($filter['date_range'])) {
                        $filter['date_range'] = "pm.mailing_date = '" . date('Y-m-d') . "'";
                    }
                    $properties = $this->property_model->get_properties($this->logged_user->company_id, $where, $filter);
                    foreach ($properties as $p) {
                        $p->url = "";
                        $p->list_url = "";
                        if ($this->_checkListPermission($p->list_id, 'retrieve')) {
                            $p->url = base_url() . 'lists/property/' . $p->list_id . '/info/' . $p->id;
                            $p->list_url = base_url() . 'lists/info/' . $p->list_id;
                        }
                    }
                    echo json_encode(array('data' => $properties));
                    break;
                default:
                    echo json_encode(array('result' => false, 'message' => 'Action not found.'));
            }
        } else {
            $this->load->library('dm_library');
            $this->data['lists'] = $this->dm_library->getListsForSelect2($this->logged_user->company_id);
            $this->data['statuses'] = $this->dm_library->getStatusesForSelect2(['duplicate', 'draft']);
            $this->_renderL('download/letters');
        }
    }

    public function postcards()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $action = $this->input->post('action');
            switch ($action) {
                case 'list':
                    $filter = $this->input->post('filter');
                    $filter['postcards'] = true;
                    $this->load->library('property_library');
                    $filter = $this->property_library->setup_search_filter($filter);
                    $this->load->model('property_model');
                    $where = array(
                        'p.deleted' => 0,
                        'p.status !=' => 'duplicate',
                        'p.status !=' => 'draft'
                    );
                    $properties = $this->property_model->get_properties($this->logged_user->company_id, $where, $filter);
                    foreach ($properties as $p) {
                        $p->url = "";
                        $p->list_url = "";
                        if ($this->_checkListPermission($p->list_id, 'retrieve')) {
                            $p->url = base_url() . 'lists/property/' . $p->list_id . '/info/' . $p->id;
                            $p->list_url = base_url() . 'lists/info/' . $p->list_id;
                        }
                    }
                    echo json_encode(array('data' => $properties));
                    break;
                default:
                    echo json_encode(array('result' => false, 'message' => 'Action not found.'));
            }
        } else {
            $this->load->library('dm_library');
            $this->data['lists'] = $this->dm_library->getListsForSelect2($this->logged_user->company_id);
            $this->data['statuses'] = $this->dm_library->getStatusesForSelect2(['duplicate', 'draft']);
            $this->_renderL('download/postcards');
        }
    }

}
