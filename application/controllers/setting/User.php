<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends RA_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->restricted('admin');
		$this->breadcrumbs->push('User Management', '/setting/users');
	}
	
		
	public function index()
	{
		$this->include_datatables_assets(true);
		
        $this->enqueue_resource('/resource/script/adminlte/setting/users/js/users.js');
        $this->enqueue_resource('/resource/script/adminlte/setting/users/js/groups.js');

		$this->dashboard('adminlte/setting/users/index');
	}
	
	public function get($id = null) {
		parent::get();
		$this->load->model('de/setting/Users');
		$this->Users->get($id);
	}
    
    public function get_groups($id = null) {
        //error_reporting(E_ALL);
        //ini_set('display_errors', '1');
        parent::get();
        $this->load->model('de/setting/Groups', 'groups');
        $this->groups->get($id);
    }
}