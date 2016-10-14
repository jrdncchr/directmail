<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Company_model extends CI_Model {

    function __construct()
    {
        $this->load->database();
    }

    /*
     * Default CRUD
     */
    public function get($where = array(), $list = true)
    {
        $result = $this->db->get_where('company', $where);
        return $list ? $result->result() : $result->row();
    }

    public function save($company)
    {
        if (isset($company['id'])) {

            $this->db->where('id', $company['id']);
            $this->db->update('company', $company);
        } else {
            $this->db->insert('company', $company);
            $company['id'] = $this->db->insert_id();
        }
        return array('success' => true, 'id' =>  $company['id']);
    }

} 