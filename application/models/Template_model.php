<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Template_model extends CI_Model {

    function __construct()
    {
        $this->load->database();
    }

    /*
     * list Property
     */
    public function get($where = array(), $list = true)
    {
        $this->db->select('t.*, u.first_name, u.last_name');
        $this->db->join('user u', 'u.id = t.created_by', 'left');
        $result = $this->db->get_where('templates t', $where);
        return $list ? $result->result() : $result->row();
    }

    public function save($template)
    {
    	$template['hash'] = hash('sha256', $template['name'] . strval(time()));
    	if ($this->generate_document_by_html($template['content'], $template['hash'])) {
    		unset($template['content']);
	        if (isset($template['id']) && $template['id'] > 0) {
	            $this->db->where('id', $template['id']);
	            $this->db->update('templates', $template);
	        } else {
	            $this->db->insert('templates', $template);
	            $template['id'] = $this->db->insert_id();
	        }
	        return array('success' => true, 'id' =>  $template['id']);
    	}
    }

    public function delete($id, $company_id)
    {
        $result = array('success' => false);
        $this->db->delete('templates', array('id' => $id, 'company_id' => $company_id));
        return $result;
    }

    public function generate_document_by_html($html, $filename)
    {
    	try {
	    	$phpWord = new \PhpOffice\PhpWord\PhpWord();
			$section = $phpWord->addSection();
			\PhpOffice\PhpWord\Shared\Html::addHtml($section, $html);
			$targetFile = MAIL_TEMPLATES_PATH . '\\' . $filename . '.odt';
			$phpWord->save($targetFile, 'ODText');
			return true;
    	} catch(Exception $e) {}
    	return false;
    }
} 