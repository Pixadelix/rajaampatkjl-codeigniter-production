<?php
defined('BASEPATH') OR exit('No direct script access allowed');

defined('STARTUI_ASSET_PATH') or define('STARTUI_ASSET_PATH', '/assets/static/startui/');

class Startui extends RA_Controller {
	
	public function index($page = 'index.html')
	{
		$this->load->view("startui/common/index");
    }
}