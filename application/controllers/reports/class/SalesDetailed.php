<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SalesDetailed {
	protected $sql;
	protected $params;
	protected $year;
	protected $dom = 500000;
	protected $intl = 1000000;
	public $template = 'adminlte/reports/sales_detailed';

	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->data['PAGE_TITLE'] = 'Sales Detailed';
		$this->CI->breadcrumbs->push('Sales Detailed', '/report/sales-detailed');
		$this->CI->include_datatables_assets(true);
		$this->CI->enqueue_scripts('//underscorejs.org/underscore-min.js');

		$this->CI->enqueue_scripts([
			//"https://cdn.jsdelivr.net/jquery/latest/jquery.min.js",
			//"https://cdn.jsdelivr.net/momentjs/latest/moment.min.js",
			"https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js",
		]);
		$this->CI->enqueue_style([
			"https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css",
		]);		

		$this->CI->enqueue_resource('/resource/script/adminlte/reports/js/sales_detailed.php');
		$this->CI->load->model('de/report/Generic');
		$this->_init();
	}

	private function _init() {
		$dates = $this->CI->input->post('dates');
		if ( ! $dates ) return;

		$dates = explode(" - ", $this->CI->input->post('dates'));

		$this->params = array(
			':start_date' => trim($dates[0]),
			':end_date'   => trim($dates[1]),
		);
		
		//die(var_dump($this->params));

		$this->sql = "
SELECT kjl_ticket_sales.id,
       kjl_ticket_sales.full_name,
       kjl_ticket_sales.gender,
       kjl_ticket_sales.id_card_type,
       sys_countries.name as country,
       kjl_ticket_sales.country_id,
       kjl_ticket_sales.id_card_number,
       kjl_ticket_sales.phone,
       kjl_ticket_sales.email,
       kjl_ticket_sales.ticket_start_date,
       kjl_ticket_sales.ticket_expired_date,
       kjl_ticket_sales.payment_method,
       kjl_ticket_sales.payment_amount,
       sys_users.first_name,
       kjl_ticket_sales.create_by,
       kjl_operators.name as operator_name,
       kjl_ticket_sales.operator_id,
			 kjl_offices.name as office_name,
			 kjl_ticket_sales.create_at
  FROM kjl_ticket_sales,
       sys_countries,
       kjl_operators,
       kjl_offices,
       sys_users
WHERE kjl_ticket_sales.country_id = sys_countries.id
  AND kjl_ticket_sales.operator_id = kjl_operators.id
  AND kjl_ticket_sales.office_id = kjl_offices.id
	AND date(kjl_ticket_sales.ticket_start_date) >= STR_TO_DATE(:start_date, '%Y/%c/%e')
	AND date(kjl_ticket_sales.ticket_start_date) <= STR_TO_DATE(:end_date, '%Y/%c/%e')
  AND kjl_ticket_sales.create_by = sys_users.id
ORDER BY kjl_ticket_sales.id ASC, kjl_ticket_sales.full_name ASC
LIMIT 20000
";

		//die(var_dump($this->sql));
	}

	

	public function  get($id = null, $id2 = null) {
		$this->CI->get();
		$this->CI->Generic::sql2($this->sql, $this->params);
		$this->CI->Generic::json();
	}
}