<?php namespace Model\Ticket;

use \Gas\Core;
use \Gas\ORM;

class Product_taxes extends ORM {
	
	public $table = 'kjl_product_taxes';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
		'\\model\\ticket\\product_events' => 'event_id',
		'\\model\\system\\taxes' => 'tax_id'
	);
	
	function _init() {
		self::$relationships = array(
			'event' => ORM::belongs_to('\\Model\\Ticket\\Product_events'),
			'tax' => ORM::belongs_to('\\Model\\System\\Taxes'),
		);
		
		self::$fields = array(
			'id'        => ORM::field('auto[3]'),
			'event_id'  => ORM::field('int[11]'),
			'tax_id'    => ORM::field('int[11]'),
		);
	}
}