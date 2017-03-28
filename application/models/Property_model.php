<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Property_model extends CI_Model {

    function __construct()
    {
        $this->load->database();
    }

    /*
     * Property
     */
    public function get_list($where)
    {
        $where['p.deleted'] = 0;
        $this->db->select('
            p.id, 
            p.list_id, 
            p.status,
            p.property_first_name, 
            p.property_last_name, 
            p.property_middle_name, 
            p.property_address,
            p.mail_first_name, 
            p.mail_last_name, 
            p.mail_address');
        $result = $this->db->get_where('property p', $where);
        return $result->result();
    }

    public function get($where = array(), $list = true)
    {
        $where['p.deleted'] = 0;
        $this->db->select('p.*, pr.target_property_id, p2.list_id as pr_list_id');
        $this->db->join('property_replacement pr', 'pr.property_id = p.id', 'left');
        $this->db->join('property p2', 'p2.id = pr.property_id', 'left');
        $result = $this->db->get_where('property p', $where);
        return $list ? $result->result() : $result->row();
    }

    public function get_by_list_id($list_id, $company_id)
    {
        return $this->db->get_where('property', ['list_id' => $list_id, 'company_id' => $company_id])->result();
    }

    public function get_by_id($id, $company_id) {
        return $this->db->get_where('property', ['id' => $id, 'company_id' => $company_id])->row();
    }

    public function save($property)
    {
        unset($property['target_property_id']);
        unset($property['pr_list_id']);
        unset($property['pr_url']);

        if (isset($property['elligible_letter_mailings']) && $property['elligible_letter_mailings'] != 1) {
            $property['elligible_letter_mailings'] = $property['elligible_letter_mailings'] === 'true' ? 1 : 0;
        }
        if (isset($property['elligible_postcard_mailings']) && $property['elligible_postcard_mailings'] != 1) {
            $property['elligible_postcard_mailings'] = $property['elligible_postcard_mailings'] === 'true' ? 1 : 0;
        }
        if (isset($property['skip_traced'])) {
            $property['skip_traced'] = filter_var($property['skip_traced'], FILTER_VALIDATE_BOOLEAN);
        }

        $property['last_update'] = date('Y-m-d H:i:s');
        if (isset($property['id']) && $property['id'] > 0) {
            $this->db->where('id', $property['id']);
            $this->db->update('property', $property);
        } else {
            $this->db->insert('property', $property);
            $property['id'] = $this->db->insert_id();
        }
        return array('success' => true, 'id' =>  $property['id']);
    }

    public function update($where = array(), $update = array()) 
    {
        $this->db->where($where);
        return $this->db->update('property', $update);
    }

    public function delete($id, $company_id, $status = 'pending')
    {
        if ($status == 'duplicate') {
            $this->db->delete('property_replacement', array('property_id' => $id, 'company_id' => $company_id));
        }
        $where = [
            'id' => $id,
            'company_id' => $company_id
        ];
        if ($this->db->delete('property', $where)) {
            $this->db->where('property_id', $id);
            $this->db->delete('property_mailing');
            $this->db->where('property_id', $id);
            $this->db->delete('property_comment');
        }

        return array('success' => true);
    }

    public function truncate()
    {
        $this->db->truncate('property');
    }

    public function save_comment($comment)
    {
        $this->db->insert('property_comment', $comment);
        $comment['id'] = $this->db->insert_id();
        return array('success' => true, 'id' =>  $comment['id']);
    }

    public function get_comment($where = array(), $list = true)
    {
        $this->db->select('pc.*, u.first_name, u.last_name');
        $this->db->join('user u', 'u.id = pc.user_id', 'left');
        $this->db->order_by('date_created', 'desc');
        $result = $this->db->get_where('property_comment pc', $where);
        return $list ? $result->result() : $result->row();
    }

    public function delete_comments($where) {
        $this->db->where($where);
        return $this->db->delete('property_comment'); 
    }

    public function truncate_comment()
    {
        $this->db->truncate('property_comment');
    }

    public function get_mailings($where = array(), $list = true) 
    {
        $result = $this->db->get_where('property_mailing', $where);
        return $list ? $result->result() : $result->row();
    }

    public function save_mailings($property_id, $mailings) {
        foreach ($mailings as $mailing) {
            $mailing['property_id'] = $property_id;
            if (isset($mailing['id'])) {
                $this->db->where('id', $mailing['id']);
                $this->db->update('property_mailing', $mailing);
            } else {
                $this->db->insert('property_mailing', $mailing);
            }
        }
        return array('success' => true);
    }

    public function get_pending_properties($company_id) 
    {
        $this->db->select('p.*, l.name as list_name, l.id as list_id');
        $this->db->join('list l', 'l.id = p.list_id');
        $this->db->where(array('l.company_id' => $company_id, 'p.status' => 'pending', 'p.deleted' => 0));
        $result = $this->db->get('property p');
        return $result->result();
    }

    public function get_duplicate_properties($filter, $company_id) 
    {
        $this->db->select('p.*, 
            l.name as list_name, 
            l.id as list_id, 
            p2.id as target_id, 
            p2.property_address as target_property_address, 
            l2.name as target_list_name,
            l2.id as target_list_id,
            p2.status as target_status,
            p.date_created as upload_date,
            CONCAT(u.first_name, " ", u.last_name) as upload_by');
        $this->db->join('list l', 'l.id = p.list_id', 'left');
        $this->db->join('user u', 'p.created_by = u.id', 'left');
        $this->db->join('property_replacement pr', 'pr.property_id = p.id', 'left');
        $this->db->join('property p2', 'p2.id = pr.target_property_id', 'left');
        $this->db->join('list l2', 'l2.id = p2.list_id', 'left');
        $this->db->where(array('l.company_id' => $company_id, 'p.status' => 'duplicate', 'p.deleted' => 0));
        if (isset($filter['property_address'])) {
            $this->db->like("p.property_address", $filter['property_address']);
        }
        if (isset($filter['upload_by'])) {
            $this->db->like("p.created_by", $filter['upload_by']);
        }
        if (isset($filter['upload_date'])) {
            $this->db->like("p.date_created", $filter['upload_date']);
        }
        if (isset($filter['target_list'])) {
            $this->db->where_in('p2.list_id', $filter['target_list']);
        }
        if (isset($filter['target_status'])) {
            $this->db->where_in('p2.status', $filter['target_status']);
        }
        if (isset($filter['target_address'])) {
            $this->db->like("p2.property_address", $filter['target_address']);
        }
        $duplicates = $this->db->get('property p')->result();
        foreach ($duplicates as $duplicate) {
            $comment = $this->db->get_where('property_comment', ['property_id' => $duplicate->id])->row();
            $duplicate->comment['comment'] = $comment ? $comment->comment : ''; 
            $mailing_date =  $this->db->get_where('property_mailing', ['property_id' => $duplicate->id])->row();
            $duplicate->mailing_date = $mailing_date ? $mailing_date : date('Y-m-d');
        }
        return $duplicates;
    }

    public function get_properties($company_id, $where = array(), $filter = array(), $order_by = 'p.id')
    {
        $where['p.company_id'] = $company_id;
        $select = 'p.*, l.name as list_name, l.id as list_id';
        if (isset($filter['date_range'])) {
            $select = 'p.*, l.name as list_name, l.id as list_id, pm.mailing_date, pm.letter_no';
        }
        $this->db->select($select);
        $this->db->join('list l', 'l.id = p.list_id');
        $this->db->where($where);
        if (isset($filter['status'])) {
            $this->db->where_in('status', $filter['status']);
        }
        if (isset($filter['list'])) {
            $this->db->where_in('p.list_id', $filter['list']);
        }
        if (isset($filter['resource'])) {
            $this->db->like('p.resource', $filter['resource']);
        }
        if (isset($filter['skip_traced'])) {
            $this->db->where('p.skip_traced', 1);
        }
        if (isset($filter['id'])) {
            $this->db->where('p.id', $filter['id']);
        }
        if (isset($filter['property_name'])) {
            $this->db->like("CONCAT(p.property_first_name, ' ', p.property_last_name)", $filter['property_name']);
        }
        if (isset($filter['property_address'])) {
            $this->db->like("p.property_address", $filter['property_address']);
        }
        if (isset($filter['date_range'])) {
            $this->db->where($filter['date_range']);
        }
        if (isset($filter['date_range'])) {
            $this->db->where($filter['date_range']);
        }
        if (isset($filter['letter_no']) && (int)$filter['letter_no'] > 0) {
            $this->db->where('pm.letter_no', $filter['letter_no']);
        }
        if (isset($filter['date_range']) || isset($filter['letter_no'])) {
            $this->db->join('property_mailing pm', 'pm.property_id = p.id', 'left');
        }
        $this->db->order_by($order_by, 'asc');
        $result = $this->db->get('property p');
        // echo $this->db->last_query();exit;
        return $result->result();
    }

    public function save_replacement($replacement)
    {
        $result = array('success' => false);
        if ($this->db->insert('property_replacement', $replacement)) {
            $result['success'] = true;
        }
        return $result;
    }

    public function update_property_replacement($where = array(), $update = array()) 
    {
        $this->db->where($where);
        return $this->db->update('property_replacement', $update);
    }

    public function check_property_exists($property, $company_id)
    {
        $result = array('exist' => false);
        if ($property['status'] == 'draft') {
            return $result;
        }
        
        $similar_address = $this->generate_similar_address($property['property_address'], $company_id);
        $similar_address[] = strtolower($property['property_address']);
        $this->db->select('id, property_address, list_id, status');
        $this->db->where_in('LOWER(property_address)', $similar_address);
        $this->db->where('LOWER(property_city)', strtolower($property['property_city']));
        $this->db->where('LOWER(property_state)', strtolower($property['property_state']));
        $this->db->where('property_zipcode', $property['property_zipcode']);
        $this->db->where('company_id', $company_id);
        $this->db->where('deleted', 0);
        $this->db->where('active', 1);
        $this->db->where_not_in('status', ['replacement', 'duplicate']);
        if (isset($property['id'])) {
            $this->db->where('id !=', $property['id']);
        }
        $properties = $this->db->get('property');
        if ($properties->num_rows() > 0) {
            $result['exist'] = true;
            $result['properties'] = $properties->result();
        }
        return $result;
    }

    public function generate_similar_address($address, $company_id)
    {
        $abbreviations = $this->db->get_where('abbreviations', array('company_id' => $company_id))->result();
        $similar_address = array();
        $split_address = explode(" ", $address);
        $address = array();
        foreach ($split_address as $addr) {
            $address[] = array($addr);
        }
        for ($i = 0; $i < sizeof($address); $i++) {
            foreach ($abbreviations as $abbr) {
                if ($address[$i][0] == $abbr->abbr || $address[$i][0] == ($abbr->abbr . ".")) {
                    $address[$i][] = $abbr->value;
                    $address[$i][] = $abbr->abbr . ".";
                } else if ($address[$i][0] == $abbr->value) {
                    $address[$i][] = $abbr->abbr;
                    $address[$i][] = $abbr->abbr . ".";
                }
            }
            if (is_numeric($address[$i][0])) {
                $address[$i][] = "#" . $address[$i][0];
            } else if ($address[$i][0][0] == "#") {
                $address[$i][] = ltrim($address[$i][0], "#");
            }
        }

        $generated_address = $this->cartesian($address);
        $similar_address = array();
        foreach ($generated_address as $ga) {
            $similar_address[] = strtolower(implode(' ', $ga));
        }
        unset($similar_address[0]);
        return $similar_address;
    }

    // http://stackoverflow.com/questions/6311779/finding-cartesian-product-with-php-associative-arrays
    function cartesian($input) {
        $input = array_filter($input);
        $result = array(array());
        foreach ($input as $key => $values) {
            $append = array();
            foreach($result as $product) {
                foreach($values as $item) {
                    $product[$key] = $item;
                    $append[] = $product;
                }
            }
            $result = $append;
        }
        return $result;
    }

    function adjust_mailing($list) {
        $properties = $this->get(array('p.list_id' => $list['id']));
        $this->load->library('property_library');
        foreach ($properties as $property) {
            $this->db->order_by('mailing_date', 'desc');
            $mailings = $this->db->get_where('property_mailing', array('property_id' => $property->id))->result();
            if ($mailings) {
                // filter past and future
                $past_mailings = [];
                $future_mailings = [];
                foreach ($mailings as $mailing) {
                    if (strtotime($mailing->mailing_date) > strtotime("now")) {
                        $future_mailings[] = $mailing;
                    } else {
                        $past_mailings[] = $mailing;
                    }
                }
                // delete future mailings
                for ($i = 0; $i < sizeof($future_mailings); $i++) {
                    $this->db->where(array('id' => $future_mailings[$i]->id));
                    $this->db->delete('property_mailing');
                }
                // add the new adjust mailings
                $to_be_added = $list['no_of_letters'] - sizeof($past_mailings);
                if ($to_be_added > 0) {
                    $last_mail_date = sizeof($past_mailings) ? $past_mailings[0]->mailing_date : date('Y-m-d');
                    $last_letter_no = sizeof($past_mailings) ? $past_mailings[0]->letter_no : 0;
                    for ($i = 0; $i < $to_be_added; $i++) {
                        $mailing_date = $this->property_library->get_next_mailing_date(
                                $list['mailing_type'], $last_mail_date);
                        $last_letter_no = $last_letter_no + 1;
                        $new_mailing = [
                            'property_id' => $property->id,
                            'company_id' => $property->company_id,
                            'letter_no' => $last_letter_no,
                            'mailing_date' => $this->property_library->get_next_mailing_date(
                                $list['mailing_type'], $last_mail_date)
                        ]; 
                        $last_mail_date = $mailing_date;
                        $this->db->insert('property_mailing', $new_mailing);
                    }
                }
            }
        }
    }

    public function add_mailings($list_type, $no_of_letters, $property, $last_mail_date = null, $last_letter_no = 0) {
        $this->load->library('property_library');
        if (is_null($last_mail_date)) {
            $last_mail_date = date('Y-m-d');
        } else {
            $last_mail_date = date('Y-m-d', strtotime($last_mail_date));
        }
        for ($i = 0; $i < $no_of_letters; $i++) {
            $last_letter_no = $last_letter_no + 1;
            $new_mailing = [
                'property_id' => $property['id'],
                'company_id' => $property['company_id'],
                'letter_no' => $last_letter_no,
                'mailing_date' => $last_mail_date
            ]; 
            $this->db->insert('property_mailing', $new_mailing);
            $last_mail_date = $this->property_library->get_next_mailing_date(
                    $list_type, $last_mail_date);
        }
    }

    public function delete_mailings($where) {
        $this->db->where($where);
        return $this->db->delete('property_mailing'); 
    }

    public function get_history($where)
    {
        $this->db->order_by('date_created', 'desc');
        return $this->db->get_where('property_history', $where)->result();
    }

    public function add_history($history)
    {
        return $this->db->insert('property_history', $history);
    }

} 