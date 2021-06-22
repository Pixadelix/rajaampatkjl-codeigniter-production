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
	
class Groups extends RA_Editor_Model {
	
	public $table = 'sys_groups';
	
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
				`name` varchar(20) NOT NULL,
				`description` varchar(100) NOT NULL,
                
                UNIQUE ( `name` ),
				PRIMARY KEY (`id`)
			)"
		);
	}
	
	public function baseline_values() {
		
		if ( $this->production() ) return;
		
		$this->db_datatables->sql(
			"INSERT IGNORE INTO `$this->table` (`id`, `name`, `description`) VALUES
			(1, 'admin',      'Administrator (Root)'),
			(2, 'operator',   'Operator'),
			(3, 'manager',    'Manager'),
			(4, 'supervisor', 'Supervisor')"
		);
	}

	private function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
				Field::inst( 'id' ),
				Field::inst( 'name' ),
				Field::inst( 'description' )
			)
		;
	}

}