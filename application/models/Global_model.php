<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Global_model extends CI_Model {

    function __construct()
    {
        $this->load->database();
    }

    /*
     * Default CRUD
     */
    public function get_secret($where = array(), $list = true)
    {
        $result = $this->db->get_where('secret', $where);
        return $list ? $result->result() : $result->row();
    }

    /*
     * Temporary Data Table
     */
    public function get_temp_data($company_id, $where)
    {
        $where['company_id'] = $company_id;
        return $this->db->get_where('temp_data', $where)->row();
    }

    public function insert_temp_data($company_id, $data)
    {
        $this->delete_temp_data(['user_id' => $data['user_id'], 'k' => $data['k']]);
        $data['company_id'] = $company_id;
        $this->db->insert('temp_data', $data);
        return $this->db->insert_id();
    }

    public function update_temp_data($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('temp_data', $data);
        return $this->db->insert_id();
    }

    public function delete_temp_data($data)
    {
        return $this->db->delete('temp_data', $data);
    }

} 