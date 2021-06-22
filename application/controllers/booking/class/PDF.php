<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Include the main TCPDF library (search for installation path).
require_once(APPPATH.'third_party/TCPDF/tcpdf.php');
 
class PDF { 

	public static $pdf = null;
	
    public static function init() {
		if ( ! self::$pdf ) {
			$pdf = new TCPDF(
				PDF_PAGE_ORIENTATION,
				PDF_UNIT,
				PDF_PAGE_FORMAT,
				true,
				'UTF-8',
				false
			);
			$pdf->SetPrintHeader(false);
			$pdf->SetPrintFooter(false);
			$pdf->SetCreator(PDF_CREATOR);
			
			self::$pdf = $pdf;
		}
    }
	
	
	public static function render_pdf($filename = 'invoice') {
		self::$pdf->Output($filename.".pdf", 'I');
	}
	
}