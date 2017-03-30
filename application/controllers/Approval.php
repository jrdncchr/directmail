<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approval extends MY_Controller {

    function __construct()
    {
        parent::__construct(true);
        $this->data['page_title'] = "Approval";
    }
    
    public function duplicates($id = 0)
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $action = $this->input->post('action');
            switch ($action) {
                case 'list':
                    $filter = $this->input->post('filter');
                    $this->load->library('property_library');
                    $filter = $this->property_library->setup_search_filter($filter);
                    $this->load->model('property_model');
                    $lists = $this->property_model->get_duplicate_properties($filter, 
                        $this->logged_user->company_id);
                    foreach ($lists as $l) {
                        $l->url = "";
                        if ($this->_checkListPermission($l->list_id, 'retrieve')) {
                            $l->url = base_url() . 'lists/property/' . $l->list_id . '/info/' . $l->id;
                        }
                        if ($this->_checkListPermission($l->target_list_id, 'retrieve')) {
                            $l->target_url = base_url() . 'lists/property/' . $l->target_list_id . '/info/' . $l->target_id;
                        }
                    }
                    echo json_encode(array('data' => $lists));
                    break;
                case 'replace_action':
                    $replace_action = $this->input->post('replace_action');
                    $property = $this->input->post('property');
                    $target_property_id = $property['target_id'];
                    unset($property['target_id']);
                    unset($property['target_list_id']);
                    unset($property['target_list_name']);
                    unset($property['target_property_address']);
                    unset($property['target_url']);
                    unset($property['url']);
                    unset($property['list_name']);
                    $this->load->library('property_library');
                    $result = $this->property_library->confrim_replacement_action(
                        $replace_action,
                        $property,
                        $target_property_id);
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
            $this->data['lists'] = $this->dm_library->getListsForSelect2($this->logged_user->company_id);
            $this->data['statuses'] = $this->dm_library->getStatusesForSelect2();
            $this->_renderL('approval/duplicates');
        }
    }

}
