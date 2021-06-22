<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VisitorByCategory {
	protected $sql;
	protected $params = array();
	protected $year;
	public $template = 'adminlte/reports/visitor_by_category';
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->data['PAGE_TITLE'] = 'Visitor by Category';
		$this->CI->breadcrumbs->push('Visitor by Category', '/report/visitor-by-category');
		$this->CI->enqueue_resource('resource/script/adminlte/reports/js/visitor_by_category.php');
		$this->CI->load->model('de/report/Generic');
		$this->_init();
	}
	
	private function _init() {
		$year = $this->CI->input->post('year');
		$this->year = $year ? $year : (new DateTime)->format('Y');
		$this->params = array(':year' => $this->year);
		
		$this->sql = "
SELECT count(case when month(s.ticket_start_date) = 1 then s.ticket_start_date end) as `jan`,
       count(case when month(s.ticket_start_date) = 2 then s.ticket_start_date end) as `feb`,
       count(case when month(s.ticket_start_date) = 3 then s.ticket_start_date end) as `mar`,
       count(case when month(s.ticket_start_date) = 4 then s.ticket_start_date end) as `apr`,
       count(case when month(s.ticket_start_date) = 5 then s.ticket_start_date end) as `may`,
       count(case when month(s.ticket_start_date) = 6 then s.ticket_start_date end) as `jun`,
       count(case when month(s.ticket_start_date) = 7 then s.ticket_start_date end) as `jul`,
       count(case when month(s.ticket_start_date) = 8 then s.ticket_start_date end) as `aug`,
       count(case when month(s.ticket_start_date) = 9 then s.ticket_start_date end) as `sep`,
       count(case when month(s.ticket_start_date) = 10 then s.ticket_start_date end) as `oct`,
       count(case when month(s.ticket_start_date) = 11 then s.ticket_start_date end) as `nov`,
       count(case when month(s.ticket_start_date) = 12 then s.ticket_start_date end) as `dec`,
       count(s.ticket_start_date) as `total`,
       CASE c.code WHEN 'ID' THEN 'Domestik' ELSE 'International' END as `visitor_category`,
       year(s.ticket_start_date) as `y`
  FROM `kjl_ticket_sales` s,
       `sys_countries` c
 WHERE s.country_id = c.id
   AND year(s.ticket_start_date) = :year
 GROUP BY `visitor_category`
";
	}
	
	public function get($id = null, $id2 = null) {
		$this->CI->get();
		$this->CI->Generic::sql2(
			$this->sql, 
			$this->params
		);
		$this->CI->Generic::json();
	}
	
	public function get_chart_data() {
		$this->CI->Generic::sql2(
			$this->sql,
			$this->params
		);
		//$rows = $this->CI->db->query($this->sql)->result();
		$rows = $this->CI->Generic::fetchAll();
		$data = array();
		$labels = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec','Total');
		foreach($rows as $row) {
			$row = (object) $row;
			$rgb = getColor($row->visitor_category, $row->visitor_category);
			$data[] = array(
				'label' => $row->visitor_category,
				'borderColor' => 'rgba(0,0,0,.7)', //'rgb('.$rgb[0].','.$rgb[1].','.$rgb[2].')',
				'backgroundColor' => 'rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',.7)',
				'borderWidth' => 1,
				'data' => array(
					(int) $row->jan,
					(int) $row->feb,
					(int) $row->mar,
					(int) $row->apr,
					(int) $row->may,
					(int) $row->jun,
					(int) $row->jul,
					(int) $row->aug,
					(int) $row->sep,
					(int) $row->oct,
					(int) $row->nov,
					(int) $row->dec,
					(int) $row->total,
				)
			);
		}
		
		$response = array(
			'labels' => $labels,
			'datasets' => $data,
		);
		
		$this->CI->json_response($response);
	}
}