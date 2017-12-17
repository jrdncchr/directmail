<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Management extends MY_Controller {

    function __construct()
    {
        parent::__construct(true);
        $this->data['page_title'] = "Management";
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
                    $this->session->unset_userdata('role_module_permissions');
                    echo json_encode($result);
                    break;
                case 'save_list_permissions' :
                    $role_id = $this->input->post('role_id');
                    $list_permissions = $this->input->post('list_permissions');
                    $result = $this->role_model->save_list_permissions($role_id, $list_permissions);
                    $this->session->unset_userdata('role_list_permissions');
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
                        $this->data['list_permissions'] = $this->role_model
                            ->get_list_permissions($role->id, $this->logged_user->company_id);
                        $this->_renderL('management/roles_form');
                    } else {
                        $this->_renderL('management/roles_form');
                    }
                    break;
                default:
                    $this->show_404();
            }
        }
    }

    public function users($sub = 'index', $id = 0, $user_page = "")
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
                    $result = $this->user_model->delete($user_id, $this->logged_user->company_id);
                    echo json_encode($result);
                    break;
                case 'change_password' :
                    $user_id = $this->input->post('user_id');
                    $new_password = $this->input->post('new_password');
                    $result = $this->user_model->change_password($user_id, $new_password);
                    echo json_encode($result);
                    break;
                case 'save_module_permissions' :
                    $user_id = $this->input->post('user_id');
                    $module_permissions = $this->input->post('module_permissions');
                    $result = $this->user_model->save_module_permissions($user_id, $module_permissions);
                    $this->session->unset_userdata('user_module_permissions');
                    echo json_encode($result);
                    break;
                case 'save_list_permissions' :
                    $user_id = $this->input->post('user_id');
                    $list_permissions = $this->input->post('list_permissions');
                    $result = $this->user_model->save_list_permissions($user_id, $list_permissions);
                    $this->session->unset_userdata('user_list_permissions');
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
                            if ($user_page == "permissions") {
                                $this->data['module_permissions'] = $this->user_model->get_module_permissions($user->id);
                                $this->data['list_permissions'] = $this->user_model->get_list_permissions($user->id, $this->logged_user->company_id);
                                $this->_renderL('management/users_permissions');
                            } else {
                                $this->_renderL('management/users_form');
                            }
                        } else {
                            show_404();
                        }
                    } else {
                        $this->_renderL('management/users_form');
                    }
                    break;
                case 'login_user' :
                    if ($this->_checkModulesChildPermission(21, 22, 'update')) {
                        $this->session->sess_destroy();
                        $this->load->model('user_model');
                        $result = $this->user_model->login_by_user_id($this->logged_user->company_id, $id);
                        if ($result['success']) {
                        } else {
                            $this->session->set_flashdata('message', create_alert_message($result));
                            $this->_render('auth/login');
                        }

                    }
                     $this->show_404();
                    break;
                default:
                    $this->show_404();
            }
        }
    }

    public function companies($sub = "index", $id = 0)
    {
        if ($this->logged_user->super_admin) {
            if ($this->input->server('REQUEST_METHOD') == 'POST') {
                $action = $this->input->post('action');
                switch ($action) {
                    case 'list' :
                        $this->load->model('company_model');
                        $companies = $this->company_model->get(array('company.deleted' => 0));
                        echo json_encode(array('data' => $companies));
                        break;
                    case 'save' :
                        $form = $this->input->post('form');
                        $this->load->model('company_model');
                        if (isset($form['company']['id'])) {
                            $result = $this->company_model->save($form['company']);
                        } else {
                            $result = $this->company_model->create($form['company'], $form['user']);
                            if ($result['success']) {
                                $result['message'] = 'Saving company successful! <br />Company ID: ' 
                                    . $result['company_id'] . '<br /> User ID: ' 
                                    . $result['user_id'];
                                $this->session->set_flashdata('message', create_alert_message($result));
                            }
                        }
                        echo json_encode($result);
                        break;
                    case 'delete' :
                        $this->load->model('company_model');
                        $company_id = $this->input->post('company_id');
                        if ($company_id) {
                            $company = ['id' => $company_id, 'deleted' => 1];
                            $result = $this->company_model->save($company);
                        } else {
                            $result = array('success' => false);
                        }
                        echo json_encode($result);
                        break;
                    case 'users':
                        $this->load->model('user_model');
                        $company_id = $this->input->post('company_id');
                        $users = $this->user_model->get(
                        array('u.company_id' => $company_id));
                        foreach ($users as $u) {
                            $u->name = $u->last_name . ", " . $u->first_name;
                        }
                        echo json_encode(array('data' => $users));
                        break;
                }
            } else {
                switch ($sub) {
                    case 'index' :
                        $this->_renderL('management/companies');
                        break;
                    case 'form' :
                        if ($id > 0) {
                            $this->load->model('company_model');
                            $company = $this->company_model->get(array('company.id' => $id), false);
                            $company_form = [
                                'company' =>[
                                    'id' => $company->id,
                                    'name' => $company->name,
                                    'company_key' => $company->company_key
                                ],
                                'user' => [
                                    'first_name' => $company->first_name,
                                    'last_name' => $company->last_name,
                                    'email' => $company->email
                                ]
                            ];
                            $this->data['company'] = $company_form;
                        }
                        $this->_renderL('management/companies_form');
                        break;
                    case 'login_user': 
                        $this->session->unset_userdata('user');
                        $this->session->unset_userdata('role_module_permissions');
                        $this->session->unset_userdata('user_module_permissions');

                        $this->load->model('user_model');
                        $user_company_id = $this->user_model->get(['u.id' => $id], false)->company_id;
                        $logged = $this->user_model->login_by_user_id($user_company_id, $id);
                        if ($logged['success']) {
                            redirect(base_url() . "login");
                        } else {
                            echo $logged['message'];
                        }
                        break;
                }
            }
            
        } else {
            $this->show_404();
        }
    }

    public function similar_address_generator()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $result = array('success' => false);
            $action = $this->input->post('action');
            switch ($action) {
                case 'get_similar_addresses' :
                    $addr = $this->input->post('addr');
                    $this->load->model('property_model');
                    $similar_address = $this->property_model->generate_similar_address($addr, $this->logged_user->company_id);
                    echo json_encode($similar_address);
                    break;
                default :
                    echo json_encode($result);
            }
        } else {
            $this->_renderL('management/similar_address_generator');
        }
    }

    public function inserted_properties_counter()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $action = $this->input->post('action');
            $this->load->model('list_model');
            switch ($action) {
                case 'list':
                    $filter = $this->input->post('filter');
                    if (!isset($filter['date_range']) || $filter['date_range'] === '') {
                        $date_range = get_start_and_end_date_current_month();
                        $filter['date_range'] = $date_range['start'] . ' - ' . $date_range['end'];
                    }
                    $list = $this->list_model->get_list_properties_count($this->logged_user->company_id, $filter);
                    echo json_encode(array('data' => $list));
                    break;
                default:
                    echo json_encode(array('result' => false, 'message' => 'Action not found.'));
            }
        } else {
            $date_range = get_start_and_end_date_current_month();
            $this->data['current_date_range'] = $date_range['start'] . ' - ' . $date_range['end'];
            $this->_renderL('management/inserted_properties_counter');
        }
    }

    public function backup_and_restore()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $action = $this->input->post('action');
            $this->load->model('backup_model');
            switch ($action) {
                case 'list':
                    $list = $this->backup_model->get();
                    echo json_encode(array('data' => $list));
                    break;
                case 'backup':
                    $result = $this->backup_model->backup($this->logged_user->id);
                    echo json_encode($result);
                    break;
                case 'restore':
                    $id = $this->input->post('id');
                    $result = $this->backup_model->restore($id);
                    echo json_encode($result);
                    break;
                case 'delete':
                    $id = $this->input->post('id');
                    $result = $this->backup_model->delete($id);
                    echo json_encode($result);
                    break;
                default:
                    echo json_encode(array('result' => false, 'message' => 'Action not found.'));
            }
        } else {
            $this->_renderL('management/backup_and_restore');
        }
    }

    public function user_logs()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $action = $this->input->post('action');
            $this->load->model('user_model');
            switch ($action) {
                case 'list':
                    $filter = $this->input->post('filter');
                    $list = $this->user_model->get_user_logs($filter);
                    echo json_encode(array('data' => $list));
                    break;
                default:
                    echo json_encode(array('result' => false, 'message' => 'Action not found.'));
            }
        } else {
            $this->_renderL('management/user_logs');
        }
    }

}
