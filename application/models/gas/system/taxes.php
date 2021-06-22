<?php namespace Model\System;

use \Gas\Core;
use \Gas\ORM;

class Taxes extends ORM {
	
	public $table = 'sys_taxes';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
	);
	
	function _init() {
		
		self::$fields = array(
            'id'         => ORM::field('int'),
			'name'       => ORM::field('string'),
			'tax'        => ORM::field('numeric')
		);
	}
}