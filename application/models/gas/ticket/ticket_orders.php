<?php namespace Model\Ticket;

use \Gas\Core;
use \Gas\ORM;

class Ticket_orders extends ORM {
	
	public $table = 'kjl_ticket_orders';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
		'\\model\\ticket\\ticket_payments' => 'real_order_id',
		'\\model\\ticket\\product_events' => 'event_id',
		'\\model\\ticket\\sales' => 'order_id',
		'\\model\\cd\\appusers' => 'app_user_id',
	);
	
	function _init() {
        
        self::$relationships = array(
			'ticket_orders_dtl' => ORM::has_many('\\Model\\Ticket\Ticket_orders_dtl'),
			'payment' => ORM::has_one('\\Model\\Ticket\\Ticket_payments'),
			'event'   => ORM::belongs_to('\\Model\\Ticket\\Product_events'),
			'tickets' => ORM::has_many('\\Model\\Ticket\\Sales'),
			'user'    => ORM::belongs_to('\\Model\\Cd\\Appusers'),
        );
		
		self::$fields = array(
            'id'                   => ORM::field('int'),
			'event_id'             => ORM::field('int'),
			'uuid'                 => ORM::field('string'),
			'app_user_id'          => ORM::field('int'),
			
			'total_amount'         => ORM::field('numeric'),
			'tax_amount'           => ORM::field('numeric'),
			'disc_amount'          => ORM::field('numeric'),
			'open_amount'          => ORM::field('numeric'),
			'payment_amount'       => ORM::field('numeric'),
			'payment_method'       => ORM::field('string'),
			'order_status'         => ORM::field('string'),
			'payment_id'           => ORM::field('string'),
			
            'create_by'            => ORM::field('int'),
			'create_at'            => ORM::field('datetime'),
			'update_by'            => ORM::field('int'),
			'update_at'            => ORM::field('datetime'),
		);
		
		$this->ts_fields = array('[create_at]', 'update_at');
	}

	public static function place_new_order($data) {
		
		$prefix = isset($data['uuid_prefix']) ? $data['uuid_prefix'] : '';
		$uuid   = guidv4($prefix, true);
		
		$data['uuid']         = $uuid;
		$data['order_status'] = 'new';
		
		$new_order = self::make($data);
		return $new_order;
	}
	
	public function add_item($data) {
		$data['order_id'] = $this->id;
		$ticket_order_dtl = Ticket_orders_dtl::make($data);
		$ticket_order_dtl->save();
	}
	
	public function calculate() {
		$open_amount = $this->getOpenAmount();
		$this->total_amount = $open_amount;
		$tax_amount = 0;
		$disc_amount = 0;
		$taxes = $this->event()->taxes();
		
		foreach($taxes as $tax) {
			if ( $tax->tax > 0 ) {
				$tax_amount += $open_amount * $tax->tax;
			} else {
				$disc_amount += $open_amount * $tax->tax;
			}
		}
		$this->tax_amount = $tax_amount;
		$this->disc_amount = $disc_amount;
		$this->open_amount = $open_amount + $tax_amount + $disc_amount;
	}
	
	public function getOpenAmount() {
		$orders_dtl = $this->ticket_orders_dtl();
		
		$open_amt = 0;
		
		foreach ( $orders_dtl as $order_dtl ) {
			$open_amt += $order_dtl->price;
		}
		
		return $open_amt;
	}
	
	public function getMidtransPaymentStatus() {
		$payment = $this->payment();
		if ( $payment ) {
			
			$transaction = $payment->transaction_status;
			$type        = $payment->payment_type;
			$order_id    = $payment->order_id;
			$fraud       = $payment->fraud_status;
			if ($transaction == 'capture') {
				// For credit card transaction, we need to check whether transaction is challenge by FDS or not
				if ($type == 'credit_card'){
					if($fraud == 'challenge'){
						// TODO set payment status in merchant's database to 'Challenge by FDS'
						// TODO merchant should decide whether this transaction is authorized or not in MAP
						return "Transaction is challenged by FDS";
						//return "Transaction order_id: " . $order_id ." is challenged by FDS";
					} else {
						// TODO set payment status in merchant's database to 'Success'
						return "Transaction is successfully captured.";
						//return "Transaction order_id: " . $order_id ." successfully captured using " . $type;
					}
				}
			} else if ($transaction == 'settlement') {
				// TODO set payment status in merchant's database to 'Settlement'
				return "Transaction successfully transfered.";
				//return "Transaction order_id: " . $order_id ." successfully transfered using " . $type;
			} else if($transaction == 'pending') {
				// TODO set payment status in merchant's database to 'Pending'
				return "Waiting customer to finish transaction. ". $payment->status_code;
				//return "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
			} else if ($transaction == 'deny') {
				// TODO set payment status in merchant's database to 'Denied'
				return "Payment is denied.";
				//return "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
			} else if ($transaction == 'expire') {
				// TODO set payment status in merchant's database to 'expire'
				return "Payment is expired.";
				//return "Payment using " . $type . " for transaction order_id: " . $order_id . " is expired.";
			} else if ($transaction == 'cancel') {
				// TODO set payment status in merchant's database to 'Denied'
				return "Payment is canceled.";
				//return "Payment using " . $type . " for transaction order_id: " . $order_id . " is canceled.";
			}
		} else {
			return "Waiting customer to finish transaction.";
		}
	}
	
	public function isOpen() {
		
		return $this->payment_status == null;
		/*
		200 = success
		201 = credit card challenge
		      others pending
		202 = credit card denied
		407 = expired
		*/
		//if ( in_array($this->payment_status, array(200, 201, 202, 407) ) ) {
			//return false;
		//}
		//return true;
	}
	
	public function finish() {
		
		if ( $this->payment_status != 200 ) return;

		$ticket_orders_dtl = $this->ticket_orders_dtl();
		
		$notify_user = false;
		
		foreach ( $ticket_orders_dtl as $o ) {
			
			$sale = Sales::where(array(
				'order_id'     => $o->order_id,
				'order_dtl_id' => $o->id,
			))
			->get()
			;
			
			//var_dump($sale); die;

			if ( ! $sale ) {
				
				$CI =& get_instance();
				
				$country = \Model\System\Countries::where(array('code' => $o->country_code))->get();
				//die(var_dump($o->country_code));
			
				$sale = Sales::make(array(
					'order_id'            => $o->order_id,
					'order_dtl_id'        => $o->id,
					'uuid'                => guidv4($o->id),
					'app_user_id'         => $o->app_user_id,
					'event_id'            => $this->event_id,
					'full_name'           => $o->full_name,
					'gender'              => $o->gender,
					'id_card_number'      => $o->id_card_number,
					'country_id'          => $country ? $country->country_id : NULL,
					'phone'               => $o->phone,
					'email'               => $o->email,
					'ticket_start_date'   => $this->ticket_start_date ? $this->ticket_start_date : $CI->db_value_now(),
					'ticket_expired_date' => $CI->db_value_now('+1 year'),
					'seq_by_year'         => $this->_seq_next_val(),
					'payment_method'      => $this->payment_method,
					'payment_ref_number'  => $this->payment_id,
					'payment_amount'      => $this->event()->price,
				));

				$sale->save();
				$notify_user = true;
			}
			
		}
		
		$this->order_status = 'finish';
		
		$this->save();
		
		if ( $notify_user ) {
			$this->send_email_ticket();
		}

	}
	
	private function _seq_next_val() {
		$CI =& get_instance();
		$ticket_start_date = $this->ticket_start_date ? $this->ticket_start_date : $CI->db_value_now();
		$ticket_start_date = new \DateTime($ticket_start_date);
		$Y = $ticket_start_date->format('Y');
		return \Model\System\Sequence::nextval($this->table."_".($this->event()->seq_name ? $this->event()->seq_name : $this->event()->code)."_$Y");
	}
	
	public function send_email_ticket() {
		
		//if ( ! $this->email ) return;
		
		$CI =& get_instance();

		$notify_email = $CI->config->item('notification_email');
		
		$to = $this->email ? $this->email : $notify_email;

		$CI->email->from('no-reply', 'No Reply');
		$CI->email->to('yusar@media-vista.com');
		//$CI->email->to('yusar.chavik@gmail.com');
		
		$user = $CI->db->get_where('cd_appusers', array('id' => $this->app_user_id))->row();

		$CI->email->subject(strtoupper("[".PROJECT_NAME."] - ".$user->username." [$this->uuid]"));
		$data['order'] = $this;
		
		$mail_body = $this->getTicketBody();
	
		$CI->email->message($mail_body);
		
		if ( ! $CI->email->send(false) ) {	}
	}
		
	public function getTicketBody() {
		$CI =& get_instance();
		
		$event = $this->event();
		$user  = $this->user();
		
		$template = $event->template_path;
		$tickets = $this->tickets();
		
		$tax_total = 0;
		$disc_total = 0;
		$taxes = $event->taxes();
		foreach( $taxes as $tax ) {
			if ( $tax->tax > 0 ) {
				$tax_total += $tax->tax;
			} else {
				$disc_total += $tax->tax;
			}
		}

		
		$CI->load->library('parser');
		$CI->load->helper('alphaid');
		$data = array(
			'page_title'       => 'Ticket - '.PROJECT_NAME,
			'order_id'         => $this->id,
			'order_uuid'       => strtoupper($this->uuid),
			//'alpha_id'         => alphaID(hexdec($this->uuid)),
			'customer_name'    => $user->user_name,
			'event_code'       => $event->code,
			'event_name'       => $event->name,
			'event_location'   => $event->location,
			'event_start_date' => _ldate_($event->start_date, '%H:%M %Z | %A, %d %B %Y'),
			'event_end_date'   => _ldate_($event->end_date, '%H:%M %Z | %A, %d %B %Y'),
			'total_amount'     => money_format('%= (#10.0n', $this->total_amount),
			'open_amount'      => money_format('%= (#10.0n', $this->open_amount),
			'tax_total'        => $tax_total*100,
			'disc_total'       => -1*$disc_total*100,
			'payment_amount'   => money_format('%= (#10.0n', $this->payment_amount),
			'qty'              => count($tickets),
			'tickets'          => Sales::result()->where(array('order_id' => $this->id ))->all()->to_array(),
			'tax_amount'       => money_format('%= (#10.0n', $this->tax_amount),
			'disc_amount'      => money_format('%= (#10.0n', $this->disc_amount),
			
		);
		
		$mail_body = $CI->parser->parse("/templates/$template/email/ticket-A", $data, TRUE);
		
		return $mail_body;
	
	}
	
	public function getInvoiceBody() {
		$CI =& get_instance();
		
		$event = $this->event();
		$user  = $CI->getUser();
		$template = $event->template_path;
		$tickets = $this->tickets();
		
		$tax_total = 0;
		$disc_total = 0;
		$taxes = $event->taxes();
		foreach( $taxes as $tax ) {
			if ( $tax->tax > 0 ) {
				$tax_total += $tax->tax;
			} else {
				$disc_total += $tax->tax;
			}
		}
		
		
		$CI->load->library('parser');
		$CI->load->helper('alphaid');
		$data = array(
			'order_id'         => $this->id,
			'order_uuid'       => strtoupper($this->uuid),
			//'alpha_id'         => alphaID(hexdec($this->uuid)),
			'customer_name'    => $user->user_name,
			'event_code'       => $event->code,
			'event_name'       => $event->name,
			'event_location'   => $event->location,
			'event_start_date' => _ldate_($event->start_date, '%H:%M %Z | %A, %d %B %Y'),
			'event_end_date'   => _ldate_($event->end_date, '%H:%M %Z | %A, %d %B %Y'),
			'total_amount'     => money_format('%= (#10.0n', $this->total_amount),
			'open_amount'      => money_format('%= (#10.0n', $this->open_amount),
			'tax_total'        => $tax_total*100,
			'disc_total'       => -1*$disc_total*100,
			'payment_amount'   => money_format('%= (#10.0n', $this->payment_amount),
			'qty'              => count($tickets),
			'tickets'          => Sales::result()->where(array('order_id' => $this->id ))->all()->to_array(),
			'tax_amount'       => money_format('%= (#10.0n', $this->tax_amount),
			'disc_amount'      => money_format('%= (#10.0n', $this->disc_amount),
			
		);
		
		$mail_body = $CI->parser->parse("/templates/$template/email/invoice-A", $data, TRUE);
		
		return $mail_body;
	
	}
}