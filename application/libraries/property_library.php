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

	public function replace_action($replace_action, $property, $target_property_id, $logged_user)
	{
		if ($replace_action === 'save') {
			$property['status'] = 'replacement';
            if (isset($property['check'])) {
                unset($property['check']);
            }
            if (isset($property['row'])) {
            	unset($property['row']);
            }
			$save = $this->CI->property_model->save($property);
			$replacement = array(
				'property_id' => $save['id'],
				'target_property_id' => $target_property_id,
				'status' => 'pending',
				'company_id' => $logged_user->company_id,
				'requested_by' => $logged_user->id
			);
			if ($save['success']) {
				$result = $this->CI->property_model->save_replacement_approval($replacement);
			} else {
				$result = array('success' => false);
			}
		} else {
			$result = $this->confrim_replacement_action(
			$replace_action,
			$property,
			$target_property_id);
		}
		return $result;
	}

	public function confrim_replacement_action($action, $property_id, $target_property_id, $comment = '')
	{
		$this->CI->load->model('property_model');
		switch($action) {
			case 1: // reject
				return $this->replace('rejected', $property_id, $target_property_id, $comment);
				break;
			case 2: // replace the target deceased address only
				return $this->replace('replaced_address_only', $property_id, $target_property_id, $comment);
				break;
			case 3: // replace the entire target property info except the list it belongs to
				return $this->replace('replaced_all_except_list', $property_id, $target_property_id, $comment);
				break;
			case 4: // replace the entire target property info including the list it belongs to
				return $this->replace('replaced_all', $property_id, $target_property_id, $comment, true);
				break;
		}
	}

	/*
	 * Proccess the pending replacements.
	 * 
	 * @param (string) $status - rejected, replaced_address_only, replaced_all
	 * @param (int/object) $property
	 * @param (int) $target_property_id 
	 * @param (string) $comment 
	 * @param (boolean) $replace_list - if the method will also replace the list
	 * @return (type)
	 */
	public function replace($status, $property, $target_property_id, $comment = '', $replace_list = false)
	{
		$message = "You have successfully rejected the replacement.";
		if (!is_array($property)) {
			$property = $this->CI->property_model->get(['p.id' => $property], false);
		} else {
			$property = (object) $property;
		}
		$property_id = null;
		if (isset($property->id)) {
			$property_id = $property->id;
		}
		if ($status !== 'rejected') {
			$target_property = $this->CI->property_model->get(['p.id' => $target_property_id], false);
			if ($status === 'replaced_address_only') {
				$update = ['deceased_address' => $property->deceased_address];
			} else if ($status === 'replaced_all' || $status === 'replaced_all_except_list') {
				unset($property->id);
				unset($property->status);
				unset($property->company_id);
				unset($property->deleted);
				unset($property->date_created);
				unset($property->target_property_id);
				unset($property->pr_list_id);
				unset($property->pr_url);
				if (isset($property->check)) {
					unset($property->check);
				}
				if (isset($property->row)) {
					unset($property->row);
				}
				if (!$replace_list) {
					unset($property->list_id);
				} else {
					$target_property->list_id = $property->list_id;
				}
				$property->last_update = date('Y-m-d H:i:s');
				$update = (array) $property;
			}
			$this->CI->property_model->update(['id' => $target_property_id], $update);
			$message = "Replacement successful!";
		}
		if ($property_id) {
			$this->CI->property_model->update(['id' => $property_id], ['active' => 0]);
			$this->CI->property_model->update_property_replacement(['property_id' => $property_id], [
				'status' => $status,
				'comment' => $comment,
				'date_updated' => date('Y-m-d H:i:s')
			]);
			$this->CI->session->set_flashdata('message', $message);
		}

		return array(
			'success' => true, 
			'property_id' => $property_id, 
			'target_id' => $target_property_id,
			'target_list_id' => isset($target_property) ? $target_property->list_id : null,
			'status' => $status
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
                    ->setCellValue('C1', 'Deceased First Name')
                    ->setCellValue('D1', 'Deceased Middle Name')
                    ->setCellValue('E1', 'Deceased Last Name')
                    ->setCellValue('F1', 'Deceased Address')
                    ->setCellValue('G1', 'Deceased City')
                    ->setCellValue('H1', 'Deceased State')
                    ->setCellValue('I1', 'Deceased Zipcode')
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
                    ->setCellValue('B' . $row, $property->funeral_home)
                    ->setCellValue('C' . $row, $property->deceased_first_name)
                    ->setCellValue('D' . $row, $property->deceased_middle_name)
                    ->setCellValue('E' . $row, $property->deceased_last_name)
                    ->setCellValue('F' . $row, $property->deceased_address)
                    ->setCellValue('G' . $row, $property->deceased_city)
                    ->setCellValue('H' . $row, $property->deceased_state)
                    ->setCellValue('I' . $row, $property->deceased_zipcode)
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
	        if (isset($filter['deceased_name']) && $filter['deceased_name'] === '') {
	            unset($filter['deceased_name']);
	        }
	        if (isset($filter['deceased_address']) && $filter['deceased_address'] === '') {
	            unset($filter['deceased_address']);
	        }
	        if (isset($filter['id']) && $filter['id'] === '') {
	            unset($filter['id']);
	        }
	        if (isset($filter['today']) && $filter['today'] === 'true') {
	            unset($filter['date_range']);
	        } else {
	            if (isset($filter['date_range']) && $filter['date_range'] !== '') {
	                $date_split = explode(' - ', $filter['date_range']);
	                $filter['date_range'] = "next_mailing_date BETWEEN '$date_split[0]' AND '$date_split[1]'"; 
	            } else {
	                unset($filter['date_range']);
	            }
	        }
	        if (isset($filter['status_on'])) {
	        	unset($filter['status_on']);
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

	    switch ($type) {
	    	case 'Bi-monthly' :
			    $nmd = date('Y-m-d', strtotime("+15 days", $date));	
			    break;
		    case 'Monthly' :
		    	$nmd = date('Y-m-d', strtotime("+1 month", $date));
		    	break;
	    	case 'Yearly' :
			    $nmd = date('Y-m-d', strtotime("+1 year", $date));
			    break;
			case 'Quarterly' :
				$nmd = date('Y-m-d', strtotime("+3 months", $date));
				break;
	    }
	    return $nmd;
	}

}