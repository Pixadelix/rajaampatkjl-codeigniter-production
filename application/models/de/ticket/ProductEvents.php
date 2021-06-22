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
	
class ProductEvents extends RA_Editor_Model {
	
	public $table = 'kjl_product_events';
	
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
				`code` varchar(100) DEFAULT NULL,
				`name` varchar(255) DEFAULT NULL,
				`content` longtext DEFAULT NULL,
				`price` decimal(20,2) NOT NULL DEFAULT 0,
				`status` varchar(100) DEFAULT 'open',
				
				`location` varchar(255) DEFAULT NULL,
				`quota` mediumint(8) NOT NULL DEFAULT 0,
				`start_date` datetime DEFAULT NULL,
				`end_date` datetime DEFAULT NULL,
				
				`template_path` varchar(255) NOT NULL DEFAULT 'templates/booking-default',
				`seq_name` varchar(255) DEFAULT NULL,
				
				`event_type` varchar(100) NOT NULL DEFAULT 'ticket',

                `create_by` mediumint(8) UNSIGNED NOT NULL DEFAULT '1',
				`create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`update_by` mediumint(8) UNSIGNED DEFAULT NULL,
				`update_at` datetime DEFAULT NULL,
				
				UNIQUE (`code`),
                
				PRIMARY KEY (`id`)
			)" 
		);
	}
	
	public function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->field(
				Field::inst( "$this->table.id" ),
				Field::inst( "$this->table.code" )
					->validator('Validate::NotEmpty'),
				Field::inst( "$this->table.name" )
					->validator('Validate::NotEmpty'),
				Field::inst( "$this->table.content" ),
				Field::inst( "$this->table.price" )
					->validator('Validate::NotEmpty'),
				Field::inst( "$this->table.status" ),
				Field::inst( "$this->table.location" )
					->validator('Validate::NotEmpty'),
				Field::inst( "$this->table.quota" )
					->validator('Validate::NotEmpty'),
				Field::inst( "$this->table.start_date" )
					->validator('Validate::NotEmpty'),
				Field::inst( "$this->table.end_date" )
					->validator('Validate::NotEmpty'),
				Field::inst( "$this->table.template_path" )
					->validator('Validate::NotEmpty'),
				Field::inst( "$this->table.seq_name" ),
				Field::inst( "$this->table.event_type" ),
				Field::inst( "$this->table.create_by"                 )->set(Field::SET_CREATE),
				Field::inst( "$this->table.create_at"                 )->set(Field::SET_CREATE),
				Field::inst( "$this->table.update_by"                 )->set(Field::SET_EDIT),
				Field::inst( "$this->table.update_at"                 )->set(Field::SET_EDIT)
			)
		
			->join(
				Mjoin::inst( 'sys_taxes' )
					->link( "$this->table.id", 'kjl_product_taxes.event_id' )
					->link( "sys_taxes.id", 'kjl_product_taxes.tax_id' )
					->order( 'name asc' )
					->fields(
						Field::inst( 'id' )
							->options( Options::inst()
								->table( 'sys_taxes' )
								->value( 'id' )
								->label( 'name' )
							),
						Field::inst( 'name' )
					)
				)
		;
	}
}