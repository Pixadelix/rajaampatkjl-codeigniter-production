<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Outstanding extends RA_Controller {
    
    public function __construct() {
        parent::__construct();
		$this->output->enable_profiler(false);
    }
	
	public function index()
	{
		$outstandingOrders = $this->getOutstandingOrders();
		$response = array(
			'status' => 'success',
			'count' => count($outstandingOrders),
			'data' => $outstandingOrders,
		);
		echo json_encode($response);
    }
	
	public function cnt() {
		$outstandingOrders = $this->getOutstandingOrders();
		$response = array(
			'status' => 'success',
			'count' => count($outstandingOrders),
		);
		echo json_encode($response);
	}
	
	private function getOutstandingOrders() {
		$request_body = $this->input->raw_input_stream;
		$request = array();
		parse_str(html_entity_decode($request_body), $request);
		log_message('debug', $request_body);
		log_message('debug', serialize($request));
		
		if ( !isset($request['app_user_id']) ) {
			$request['app_user_id'] = 8;
		}
		$outstandingOrders = Model\Ticket\Ticket_orders::result()
			->where(array(
				'app_user_id' => $request['app_user_id'],
				'order_status' => 'new',
			))
			->get()
			->to_array()
			;
		return $outstandingOrders;
	}
    
	public function cancel() {
		//$request_body = $this->input->raw_input_stream;
		$request_body = file_get_contents('php://input');
		$request = array();
		parse_str(html_entity_decode($request_body), $request);
		log_message('debug', 'REQUEST_BODY: '.$request_body);
		log_message('debug', serialize($request));
		
		if ( !isset($request['id']) ) {
			$request['id'] = 1;
		}
		if ( !isset($request['app_user_id']) ) {
			$request['app_user_id'] = 8;
		}
		
		$outstandingOrders = Model\Ticket\Ticket_orders::where(array(
				'id' => $request['id'],
				'app_user_id' => $request['app_user_id'],
				'order_status' => 'new',
			))
			->all();
			;
		
		//var_dump($outstandingOrders); die;
		foreach($outstandingOrders as $order) {
			$order->order_status = 'cancel';
			$order->save();
		}
		
		$response = array(
			'status' => 'success',
		);
		echo json_encode($response);
	}
    
}