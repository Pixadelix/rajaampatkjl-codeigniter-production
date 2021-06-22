<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Card extends RA_Controller {
	public $card;
	public function __construct() {
		parent::__construct();
		require_once('class/PDF.php');
		require_once('class/'.PDF_CLASS_PATH.'/PDFCard.php');
		$this->card = new PDFCard();
		
		$this->output->enable_profiler(false);
	}
	
	public function pdf($id = null) {
		if ( ! $id ) {
			$ids = $this->input->post();
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
			$this->card->create_ticket_card_pdf($ids[$i]);
		}
		$this->card->render_pdf();
	}
	
	private function _create_single_pdf($id) {
		$this->card->create_ticket_card_pdf($id);
		$this->card->render_pdf();
	}
	
}