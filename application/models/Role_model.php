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
        $this->db->order_by('name');
        $where['deleted'] = 0;
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

    public function delete($role_id, $company_id)
    {
        $result = array('success' => false);
        $users_role = $this->db->get_where('user', array('role_id' => $role_id, 'company_id' => $company_id));
        if ($users_role->num_rows() > 0) {
            $result['message'] = "Cannot delete because there are users assigned to this role.";
        } else {
            $result = $this->save(array('id' => $role_id, 'deleted' => 1));
            $this->db->delete('roles_module_permission', array('role_id' => $role_id));
            $this->db->delete('roles_list_category_permission', array('role_id' => $role_id));
        }
        return $result;
    }


    /*
     * roles_module_permission
     */
    public function get_module_permissions($role_id)
    {
        $this->db->select('m.id as _id, m.name, m.code, m.description, m.active, m.display_order, m.parent_id, rmp.*');
        $this->db->join('roles_module_permission rmp', 'rmp.module_id = m.id AND rmp.role_id = ' . $role_id, 'left');
        $permission = $this->db->get_where('modules m')->result();
        if ($permission) {
            return $permission;
        } else {
            $this->_create_new_module_permissions_for_new_role($role_id);
            return $this->get_module_permissions($role_id);
        }
    }

    public function _create_new_module_permissions_for_new_role($role_id)
    {
        $modules = $this->db->get_where('modules', array('active' => 1))->result();
        foreach ($modules as $m) {
            $this->db->insert('roles_module_permission', array('module_id' => $m->id, 'role_id' => $role_id));
        }
    }

    public function save_module_permissions($role_id, $module_permissions)
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
                $this->db->update('roles_module_permission', $permission);
            } else {
                $permission['module_id'] = $mp['m_id'];
                $permission['role_id'] = $role_id;
                $this->db->insert('roles_module_permission', $permission);
            }
        }
        return array('success' => true);
    }

    /*
     * roles_list_category_permission
     */
    public function get_list_category_permissions($role_id, $category_id)
    {
        $this->db->select('lc.id as _id, lc.name, lc.description, lc.active, rlcp.*');
        $this->db->join('roles_list_category_permission rlcp', 'rlcp.list_category_id = lc.id AND rlcp.role_id = ' . $role_id, 'left');
        $permission = $this->db->get_where('list_category lc')->result();
        if ($permission) {
            return $permission;
        } else {
            $this->_create_new_list_category_permissions_for_new_role($role_id, $category_id);
            return $this->get_list_category_permissions($role_id, $category_id);
        }
    }

    public function _create_new_list_category_permissions_for_new_role($role_id, $company_id)
    {
        $list_categories = $this->db->get_where('list_category', array('active' => 1, 'company_id' => $company_id))->result();
        foreach ($list_categories as $lc) {
            $this->db->insert('roles_list_category_permission', array('list_category_id' => $lc->id, 'role_id' => $role_id));
        }
    }

    public function save_list_category_permissions($role_id, $list_category_permissions)
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
                $this->db->update('roles_list_category_permission', $permission);
            } else {
                $permission['list_category_id'] = $lcp['lc_id'];
                $permission['role_id'] = $role_id;
                $this->db->insert('roles_list_category_permission', $permission);
            }
        }
        return array('success' => true);
    }

} 