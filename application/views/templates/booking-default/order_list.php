<?php

$orders_dtl = $order ? $order->ticket_orders_dtl() : null;

if ( ! $orders_dtl ) return;

setlocale(LC_MONETARY, 'id_ID');

$open_amount = 0;

?>

<section class="section-table cid-qOZikgI47v mbr-parallax-background" id="table1-z" style="padding-top: 135px; padding-bottom: 135px;">

	<a href="/"></a>
  
  <div class="mbr-overlay" style="opacity: 0.9; background-color: rgb(255, 255, 255);">
  </div>
  <div class="container container-table">
      <h2 class="mbr-section-title mbr-fonts-style align-center pb-3 display-2">Your Cart Items</h2>
      <h3 class="mbr-section-subtitle mbr-fonts-style align-center pb-5 mbr-light display-5">List of your ordered tickets.     
      </h3>
      <div class="table-wrapper">
        <div class="container">
          
        </div>

        <div class="container scroll table-responsive">
          <table class="table" cellspacing="0">
            <thead>
              <tr class="table-heads">
              <th class="head-item mbr-fonts-style display-7 text-right">#</th>
              <th class="head-item mbr-fonts-style display-7">NAME</th>
			  <th class="head-item mbr-fonts-style display-7">EMAIL</th>
			  <th class="head-item mbr-fonts-style display-7">PHONE</th>
			  <th class="head-item mbr-fonts-style display-7 text-right ">PRICE</th>
			  <?php if ( $order->isOpen() ) { ?><td class=""></td><?php } ?>
			  </tr>
            </thead>

            <tbody>

<?php
$i = 0;
foreach ($orders_dtl as $order_dtl ) {
	$i++;
?>
            <tr>
			  <td class="body-item mbr-fonts-style display-7 text-right"><?php echo $i; ?>.</td>
              <td class="body-item mbr-fonts-style display-7"><?php echo $order_dtl->full_name; ?></td>
			  <td class="body-item mbr-fonts-style display-7"><?php echo $order_dtl->email; ?></td>
			  <td class="body-item mbr-fonts-style display-7"><?php echo $order_dtl->phone; ?></td>
			  <td class="body-item mbr-fonts-style display-7 text-right">
				<span class="text-monospace"><?php echo money_format('%= (#10.0n', $order_dtl->price); ?></span>
			  </td>
			  <?php if ( $order->isOpen() ) { ?>
			  <td class="body-item mbr-fonts-style display-7 text-right">
				<a href="/booking/edit/<?php echo "$order_dtl->id/$event->code"; ?>" class="display-4"><i class="fa fa-pencil-square fa-lg fa-fw text-primary"></i></a>
				<a href="/booking/remove/<?php echo "$order_dtl->id/$event->code"; ?>" class="display-4"><i class="fa fa-minus-square fa-lg fa-fw text-danger"></i></a>
			  </td>
			  <?php } ?>
			</tr>
<?php
	$open_amount += $order_dtl->price;
}
?>
		    </tbody>
            <tfoot>
              <tr class="">

              <td colspan="4" class="head-item mbr-fonts-style display-7 text-right">SUB TOTAL:</td>
			  <td class="head-item mbr-fonts-style display-7 text-right">
				<span class="text-monospace"><?php echo money_format('%= (#10.0n', $open_amount); ?></span>
			  </td>
			  <?php if ( $order->isOpen() ) { ?><td></td><?php } ?>
			  </tr>
			  <?php
			  $taxes = $event->taxes();
			  $tax_total = 0;
			  foreach ( $taxes as $tax ) {
				  $tax_total += ($open_amount * $tax->tax);
			  ?>
			  <tr class="">
			  <td colspan="4"class="head-item mbr-fonts-style display-7 text-right"><?php echo $tax->name . ' '.(($tax->tax < 0 ? $tax->tax * -1 : $tax->tax) * 100).'%'; ?>:</td>
			  <td class="head-item mbr-fonts-style display-7 text-right">
				<span class="text-monospace"><?php echo money_format('%= (#10.0n', $open_amount*$tax->tax); ?></span>
			  </td>
			  <?php if ( $order->isOpen() ) { ?><td class=""></td><?php } ?>
			  </tr>
			  <?php
			  }
			  ?>
			  <tr class="">

			  <td colspan="4" class="head-item mbr-fonts-style display-7 text-right">GRAND TOTAL:</td>
			  <td class="head-item mbr-fonts-style display-7 text-right">
				<span class="text-monospace"><?php echo money_format('%= (#10.0n', $open_amount + $tax_total); ?></span>
			  </td>
			  <?php if ( $order->isOpen() ) { ?><td></td><?php } ?>
			  </tr>
            </tfoot>
          </table>
        </div>
        <div class="container table-info-container"
		style="
		text-shadow:
			0px 4px 3px rgba(0,0,0,0.4),
			0px 8px 13px rgba(0,0,0,0.2),
			0px 18px 23px rgba(0,0,0,0.1);
			"
		>
			<span>
				<i class="fa fa-info-circle"></i> Status: <?php echo $order->getMidtransPaymentStatus(); ?></span>
			<br/>
			<!--span>
				<i class="fa fa-ticket"></i> <?php echo $event->getAvailableQuota(); ?> tickets still available. Please finish your payment.
			</span-->
        </div>
		<?php if ( $order->isOpen() ) { ?>
		<div class="text-center" style="padding-top: 60px; padding-bottom: 0px;">
			<span class="input-group-btn"><button id="pay-button" data-order-id="<?php echo $order->id; ?>" class="btn btn-secondary btn-form display-4"><i class="fa fa-shopping-cart fa-lg"></i>&nbsp;PROCEED TO PAYMENT</button></span>
		</div>
		<?php } ?>
      </div>
    </div>
</section>

<?php
$CI =& get_instance();
$CI->load->config('midtrans');
$configMidtrans = $CI->config->item('midtrans');
$client_key = $configMidtrans['client_key'];
$lib_snap   = $configMidtrans['lib_snap'];

?>

<script src="<?php echo $lib_snap; ?>" data-client-key="<?php echo $client_key; ?>"></script>

<?php // button class="btn btn-form btn-danger display-4" id="test-notification">Test Notification</button ?>

<!-- moved to js/order_list.php script type="text/javascript">

var payButton = document.getElementById('pay-button');

if (payButton) {
	payButton.onclick = function(){
		$.ajax({
			type: 'GET',
			url: '/booking/transaction_details/<?php echo $event->code; ?>',
			success: function(transaction_details) {
				getSnapToken(transaction_details, function(response) {
					var tokenResponse = JSON.parse(response);
					if ( tokenResponse.token ) {
						snap.pay(tokenResponse.token, {
							skipOrderSummary: true,
							skipCustomerDetails: true,
							showOrderId: true,
							onSuccess: function(result){
								console.log('success');
								console.log(result);
								txLog(result);
							},
							onPending: function(result){
								console.log('pending');
								console.log(result);
								txLog(result);
							},
							onError: function(result){
								console.log('error');
								console.log(result);
								txLog(result);
							},
							onClose: function(){
								console.log('customer closed the popup without finishing the payment');
							}
						});
					} else {
						console.log(response);
					}
				});
			},
			error: function(response) {
				console.log(response);
			}
		});
		
		return;
	};
}

/**
 * Send AJAX POST request to checkout.php, then call callback with the API response
 * @param {object} requestBody: request body to be sent to SNAP API
 * @param {function} callback: callback function to pass the response
 */
function getSnapToken(requestBody, callback) {
	var xmlHttp = new XMLHttpRequest();
	xmlHttp.onreadystatechange = function() {
		if(xmlHttp.readyState == 4 && xmlHttp.status == 200) {
			callback(xmlHttp.responseText);
		}
	}

	xmlHttp.open("post", "/booking/midtrans/checkout", "<?php echo $event->code; ?>");
	xmlHttp.send(JSON.stringify(requestBody));
}

function txLog(payment) {
	console.log('txLog');
}

</script -->
