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
            	 	$this->load->model('property_model');
                    $lists = $this->property_model->get_pending_properties(
                    	$this->logged_user->company_id);
                    echo json_encode(array('data' => $lists));
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
            	 $this->_renderL('approval/properties');
            }
        }
    }

}
