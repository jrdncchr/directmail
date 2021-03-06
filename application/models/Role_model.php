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
            $this->db->delete('roles_list_permission', array('role_id' => $role_id));
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
            $this->_create_new_module_permissions_for_new_role($role_id);
            return $this->get_module_permissions($role_id);
        }
    }

    public function _create_new_module_permissions_for_new_role($role_id, $default_role = false)
    {
        $modules = $this->db->get_where('modules', array('active' => 1))->result();
        foreach ($modules as $m) {
            if (!$default_role) {
                $this->db->insert('roles_module_permission', array('module_id' => $m->id, 'role_id' => $role_id));    
            } else {
                $this->db->insert('roles_module_permission', array(
                    'module_id' => $m->id, 
                    'role_id' => $role_id,
                    'create_action' => 1,
                    'retrieve_action' => 1,
                    'update_action' => 1,
                    'delete_action' => 1)
                );
            }
            
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
                $permission['module_id'] = $mp['_id'];
                $permission['role_id'] = $role_id;
                $this->db->insert('roles_module_permission', $permission);
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
                        $this->db->update('roles_module_permission', $child_permission);
                    } else {
                        $child_permission['module_id'] = $child['_id'];
                        $child_permission['role_id'] = $role_id;
                        $this->db->insert('roles_module_permission', $child_permission);
                    }
                }
            }

        }
        return array('success' => true);
    }

    /*
     * roles_list_permission
     */
    public function save_list_permissions($role_id, $list_permissions)
    {
        foreach ($list_permissions as $lp) {
            $permission = array(
                'create_action'     => filter_var($lp['create_action'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                'retrieve_action'   => filter_var($lp['retrieve_action'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                'update_action'     => filter_var($lp['update_action'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                'delete_action'     => filter_var($lp['delete_action'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                'last_update'       => date("Y-m-d H:i:s")
            );
            if ($lp['id']) {
                $this->db->where('id', $lp['id']);
                $this->db->update('roles_list_permission', $permission);
            } else {
                $permission['list_id'] = $lp['_id'];
                $permission['role_id'] = $role_id;
                $this->db->insert('roles_list_permission', $permission);
            }
        }
        return array('success' => true);
    }

    public function get_list_permissions($role_id, $company_id)
    {
        $this->db->select('l.id as _id, l.name, l.active, rlp.*');
        $this->db->join('roles_list_permission rlp ', 'rlp.list_id = l.id AND rlp.role_id = ' . $role_id, 'left');
        $this->db->where(array('l.deleted' => 0, 'l.active' => 1, 'l.company_id' => $company_id));
        $this->db->order_by('l.name', 'asc');
        $permission = $this->db->get('list l')->result();
        if ($permission) {
            return $permission;
        } else {
            $this->_create_new_list_permissions_for_new_role($role_id, $company_id);
            return $this->get_list_permissions($role_id, $company_id);
        }
    }

    public function _create_new_list_permissions_for_new_role($role_id, $company_id)
    {
        $list = $this->db->get_where('list', array('active' => 1, 'company_id' => $company_id))->result();
        foreach ($list as $l) {
            $this->db->insert('roles_list_permission', array('list_id' => $l->id, 'role_id' => $role_id));
        }
    }

} 