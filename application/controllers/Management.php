<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Management extends MY_Controller {

    function __construct()
    {
        parent::__construct(true);
    }

    public function roles($sub = "index", $id = 0)
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $result = array('success' => false);
            $action = $this->input->post('action');
            switch ($action) {
                case 'list' :
                    $this->load->model('role_model');
                    $roles = $this->role_model->get(array('company_id' => $this->user->company_id));
                    echo json_encode(array('data' => $roles));
                    break;
                case 'save_role_details' :
                    $this->load->model('role_model');
                    $role = $this->input->post('form');
                    $role['company_id'] = $this->user->company_id;
                    $result = $this->role_model->save($role);
                    echo json_encode($result);
                    break;
                default :
                    echo json_encode($result);
            }
        } else {
            switch ($sub) {
                case 'index' :
                    $this->_renderL('management/roles');
                    break;
                case 'form' :
                    if ($id > 0) {
                        $this->load->model('role_model');
                        $role = $this->role_model->get(array('id' => $id, 'company_id' => $this->user->company_id), false);
                        $this->data['role'] = $role;
                        $this->data['permission'] = $this->role_model->get_permissions($role->id);
                        $this->_renderL('management/roles_form');
                    } else {
                        $this->_renderL('management/roles_form');
                    }
                    break;
                    break;
                default:
                    show_404();
            }
        }
    }
}
