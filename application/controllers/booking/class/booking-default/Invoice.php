<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	
class Invoice extends PDF {
	
	public static $CI = null;
	
	public static function print($uuid) {
		if ( ! self::$CI ) {
			self::$CI = get_instance();
		}

		self::$CI->output->enable_profiler(false);
		
		self::init();
		
		$pdf = self::$pdf;
		
		// add a page
		$pdf->AddPage('L', 'A4');
		$pdf->SetMargins(10, 10, 10, false);
		$pdf->SetY(10, true, true);
		$pdf->SetAutoPageBreak(TRUE, 0);
		
		$style = array(
			'border' => false,
			'vpadding' => 'auto',
			'hpadding' => 'auto',
			'fgcolor' => array(0,0,0),
			'bgcolor' => false, //array(255,255,255)
			'module_width' => 1, // width of a single module in points
			'module_height' => 1 // height of a single module in points
		);
		
		$order = Model\Ticket\Ticket_orders::where(array('uuid' => $uuid))->get();
		
		if ( ! $order ) show_404();
		
		$html = $order->getInvoiceBody();
		$pdf->writeHTML($html);//, true, false, true, false);
		
		//$pdf->Output('invoice.pdf', 'I');
		self::render_pdf();
		
	}
}