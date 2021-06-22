<?php namespace Model\Ticket;

use \Gas\Core;
use \Gas\ORM;

class Operators extends ORM {
	
	public $table = 'kjl_operators';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
	);
	
	function _init() {
		
		self::$fields = array(
			'id'          => ORM::field('int'),
			'name'        => ORM::field('string'),
            'category_id' => ORM::field('int'),
		);
	}
    
    public static function add($operator_name, $category_name) {
        $category_name = ucfirst($category_name);
        $category = Operator_categories::find_by_name($category_name);
            
        if ( ! $category ) {
            $category = Operator_categories::make(array('name' => $category_name));
            $category->save();
            $category_id = Operator_categories::last_created()->id;
        } else {
            $category_id = $category[0]->id;
            $category[0]->cache_flush();
        }
		
		$operator = self::where(array(
			'name' => $operator_name,
			'category_id' => $category_id
		))
		->get();
		;
		
		if ( $operator ) return $operator;
            
        $operator = self::make(array('name' => $operator_name, 'category_id' => $category_id));
        $operator->save();
        return $operator;
    }
}