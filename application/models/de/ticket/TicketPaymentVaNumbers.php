<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Mjoin,
	DataTables\Editor\Options,
	DataTables\Editor\Upload,
	DataTables\Editor\Validate,
	DataTables\Editor\ValidateOptions;
	
class TicketPaymentVaNumbers extends RA_Editor_Model {
	
	public $table = 'kjl_ticket_payment_va_numbers';
	
	public function __construct() {
		
		parent::__construct();
		$this->create_table();
		$this->init_editor();
	}

	public function create_table() {
		
		if ( $this->production() ) return;
		
		$this->db_datatables->sql(
			"CREATE TABLE IF NOT EXISTS `$this->table` (
				`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
				`real_order_id` int(11) UNSIGNED NOT NULL,
				`bank` varchar(50) NOT NULL,
				`va_number` varchar(50) NOT NULL,
				
                `create_by` mediumint(8) UNSIGNED NOT NULL DEFAULT '1',
				`create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`update_by` mediumint(8) UNSIGNED DEFAULT NULL,
				`update_at` datetime DEFAULT NULL,
				
				UNIQUE (`real_order_id`, `bank`, `va_number`),
				
				PRIMARY KEY (`id`)
			)" 
		);
	}
	
	public function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
                Field::inst( "$this->table.id" ),
				Field::inst( "$this->table.real_order_id" ),
				Field::inst( "$this->table.bank" ),
				Field::inst( "$this->table.va_number" ),

				Field::inst( "$this->table.create_by" ),
				Field::inst( "$this->table.create_at" ),
				Field::inst( "$this->table.update_by" ),
				Field::inst( "$this->table.update_at" )
				
			)
		;
	}
	
	public function get($id = null, $id2 = null) {
		$this->editor->where("$this->table.real_order_id", $id, '=');
		parent::get();
	}
}