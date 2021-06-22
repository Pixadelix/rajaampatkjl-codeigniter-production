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
	
class UsersGroups extends RA_Editor_Model {
    
    public $table = 'sys_users_groups';
	
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
				`user_id` int(11) UNSIGNED NOT NULL,
				`group_id` mediumint(8) UNSIGNED NOT NULL,
				PRIMARY KEY (`id`),
				UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
				KEY `fk_users_groups_users1_idx` (`user_id`),
				KEY `fk_users_groups_groups1_idx` (`group_id`)
			)" 
		);
	}

	private function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
				Field::inst( 'id' ),
				Field::inst( 'user_id' ),
				Field::inst( 'group_id' )
			)
		;
	}

}