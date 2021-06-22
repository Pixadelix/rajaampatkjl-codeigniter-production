<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Receipt extends RA_Controller {
	public $receipt;
	public function __construct() {
		parent::__construct();
		require_once('class/PDF.php');
		require_once('class/'.PDF_CLASS_PATH.'/PDFReceipt.php');
		$this->receipt = new PDFReceipt();
		//var_dump($this->receipt);die;
	}
	
	public function pdf($id = null) {
		//var_dump($_GET); die;
		if ( ! $id ) {
			//$ids = $this->input->post();
			$ids = $this->input->get('id');
			//var_dump($ids); die;
			if ( ! $ids ) {
				show_404();
			} else {
				$this->_create_multi_pdf($ids);
			}
		} else {
			$this->_create_single_pdf($id);
		}
	}

	private function _create_multi_pdf($ids) {
		for( $i = 0; $i < count($ids); $i++ ) {
			$this->receipt->create_ticket_card_pdf($ids[$i]);
		}
		$this->receipt->render_pdf('receipts-'.implode('-', $ids));
	}
	
	private function _create_single_pdf($id) {
		$this->receipt->create_ticket_card_pdf($id);
		$this->receipt->render_pdf('receipt-'.$id);
	}
	
}