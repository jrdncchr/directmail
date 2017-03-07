<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Download_model extends CI_Model {

    function __construct()
    {
        $this->load->database();
    }

    public function generate_mailings($filter) 
    {
        $mailings = [];

        // get list
        $where_list = array(
            'company_id' => $filter['company_id'],
            'active' => 1,
            'deleted' => 0
        );
        if ($filter['list'] == 'all') {
            $lists = $this->db->get_where('list', $where_list)->result();
        } else {
            $where_list['id'] = $filter['list'];
            $lists = $this->db->get_where('list', $where_list)->result();
        }
        
        // generate mailings by list
        foreach ($lists as $list) {
            $letters = [];
            for ($i = 1; $i <= (int)$list->no_of_letters; $i++) {
                $sql = "SELECT * FROM property_mailing pm 
                    LEFT JOIN property p ON pm.property_id = p.id 
                    WHERE pm.letter_no = " . $this->db->escape($i) . "
                    AND p.company_id = " . $filter['company_id'];

                if ($filter['list'] != 'all') {
                    $sql .= " AND p.list_id = " . $this->db->escape($list->id);
                }

                if ($filter['report_type'] == 'Date Range') {
                    $sql .= " AND pm.mailing_date BETWEEN " 
                    . $this->db->escape($filter['from']) . " AND " 
                    . $this->db->escape($filter['to']);
                }

                $result = $this->db->query($sql)->result();
                var_dump($result);exit;
            }
        }
    }

} 