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

        $exist = $this->get(array('u.email' => $info['email']), false);
        if ($exist) {
            $result['message'] = "Email address already exists.";
            return $result;
        }

        $this->db->insert('user',
            array(
                'email'         => $info['email'],
                'first_name'    => $info['first_name'],
                'last_name'     => $info['last_name'],
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

    public function add_test_user($user)
    {
        $this->db->insert('user', $user);
        $user_id = $this->db->insert_id();

        $salt = generate_random_str(20);
        $password = crypt('jordan', $salt);
        $confirmation_key = generate_random_str(100);
        $this->db->insert('user_secret',
            array(
                'user_id'           => $user_id,
                'password'          => $password,
                'confirmation_key'  => $confirmation_key
            )
        );
    }

    public function truncate()
    {
        $this->db->truncate('user');
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

    /*
     * user_module_permission
     */
    public function get_module_permissions($user_id)
    {
        $this->db->select('m.id as _id, m.name, m.code, m.description, m.active, m.display_order, m.parent_id, ump.*');
        $this->db->join('user_module_permission ump', 'ump.module_id = m.id AND ump.user_id = ' . $user_id, 'left');
        $result = $this->db->get_where('modules m')->result();

        if ($result) {
            $modules = array();
            foreach ($result as $module) {
                if ($module->parent_id == 0) {
                    $child_modules = [];
                    foreach ($result as $child_module) {
                        if ($child_module->parent_id == $module->_id) {
                            $child_modules[] = $child_module;
                        }
                    }
                    usort($child_modules, function($a, $b) {
                        return strcmp($a->display_order, $b->display_order);
                    });
                    $module->children = $child_modules;
                    $modules[] = $module;
                }
            }

            usort($modules, function($a, $b) {
                return strcmp($a->display_order, $b->display_order);
            });
            return $modules;
        } else {
            $this->_create_new_module_permissions_for_new_user($user_id);
            return $this->get_module_permissions($user_id);
        }
    }

    public function _create_new_module_permissions_for_new_user($user_id)
    {
        $modules = $this->db->get_where('modules', array('active' => 1))->result();
        foreach ($modules as $m) {
            $this->db->insert('user_module_permission', array('module_id' => $m->id, 'user_id' => $user_id));
        }
    }

    public function save_module_permissions($user_id, $module_permissions)
    {
        foreach ($module_permissions as $mp) {
            $permission = array(
                'create_action'     => filter_var($mp['create_action'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                'retrieve_action'   => filter_var($mp['retrieve_action'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                'update_action'     => filter_var($mp['update_action'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                'delete_action'     => filter_var($mp['delete_action'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                'last_update'       => date("Y-m-d H:i:s")
            );
            if ($mp['id']) {
                $this->db->where('id', $mp['id']);
                $this->db->update('user_module_permission', $permission);
            } else {
                $permission['module_id'] = $mp['_id'];
                $permission['user_id'] = $user_id;
                $this->db->insert('user_module_permission', $permission);
            }
            if (isset($mp['children'])) {
                foreach ($mp['children'] as $child) {
                    $child_permission = array(
                        'create_action'     => filter_var($child['create_action'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                        'retrieve_action'   => filter_var($child['retrieve_action'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                        'update_action'     => filter_var($child['update_action'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                        'delete_action'     => filter_var($child['delete_action'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                        'last_update'       => date("Y-m-d H:i:s")
                    );
                    if ($child['id']) {
                        $this->db->where('id', $child['id']);
                        $this->db->update('user_module_permission', $child_permission);
                    } else {
                        $child_permission['module_id'] = $child['_id'];
                        $child_permission['user_id'] = $user_id;
                        $this->db->insert('user_module_permission', $child_permission);
                    }
                }
            }

        }
        return array('success' => true);
    }

    /*
     * user_list_category_permission
     */
    public function get_list_category_permissions($user_id, $company_id)
    {
        $this->db->select('lc.id as _id, lc.name, lc.description, lc.active, ulcp.*');
        $this->db->join('user_list_category_permission ulcp', 'ulcp.list_category_id = lc.id AND ulcp.user_id = ' . $user_id, 'left');
        $this->db->where(array('lc.active' => 1, 'lc.deleted' => 0));
        $permission = $this->db->get('list_category lc')->result();
        if ($permission) {
            return $permission;
        } else {
            $this->_create_new_list_category_permissions_for_new_user($user_id, $company_id);
            return $this->get_list_category_permissions($user_id, $company_id);
        }
    }

    public function _create_new_list_category_permissions_for_new_user($user_id, $company_id)
    {
        $list_categories = $this->db->get_where('list_category', array('active' => 1, 'company_id' => $company_id))->result();
        foreach ($list_categories as $lc) {
            $this->db->insert('user_list_category_permission', array('list_category_id' => $lc->id, 'user_id' => $user_id));
        }
    }

    public function save_list_category_permissions($user_id, $list_category_permissions)
    {
        foreach ($list_category_permissions as $lcp) {
            $permission = array(
                'create_action'     => filter_var($lcp['create_action'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                'retrieve_action'   => filter_var($lcp['retrieve_action'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                'update_action'     => filter_var($lcp['update_action'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                'delete_action'     => filter_var($lcp['delete_action'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                'last_update'       => date("Y-m-d H:i:s")
            );
            if ($lcp['id']) {
                $this->db->where('id', $lcp['id']);
                $this->db->update('user_list_category_permission', $permission);
            } else {
                $permission['list_category_id'] = $lcp['_id'];
                $permission['user_id'] = $user_id;
                $this->db->insert('user_list_category_permission', $permission);
            }
            if (isset($lcp['children'])) {
                foreach ($lcp['children'] as $child) {
                    $this->save_list_permissions($user_id, $child);
                }
            }
        }
        return array('success' => true);
    }

    /*
     * user_list_permission
     */
    public function get_list_permissions($user_id, $company_id)
    {
        $this->db->select('l.id as _id, l.name, l.active, l.list_category_id, ulp.*');
        $this->db->join('user_list_permission ulp', 'ulp.list_id = l.id AND ulp.user_id = ' . $user_id, 'left');
        $this->db->where(array('l.active' => 1, 'l.deleted' => 0));
        $permission = $this->db->get('list l')->result();
        if ($permission) {
            return $permission;
        } else {
            $this->_create_new_list_permissions_for_new_user($user_id, $company_id);
            return $this->get_list_permissions($user_id, $company_id);
        }
    }

    public function _create_new_list_permissions_for_new_user($user_id, $company_id)
    {
        $list = $this->db->get_where('list', array('active' => 1, 'company_id' => $company_id))->result();
        foreach ($list as $l) {
            $this->db->insert('user_list_permission', array('list_id' => $l->id, 'user_id' => $user_id));
        }
    }

    public function _create_list_permission($user_id, $list_id)
    {
        $this->db->insert('user_list_permission', array(
            'list_id' => $list_id, 
            'user_id' => $user_id,
            'create_action' => 1,
            'retrieve_action' => 1,
            'update_action' => 1,
            'delete_action' => 1
            )
        );
    }

    public function save_list_permissions($user_id, $list)
    {
        $permission = array(
            'create_action'     => filter_var($list['create_action'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
            'retrieve_action'   => filter_var($list['retrieve_action'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
            'update_action'     => filter_var($list['update_action'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
            'delete_action'     => filter_var($list['delete_action'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
            'last_update'       => date("Y-m-d H:i:s")
        );
        if ($list['id']) {
            $this->db->where('id', $list['id']);
            $this->db->update('user_list_permission', $permission);
        } else {
            $permission['list_id'] = $list['_id'];
            $permission['user_id'] = $user_id;
            $this->db->insert('user_list_permission', $permission);
        }
        return array('success' => true);
    }

    public function get_category_with_list_permission($user_id, $company_id)
    {
        $list_category_permissions = $this->get_list_category_permissions($user_id, $company_id);
        $list_permissions = $this->get_list_permissions($user_id, $company_id);
        foreach ($list_category_permissions as $lcp) {
            $children = [];
            foreach ($list_permissions as $lp) {
                if ($lp->list_category_id == $lcp->_id) {
                    $children[] = $lp;
                }
            }
            $lcp->children = $children;
        }
        return $list_category_permissions;
    }
} 