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
	
class TicketOrdersDtl extends RA_Editor_Model {
	
	public $table = 'kjl_ticket_orders_dtl';
	
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
				`order_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
				`app_user_id` int(11) UNSIGNED NOT NULL,
                `full_name` varchar(200) DEFAULT NULL,
                `gender` varchar(20) DEFAULT NULL,
                `id_card_number` varchar(50) DEFAULT NULL,
				`country_code` varchar(10) DEFAULT NULL,
                `phone` varchar(50) DEFAULT NULL,
                `email` varchar(100) DEFAULT NULL,
				`price` decimal(20,2) NOT NULL DEFAULT 0,
				`image_url` varchar(255) DEFAULT NULL,

                `create_by` mediumint(8) UNSIGNED NOT NULL DEFAULT '1',
				`create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`update_by` mediumint(8) UNSIGNED DEFAULT NULL,
				`update_at` datetime DEFAULT NULL,

				INDEX (`order_id`),
				INDEX (`app_user_id`),
                
				PRIMARY KEY (`id`)
			)" 
		);
	}
	
	public function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
                Field::inst( "$this->table.id" ),
				Field::inst( "$this->table.order_id" ),
				Field::inst( "$this->table.app_user_id" ),
				Field::inst( "$this->table.full_name" ),
				Field::inst( "$this->table.gender" ),
				Field::inst( "$this->table.id_card_number" ),
				Field::inst( "$this->table.country_code" ),
				Field::inst( "$this->table.phone" ),
				Field::inst( "$this->table.email" ),
				Field::inst( "$this->table.price" ),
				Field::inst( "$this->table.image_url" ),

				Field::inst( "$this->table.create_by" ),
				Field::inst( "$this->table.create_at" ),
				Field::inst( "$this->table.update_by" ),
				Field::inst( "$this->table.update_at" ),
				
				Field::inst( "cd_appusers.username" ),
				Field::inst( "sys_countries.name" )
			)
			->leftJoin( 'cd_appusers', 'cd_appusers.id', '=', "$this->table.app_user_id" )
			->leftJoin( 'sys_countries', 'sys_countries.code', '=', "$this->table.country_code" )
		;
	}
	
	public function get($id = null, $id2 = null) {
		$this->editor->where("$this->table.order_id", $id, '=');
		parent::get();
	}
}