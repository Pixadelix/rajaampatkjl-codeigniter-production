<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Report extends RA_Controller {
	
	protected $_sql = array();
	
	public function __construct() {
		parent::__construct();
		$this->data['PAGE_TITLE'] = 'Reporting';
		$this->restricted(array('visitor-report', 'sales-report'));
		//$this->breadcrumbs->push('Report', '/report');
		
		$this->include_datatables_assets(true);
		$this->enqueue_scripts(array(
			'//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.min.js',
		));
		
	}
	
	public function render($type_of_report) {
		$oReport = $this->_createReportObj($type_of_report);
		
		if ( isset($oReport->template) ) {
			$this->dashboard($oReport->template);
		} else {
			$this->dashboard('/adminlte/reports/generic_template');
		}
		
	}
	
	public function get_data($type_of_report) {
		$oReport = $this->_createReportObj($type_of_report);
		$oReport->get();
	}
	
	public function get_chart_data($type_of_report) {
		$oReport = $this->_createReportObj($type_of_report);
		$oReport->get_chart_data();
	}
	
	private function _createReportObj ($type_of_report) {
		if ( ! $type_of_report ) show_404();
		
		$o = null;
		
		switch ( $type_of_report ) {
			case 'visitor-by-operator':
				include_once('class/VisitorByOperator.php');
				$o = new VisitorByOperator();
				break;
			case 'visitor-by-opr-category':
				include_once('class/VisitorByOperatorCategory.php');
				$o = new VisitorByOperatorCategory();
				break;
			case 'visitor-by-category':
				include_once('class/VisitorByCategory.php');
				$o = new VisitorByCategory();
				break;
			case 'visitor-by-gender':
				include_once('class/VisitorByGender.php');
				$o = new VisitorByGender();
				break;
			case 'visitor-by-location':
				include_once('class/VisitorByLocation.php');
				$o = new VisitorByLocation();
				break;
			case 'sales-summary':
				include_once('class/SalesSummary.php');
				$o = new SalesSummary();
				break;
			case 'sales-detailed':
				include_once('class/SalesDetailed.php');
				$o = new SalesDetailed();
				break;
			default:
				$this->dashboard('/adminlte/errors/html/404');
				break;
		}
		
		return $o;
		
	}
	
	
}