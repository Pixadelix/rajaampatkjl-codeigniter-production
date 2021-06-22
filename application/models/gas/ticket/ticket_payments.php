<?php namespace Model\Ticket;

use \Gas\Core;
use \Gas\ORM;

class Ticket_payments extends ORM {
	
	public $table = 'kjl_ticket_payments';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
		'\\model\\ticket\\ticket_orders' => 'real_order_id',
	);
	
	function _init() {
        
        self::$relationships = array(
			
        );
		
		self::$fields = array(
            'id'                         => ORM::field('int'),
			'real_order_id'              => ORM::field('int'),
			'order_id'                   => ORM::field('int'),
			'transaction_id'             => ORM::field('string'),
			
			'masked_card'                => ORM::field('string'),
			'approval_code'              => ORM::field('string'),
			'bank'                       => ORM::field('string'),
			'eci'                        => ORM::field('string'),
			'saved_token_id'             => ORM::field('string'),
			'saved_toked_id_expired_at'  => ORM::field('string'),
			'channel_response_code'      => ORM::field('string'),
			'channel_response_message'   => ORM::field('string'),
			'transaction_time'           => ORM::field('string'),
			'gross_amount'               => ORM::field('string'),
			'payment_type'               => ORM::field('string'),
			'signature_key'              => ORM::field('string'),
			'status_code'                => ORM::field('string'),
			
			'transaction_status'         => ORM::field('string'),
			'fraud_status'               => ORM::field('string'),
			'status_message'             => ORM::field('string'),
			
            'create_by'                  => ORM::field('int'),
			'create_at'                  => ORM::field('datetime'),
			'update_by'                  => ORM::field('int'),
			'update_at'                  => ORM::field('datetime'),
		);
		
		$this->ts_fields = array('[create_at]', 'update_at');
	}
	
	function create_log() {
		
		$change_log = json_decode($this->change_log);
		
		$o = (object) $this->record['data'];
		$o->change_log = null;
		$change_log[] = get_object_vars($o);
		
		$this->change_log = json_encode($change_log);
	}
}