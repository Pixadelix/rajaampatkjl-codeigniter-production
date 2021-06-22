<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Operator_category extends RA_Controller {
    
    public function __construct() {
        parent::__construct();
		$this->restricted('admin');
        $this->data['PAGE_TITLE'] = 'Operator Categories';
        $this->breadcrumbs->push('Operator Categories', '/setting/operator-category');
    }
	
	public function index()
	{
        $this->include_datatables_assets(true);
        $this->enqueue_resource('/resource/script/adminlte/setting/js/operator-categories.php');
        $this->dashboard('/adminlte/setting/operator-category');
    }
    
    public function get($id = null, $id2 = null) {
        parent::get();
        $this->load->model('de/ticket/OperatorCategories');
        $this->OperatorCategories->get();
    }
}