<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Company_model extends CI_Model {

    function __construct()
    {
        $this->load->database();
    }

    /*
     * Default CRUD
     */
    public function get($where = array(), $list = true)
    {
        $this->db->select('company.*, user.first_name, user.last_name, user.id as user_id, user.email');
        $this->db->join('user', 'user.id = company.admin_id', 'left');
        $result = $this->db->get_where('company', $where);
        return $list ? $result->result() : $result->row();
    }

    public function save($company)
    {
        if (isset($company['id'])) {
            $this->db->where('id', $company['id']);
            $this->db->update('company', $company);
        } else {
            $this->db->insert('company', $company);
            $company['id'] = $this->db->insert_id();
        }
        return array('success' => true, 'id' =>  $company['id']);
    }

    /*
     * New company creation
     */
    public function create($company, $user)
    {
        $result = array('success' => false);
        // Validate company
        $where = array('deleted' => 0, 'status' => 'active');
        $company_name_exist = $this->db->get_where('company', array_merge($where, array('name' => $company['name'])))->num_rows();
        if ($company_name_exist) {
            $result['message'] = "Company Name already exist.";
            return $result;
        }
        $company_key_exist = $this->db->get_where('company', array_merge($where, array('company_key' => $company['company_key'])))->num_rows();
        if ($company_key_exist) {
            $result['message'] = "Company Key already exist.";
            return $result;
        }

        // Validate user
        $user_email_exist = $this->db->get_where('user', array('email' => $user['email'], 'deleted' => 0))->num_rows();
        if ($user_email_exist) {
            $result['message'] = "User email already exist.";
            return $result;
        }

        // Save company
        $save_company = $this->save($company);
        if (!$save_company['success']) {
            $result['message'] = "Something went wrong on saving the company.";
            return $result;    
        }
        $company['id'] = $save_company['id'];

        // Add default role on new company
        $CI =& get_instance();
        $CI->load->model('role_model');
        $default_role = $CI->role_model->save(array(
            'name' => 'Administrator',
            'description' => 'Default role on a new company.',
            'company_id' => $company['id']));
        $CI->role_model->_create_new_module_permissions_for_new_role($default_role['id'], true);

        // Save user
        $user['company_id'] = $company['id'];
        $user['role_id'] = $default_role['id'];
        $this->db->insert('user', $user);
        $user_id = $this->db->insert_id();

        // Update company admin_id
        $this->save(array('id' => $company['id'], 'admin_id' => $user_id));

        // Save user secrets
        $pw = generate_random_str(10);
        $salt = generate_random_str(20);
        $password = crypt($pw, $salt);
        $confirmation_key = generate_random_str(100);
        $this->db->insert('user_secret',
            array(
                'user_id'           => $user_id,
                'password'          => $password,
                'confirmation_key'  => $confirmation_key
            )
        );

        // Send Email confirmation
        $this->load->library('email_library');
        $email_data = array(
            'to' => $user['email'],
            'name' => $user['first_name'] . " " . $user['last_name'],
            'company' => $company['name'],
            'company_key' => $company['company_key'],
            'password' => $pw, 
            'confirmation_key' => $confirmation_key
        );
        $this->email_library->send_new_company_email_confirmation($email_data);

        $result['success'] = true;
        $result['user_id'] = $user_id;
        $result['company_id'] = $company['id'];
        return $result;
    }

} 