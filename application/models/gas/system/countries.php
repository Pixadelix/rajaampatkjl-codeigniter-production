<?php namespace Model\System;

use \Gas\Core;
use \Gas\ORM;

class Countries extends ORM {
	
	public $table = 'sys_countries';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
	);
	
	function _init() {
		
		/*
		self::$relationshops = array(
			'sales' => ORM::has_many('\\Model\\Ticket\\Sales'),
		);
		*/
		
		self::$fields = array(
            'id'          => ORM::field('int'),
			'code'        => ORM::field('string'),
			'name'        => ORM::field('string')
		);
	}
}