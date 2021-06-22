<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Order {
	
	public static $CI = null;
	
	public static function add() {

		if ( ! self::$CI ) {
			self::$CI = get_instance();
		}
		
		
		if ( ! self::$CI->getOrder() ) {
			$order = Model\Ticket\Ticket_orders::place_new_order(array(
				'event_id' => self::$CI->getEvent()->id,
				'app_user_id' => self::$CI->getAppUserId(),
			));
			$order->save();
			self::$CI->setOrder();
		}
		
		if ( ! self::$CI->getOrder()->isOpen() ) {
			return false;
		}
		
		$request_body = self::$CI->input->raw_input_stream;
		parse_str(html_entity_decode($request_body), $array_data);
		
		self::$CI->form_validation->set_rules('full_name', 'Name', 'required', array('required' => 'Name is required'));
		self::$CI->form_validation->set_rules('email', 'Email', 'required|valid_email',
			array(
				'required' => 'Email is required',
				'is_unique' => 'Email already exists'
			));
		self::$CI->form_validation->set_rules('phone', 'Phone', 'required', array('required' => 'Phone is required'));
		self::$CI->form_validation->set_rules('country_code', 'Country', 'required', array('required' => 'Country is required'));
		
		if (self::$CI->form_validation->run() == FALSE) {
			return false;
        }

		$array_data['order_id']       = $order_id;
		$array_data['app_user_id']    = self::$CI->getAppUserId();
		$array_data['price']          = self::$CI->getEvent()->price;
		
		self::$CI->getOrder()->add_item($array_data);
		
		return true;
	}
	
	public static function edit($id) {
		
		if ( ! self::$CI ) {
			self::$CI = get_instance();
		}
		
		$order_dtl = Model\Ticket\Ticket_orders_dtl::where(array(
			'app_user_id' => self::$CI->getAppUserId(),
			'id' => $id,
			'order_id' => self::$CI->getOrder()->id,
		))
		->get()
		;
		
		if ( ! $order_dtl ) show_404();
		
		if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
		
			self::$CI->form_validation->set_rules('full_name', 'Name', 'required', array('required' => 'Name is required'));
			self::$CI->form_validation->set_rules('email', 'Email', 'required|valid_email',
				array(
					'required' => 'Email is required',
					'is_unique' => 'Email already exists'
				));
			self::$CI->form_validation->set_rules('phone', 'Phone', 'required', array('required' => 'Phone is required'));
			self::$CI->form_validation->set_rules('country_code', 'Country', 'required', array('required' => 'Country is required'));
		
			if (self::$CI->form_validation->run() !== FALSE) {
				$order_dtl->full_name    = $_POST['full_name'];
				$order_dtl->email        = $_POST['email'];
				$order_dtl->phone        = $_POST['phone'];
				$order_dtl->country_code = $_POST['country_code'];
				$order_dtl->save();
				return true;
			}
	
		}
		self::$CI->data['order_dtl'] = $order_dtl;
			
		return false;
	}
	
	public static function finish() {

		if ( ! self::$CI ) {
			self::$CI = get_instance();
		}

		$orders = Model\Ticket\Ticket_orders
			::where(array(
				'event_id' => self::$CI->getEvent()->id,
				'app_user_id' => self::$CI->getAppUserId(),
				'order_status !=' => 'finish',
				'payment_status' => 200,
			))
			->all()
			;
		//var_dump($orders); die;
		foreach ( $orders as $order ) {
			$order->finish();
		}
		//die;
	}
	
}