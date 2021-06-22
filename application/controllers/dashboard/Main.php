<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends RA_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->restricted();
	}
	
	public function index()
	{
		$this->include_datatables_assets();
        $this->enqueue_style(array(
            //'../plugins/jvectormap/jquery-jvectormap-1.2.2.css',
			'../plugins/jvectormap/jquery-jvectormap-2.0.3.css',
            '../plugins/daterangepicker/daterangepicker-bs3.css',
        ));
        $this->enqueue_scripts(array(
            '../plugins/sparkline/jquery.sparkline.min.js',
            //'../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
						'../plugins/jvectormap/jquery-jvectormap-2.0.3.min.js',
						'../plugins/jvectormap/jquery-jvectormap-world-merc.js',
            //'../plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
            'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js',
            '../plugins/daterangepicker/daterangepicker.js',
            '../plugins/datepicker/bootstrap-datepicker.js',
			'//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.min.js',
        ));
		
		$sales_today = Model\Ticket\Sales::where(array(
			'ticket_start_date >=' => $this->db_value_now(null, 'Y-m-d')
		))->get();
		
		$sales_this_month = Model\Ticket\Sales::where(array(
			'month(ticket_start_date) =' => $this->db_value_now(null, 'm'),
			'year(ticket_start_date) =' => $this->db_value_now(null, 'Y'),
		))->get();
		
		//die(var_dump($sales_this_month));
		$this->data['today_ticket_sales'] = is_array($sales_today) ? count($sales_today) : 0;
		$this->data['this_month_ticket_sales'] = is_array($sales_this_month) ? count($sales_this_month) : 0;

        $this->enqueue_resource('/resource/script/adminlte/dashboard/js/main.php');
        $this->dashboard('/adminlte/dashboard/main');
    }
	
	public function getData() {
		$sql = "
select distinct(year(ticket_start_date)) as `y`
  from kjl_ticket_sales
 order by y
";
		$years = $this->db->query($sql)->result();
		$sql = "
select coalesce(cnt, 0) as `cnt`,
       monthname(str_to_date(sm.id, '%%c')) as `bulan`,
	   sm.id
  from rpt_months as `sm`
left join (
    select count(*) as `cnt`,
       year(ticket_start_date) as `y`,
       month(ticket_start_date) as `m`,
       monthname(str_to_date(month(ticket_start_date), '%%c'))
  from kjl_ticket_sales
 where year(ticket_start_date) = '%s'
  group by year(ticket_start_date),
          month(ticket_start_date),
          monthname(str_to_date(month(ticket_start_date), '%%c'))
 order by year(ticket_start_date),
          month(ticket_start_date)
) as `su` on sm.id = su.m
order by sm.id

";

		$strokeColors = array(
			'purple',
			'magenta',
			'red',
			'green',
			'blue',
		);
		$max    = 0;
		$data   = array();
		$i = 0;
		foreach($years as $year) {
			
			$labels = array();
			$rows = $this->db->query(sprintf($sql, $year->y))->result();
			$data[$i] = array(
				'label'                => $year->y,
				'fill'                 => 'false',
				'backgroundColor'      => $strokeColors[$i],
				'borderColor'          => $strokeColors[$i],
			);
			foreach($rows as $row) {
				array_push($labels, $row->bulan);
				$max = $max > $row->cnt ? $max : $row->cnt;
				$data[$i]['data'][] = $row->cnt;
			}
			$i++;
		}
		
		$sql = "
select c.code as `code`,
       count(*) as `cnt`,
	   c.name, year(s.ticket_start_date) as `y`
  from kjl_ticket_sales s, sys_countries c
 where s.country_id = c.id
   and c.code is not null
 group by c.code
 order by c.code
";
		
		$visitorsData = $this->db->query($sql)->result_array();
		//var_dump(array_values($visitorsData)); die;
		$visitorData = array();
		foreach($visitorsData as $k => $v) {
			$visitorData[$v['code']] = $v['cnt'];
			$countryData[] = array(
				$v['name'],
				$v['cnt'],
				$v['y']
			);
		}
			
		
		$response = array(
			'salesPerMonth' => array(
				'labels' => $labels,
				'datasets' => $data,
				'max' => $max + 1000,
			),
			'visitorsData' => $visitorData,
			'countryData'  => $countryData,
		);
		
		$this->json_response($response);
	}
	
	public function getVisitorByCountry() {
		parent::get();
		
		$year = isset($_POST['year']) ? $_POST['year'] : (new DateTime())->format('Y');
		$sql = "
select c.code as `code`,
       count(*) as `cnt`,
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
	   case when c.code is not null then concat(c.name, ' (', c.code, ')') else '*Invalid Country Code' end as `name`,
	   year(s.ticket_start_date) as `y`
  from kjl_ticket_sales s, sys_countries c
 where s.country_id = c.id
   and year(s.ticket_start_date) = :year
 group by c.code
 order by c.code";
		
		$this->load->model('de/report/Generic');
		$this->Generic::sql2($sql, array(':year' => $year));
		$this->Generic::json();
	}
}

