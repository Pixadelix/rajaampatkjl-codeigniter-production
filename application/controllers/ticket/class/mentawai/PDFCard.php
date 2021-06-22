<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PDFCard extends PDF { 

	public function create_ticket_card_pdf($id) {
		$ticket = Model\Ticket\Sales::find($id);
		
		if ( ! $ticket ) show_404();
		
		$pdf = $this->pdf;
		
		// add a page
		$pdf->AddPage('L', 'BUSINESS_CARD');
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
		
		$style = array(
			'border' => false,
			'vpadding' => 'auto',
			'hpadding' => 'auto',
			'fgcolor' => array(0,0,0),
			'bgcolor' => false, //array(255,255,255)
			'module_width' => 1, // width of a single module in points
			'module_height' => 1 // height of a single module in points
		);
		
		$country = $ticket->country();
		$operator = $ticket->operator();
		$start_date = new DateTime($ticket->ticket_start_date);
		$expired_date = new DateTime($ticket->ticket_expired_date);
		
		$id_card_number = '';
		$valid = '';
		
		switch ($country->code) {
			case 'ID':
				$origin = $operator->name;
				$id_card_number = "No $ticket->id_card_type. ".$ticket->id_card_number;
				$valid = 'Berlaku '.$start_date->format('d/m/Y').' sd '.$expired_date->format('d/m/Y');
				$img_file = '/assets/static/img/KJL-Card-2018-D-Blank.png';
				break;
			default:
				$origin = $country->name;
				$id_card_number = "$ticket->id_card_type No. ".$ticket->id_card_number;
				$valid = 'Valid '.$start_date->format('d/m/Y').' to '.$expired_date->format('d/m/Y');
				$img_file = '/assets/static/img/KJL-Card-2018-I-Blank.png';
				break;
		}
		
		//$pdf->SetAlpha(0.5);
		//$pdf->Image($img_file, 0, 0); //, 210, 297, '', '', '', false, 300, '', false, false, 0);
		//$pdf->SetAlpha(1);
		
		$serial_number = 'M.'.($country->code == 'ID' ? 'D' : 'I').' '.$start_date->format('Y').sprintf(' %06d', $ticket->seq_by_year);
		
		$qrcode_data_text = "
Ticket No: $serial_number
Name: $ticket->full_name. 
Country: $country->name. 
".$id_card_number.". 
Valid: ".$start_date->format('d M Y')." - ".$expired_date->format('d M Y').".";
		
		$margin_left = 0;
		$margin_top  = 0;
		$line_height = 4;
		$font_size   = 10;
		
		$pdf->SetFont('freesansb', '', $font_size-5.8	);
		//[ddmmyy][6 digit nourut]
		
		
		$pdf->Text($margin_left+62.88, $margin_top+32.3, $serial_number);
		
		// QRCODE,H : QR-CODE Best error correction
		
		$pdf->write2DBarcode($qrcode_data_text, 'QRCODE,H',
			$margin_left+63.5, // x
			$margin_top +20.2, // y
			12.5,
			12.5,
			$style,
			'T',
			true
			);
		
		//$pdf->write2DBarcode($qrcode_data_text, 'QRCODE,L', $margin_left+64, $margin_top+20.4, 12, 12, $style, 'N');


		$margin_left = 10;
		$margin_top = 20.5;
		
		//$ticket->full_name = '12345678901234567890123456789012345678901234567890';

		//$pdf->SetFont('freesansb', '', $font_size);
		$full_name_len = strlen($ticket->full_name);
		$font_size_full_name = $font_size;
		$top_country = 0;
		switch ($full_name_len) {
			case $full_name_len < 20:
				$font_size_full_name = $font_size;
				break;
			case $full_name_len < 30:
				$font_size_full_name = $font_size - 2;
				break;
				
			case $full_name_len < 40:
				$font_size_full_name = $font_size - 4;
				$margin_top = $margin_top + .8;
				$top_country = - .8;
				break;
			
			default:
				$font_size_full_name = $font_size - 6;
				
				break;
		}
		$pdf->SetFont('dejavusanscondensedb', '', $font_size_full_name);
		$pdf->Text($margin_left, $margin_top, strtoupper($ticket->full_name));
		$pdf->SetFont('dejavusanscondensed', '', $font_size-3);
		$pdf->Text($margin_left, $margin_top+=$line_height+$top_country, $country->name);
		$pdf->Text($margin_left, $margin_top+=$line_height-1, $id_card_number);
		$pdf->SetFont('dejavusanscondensed', '', $font_size-5);
		$pdf->Text($margin_left, $margin_top+=$line_height-0, $valid);

	}
	
}
