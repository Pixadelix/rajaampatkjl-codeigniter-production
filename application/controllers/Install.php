<?php
defined('BASEPATH') OR exit('No direct script access allowed');

defined('INSTALL') OR define('INSTALL', true);

class Install extends RA_Controller {
	
	//protected $source_db = null;
	//protected $target_db = null;
	private $_initialized = false;
    
	protected $tables = null;
	
	/*protected $_tables = array(
	
		// CORE
		array('model' => 'de/system/Sequences'),
        array('model' => 'de/system/Countries'),
		array('model' => 'de/system/Taxes'),
		array('model' => 'de/system/Crons'),
		
		array('model' => 'de/setting/Groups'),
		array('model' => 'de/setting/Users'),
		array('model' => 'de/setting/Clients'),
		array('model' => 'de/setting/Projects'),
		array('model' => 'de/setting/UsersGroups'),
		array('model' => 'de/setting/AclResource'),
		array('model' => 'de/setting/AclRestrictedResource'),
		

        // POSTS
        array('model' => 'de/content/Posts'),
        
        // TICKET
        array('model' => 'de/ticket/OperatorCategories'),
        array('model' => 'de/ticket/Offices'),
        array('model' => 'de/ticket/Operators'),
		array('model' => 'de/ticket/ProductEvents'),
		array('model' => 'de/ticket/ProductTaxes'),
		array('model' => 'de/ticket/TicketOrders'),
		array('model' => 'de/ticket/TicketOrdersDtl'),
		array('model' => 'de/ticket/TicketPayments'),
		array('model' => 'de/ticket/Sales'),
		
		
		// REPORTS
		array('model' => 'de/report/Months'),
		
		// CONTEST
		array('model' => 'de/contest/Questions'),
		array('model' => 'de/contest/Contestants'),
		array('model' => 'de/contest/Scores'),
	);
	*/

	public function __construct() {
		parent::__construct();
		if(php_sapi_name() == "cli") {
			//In cli-mode
		} else {
			//Not in cli-mode
			echo 'This module can only be running in CLI Mode';
			exit();
		}
        $this->output->enable_profiler(false);
        
        $this->target_db = $this->db;
		
		$this->load->config('table_resources');
		$this->tables = $this->config->item('table_resources');
		
		$this->_load_models();
    }
    
    private function _load_models() {
        
        if ( $this->_initialized ) return;
        
		echo "Please wait...".PHP_EOL.PHP_EOL;
		
		for ( $i = 0; $i < count($this->tables); $i++ ) {
			$table = $this->tables[$i];

            $target = $table['model'];
			
			//printf("Load model: %-30s", $target);
            $this->show_progress_status($i+1, count($this->tables), sprintf("%-10s : %-30s", "Initialize", $target));
            
            $this->load->model($table['model'], $target ? $target : $table['model'], $this->target_db);
            
			//print("\n");
			usleep(100000);
		}
		$this->show_progress_status($i+1, count($this->tables), sprintf("%-10s : %-30s", "Initialize", "Done"));
		//print(" Done\n");
		
		$this->_initialized = true;
		
		return;
	}
	
	public function __destruct() {
		if ( ! $this->input->is_cli_request() ) {
			return;
		}
		echo <<<EOL


Installation is finished. Good luck and thank you.

EOL;
        parent::__destruct();
	}
	
	public function help() {
		echo <<<EOL
List of available options:
  - tables    : install tables
  - baseline  : install baseline value for all tables
  - model     : call specific [model_function] specified in the [model_name]
    parameters [model_name] [model_function]
EOL;
	}

	public function index()
	{

		$error_level = error_reporting();
		error_reporting($error_level & ~E_NOTICE);

		$this->help();
		
		error_reporting($error_level);
	}
    
	public function tables() {
		for ( $i = 0; $i < count($this->tables); $i++ ) {
			$table = $this->tables[$i];
            
            $target = $table['model'];
			
			//printf("Create Table: %-30s", $target);
			$this->show_progress_status($i+1, count($this->tables)+1, sprintf("%-10s : %-30s", "Installing", $target));
            $this->load->model($table['model'], $target, $this->target_db);
			
			$this->$target->create_table();
			

			if ( method_exists($this->$target, 'create_view') ) {
				//print("\n");
				$this->$target->create_view();
			}

			//print("\n");
		}
		
		//print("\n");
		$this->show_progress_status($i+1, count($this->tables)+1, sprintf("%-10s : %-30s", "Installing", "Completed"));
	
		return;
	}
	
	public function baseline() {
		//printf("Populating baseline values, please wait...".PHP_EOL);
		//try {
			for ( $i = 0; $i < count($this->tables); $i++ ) {
				$table = $this->tables[$i];
                
                $target = $table['model'];
                
                if ( ! isset($this->target) ) {
                    $this->load->model($table['model'], $target, $this->target_db);
                }

				$this->show_progress_status($i+1, count($this->tables)+1, sprintf("%-10s : %-30s", "Baseline", $target));
				if ( method_exists($this->$target, 'baseline_values') ) {
					$this->$target->baseline_values();
				}
				
				

			}
			
			$this->show_progress_status($i+1, count($this->tables)+1, sprintf("%-10s : %-30s", "Baseline", 'Completed'));
			
			//$this->reset_acl_restricted_resource();
		//}
		//catch (Exception $e) {
			//echo 'Caught exception: ', $e->getMessage(), PHP_EOL;
		//}
		
		print("\n");
	}
    
	// call model function
	public function model($model_name = null, $model_function = null, $arg = null) {
        
        if( !$model_name ) {
            $this->help();
            return;
        }
        
        $model_name = str_replace('-', '/', $model_name);
        
        echo "Load model: $model_name".PHP_EOL;
		$this->load->model($model_name, $model_name, $this->target_db);
		
		if( $model_function ) {
			if ( method_exists($this->$model_name, $model_function) ) {
                echo "Execute: $model_name->$model_function";
				$this->$model_name->$model_function($arg);
			}
		}
	}
}
