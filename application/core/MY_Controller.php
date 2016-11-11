<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    protected $logged_user;
    protected $module_permissions;
    protected $list_category_permissions;
    protected $list_permissions;


    // Page resources
    protected $js = array();
    protected $css = array();
    protected $bower = array();

    // Page Info
    protected $title = "Direct Mail";
    protected $description = "Direct Mail";
    protected $keywords = "Direct Mail";
    protected $author = "Danero";

    // Page data
    protected $data = array();

    function __construct($logged = false)
    {
        parent::__construct();
        $this->logged_user = $this->session->userdata('user');
        if ($logged) {
            $this->_checkAuth();
            $this->_initializeSecrets();
            $this->_initializePermissions();

            $this->data['logged_user'] = $this->logged_user;
        }

        $this->data['title'] = $this->title;
        $this->data['description'] = $this->description;
        $this->data['keywords'] = $this->keywords;
        $this->data['author'] = $this->author;
        $this->data['mc'] = $this;
    }

    public function _initializeSecrets()
    {
        $this->load->model('global_model');
        $secrets = $this->global_model->get_secret();
        foreach ($secrets as $s) {
            defined("$s->k") OR define("$s->k", $s->v);
        }
        $this->session->set_userdata('initialized_secrets', true);
    }

    public function _initializePermissions()
    {
        /*
         * Module Permissions
         */
        $role_module_permissions = $this->session->userdata('role_module_permissions');
        if (!$role_module_permissions) {
            if ($this->logged_user->role_id > 0) {
                $this->load->model('role_model');
                $role_module_permissions = $this->role_model->get_module_permissions($this->logged_user->role_id);
                $role_module_permissions = $this->_objectToArrayById($role_module_permissions);
                $this->session->set_userdata('role_module_permissions', $role_module_permissions);
            } else {
                $role_module_permissions = array();
            }
        }
        $user_module_permissions = $this->session->userdata('user_module_permissions');
        if (!$user_module_permissions) {
            $this->load->model('user_model');
            $user_module_permissions = $this->user_model->get_module_permissions($this->logged_user->id);
            $user_module_permissions = $this->_objectToArrayById($user_module_permissions);
            $this->session->set_userdata('user_module_permissions', $user_module_permissions);
        }
        $module_permissions = $this->_arrayMergeById($role_module_permissions, $user_module_permissions);
        $this->module_permissions = $module_permissions;
        $this->data['module_permissions'] = $module_permissions;

        /*
         * List Category Permissions
         */
        $role_list_category_permissions = $this->session->userdata('role_list_category_permissions');
        if (!$role_list_category_permissions) {
            if ($this->logged_user->role_id > 0) {
                foreach ($role_module_permissions as $m) {
                    if ($m->code == "list") {
                        if ($m->retrieve_action == 1) {
                            $role_list_category_permissions = $this->role_model->get_list_category_permissions($this->logged_user->role_id, $this->logged_user->company_id);
                            $role_list_category_permissions = $this->_objectToArrayById($role_list_category_permissions);
                            $this->session->set_userdata('role_list_category_permissions', $role_list_category_permissions);
                        }
                        break;
                    }
                }
            }  else {
                $role_list_category_permissions = array();
            }
        }
        $user_list_category_permissions = $this->session->userdata('user_list_category_permissions');
        if (!$user_list_category_permissions) {
            foreach ($user_module_permissions as $m) {
                if ($m->code == "list") {
                    if ($m->retrieve_action == 1) {
                        $user_list_category_permissions = $this->user_model->get_list_category_permissions($this->logged_user->id, $this->logged_user->company_id);
                        $user_list_category_permissions = $this->_objectToArrayById($user_list_category_permissions);
                        $this->session->set_userdata('user_list_category_permissions', $user_list_category_permissions);
                    }
                    break;
                }
            }
        }
        $list_category_permissions = $this->_arrayMergeById($role_list_category_permissions, $user_list_category_permissions);
        $this->list_category_permissions = $list_category_permissions;
        $this->data['list_category_permissions'] = $list_category_permissions;

        /*
         * List Permission
         */
        $role_list_permissions = $this->session->userdata('role_list_permissions');
        if (!$role_list_permissions) {
            if ($this->logged_user->role_id > 0) {
                $this->load->model('role_model');
                $role_list_permissions = $this->role_model->get_list_permissions($this->logged_user->role_id, $this->logged_user->company_id);
                $role_list_permissions = $this->_objectToArrayById($role_list_permissions);
                $this->session->set_userdata('role_list_permissions', $role_list_permissions);
            } else {
                $role_list_permissions = array();
            }
        }
        $user_list_permissions = $this->session->userdata('user_list_permissions');
        if (!$user_list_permissions) {
            $this->load->model('user_model');
            $user_list_permissions = $this->user_model->get_list_permissions($this->logged_user->id, $this->logged_user->company_id);
            $user_list_permissions = $this->_objectToArrayById($user_list_permissions);
            $this->session->set_userdata('user_list_permissions', $user_list_permissions);
        }
        $list_permissions = $this->_permissionArrayMergeById($role_list_permissions, $user_list_permissions);
        $this->list_permissions = $list_permissions;
        $this->data['list_permissions'] = $list_permissions;
    }

    public function _checkModulePermission($id, $action)
    {
        $action .= "_action";
        if (isset($this->module_permissions[$id]->$action)) {
            if (filter_var($this->module_permissions[$id]->$action, FILTER_VALIDATE_BOOLEAN)) {
                return true;
            }
        }
        return false;
    }

    public function _checkListCategoryPermission($id, $action)
    {
        $action .= "_action";
        if (isset($this->list_category_permissions[$id]->$action)) {
            if (filter_var($this->list_category_permissions[$id]->$action, FILTER_VALIDATE_BOOLEAN)) {
                return true;
            }
        }
        return false;
    }

    public function _checkListPermission($id, $action)
    {
        $action .= "_action";
        if (isset($this->list_permissions[$id]->$action)) {
            if (filter_var($this->list_permissions[$id]->$action, FILTER_VALIDATE_BOOLEAN)) {
                return true;
            }
        }
        return false;
    }

    public function _checkAuth()
    {
        $user = $this->session->userdata('user');
        if (null == $user) {
            redirect(base_url());
        }
        $this->user = $user;
    }

    public function _objectToArrayById($data)
    {
        $newArray = [];
        foreach ($data as $d) {
            $newArray[$d->_id] = $d;
        }
        return $newArray;
    }

    function _arrayMergeById($array1, $array2) {
        $final_array = $array1;
        foreach ($array2 as $k2 => $v2) {
            $add = true;
            foreach ($array1 as $k1 => $v1) {
                if ($k2 == $k1) {
                    $add = false;
                    break;
                }
            }
            if ($add) {
                $final_array[$k2] = $v2;
            }
        }
        return $final_array;
    }

    function _permissionArrayMergeById($array1, $array2) {
        $final_array = $array1;
        foreach ($array2 as $k2 => $v2) {
            $add = true;
            foreach ($array1 as $k1 => $v1) {
                if ($k2 == $k1) {
                    $add = false;
                    $v1->create_action = ($v1->create_action == 1 || $v2->create_action == 1) ? 1 : 0;
                    $v1->retrieve_action = ($v1->retrieve_action == 1 || $v2->retrieve_action == 1) ? 1 : 0;
                    $v1->update_action = ($v1->update_action == 1 || $v2->update_action == 1) ? 1 : 0;
                    $v1->delete_action = ($v1->delete_action == 1 || $v2->delete_action == 1) ? 1 : 0;
                    $final_array[$k1] = $v1;
                    break;
                }
            }
            if ($add) {
                $final_array[$k2] = $v2;
            }
        }
        return $final_array;
    }


    public function _render($view)
    {
        $data = $this->data;
        $data['css'] = $this->css;
        $data['js'] = $this->js;
        $data['bower'] = $this->bower;
        $data['head'] = $this->load->view('templates/head', $data, true);
        $data['content'] = $this->load->view($view, $data, true);
        $this->load->view('templates/skeleton', $data);
    }

    public function _renderL($view)
    {
        $data = $this->data;
        $data['css'] = $this->css;
        $data['js'] = $this->js;
        $data['bower'] = $this->bower;
        $data['head'] = $this->load->view('templates/logged/head', $data, true);

        $this->load->model('module_model');
        $data['modules'] = $this->module_model->get();
        $data['nav'] = $this->load->view('templates/logged/nav', $data, true);
        $data['content'] = $this->load->view($view, $data, true);
        $this->load->view('templates/logged/skeleton', $data);
    }

    public function _renderA($view)
    {
        $data = $this->data;
        $data['css'] = $this->css;
        $data['js'] = $this->js;
        $data['bower'] = $this->bower;
        $data['head'] = $this->load->view('templates/admin/head', $data, true);
        $data['nav'] = $this->load->view('templates/admin/nav', $data, true);
        $data['content'] = $this->load->view('admin/' . $view, $data, true);
        $this->load->view('templates/admin/skeleton', $data);
    }

    public function show_404()
    {
        $this->output->set_status_header('404');
        $this->_render('not_found');
    }

}

?>