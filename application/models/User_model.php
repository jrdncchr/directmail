<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class User_model extends CI_Model {

    function __construct()
    {
        $this->load->database();
    }

    /*
     * Authentication / Registration
     */
    public function login(array $auth, $admin = false)
    {
        $result = array('success' => false, 'message' => "Login failed.");

        if (isset($auth['email']) && isset($auth['password']) && isset($auth['company'])) {
            // Check Company
            $company_result = $this->db->get_where('company', array('company_key' => $auth['company'], 'deleted' => 0));
            if (!$company_result->num_rows()) {
                $result['message'] = "Company does not exist.";
                return $result;
            }
            $company = $company_result->row();

            $result['message'] = "Incorrect email or password.";
            // Check User
            $where = array(
                'email' => $auth['email'],
                'company_id' => $company->id,
                'deleted' => 0
            );
            if ($admin) {
                $where['is_admin'] = 1;
            }
            $user_result = $this->db->get_where('user', $where);
            if (!$user_result->num_rows()) {
                return $result;
            }
            $user = $user_result->row();

            // Check Password
            $user_secret = $this->db->get_where('user_secret', array('user_id' => $user->id))->row();
            if (!hash_equals($user_secret->password, crypt($auth['password'], $user_secret->password))) {
                return $result;
            }

            // Check if confirmed
            if ($user->confirmed == 0) {
                $result['message'] = "Verify your email address.";
                return $result;
            }

            $user->company = $this->db->get_where('company', array('id' => $user->company_id))->row();
            $result = array('success' => true);
            $this->session->set_userdata('user', $user);
        }
        return $result;
    }

    public function register($info, $manually_added = false)
    {
        $result = array('success' => false);

        if (!$manually_added) {
            if ($info['password'] != $info['confirm_password']) {
                $result['message'] = "Passwords did not match.";
                return $result;
            }
        } else {
            $info['password'] = generate_random_str(10);
        }

        $exist = $this->get(array('email' => $info['email'], 'deleted' => 0), false);
        if ($exist) {
            $result['message'] = "Email address already exists.";
            return $result;
        }

        $this->db->insert('user',
            array(
                'email'         => $info['email'],
                'first_name'    => $info['first_name'],
                'last_name'     => $info['last_name'],
                'birth_date'    => $info['birth_date'],
                'contact_no'    => $info['contact_no'],
                'company_id'    => $info['company_id'],
                'role_id'       => isset($info['role_id']) ? $info['role_id'] : ''
            )
        );
        $user_id = $this->db->insert_id();

        $salt = generate_random_str(20);
        $password = crypt($info['password'], $salt);
        $confirmation_key = generate_random_str(100);
        $this->db->insert('user_secret',
            array(
                'user_id'           => $user_id,
                'password'          => $password,
                'confirmation_key'  => $confirmation_key
            )
        );

        $this->load->library('email_library');
        $email_data = array(
            'to' => $info['email'],
            'name' => $info['first_name'],
            'company' => $info['company_name'],
            'confirmation_key' => $confirmation_key
        );
        if ($manually_added) {
            $email_data['password'] = $info['password'];
        }
        $this->email_library->send_email_confirmation($email_data);

        $result['success'] = true;
        $result['user_id'] = $user_id;
        return $result;
    }

    public function confirm($confirmation_key)
    {
        $result = array('success' => false);
        $user_result = $this->db->get_where('user_secret', array('confirmation_key' => $confirmation_key));
        if ($user_result->num_rows() > 0) {
            $user = $user_result->row();
            $this->db->where('id', $user->user_id);
            $this->db->update('user', array('confirmed' => 1));
            $result['success'] = true;
            $result['message'] = "Account confirmed! You may now login.";
        }
        return $result;
    }

    public function change_password($user_id, $new_password)
    {
        $result['success'] = false;
        $salt = generate_random_str(20);
        $password = crypt($new_password, $salt);
        $this->db->where('user_id', $user_id);
        if ($this->db->update('user_secret', array('password' => $password))) {
            $result['success'] = true;
        } else {
            $result['message'] = 'Something went wrong.';
        }
        return $result;
    }

    /*
     * Default CRUD
     */
    public function get($where = array(), $list = true)
    {
        $where['u.deleted'] = 0;
        $this->db->select('u.*, r.name as role_name');
        $this->db->join('roles r', 'r.id = u.role_id', 'left');
        $result = $this->db->get_where('user u', $where);
        return $list ? $result->result() : $result->row();
    }

    public function save($user)
    {
        $result['success'] = false;
        $this->db->where('id', $user['id']);
        if ($this->db->update('user', $user)) {
            $result['success'] = true;
        }
        return $result;
    }

} 