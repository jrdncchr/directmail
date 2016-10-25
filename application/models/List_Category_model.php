<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class List_Category_model extends CI_Model {

    function __construct()
    {
        $this->load->database();
    }

    /*
     * list_category
     */
    public function get($where = array(), $list = true)
    {
        $where['deleted'] = 0;
        $result = $this->db->get_where('list_category', $where);
        return $list ? $result->result() : $result->row();
    }

    public function save($list_category)
    {
        if (isset($list_category['id']) && $list_category['id'] > 0) {
            $this->db->where('id', $list_category['id']);
            $this->db->update('list_category', $list_category);
        } else {
            $this->db->insert('list_category', $list_category);
            $list_category['id'] = $this->db->insert_id();
        }
        return array('success' => true, 'id' =>  $list_category['id']);
    }

    public function delete($id, $company_id)
    {
        $result = array('success' => false);
        $list = $this->db->get_where('list', array('list_category_id' => $id, 'company_id' => $company_id));
        if ($list->num_rows() > 0) {
            $result['message'] = "Cannot delete because there are list on the selected category.";
        } else {
            $result = $this->save(array('id' => $id, 'deleted' => 1));
        }
        return $result;
    }

} 