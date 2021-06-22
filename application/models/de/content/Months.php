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
	
class Months extends RA_Editor_Model {
	
	public $table = 'rpt_months';
	
	public function __construct() {
		
		parent::__construct();
		$this->create_table();
	}

	public function create_table() {
		
		if ( $this->production() ) return;
		
		$this->db_datatables->sql(
			"CREATE TABLE IF NOT EXISTS `$this->table` (
                `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`id`)
			)" 
		);
	}
	
	public function baseline_values() {
		$this->db_datatables->sql("insert ignore into `$this->table` (`id`) values (1),(2),(3),(4),(5),(6),(7),(8),(9),(10),(11),(12);");
	}
}