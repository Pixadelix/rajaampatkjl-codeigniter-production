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
	
class TicketPayments extends RA_Editor_Model {
	
	public $table = 'kjl_ticket_payments';
	
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
				
				`order_id` varchar(100) NOT NULL,
				`transaction_id` varchar(100) NOT NULL,
				
				`masked_card` varchar(255) DEFAULT NULL,
				`approval_code` varchar(255) DEFAULT NULL,
				`bank` varchar(255) DEFAULT NULL,
				`eci` varchar(255) DEFAULT NULL,
				`saved_token_id` varchar(255) DEFAULT NULL,
				`saved_token_id_expired_at` varchar(255) DEFAULT NULL,
				`channel_response_code` varchar(255) DEFAULT NULL,
				`channel_response_message` varchar(255) DEFAULT NULL,
				`transaction_time` varchar(255) DEFAULT NULL,
				`gross_amount` varchar(255) DEFAULT NULL,
				`currency` varchar(20) DEFAULT NULL,
				
				`payment_type` varchar(255) DEFAULT NULL,
				`signature_key` varchar(255) DEFAULT NULL,
				`status_code` varchar(255) DEFAULT NULL,
				
				`transaction_status` varchar(255) DEFAULT NULL,
				`fraud_status` varchar(255) DEFAULT NULL,
				`status_message` varchar(255) DEFAULT NULL,

				`change_log` longtext,                

                `create_by` mediumint(8) UNSIGNED NOT NULL DEFAULT '1',
				`create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`update_by` mediumint(8) UNSIGNED DEFAULT NULL,
				`update_at` datetime DEFAULT NULL,
				
				UNIQUE (`real_order_id`),
				UNIQUE (`order_id`),
				UNIQUE (`transaction_id`),

				PRIMARY KEY (`id`)
			)" 
		);
	}
	
	public function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
                Field::inst( "$this->table.id" ),
				Field::inst( "$this->table.real_order_id" ),
				Field::inst( "$this->table.order_id" ),
				Field::inst( "$this->table.transaction_id" ),
				Field::inst( "$this->table.masked_card" ),
				Field::inst( "$this->table.approval_code" ),
				Field::inst( "$this->table.bank" ),
				Field::inst( "$this->table.eci" ),
				Field::inst( "$this->table.saved_token_id" ),
				Field::inst( "$this->table.saved_token_id_expired_at" ),
				Field::inst( "$this->table.channel_response_code" ),
				Field::inst( "$this->table.channel_response_message" ),
				Field::inst( "$this->table.transaction_time" ),
				Field::inst( "$this->table.gross_amount" ),
				Field::inst( "$this->table.payment_type" ),
				Field::inst( "$this->table.signature_key" ),
				Field::inst( "$this->table.status_code" ),
				Field::inst( "$this->table.transaction_status" ),
				Field::inst( "$this->table.fraud_status" ),
				Field::inst( "$this->table.status_message" ),
				
				Field::inst( "$this->table.change_log"),

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