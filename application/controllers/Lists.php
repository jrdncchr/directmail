<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lists extends MY_Controller {

    function __construct()
    {
        parent::__construct(true);
        $this->data['page_title'] = "Lists";
    }

    public function no_list_category()
    {
        $this->_renderL('lists/empty');
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
                }
                $this->show_404();
            } else {
                $this->show_404();
            }
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
                        'p.active' => 1
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
                case 'replace_action':
                    $replace_action = $this->input->post('replace_action');
                    $property = $this->input->post('property');
                    $target_property_id = $this->input->post('target_property_id');
                    $this->load->library('property_library');
                    $result = $this->property_library->replace_action(
                        $replace_action,
                        $property,
                        $target_property_id,
                        $this->logged_user
                    );
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
                case 'bulk_import' :
                    if ($this->_checkListPermission($id, 'create')) {
                        // list
                        $this->load->model('list_model');
                        $this->data['list'] = $this->list_model->get(array(
                                'l.id' => $id, 
                                'l.company_id' => $this->logged_user->company_id
                            ), false);
                        // list category
                        $this->data['list_category'] = $this
                            ->list_category_permissions[$this->data['list']->list_category_id];
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
                    // list category
                    $this->data['list_category'] = $this
                        ->list_category_permissions[$this->data['list']->list_category_id];
                    $this->data['result'] = $this->bulk_import($id);
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
                    $target_property_id = $this->input->post('target_property_id');
                    $this->load->library('property_library');
                    $result = $this->property_library->replace_action(
                        $replace_action,
                        $property,
                        $target_property_id,
                        $this->logged_user
                    );
                    echo json_encode($result);
                    break;
                case 'delete_property':
                    $id = $this->input->post('id');
                    $status = $this->input->post('status');
                    $result = $this->property_model->delete($id, $this->logged_user->company_id, $status);
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
                        // list category
                        $this->data['list_category'] = $this
                            ->list_category_permissions[$this->data['list']->list_category_id];
                        // Property
                        if ($property_id > 0) {
                            $this->load->model('property_model');
                            $property = $this->property_model->get(
                                array('p.id' => $property_id, 'p.list_id' => $list_id), false);
                            $property->pr_url = base_url() . 'lists/property/' . $property->pr_list_id . '/info/' . $property->target_property_id;
                            $this->data['property'] = $property;
                            $this->data['comments'] = $this->property_model->get_comment(array('property_id' => $property_id));
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

    public function bulk_import($list_id)
    {
        $result = array(
            'similars' => array(),
            'saved' => array()
        );
        $path = $_FILES["file"]["tmp_name"];

        $objPHPExcel = PHPExcel_IOFactory::load($path);
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

        $properties = array();
        for ($row = 2; $row <= $highestRow; ++ $row) {
            $property = array();
            $property['row'] = $row;
            $property['created_by'] = $this->logged_user->id;
            $property['last_update'] = date('Y-m-d H:i:s');
            $property['company_id'] = $this->logged_user->company_id;
            for ($col = 0; $col < $highestColumnIndex; ++ $col) {
                $cell = $sheet->getCellByColumnAndRow($col, $row);
                $val = $cell->getValue();
                switch ($col) {
                    case 0 : $property['list_id'] = $val; break;
                    case 1 : $property['funeral_home'] = $val; break;
                    case 2 : $property['property_first_name'] = $val; break;
                    case 3 : $property['property_middle_name'] = $val; break;
                    case 4 : $property['property_last_name'] = $val; break;
                    case 5 : $property['property_address'] = $val; break;
                    case 6 : $property['property_city'] = $val; break;
                    case 7 : $property['property_state'] = $val; break;
                    case 8 : $property['property_zipcode'] = $val; break;
                    case 9 : $property['pr_first_name'] = $val; break;
                    case 10 : $property['pr_middle_name'] = $val; break;
                    case 11 : $property['pr_last_name'] = $val; break;
                    case 12 : $property['pr_address'] = $val; break;
                    case 13 : $property['pr_city'] = $val; break;
                    case 14 : $property['pr_state'] = $val; break;
                    case 15 : $property['pr_zipcode'] = $val; break;
                    case 16 : $property['attorney_name'] = $val; break;
                    case 17 : $property['attorney_first_address'] = $val; break;
                    case 18 : $property['attorney_second_address'] = $val; break;
                    case 19 : $property['attorney_city'] = $val; break;
                    case 20 : $property['attorney_state'] = $val; break;
                    case 21 : $property['attorney_zipcode'] = $val; break;
                    case 22 : $property['mail_first_name'] = $val; break;
                    case 23 : $property['mail_last_name'] = $val; break;
                    case 24 : $property['mail_address'] = $val; break;
                    case 25 : $property['mail_city'] = $val; break;
                    case 26 : $property['mail_state'] = $val; break;
                    case 27 : $property['mail_zipcode'] = $val; break;
                    case 28 : $property['status'] = $val; break;
                }
            }
            if ($property['list_id'] == $list_id) {
                $properties[] = $property;
            }
        }

        $this->load->model('property_model');
        foreach ($properties as $property) {
            $check_property = $this->property_model->check_property_exists($property, $this->logged_user->company_id);
            if ($check_property['exist']) {
                foreach ($check_property['properties'] as $cp) {
                    $cp->permission = $this->_checkListPermission($cp->list_id, 'retrieve');
                    $cp->url = base_url() . "lists/property/". $cp->list_id . "/info/" . $cp->id;
                }
                $property['check'] = $check_property;
                $result['similars'][] = $property;
            } else {
                $row = $property['row'];
                unset($property['row']);
                $save = $this->property_model->save($property);
                if ($save['success']) {
                    $property['row'] = $row;
                    $property['id'] = $save['id'];
                    $result['saved'][] = $property;
                }
            }
        }
        return $result;
    }

}
