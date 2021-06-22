<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Include the main TCPDF library (search for installation path).
require_once(APPPATH.'third_party/TCPDF/tcpdf.php');
 
class PDF { 

	public $pdf;
	
    public function __construct() { 
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
		
		$this->pdf = $pdf;
    }
	
	
	public function render_pdf($filename = 'ticket') {
		$this->pdf->Output(md5($filename).".pdf", 'I');
	}
	
}