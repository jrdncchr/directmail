<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lists extends MY_Controller {

    function __construct()
    {
        parent::__construct(true);
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
                default :
                    echo json_encode($result);
            }
        } else {
            if ($id > 0) {
                switch ($sub) {
                    case 'index' :
                        if (isset($this->list_category_permissions[$id])) {
                            $allowed = filter_var($this->list_category_permissions[$id]->retrieve_action, FILTER_VALIDATE_BOOLEAN);
                            if ($allowed) {
                                $this->data['list_category'] = $this->list_category_permissions[$id];
                                $this->_renderL('lists/index');
                                return;
                            }
                        }
                        show_404();
                        break;
                    case 'add' :

                    default:
                        show_404();
                }
            } else {
                show_404();
            }
        }
    }

    public function index($id = 0)
    {
        echo $id;
    }

}
