<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Payment {
	public static function update($order) {
		
		#var_dump($order);
		
		$ci =& get_instance();
		$ci->load->config('midtrans');
		$configMidtrans = $ci->config->item('midtrans');

		require_once(dirname(__FILE__) . '/../midtrans/Veritrans.php');
		Veritrans_Config::$isProduction = $configMidtrans['is_production'];
		Veritrans_Config::$serverKey    = $configMidtrans['server_key'];

		#echo "Checking transaction $order->id ... ";
		$transaction = Veritrans_Transaction::status($order->uuid);
		
		#echo "$transaction->status_code $transaction->status_message".PHP_EOL;

		if ( in_array($transaction->status_code, array(200, 201, 202, 407) ) ) {
			
			#var_dump($transaction);
			
			if ( isset($transaction->va_numbers) ) {
				#var_dump($transaction->va_numbers);
				foreach($transaction->va_numbers as $va_numbers) {
					$va_numbers->real_order_id = $order->id;
					#var_dump($va_numbers);
					
					$va_number = Model\Ticket\Ticket_payment_va_numbers::where(array(
						'real_order_id' => $order->id,
						'bank' => $va_numbers->bank,
						'va_number' => $va_numbers->va_number
					))
					->get()
					;
					#$va_number = $va_number[0];
					#die(var_dump($va_number));
					if ( ! $va_number ) {
						echo 'Creating va_number'.PHP_EOL;
						$va_number = Model\Ticket\Ticket_payment_va_numbers::make((array)$va_numbers);
						$va_number->create_by = method_exists($ci, 'getUser') ? $ci->getUser()->user_id : $ci->user_id;
						$va_number->save();
					} else {
						echo 'Updating va_number: '.$va_number->id.PHP_EOL;
						$va_number->update_by = method_exists($ci, 'getUser') ? $ci->getUser()->user_id : $ci->user_id;
						$va_number
							->where(array('id' => $va_number->id))
							->update($va_numbers)
						;
						$va_number->save();
					}
				}
				unset($transaction->va_numbers);
			}
			if ( isset($transaction->payment_amounts) ) {
				#var_dump($transaction->payment_amounts);
				unset($transaction->payment_amounts);
			}

			//var_dump($transaction);
			//return;
			
			$payment = Model\Ticket\Ticket_payments::where(array(
				'real_order_id' => $order->id,
				'order_id' => $order->uuid,
				'transaction_id' => $transaction->transaction_id,
			))
			->get()
			;
			//var_dump($transaction->status_code);
			//var_dump($order->id);
			#var_dump($payment);
			
			if ( ! $payment ) {
				echo 'Creating payment'.PHP_EOL;
				$payment = Model\Ticket\Ticket_payments::make((array)$transaction);
				$payment->real_order_id = $order->id;
				$payment->create_by = method_exists($ci, 'getUser') ? $ci->getUser()->user_id : $ci->user_id;
				$payment->save();
			} else {
				echo 'Updating payment: '.$payment->id.PHP_EOL;
				$payment->update_by = method_exists($ci, 'getUser') ? $ci->getUser()->user_id : $ci->user_id;
				$payment->create_log();
				$payment->save();
				$payment
					->where(array('id' => $payment->id))
					->update($transaction)
				;
			}
			//die(var_dump($order->payment_id));
			$order->order_status   = $transaction->transaction_status;
			$order->payment_status = $transaction->status_code;
			$order->payment_method = $transaction->payment_type;
			$order->payment_id     = $transaction->transaction_id; //$payment->id;
			$order->payment_amount = (float) $transaction->gross_amount;
			$order->calculate();
			$order->save();
			
			/* after the payment is approved and succeeded the system will publish the ticket
			   then reset the order to null
			 */
			if ( $transaction->status_code == 200 ) {
				
				if ( $order ) {
					//var_dump($order); die;
					//$order->publishTickets();
				}
				
				//$order = null;
			}

		}

		return $order;
	}
}
