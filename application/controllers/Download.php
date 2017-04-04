<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Download extends MY_Controller {

    function __construct()
    {
        parent::__construct(true);
        $this->data['page_title'] = "Downloads";
    }

    public function upload()
    {
        // $this->load->model('global_model');
        // $progress_id = $this->global_model->insert_temp_data(
        //     $this->logged_user->company_id,
        //     [
        //         'user_id' => $this->logged_user->id,
        //         'k' => 'bulk_import_rows_count',
        //         'v' => 0
        //     ]
        // );
        session_write_close();
        for($i=1;$i<10;$i++){
            file_put_contents(FCPATH . 'temp/dm_import_progress.txt', "done {$i} iterations", LOCK_EX);
            sleep(2);
            
        }

        echo "done.<br/>\n";
    }
    public function check()
    {
        echo file_get_contents(FCPATH . 'temp/dm_import_progress.txt');
        
    }

    public function download($type, $save = 0)
    {
        $properties = array();
        $filter = $this->session->userdata('list_filter');
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
            $where['status != '] = 'duplicate';
            $properties = $this->property_model->get_properties($this->logged_user->company_id, $where, $filter);
            if ($save == 1 && sizeof($properties) > 0) {
                $history = [
                    'type' => $type,
                    'filters' => json_encode($filter),
                    'uploaded_by_user_id' => $this->logged_user->id,
                    'company_id' => $this->logged_user->company_id
                ];
                $this->load->model('download_model');
                $this->download_model->save_download_history($history, $properties);
            }
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
                    $properties = $this->property_model->get_properties(
                        $this->logged_user->company_id, 
                        $where, 
                        $filter
                    );
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
                    $properties = $this->property_model->get_properties(
                        $this->logged_user->company_id, 
                        $where, 
                        $filter
                    );
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

    public function history()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $action = $this->input->post('action');
            switch ($action) {
                case 'list':
                    $this->load->model('download_model');
                    $history = $this->download_model->get_download_history($this->logged_user->company_id);
                    echo json_encode(array('data' => $history));
                    break;
                default:
                    echo json_encode(array('result' => false, 'message' => 'Action not found.'));
            }
        } else {
            $this->_renderL('download/history');
        }
    }

}
