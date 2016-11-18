<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Property_model extends CI_Model {

    function __construct()
    {
        $this->load->database();
    }

    /*
     * Property
     */
    public function get_list($where)
    {
        $where['p.deleted'] = 0;
        $this->db->select('
            p.id, 
            p.list_id, 
            p.status,
            p.deceased_first_name, 
            p.deceased_last_name, 
            p.deceased_middle_name, 
            p.deceased_address,
            p.mail_first_name, 
            p.mail_last_name, 
            p.mail_address');
        $result = $this->db->get_where('property p', $where);
        return $result->result();
    }

    public function get($where = array(), $list = true)
    {
        $where['p.deleted'] = 0;
        $result = $this->db->get_where('property p', $where);
        return $list ? $result->result() : $result->row();
    }

    public function save($property)
    {
        $property['last_update'] = date('Y-m-d H:i:s');
        if (isset($property['id']) && $property['id'] > 0) {
            $this->db->where('id', $property['id']);
            $this->db->update('property', $property);
        } else {
            $this->db->insert('property', $property);
            $property['id'] = $this->db->insert_id();
        }
        return array('success' => true, 'id' =>  $property['id']);
    }

    public function delete($id)
    {
        return $this->save(array('id' => $id, 'deleted' => 1));
    }

    public function truncate()
    {
        $this->db->truncate('property');
    }

    public function save_comment($comment)
    {
        $this->db->insert('property_comment', $comment);
        $comment['id'] = $this->db->insert_id();
        return array('success' => true, 'id' =>  $comment['id']);
    }

    public function get_comment($where = array(), $list = true)
    {
        $this->db->select('pc.*, u.first_name, u.last_name');
        $this->db->join('user u', 'u.id = pc.user_id', 'left');
        $this->db->order_by('date_created', 'desc');
        $result = $this->db->get_where('property_comment pc', $where);
        return $list ? $result->result() : $result->row();
    }

    public function truncate_comment()
    {
        $this->db->truncate('property_comment');
    }

    public function get_pending_properties($company_id) 
    {
        $this->db->select('p.*, l.name as list_name');
        $this->db->join('list l', 'l.id = p.list_id');
        $this->db->where(array('l.company_id' => $company_id, 'p.status' => 'pending'));
        $result = $this->db->get('property p');
        return $result->result();
    }
} 