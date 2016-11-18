<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class List_model extends CI_Model {

    function __construct()
    {
        $this->load->database();
    }

    /*
     * List
     */
    public function get($where = array(), $list = true)
    {
        $where['l.deleted'] = 0;
        $where['l.active'] = 1;
        $this->db->select('l.*, u.first_name, u.last_name');
        $this->db->join('user u', 'u.id = l.created_by', 'left');
        $result = $this->db->get_where('list l', $where);
        return $list ? $result->result() : $result->row();
    }

    public function save($list)
    {
        if (isset($list['id']) && $list['id'] > 0) {
            $old = $this->db->get_where('list', array('id' => $list['id']))->row();
            if ($list['name'] != $old->name) {
                if ($this->check_list_name_exists($list['name'], $list['company_id'])) {
                    return array('success' => false, 'message' => 'List name already exist.');
                }
            }
            $this->db->where('id', $list['id']);
            $this->db->update('list', $list);
        } else {
            if ($this->check_list_name_exists($list['name'], $list['company_id'])) {
                return array('success' => false, 'message' => 'List name already exist.');
            }
            $this->db->insert('list', $list);
            $list['id'] = $this->db->insert_id();

            $CI =& get_instance();
            $CI->load->model('user_model');
            $CI->user_model->_create_list_permission($list['created_by'], $list['id']);
            $this->session->unset_userdata('user_list_permissions');
        }
        return array('success' => true, 'id' =>  $list['id']);
    }

    public function delete($list_id)
    {
        $result = array('success' => false);
        $this->db->where('id', $list_id);
        if ($this->db->update('list', array('deleted' => 1))) {
            $result['success'] = true;
        };
       return $result;
    }

    public function check_list_name_exists($list_name, $company_id) 
    {
        $exist = $this->db->get_where('list', 
            array(
                'company_id' => $company_id, 
                'name' => $list_name,
                'deleted' => 0,
                'active' => 1
            ));
        return $exist->num_rows() > 0 ? true : false;
    }

    /*
     * List Paragraph
     */
    public function get_paragraphs($where = array(), $list = true)
    {
        $this->db->order_by('number');
        $result = $this->db->get_where('list_paragraph lp', $where);
        return $list ? $result->result() : $result->row();
    }

    public function insert_paragraph($paragraph = array()) // used for seeding
    {
        $this->db->insert('list_paragraph', $paragraph);
        return array('success' => true);
    }

    public function save_paragraphs($list_id, $type, $paragraphs = array())
    {
        $this->delete_paragraph(array('list_id' => $list_id, 'type' => $type));
        foreach ($paragraphs as $p) {
            $p['list_id'] = $list_id;
            $p['type'] = $type;
            $this->db->insert('list_paragraph', $p);
        }
        return array('success' => true);
    }

    public function delete_paragraph($where)
    {
        return $this->db->delete('list_paragraph', $where);
    }

    public function truncate_list_paragraph()
    {
        $this->db->truncate('list_paragraph');
    }

    /*
     * List Bullet points
     */
    public function get_bullet_points($where = array(), $list = true)
    {
        $this->db->order_by('number');
        $result = $this->db->get_where('list_bullet_point lbp', $where);
        return $list ? $result->result() : $result->row();
    }

    public function save_bullet_points($list_id, $bullet_points = array())
    {
        $this->delete_bullet_points(array('list_id' => $list_id));
        foreach ($bullet_points as $bp) {
            $bp['list_id'] = $list_id;
            $this->db->insert('list_bullet_point', $bp);
        }
        return array('success' => true);
    }

    public function insert_bullet_point($bullet_point) // used for seeding
    {
         $this->db->insert('list_bullet_point', $bullet_point);
        return array('success' => true);
    }

    public function delete_bullet_points($where)
    {
        return $this->db->delete('list_bullet_point', $where);
    }

    public function truncate_list_bullet_points()
    {
        $this->db->truncate('list_bullet_point');
    }

     /*
     * List Testimonials
     */
    public function get_testimonials($where = array(), $list = true)
    {
        $this->db->order_by('number');
        $result = $this->db->get_where('list_testimonial lt', $where);
        return $list ? $result->result() : $result->row();
    }

    public function save_testimonials($list_id, $testimonials = array())
    {
        $this->delete_testimonials(array('list_id' => $list_id));
        foreach ($testimonials as $t) {
            $t['list_id'] = $list_id;
            $this->db->insert('list_testimonial', $t);
        }
        return array('success' => true);
    }

    public function insert_testimonial($testimonial) // used for seeding
    {
         $this->db->insert('list_testimonial', $testimonial);
        return array('success' => true);
    }

    public function delete_testimonials($where)
    {
        return $this->db->delete('list_testimonial', $where);
    }

    public function truncate_list_testimonials()
    {
        $this->db->truncate('list_testimonial');
    }
} 