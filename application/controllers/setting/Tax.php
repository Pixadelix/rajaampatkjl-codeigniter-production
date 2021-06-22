<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tax extends RA_Controller {
    
    public function __construct() {
        parent::__construct();
		$this->restricted('admin');
    }
	
    public function get($id = null, $id2 = null) {
        parent::get();
        $this->load->model('de/system/Taxes');
        $this->Taxes->get();
    }
}