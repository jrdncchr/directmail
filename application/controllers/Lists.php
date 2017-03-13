<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lists extends MY_Controller {

    function __construct()
    {
        parent::__construct(true);
        $this->data['page_title'] = "Lists";
    }

    public function index()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $result = array('success' => false);
            $action = $this->input->post('action');
            $this->load->model('list_model');
            switch ($action) {
                case 'list' :
                    $lists = $this->list_model->get(array(
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
            $this->_renderL('lists/index');
        }
        
    }

    public function info($id = 0, $sub = "index")
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST' && $this->input->is_ajax_request()) {
            $result = array('success' => false);
            $action = $this->input->post('action');
            $this->load->model('list_model');
            switch ($action) {
                case 'property_list':
                    $filter = $this->input->post('filter');
                    $filter['list'] = $this->input->post('list_id');
                    $this->load->library('property_library');
                    $filter = $this->property_library->setup_search_filter($filter);
                    $this->load->model('property_model');
                    $where = array(
                        'p.deleted' => 0,
                        'p.active' => 1,
                        'p.status !=' => 'duplicate'
                    );
                    $properties = $this->property_model->get_properties($this->logged_user->company_id, $where, $filter);
                    foreach ($properties as $p) {
                        $p->url = "";
                        if ($this->_checkListPermission($p->list_id, 'retrieve')) {
                            $p->url = base_url() . 'lists/property/' . $p->list_id . '/info/' . $p->id;
                        }
                    }
                    echo json_encode(array('data' => $properties));
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
                    if ($result['success']) {
                        $adjust = $this->input->post('adjust');
                        if (filter_var($adjust, FILTER_VALIDATE_BOOLEAN)) {
                            $this->load->model('property_model');
                            $adjust_result = $this->property_model->adjust_mailing($list);
                            $result['message'] = "Save successful and the properties mailing dates are now adjusted!";
                        } else {
                            $result['message'] = "Save successful!";
                        }
                        
                        $this->session->set_flashdata('message', create_alert_message($result));
                    }
                    break;
                case 'delete_list' :
                    $list_id = $this->input->post('list_id');
                    $result = $this->list_model->delete($list_id, $this->logged_user->company_id);
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
                case 'replace_action':
                    $replace_action = $this->input->post('replace_action');
                    $property = $this->input->post('property');
                    $target_property_id = $property['similar']['id'];
                    unset($property['similar']);
                    unset($property['property_link']);
                    unset($property['row']);
                    $this->load->library('property_library');
                    $result = $this->property_library->confrim_replacement_action(
                        $replace_action,
                        $property,
                        $target_property_id);
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
                        $list = new stdClass();
                        $list->id = 0;
                        $list->content = '';
                        $this->data['list'] = $list;
                        $this->_renderL('lists/list_info');
                        return;            
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
                case 'bulk_import' :
                    if ($this->_checkListPermission($id, 'create')) {
                        // list
                        $this->load->model('list_model');
                        $this->data['list'] = $this->list_model->get(array(
                                'l.id' => $id, 
                                'l.company_id' => $this->logged_user->company_id
                            ), false);
                        $this->_renderL('lists/bulk_import');
                        return;
                    }
                    break;
                case 'bulk_import_result' :
                    // list
                    $this->load->model('list_model');
                    $this->data['list'] = $this->list_model->get(array(
                            'l.id' => $id, 
                            'l.company_id' => $this->logged_user->company_id
                        ), false);
                    $this->load->library('list_library');
                    $this->data['result'] = $this->list_library->bulk_import($id);
                    $this->_renderL('lists/bulk_import_result');
                    return;
                break;
            }
            $this->show_404();
        }
    }

    public function property($list_id = 0, $sub = "info", $property_id = 0) 
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $action = $this->input->post('action');
            $this->load->model('property_model');
            switch ($action) {
                case 'save_property':
                    $property = $this->input->post('form');
                    $property['created_by'] = $this->logged_user->id;
                    $property['company_id'] = $this->logged_user->company_id;
                    if (isset($property['status']) && $property['status'] == 'replacement') {
                        $result = $this->property_model->save($property);
                    } else {
                        $check_property = $this->property_model->check_property_exists($property, $this->logged_user->company_id);
                        if ($check_property['exist']) {
                            foreach ($check_property['properties'] as $cp) {
                                $cp->permission = $this->_checkListPermission($cp->list_id, 'retrieve');
                                $cp->url = base_url() . "lists/property/". $cp->list_id . "/info/" . $cp->id;
                            }
                            $result['exist'] = true;
                            $result['properties'] = $check_property['properties'];
                            $result['success'] = false;
                        } else {
                            $result = $this->property_model->save($property);
                            if ($result['success']) {
                                $this->property_model->add_history([
                                    'property_id' => $result['id'],
                                    'company_id' => $property['company_id'],
                                    'message' => 'Property was ' .  (isset($property['id']) ? 'updated' : 'added') . ' by ' . $this->logged_user->first_name . ' ' . $this->logged_user->last_name
                                ]);
                                 $mailings = $this->input->post('mailings');
                                $this->property_model->save_mailings($result['id'], $mailings);
                            }
                        }
                    }
                    echo json_encode($result);
                    break;
                case 'replace_action' :
                    $replace_action = $this->input->post('replace_action');
                    $property = $this->input->post('property');
                    $target_property_id = $property['similar']['id'];
                    $this->load->library('property_library');
                    $result = $this->property_library->replace_action(
                        $replace_action,
                        $property,
                        $target_property_id,
                        $this->logged_user
                    );
                    $this->property_model->add_history([
                        'property_id' => $property['id'],
                        'company_id' => $property['company_id'],
                        'message' => 'Property was replaced by ' . $this->logged_user->first_name . ' ' . $this->logged_user->last_name
                    ]);
                    echo json_encode($result);
                    break;
                case 'delete_property':
                    $id = $this->input->post('id');
                    $status = $this->input->post('status');
                    $result = $this->property_model->delete($id, $this->logged_user->company_id, $status);
                    $this->property_model->add_history([
                        'property_id' => $property['id'],
                        'company_id' => $property['company_id'],
                        'message' => 'Property was deleted by ' . $this->logged_user->first_name . ' ' . $this->logged_user->last_name
                    ]);
                    echo json_encode($result);
                    break;
                case 'save_comment':
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
                    $property_id = $this->input->post('property_id');
                    $result = $this->property_model->get_comment(array('property_id' => $property_id));
                    echo json_encode($result);
                    break;
                case 'check_property_exists' :
                    $property = $this->input->post('property');
                    $result = $this->property_model->check_property_exists($property, $this->logged_user->company_id);
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
                        // Property
                        if ($property_id > 0) {
                            $this->load->model('property_model');
                            $property = $this->property_model->get(
                                array('p.id' => $property_id, 'p.list_id' => $list_id), false);
                            $property->pr_url = base_url() . 'lists/property/' . $property->pr_list_id . '/info/' . $property->target_property_id;
                            $this->data['property'] = $property;
                            $this->data['comments'] = $this->property_model->get_comment(array('property_id' => $property_id));
                            $this->data['histories'] = $this->property_model->get_history(array('property_id' => $property_id));
                            $this->data['mailings'] = $this->property_model->get_mailings(array('property_id' => $property_id));
                            if (!$this->data['mailings']) {
                                $this->data['mailings'] = $this->_generateTempMailings($this->data['list']->mailing_type, $this->data['list']->no_of_letters);
                                $this->property_model->save_mailings($property_id, $this->data['mailings']);
                                $this->data['mailings'] = $this->property_model->get_mailings(array('property_id' => $property_id));
                            }
                        } else {
                            $this->data['mailings'] = $this->_generateTempMailings($this->data['list']->mailing_type, $this->data['list']->no_of_letters);
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

    public function _generateTempMailings($type, $letter_count)
    {
        $mailings = [];
        $date = date('Y-m-d');
        $this->load->library('property_library');
        for ($i = 1; $i <= $letter_count; $i++) {
            $next_date = $this->property_library->get_next_mailing_date($type, $date);
            $date = $next_date;

            $mailings[] = [
                'letter_no' => $i,
                'mailing_date' => $date,
                'company_id' => $this->logged_user->company_id
            ];
        }
        return $mailings;
    }

}
