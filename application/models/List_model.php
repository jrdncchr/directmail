<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class List_model extends CI_Model {

    function __construct()
    {
        $this->load->database();
    }

    /*
     * list
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
            $this->db->where('id', $list['id']);
            $this->db->update('list', $list);
        } else {
            $this->db->insert('list', $list);
            $list['id'] = $this->db->insert_id();
        }
        return array('success' => true, 'id' =>  $list['id']);
    }

    public function delete($id)
    {
        return $this->save(array('id' => $id, 'deleted' => 1));
    }

} 