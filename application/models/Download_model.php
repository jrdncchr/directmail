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
            $mail = ['list' => $list->name, 'letters' => []];
            for ($i = 1; $i <= (int)$list->no_of_letters; $i++) {
                $letter = [
                    'number' => $i,
                    'mail_qty' => 0,
                    'leads' => 0,
                    'buys' => 0,
                    'costs' => 0
                ];

                $sql = "SELECT * FROM property_mailing pm 
                    LEFT JOIN property p ON pm.property_id = p.id 
                    WHERE pm.letter_no = " . $this->db->escape($i) . "
                    AND p.company_id = " . $filter['company_id'] . " 
                    AND p.status NOT IN ('stop', 'pending')";

                if ($filter['list'] != 'all') {
                    $sql .= " AND p.list_id = " . $this->db->escape($list->id);
                }

                if ($filter['report_type'] == 'Date Range') {
                    $sql .= " AND pm.mailing_date BETWEEN " 
                    . $this->db->escape($filter['from']) . " AND " 
                    . $this->db->escape($filter['to']);
                }

                $property_mailings = $this->db->query($sql)->result();
                foreach ($property_mailings as $pm) {
                    $letter['mail_qty']++;
                    $letter['costs']++;
                    if ($pm->status == 'buy') {
                        $letter['buys']++;
                    }
                    if ($pm->status == 'lead') {
                        $letter['leads']++;
                    }
                }
                $mail['letters'][] = $letter;
            }
            $mailings[] = $mail;
        }
        return $mailings;
    }

} 