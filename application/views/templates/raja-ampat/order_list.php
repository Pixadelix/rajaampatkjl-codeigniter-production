<?php

$orders_dtl = $order ? $order->ticket_orders_dtl() : null;

if ( ! $orders_dtl ) return;

setlocale(LC_MONETARY, 'id_ID');

$open_amount = 0;

?>

<section class="section-table cid-qOTOTVrHzg mbr-fullscreen mbr-parallax-background" id="table1-z" style="padding-top: 135px; padding-bottom: 135px;">
	<div class="mbr-overlay" style="opacity: 0.9; background-color: rgba(255, 255, 255, .95);"></div>
	<div class="container container-table">
	
		<h2 class="mbr-section-title mbr-fonts-style align-center pb-3 display-2">Your Cart Items</h2>
		<h3 class="mbr-section-subtitle mbr-fonts-style align-center pb-5 mbr-light display-5">List of your ordered tickets.</h3>
	

		<ul class="list-group" id="list-tab" role="tablist">
		<?php
		foreach ( $orders_dtl as $order_dtl ) {
			$country = Model\System\Countries::where(array('code' => $order_dtl->country_code))->get();
		?>
			<li href="#" class="list-group-item list-group-item-action flex-column align-items-start" ata-toggle="list" role="tab">
				<div class="d-flex w-100 justify-content-between">
					<div class="mb-1 h5"><?php echo $order_dtl->full_name; ?></div>
					<span>
						<!--a href="/booking/edit/<?php echo "$order_dtl->id/$event->code"; ?>" class="btn-secondary-outline btn-form">Edit</a-->
						<a href="/booking/edit/<?php echo "$order_dtl->id/$event->code"; ?>"><i class="fa fa-pencil-square-o fa-lg fa-fw" style="color: green;"></i></a>
						<a href="/booking/remove/<?php echo "$order_dtl->id/$event->code"; ?>"><i class="fa fa-trash-o fa-lg fa-fw" style="color: darkred;"></i></a>
					</span>
					
				</div>
				<hr/>
				<div class="mb-1"><i class="fa fa-fw fa-credit-card"></i><span class="text-monospace"><?php echo money_format('%= (#10.0n', $order_dtl->price); ?></span></div>
				<div><i class="fa fa-fw fa-envelope-o"></i> <?php echo $order_dtl->email; ?></div>
				<div><i class="fa fa-fw fa-phone"></i> <?php echo $order_dtl->phone; ?></div>
				<div><i class="fa fa-fw fa-book"></i> <?php echo $order_dtl->id_card_number; ?></div>
				<div><i class="fa fa-fw fa-globe"></i> <?php echo $country->name; ?></div>
				
				
				
			</li>
		<?php
			$open_amount += $order_dtl->price;
		}

		$taxes = $event->taxes();
		$tax_total = 0;
		if ( $taxes ) {
			?>
			<li href="#" class="list-group-item list-group-item-action flex-column align-items-start" ata-toggle="list" role="tab">
				<span class="h5">TAX</span>
			<?php
			foreach ( $taxes as $tax ) {
				$tax_total += ($open_amount * $tax->tax);
			?>
			
				<div class="d-flex w-100 justify-content-between">
					<?php echo $tax->name . ' '.(($tax->tax < 0 ? $tax->tax * -1 : $tax->tax) * 100).'%'; ?>
					<span class="text-monospace"><?php echo money_format('%= (#10.0n', $open_amount*$tax->tax); ?></span>
				</div>
			<?php
			}
		}
			?>
			</li>
			<li href="#" class="list-group-item list-group-item-action flex-column align-items-start" ata-toggle="list" role="tab">
				<div class="d-flex w-100 justify-content-between h5">
					<span>PRICE TOTAL</span>
					<span class="text-monospace"><?php echo money_format('%= (#10.0n', $open_amount + $tax_total); ?></span>
				</div>
			</li>
		</ul>
		<?php /*
		<div class="table-wrapper">
			<div class="container scroll table-responsive-sm">
				<table class="table" cellspacing="0">
					<thead>
						<tr class="table-heads">
							<th class="head-item mbr-fonts-style display-7 text-right">#</th>
							<th class="head-item mbr-fonts-style display-7">NAME</th>
							<th class="head-item mbr-fonts-style display-7">EMAIL</th>
							<th class="head-item mbr-fonts-style display-7">PHONE</th>
							<th class="head-item mbr-fonts-style display-7 text-right ">PRICE</th>
							<?php if ( $order->isOpen() ) { ?><th class=""></th><?php } ?>
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
			
			*/ ?>
			<div class="container table-info-container"
				style="
				text-shadow:
					0px 4px 3px rgba(0,0,0,0.4),
					0px 8px 13px rgba(0,0,0,0.2),
					0px 18px 23px rgba(0,0,0,0.1);
				"
			>
				<!--span>
					<i class="fa fa-info-circle"></i> Status: <?php echo $order->getMidtransPaymentStatus(); ?>
				</span><br/-->
				<!--span>
					<i class="fa fa-ticket"></i> <?php echo $event->getAvailableQuota(); ?> tickets still available. Please finish your payment.
				</span-->
			</div>
			<?php if ( $order->isOpen() ) { ?>
			<div class="text-center" style="padding-top: 60px; padding-bottom: 0px;">
				<span class="input-group-btn"><button id="pay-button" data-order-id="<?php echo $order->id; ?>" class="btn btn-secondary-outline btn-form display-4" style="border-radius: 100px;"><i class="fa fa-shopping-cart fa-lg"></i>&nbsp;Pay Now</button></span>
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
