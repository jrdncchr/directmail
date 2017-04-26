<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Property extends MY_Controller {

    function __construct()
    {
        parent::__construct(true);
    }
    
    public function bulk_action()
    {
        $this->load->library('property_library');
        $result = $this->property_library->bulk_action();
        echo json_encode(['success' => $result]);
    }

}
