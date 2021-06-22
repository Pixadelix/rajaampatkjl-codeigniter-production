<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Charge extends RA_Controller {

	protected $midtrans;

	public function __construct() {
		parent::__construct();
		$this->output->enable_profiler(false);
		$this->load->config('midtrans');
		$this->midtrans = $this->config->item('midtrans');
	}
	
	public function index() {
		// Check if method is not HTTP POST, display 404
		if( $_SERVER['REQUEST_METHOD'] !== 'POST'){
			//http_response_code(404);
			//echo "Page not found or wrong HTTP request method is used"; exit();
		}
		
		// get the HTTP POST body of the request
		$request_body = file_get_contents('php://input');
		// set response's content type as JSON
		//header('Content-Type: application/json');
		// call charge API using request body passed by mobile SDK, then print out the result
		
		
		
		if ( $this->_create_order($request_body) ) {
			echo $this->chargeAPI($this->midtrans['api_url'], $this->midtrans['server_key'], $request_body);
		}
		
		

	}
	
	private function _create_order($request_body) {
		$request_body = <<<EOL
{"customer_details":{"billing_address":{"address":"Roda","city":"Bogor","country_code":"IDN","first_name":"Yusat","phone":"087870877321","postal_code":"16141"},"email":"yusar.chavik@gmail.com","first_name":"Yusat","phone":"087870877321","shipping_address":{"address":"Roda","city":"Bogor","country_code":"IDN","first_name":"Yusat","phone":"087870877321","postal_code":"16141"}},"credit_card":{"authentication":"3ds","bank":"bca","save_card":false,"secure":true},"custom_field1":"PA-123451234","custom_field2":"Man","item_details":[{"id":"2","name":"Raja Ampat KJL","price":1000000,"quantity":1}],"transaction_details":{"gross_amount":1000000,"order_id":"1520847505765"},"user_id":"3aaa8495-84c3-4258-856d-c32c6f2d81c7"}
EOL;


		$order = json_decode($request_body);
		//var_dump($order);
		return true;
		
		return false;
	}
	
	
	/**
	 * call charge API using Curl
	 * @param string  $api_url
	 * @param string  $server_key
	 * @param string  $request_body
	 */
	private function chargeAPI($api_url, $server_key, $request_body){
		
		
		log_message('debug', $request_body);
		$ch = curl_init();
		$curl_options = array(
			CURLOPT_URL => $api_url,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_POST => 1,
			// Add header to the request, including Authorization generated from server key
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Accept: application/json',
				'Authorization: Basic ' . base64_encode($server_key . ':')
			),
			CURLOPT_POSTFIELDS => $request_body
		);
		curl_setopt_array($ch, $curl_options);
		$result = curl_exec($ch);
		return $result;
	}
}