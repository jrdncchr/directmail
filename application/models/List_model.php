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
    public function get($where = array(), $list = true, $get_need_actions = false)
    {
        $where['l.deleted'] = 0;
        $where['l.active'] = 1;
        $this->db->select('l.*, u.first_name, u.last_name');
        if ($get_need_actions) {
            $this->db->select("(SELECT COUNT(*) FROM property p WHERE p.list_id = l.id AND p.status = 'duplicate') duplicate_count");
            $this->db->select("(SELECT COUNT(*) FROM property p WHERE p.list_id = l.id AND p.status = 'draft') draft_count");
            $this->db->where("((SELECT COUNT(*) FROM property p WHERE p.list_id = l.id AND p.status = 'duplicate') > 0 OR (SELECT COUNT(*) FROM property p WHERE p.list_id = l.id AND p.status = 'draft') > 0)");
        }

        $this->db->join('user u', 'u.id = l.created_by', 'left');
        $result = $this->db->get_where('list l', $where);
        return $list ? $result->result() : $result->row();
    }

    public function get_list_by_priority($company_id)
    {
        $this->db->order_by('priority', 'date_created');
        return $this->db->get_where('list', ['company_id' => $company_id, 'deleted' => 0])->result();
    }

    public function bulk_update($company_id, $data)
    {
        $result['success'] = false;
        $this->db->where('company_id', $company_id);
        if ($this->db->update_batch('list', $data, 'id')) {
            $result['success'] = true;
        }
        return $result;
    }

    public function save($list)
    {
        $action_word = "Updated";
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
            $action_word = "Created";
            $this->db->insert('list', $list);
            $list['id'] = $this->db->insert_id();

            $CI =& get_instance();
            $CI->load->model('user_model');
            $CI->user_model->_create_list_permission($list['created_by'], $list['id']);
            $this->session->unset_userdata('user_list_permissions');
        }
        // log user action
        $this->dm_library->insert_user_log([
            'user_id' => $this->logged_user->id,
            'log' => "$action_word a list with an ID of " . $list['id'] . " [" . $list['name'] . "].",
            'link' => base_url() . "lists/info/" . $list['id']
        ]);
        return array('success' => true, 'id' =>  $list['id']);
    }

    public function delete($list_id, $company_id)
    {
        $result = array('success' => false);
        $CI =& get_instance();
        $CI->load->model('property_model');
        $list_name = $this->db->get_where('list', ['id' => $list_id, 'company_id' => $company_id])->row()->name;
        $properties = $CI->property_model->get_by_list_id($list_id, $company_id);
        $CI->property_model->bulk_delete_properties($company_id, $properties);
        if ($this->db->delete('list', ['id' => $list_id, 'company_id' => $company_id])) {
            $result['success'] = true;
        }
        // log user action
        $this->dm_library->insert_user_log([
            'user_id' => $this->logged_user->id,
            'log' => "Deleted a list with an ID of " . $list_id . " [" . $list_name ."]."
        ]);
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

    public function get_list_properties_count($company_id, $filter)
    {
        $where['l.company_id'] = $company_id;
        $this->db->select(' l.id, l.name, COUNT(p.id) AS property_count');
        $this->db->join('property p', 'p.list_id = l.id', 'left');

        if (isset($filter['date_range']) && $filter['date_range'] !== '') {
            $date_split = explode(' - ', $filter['date_range']);
            $this->db->where("p.date_created BETWEEN '$date_split[0]' AND '$date_split[1]'"); 
        }

        $this->db->where("l.company_id = $company_id");
        $this->db->group_by('l.id'); 
        $this->db->order_by('property_count');

        $list_property = $this->db->get_where('list l', $where)->result();
        return $list_property;
    }
    
} 