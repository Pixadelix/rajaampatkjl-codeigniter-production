<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Office extends RA_Controller {
    
    public function __construct() {
        parent::__construct();
		$this->restricted('admin');
        $this->data['PAGE_TITLE'] = 'Sales Offices';
        $this->breadcrumbs->push('Sales Offices', '/setting/office');
    }
	
	public function index()
	{
        $this->include_datatables_assets(true);
        $this->enqueue_resource('/resource/script/adminlte/setting/js/offices.php');
        $this->dashboard('/adminlte/setting/offices');
    }
    
    public function get($id = null, $id2 = null) {
        parent::get();
        $this->load->model('de/ticket/Offices');
        $this->Offices->get();
    }
}