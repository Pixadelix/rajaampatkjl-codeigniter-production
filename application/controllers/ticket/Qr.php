<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Include the main TCPDF library (search for installation path).
require_once(APPPATH.'third_party/TCPDF/tcpdf_barcodes_2d.php');
 
class Qr extends RA_Controller {

	public function __construct() {
		parent::__construct();
		$this->output->enable_profiler(false);
	}
	
    public function index($uuid = null, $type = 'QRCODE,H') {

		$ticket = Model\Ticket\Sales::find_by_uuid($uuid);
		
		if ( ! $ticket ) show_404();
		
		$ticket = $ticket[0];
		
		$country = $ticket->country_id ? $ticket->country() : null;
		$operator = $ticket->operator_id ? $ticket->operator() : null;
		$start_date = new DateTime($ticket->ticket_start_date);
		$expired_date = new DateTime($ticket->ticket_expired_date);
		
		$id_card_number = null;
		$country_name = null;
		
		if ( $country ) {
			$country_name = $country->name;
			switch ($country->code) {
				case 'ID':
					$origin = $operator->name;
					$id_card_number = "No $ticket->id_card_type. ".$ticket->id_card_number;
					$img_file = '/assets/static/img/KJL-Card-2018-D-Blank.png';
					break;
				default:
					$origin = $country->name;
					$id_card_number = "$ticket->id_card_type No. ".$ticket->id_card_number;
					$img_file = '/assets/static/img/KJL-Card-2018-I-Blank.png';
					break;
			}
		}
		
		$serial_number = '';
		if ( $country ) {
			$serial_number = 'M.'.($country->code == 'ID' ? 'D' : 'I').' '.$start_date->format('Y').sprintf(' %06d', $ticket->seq_by_year);
		} else {
			$serial_number = $start_date->format('Y').sprintf('%06d', $ticket->seq_by_year);
		}
		$event = $ticket->event();
		$qrcode_data_text = "
$event->name
Ticket No: $serial_number"
."\nName: $ticket->full_name."
.($country_name ? "\nCountry: $country_name." : null)
.($id_card_number ? "\n$id_card_number." : null)
."\nValid: ".$start_date->format('d M Y')." - ".$expired_date->format('d M Y').".";

		//echo $qrcode_data_text; die;
		$tcpdf2dbarcode = new TCPDF2DBarcode($qrcode_data_text, $type);

		$tcpdf2dbarcode->getBarcodePNG(2,2);
	}
	
	
	public function order($uuid = null) {
		
		$order = Model\Ticket\Ticket_orders::find_by_uuid($uuid);
		
		if ( ! $order ) show_404();
		
		$order = $order[0];
		
		$qrcode_data_text = "http:".base_url()."/ticket/order/$uuid";
		
		$tcpdf2dbarcode = new TCPDF2DBarcode($qrcode_data_text, 'QRCODE,H');
	
		//$tcpdf2dbarcode->getBarcodePNG();
	}
}