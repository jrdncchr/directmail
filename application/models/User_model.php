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

        if (isset($auth['email']) && isset($auth['password']) && isset($auth['client'])) {
            // Check Client
            $client_result = $this->db->get_where('client', array('client_key' => $auth['client'], 'deleted' => 0));
            if (!$client_result->num_rows()) {
                $result['message'] = "Client does not exist.";
                return $result;
            }
            $client = $client_result->row();

            $result['message'] = "Incorrect email or password.";
            // Check User
            $where = array(
                'email' => $auth['email'],
                'client_id' => $client->id,
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
            if (hash_equals($user_secret->password, crypt($auth['password'], $user_secret->password))) {
                $result = array('success' => true);
                $this->session->set_userdata('user', $user);
            }
        }
        return $result;
    }

    public function register($info)
    {
        $result = array('success' => false);

        if ($info['password'] != $info['confirm_password']) {
            $result['message'] = "Passwords did not match.";
            return $result;
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
                'client_id'     => $info['client_id']
            )
        );
        $user_id = $this->db->insert_id();

        $salt = generate_random_str(20);
        $password = crypt($info['password'], $salt);
        $this->db->insert('user_secret',
            array(
                'user_id'           => $user_id,
                'password'          => $password,
                'confirmation_key'  => generate_random_str(100)
            )
        );
        $result['success'] = true;
        $result['user_id'] = $user_id;

        return $result;
    }

    /*
     * Default CRUD
     */
    public function get($where = array(), $list = true)
    {
        $result = $this->db->get_where('user', $where);
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