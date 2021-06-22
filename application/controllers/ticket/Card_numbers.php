<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Card_numbers extends RA_Controller {
	public $card;
	public function __construct() {
		parent::__construct();
		include_once('class/PDFCardNumbers.php');
		$this->card_numbers = new PDFCardNumbers();
		
		$this->output->enable_profiler(false);
	}
	
	public function pdf() {
		$this->_create_multi_pdf();
	}

	private function _create_multi_pdf() {
		
		set_time_limit(60*5);
		$start = $this->input->post('start');
		
		$start = explode(',', $start);
		
		if ( ! $start ) {
			$start = 1;
			$end = 3000;
		} else {
			$end   = $start[1];
			$start = $start[0];
		}
		
		$start = $start == 0 ? 1 : $start;
		
		if ( $end - $start > 3000 ) {
			$end = $start + 3000;
		}
		
		for( $i = $start; $i <= $end; $i++ ) {
			$this->card_numbers->create_ticket_card_numbers_pdf($i);
			//break;
		}
		$this->card_numbers->render_pdf();
	}
	
}