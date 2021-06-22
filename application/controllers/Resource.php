<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resource extends RA_Controller {
	
	public function __construct() {
		parent::__construct();
        $this->output->enable_profiler(false);
		//$this->restricted();
	}
	
    public function index() {
        // do not use, use script handler instead
        die;
    }
    
    public function style(
        $path1 = null,
        $path2 = null,
        $path3 = null,
        $path4 = null,
        $path5 = null,
        $path6 = null
    ) {
        $path = $path1
            .($path2?"/$path2":'')
            .($path3?"/$path3":'')
            .($path4?"/$path4":'')
            .($path5?"/$path5":'')
            .($path6?"/$path6":'')
        ;

        $this->data['path'] = $path;
        $this->load->view($path, $this->data);
	}
    
	public function script(
        $path1 = null,
        $path2 = null,
        $path3 = null,
        $path4 = null,
        $path5 = null,
        $path6 = null
    ) {
        $path = $path1
            .($path2?"/$path2":'')
            .($path3?"/$path3":'')
            .($path4?"/$path4":'')
            .($path5?"/$path5":'')
            .($path6?"/$path6":'')
        ;

        $this->data['path'] = $path;
        $this->load->view($path, $this->data);
	}

}   