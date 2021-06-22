<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class VisitorByLocation {
	protected $sql;
	protected $year;
	protected $country;
	public $template = 'adminlte/reports/visitor_by_operator';
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->data['PAGE_TITLE'] = 'Visitor by Location';
		$this->CI->breadcrumbs->push('Visitor by Location', '/report/visitor-by-location');
		$this->CI->enqueue_resource('resource/script/adminlte/reports/js/visitor_by_location.php');
		$this->CI->load->model('de/report/Generic');
		$this->_init();
	}
	
	private function _init() {
		$year = $this->CI->input->post('year');
		$this->year = $year ? $year : (new DateTime())->format('Y');
		
		$country = $this->CI->input->post('country');
		$this->country = is_array($country) ? implode(', ', $country) : null;
		$country_filter = $this->country ? "and s.country_id in ($this->country)" : null;
		
		$this->sql = "
SELECT o.name,
       s.office_id,
       year(s.ticket_start_date) as `year`,
       count(case when month(s.ticket_start_date) = 1 then s.ticket_start_date end) as `jan`,
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
       count(s.ticket_start_date) as `total`
  FROM `kjl_ticket_sales` s, `kjl_offices` o
 WHERE s.office_id = o.id
   AND year(s.ticket_start_date) = :year
   $country_filter
 GROUP BY o.id, year";
	}
	
	public function get($id = null, $id2 = null) {
		$this->CI->get();
		$this->CI->Generic::sql2(
			$this->sql.' order by `total` desc',
			array(
				':year' => $this->year,
			)
		);
		$this->CI->Generic::json();
	}
	
	public function get_chart_data() {
		$this->CI->Generic::sql2(
			$this->sql.' order by `total` desc limit 10',
			array(':year' => $this->year)
		);
		
		$rows = $this->CI->Generic::fetchAll();
		$data = array();
		$labels = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
		foreach($rows as $row) {
			$row = (object) $row;
			$rgb = getColor($row->name, $row->office_id.$row->name);
			$data[] = array(
				'label' => $row->name,
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
					//(int) $row->total,
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