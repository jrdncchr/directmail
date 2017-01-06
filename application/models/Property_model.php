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
            p.deceased_first_name, 
            p.deceased_last_name, 
            p.deceased_middle_name, 
            p.deceased_address,
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

        $this->load->library('property_library');
        $property['next_mailing_date'] = $this->property_library->get_next_mailing_date($property['mailing_type'], $property['mailing_date']);

        $property['last_update'] = date('Y-m-d H:i:s');
        if (isset($property['id']) && $property['id'] > 0) {
            $this->db->where('id', $property['id']);
            $this->db->update('property', $property);
        } else {
            $property['mailing_date'] = date('Y-m-d');
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
        if ($status == 'replacement') {
            $this->db->delete('property_replacement', array('property_id' => $id, 'company_id' => $company_id));
        }
        return $this->save(array('id' => $id, 'deleted' => 1));
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

    public function truncate_comment()
    {
        $this->db->truncate('property_comment');
    }

    public function get_pending_properties($company_id) 
    {
        $this->db->select('p.*, l.name as list_name, l.id as list_id');
        $this->db->join('list l', 'l.id = p.list_id');
        $this->db->where(array('l.company_id' => $company_id, 'p.status' => 'pending', 'p.deleted' => 0));
        $result = $this->db->get('property p');
        return $result->result();
    }

    public function get_replacement_properties($company_id) 
    {
        $this->db->select('p.*, 
            l.name as list_name, 
            l.id as list_id, 
            p2.id as target_id, 
            p2.deceased_address as target_deceased_address, 
            l2.name as target_list_name,
            l2.id as target_list_id');
        $this->db->join('list l', 'l.id = p.list_id', 'left');
        $this->db->join('property_replacement pr', 'pr.property_id = p.id', 'left');
        $this->db->join('property p2', 'p2.id = pr.target_property_id', 'left');
        $this->db->join('list l2', 'l2.id = p2.list_id', 'left');
        $this->db->where(array('l.company_id' => $company_id, 'p.status' => 'replacement', 'p.deleted' => 0, 'p.active' => 1));
        $result = $this->db->get('property p');
        return $result->result();
    }

    public function get_properties($company_id, $where = array(), $filter = array(), $order_by = 'p.id')
    {
        $where['p.company_id'] = $company_id;
        $this->db->select('p.*, l.name as list_name, l.id as list_id');
        $this->db->join('list l', 'l.id = p.list_id');
        $this->db->where($where);
        if (isset($filter['status'])) {
            $this->db->where('status', $filter['status']);
        }
        if (isset($filter['id'])) {
            $this->db->where('p.id', $filter['id']);
        }
        if (isset($filter['list'])) {
            $this->db->where('p.list_id', $filter['list']);
        }
        if (isset($filter['deceased_name'])) {
            $this->db->like("CONCAT(p.deceased_first_name, ' ', p.deceased_last_name)", $filter['deceased_name']);
        }
        if (isset($filter['deceased_address'])) {
            $this->db->like("p.deceased_address", $filter['deceased_address']);
        }
        if (isset($filter['today']) && $filter['today'] === 'true') {
            $this->db->where('p.next_mailing_date', date('Y-m-d'));
        }
        if (isset($filter['date_range'])) {
            $this->db->where($filter['date_range']);
        }
        $this->db->order_by($order_by, 'asc');
        $result = $this->db->get('property p');
        return $result->result();
    }

    public function save_replacement_approval($replacement)
    {
        $result = array('success' => false);
        $exist = $this->db->get_where('property_replacement', array(
            'property_id' => $replacement['property_id'],
            'company_id' => $replacement['company_id']
        ));
        
        if ($exist->num_rows() > 0) {
            $this->db->where(array('target_property_id' => $replacement['target_property_id'], 'company_id' => $replacement['company_id']));
            $save = $this->db->update('property_replacement', $replacement);
        } else {
            $save = $this->db->insert('property_replacement', $replacement);
        }
        if ($save) {
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
        $similar_address = $this->generate_similar_address($property['deceased_address'], $company_id);
        $similar_address[] = strtolower($property['deceased_address']);
        $this->db->select('id, deceased_address, list_id, status');
        $this->db->where_in('LOWER(deceased_address)', $similar_address);
        $this->db->where('LOWER(deceased_city)', strtolower($property['deceased_city']));
        $this->db->where('LOWER(deceased_state)', strtolower($property['deceased_state']));
        $this->db->where('deceased_zipcode', $property['deceased_zipcode']);
        $this->db->where('company_id', $company_id);
        $this->db->where('deleted', 0);
        $this->db->where('active', 1);
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

} 