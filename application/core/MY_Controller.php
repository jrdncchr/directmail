<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    protected $logged_user;
    protected $list_category_permissions;
    protected $module_permissions;

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

            $initialized_secrets = $this->session->userdata('initialized_secrets');
            if (!$initialized_secrets) {
                $this->_initializeSecrets();
            }

            $this->_initializePermissions();

            $this->data['logged_user'] = $this->logged_user;
        }

        $this->data['title'] = $this->title;
        $this->data['description'] = $this->description;
        $this->data['keywords'] = $this->keywords;
        $this->data['author'] = $this->author;
    }

    public function _initializeSecrets()
    {
        $this->load->model('global_model');
        $secrets = $this->global_model->get_secret();
        foreach ($secrets as $s) {
            defined($s->k) OR define($s->k, $s->v);
        }
        $this->session->set_userdata('initialized_secrets', true);
    }

    public function _initializePermissions()
    {
        $this->load->model('role_model');
        $module_permissions = $this->session->userdata('module_permissions');
        if (!$module_permissions) {
            $this->load->model('role_model');
            $module_permissions = $this->role_model->get_module_permissions($this->logged_user->role_id);
            $module_permissions = $this->_objectToArrayById($module_permissions);
            $this->session->set_userdata('module_permissions', $module_permissions);
        }
        $this->module_permissions = $module_permissions;
        $this->data['sb_module_permissions'] = $module_permissions;

        $list_category_permissions = $this->session->userdata('list_category_permissions');
        if (!$list_category_permissions) {
            foreach ($module_permissions as $m) {
                if ($m->code == "list") {
                    if ($m->retrieve_action == 1) {
                        $list_category_permissions = $this->role_model->get_list_category_permissions($this->logged_user->role_id, $this->logged_user->company_id);
                        $list_category_permissions = $this->_objectToArrayById($list_category_permissions);
                        $this->session->set_userdata('list_category_permissions', $list_category_permissions);
                    }
                    break;
                }

            }
        }
        $this->list_category_permissions = $list_category_permissions;
        $this->data['sb_list_category_permissions'] = $list_category_permissions;
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

}

?>