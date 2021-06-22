<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Country extends RA_Controller {
    
    public function __construct() {
        parent::__construct();
		$this->restricted('admin');
        $this->data['PAGE_TITLE'] = 'Countries';
        $this->breadcrumbs->push('Countries', '/setting/countries');
    }
	
	public function index()
	{
        $this->include_datatables_assets(true);
        $this->enqueue_resource('/resource/script/adminlte/setting/js/countries.php');
        $this->dashboard('/adminlte/setting/countries');
    }
    
    public function get($id = null, $id2 = null) {
        parent::get();
        $this->load->model('de/system/Countries');
        $this->Countries->get();
    }
}