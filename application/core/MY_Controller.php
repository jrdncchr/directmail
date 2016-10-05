<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    protected $user;

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
        $this->user = $this->session->userdata("user");
        if ($logged) {
            $this->_checkAuth();
        }
        $this->data['user'] = $this->user;
        $this->data['title'] = $this->title;
        $this->data['description'] = $this->description;
        $this->data['keywords'] = $this->keywords;
        $this->data['author'] = $this->author;
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

}

?>