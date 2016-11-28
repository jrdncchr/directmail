<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Setting_model extends CI_Model {

    function __construct()
    {
        $this->load->database();
    }

    /*
     * Default CRUD
     */
    public function get_abbreviations($company_id, $list = true)
    {
        $result = $this->db->get_where('abbreviations', array('company_id' => $company_id));
        return $list ? $result->result() : $result->row();
    }

    public function save_abbreviation($abbr)
    {
        if (isset($abbr['id'])) {
            $this->db->where('id', $abbr['id']);
            $this->db->update('abbreviations', $abbr);
        } else {
            $this->db->insert('abbreviations', $abbr);
            $abbr['id'] = $this->db->insert_id();
        }
        return array('success' => true, 'id' =>  $abbr['id']);
    }

    public function delete_abbreviation($where) 
    {
    	$result = array('success' => false);
    	$this->db->where($where);
    	if ($this->db->delete('abbreviations')) {
    		$result['success']  = true;
    	}
    	return $result;
    }

} 