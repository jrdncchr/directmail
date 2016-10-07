<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Client_model extends CI_Model {

    function __construct()
    {
        $this->load->database();
    }

    /*
     * Default CRUD
     */
    public function get($where = array(), $list = true)
    {
        $result = $this->db->get_where('client', $where);
        return $list ? $result->result() : $result->row();
    }

    public function save($client)
    {
        if (isset($client['id'])) {

            $this->db->where('id', $client['id']);
            $this->db->update('client', $client);
        } else {
            $this->db->insert('user', $client);
            $client['id'] = $this->db->insert_id();
        }
        return array('success' => true, 'id' =>  $client['id']);
    }

} 