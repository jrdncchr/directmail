<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lists extends MY_Controller {

    function __construct()
    {
        parent::__construct(true);
        $this->data['page_title'] = "Lists";
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
                            $this->_renderL('lists/category');
                            return;
                        }
                        break;
                    case 'add' :
                        if ($this->_checkListCategoryPermission($id, 'create')) {
                            echo "OK";
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
                case 'property_list' :
                    $this->load->model('property_model');
                    $lists = $this->property_model->get_list(array(
                        'list_id' => $this->input->post('list_id')));
                    echo json_encode(array('data' => $lists));
                    break;
                case 'check_list_permission' :
                    $list_id = $this->input->post('list_id');
                    if ($this->list_permissions[$list_id]->retrieve_action) {
                        $result['success'] = true;
                    }
                    break;
                case 'save_list' :
                    $list = $this->input->post('list');
                    if (!isset($list['id'])) {
                        $list['created_by'] = $this->logged_user->id;
                        $list['active'] = 1;
                    }
                    $list['company_id'] = $this->logged_user->company_id;
                    $result = $this->list_model->save($list);
                    break;
                case 'delete_list' :
                    $list_id = $this->input->post('list_id');
                    $result = $this->list_model->delete($list_id);
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
                    if ($id == 'new') {
                        $list_category_id = $this->session->userdata('current_list_category_id');
                        if ($list_category_id) {
                            if ($this->_checkListCategoryPermission($list_category_id, 'create')) {
                                    $list = new stdClass();
                                    $list->id = 0;
                                    $list->content = '';
                                $this->data['list'] = $list;
                                $this->data['list_category'] = $this
                                    ->list_category_permissions[$list_category_id];
                                $this->_renderL('lists/list_info');
                                return;
                            }
                        }                        
                    } else {
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
                                $this->_renderL('lists/list_info');
                                return;
                            }
                        }
                    }
                    break;
            }
            $this->show_404();
        }
    }

    public function property($list_id = 0, $sub = "info", $property_id = 0) 
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $action = $this->input->post('action');
            switch ($action) {
                case 'save_property':
                    $this->load->model('property_model');
                    $property = $this->input->post('form');
                    $property['created_by'] = $this->logged_user->id;
                    $result = $this->property_model->save($property);
                    echo json_encode($result);
                    break;
                case 'delete_property':
                    $this->load->model('property_model');
                    $id = $this->input->post('id');
                    $result = $this->property_model->delete($id);
                    echo json_encode($result);
                    break;
                case 'save_comment':
                    $this->load->model('property_model');
                    $comment = array(
                        'property_id' => $this->input->post('property_id'),
                        'comment' => $this->input->post('comment'),
                        'user_id' => $this->logged_user->id,
                        'type' => 'comment'
                    );
                    $result = $this->property_model->save_comment($comment);
                    echo json_encode($result);
                    break;
                case 'get_comments':
                    $this->load->model('property_model');
                    $property_id = $this->input->post('property_id');
                    $result = $this->property_model->get_comment(array('property_id' => $property_id));
                    echo json_encode($result);
                    break;
                default:
                    echo json_encode(array('result' => false, 'message' => 'Action not found.'));
            }
        } else {
            switch ($sub) {
                case 'new':
                case 'info':
                    if ($this->_checkListPermission($list_id, 'retrieve')) {
                        // list
                        $this->load->model('list_model');
                        $this->data['list'] = $this->list_model->get(array(
                                'l.id' => $list_id, 
                                'l.company_id' => $this->logged_user->company_id
                            ), false);
                        // list category
                        $this->data['list_category'] = $this
                            ->list_category_permissions[$this->data['list']->list_category_id];
                        // Property
                        if ($property_id > 0) {
                            $this->load->model('property_model');
                            $this->data['property'] = $this->property_model->get(
                                array('p.id' => $property_id, 'p.list_id' => $list_id), false);
                            $this->data['comments'] = $this->property_model->get_comment(array('property_id' => $property_id));
                        }
                        $this->_renderL('lists/property');
                        return;
                    }
                    break;
                default:
            }
            $this->show_404();
        }
    }

}
