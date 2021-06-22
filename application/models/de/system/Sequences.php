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
	
class Sequences extends RA_Editor_Model {
	
	public $table = 'sys_sequence_data';
	
	public function __construct() {
		
		parent::__construct();
		$this->create_table();
		$this->init_editor();
	}

	public function create_table() {
		
		if ( $this->production() ) return;
		
		$this->db_datatables->sql(
			"CREATE TABLE IF NOT EXISTS `$this->table` (
				`sequence_name` varchar(100) NOT NULL,
				`sequence_increment` int(11) unsigned NOT NULL DEFAULT 1,
				`sequence_min_value` int(11) unsigned NOT NULL DEFAULT 1,
				`sequence_max_value` bigint(20) unsigned NOT NULL DEFAULT 18446744073709551615,
				`sequence_cur_value` bigint(20) unsigned DEFAULT 1,
				`sequence_cycle` boolean NOT NULL DEFAULT FALSE,
				PRIMARY KEY (`sequence_name`)
			)"
		);
		return;
		$this->db_datatables->sql("DROP FUNCTION IF EXISTS `nextval`");
		$this->db_datatables->sql(
			"
			
			CREATE FUNCTION `nextval`(`seq_name` VARCHAR(100)) RETURNS BIGINT NOT DETERMINISTIC NO SQL SQL SECURITY DEFINER BEGIN
				DECLARE cur_val bigint(20);

				SELECT
					sequence_cur_value INTO cur_val
				FROM
					sys_sequence_data
				WHERE
					sequence_name = seq_name
				;

				IF cur_val IS NOT NULL THEN
					UPDATE
						sys_sequence_data
					SET
						sequence_cur_value = IF (
							(sequence_cur_value + sequence_increment) > sequence_max_value,
							IF (
								sequence_cycle = TRUE,
								sequence_min_value,
								NULL
							),
							sequence_cur_value + sequence_increment
						)
					WHERE
						sequence_name = seq_name
					;
				END IF;

				RETURN cur_val;
			END
			
			
			/*
			CREATE OR REPLACE FUNCTION `nextval` (`seq_name` varchar(100))
			RETURNS bigint(20) NOT DETERMINISTIC
			BEGIN
				DECLARE cur_val bigint(20);

				SELECT
					sequence_cur_value INTO cur_val
				FROM
					sys_sequence_data
				WHERE
					sequence_name = seq_name
				;

				IF cur_val IS NOT NULL THEN
					UPDATE
						sys_sequence_data
					SET
						sequence_cur_value = IF (
							(sequence_cur_value + sequence_increment) > sequence_max_value,
							IF (
								sequence_cycle = TRUE,
								sequence_min_value,
								NULL
							),
							sequence_cur_value + sequence_increment
						)
					WHERE
						sequence_name = seq_name
					;
				END IF;

				RETURN cur_val;
			END
			*/
			
			"
		);
	}
	
	private function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'sequence_name' )
			->fields(
                Field::inst( "$this->table.sequence_name" ),
                Field::inst( "$this->table.sequence_cur_value" )
			)
		;
	}
}