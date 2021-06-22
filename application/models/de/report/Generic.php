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
	
class Generic extends RA_Editor_Model {
	
	static $_db;
	static $_rows = array();
	static $_sql;
	static $_params = array();
	
	public function __construct() {
		parent::__construct();
		self::$_db = $this->db_datatables;
	}
	
	public static function sql($sql) {
		self::$_sql = $sql;
		//self::$_rows = self::$_db->sql($sql)->fetchAll();
	}
	
	public static function sql2($sql, $params) {
		self::$_sql    = $sql;
		self::$_params = $params;
	
	}
	
	public static function exec() {
		//var_dump(self::$_sql); var_dump(self::$_params); die;
		$q = self::$_db->query('raw');
		foreach( self::$_params as $k => $v ) {
			$q->bind($k, $v);
		}
		//var_dump($q); die;
		self::$_rows = $q->exec(self::$_sql)->fetchAll();
		//var_dump(self::$_rows); die;
	}
	
	public static function fetchAll() {
		self::exec();
		return self::$_rows;
	}
	
	public static function json() {
		self::exec();
		$arr = array(
			'data' => self::$_rows,
			'options' => '',
			'files' => ''
		);
		
		echo json_encode($arr);
		exit();
	}
	
	
	
}