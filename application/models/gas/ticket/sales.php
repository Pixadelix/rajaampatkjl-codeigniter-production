<?php namespace Model\Ticket;

use \Gas\Core;
use \Gas\ORM;

class Sales extends ORM {
	
	public $table = 'kjl_ticket_sales';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
        '\\model\\system\\countries' => 'country_id',
		'\\model\\ticket\\operators' => 'operator_id',
		'\\model\\ticket\\product_events' => 'event_id',
		'\\model\\ticket\\ticket_orders' => 'order_id',
	);
	
	function _init() {
        
        self::$relationships = array(
            'country' => ORM::belongs_to('\\Model\\System\\Countries'),
			'operator' => ORM::belongs_to('\\Model\\Ticket\\Operators'),
			'event' => ORM::belongs_to('\\Model\\Ticket\\Product_events'),
			'order' => ORM::belongs_to('\\Model\\Ticket\\Ticket_orders'),
			
        );
		
		self::$fields = array(
            'id'                   => ORM::field('int'),
			'uuid'                 => ORM::field('string'),
			'app_user_id'          => ORM::field('int'),
			'event_id'             => ORM::field('int'),
            'full_name'            => ORM::field('string'),
            'gender'               => ORM::field('string'),
            'operator_id'          => ORM::field('int'),
            'id_card_type'         => ORM::field('string'),
            'id_card_number'       => ORM::field('string'),
            'country_id'           => ORM::field('int'),
            'kjl_card_number'      => ORM::field('string'),
            'payment_ref_number'   => ORM::field('string'),
            'ticket_ref_number'    => ORM::field('string'),
			'ticket_type'          => ORM::field('string'),
            'ticket_start_date'    => ORM::field('date'),
			'ticket_expired_date'  => ORM::field('date'),
            'payment_method'       => ORM::field('string'),
            'category'             => ORM::field('string'),


            'email'                => ORM::field('string'),
            'phone'                => ORM::field('string'),

            'payment_amount'       => ORM::field('numeric'),
			
			'seq_by_year'          => ORM::field('int'),
			'change_log'           => ORM::field('longtext'),
            
            'create_by'            => ORM::field('int'),
			'create_at'            => ORM::field('datetime'),
			'update_by'            => ORM::field('int'),
			'update_at'            => ORM::field('datetime'),
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