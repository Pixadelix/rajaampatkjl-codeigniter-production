<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// DataTables PHP library and database connection
//include_once APPPATH . DATATABLE_EDITOR;

// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Mjoin,
	DataTables\Editor\Options,
	DataTables\Editor\Upload,
	DataTables\Editor\Validate;
	
class ProductTaxes extends RA_Editor_Model {
    
    public $table = 'kjl_product_taxes';
	
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
				`event_id` int(11) UNSIGNED NOT NULL,
				`tax_id` mediumint(8) UNSIGNED NOT NULL,
				PRIMARY KEY (`id`),
				UNIQUE KEY (`event_id`,`tax_id`),
				KEY (`event_id`),
				KEY (`tax_id`)
			)" 
		);
	}

	private function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
				Field::inst( 'id' ),
				Field::inst( 'event_id' ),
				Field::inst( 'tax_id' )
			)
		;
	}

}