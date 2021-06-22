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
	
class TicketOrders extends RA_Editor_Model {
	
	public $table = 'kjl_ticket_orders';
	
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
				`event_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
				`uuid` varchar(100) NOT NULL,
				-- `short_uuid' varchar(255) NOT NULL,
				`app_user_id` int(11) UNSIGNED NOT NULL,
				`total_amount` decimal(20,2) NOT NULL DEFAULT 0,
				`tax_amount` decimal(20,2) NOT NULL DEFAULT 0,
				`disc_amount` decimal(20,2) NOT NULL DEFAULT 0,
				`open_amount` decimal(20,2) NOT NULL DEFAULT 0,
				`payment_amount` decimal(20,2) NOT NULL DEFAULT 0,
				`payment_method` varchar(20) DEFAULT NULL,
				-- `discount_amount` decimal(20,2) DEFAULT NULL,
				-- `discount_voucher_code` varchar(100) DEFAULT NULL,
				`order_status` varchar(100) DEFAULT 'new',
				`payment_status` varchar(100) DEFAULT NULL,
				`payment_id` varchar(255) DEFAULT NULL,
                `create_by` mediumint(8) UNSIGNED NOT NULL DEFAULT '1',
				`create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`update_by` mediumint(8) UNSIGNED DEFAULT NULL,
				`update_at` datetime DEFAULT NULL,

				UNIQUE (`uuid`),
				INDEX (`app_user_id`),
				INDEX (`order_status`),
                
				PRIMARY KEY (`id`)
			)" 
		);
	}
	
	public function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
                Field::inst( "$this->table.id" ),
				Field::inst( "$this->table.event_id" ),
				Field::inst( "$this->table.uuid" ),
				Field::inst( "$this->table.app_user_id" ),
				Field::inst( "$this->table.total_amount" ),
				Field::inst( "$this->table.tax_amount" ),
				Field::inst( "$this->table.disc_amount" ),
				Field::inst( "$this->table.open_amount" ),
				Field::inst( "$this->table.payment_amount" ),
				Field::inst( "$this->table.payment_method" ),
				//Field::inst( "$this->table.discount_amount" ),
				//Field::inst( "$this->table.discount_voucher_code" ),
				Field::inst( "$this->table.order_status" ),
				Field::inst( "$this->table.payment_status" ),
				Field::inst( "$this->table.create_by" ),
				Field::inst( "$this->table.create_at" ),
				Field::inst( "$this->table.update_by" ),
				Field::inst( "$this->table.update_at" ),
				
				Field::inst( "kjl_product_events.code" ),
				Field::inst( "kjl_product_events.name" ),
				Field::inst( "cd_appusers.username" )
			)
			->leftJoin( 'kjl_product_events', 'kjl_product_events.id', '=', "$this->table.event_id" )
			->leftJoin( 'cd_appusers', 'cd_appusers.id', '=', "$this->table.app_user_id" )
		;
	}
}