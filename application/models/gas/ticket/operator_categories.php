<?php namespace Model\Ticket;

use \Gas\Core;
use \Gas\ORM;

class Operator_categories extends ORM {
	
	public $table = 'kjl_operator_categories';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
	);
	
	function _init() {
		
		self::$fields = array(
			'id'          => ORM::field('int'),
			'category'    => ORM::field('string')
		);
	}
}