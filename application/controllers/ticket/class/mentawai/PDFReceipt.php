<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PDFReceipt extends PDF { 

	public function create_ticket_card_pdf($id) {
		$ticket = Model\Ticket\Sales::find($id);
		
		if ( ! $ticket ) show_404();
		
		$pdf = $this->pdf;

		// add a page
		$pdf->AddPage('P', 'RECEIPT_MENTAWAI');
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
				$img_file = '/assets/static/img/mentawai005.jpg';
				break;
			default:
				$origin = $country->name;
				$paid_amt = CONTRIBUTION_I; //'Rp 1.000.000,- (One Million Rupiah)';
				$img_file = '/assets/static/img/mentawai005.jpg';
				break;
		}
		
		//$pdf->SetAlpha(0.2);
		//$pdf->Image($img_file, 0, 0); //, 210, 297, '', '', '', false, 300, '', false, false, 0);
		//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		//$pdf->Image($img_file, 0, 0, 527.04, 964.08, '', '', '', false, 300, '', false, false, 0);
		//$pdf->SetAlpha(1);
		
		$start_date = new DateTime($ticket->ticket_start_date);
		$expired_date = new DateTime($ticket->ticket_expired_date);
		
		$serial_number = 'M. '.$start_date->format('dmY').sprintf(' %06d', $ticket->seq_by_year);
		
		$qrcode_data_text = "
Ticket No: $serial_number
Name: $ticket->full_name. 
Country: $country->name. 
".$ticket->id_card_type." No: ".$ticket->id_card_number.". 
Valid: ".$start_date->format('d M Y')." - ".$expired_date->format('d M Y').".";
		
		$margin_top  = 40;
		$margin_left = 56;
		$line_height = 10;
		$font_size   = 10;
		
		for ( $i = 0; $i < 4; $i++ ) {
			
			$pdf->SetFont('freesansb', '', $font_size-4.);
			
			$pdf->Text($margin_left+69.9, $margin_top+20.4, $serial_number);
		
			// QRCODE,H : QR-CODE Best error correction
			
			$pdf->write2DBarcode($qrcode_data_text, 'QRCODE,L',
				$margin_left+71, // x
				$margin_top +0, // y
				20,
				20,
				$style,
				'T',
				true
			);
			
			
			//$pdf->SetFont('pdfatimesb', '', $font_size);
			//$pdf->SetFont('freesansb', '', $font_size	);
			$pdf->SetFont('dejavusanscondensedb', '', strlen($ticket->full_name) < 20 ? $font_size : $font_size - 4);
			$pdf->SetFont('dejavusanscondensedb', '', $font_size);
			//$pdf->SetFont('cid0jp', '', $font_size);
			
			//$margin_top+=(strlen($ticket->full_name) < 20 ? $line_height : $line_height + 2);
			//$pdf->Text($margin_left, $margin_top, substr(strtoupper($ticket->full_name), 0, 30));
			
			if ( strlen($ticket->full_name) >= 20 ) {
				$full_name = explode(' ', strtoupper($ticket->full_name));
				
				$buffer = '';
				$line = 0;
				for( $j = 0; $j < count($full_name); $j++ ) {
					$name = $full_name[$j];
					$buffer.=$name.' ';
					if ( strlen($buffer) >= 20 ) {
						$pdf->Text($margin_left, $margin_top+($line++*2), $buffer);
						$buffer = '';
					}
				}
				$pdf->Text($margin_left, $margin_top+(++$line*2), $buffer);
				//$pdf->Text($margin_left, $margin_top, implode(' ', array_slice($full_name, 0, 2)));
				//$pdf->Text($margin_left, $margin_top+4, implode(' ', array_slice($full_name, 3, 7)));
			} else {
				$pdf->Text($margin_left, $margin_top+2, strtoupper($ticket->full_name));
			}
			
			$pdf->SetFont('dejavusanscondensed', '', $font_size	);
			//$pdf->SetFont('cid0jp', '', $font_size);
			$pdf->Text($margin_left, $margin_top+=$line_height+1, $origin);
			$pdf->Text($margin_left, $margin_top+=$line_height-1, $ticket->id_card_number);
			//$pdf->SetFont('pdfacourierb', '', $font_size	);
			//$pdf->SetFont('cid0jp', '', $font_size);
			//$pdf->Text($margin_left, $margin_top+=$line_height, $ticket->kjl_card_number);
			//$pdf->SetFont('dejavusanscondensed', '', $font_size	);
			//$pdf->Text($margin_left, $margin_top+=$line_height, $paid_amt);
			
			$margin_top += 65.2;
			$line_height -= 0.1;
		}
		
	}
}
