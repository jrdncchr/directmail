<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class List_library {

    private $CI;

    function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->library('session');
    }

    public function bulk_import($list)
    {
        // set_time_limit(0);
        // ini_set('max_execution_time', 30000);
        // ini_set('memory_limit', '8192M');

        $result = array(
            'similars' => array(),
            'saved' => array()
        );
        $path = $_FILES["file"]["tmp_name"];
        $objPHPExcel = PHPExcel_IOFactory::load($path);
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
         $this->CI->load->model('property_model');

        $last_inserted = $this->CI->property_model->get_last_inserted_row()->id;
        $property_id = $last_inserted == null ? 0 : $last_inserted;
        $property_id++;

        $properties = array();
        for ($row = 2; $row <= $highestRow; ++ $row) {
            $property = array();
            $property['id'] = $property_id;
            $property_id++;
            $property['row'] = $row;
            $property['created_by'] = $this->CI->logged_user->id;
            $property['last_update'] = date('Y-m-d H:i:s');
            $property['company_id'] = $this->CI->logged_user->company_id;
            for ($col = 0; $col < $highestColumnIndex; ++ $col) {
                $cell = $sheet->getCellByColumnAndRow($col, $row);
                $val = $cell->getValue();
                if (!$val) {
                    $val = '';
                }
                switch ($col) {
                    case 0 : $property['list_id'] = $val; break;
                    case 1 : $property['resource'] = $val; break;
                    case 2 : $property['property_first_name'] = $val; break;
                    case 3 : $property['property_middle_name'] = $val; break;
                    case 4 : $property['property_last_name'] = $val; break;
                    case 5 : $property['property_address'] = $val; break;
                    case 6 : $property['property_city'] = $val; break;
                    case 7 : $property['property_state'] = $val; break;
                    case 8 : $property['property_zipcode'] = $val; break;
                    case 9 : $property['pr_first_name'] = $val; break;
                    case 10 : $property['pr_middle_name'] = $val; break;
                    case 11 : $property['pr_last_name'] = $val; break;
                    case 12 : $property['pr_address'] = $val; break;
                    case 13 : $property['pr_city'] = $val; break;
                    case 14 : $property['pr_state'] = $val; break;
                    case 15 : $property['pr_zipcode'] = $val; break;
                    case 16 : $property['attorney_name'] = $val; break;
                    case 17 : $property['attorney_first_address'] = $val; break;
                    case 18 : $property['attorney_second_address'] = $val; break;
                    case 19 : $property['attorney_city'] = $val; break;
                    case 20 : $property['attorney_state'] = $val; break;
                    case 21 : $property['attorney_zipcode'] = $val; break;
                    case 22 : $property['mail_first_name'] = $val; break;
                    case 23 : $property['mail_last_name'] = $val; break;
                    case 24 : $property['mail_address'] = $val; break;
                    case 25 : $property['mail_city'] = $val; break;
                    case 26 : $property['mail_state'] = $val; break;
                    case 27 : $property['mail_zipcode'] = $val; break;
                    case 28 : $property['mailing_date'] = gmdate('Y-m-d', (($val - 25569) * 86400)); break;
                    case 29 : $property['status'] = $val ? strtolower($val) : 'draft'; break;
                    case 30 : $property['comment'] = $val; break;
                    case 31 : $property['skip_traced'] = $val != 1 ? 0 : 1; break;
                }
            }
            if ($property['list_id'] == $list->id) {
                $properties[] = $property;
            }
        }

        $result['duplicates'] = [];
        $result['saved'] = [];
        $inserts = [];
        $mailing_dates = [];
        $comments = [];
        $histories = [];
        $replacements = [];

        foreach ($properties as $property) {
             $property['property_link'] = base_url() . 'lists/property/' . $list->id . '/info/' . $property['id'];

            // check if its a duplicate or similar to a property
            $check_property = $this->CI->property_model->check_property_exists($property, $this->CI->logged_user->company_id);
            if ($check_property['exist']) {
                $similar = $check_property['properties'][0];
                $similar->permission = $this->CI->_checkListPermission($similar->list_id, 'retrieve');
                $similar->url = base_url() . "lists/property/". $similar->list_id . "/info/" . $similar->id;
                $similar->list = $this->CI->list_model->get(['l.id' => $similar->list_id], false);
                if ($similar->list) {
                    $similar->list->url = base_url() . "lists/info/" . $similar->list_id;   
                }
                $property['status'] = 'duplicate';
                $property['similar'] = $similar;
                $result['duplicates'][] = $property;

                // replacements
                $replacement = [
                    'property_id' => $property['id'],
                    'target_property_id' => $similar->id,
                    'company_id' => $this->CI->logged_user->company_id
                ];
                $replacements[] = $replacement;
            } else {
                $result['saved'][] = $property;
            }

            // mailing adtes
            $property_mailing_dates = $this->CI->property_model->generate_mailings(
                $list->mailing_type, 
                $list->no_of_letters, 
                $property,
                $property['mailing_date']
            ); 
            $mailing_dates = array_merge($mailing_dates, $property_mailing_dates);

            // comments
            if ($property['comment']  && $property['comment'] !== '') {
                $comment = [
                    'property_id' => $property['id'],
                    'comment' => $property['comment'],
                    'type' => 'comment',
                    'user_id' => $this->CI->logged_user->id
                ];
                $comments[] = $comment;
            }

            // history
            $history = [
                'property_id' => $property['id'],
                'message' => 'Added using bulk import by user id ' . $this->CI->logged_user->id,
                'company_id' => $this->CI->logged_user->company_id
            ];
            $histories[] = $history;

            unset($property['row']);
            unset($property['mailing_date']);
            unset($property['comment']);
            unset($property['similar']);
            unset($property['property_link']);
            $inserts[] = $property;
        }
        // insertion by batch
        if (!$this->CI->property_model->save_bulk_import($inserts, $mailing_dates, $comments, $histories, $replacements)) {
            exit('Something went wrong with the import.');
        }

        // log user action
        $this->CI->dm_library->insert_user_log([
            'user_id' => $this->CI->logged_user->id,
            'log' => "Bulk import in the list " . $list->id . " [" . $list->name . "]. Resulting to " . sizeof($inserts) . " insertions with . " . sizeof($replacements) . " duplicate properties." ,
            'link' => base_url() . "lists/info/" . $list->id
        ]);

        return $result;
    }

    function send_message($progress) {
        $d = array('progress' => $progress);
         
        echo "data: " . json_encode($d) . PHP_EOL;
        echo PHP_EOL;
         
        ob_flush();
        flush();
    }
    
}