<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends MY_Controller {

    function __construct()
    {
        parent::__construct(true);
        $this->data['page_title'] = "Reports";
    }

	public function mailings()
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
                        'p.status !=' => 'duplicate' 
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
            $this->load->model('list_model');
            $this->data['lists'] = $this->list_model->get(array('l.company_id' => $this->logged_user->company_id));
            $this->_renderL('report/mailings');
        }
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
                        'p.active' => 1,
                        'p.status !=' => 'duplicate' 
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
            $this->load->model('list_model');
            $this->data['lists'] = $this->list_model->get(array('l.company_id' => $this->logged_user->company_id));
            $this->_renderL('report/properties');
        }
    }

}
