<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tools extends RA_Controller {
	
	public function ticket_numbers()
	{
		$this->data['PAGE_TITLE'] = 'Ticket Numbers';
		$this->enqueue_style(array(
			'//cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/css/bootstrap-slider.min.css'
		));
		$this->enqueue_scripts(array(
			'//cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/bootstrap-slider.min.js'
		));
		
		$this->enqueue_resource('/resource/script/adminlte/tools/js/ticket_numbers.php');
		$this->dashboard('/adminlte/tools/ticket_numbers');
    }
	
	public function generate_ticket_numbers() {
	}
}