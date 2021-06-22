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
	
class AclResource extends RA_Editor_Model {
	
	public $table = 'sys_acl_resource';
    
    const TYPE_SIDEBAR        = 'sidebar';
	const TYPE_SIDEBAR_COMMON = 'sidebar-common';
    const TYPE_NAVBAR         = 'navbar';
    const TYPE_WEBSVC         = 'web-service';
	
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
				`parent_id` int(11) UNSIGNED DEFAULT NULL,
				`code` varchar(50) NOT NULL,
				`label` varchar(255) NOT NULL,
				`url` varchar(255) DEFAULT NULL,
				`icon` varchar(50) DEFAULT NULL,
				`position` int(5) DEFAULT '0',
				`menu_type` varchar(20) NOT NULL DEFAULT 'core',
                UNIQUE( `code`),
				PRIMARY KEY (`id`)
			)" 
		);
	}
	
	private function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
				Field::inst( 'id' ),
				Field::inst( 'parent_id' ),
				Field::inst( 'code' ),
				Field::inst( 'label' ),
				Field::inst( 'url' ),
				Field::inst( 'icon' ),
				Field::inst( 'position' ),
				Field::inst( 'menu_type' )
			)
		;
	}

}