<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PDFReceipt extends PDF { 

	public function create_ticket_card_pdf($id) {
		$ticket = Model\Ticket\Sales::find($id);
		
		if ( ! $ticket ) show_404();
		
		$pdf = $this->pdf;
		
		// add a page
		$pdf->AddPage('P', 'A5');
		$pdf->SetMargins(0, 0, 0, false);
		$pdf->SetY(0, true, true);
		$pdf->SetAutoPageBreak(TRUE, 0);
		
		
		// new style
		$style = array(
			'border' => false,
			'padding' => 0,
			//'fgcolor' => array(128,0,0),
			'bgcolor' => false
		);
		
		$country = $ticket->country();
		$operator = $ticket->operator();
		
		$paid_amt = '';
		$origin   = '';
		$img_file = '';
		switch ($country->code) {
			case 'ID':
				$origin = $operator->name;
				$paid_amt = CONTRIBUTION_D; //'Rp 500.000,- (Lima Ratus Ribu Rupiah)';
				$img_file = '/assets/static/img/Form-KJL-Card-2018-02-Blank.png';
				break;
			default:
				$origin = $country->name;
				$paid_amt = CONTRIBUTION_I; //'Rp 1.000.000,- (One Million Rupiah)';
				$img_file = '/assets/static/img/Form-KJL-Card-2018-01-Blank.png';
				break;
		}
		
		//$pdf->SetAlpha(0.2);
		//$pdf->Image($img_file, 0, 0); //, 210, 297, '', '', '', false, 300, '', false, false, 0);
		//$pdf->SetAlpha(1);
		
		$start_date = new DateTime($ticket->ticket_start_date);
		$expired_date = new DateTime($ticket->ticket_expired_date);
		
		$serial_number = 'RA. '.$start_date->format('dmY').sprintf(' %06d', $ticket->seq_by_year);
		
		$qrcode_data_text = "
Ticket No: $serial_number
Name: $ticket->full_name. 
Country: $country->name. 
".$ticket->id_card_type." No: ".$ticket->id_card_number.". 
Valid: ".$start_date->format('d M Y')." - ".$expired_date->format('d M Y').".";
		
		$margin_left = 45;
		$margin_top  = 21;
		$line_height = 4.7;
		$font_size   = 8.2;
		
		for ( $i = 0; $i < 3; $i++ ) {
			
			$pdf->SetFont('freesansb', '', $font_size-3.3	);
			
			$pdf->Text($margin_left+56, $margin_top+24.2, $serial_number);
		
			// QRCODE,H : QR-CODE Best error correction
			$pdf->write2DBarcode($qrcode_data_text, 'QRCODE,L',
				$margin_left+57, // x
				$margin_top +7, // y
				17,
				17,
				$style,
				'T',
				true
			);
			
			

			//$pdf->SetFont('pdfatimesb', '', $font_size);
			//$pdf->SetFont('freesansb', '', $font_size	);
			$pdf->SetFont('dejavusanscondensedb', '', $font_size);
			//$pdf->SetFont('cid0jp', '', $font_size);
			$pdf->Text($margin_left, $margin_top+=$line_height, strtoupper($ticket->full_name));

			$pdf->SetFont('dejavusanscondensed', '', $font_size	);
			//$pdf->SetFont('cid0jp', '', $font_size);
			$pdf->Text($margin_left, $margin_top+=$line_height, $ticket->id_card_number);
			$pdf->Text($margin_left, $margin_top+=$line_height, $origin);
			//$pdf->SetFont('pdfacourierb', '', $font_size	);
			//$pdf->SetFont('cid0jp', '', $font_size);
			$pdf->Text($margin_left, $margin_top+=$line_height, $ticket->kjl_card_number);
			//$pdf->SetFont('dejavusanscondensed', '', $font_size	);
			$pdf->Text($margin_left, $margin_top+=$line_height, $paid_amt);
			
			$margin_top += 47;
			$line_height -= 0.1;
		}
		
	}
}
