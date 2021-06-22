<?php namespace Model\Ticket;

use \Gas\Core;
use \Gas\ORM;

class Offices extends ORM {
	
	public $table = 'kjl_offices';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
	);
	
	function _init() {
		
		self::$fields = array(
			'id'          => ORM::field('int'),
			'name'        => ORM::field('string'),
		);
	}
}