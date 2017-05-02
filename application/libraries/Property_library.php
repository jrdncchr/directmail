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

    public function bulk_action()
    {
        $bulk_action = $this->CI->input->post('bulk_action');
        if ($bulk_action == 'delete') {
            $properties = $this->_get_filtered_properties();
            return $this->CI->property_model->bulk_delete_properties(
                $this->CI->logged_user->company_id, 
                $properties
            );
        } else if ($bulk_action == 'change_status') {
            $status = $this->CI->input->post('status');
            $properties = $this->_get_filtered_properties();
            return $this->CI->property_model->bulk_change_status_properties(
                $this->CI->logged_user->company_id, 
                $properties,
                $status
            );
        }
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
	 * Proccess the duplicate and replacements.
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

	function setup_search_filter($filter) 
	{
	    if (sizeof($filter) > 0) {
	        if (isset($filter['list']) && in_array('all', $filter['list'])) {
	            unset($filter['list']);
	        }
            if (isset($filter['status']) && in_array('all', $filter['status'])) {
                unset($filter['status']);
            }
            if (isset($filter['letter_no']) && in_array('all', $filter['letter_no'])) {
                unset($filter['letter_no']);
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
	        if (isset($filter['skip_traced']) && !filter_var($filter['skip_traced'], FILTER_VALIDATE_BOOLEAN)) {
	        	unset($filter['skip_traced']);
	        }
	        // Used in Duplicates
	        if (isset($filter['target_list']) && in_array('all', $filter['target_list'])) {
	            unset($filter['target_list']);
	        }
	        if (isset($filter['target_status']) && in_array('all', $filter['target_status'])) {
	            unset($filter['target_status']);
	        }
	        if (isset($filter['target_address']) && $filter['target_address'] === '') {
	            unset($filter['target_address']);
	        }
	        if (isset($filter['upload_by']) && $filter['upload_by'] === '') {
	            unset($filter['upload_by']);
	        }
	        if (isset($filter['upload_date']) && $filter['upload_date'] === '') {
	            unset($filter['upload_date']);
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

    public function _get_filtered_properties()
    {
        $filter = $this->CI->input->post('filter');
        $filter = $this->setup_search_filter($filter);
        $where = array( 
            'p.deleted' => 0,
            'p.active' => 1
        );
        $properties = $this->CI->property_model->get_properties(
            $this->CI->logged_user->company_id, 
            $where, 
            $filter
        );
        return $properties;
    }

    public function _get_filtered_properties_from_session($type)
    {
        $filter = $this->CI->session->userdata('list_filter');
        if (isset($filter)) {
            $where = [
                'p.deleted' => 0,
                'p.active' => 1
            ];
            switch ($type) {
                case 'downloads_letters' :
                case 'downloads_post_letters' :
                    $filter['status_not_in'] = ['draft', 'duplicate'];
                    break;
            }
            $filter['download_type'] = $type;
            $properties = $this->CI->property_model->get_properties(
                $this->CI->logged_user->company_id, 
                $where, 
                $filter
            );
            return $properties;
        }
        return false;
    }

}