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

}