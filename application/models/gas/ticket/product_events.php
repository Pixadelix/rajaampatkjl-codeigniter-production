<?php namespace Model\Ticket;

use \Gas\Core;
use \Gas\ORM;

class Product_events extends ORM {
	
	public $table = 'kjl_product_events';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
		'\\model\\ticket\\sales' => 'event_ids',
		'\\model\\ticket\\product_taxes' => 'event_id',
	);
	
	function _init() {
        
        self::$relationships = array(
			'ticket_orders' => ORM::has_many('\\Model\\Ticket\\Ticket_orders'),
			'sales' => ORM::has_many('\\Model\\Ticket\\Sales'),
			'taxes' => ORM::has_many('\\Model\\Ticket\\Product_taxes => \\Model\\System\\Taxes'),
        );
		
		self::$fields = array(
            'id'                   => ORM::field('int'),
			'code'                 => ORM::field('string'),
			'name'                 => ORM::field('string'),
			'content'              => ORM::field('string'),
			'price'                => ORM::field('numeric'),
			'status'               => ORM::field('string'),
			
			'location'             => ORM::field('string'),
			'quota'                => ORM::field('int'),
			'start_date'           => ORM::field('datetime'),
			'end_date'             => ORM::field('datetime'),
			
			'template_path'        => ORM::field('string'),
			
            'create_by'            => ORM::field('int'),
			'create_at'            => ORM::field('datetime'),
			'update_by'            => ORM::field('int'),
			'update_at'            => ORM::field('datetime'),
		);
		
		$this->ts_fields = array('[create_at]', 'update_at');
	}
	
	public function getAvailableQuota() {
		$sales = $this->sales();
		return $this->quota - (count($sales) + rand(25, 89));
	}

	public function deleteContest() {
		$ci =& get_instance();
		$ci->db->delete($this->table, array('id' => $this->id));
		$ci->db->delete(array('cts_questions', 'cts_contestants', 'cts_scores'), array('event_id' => $this->id));
	}
}