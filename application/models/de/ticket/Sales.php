<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Mjoin,
	DataTables\Editor\Options,
	DataTables\Editor\Upload,
	DataTables\Editor\Validate,
	DataTables\Editor\ValidateOptions;
	
class Sales extends RA_Editor_Model {
	
	public $table = 'kjl_ticket_sales';
	
	
	private $_M4_last_ticket_start_date = null;
	private $_M4_last_operator = null;
	
	public function __construct() {
		
		parent::__construct();
		$this->create_table();
		$this->init_editor();
	}

	public function create_table() {

		if ( $this->production() ) return;
		
		$sql = 
			"CREATE TABLE IF NOT EXISTS `$this->table` (
                `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
				`uuid` varchar(255) DEFAULT NULL,
				-- `short_uuid` varchar(255) DEFAULT NULL,
				`app_user_id` int(11) UNSIGNED DEFAULT NULL,
				`event_id` int(11) UNSIGNED DEFAULT NULL,
                `full_name` varchar(200) DEFAULT NULL,
                `gender` varchar(20) DEFAULT NULL,
                `office_id` int(5) DEFAULT NULL,
                `operator_id` int(5) DEFAULT NULL,
                `id_card_type` varchar(20) DEFAULT NULL,
                `id_card_number` varchar(50) DEFAULT NULL,
                `country_id` int(5) DEFAULT NULL,
                `kjl_card_number` varchar(50) DEFAULT NULL,
                `payment_ref_number` varchar(100) DEFAULT NULL,
                `ticket_ref_number` varchar(100) DEFAULT NULL,
				`ticket_type` varchar(100) NOT NULL DEFAULT 'regular',
                `ticket_start_date` date NOT NULL,
				`ticket_expired_date` date DEFAULT NULL,
                `payment_method` varchar(20) DEFAULT NULL,
                `category` varchar(50) DEFAULT NULL,
                
                `phone` varchar(50) DEFAULT NULL,
                `email` varchar(100) DEFAULT NULL,
                
                `payment_amount` decimal(20,2) NOT NULL DEFAULT 0,
				
				`seq_by_year` int(11) NOT NULL DEFAULT 0,
				
				`change_log` longtext,
                
                `create_by` mediumint(8) UNSIGNED NOT NULL DEFAULT '1',
				`create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`update_by` mediumint(8) UNSIGNED DEFAULT NULL,
				`update_at` datetime DEFAULT NULL,
				
				`order_id` int(11) UNSIGNED DEFAULT NULL,
				`order_dtl_id` int(11) UNSIGNED DEFAULT NULL,
				
				-- UNIQUE (`full_name`, `kjl_card_number`, `ticket_start_date`),
				UNIQUE (`order_id`, `order_dtl_id`),
                
				INDEX (`uuid`),
				INDEX (`app_user_id`),
                INDEX (`full_name`),
				INDEX (`ticket_start_date`),
				PRIMARY KEY (`id`)
			)"
		;

		$this->db_datatables->sql($sql);
	}
	
	private function init_editor() {
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
                Field::inst( "$this->table.id" ),
				Field::inst( "$this->table.uuid" )
					->set(Field::SET_CREATE)
				,
				Field::inst( "$this->table.app_user_id" ),
				Field::inst( "$this->table.event_id" )
                    ->options( Options::inst()
                        ->table( 'kjl_product_events' )
                        ->value( 'id' )
                        ->label( 'name' )
                        ->order( 'trim(name)', 'asc' )
                        ->where( function($q) {
                            $q->where('name', '', '!=');
                        })
                    )
					->validator( Validate::dbValues() )
					//->validator( Validate::none(ValidateOptions::inst()->allowEmpty(true) ) )
					->setFormatter( Format::ifEmpty(null) )
				,
				Field::inst( "$this->table.full_name" )
                    ->validator('Validate::NotEmpty'),
                Field::inst( "$this->table.gender" )
                    ->validator('Validate::NotEmpty'),
                Field::inst( "$this->table.office_id" )
					->set(Field::SET_BOTH)
                    ->validator('Validate::NotEmpty')
                    ->options( Options::inst()
                        ->table( 'kjl_offices' )
                        ->value( 'id' )
                        ->label( 'name' )
                        ->order( 'name', 'asc' )
                        ->where( function($q) {
                            $q->where('name', '', '!=');
                        })
                    )
                ,
                Field::inst( "$this->table.operator_id" )
					->set(Field::SET_BOTH)
                    ->validator('Validate::NotEmpty')
                    ->options( Options::inst()
                        ->table( 'kjl_operators' )
                        ->value( 'id' )
                        ->label( 'name' )
                        ->order( 'trim(name)', 'asc' )
                        ->where( function($q) {
                            $q->where('name', '', '!=');
                        })
                    )
                ,
                Field::inst( "$this->table.id_card_type" )
                    ->validator('Validate::NotEmpty'),
                Field::inst( "$this->table.id_card_number" )
                    ->validator('Validate::NotEmpty'),
                Field::inst( "$this->table.country_id" )
                    ->validator('Validate::NotEmpty')
                    ->options( Options::inst()
                        ->table( 'sys_countries' )
                        ->value( 'id' )
                        ->label( 'name' )
                        ->order( 'trim(name)', 'asc' )
                        ->where( function($q) {
                            $q->where('name', '', '!=');
                        })
                    )
                ,
                Field::inst( "$this->table.kjl_card_number" )
                    ->validator('Validate::required')
                ,
                Field::inst( "$this->table.payment_ref_number" )
                    //->validator('Validate::required')
                ,
                Field::inst( "$this->table.ticket_ref_number" )
                    //->validator('Validate::required')
                ,
				Field::inst( "$this->table.ticket_type" )
				,
                Field::inst( "$this->table.ticket_start_date" )
                    ->set(Field::SET_BOTH)
                    ->validator('Validate::required')
                ,
				Field::inst( "$this->table.ticket_expired_date" )
					->set(Field::SET_BOTH)
					//->validator('Validate::NotEmpty')
				,
                Field::inst( "$this->table.payment_method" )
                    ->validator('Validate::required')
                ,
                Field::inst( "$this->table.category" )
                    //->validator('Validate::required')
                ,
                Field::inst( "$this->table.phone" )->validator( 'Validate::NotEmpty' ),
                Field::inst( "$this->table.email" )->validator( 'Validate::NotEmpty' ),
                Field::inst( "$this->table.payment_amount" )->set(Field::SET_BOTH),
				Field::inst( "$this->table.seq_by_year" )
					->set(Field::SET_CREATE)
				,
				Field::inst( "$this->table.change_log"),
                
                Field::inst( "$this->table.create_by"                 )->set(Field::SET_CREATE),
				Field::inst( "$this->table.create_at"                 )->set(Field::SET_CREATE),
				Field::inst( "$this->table.update_by"                 )->set(Field::SET_EDIT),
				Field::inst( "$this->table.update_at"                 )->set(Field::SET_EDIT),
				
				Field::inst( "$this->table.order_id"),
				Field::inst( "$this->table.order_dtl_id"),
                
				Field::inst( "kjl_operators.name" ),
				Field::inst( "kjl_offices.name" ),
                Field::inst( "sys_countries.name"),
                Field::inst( "sys_users.first_name" )

			)
            ->leftJoin( 'kjl_operators', 'kjl_operators.id', '=', "$this->table.operator_id" )
			->leftJoin( 'kjl_offices', 'kjl_offices.id', '=', "$this->table.office_id" )
            ->leftJoin( 'sys_countries', 'sys_countries.id', '=', "$this->table.country_id" )
            ->leftJoin( 'sys_users', 'sys_users.id', '=', "$this->table.create_by" )
            
            ->on( 'preCreate', function ( $editor, $values ) {
                $this->default_create_log();
				
				$ticket_start_date = null;
                
				if ( isset($values[$this->table]['ticket_start_date'] ) ) {
					if ( '' === $values[$this->table]['ticket_start_date'] ) {
						// empty value submited
						$ticket_start_date = $this->ci->db_value_now();
						$this->editor
							->field("$this->table.ticket_start_date")
							->setValue( $ticket_start_date );
							
						$this->editor
							->field("$this->table.ticket_expired_date")
							->setValue( $this->ci->db_value_now('+1 year') );
					} else {
						$ticket_start_date = $values[$this->table]['ticket_start_date'];
						if ( isset($values[$this->table]['ticket_expired_date'] ) ) {
							// user set start date without set expired date
							
							if ( '' === $values[$this->table]['ticket_expired_date'] ) {
								$expired_date = (new DateTime($values[$this->table]['ticket_start_date']))->modify('+1 year')->format('Y-m-d');
								$this->editor
									->field("$this->table.ticket_expired_date")
									->setValue( $expired_date );
							}
						}
					}
				}
				
				$ticket_start_date = new DateTime($ticket_start_date);
				$Y = $ticket_start_date->format('Y');
				

				$event = null;
				$seq_name = null;

				if ( isset($values[$this->table]['event_id']) ) {
					$event_id = $values[$this->table]['event_id'];
					if ( $event_id ) {
						$event = $this->event($event_id);
						if ( $event ) {
							$seq_name = $event->seq_name;
							//$this->event($values[$this->table]['event_id'])->seq_name
						}
					}
				}
				
				$this->editor
					->field("$this->table.uuid")
					->setValue( guidv4() );

				$this->editor
					->field("$this->table.seq_by_year")
					->setValue( Model\System\Sequence::nextval($this->table.$seq_name."_$Y"));
				
				$this->editor
					->field("$this->table.office_id")
					->setValue( $this->ValidateOffice( $values[$this->table]['office_id'] ) );
					
				$this->editor
					->field("$this->table.operator_id")
					->setValue( $this->ValidateOperator( $values[$this->table]['operator_id'] ) );
					
				$payment_amount = 0;
				if ( $event ) {
					$payment_amount = $event->price;
				} else {
					if ( isset($values[$this->table]['country_id'] ) ) {
						$country_id = $values[$this->table]['country_id'];
						$country = Model\System\Countries::find($country_id);
						if ( $country ) {
							switch ( $country->code ) {
								case 'ID':
									$payment_amount = 500000;
									break;
								default:
									$payment_amount = 1000000;
									break;
							}
						}
					}
				}
				$this->editor
					->field("$this->table.payment_amount")
					->setValue($payment_amount);
					
			} )
            
            ->on( 'preEdit', function ( $editor, $id, $values ) {
				$this->create_log($id);
                $this->default_edit_log();
				
				$this->editor
					->field("$this->table.operator_id")
					->setValue( $this->ValidateOperator( $values[$this->table]['operator_id'] ) );

                $event = null;
                $seq_name = null;

                if ( isset($values[$this->table]['event_id']) ) {
                    $event_id = $values[$this->table]['event_id'];
                    if ( $event_id ) {
                        $event = $this->event($event_id);
                        if ( $event ) {
                            $seq_name = $event->seq_name;
                            //$this->event($values[$this->table]['event_id'])->seq_name
                        }
                    }
                }

                $payment_amount = 0;
                if ( $event ) {
                    $payment_amount = $event->price;
                } else {
                    if ( isset($values[$this->table]['country_id'] ) ) {
                        $country_id = $values[$this->table]['country_id'];
                        $country = Model\System\Countries::find($country_id);
                        if ( $country ) {
                            switch ( $country->code ) {
                                case 'ID':
                                    $payment_amount = 500000;
                                    break;
                                default:
                                    $payment_amount = 1000000;
                                    break;
                            }
                        }
                    }
                }

                if ( $payment_amount ) {
                    $this->editor
                        ->field("$this->table.payment_amount")
                        ->setValue($payment_amount);
                }

            } )
			
			->on( 'postEdit', function( $editor, $id, $values, $row ) {
				//$this->send_notification( $id, $row );
			})
			
			->on( 'postCreate', function( $editor, $id, $values, $row ) {
				// todo: update payment_amount based on Country Code ID = 500000, others = 1000000
				$this->send_notification( $id, $row );
			} )
		;
	}
	
	public function get($order_id = null, $order_dtl_id = null) {
		if ( $order_id )
			$this->editor->where("$this->table.order_id", $order_id, '=');
		if ( $order_dtl_id )
			$this->editor->where("$this->table.order_dtl_id", $order_dtl_id, '=');
		parent::get();
	}
	
	private function create_log($id) {
		$rec = Model\Ticket\Sales::find($id);
		$rec->create_log();
		$rec->save();
	}
	
	private function ValidateOffice( $val ) {
		$office_id = $val;
		if ( ! is_numeric($val) ) {
			$office = Model\Ticket\Offices::find_by_name($val);
			if ( ! $office ) {
				$office = Model\Ticket\Offices::make(array('name' => $val));
				$office->save();
				$office_id = Model\Ticket\Offices::last_created()->id;
			} else {
				$office_id = $office[0]->id;
			}
		}
		return $office_id;
	}
	
	private function ValidateOperator( $val ) {
		$operator_id = $val;
		if ( ! is_numeric($val) ) {
			$operator = Model\Ticket\Operators::find_by_name($val);
			if ( ! $operator ) {
				$operator = Model\Ticket\Operators::make(array('name' => $val));
				$operator->save();
				$operator_id = Model\Ticket\Operators::last_created()->id;
			} else {
				$operator_id = $operator[0]->id;
			}
		}
		return $operator_id;
	}
	
	public function event($event_id) {
		return Model\Ticket\Product_events::find($event_id);
	}
	
    public function import_R4_2017() {
        error_reporting(E_ALL);
        $keys = array(
            "No",
            "Tanggal",
            "Bulan",
            "Tahun",
            "TourismOperatorIndividual",
            "NamaLengkap",
            "JenisKelamin",
            "JenisIdentitas",
            "NoIdentitas",
            "Negara",
            "NoKartu",
            "NoPembayaran",
            "NoVoucherPenjualan",
            "TunaiTransferEDCDeposit",
            "KategoriWisatawan",
            "Penjualan",
            "AwalTahun",
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
            "Nov",
            "Dec",
            "KantorPenjualan",
            "InisialKantorPenjualan",
            "KategoriOperator",
        );
        
        $visitors = array_map('str_getcsv', file('../data/R4-2017/visitors.csv'));
        
        for ($i = 0; $i < count($visitors); $i++) {
            $v = $visitors[$i];
            $this->ci->show_progress_status($i+1, count($visitors), sprintf('Importing: %-35s', $v[5]));
            $visitor = (object) array_combine($keys, $v);
            $this->_create_visitor_R4_2017($visitor);
        }

    }
	
	public function import_MTW_2017() {
		error_reporting(E_ALL);
		$keys = array(
			"No",
			"Nama",
			"Kewarganegaraan",
			"NoPaspor",
			"NoTiket",
			"AkomodasiKapal",
			"Retribusi",
			"Tanggal",
			"JUNK",
		);
		
		$visitors = array_map('str_getcsv', file('../data/Mentawai-2017/visitors.csv'));
		//var_dump($visitors); return;
		for ($i = 0; $i < count($visitors); $i++) {
			$v = $visitors[$i];
			$this->ci->show_progress_status($i+1, count($visitors), sprintf('Importing: %-35s', $v[1]));
			$visitor = (object) array_combine($keys, $v);
			$this->_create_visitor_MTW_2017($visitor);
		}
	}
    
    private function _create_visitor_R4_2017($o) {
        error_reporting(E_ALL);
        $office = Model\Ticket\Offices::find_by_name($o->KantorPenjualan);
        $office_id = 0;
        if( ! $office ) {
            $office = Model\Ticket\Offices::make(array('name' => ucfirst(strtolower($o->KantorPenjualan))));
            $office->save();
            $office_id = Model\Ticket\Offices::last_created()->id;
        } else {
            $office_id = $office[0]->id;
        }
        
        $operator = Model\Ticket\Operators::find_by_name($o->TourismOperatorIndividual);
        $operator_id = 0;
        if ( ! $operator ) {
            $operator = Model\Ticket\Operators::add($o->TourismOperatorIndividual, $o->KategoriOperator);
            $operator_id = Model\Ticket\Operators::last_created()->id;
        } else {
            $operator_id = $operator[0]->id;
        }
        
        $country = Model\System\Countries::find_by_name($o->Negara);
        $country_id = null;
        if ( ! $country ) {
            $country = Model\System\Countries::make(array('name' => $o->Negara));
            $country->save();
            $country_id = Model\System\Countries::last_created()->id;
        } else {
            $country_id = $country[0]->id;
        }
        
        if ( ! $country_id || ! $office_id ) {
            var_dump($o); die;
        }
        
        //$full_name = explode(' ', ucwords($o->NamaLengkap));
        
        $create_at = new DateTime($o->Tahun.'-'.$o->Bulan.'-'.$o->Tanggal);
		
        $data = array(
            'full_name'            => strtolower(trim($o->NamaLengkap)) == 'no data' ? null : ucwords(strtolower($o->NamaLengkap)),
			'uuid'                 => guidv4(),
            'gender'               => $o->JenisKelamin,
            'office_id'            => $office_id,
            'operator_id'          => $operator_id,
            'id_card_type'         => $o->JenisIdentitas,
            'id_card_number'       => $o->NoIdentitas,
            'country_id'           => $country_id,
            'kjl_card_number'      => strtolower(trim($o->NoKartu)) == 'no data' ? null : $o->NoKartu,
            'payment_ref_number'   => $o->NoPembayaran,
            'ticket_ref_number'    => $o->NoVoucherPenjualan,
            'ticket_start_date'    => $create_at->format('Y-m-d'),
			'ticket_expired_date'  => $create_at->modify('+1 year')->format('Y-m-d'),
            'payment_method'       => $o->TunaiTransferEDCDeposit,
            'category'             => $o->KategoriWisatawan,
            'payment_amount'       => (double) preg_replace("/([^0-9\\.])/i", "", $o->Penjualan),
			'seq_by_year'          => Model\System\Sequence::nextval($this->table.'_'.$o->Tahun),
            
        );
        
        //var_dump($data);
        
        $visitor = Model\Ticket\Sales::make($data);
        $visitor->save();
        //var_dump($visitor);
    }
/*
 0 No.
 1 Tanggal
 2 Bulan
 3 Tahun
 4 Tourism Operator/Individual
 5 Nama Lengkap
 6 Jenis Kelamin
 7 Jenis Identitas
 8 No. Identitas
 9 Negara
10 No. Kartu
11 No. Pembayaran
12 No. Voucher Penjualan
13 Tunai/Transfer/EDC/Deposit
14 Kategori Wisatawan
15 Penjualan
16 Awal Tahun
17 Jan
18 Feb
19 Mar
20 Apr
21 May
22 Jun
23 Jul
24 Aug
25 Sep
26 Oct
27 Nov
28 Dec
29 Kantor Penjualan
30 Inisial Kantor Penjualan
31 Kategori Operator
*/

	private function _create_visitor_MTW_2017($o) {
		
		$office = Model\Ticket\Offices::find_by_name('Mentawai');
		$office_id = 0;
		if ( ! $office ) {
			$office = Model\Ticket\Offices::make(array('name' => 'Mentawai'));
			$office->save();
			$office_id = Model\Ticket\Offices::last_created()->id;
		} else {
			$office_id = $office[0]->id;
		}
		
		if ( $o->AkomodasiKapal ) {
			$this->_M4_last_operator = $o->AkomodasiKapal;
		}
		
		$last_operator = $this->_M4_last_operator;
		
		$operator = Model\Ticket\Operators::find_by_name($last_operator);
        $operator_id = 0;
        if ( ! $operator ) {
            $operator = Model\Ticket\Operators::add($o->AkomodasiKapal, 'Akomodasi/Kapal');
            $operator_id = Model\Ticket\Operators::last_created()->id;
        } else {
            $operator_id = $operator[0]->id;
        }
		
		$country = Model\System\Countries::find_by_name($o->Kewarganegaraan);
		$country_id = null;
		if ( ! $country ) {
			$country = Model\System\Countries::make(array('name' => $o->Kewarganegaraan));
			$country->save();
			$country_id = Model\System\Countries::last_created()->id;
		} else {
			$country_id = $country[0]->id;
		}
		$months = array(
			'Januari'     => 1,
			'Februari'    => 2,
			'02'          => 2,
			'Maret'       => 3,
			'April'       => 4,
			'Apr'         => 4,
			'Mei'         => 5,
			'Mai'         => 5,
			'May'         => 5,
			'Juni'        => 6,
			'Juli'        => 7,
			'Agustus'     => 8,
			'September'   => 9,
			'Sep'         => 9,
			'Oktober'     => 10,
			'Nopember'    => 11,
			'Desember'    => 12,
			
		);
		
		$tanggal = null;
		$create_at = null;
		if ( ! $create_at && $o->Tanggal != '' && $o->Tanggal != ',' ) {
			$tanggal = explode(' ', trim($o->Tanggal));
			$tanggal = count($tanggal) > 1 ? $tanggal : explode('-', trim($o->Tanggal));
			//echo $months[ucwords(strtolower($tanggal[1]))].PHP_EOL; return;
			
			$str_date = $tanggal[0].'-'.$months[ucwords(strtolower($tanggal[1]))].'-'.(strlen($tanggal[2]) >= 4 ? $tanggal[2] : '20'.$tanggal[2]);
			//echo $str_date.PHP_EOL; return;
			
			$create_at = DateTime::createFromFormat('d-m-Y', $str_date);
			$this->_M4_last_ticket_start_date = $str_date;
		} else {
			$create_at =  DateTime::createFromFormat('d-m-Y', $this->_M4_last_ticket_start_date);
		}

		if ( ! $create_at ) {
			echo $o->Tanggal.PHP_EOL;
			var_dump($create_at);
			return;
		}
		
		
		$ticket_start_date   = $create_at->format('Y-m-d');
		$ticket_expired_date = $create_at->modify('+1 year')->format('Y-m-d');
		
		$event = Model\Ticket\Product_events::first();
		
		$seq_by_year = Model\System\Sequence::nextval($this->table."_".$create_at->format('Y'));
		
		$data = array(
			'event_id'             => isset($event->id) ? $event->id : null,
			'uuid'                 => guidv4(),
			'full_name'            => ucwords(strtolower($o->Nama)),
			'country_id'           => $country_id,
			'id_card_type'         => 'Passport',
			'id_card_number'       => $o->NoPaspor,
			'kjl_card_number'      => $o->NoTiket,
			'office_id'            => $office_id,
			'operator_id'          => $operator_id,
			'ticket_start_date'    => $ticket_start_date,
			'ticket_expired_date'  => $ticket_expired_date,
			'seq_by_year'          => $seq_by_year,
			'payment_amount'       => (double) preg_replace("/([^0-9\\.])/i", "", $o->Retribusi),
		);
		
		$visitor = Model\Ticket\Sales::make($data);
		$visitor->save();
	}
/*
0 No
1 Nama
2 Kewarganegaraan
3 NoPaspor
4 NoTiket
5 AkomodasiKapal
6 Retribusi
7 Tanggal
8 JUNK
*/
	private function send_notification( $id, $row ) {
		
		if ( strpos(base_url(), '//event') === 0 ) {
			//return;
		}
		
		//if ( 'development' == ENVIRONMENT ) return;
		
		$ticket = $row[$this->table];
		
		//var_dump($ticket); die;
		
		if ( ! $ticket ) return;
		
		$notify_email = $this->config->item('notification_email');
		
		$to = $ticket['email'] ? $ticket['email'] : $notify_email;
		$this->email->from('no-reply', 'No Reply');
		if ( 'production' === ENVIRONMENT ) {
			$this->email->to($to);
			$bcc = array($notify_email, 'yusar@media-vista.com');
			$me = Model\Setting\Users::find($this->user_id);
			if( $me && $me->email ) {
				$bcc[] = $me->email;
			}
			$this->email->bcc($bcc);
		} else {
			$this->email->to('yusar@media-vista.com');
		}
		
		$this->email->subject("[".PROJECT_NAME."] - #$id ".$ticket['kjl_card_number'].' '.$ticket['full_name']);
		$data['ticket'] = $ticket;
		$mail_body = $this->load->view('email/ticket/notification', $data, true);
		$this->email->message($mail_body);
		
		if ( ! $this->email->send(false) ) {
			
		}
	}

}
