<?php namespace Model\System;

use \Gas\Core;
use \Gas\ORM;

class Sequence extends ORM {
	
	public $table = 'sys_sequence_data';
	
	public $primary_key = 'sequence_name';
	
	public $foreign_key = array(
	);
	
	function _init() {
		
		self::$fields = array(
            'sequence_name'             => ORM::field('string'),
			'sequence_increment'        => ORM::field('int'),
			'sequence_min_value'        => ORM::field('int'),
			'sequence_max_value'        => ORM::field('int'),
			'sequence_cur_value'        => ORM::field('int'),
			'sequence_cycle'            => ORM::field('numeric')
		);
	}
	
	public static function nextval($sequence_name) {
		$sequence = self::find($sequence_name);
		if ( ! $sequence ) {
			$sequence = self::make(array(
				'sequence_name' => $sequence_name,
			));
			$sequence->save();
		}
		
		$sql = "SELECT nextval('$sequence_name') AS NEXT_SEQUENCE";
		$ci =& get_instance();
		$nextval = $ci->db->query($sql)->result();
		return $nextval[0]->NEXT_SEQUENCE;
	}
}