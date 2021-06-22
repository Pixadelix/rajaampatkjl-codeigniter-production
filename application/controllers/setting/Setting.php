<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends RA_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->restricted('admin');
		$this->breadcrumbs->push('Settings', '/settings');
	}
	
		
	public function index()
	{
		$this->dashboard('adminlte/blank');
	}
	
}