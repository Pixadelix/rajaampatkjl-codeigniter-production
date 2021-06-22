<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once('PDF.php');
 
class PDFCardNumbers extends PDF {
	
	public function __construct() {
		parent::__construct();
	}

	public function create_ticket_card_numbers_pdf($number) {
		$pdf = $this->pdf;
		
		// add a page
		$pdf->AddPage('L', 'BUSINESS_CARD');
		$pdf->SetMargins(0, 0, 0, false);
		$pdf->SetY(0, true, true);
		$pdf->SetAutoPageBreak(TRUE, 0);
		
		//$img_file = '/assets/static/img/KJL-Card-2018-Front-D.png';
		//$this->pdf->SetAlpha(0.2);
		//$this->pdf->Image($img_file, 0, 0); //, 210, 297, '', '', '', false, 300, '', false, false, 0);
		//$this->pdf->SetAlpha(1);
		
		$margin_left = 0;
		$margin_top  = 0;
		$line_height = 4;
		$font_size   = 10;
		
		//$pdf->SetFont('hysmyeongjostdmedium', '', $font_size-2);
		//$pdf->SetFont('pdfatimes', '', $font_size-3);
		$pdf->SetFont('dejavusanscondensed', '', $font_size);
		
		$pdf->Text($margin_left+64.5, $margin_top+18.2, sprintf('%06d', $number));
	}
	
}
