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
	
class Operators extends RA_Editor_Model {
	
	public $table = 'kjl_operators';
	
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
				`name` varchar(100) NOT NULL,
                `category_id` int(8) NOT NULL,
                UNIQUE (`name`, `category_id`),
				INDEX (`name`),
                INDEX (`category_id`),
				PRIMARY KEY (`id`)
			)" 
		);
	}
    
    public function baseline_values() {
        $operators = array_map('str_getcsv', file('../data/2017/operators.csv'));
        for ($i = 0; $i < count($operators); $i++ ) {
            Model\Ticket\Operators::add($operators[$i][0], $operators[$i][1]);
        }
    }

	private function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
                Field::inst( "$this->table.id" ),
				Field::inst( "$this->table.name" ),
                Field::inst( "$this->table.category_id" )
                    ->options( Options::inst()
                        ->table( 'kjl_operator_categories' )
                        ->label( 'kjl_operator_categories.name' )
                        ->value( 'kjl_operator_categories.id' )
                        ->order( 'kjl_operator_categories.name' )
                    )
                , Field::inst( "kjl_operator_categories.name" )
			)
            ->leftJoin( 'kjl_operator_categories', 'kjl_operator_categories.id', '=', "$this->table.category_id" )
		;
	}

}