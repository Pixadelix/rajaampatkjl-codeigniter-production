<?php
defined('BASEPATH') OR exit('No direct script access allowed');


//Veritrans_Config::$isProduction = false;
//Veritrans_Config::$serverKey = 'VT-server-U7ikS7r-qJez4zoQwa_rJO66';

class Tx extends RA_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->output->enable_profiler(false);
		
		$this->load->config('midtrans');
		$configMidtrans = $this->config->item('midtrans');

		require_once(dirname(__FILE__) . '/Veritrans.php');
		Veritrans_Config::$isProduction = $configMidtrans['is_production'];
		Veritrans_Config::$serverKey    = $configMidtrans['server_key'];
		
	}
	
	public function transaction_details($order_id) {
		
		$order = Model\Ticket\Ticket_orders::where(array(
			'id' => $order_id,
			//'order_status' => 'new'
		))
		->get()
		;
		
		//show_error('TODO: check for payment');
		
		//die(var_dump($order->uuid));
		
		if ( ! $order ) show_404();

		$taxes = $order->event()->taxes();
		$openAmt = $order->getOpenAmount();
		$taxAmt = 0;
		foreach ( $taxes as $tax ) {
			$taxAmt += ($openAmt * $tax->tax);
		}
		$grossAmt = $openAmt + $taxAmt;
		
		$data = array(
			'transaction_details' => array(
				'order_id' => (string) $order->uuid,
				'gross_amount' => (float) $grossAmt, // $this->_order->getOpenAmount(),
			),
			'credit_card' => array(
				'secure' => true,
				'save_card' => true
			),
			'user_id' => 'customer-'.$order->app_user_id,
			'callbacks' => array(
				'finish'   => "/booking/order/finish/".$order->uuid,
				'unfinish' => "/booking/order/unfinish/".$order->uuid,
				'error'    => "/booking/order/error/".$order->uuid,
			),
		);

		//die(var_dump(Veritrans_Config::getSnapBaseUrl()));
		//$token = Veritrans_Snap::getSnapToken($data);
		//die(var_dump($token));
		
		$this->json_response($data);
	}
	
	public function checkout() {
		$data = file_get_contents('php://input');
		$transaction = json_decode($data, true);
		//die(var_dump($transaction));
		try {
			$token = Veritrans_Snap::getSnapToken($transaction);
			//die(var_dump($token));
			$this->json_response(array('token' => $token));
		}
		catch (Exception $e) {
			$this->json_response(array('error' => $e->getMessage()));
		}
	}
	
	/*
	public function checkout_deprecated() {
		
		$data = file_get_contents('php://input');

		// Change "app.sandbox.midtrans.com" to "app.midtrans.com" when you are deploying to production environment 

		$transaction = json_decode($data, true);
		//die(var_dump($transaction));
		$token = Veritrans_Snap::getSnapToken($transaction);
		//die(var_dump($token));
		$this->json_response(array('token' => $token)); return;

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $midtransConfig['api_url'], //"https://app.sandbox.midtrans.com/snap/v1/transactions",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $transaction,
			CURLOPT_HTTPHEADER => array(
				"accept: application/json",
				"Authorization: Basic VlQtc2VydmVyLVU3aWtTN3ItcUplejR6b1F3YV9ySk82Njo=",
				"cache-control: no-cache",
				"content-type: application/json"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);

		if ($err) {
			//echo "cURL Error #:" . $err;
			show_error($err);
		} else {
			echo $response;
		}
	}
	*/

	
/* Current endpoint:
http://event.mediavista.id/booking/midtrans/tx/notification

Content-Type:
application/json

Notification data:
{
  "transaction_time": "2018-05-28 11:03:57",
  "transaction_status": "capture",
  "transaction_id": "a582c136-2dcf-471c-bfe2-c623a98304a4",
  "status_message": "midtrans payment notification",
  "status_code": "200",
  "signature_key": "6f530517bcf280f553ea929af97b30c2670383c0249864ca3dca58fabe051ecfc79203a7f32ad406925f1b1a8962aa5604a80eaf95d0a88f8fffb0f3379bc25a",
  "payment_type": "credit_card",
  "order_id": "836edb17-3cf2-449d-b095-ca2d0d91ec92",
  "masked_card": "481111-1114",
  "gross_amount": "1200.00",
  "fraud_status": "accept",
  "channel_response_message": "Approved",
  "channel_response_code": "00",
  "bank": "mandiri",
  "approval_code": "1527480238061"
}


{
  "transaction_time": "2018-05-28 14:52:30",
  "transaction_status": "pending",
  "transaction_id": "6ec98fd8-f6e5-4870-bbb5-a4ebab3bfd96",
  "status_message": "midtrans payment notification",
  "status_code": "201",
  "signature_key": "a3c20a6f9266d367e8d3e5c902d4e6da278e5417e31af8942849a7299bf21a4ef45061efef570015eaa043579fa7b23507db7681f3e06ffe297b0128b21cdfe7",
  "payment_type": "bca_klikbca",
  "order_id": "a91d4e8c-be70-439e-8415-373fa28a00e2",
  "gross_amount": "1000.00",
  "approval_code": "6ec98fd8f6e54870bb"
}

 */
	public function notification() {
		
		$this->_log_input('notification');
		
		$uuid = null;

		if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
			try {
				$notif = new Veritrans_Notification();
				//var_dump($notif);
			}
			catch (Exception $e) {
				echo "Exception: ".$e->getMessage()."\r\n";
				echo "Notification received: ".file_get_contents("php://input");
				exit();
			} 
			$transaction = $notif->transaction_status;
			$type = $notif->payment_type;
			$order_id = $notif->order_id;
			$uuid = $order_id;
			$fraud = $notif->fraud_status;
			if ($transaction == 'capture') {
				// For credit card transaction, we need to check whether transaction is challenge by FDS or not
				if ($type == 'credit_card'){
					if($fraud == 'challenge'){
						// TODO set payment status in merchant's database to 'Challenge by FDS'
						// TODO merchant should decide whether this transaction is authorized or not in MAP
						echo "Transaction order_id: " . $order_id ." is challenged by FDS";
					} else {
						// TODO set payment status in merchant's database to 'Success'
						echo "Transaction order_id: " . $order_id ." successfully captured using " . $type;
					}
				}
			} else if ($transaction == 'settlement') {
				// TODO set payment status in merchant's database to 'Settlement'
				echo "Transaction order_id: " . $order_id ." successfully transfered using " . $type;
			} else if($transaction == 'pending') {
				// TODO set payment status in merchant's database to 'Pending'
				echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
			} else if ($transaction == 'deny') {
				// TODO set payment status in merchant's database to 'Denied'
				echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
			} else if ($transaction == 'expire') {
				// TODO set payment status in merchant's database to 'expire'
				echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is expired.";
			} else if ($transaction == 'cancel') {
				// TODO set payment status in merchant's database to 'Denied'
				echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is canceled.";
			}
		} else {
			
			// order_id=776981683&status_code=200&transaction_status=capture

			$order_id = $_GET['order_id'];
			$uuid = $order_id;
			$statusCode = $_GET['status_code'];
			$transaction  = $_GET['transaction_status'];


			if($transaction == 'capture') {
			  echo "<p>Transaksi berhasil.</p>";
			  echo "<p>Status transaksi untuk order id : " . $order_id;

			}
			// Deny
			else if($transaction == 'deny') {
			  echo "<p>Transaksi ditolak.</p>";
			  echo "<p>Status transaksi untuk order id .: " . $order_id;

			}
			// Challenge
			else if($transaction == 'challenge') {
			  echo "<p>Transaksi challenge.</p>";
			  echo "<p>Status transaksi untuk order id : " . $order_id;

			}
			// Error
			else {
			  echo "<p>Terjadi kesalahan pada data transaksi yang dikirim.</p>";
			  echo "<p>Status message: [$response->status_code] " . $transaction;
			}

		}
		//echo "\n";
		//var_dump($uuid);
		$order = Model\Ticket\Ticket_orders::where(array(
			'uuid' => $uuid
		))
		->get();
		
		if ( $order ) {
			//var_dump(count($order));
			//$order = $order->first();
			//var_dump($order->id);
			//var_dump($order->uuid);
			require_once(dirname(__FILE__) . '/../class/Payment.php');
			Payment::update($order);
		}
	}
	
	public function finish() {
		// Dear customer. Thank you for completing the payment process
		$this->_log_input('finish');
		$this->load->view('templates/booking-default/finish', $this->data);
	}
	
	public function unfinish() {
		// Dear customer. You haven't completed the payment process
		$this->_log_input('unfinish');
		$this->load->view('templates/booking-default/unfinish', $this->data);
	}
	
	public function error() {
		// Dear customer. Sorry we couldn't process your payment
		$this->_log_input('error');
		$this->load->view('templates/booking-default/error', $this->data);
	}
	
	private function _logTX() {
	}

}