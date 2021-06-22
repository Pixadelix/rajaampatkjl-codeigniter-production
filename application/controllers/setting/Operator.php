<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Operator extends RA_Controller {
    
    public function __construct() {
        parent::__construct();
		$this->restricted('admin');
        $this->data['PAGE_TITLE'] = 'Operators';
        $this->breadcrumbs->push('Operators', '/setting/operator');
    }
	
	public function index()
	{
        $this->include_datatables_assets(true);
        $this->enqueue_resource('/resource/script/adminlte/setting/js/operators.php');
        $this->dashboard('/adminlte/setting/operators');
    }
    
    public function get($id = null, $id2 = null) {
        parent::get();
        $this->load->model('de/ticket/Operators');
        $this->Operators->get();
    }
}