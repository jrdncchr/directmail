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
            $this->load->model('role_model');
            switch ($action) {
                case 'list' :
                    $roles = $this->role_model->get(array('company_id' => $this->logged_user->company_id));
                    echo json_encode(array('data' => $roles));
                    break;
                case 'save_role_details' :
                    $role = $this->input->post('form');
                    $role['company_id'] = $this->logged_user->company_id;
                    $result = $this->role_model->save($role);
                    echo json_encode($result);
                    break;
                case 'save_module_permissions' :
                    $role_id = $this->input->post('role_id');
                    $module_permissions = $this->input->post('module_permissions');
                    $result = $this->role_model->save_module_permissions($role_id, $module_permissions);
                    echo json_encode($result);
                    break;
                case 'save_list_category_permissions' :
                    $role_id = $this->input->post('role_id');
                    $list_category_permissions = $this->input->post('list_category_permissions');
                    $result = $this->role_model->save_list_category_permissions($role_id, $list_category_permissions);
                    echo json_encode($result);
                    break;
                case 'delete' :
                    $role_id = $this->input->post('role_id');
                    $result = $this->role_model->delete($role_id, $this->logged_user->company_id);
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
                        $role = $this->role_model->get(
                            array('id' => $id, 'company_id' => $this->logged_user->company_id), false);
                        $this->data['role'] = $role;
                        $this->data['module_permissions'] = $this->role_model->get_module_permissions($role->id);
                        $this->data['list_category_permissions'] = $this->role_model->get_list_category_permissions($role->id, $this->logged_user->company_id);
                        $this->_renderL('management/roles_form');
                    } else {
                        $this->_renderL('management/roles_form');
                    }
                    break;
                default:
                    show_404();
            }
        }
    }

    public function list_categories($sub = 'index', $id = 0)
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $result = array('success' => false);
            $action = $this->input->post('action');
            $this->load->model('list_category_model');
            switch ($action) {
                case 'list' :
                    $list_category = $this->list_category_model->get(
                        array('company_id' => $this->logged_user->company_id));
                    echo json_encode(array('data' => $list_category));
                    break;
                case 'save' :
                    $list_category = $this->input->post('form');
                    $list_category['company_id'] = $this->logged_user->company_id;
                    $result = $this->list_category_model->save($list_category);
                    echo json_encode($result);
                    break;
                case 'delete' :
                    $list_category_id = $this->input->post('id');
                    $result = $this->list_category_model->delete($list_category_id, $this->logged_user->company_id);
                    echo json_encode($result);
                    break;
                default :
                    echo json_encode($result);
            }
        } else {
            switch ($sub) {
                case 'index' :
                    $this->_renderL('management/list_categories');
                    break;
                case 'form' :
                    if ($id > 0) {
                        $this->load->model('list_category_model');
                        $list_category = $this->list_category_model->get(
                            array('id' => $id, 'company_id' => $this->logged_user->company_id), false);
                        $this->data['list_category'] = $list_category;
                        $this->_renderL('management/list_categories_form');
                    } else {
                        $this->_renderL('management/list_categories_form');
                    }
                    break;
                default:
                    show_404();
            }
        }
    }

    public function users($sub = 'index', $id = 0)
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $result = array('success' => false);
            $this->load->model('user_model');
            $action = $this->input->post('action');
            switch ($action) {
                case 'list' :
                    $users = $this->user_model->get(
                        array('u.company_id' => $this->logged_user->company_id));
                    foreach ($users as $u) {
                        $u->name = $u->last_name . ", " . $u->first_name;
                    }
                    echo json_encode(array('data' => $users));
                    break;
                case 'save' :
                    $user = $this->input->post('form');
                    $user['company_id'] = $this->logged_user->company_id;
                    if (isset($user['id']) && $user['id'] != '') {
                        $result = $this->user_model->save($user);
                    } else {
                        $user['company_name'] = $this->logged_user->company->name;
                        $result = $this->user_model->register($user, true);
                    }
                    echo json_encode($result);
                    break;
                case 'delete' :
                    $user_id = $this->input->post('user_id');
                    $result = $this->user_model->save(array('deleted' => 1, 'id' => $user_id));
                    echo json_encode($result);
                    break;
                case 'change_password' :
                    $user_id = $this->input->post('user_id');
                    $new_password = $this->input->post('new_password');
                    $result = $this->user_model->change_password($user_id, $new_password);
                    echo json_encode($result);
                    break;
                default :
                    echo json_encode($result);
            }
        } else {
            switch ($sub) {
                case 'index' :
                    $this->_renderL('management/users');
                    break;
                case 'form' :
                    $this->load->model('role_model');
                    $this->data['roles'] = $this->role_model->get(array('company_id' => $this->logged_user->company_id));
                    if ($id > 0) {
                        $this->load->model('user_model');
                        $user = $this->user_model->get(
                            array('u.id' => $id, 'u.company_id' => $this->logged_user->company_id), false);
                        if ($user) {
                            $this->data['user'] = $user;
                            $this->_renderL('management/users_form');
                        } else {
                            show_404();
                        }
                    } else {
                        $this->_renderL('management/users_form');
                    }
                    break;
                default:
                    show_404();
            }
        }
    }

}
