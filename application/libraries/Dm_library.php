<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Dm_library {

    public function getStatusesForSelect2($exclude = []) 
    {
        $result = [];
        $CI =& get_instance();

        $statuses = $CI->config->item('statuses');
        if (sizeof($exclude) > 0) {
            foreach ($exclude as $e) {
                $key = array_search($e, $statuses);
                array_splice($statuses, $key, 1);
            }
        }
        foreach ($statuses as $status) {
            $result[] = [
                'id' => $status,
                'text' => ucfirst($status)
            ];
        }
        return $result;
    }

    public function getListsForSelect2($companyId)
    {
        $result = [['id' => 'all', 'text' => 'All']];
        $CI =& get_instance();
        $CI->load->model('list_model');

        $lists = $CI->list_model->get(array('l.company_id' => $companyId, 'active' => 1));
        foreach ($lists as $list) {
            $result[] = [
                'id' => $list->id,
                'text' => $list->name
            ];
        }
        return $result;
    }

    public function getFromModulesForDownloadHistory()
    {
        $result = [['id' => 'all', 'text' => 'All']];
        $CI =& get_instance();
        $CI->load->model('module_model');

        $modules = $CI->module_model->get_where(array('active' => 1, 'track_download_history' => 1));
        foreach ($modules as $module) {
            $code = explode('-', $module->code);
            $text = implode(' ', array_map('ucfirst', $code));
            $result[] = [
                'id' => $module->code,
                'text' => $text
            ];
        }
        return $result;
    }

}
