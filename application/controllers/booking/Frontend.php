<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Frontend extends RA_Controller {
	
	protected $_event = null;
	protected $_order = null;
	protected $_payment = null;
	
	public function getEvent() {
		return $this->_event;
	}
	
	public function getOrder() {
		if ( is_object($this->_order) ) {
			return $this->_order;
		} else if (  is_array( $this->_order ) ) {
			// return the last order
			return end($this->_order);
		}
	}
	
	public function getUser() {
		return $this->user->get_logged_in_user_info();
	}

	public function __construct() {
		parent::__construct();

		$event_code = $this->uri->segment($this->uri->total_segments());
		#$event = Model\Ticket\Product_events::find_by_code($event_code);
		$event = Model\Ticket\Product_events::where(array(
			'code' => $event_code,
			'status' => 'open',
			'event_type' => 'ticket',
			'start_date <= ' => $this->db_value_now(),
			'end_date > ' => $this->db_value_now(),
		))->get();
		
		if ( ! $event ) {
			//show_error('Sorry');
			// get 1 active event
			$event = Model\Ticket\Product_events::where(array(
				'status' => 'open',
				'event_type' => 'ticket',
				'start_date <= ' => $this->db_value_now(),
				'end_date > ' => $this->db_value_now()
			))
			->order_by('start_date desc')
			#->first()
			->get()
			;

			$event = is_array($event) ? $event[0] : $event;
		}

		#die(var_dump($event));
		
		if ( ! $event ) {
			redirect('/welcome');
			return;
		}

		if ( $event->code != $event_code ) {
			$this->_redirect("/booking/$event->code");
		}
		
		$this->_event = $event;

		$this->load->config('midtrans');
		$this->load->model('../../citiesdirectory/application/models/base_model');
		$this->load->model('../../citiesdirectory/application/models/appuser');
		$this->load->model('../../citiesdirectory/application/models/user');
		
		$this->data['event']      = $this->_event;
		$this->data['PAGE_TITLE'] = $this->_event->name;
		$this->data['EVENT_NAME'] = $this->_event->name;
		$this->data['user']       = $this->user->get_logged_in_user_info();
		
		$this->setOrder();
		
		#var_dump($this->_order); die;
	
		
		
		$this->enqueue_style(array(
			'../../css/jquery-confirm.css',
		));
		
		$this->enqueue_scripts(array(
			//'https://code.jquery.com/jquery-3.3.1.min.js',
			'../../js/jquery-confirm.js',
			'../../js/jquery.preloaders.min.js'
		));

	}
	
	public function setOrder() {
		if ( $this->data['user'] ) {
			$this->_order = Model\Ticket\Ticket_orders
				::where(array(
					'event_id' => $this->_event->id,
					'app_user_id' => $this->data['user']->user_id,
					'order_status = ' => 'new',
				))
				->order_by('create_at desc')
				//->group_start()
					//->where_not_in('payment_status', array(200, 201, 202, 407))
					//->or_where('payment_status is null')
				//->group_end()
				->get()
			;
			
			#die(var_dump($this->_order));
			
			if ( $this->_order ) {
				
				require_once(dirname(__FILE__) . '/class/Payment.php');

				if ( $this->_order && is_object($this->_order) ) {
					$this->_order->calculate();
					$this->_order->save();
					$this->_order = Payment::update($this->_order);
				} else {

					if ( is_array( $this->_order ) ) {
						foreach( $this->_order as $order ) {
							$order->calculate();
							$order->save();
							Payment::update($order);
							//Ticket::create($order);
						}

						// TODO: Handle more than 1 order
						#$this->_redirect('/booking');
						#show_error('Too many opened orders, please contact administrator.');
					}

					//$this->_order = null;
					
				}
			}
		}
		
		$this->data['order'] = $this->_order;
	}

	public function restricted($resource = null, $blocking = true) {
		$this->_restricted();
	}
	
	private function _restricted() {
		if ( !$this->user->is_logged_in() ) {
			$this->_redirect('/booking');
		}
	}
	
	private function _redirect($uri) {
		redirect("$uri/".$this->_event->code);
	}
	
	private function _get_app_user_id() {
		return (isset($this->data['user']) && $this->data['user']) ? $this->data['user']->user_id : null;
	}
	
	public function getAppUserId() {
		return $this->_get_app_user_id();
	}
	
	private function _view($tpl) {
		//die(var_dump($this->_event->template_path));
		$this->load->view('templates/'.$this->_event->template_path."/$tpl", $this->data);
	}
	
	public function form($uuid = null) {
		$this->_view('index');
	}
	
	public function register() {
		
		$this->enqueue_resource('resource/script/templates/'.$this->getEvent()->template_path.'/js/order_list.php');
		
		#$this->_view('register_success');
		#return;
		
		$data = $this->input->post();
		
		$this->form_validation->set_rules('username', 'Full Name', 'required', array('required' => 'Full Name is required'));
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[cd_appusers.email]',
			array(
				'required' => 'Email is required',
				'is_unique' => 'Email already exists'
			)
		);
		$this->form_validation->set_rules('company_name', 'Company', 'required', array('required' => 'Company is required'));
		$this->form_validation->set_rules('phone', 'Phone', 'required', array('required' => 'Phone is required'));
		$this->form_validation->set_rules('password', 'Password', 'required', array('required' => 'Password is required'));
		$this->form_validation->set_rules('retype_password', 'Retype Password', 'required|matches[password]',
			array(
				'required' => 'Retype Password is required',
				'matches' => 'Password does not match'
			)
		);

		if ($this->form_validation->run() == FALSE) {
            $this->form();
			return;
        }
		
		$user_data = array(
			'username'      => $data['username'],
			'password'      => md5($data['password']),
			'email'         => $data['email'],
			'profile_photo' => "/assets/static/img/avatar.jpeg",
			'company_name'  => $data['company_name'],
			'phone'         => $data['phone'],
		);

		if ($this->appuser->exists($user_data)) {
			$this->form();
            return FALSE;
		} else {
			$this->appuser->save($user_data);
			$this->user->login($data['email'], $data['password']);
		}
		
		//var_dump($user_data);
		
		$this->_view('register_success');
	}
	
	/**
	 * Checks the user credential and redirect to respecitve urls
	 * 
	 */
	public function login() {

		if ( $this->user->is_logged_in() ) {
			$this->_redirect('/booking');
		} else {
			
			// if the user is not yet logged in, authenticate url or load the login form view
			if ( $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET' ) {

				// if request is post method, login and redirect
				$user_email = htmlentities($this->input->post('user_email'));
				$user_password = $this->input->post('user_pass');

				if ( ! filter_var( $user_email, FILTER_VALIDATE_EMAIL )) {
				// if the email input is invalid email address
				
					// find the related email with that username
					$emails = $this->user->get_info_by_username( $user_email )->result();

					if ( empty( $emails )) {
					// if there is no related email
						$this->session->set_flashdata('error','Username does not exist');
						$this->_redirect('/booking');
					}

					// create error mesage with such email list
					$error = "You can no longer log in with a username. Use your email address instead. <br/>";
					foreach ( $emails as $email ) {
						$error .= $email->user_email ."<br>";
					}

					$this->session->set_flashdata( 'error', $error );
					$this->_redirect('/booking');
				}

				if ( $this->user->login( $user_email, $user_password )) {

					// if credential is correct, redirect to respective url
					$this->_redirect('/booking');
					
				} else {

					// if credential is incorrect, show error message and redirect to login
					$this->session->set_flashdata('error','Username and password do not match.');
					$this->_redirect('/booking');
				}
			} else {

				// if request is GET method, load login form
				$this->form();
			}
		}
	}
	
	function logout()
	{
		$this->user->logout();
		$this->data['user'] = false;
		$this->form();
	}
	
	public function forgot_password()
	{
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');

		if ($this->form_validation->run() == false) {
			
			$this->session->set_flashdata('error', validation_errors());
			$this->_view('forgot_password');
			return;
		} else {
			$user = Model\Cd\Appusers::where(array('email' => $this->input->post('email')))->get();
			
			if ( ! $user ) {
				$this->session->set_flashdata('error', 'User not found.');
				$this->_view('forgot_password');
				return;
			}
			
			if ( $this->_forgotten_password($user) ) {
				$this->session->set_flashdata('success', 'Please check your email to reset your password.');
				$this->_view('forgot_password');
				return;
			} else {
				$this->session->set_flashdata('error', 'Sorry, can\'t do that right now, please try again later.');
				$this->_view('forgot_password');
				return;
			}
		}
	}
	
	private function _forgotten_password($user) {
		return $user->forgotten_password();
	}
	
	public function reset_password($code, $event_code) {
		$this->data['PAGE_TITLE'] = 'Reset Password';
		if (!$code) {
			show_404();
			return;
		}

		$user = Model\Cd\Appusers::where(array('forgotten_password_code' => $code))->get();
		
		$this->lang->load('auth');
		
		if ( $user && 1 == count($user) ) {
		
			$this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

			if ($this->form_validation->run() == false) {
				
				// display the form

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$this->data['new_password'] = array(
					'name' => 'new',
					'id'   => 'new',
					'type' => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
					'class' => 'form-control px-3',
					'placeholder' => 'New Password',
					'required' => 'true'
				);
				$this->data['new_password_confirm'] = array(
					'name'    => 'new_confirm',
					'id'      => 'new_confirm',
					'type'    => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
					'class' => 'form-control px-3',
					'placeholder' => 'Confirm New Password',
					'required' => 'true'
				);
				$this->data['user_id'] = array(
					'name'  => 'user_id',
					'id'    => 'user_id',
					'type'  => 'hidden',
					'value' => $user->id,
				);
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['code'] = $code;

				$this->_view('reset_password');

			} else {
				
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id')) {

					// something fishy might be up
					#$this->ion_auth->clear_forgotten_password_code($code);
					//$user->forgotten_password_code = null;
					//$user->forgotten_password_time = null;
					//$user->save();

					//echo ($this->lang->line('error_csrf'));
					$this->_redirect("/booking/reset-password/$code");
					//return;

				} else {
					// finally change the password
					#$identity = $user->{$this->config->item('identity', 'ion_auth')};

					#$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));
					$change = false;
					#(var_dump($this->session->flashdata()));
					$user->password = md5($this->input->post('new'));
					$user->forgotten_password_code = null;
					$user->forgotten_password_time = null;
					
					$change = $user->save();
					
					#var_dump($change); die;

					if ($change) {
						// if the password was successfully changed
						#$this->session->set_flashdata('message', $this->ion_auth->messages());
						$this->_redirect('/booking/reset-password-success');
					} else {
						#$this->session->set_flashdata('message', $this->ion_auth->errors());
						$this->_redirect('/booking/reset-password');
					}
				}
				
			}
		} else {
			$this->_redirect('/booking');
		}
		#$this->session->flashdata();
	}

	public function reset_password_success() {
		$this->_view('reset_password_success');
	}
		
	public function cart() {
		
		$this->_restricted();
		
		if ( ! $this->_order ) {
			#$this->_redirect('/booking');
			#return;
		}
		
		$this->enqueue_resource('resource/script/templates/'.$this->getEvent()->template_path.'/js/order_list.php');
		
		$this->_view('cart');
	}
	
	public function add() {
		$this->_restricted();
		require_once('class/'.$this->_event->template_path.'/Order.php');
		Order::add();
		$this->_redirect('/booking/cart');
	}
	
	public function edit($id) {
		$this->_restricted();
		require_once('class/'.$this->_event->template_path.'/Order.php');
		$this->data['order_dtl'] = Order::edit($id);
		if ( ! Order::edit($id) ) {
			$this->_view('edit_ticket');
			return;
		}
			
		$this->_redirect('/booking/cart');

	}
	
	public function remove($id) {
		
		$this->_restricted();
		
		$order_dtl = Model\Ticket\Ticket_orders_dtl::where(array(
			'app_user_id' => $this->_get_app_user_id(),
			'id' => $id,
			'order_id' => $this->_order->id,
		))
		->get()
		;
		
		if ( ! $order_dtl ) show_404();
		
		$order_dtl->delete();
		
		$this->_redirect('/booking/cart');
	}
	
	public function history() {
		//require_once('class/'.$this->_event->template_path.'/Order.php');
		//Order::finish();
		
		$orders_hist = Model\Ticket\Ticket_orders::where(array(
			'app_user_id' => $this->getUser()->user_id,
			'event_id'    => $this->getEvent()->id,
		))
		->order_by('create_at desc')
		->all()
		;
		
		//var_dump($orders_hist); die;
		
		if ( ! $orders_hist ) $this->_redirect('/booking');
		$this->data['orders_hist'] = $orders_hist;
	
		$this->_view('history');
	}
	
	public function order($uuid) {
		require_once('class/'.$this->_event->template_path.'/Order.php');
		Order::finish();
		$order = Model\Ticket\Ticket_orders::where(array(
			'uuid' => $uuid,
			#'order_status' => 'finish',
		))->get();
		
		if ( ! $order ) { show_404(); }

		$this->data['order'] = $order;
		
		$this->_view('order_detail');
		//echo $order->getOrderBody();
	}
	
	public function ticket($uuid) {
		$ticket = Model\Ticket\Sales::where(array('uuid' => $uuid))->get();
		
		if ( ! $ticket ) { show_404(); }
		$this->data['ticket'] = $ticket;
		$this->_view('ticket_detail');
		#echo $ticket->getTicketBody();
	}

	// public function checkout() {
		
		// $this->output->enable_profiler(false);
		
		// $this->_restricted();
		
		// if ( ! $this->_order ) return;
		
		// $transaction = file_get_contents('php://input');

		// // Change "app.sandbox.midtrans.com" to "app.midtrans.com" when you are deploying to production environment
		// $this->load->config('midtrans');
		// $midtransConfig = $this->config->item('midtrans');

		// $curl = curl_init();
		// curl_setopt_array($curl, array(
			// CURLOPT_URL => $midtransConfig['api_url'], //"https://app.sandbox.midtrans.com/snap/v1/transactions",
			// CURLOPT_RETURNTRANSFER => true,
			// CURLOPT_ENCODING => "",
			// CURLOPT_MAXREDIRS => 10,
			// CURLOPT_TIMEOUT => 30,
			// CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			// CURLOPT_CUSTOMREQUEST => "POST",
			// CURLOPT_POSTFIELDS => $transaction,
			// CURLOPT_HTTPHEADER => array(
				// "accept: application/json",
				// "Authorization: Basic VlQtc2VydmVyLVU3aWtTN3ItcUplejR6b1F3YV9ySk82Njo=", 
				// "cache-control: no-cache",
				// "content-type: application/json"
			// ),
		// ));

		// /*
		// expected response
		// r = {
			// "token":"0415afcd-cff9-4660-ada9-3e91d8409c03",
			// "redirect_url":"https://app.sandbox.midtrans.com/snap/v2/vtweb/0415afcd-cff9-4660-ada9-3e91d8409c03"
		// };
		// */

		// $response = curl_exec($curl);
		// $err = curl_error($curl);

		// curl_close($curl);

		// if ($err) {
			// //echo "cURL Error #:" . $err;
			// show_error($err);
		// } else {
			// echo $response;
		// }
	// }
	
	//****** Moved to midtrans/tx/transaction_details
	// public function transaction_details() {
		
		// $this->_restricted();
		
		// if ( ! $this->_order ) show_404();
		
		// if ( 'new' != $this->_order->order_status ) show_error('Invalid Request');
		
		// $taxes = $this->_event->taxes();
		// $openAmt = $this->_order->getOpenAmount();
		// $taxAmt = 0;
		// foreach ( $taxes as $tax ) {
			// $taxAmt += ($openAmt * $tax->tax);
		// }
		// $grossAmt = $openAmt + $taxAmt;
		
		// $data = array(
			// 'transaction_details' => array(
				// 'order_id' => (string) $this->_order->uuid,
				// 'gross_amount' => (float) $grossAmt, // $this->_order->getOpenAmount(),
			// ),
			// 'credit_card' => array(
				// 'secure' => true,
				// 'save_card' => true
			// ),
			// 'user_id' => 'customer-'.$this->getAppUserId(),
			// 'callbacks' => array(
				// 'finish'   => "/booking/order/finish/".$this->_order->uuid,
				// 'unfinish' => "/booking/order/unfinish/".$this->_order->uuid,
				// 'error'    => "/booking/order/error/".$this->_order->uuid,
			// ),
		// );

		// $this->json_response($data);
	// }
	
	// private function _log_input($func_name = '_log_input') {
		// $in = file_get_contents('php://input');
		// $log = json_decode($in);
		// log_message('info', $func_name.":\n".$log);
	// }

	public function qr($uuid) {
		
		$this->output->enable_profiler(false);
		$order = Model\Ticket\Ticket_orders::where(array('uuid' => $uuid))->get();

		if ( ! $order ) { show_404(); }
		
		$data_text = base_url("ticket/orders/verify/".$order->uuid); //, isset($_SERVER['HTTPS']) ? 'https:' : 'http:');
		//var_dump($data_text); die;
		require_once(APPPATH.'third_party/TCPDF/tcpdf_barcodes_2d.php');
		$tcpdf2dbarcode = new TCPDF2DBarcode($data_text, 'QRCODE,L');
		$sz = 3;
		$tcpdf2dbarcode->getBarcodePNG($sz, $sz);//, array(195,125,35));
	}
	
	public function invoice($uuid) {
		//$this->_restricted();
		require_once('class/PDF.php');
		require_once('class/'.$this->_event->template_path.'/Invoice.php');
		Invoice::print($uuid);
	}
	
	public function refund($uuid) {
		$order = Model\Ticket\Ticket_orders::where(array(
			'uuid' => $uuid,
			'order_status' => 'finish',
		))->get();
		
		if ( ! $order ) show_404();
		
		$this->form_validation->set_rules('reason_for_refund', 'Please tell us your reason for refund', 'required');
		
		if ( $this->form_validation->run() == false ) {
			$this->data['user_id'] = array(
				'name'  => 'user_id',
				'id'    => 'user_id',
				'type'  => 'hidden',
				'value' => $this->getUser()->user_id,
			);
			$this->data['order'] = $order;
			$this->data['csrf']  = $this->_get_csrf_nonce();
			$this->_view('refund');
			
		} else {
		
			if ($this->_valid_csrf_nonce() === FALSE || $this->getUser()->user_id != $this->input->post('user_id')) {
				#var_dump($this->session->flashdata());
				#die(var_dump($_POST));
				echo "Under development.";
			}
		}

	}
	
	public function terms_of_use() {
		$this->_view('terms-of-use');
	}
	
	public function refund_policy() {
		$this->_view('refund-policy');
	}
	
	public function privacy_policy() {
		$this->_view('privacy-policy');
	}
}