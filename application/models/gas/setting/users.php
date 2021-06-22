<?php

namespace Model\Setting;

use \Gas\Core;
use \Gas\ORM;

class Users extends ORM {
	
	public $table = 'sys_users';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
		'\\model\\setting\\users\\groups' => 'user_id',
		'\\model\\setting\\users\\projects' => 'user_id',
	);
	
	function _init() {
		
		self::$relationships = array(
			'groups' => ORM::has_many('\\Model\\Setting\\Users\\Groups => \\Model\\Setting\\Groups'),
		);
		
		self::$fields = array(
			'id' => ORM::field('auto'),
			'ip_address' => ORM::field('string'),
			'username' => ORM::field('string'),
			'first_name' => ORM::field('string'),
			'email' => ORM::field('string'),
			'phone' => ORM::field('string'),
			'telegram_username' => ORM::field('string'),
            'profile_photo' => ORM::field('int'),
            'created_on' => ORM::field('timestamp'),
		);
	}
}