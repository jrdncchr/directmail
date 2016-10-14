<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Role_model extends CI_Model {

    function __construct()
    {
        $this->load->database();
    }

    /*
     * roles
     */
    public function get($where = array(), $list = true)
    {
        $result = $this->db->get_where('roles', $where);
        return $list ? $result->result() : $result->row();
    }

    public function save($role)
    {
        if (isset($role['id']) && $role['id'] > 0) {
            $this->db->where('id', $role['id']);
            $this->db->update('roles', $role);
        } else {
            $this->db->insert('roles', $role);
            $role['id'] = $this->db->insert_id();
        }
        return array('success' => true, 'id' =>  $role['id']);
    }


    /*
     * roles_permission
     */
    public function get_permissions($role_id)
    {
        $this->db->select('rp.*, m.name, m.description, m.active, m.display_order, m.parent_id');
        $this->db->join('modules m', 'm.id = rp.module_id', 'left');
        $permission = $this->db->get_where('roles_permission rp', array('role_id' => $role_id))->result();
        if ($permission) {
            return $permission;
        } else {
            $this->_create_new_permissions_for_new_role($role_id);
            return $this->get_permissions($role_id);
        }
    }

    public function _create_new_permissions_for_new_role($role_id) {
        $modules = $this->db->get_where('modules', array('active' => 1))->result();
        foreach ($modules as $m) {
            $this->db->insert('roles_permission', array('module_id' => $m->id, 'role_id' => $role_id));
        }
    }

} 