<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends MY_Controller {

    function __construct()
    {
        parent::__construct(true);
        $this->data['page_title'] = "Settings";
    }

    public function abbreviations($page = "index")
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $action = $this->input->post('action');
            $this->load->model('setting_model');
            switch ($action) {
            	case 'list':
                    $type = $this->input->post('type');
                    $abbr = $this->setting_model->get_abbreviations($this->logged_user->company_id, $type);
                    echo json_encode(array('data' => $abbr));
                    break;
                case 'save':
                    $abbr = $this->input->post('abbr');
                    $abbr['created_by'] = $this->logged_user->id;
                    $abbr['company_id'] = $this->logged_user->company_id;
                    $result = $this->setting_model->save_abbreviation($abbr);
                    echo json_encode($result);
                    break;
                case 'delete' :
                	$id = $this->input->post('id');
                	$result = $this->setting_model->delete_abbreviation(array(
                		'id' => $id,
                		'company_id' => $this->logged_user->company_id
            		));
            		echo json_encode($result);
                	break;
                default:
                    echo json_encode(array('result' => false, 'message' => 'Action not found.'));
            }
        } else {
        	$this->_renderL('settings/abbreviations');
        }
    }

    public function list_priority()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $action = $this->input->post('action');
            switch ($action) {
                case 'save':
                    $order = $this->input->post('order');
                    $this->load->model('list_model');
                    $result = $this->list_model->bulk_update($this->logged_user->company_id, $order);
                    echo json_encode($result);
                    break;
                default:
                    echo json_encode(array('result' => false, 'message' => 'Action not found.'));
            }
        } else {
            $this->load->model('list_model');
            $this->data['lists'] = $this->list_model->get_list_by_priority($this->logged_user->company_id);
            $this->_renderL('settings/list_priority');
        }
    }

}
