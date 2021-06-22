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
	DataTables\Editor\Validate;
	
class Clients extends RA_Editor_Model {
    
    public $table = 'sys_clients';
	
	public function __construct() {
		
		parent::__construct();
		$this->create_table();
		$this->init_editor();
		
	}

	public function create_table() {
		
		if ( $this->production() ) return;
		
		$this->db_datatables->sql(
			"CREATE TABLE IF NOT EXISTS `$this->table` (
				`id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
				`name` varchar(100) NOT NULL,
				`description` varchar(255) NOT NULL,
				`website` varchar(100) DEFAULT NULL,
				`phone` varchar(20) DEFAULT NULL,
				`create_by` mediumint(8) UNSIGNED NOT NULL DEFAULT '1',
				`create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`update_by` mediumint(8) UNSIGNED DEFAULT NULL,
				`update_at` datetime DEFAULT NULL,
				PRIMARY KEY (`id`)
			)" 
		);

	}

	private function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
				Field::inst( 'id' ),
				Field::inst( 'name' ),
				Field::inst( 'description' ),
				Field::inst( 'website' ),
				Field::inst( 'phone' )
			)
		;
	}
	
}