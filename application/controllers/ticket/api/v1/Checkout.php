<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends RA_Controller {
    
    public function __construct() {
        parent::__construct();
		$this->output->enable_profiler(false);
    }
	
	public function index()
	{
        $request_body = $this->input->raw_input_stream;
		//$request_body = file_get_contents('php://input');
		
		//$request_body = 'email=yusar%40media-vista.com&gender=Male&country=Vietnam&full_name=Yusar+Chavik&id_card_number=82773748182&';
		
		log_message('debug', $request_body);
		
		parse_str(html_entity_decode($request_body), $array_data);
		
		log_message('debug', serialize($array_data));
		
		$ticket_order = Model\Ticket\Ticket_orders::place_new_order($array_data);
		$ticket_order->save();
		
		$response = array(
			'status' => 'success',
			'ticket_order_id' => Model\Ticket\Ticket_orders::last_created()->id,
		);
		
		echo json_encode($response);
    }
    
    
}