<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class User_model extends CI_Model {

    private $tbl = 'user';

    function __construct() {
        $this->load->database();
    }

    /*
     * Default CRUD
     */
    public function get($where = array(), $list = true)
    {
        $result = $this->db->get_where($this->tbl, $where);
        return $list ? $result->result() : $result->row();
    }

    public function save($user)
    {
        if(isset($user['password'])) {
            $salt = generate_random_str(20);
            $user['password'] = crypt($user['password'], $salt);
        }
        if(isset($user['id'])) {
            $this->db->where('id', $user['id']);
            $this->db->update($this->tbl, $user);
        } else {
            $this->db->insert($this->tbl, $user);
            $user['id'] = $this->db->insert_id();
        }
        return array('success' => true, 'user_id' => $user['id']);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->tbl);
        return array('success' => true);
    }

    /*
     * Auth
     */
    public function login(array $auth, $admin = false)
    {
        $result = array('success' => false,  'message' => 'Incorrect Email or Password.');
        if(isset($auth['email']) && isset($auth['password'])) {
            $where = array('email' => $auth['email']);
            if($admin) {
                $where['is_admin'] = 1;
            }
            $user_result = $this->db->get_where($this->tbl, $where);
            if($user_result->num_rows() > 0) {
                $user = $user_result->row();
                if (hash_equals($user->password, crypt($auth['password'], $user->password))) {
                    $user_details = $this->get(array('id' => $user->id), false);
                    $result = array('success' => true);
                    $_SESSION['user'] = $user_details;
                    $this->session->set_userdata('user', $user_details);
                }
            }
        }
        return $result;
    }

    public function add_test_user()
    {
        $user = array(
            'email' => 'danero.jrc@gmail.com',
            'password' => 'jordan',
            'name' => 'CCW Inc.'
        );
        $this->save($user);
    }

} 