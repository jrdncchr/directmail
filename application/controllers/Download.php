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
            $where = [
                'p.deleted' => 0,
                'p.active' => 1
            ];
            switch ($type) {
                case 'downloads_letters' :
                case 'downloads_post_letters' :
                    $filter['status_not_in'] = ['draft', 'duplicate'];
                    break;
            }
            $properties = $this->property_model->get_properties($this->logged_user->company_id, $where, $filter);
            if ($save == 1 && sizeof($properties) > 0) {
                $history = [
                    'type' => str_replace('_', '-', $type),
                    'filters' => json_encode($filter),
                    'downloaded_by_user_id' => $this->logged_user->id,
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
                        'p.deleted' => 0
                    );
                    $filter['status_not_in'] = ['draft', 'duplicate'];
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

    public function post_letters()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $action = $this->input->post('action');
            switch ($action) {
                case 'list':
                    $filter = $this->input->post('filter');
                    $filter['post_letters'] = true;
                    $this->load->library('property_library');
                    $filter = $this->property_library->setup_search_filter($filter);
                    $this->load->model('property_model');
                    $where = array(
                        'p.deleted' => 0
                    );
                    $filter['status_not_in'] = ['draft', 'duplicate'];
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
            $this->_renderL('download/post_letters');
        }
    }

    public function history()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $action = $this->input->post('action');
            $this->load->model('download_model');
            switch ($action) {
                case 'list':
                    $filter = $this->input->post('filter');
                    $history = $this->download_model->get_download_history($this->logged_user->company_id, $filter);
                    echo json_encode(array('data' => $history));
                    break;
                case 'update' :
                    $history = $this->input->post('history');
                    $history['company_id'] = $this->logged_user->company_id;
                    $result = $this->download_model->update_download_history($history);
                    echo json_encode($result);
                    break;
                case 'delete' :
                    $id = $this->input->post('id');
                    $company_id = $this->logged_user->company_id;
                    $result = $this->download_model->delete_download_history($id, $company_id);
                    echo json_encode($result);
                    break;
                default:
                    echo json_encode(array('result' => false, 'message' => 'Action not found.'));
            }
        } else {
            $this->load->model('user_model');
            $where = [
                'company_id' => $this->logged_user->company_id, 
                'deleted' => 0,
                'confirmed' => 1
            ];
            $this->data['users'] = $this->user_model->get_id_name($where);
            $this->load->library('dm_library');
            $this->data['from_modules'] = $this->dm_library->getFromModulesForDownloadHistory();
            $this->_renderL('download/history');
        }
    }

}
