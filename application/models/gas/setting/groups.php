<?php namespace Model\Setting;

use \Gas\Core;
use \Gas\ORM;

class Groups extends ORM {
	
	public $table = 'sys_groups';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
		'\\model\\setting\\users\\groups' => 'group_id',
        '\\model\\setting\\acl_restricted_resource' => 'group_id',
	);
	
	function _init() {
		self::$relationships = array(
			'users' => ORM::has_many('\\Model\\Setting\\Users\\Groups => \\Model\\Setting\\Users'),
            'restricted_resources' => ORM::has_many('\\Model\\Setting\\Acl_restricted_resource'),
			
		);
		
		self::$fields = array(
			'id'          => ORM::field('auto[10]'),
			'name'        => ORM::field('string'),
			'description' => ORM::field('string')
		);
	}
}