<?php

if ( ! function_exists('ticket_order_status_desc') ) {
	function ticket_order_status_desc($o) {
		if ( ! in_array($o->order_status, array('new') ) ) {
			if (in_array($o->order_status, array('capture', 'finish', 'credit_card', 'settlement')) && $o->payment_status == 200) {
				$event = $o->event();
				return "<a href=\"/booking/order/$o->uuid/$event->code\" style=\"color: green;\" target=\"_blank\">Success</a>";
				//return 'Success';
			} else {
				return '<span style="color: red;">Failed</span>';
			}
		} else {
			return '<span style="color: orange;">Waiting for payment</span>';
		}
	}
}

	
if ( $orders_hist ) {
?>


<section class="section-table cid-qOZikgI47v mbr-parallax-background" id="table1-z" style="padding-top: 135px; padding-bottom: 135px;">
	<div class="mbr-overlay" style="opacity: 0.9; background-color: rgb(255, 255, 255);"></div>
	
	<div class="container">
		<h2 class="mbr-section-title mbr-fonts-style align-center pb-3 display-2">Transaction History</h2>
		<h3 class="mbr-section-subtitle mbr-fonts-style align-center pb-5 mbr-light display-5">List of your successful or pending transactions.</h3>

		<!--a href="https://www.mentawaisr.com/booking/invoice/1e2c7735-6d14-4eb4-ac44-eb319b913ac6/mentawai-domestik">INPOIS</a-->
		<ul class="list-group" id="list-tab" role="tablist">
		<?php
		foreach ( $orders_hist as $o ) {
		?>
			
			<li href="#" class="list-group-item list-group-item-action flex-column align-items-start" role="tab">
				<div class="d-flex w-100 justify-content-between">
					<div class="mb-1 h5"><?php echo _ldate_($o->create_at, '%d %B %Y'); ?></div>
					<a href="/booking/invoice/<?php echo $o->uuid."/$event->code"; ?>"><i class="fa fa-cloud-download text-danger"></i> Invoice</a>
				</div>
				
				<div class="d-flex w-100 justify-content-between" style="padding-bottom: 10px;">
					<small><?php echo ticket_order_status_desc($o); ?></small>
				</div>
				
				<?php
				
				$tickets = $o->tickets();
				if ( $tickets ) {
				?>

				<ul class="list-group list-group-flush" id="list-tab" role="tablist">
					<?php
					foreach ( $tickets as $t ) {
					?>
				
					<li href="#" class="list-group-item list-group-item-action flex-column align-items-start" role="tab" style="padding-right: 0;">
						<div class="d-flex w-100 justify-content-between">
							<small><i class="fa fa-ticket"></i> <?php echo $t->full_name; ?></small>
							<small><a href="/booking/ticket/<?php echo $t->uuid; ?>/<?php echo $t->event()->code; ?>" ><i class="fa fa-cloud-download text-danger"></i> Ticket</a></small>
						</div>
					</li>
				
		
					<?php
					}
					?>
				</ul>
				<?php
				}
				?>
		
			</li>
		<?php
		}
		?>
		</ul>
		
		<?php /*
		<div class="table-wrapper">
			<div class="container"></div>
			<div class="container scroll table-responsive-sm">
				<table class="table" cellspacing="0">
					<thead>
						<tr class="table-heads ">
							<!--th class="head-item mbr-fonts-style display-7 text-center" style="vertical-align: middle">TYPE</th-->
							<th class="head-item mbr-fonts-style display-7 text-center" style="vertical-align: middle">DATE</th>
							<th class="head-item mbr-fonts-style display-7 text-center" style="vertical-align: middle">STATUS</th>
							<th class="head-item mbr-fonts-style display-7 text-right" style="vertical-align: middle">PRICE</th>
							<th class="head-item mbr-fonts-style display-7 text-right" style="vertical-align: middle">INVOICE</th>
						</tr>
					</thead>
					<tbody>
					<?php
					foreach ( $orders_hist as $o ) {
						//var_dump($o->create_at); continue;
						?>
						<tr>
							<!--td class="body-item mbr-fonts-style text-monospace text-left"><?php echo $o->event()->name; ?></td-->
							<td class="body-item mbr-fonts-style text-monospace text-left" nowrap><?php echo _ldate_($o->create_at, '%d %B %Y'); ?></td>
							<td class="body-item mbr-fonts-style display-7 text-center"><?php
							if ( ! in_array($o->order_status, array('new') ) ) {
								if (in_array($o->order_status, array('capture', 'finish', 'credit_card', 'settlement')) && $o->payment_status == 200) {
									echo "<a href=\"/booking/order/$o->uuid/$event->code\" target=\"_blank\">SUCCESS</a>";
									//echo 'SUCCESS';
								} else {
									echo 'FAILED';
								}
							} else {
								echo 'PENDING';
							}
			  
							?>
							</td>
							<td class="body-item mbr-fonts-style display-7 text-right" nowrap>
								<span class="text-monospace"><?php echo money_format('%= (#10.0n', $o->total_amount+$o->tax_amount+$o->disc_amount); ?></span>
							</td>
			  
							<td class="body-item mbr-fonts-style display-7 text-right">
								<a href="/booking/invoice/<?php echo $o->uuid."/$event->code"; ?>" target="_blank"><i class="fa fa-file-pdf-o text-danger"></i></a>
							</td>
						</tr>
					</tbody>
					<?php
					}
					?>
				</table>
			</div>
			*/ ?>
		</div>
	</div>
</section>
<?php
}
?>