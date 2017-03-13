<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approval extends MY_Controller {

    function __construct()
    {
        parent::__construct(true);
        $this->data['page_title'] = "Approval";
    }

    public function properties($id = 0)
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $action = $this->input->post('action');
            switch ($action) {
            	case 'property_list':
        	 	case 'list':
                    $filter = $this->input->post('filter');
                    $this->load->library('property_library');
                    $filter = $this->property_library->setup_search_filter($filter);
                    $this->load->model('property_model');
                    $where = array(
                        'p.status' => 'pending', 
                        'p.deleted' => 0
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
                case 'save_property':
                    $this->load->model('property_model');
                    $property = $this->input->post('form');
                    $property['created_by'] = $this->logged_user->id;
                    $result = $this->property_model->save($property);
                    echo json_encode($result);
                    break;
                default:
                    echo json_encode(array('result' => false, 'message' => 'Action not found.'));
            }
        } else {
            if ($id > 0) {

            } else {
                $this->load->model('list_model');
                $this->data['lists'] = $this->list_model->get(array('l.company_id' => $this->logged_user->company_id));
            	$this->_renderL('approval/properties');
            }
        }
    }

    public function duplicates($id = 0)
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $action = $this->input->post('action');
            switch ($action) {
                case 'property_list':
                    $this->load->model('property_model');
                    $lists = $this->property_model->get_duplicate_properties(
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
                case 'confirm_replacement':
                    $this->load->library('property_library');
                    $result = $this->property_library->confrim_replacement_action(
                        $this->input->post('replacement_action'),
                        $this->input->post('property_id'),
                        $this->input->post('target_property_id'),
                        $this->input->post('comment'));
                    echo json_encode($result);
                    break;
                default:
                    echo json_encode(array('result' => false, 'message' => 'Action not found.'));
            }
        } else {
            if ($id > 0) {

            } else {
                 $this->_renderL('approval/duplicates');
            }
        }
    }

}
