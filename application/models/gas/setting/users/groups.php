<?php namespace Model\Setting\Users;

use \Gas\Core;
use \Gas\ORM;

class Groups extends ORM {
	
	public $table = 'sys_users_groups';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
		'\\model\\setting\\users' => 'user_id',
		'\\model\\setting\\groups' => 'group_id'
	);
	
	function _init() {
		self::$relationships = array(
			'users' => ORM::belongs_to('\\Model\\Setting\\Users'),
			'groups' => ORM::belongs_to('\\Model\\Setting\\Groups'),
		);
		
		self::$fields = array(
			'id'       => ORM::field('auto[3]'),
			'user_id'  => ORM::field('int[11]'),
			'group_id' => ORM::field('int[11]'),
		);
	}
}