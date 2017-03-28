<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lookup extends MY_Controller {

    function __construct()
    {
        parent::__construct(true);
    }

    public function status(string $type = 'all', string $input = 'normal')
    {
        $this->load->library('dm_library');
        $statuses = $this->dm_library->getStatuses($type, $input);
        echo json_encode($statuses);
    }

}
