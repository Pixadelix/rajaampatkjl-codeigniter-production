<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pricing extends RA_Controller {
    
    public function __construct() {
        parent::__construct();
		
		$this->restricted('ticket');
		
        $this->data['PAGE_TITLE'] = 'Pricing';
        $this->breadcrumbs->push('Pricing', '/ticket/pricing');

    }
	
	public function index()
	{
        $this->include_datatables_assets(true);
		$this->enqueue_scripts('//underscorejs.org/underscore-min.js');
		$this->enqueue_resource('/resource/script/adminlte/ticket/js/taxes.php');
        $this->enqueue_resource('/resource/script/adminlte/ticket/js/pricing.php');
        $this->dashboard('/adminlte/ticket/pricing');
    }
    
    public function get($id = null, $id2 = null) {
        parent::get();
        $this->load->model('de/ticket/ProductEvents');
		
		$this->ProductEvents->editor->where('event_type', 'ticket');
        $this->ProductEvents->get();
    }
}