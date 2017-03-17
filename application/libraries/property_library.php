<?php

if (!defined('BASEPATH'))
	exit('No direct access is allowed!');

class Property_Library {

	private $CI;

	function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->model('property_model');
		$this->CI->load->library('session');
	}

	public function confrim_replacement_action($action, $property_id, $target_property_id)
	{
		$this->CI->load->model('property_model');
		switch($action) {
			case 1: 
				$id = !is_array($property_id) ? $property_id : $property_id['id'];
				return $this->CI->property_model->delete($id, $this->CI->logged_user->company_id);
			case 2: // replace the target property address only
				return $this->replace('replaced_address_only', $property_id, $target_property_id);
				break;
			case 3: // replace the entire target property info only
				return $this->replace('replaced_property_info_only', $property_id, $target_property_id);
				break;
			case 4: // replace the entire target property info including the list, mailings, comments it belongs to
				return $this->replace('replaced_all', $property_id, $target_property_id, true);
				break;
			case 5: // save the property with status of active
				return $this->replace('keep_both', $property_id, $target_property_id);
				break;
		}
	}

	/*
	 * Proccess the pending replacements.
	 * 
	 * @param (string) $status - rejected, replaced_address_only, replaced_all
	 * @param (int/object) $property
	 * @param (int) $target_property_id 
	 * @param (boolean) $replace_list - if the method will also replace the list
	 * @return (type)
	 */
	public function replace($status, $property, $target_property_id, $replace_list = false)
	{
		$message = "";
		if (!is_array($property)) {
			$property = $this->CI->property_model->get(['p.id' => $property], false);
		} else {
			$property = (object) $property;
		}
		$property_id = null;
		if (isset($property->id)) {
			$property_id = $property->id;
		}

		$property = (array) $property;
		$property['status'] = 'active';
		$property['last_update'] = date('Y-m-d H:i:s');

		if ($status !== 'rejected') {
			$target_property = $this->CI->property_model->get_by_id($target_property_id, $this->CI->logged_user->company_id);
			if ($status === 'replaced_address_only') {
				if ($this->CI->property_model->update(['id' => $property_id], ['property_address' => $property['property_address']])) {
					$this->CI->property_model->delete($property_id, $this->CI->logged_user->company_id);
				}
			} else if ($status === 'replaced_all' || $status === 'replaced_property_info_only' || $status === 'keep_both') {
				$property_comments = $property['comment'];
				$mailing_date = $property['mailing_date'];
				unset($property['comment']);
				unset($property['mailing_date']);
				unset($property['id']);
				unset($property['company_id']);
				unset($property['deleted']);
				unset($property['date_created']);
				unset($property['target_property_id']);
				unset($property['pr_list_id']);
				unset($property['pr_url']);
				if (isset($property['check'])) {
					unset($property['check']);
				}
				if (isset($property['row'])) {
					unset($property['row']);
				}
				if (!$replace_list) {
					unset($property['list_id']);
				} else {
					$target_property->list_id = $property['list_id'];
				}
			}

			// Replace All
			if ($status === 'replaced_all') {
				$list_id = isset($property['list_id']) 
					? $property['list_id'] 
					: $target_property->list_id;

				if ($this->CI->property_model->update(['id' => $target_property_id], $property)) {
					$this->CI->property_model->delete_mailings(['property_id' => $target_property->id]);
                	$this->CI->property_model->delete_comments(['property_id' => $target_property->id]);

                	$comment = [
		            	'property_id' => $target_property->id,
		            	'comment' => $property_comments['comment'],
		            	'user_id' => $this->CI->logged_user->id
		            ];
		            $this->CI->property_model->save_comment($comment);
		            
					$this->CI->property_model->add_history([
						'property_id' =>  $target_property->id,
						'message' => 'Replaced using the [' . $status . '] option by ' 
							. $this->CI->logged_user->first_name . ' ' . $this->CI->logged_user->last_name,
						'company_id' => $this->CI->logged_user->company_id
					]);

					$this->CI->load->model('list_model');
					$list = $this->CI->list_model->get(array('l.id' => $property['list_id']), false);
					$this->CI->property_model->add_mailings(
		                $list->mailing_type, 
		                $list->no_of_letters, 
		                ['id' => $target_property->id, 'company_id' => $target_property->company_id],
		                $mailing_date
		            );
		            $message = 'Replacing property successful.';
		            $this->CI->property_model->delete($property_id, $this->CI->logged_user->company_id);
				}
				
            // Save Property Info only
			} else if ($status === 'replaced_property_info_only') {
				if ($this->CI->property_model->update(['id' => $target_property_id], $property)) {
					$this->CI->property_model->delete($property_id, $this->CI->logged_user->company_id);
				}
				$message = "Replacing property info successful.";
			} else if ($status === 'keep_both') {
				if ($this->CI->property_model->update(['id' => $property_id], ['status' => 'active'])) {
					$message = 'Keep both successful.';
				}
			}
		} else {
			$this->CI->property_model->delete($property_id, $this->CI->logged_user->company_id);
		}

		return array(
			'success' => true, 
			'property_id' => $property_id, 
			'target_id' => $target_property_id,
			'target_list_id' => isset($target_property) ? $target_property->list_id : null,
			'status' => $status,
			'message' => $message
		);
	}

	public function download_list($type, $properties, $user)
	{
		$objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()
            ->setCreator($user->first_name . " " . "$user->last_name")
            ->setLastModifiedBy($user->first_name . " " . "$user->last_name")
            ->setTitle("Direct Mail Property List")
            ->setSubject("Direct Mail Property List")
            ->setKeywords("Direct Mail")
            ->setCategory("Property List");

        // Set Headers
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'List ID')
                    ->setCellValue('B1', 'Funeral Home')
                    ->setCellValue('C1', 'Property First Name')
                    ->setCellValue('D1', 'Property Middle Name')
                    ->setCellValue('E1', 'Property Last Name')
                    ->setCellValue('F1', 'Property Address')
                    ->setCellValue('G1', 'Property City')
                    ->setCellValue('H1', 'Property State')
                    ->setCellValue('I1', 'Property Zipcode')
                    ->setCellValue('J1', 'PR First Name')
                    ->setCellValue('K1', 'PR Middle Name')
                    ->setCellValue('L1', 'PR Last Name')
                    ->setCellValue('M1', 'PR Address')
                    ->setCellValue('N1', 'PR City')
                    ->setCellValue('O1', 'PR State')
                    ->setCellValue('P1', 'PR Zipcode')
                    ->setCellValue('Q1', 'Attorney Name')
                    ->setCellValue('R1', 'Attroney Address')
                    ->setCellValue('S1', 'Attorney Address 2')
                    ->setCellValue('T1', 'Attorney City')
                    ->setCellValue('U1', 'Attorney State')
                    ->setCellValue('V1', 'Attorney Zipcode')
                    ->setCellValue('W1', 'Mail First Name')
                    ->setCellValue('X1', 'Mail Last Name')
                    ->setCellValue('Y1', 'Mail Address')
                    ->setCellValue('Z1', 'Mail City')
                    ->setCellValue('AA1', 'Mail State')
                    ->setCellValue('AB1', 'Mail Zip Code')
                    ->setCellValue('AC1', 'Status');

        // Add the data
        $row = 2;
        foreach ($properties as $property) {
        	$objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $row, $property->list_id)
                    ->setCellValue('B' . $row, $property->resource)
                    ->setCellValue('C' . $row, $property->property_first_name)
                    ->setCellValue('D' . $row, $property->property_middle_name)
                    ->setCellValue('E' . $row, $property->property_last_name)
                    ->setCellValue('F' . $row, $property->property_address)
                    ->setCellValue('G' . $row, $property->property_city)
                    ->setCellValue('H' . $row, $property->property_state)
                    ->setCellValue('I' . $row, $property->property_zipcode)
                    ->setCellValue('J' . $row, $property->pr_first_name)
                    ->setCellValue('K' . $row, $property->pr_middle_name)
                    ->setCellValue('L' . $row, $property->pr_last_name)
                    ->setCellValue('M' . $row, $property->pr_address)
                    ->setCellValue('N' . $row, $property->pr_city)
                    ->setCellValue('O' . $row, $property->pr_state)
                    ->setCellValue('P' . $row, $property->pr_zipcode)
                    ->setCellValue('Q' . $row, $property->attorney_name)
                    ->setCellValue('R' . $row, $property->attorney_first_address)
                    ->setCellValue('S' . $row, $property->attorney_second_address)
                    ->setCellValue('T' . $row, $property->attorney_city)
                    ->setCellValue('U' . $row, $property->attorney_state)
                    ->setCellValue('V' . $row, $property->attorney_zipcode)
                    ->setCellValue('W' . $row, $property->mail_first_name)
                    ->setCellValue('X' . $row, $property->mail_last_name)
                    ->setCellValue('Y' . $row, $property->mail_address)
                    ->setCellValue('Z' . $row, $property->mail_city)
                    ->setCellValue('AA' . $row, $property->mail_state)
                    ->setCellValue('AB' . $row, $property->mail_zipcode)
                    ->setCellValue('AC' . $row, $property->status);
            $row++;
        }

        // Rename worksheet
        // $objPHPExcel->getActiveSheet()->setTitle('Simple');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        
        // Redirect output to a client’s web browser (OpenDocument)
        header('Content-Type: application/vnd.oasis.opendocument.spreadsheet');
        header('Content-Disposition: attachment;filename="directmail_' . $type . '_' . date('Ymd') . '_' .  generate_random_str() . '.ods"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'OpenDocument');
        $objWriter->save('php://output');
	}


	function setup_search_filter($filter) 
	{
	    if (sizeof($filter) > 0) {
	        if (isset($filter['list']) && $filter['list'] === 'all') {
	            unset($filter['list']);
	        }
	        if (isset($filter['resource']) && $filter['resource'] === '') {
	            unset($filter['resource']);
	        }
	        if (isset($filter['property_name']) && $filter['property_name'] === '') {
	            unset($filter['property_name']);
	        }
	        if (isset($filter['property_address']) && $filter['property_address'] === '') {
	            unset($filter['property_address']);
	        }
	        if (isset($filter['id']) && $filter['id'] === '') {
	            unset($filter['id']);
	        }
            if (isset($filter['date_range']) && $filter['date_range'] !== '') {
                $date_split = explode(' - ', $filter['date_range']);
                $filter['date_range'] = "pm.mailing_date BETWEEN '$date_split[0]' AND '$date_split[1]'"; 
            } else {
                unset($filter['date_range']);
            }
	        if (isset($filter['status_on'])) {
	        	unset($filter['status_on']);
	        }
	        if (isset($filter['skip_traced']) && !filter_var($filter['skip_traced'], FILTER_VALIDATE_BOOLEAN)) {
	        	unset($filter['skip_traced']);
	        }
	    }
	    $filter = $filter ? $filter : [];
	    $CI =& get_instance();
		$CI->session->set_userdata('list_filter', $filter);
	    return $filter;
	}

	function get_next_mailing_date($type, $date) 
	{
	    $date = strtotime($date);

	    $nmd = date('Y-m-d', strtotime("+" . $type, $date));
	    return $nmd;
	}

}