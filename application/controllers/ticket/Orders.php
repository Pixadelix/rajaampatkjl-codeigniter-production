<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends RA_Controller {
    
    public function __construct() {
        parent::__construct();
		
		$this->restricted('orders');
		
        $this->data['PAGE_TITLE'] = 'Orders';
        $this->breadcrumbs->push('Orders', '/ticket/orders');

    }
	
	public function index()
	{
        $this->include_datatables_assets(true);
		$this->enqueue_scripts('//underscorejs.org/underscore-min.js');
		$this->enqueue_style('https://unpkg.com/ionicons@4.1.2/dist/css/ionicons.min.css');
        $this->enqueue_resource('/resource/script/adminlte/ticket/js/order_dtl.php');
		$this->enqueue_resource('/resource/script/adminlte/ticket/js/order_payment.php');
		$this->enqueue_resource('/resource/script/adminlte/ticket/js/order_tickets.php');
		$this->enqueue_resource('/resource/script/adminlte/ticket/js/orders.php');
		
        $this->dashboard('/adminlte/ticket/orders');
    }
    
    public function get($id = null, $id2 = null) {
		/*
		$this->load->helper('alphaid');
		
		$uuid = '301a5e47-9c75-47af-b819-b40cc424b548';
		//$uuid = uniqid();
		$id = hexdec($uuid);
		echo $uuid;echo '<br/>';
		echo $id;echo '<br/>';
		$aid = alphaID($id, false, false, 'asdf');
		echo $aid; echo '<br/>';
		echo alphaID($aid, true, false, 'asdf'); echo '<br/>';
		die;
		*/
		
        parent::get();
        $this->load->model('de/ticket/TicketOrders');
        $this->TicketOrders->get();
    }
	
	public function get_dtl($id = null, $id2 = null) {
        parent::get();
        $this->load->model('de/ticket/TicketOrdersDtl');
        $this->TicketOrdersDtl->get($id);
    }
	
	public function get_payment($id = null, $id2 = null) {
		parent::get();
		$this->load->model('de/ticket/TicketPayments');
		$this->TicketPayments->get($id);
	}
	
	public function check_payments() {
		$this->output->enable_profiler(false);
		$orderIds = $this->input->post('orders');
		//die(var_dump($orderIds));
		
		require_once(dirname(__FILE__) . '/../booking/class/Payment.php');
		
		foreach($orderIds as $id) {
			$order = Model\Ticket\Ticket_orders::find($id);
			//var_dump($order->id);
			Payment::update($order);
		}

		echo json_encode(array('status' => 'success'));
	}
	
	public function create_tickets() {
		$this->output->enable_profiler(false);
		$orderIds = $this->input->post('orders');
		
		foreach($orderIds as $id) {
			$order = Model\Ticket\Ticket_orders::where(array('id' => $id))->get();
			$order->finish();

		}
	}
	
	public function check_orders_finish() {
		$this->must_cli_mode();
		
		require_once(dirname(__FILE__) . '/../booking/class/Payment.php');
		
		$orders = Model\Ticket\Ticket_orders::where(array(
			'order_status' => 'new',
		))
		->all()
		;
		
		foreach( $orders as $order ) {
			Payment::update($order);
			$order->finish();
		}
	}
}