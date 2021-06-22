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
	
class Appusers extends RA_Editor_Model {
	
	public $table = 'cd_appusers';
	
	public function __construct() {
		
		parent::__construct();
		$this->init_editor();
		
	}

	public function alter_table() {
		
		if ( $this->production() ) return;
		
		$this->db_datatables->sql(
			"ALTER TABLE `$this->table`
				ADD `company_name` VARCHAR(255) DEFAULT NULL AFTER `profile_photo`,
				ADD `phone` VARCHAR(100) DEFAULT NULL AFTER `company_name`,
				ADD `forgotten_password_code` varchar(40) DEFAULT NULL AFTER `phone`,
				ADD `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL AFTER `forgotten_password_code`
			;"
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