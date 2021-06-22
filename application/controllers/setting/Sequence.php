<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sequence extends RA_Controller {
    
    public function __construct() {
        parent::__construct();
		$this->restricted('admin');
        $this->data['PAGE_TITLE'] = 'Sequence';
        $this->breadcrumbs->push('Sequences', '/setting/Sequence');
    }
	
	public function index()
	{
        $this->include_datatables_assets(true);
        $this->enqueue_resource('/resource/script/adminlte/setting/js/sequences.php');
        $this->dashboard('/adminlte/setting/sequences');
    }
    
    public function get($id = null, $id2 = null) {
        parent::get();
        $this->load->model('de/system/Sequences');
        $this->Sequences->get();
    }
}