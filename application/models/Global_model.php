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

} 