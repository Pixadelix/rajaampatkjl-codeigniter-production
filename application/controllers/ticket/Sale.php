<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sale extends RA_Controller {
    
    public function __construct() {
        parent::__construct();
		
		$this->restricted('ticket');
		
        $this->data['PAGE_TITLE'] = 'Ticket';
        $this->breadcrumbs->push('Ticket', '/ticket/sales');

    }
	
	public function index()
	{
        $this->include_datatables_assets(true);
		$this->enqueue_scripts('//underscorejs.org/underscore-min.js');
        $this->enqueue_resource('/resource/script/adminlte/ticket/js/sales.php');
        $this->dashboard('/adminlte/ticket/sales');
    }
    
    public function get($id = null, $id2 = null) {
        parent::get();
        $this->load->model('de/ticket/Sales');
        $this->Sales->get($id, $id2);
    }
	
	public function qr($uuid) {
		$ticket = Model\Ticket\Sales::where(array('uuid' => $uuid))->get();

		if ( ! $ticket ) { show_404(); }
		
		//var_dump($ticket->uuid);
		$data_text = base_url("verification/ticket/".$ticket->uuid, $_SERVER['HTTPS'] ? 'https:' : 'http:');
		//var_dump($data_text); die;
		require_once(APPPATH.'third_party/TCPDF/tcpdf_barcodes_2d.php');
		$tcpdf2dbarcode = new TCPDF2DBarcode($data_text, 'QRCODE,L');

		$sz = 3;
		$tcpdf2dbarcode->getBarcodePNG($sz, $sz, array(55,0,0));

	}
}