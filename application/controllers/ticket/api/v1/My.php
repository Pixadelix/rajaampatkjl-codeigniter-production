<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class My extends RA_Controller {
    
    public function __construct() {
        parent::__construct();
		$this->output->enable_profiler(false);
    }
	
	public function index()
	{
		$tickets = $this->getMyTickets();
		$response = array(
			'status' => 'success',
			'count' => count($tickets),
			'data' => $tickets,
		);
		echo json_encode($response);
    }
	
	private function getMyTickets() {
		$request_body = $this->input->raw_input_stream;
		$request = array();
		parse_str(html_entity_decode($request_body), $request);
		log_message('debug', $request_body);
		log_message('debug', serialize($request));
		
		if ( !isset($request['app_user_id']) ) {
			$request['app_user_id'] = 8;
		}
		
		$tickets = Model\Ticket\Sales::result()
			->where(array(
				'app_user_id' => $request['app_user_id'],
				'ticket_expired_date >= ' => $this->db_value_now(null, 'Y-m-d')
			))
			->get()
			->to_array()
			;
			
		//var_dump($tickets); die;
		if ( $tickets ) {
			foreach($tickets as $k => $v) {
				unset($tickets[$k]['change_log']);
				$tickets[$k]['country'] = Model\Countries::result()->find($v['country_id'])->to_array()[0]['name'];
			}
		}
		
		return $tickets;
	}
    
    
}