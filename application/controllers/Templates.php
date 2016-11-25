<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Templates extends MY_Controller {

    function __construct()
    {
        parent::__construct(true);
        $this->data['page_title'] = "Templates";
    }

    public function category($id = 0, $sub = "index")
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $result = array('success' => false);
            $action = $this->input->post('action');
            $this->load->model('list_model');
            switch ($action) {
                case 'list' :
                    $lists = $this->list_model->get(array(
                        'list_category_id' => $this->input->post('list_category_id'),
                        'l.company_id' => $this->logged_user->company_id));
                    echo json_encode(array('data' => $lists));
                    break;
                case 'check_list_permission' :
                    $list_id = $this->input->post('list_id');
                    if ($this->list_permissions[$list_id]->retrieve_action) {
                        $result['success'] = true;
                    }
                    echo json_encode($result);
                    break;
                default :
                    echo json_encode($result);
            }
        } else {
            if ($id > 0) {
                $this->session->set_userdata('current_list_category_id', $id);
                switch ($sub) {
                    case 'index' :
                        if ($this->_checkListCategoryPermission($id, 'retrieve')) {
                            $this->data['list_category'] = $this->list_category_permissions[$id];
                            $this->_renderL('templates/category');
                            return;
                        }
                        break;
                }
                $this->show_404();
            } else {
                $this->show_404();
            }
        }
    }

    public function info($id = 0, $sub = "index")
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $result = array('success' => false);
            $action = $this->input->post('action');
            $this->load->model('list_model');
            switch ($action) {
                case 'save_list' :
                    $list = $this->input->post('list');
                    if (!isset($list['id'])) {
                        $list['created_by'] = $this->logged_user->id;
                        $list['company_id'] = $this->logged_user->company_id;
                        $list['active'] = 1;
                    }
                    $result = $this->list_model->save($list);
                    break;
                case 'save_paragraphs' :
                    $list_id = $this->input->post('list_id');
                    $type = $this->input->post('type');
                    $paragraphs = $this->input->post('paragraphs');
                    $result = $this->list_model->save_paragraphs($list_id, $type, $paragraphs);
                    break;
                case 'save_bullet_points' :
                    $list_id = $this->input->post('list_id');
                    $bullet_points = $this->input->post('bullet_points');
                    $result = $this->list_model->save_bullet_points($list_id, $bullet_points);
                    break;
                case 'save_testimonials' :
                    $list_id = $this->input->post('list_id');
                    $testimonials = $this->input->post('testimonials');
                    $result = $this->list_model->save_testimonials($list_id, $testimonials);
                    break;
            }
            if ($action != 'property_list') {
                echo json_encode($result);   
            }
        } else {
            switch ($sub) {
                case 'index' :
                    $this->load->model('list_model');
                    $list = $this->list_model->get(
                        array(
                            'l.id' => $id, 
                            'l.company_id' => $this->logged_user->company_id
                        ), false);
                    if ($list) {
                        if ($this->_checkListPermission($id, 'retrieve')) {
                            // list
                            $this->data['list'] = $list;
                            // list category
                            $this->data['list_category'] = $this
                                ->list_category_permissions[$this->data['list']->list_category_id];
                            // paragraphs
                            $all_paragraphs = $this->list_model->get_paragraphs(array('list_id' => $id));
                            $paragraphs = array(
                                'intro' => array(),
                                'second' => array(),
                                'bbb' => array(),
                                'kim' => array(),
                                'cta' => array(),
                                'ps' => array()
                            );
                            foreach ($all_paragraphs as $p) {
                                 $paragraphs[$p->type][] = $p;
                            }
                            $this->data['paragraphs'] = $paragraphs;
                            // bullet points
                            $this->data['bullet_points'] = $this->list_model
                                ->get_bullet_points(array('list_id' => $id));
                            // bullet points
                            $this->data['testimonials'] = $this->list_model
                                ->get_testimonials(array('list_id' => $id));
                            $this->_renderL('templates/template');
                            return;
                        }
                    }
                break;
            }
            $this->show_404();
        }
    }

    public function mail($sub = 'index', $id = 0)
    {
    	if ($this->_checkModulesChildPermission(MODULE_TEMPLATES_ID, MODULE_MAIL_TEMPLATES_ID, 'retrieve')) {
    		if ($this->input->server('REQUEST_METHOD') == 'POST') {
	            $result = array('success' => false);
	            $action = $this->input->post('action');
	            $this->load->model('template_model');
	            switch ($action) {
	            	case 'list' :
	                    $templates = $this->template_model->get(
	                    	array('company_id' => $this->logged_user->company_id));
	                    echo json_encode(array('data' => $templates));
	                    break;
	                case 'save_mail_template' :
	                    $mail_template = $this->input->post('mail_template');
	                    if (!isset($mail_template['id'])) {
	                        $mail_template['created_by'] = $this->logged_user->id;
	                        $mail_template['company_id'] = $this->logged_user->company_id;
	                    }
	                    $result = $this->template_model->save($mail_template);
	                    break;
	            }
	            if ($action != 'list') {
	                echo json_encode($result);   
	            }
	        } else {
	            switch ($sub) {
	                case 'index' :
	                    $this->_renderL('templates/mail_list');
	                    return;
                    case 'form' :
                        $this->_renderL('templates/mail_form');
                        return;
	                break;
	            }
	            $this->show_404();
	        }
    	} else {
    		$this->show_404();
    	}
    }

    public function test() 
    {
		$template_path = FCPATH . 'resources\templates\template1.docx';
    	$templateProcessor = new PhpOffice\PhpWord\TemplateProcessor($template_path);
		$test = $templateProcessor->setValue('Name', 'John Doe');
		$templateProcessor->setValue(array('City', 'Street'), array('Detroit', '12th Street'));

		header("Content-Description: File Transfer");
		header('Content-Disposition: attachment; filename=template.docx');
		header('Content-Type: application/octet-stream');

		$templateProcessor->saveAs('php://output');
    }

    public function test2()
    {
    	$html = '
    		<p>${name}</p>
    	';
    	$this->load->model('template_model');
    	$this->template_model->generate_document_by_html($html, 'test123');
    }

}
