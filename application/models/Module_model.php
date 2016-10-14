<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Module_model extends CI_Model {

    function __construct()
    {
        $this->load->database();
    }

    public function get()
    {
        $result = $this->db->get_where('modules', array('active' => 1))->result();

        $modules = array();
        foreach ($result as $module) {
            if ($module->parent_id == 0) {
                $child_modules = [];
                foreach ($result as $child_module) {
                    if ($child_module->parent_id == $module->id) {
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
    }

} 