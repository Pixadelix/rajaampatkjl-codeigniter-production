<?php namespace Model\Ticket;

use \Gas\Core;
use \Gas\ORM;

class Ticket_orders_dtl extends ORM {
	
	public $table = 'kjl_ticket_orders_dtl';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
		'\\model\\ticket\ticket_orders' => 'order_id',
	);
	
	function _init() {
        
        self::$relationships = array(
			'order' => ORM::belongs_to('\\Model\\Ticket\Ticket_orders'),
        );
		
		self::$fields = array(
            'id'                   => ORM::field('int'),
			'order_id'             => ORM::field('int'),
			'app_user_id'          => ORM::field('int'),
            'full_name'            => ORM::field('string'),
            'gender'               => ORM::field('string'),
            'id_card_number'       => ORM::field('string'),
			'country_code'         => ORM::field('string'),
            'phone'                => ORM::field('string'),
			'email'                => ORM::field('string'),
            'price'                => ORM::field('numeric'),
			'image_url'            => ORM::field('string'),
			
            'create_by'            => ORM::field('int'),
			'create_at'            => ORM::field('datetime'),
			'update_by'            => ORM::field('int'),
			'update_at'            => ORM::field('datetime'),
		);
		
		$this->ts_fields = array('[create_at]', 'update_at');
	}
}