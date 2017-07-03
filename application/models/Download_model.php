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

    public function get_download_history($company_id, $filter, $where = [])
    {
        $where['dh.company_id'] = $company_id;
        $this->db->select('dh.*, CONCAT(u.first_name, " ", u.last_name) as full_name');
        $this->db->join('user u', 'dh.downloaded_by_user_id = u.id', 'left');

        if (isset($filter['from_module']) && !in_array('all', $filter['from_module'])) {
            $this->db->where_in('dh.type', $filter['from_module']);
        }
        if (isset($filter['downloaded_by']) && $filter['downloaded_by'] !== 'all') {
            $this->db->where('dh.downloaded_by_user_id', $filter['downloaded_by']);
        }
        if (isset($filter['download_date']) && $filter['download_date'] !== '') {
            $date_split = explode(' - ', $filter['download_date']);
            $this->db->where("dh.download_date BETWEEN '$date_split[0]' AND '$date_split[1]'"); 
        }

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

    public function update_download_history($history)
    {
        $result = ['success' => false];
        if (isset($history['id'])) {
            $this->db->where('id', $history['id']);
            $this->db->update('download_history', $history);
            $result['success'] = true;
        }
        return $result;
    }

    public function delete_download_history($id, $company_id)
    {
        $result = ['success' => false];
        $this->db->trans_start();
        $this->db->where(['id' => $id, 'company_id' => $company_id]);
        $this->db->delete('download_history');
        $this->db->where(['history_id' => $id]);
        $this->db->delete('download_history_property');
        $this->db->trans_complete();
        if ($this->db->trans_status()) {
            $result['success'] = true;
        }
        return $result;
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

        if (!in_array('all', $filter['list'])) {
            $this->db->where_in('id', $filter['list']);
        }
        $lists = $this->db->get_where('list', $where_list)->result();

        if ($filter['report_type'] == 'Date Range') {
            $date_split = explode(' - ', $filter['date_range']);
            $filter['from'] = $date_split[0];
            $filter['to'] = $date_split[1];
        }

        $type = 'downloads-post-letters';
        if ($filter['type'] == 'letter') {
            $type = 'downloads-letters';
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
                    'costs' => 0,
                    'variables' => []
                ];

                $sql = "SELECT 
                        p.id,
                        p.status,
                        dh.variable,
                        dh.cost
                    FROM property_mailing pm
                    LEFT JOIN property p ON pm.property_id = p.id
                    RIGHT JOIN download_history_property dhp ON dhp.property_id = p.id
                    LEFT JOIN download_history dh ON dh.id = dhp.history_id
                    WHERE pm.letter_no = " . $this->db->escape($i) . "
                    AND p.company_id = " . $filter['company_id'] . " 
                    AND p.status NOT IN ('stop', 'draft', 'duplicate')";

                if ($filter['type'] !== 'all') {
                    $sql .= "AND dh.type = '$type'";
                }

                $sql .= " AND p.list_id = " . $this->db->escape($list->id);

                if ($filter['report_type'] == 'Date Range') {
                    $sql .= " AND pm.mailing_date BETWEEN " 
                    . $this->db->escape($filter['from']) . " AND " 
                    . $this->db->escape($filter['to']);
                } else if ($filter['report_type'] == 'Last 4 Months') {
                    $sql .= " AND pm.mailing_date BETWEEN NOW()-INTERVAL 3 MONTH AND NOW()";
                } else if ($filter['report_type'] == 'Last 12 Months') {
                    $sql .= " AND pm.mailing_date BETWEEN NOW()-INTERVAL 12 MONTH AND NOW()";
                }

                $sql .= "GROUP BY id, variable, cost";

                $property_mailings = $this->db->query($sql)->result();

                foreach ($property_mailings as $pm) {
                    $letter['mail_qty']++;
                    $letter['costs'] += $pm->cost;
                    if ($pm->status == 'buy') {
                        $letter['buys']++;
                    }
                    if ($pm->status == 'lead') {
                        $letter['leads']++;
                    }

                    if ($pm->variable) {
                        if (!isset($letter['variables'][$pm->variable])) {
                            $letter['variables'][$pm->variable] = [
                                'mail_qty' => 0,
                                'leads' => 0,
                                'buys' => 0,
                                'costs' => 0
                            ];
                        }
                        $letter['variables'][$pm->variable]['mail_qty']++;
                        $letter['variables'][$pm->variable]['costs'] += $pm->cost;
                        if ($pm->status == 'buy') {
                            $letter['variables'][$pm->variable]['buys']++;
                        }
                        if ($pm->status == 'lead') {
                            $letter['variables'][$pm->variable]['leads']++;
                        }
                    }
                }
                $mail['letters'][] = $letter;
            }
            // compute total
            $mail['total_cost'] = 0;
            $mail['total_mail_qty'] = 0;
            $mail['total_leads'] = 0; 
            $mail['total_buys'] = 0;
            foreach ($mail['letters'] as $letter) {
                $mail['total_cost'] += $letter['costs']; 
                $mail['total_mail_qty'] += $letter['mail_qty'];
                $mail['total_leads'] += $letter['leads'];
                $mail['total_buys'] += $letter['buys'];
            }
            $mailings[] = $mail;
        }
        return $mailings;
    }
} 