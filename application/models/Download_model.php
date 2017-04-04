<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Download_model extends CI_Model {

    function __construct()
    {
        $this->load->database();
    }

    public function save_download_history($history, $properties)
    {
        $this->db->insert('download_history', $history);
        $history_id = $this->db->insert_id();

        $download_history_properties = [];
        foreach ($properties as $property) {
            $download_history_properties[] = [
                'history_id' => $history_id,
                'property_id' => $property->id
            ];
        }
        $this->db->insert_batch('download_history_property', $download_history_properties);
    }

    public function get_download_history($company_id, $where = [])
    {
        $where['dh.company_id'] = $company_id;
        $this->db->select('dh.*, CONCAT(u.first_name, " ", u.last_name) as full_name');
        $this->db->join('user u', 'dh.uploaded_by_user_id = u.id', 'left');
        $download_history = $this->db->get_where('download_history dh', $where)->result();
        if ($download_history) {
            foreach ($download_history as $history) {
                $history->property_count = $this->db->get_where('download_history_property', [
                    'history_id' => $history->id
                ])->num_rows();
                $history->filters = json_decode($history->filters);
            }
        }
        return $download_history;
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

        $date_split = explode(' - ', $filter['date_range']);
        $filter['from'] = $date_split[0];
        $filter['to'] = $date_split[1];
        
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
                    AND p.status NOT IN ('stop', 'draft', 'duplicate')";

                $sql .= " AND p.list_id = " . $this->db->escape($list->id);

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

    public function setBulkImportRowsCount($user_id, $count)
    {
        $this->load->dbforge();
        $this->dbforge->drop_table('temp_bulk_import_' . $user_id, true);
        $this->dbforge->create_table('temp_bulk_import_' . $user_id, FALSE, $attributes);
    }

} 