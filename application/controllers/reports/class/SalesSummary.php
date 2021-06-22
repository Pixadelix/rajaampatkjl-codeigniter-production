<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class SalesSummary {
	protected $sql;
	protected $params;
	protected $year;
	protected $dom = 500000;
	protected $intl = 1000000;
	public $template = 'adminlte/reports/sales_summary';
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->data['PAGE_TITLE'] = 'Sales Summary';
		$this->CI->breadcrumbs->push('Sales Summary', '/report/sales-summary');
		$this->CI->enqueue_resource('resource/script/adminlte/reports/js/sales_summary.php');
		$this->CI->enqueue_resource('resource/script/adminlte/reports/js/sales_summary_2.php');
		$this->CI->load->model('de/report/Generic');
		$this->_init();
	}
	
	private function _init() {
		$year = $this->CI->input->post('year');
		$dom = $this->CI->input->post('dom');
		$intl = $this->CI->input->post('intl');
		$this->year = $year ? $year : (new DateTime())->format('Y');
		$this->dom = $dom ? $dom : $this->dom;
		$this->intl = $intl ? $intl : $this->intl;
		$this->params = array(
			':year' => $this->year,
			':dom'  => (float) $this->dom,
			':intl' => (float) $this->intl,
		);
		//var_dump($this->params); die;
		$this->sql = "
SELECT count(case when month(s.ticket_start_date) = 1 then s.ticket_start_date end) * CASE c.code WHEN 'ID' THEN :dom ELSE :intl END as `jan`,
       count(case when month(s.ticket_start_date) = 2 then s.ticket_start_date end) * CASE c.code WHEN 'ID' THEN :dom ELSE :intl END as `feb`,
       count(case when month(s.ticket_start_date) = 3 then s.ticket_start_date end) * CASE c.code WHEN 'ID' THEN :dom ELSE :intl END as `mar`,
       count(case when month(s.ticket_start_date) = 4 then s.ticket_start_date end) * CASE c.code WHEN 'ID' THEN :dom ELSE :intl END as `apr`,
       count(case when month(s.ticket_start_date) = 5 then s.ticket_start_date end) * CASE c.code WHEN 'ID' THEN :dom ELSE :intl END as `may`,
       count(case when month(s.ticket_start_date) = 6 then s.ticket_start_date end) * CASE c.code WHEN 'ID' THEN :dom ELSE :intl END as `jun`,
       count(case when month(s.ticket_start_date) = 7 then s.ticket_start_date end) * CASE c.code WHEN 'ID' THEN :dom ELSE :intl END as `jul`,
       count(case when month(s.ticket_start_date) = 8 then s.ticket_start_date end) * CASE c.code WHEN 'ID' THEN :dom ELSE :intl END as `aug`,
       count(case when month(s.ticket_start_date) = 9 then s.ticket_start_date end) * CASE c.code WHEN 'ID' THEN :dom ELSE :intl END as `sep`,
       count(case when month(s.ticket_start_date) = 10 then s.ticket_start_date end) * CASE c.code WHEN 'ID' THEN :dom ELSE :intl END  as `oct`,
       count(case when month(s.ticket_start_date) = 11 then s.ticket_start_date end) * CASE c.code WHEN 'ID' THEN :dom ELSE :intl END  as `nov`,
       count(case when month(s.ticket_start_date) = 12 then s.ticket_start_date end) * CASE c.code WHEN 'ID' THEN :dom ELSE :intl END  as `dec`,
       count(*) * CASE c.code WHEN 'ID' THEN :dom ELSE :intl END as `total`,
       year(s.ticket_start_date) as `y`,
       CASE c.code WHEN 'ID' THEN 'Domestik' ELSE 'International' END as `visitor_category`
  FROM `kjl_ticket_sales` s,
       `sys_countries` c
 WHERE s.country_id = c.id
   AND year(s.ticket_start_date) = :year
 group by `visitor_category`
 
";
	}
	
	public function get($id = null, $id2 = null) {
		$this->CI->get();
		$this->CI->Generic::sql2($this->sql, $this->params);
		$this->CI->Generic::json();
	}
	
	public function get_chart_data() {
		$this->sql = "
SELECT SUM(X.jan) as `jan`,
       SUM(X.feb) as `feb`,
       SUM(X.mar) as `mar`,
       SUM(X.apr) as `apr`,
       SUM(X.may) as `may`,
       SUM(X.jun) as `jun`,
       SUM(X.jul) as `jul`,
       SUM(X.aug) as `aug`,
       SUM(X.sep) as `sep`,
       SUM(X.oct) as `oct`,
       SUM(X.nov) as `nov`,
       SUM(X.dec) as `dec`,
       SUM(X.total) as `total`
  FROM 
(
SELECT count(case when month(s.ticket_start_date) = 1 then s.ticket_start_date end) * CASE c.code WHEN 'ID' THEN :dom ELSE :intl END as `jan`,
       count(case when month(s.ticket_start_date) = 2 then s.ticket_start_date end) * CASE c.code WHEN 'ID' THEN :dom ELSE :intl END as `feb`,
       count(case when month(s.ticket_start_date) = 3 then s.ticket_start_date end) * CASE c.code WHEN 'ID' THEN :dom ELSE :intl END as `mar`,
       count(case when month(s.ticket_start_date) = 4 then s.ticket_start_date end) * CASE c.code WHEN 'ID' THEN :dom ELSE :intl END as `apr`,
       count(case when month(s.ticket_start_date) = 5 then s.ticket_start_date end) * CASE c.code WHEN 'ID' THEN :dom ELSE :intl END as `may`,
       count(case when month(s.ticket_start_date) = 6 then s.ticket_start_date end) * CASE c.code WHEN 'ID' THEN :dom ELSE :intl END as `jun`,
       count(case when month(s.ticket_start_date) = 7 then s.ticket_start_date end) * CASE c.code WHEN 'ID' THEN :dom ELSE :intl END as `jul`,
       count(case when month(s.ticket_start_date) = 8 then s.ticket_start_date end) * CASE c.code WHEN 'ID' THEN :dom ELSE :intl END as `aug`,
       count(case when month(s.ticket_start_date) = 9 then s.ticket_start_date end) * CASE c.code WHEN 'ID' THEN :dom ELSE :intl END as `sep`,
       count(case when month(s.ticket_start_date) = 10 then s.ticket_start_date end) * CASE c.code WHEN 'ID' THEN :dom ELSE :intl END  as `oct`,
       count(case when month(s.ticket_start_date) = 11 then s.ticket_start_date end) * CASE c.code WHEN 'ID' THEN :dom ELSE :intl END  as `nov`,
       count(case when month(s.ticket_start_date) = 12 then s.ticket_start_date end) * CASE c.code WHEN 'ID' THEN :dom ELSE :intl END  as `dec`,
       count(*) * CASE c.code WHEN 'ID' THEN :dom ELSE :intl END as `total`,
       year(s.ticket_start_date) as `y`,
       CASE c.code WHEN 'ID' THEN 'Domestik' ELSE 'International' END as `visitor_category`
  FROM `kjl_ticket_sales` s,
       `sys_countries` c
 WHERE s.country_id = c.id
   AND year(s.ticket_start_date) = :year
 group by `visitor_category`
) X

		";
		
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
			$rgb = getColor($row->total);
			$data[] = array(
				'label' => $this->year,
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