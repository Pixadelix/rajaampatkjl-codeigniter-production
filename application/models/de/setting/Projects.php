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
	
class Projects extends RA_Editor_Model {
    
    public $table = 'sys_projects';
	
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
				`client_id` mediumint(8) UNSIGNED NOT NULL,
				`create_by` mediumint(8) UNSIGNED NOT NULL DEFAULT '1',
				`create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`update_by` mediumint(8) UNSIGNED DEFAULT NULL,
				`update_at` datetime DEFAULT NULL,
				PRIMARY KEY (`id`),
				KEY `fk_projects_clients1` (`client_id`)
			)" 
		);

	}

	private function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
				Field::inst( "$this->table.id" ),
				Field::inst( "$this->table.name" ),
				Field::inst( "$this->table.description" ),
				Field::inst( "$this->table.client_id" )
					->options( Options::inst()
						->table( 'sys_clients' )
						->value( 'id' )
						->label( 'name' )
					)
				,
				
				Field::inst( 'sys_clients.name' )
			)
			->leftJoin( 'sys_clients', 'sys_clients.id', '=', "$this->table.client_id" )
		;
	}

}