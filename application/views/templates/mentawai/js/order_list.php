//<script><?php // restricted(''); ?>

$(document).ready(function() {
	<?php
	/*
	$('#test-notification').on('click', function() {
	
		data = {
			"transaction_time": "2018-06-05 14:59:13",
			"transaction_status": "settlement",
			"transaction_id": "6f76ec94-fb14-4e00-a4ab-c744bf3c804e",
			"status_message": "midtrans payment notification",
			"status_code": "200",
			"signature_key": "71bda85ffb466a0424610fcdfdc38c7b71556008fc29befd44aaa751f8b266c44460a550ed049efea7c8f036d18dfe8f3e384379a2aeddfc428aade71ae6204a",
			"payment_type": "credit_card",
			//"order_id": "384256dc-95e4-4d3b-9bc8-6a0f03c40810",
			order_id: 'd2cce866-36b0-4e3b-99cb-8c1e051e3d91',
			"masked_card": "410505-1467",
			"gross_amount": "1000.00",
			"fraud_status": "accept",
			"eci": "05",
			"channel_response_message": "Approved",
			"channel_response_code": "00",
			"bank": "bni",
			"approval_code": "1528185554310"
		};
		
		$.ajax({
			type: 'POST',
			dataType: 'JSON',
			data: JSON.stringify(data),
			//url: 'http://event.mediavista.id/booking/midtrans/tx/notification',
			url: '//event.skyrim.dev/booking/midtrans/tx/notification',
		})
		.done(function(resp) { debug(resp); })
		;
	
	});
	*/ ?>
	
	$('#pay-button').on('click', function(){
		$.preloader.start({
			modal: true,
			src : '/assets/static/img/sprites.24.png'
		});
		//setTimeout(function(){
			//$.preloader.stop();
        //}, 3000);
		orderId = $(this).data('order-id');
		$.ajax({
			type: 'GET',
			url: '/booking/midtrans/tx/transaction_details/'+orderId,
			success: function(resp) {
				//debug(resp);
				if ( !resp.transaction_details.order_id || !resp.transaction_details.gross_amount ) {
					$.alert({
						title: 'Invalid Order',
						content: 'This order is invalid.',
						backgroundDismiss: true,
					});
					return;
				}
				getSnapToken(resp, function(response) {
					$.preloader.stop();
					if ( response.token ) {
						snap.pay(response.token, {
							skipOrderSummary: true,
							skipCustomerDetails: true,
							showOrderId: true,
							onSuccess: function(result){
								console.log('success');
								txLog('success', result);
							},
							onPending: function(result){
								console.log('pending');
								txLog('pending', result);
							},
							onError: function(result){
								console.log('error');
								txLog('error', result);
							},
							onClose: function(){
								console.log('customer closed the popup without finishing the payment');
							}
						});
					} else {
						console.log(response);
						errorResponse = JSON.parse(response);
						$.alert({
							icon: 'fa fa-exclamation',
							title: 'Transaction Error',
							theme: 'material',
							backgroundDismiss: false,
							columnClass: 'medium',
							containerFluid: false,
							content: errorResponse.error,
							buttons: {
								Close: {
									btnClass: 'btn-danger',
									action: function() {
										window.location.reload(true);
									}
								}
							}
						});
					}
				});
			},
			error: function(response) {
				debug('TODO: handle this error');
				debug(response);
				//window.location.reload(true);
			}
		})
		.done(function() {
			//$.preloader.stop();
		})
		;
		
		return;
	});
	

	/**
	 * Send AJAX POST request to checkout.php, then call callback with the API response
	 * @param {object} requestBody: request body to be sent to SNAP API
	 * @param {function} callback: callback function to pass the response
	 */
	function getSnapToken(requestBody, callback) {
		/* */
		debug(requestBody);
		$.preloader.start({
			modal: true,
			src : '/assets/static/img/sprites.24.png'
		});
		$.ajax({
			type: 'POST',
			url: '/booking/midtrans/tx/checkout',
			data: JSON.stringify(requestBody),
			dataType: 'JSON',
		})
		.success(function(response) {
			//debug(response);
			callback(response);
		})
		.done(function() {
			
		})
		;
		/* /
		var xmlHttp = new XMLHttpRequest();
		xmlHttp.onreadystatechange = function() {
			if(xmlHttp.readyState == 4 && xmlHttp.status == 200) {
				callback(xmlHttp.responseText);
			} else {
				debug(xmlHttp.responseText);
				//window.location.reload(true);
			}
		}

		xmlHttp.open("post", "/booking/midtrans/tx/checkout");
		xmlHttp.send(JSON.stringify(requestBody));
		/* */
	}

	function txLog(status, payment) {
		debug('txLog:' + status);
		debug(payment);
	}
	
});