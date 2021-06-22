<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ticketing extends RA_Controller {
	
	public function index() {
		//die('index');
		redirect('/booking/frontend');
		return;
    }
}