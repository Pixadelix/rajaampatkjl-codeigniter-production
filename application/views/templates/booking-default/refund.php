<?php
require_once('common/header.php');

#$o = Model\Ticket\Ticket_orders::first();
$o = $order;
$order_dtl = $o->ticket_orders_dtl();

?>

	<section class="countdown2 cid-qOTPHuD2Jj" id="countdown2-r" style="padding-bottom: 30px;">
        <div class="container">
            <h2 class="mbr-section-title pb-3 align-center mbr-fonts-style display-2">Request for refund</h2>
        </div>
    
	
		<div class="container">
			<div class="row justify-content-center">
				<div class="media-container-column col-lg-12" data-form-type="formoid">
					<form class="mbr-form" action="/booking/refund/<?php echo "$o->uuid/$event->code"; ?>" method="post">
						<?php
						echo form_input($user_id);
						echo form_hidden(array('uuid' => $o->uuid));
						echo form_hidden($csrf);
						?>
						<div class="row row-sm-offset">
							<div class="col-md-12 multi-horizontal" data-for="username">
								<div class="form-group">
									<label class="form-control-label mbr-fonts-style display-7" for="reason_for_refund">Please tell us your reason to refund</label>
									<textarea rows="10" type="text" class="form-control" name="reason_for_refund" data-form-field="Reason" required="true" id="reason-for-refund" value="<?php echo set_value('reason_for_refund'); ?>"></textarea>
								</div>
							</div>
						</div>
						<span class="input-group-btn">
							<button href="" type="submit" class="btn btn-primary btn-form display-4">SUBMIT</button>
						</span>
						<p class="mbr-text align-center py-2 mbr-fonts-style display-5">
							Please read our refund policy <a href="/refund-policy">here</a> before making a request.
						</p>
					</form>
				</div>
			</div>
		</div>
		
	</section>

	<section class="countdown2 cid-qOTPHuD2Jj" style="padding-top: 0px;">
		<div class="container">
            <h5 class="mbr-section-title pb-3 mbr-fonts-style">Order Number: <?php echo $o->uuid; ?></h5>
        </div>
		
		<div class="table-wrapper">
			<div class="container scroll">
				<table class="table" cellspacing="0">
					<thead>
						<tr class="table-heads">
							<th class="head-item mbr-fonts-style display-7">ORDER FOR</th>
							<th class="head-item mbr-fonts-style display-7">EVENT</th>
							<th class="head-item mbr-fonts-style display-7">TRANSACTION DATE</th>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td class="body-item mbr-fonts-style text-monospace"><?php echo $o->user()->username; ?></td>
							<td class="body-item mbr-fonts-style text-monospace"><?php echo $o->event()->name; ?></td>
							<td class="body-item mbr-fonts-style text-monospace"><?php echo _ldate_($o->create_at, '%A, %d %B %Y %H:%M %Z'); ?></td>
						</tr>
					</tbody>
				</table>
	
			</div>
		</div>
		
		<div class="container">
            <h5 class="mbr-section-title pb-3 mbr-fonts-style">Order details</h5>
        </div>
		
		<div class="table-wrapper">
			<div class="container scroll">
				<table class="table" cellspacing="0">
					<thead>
						<tr class="table-heads ">
							<th class="head-item mbr-fonts-style display-7">TICKET FOR</th>
							<th class="head-item mbr-fonts-style display-7">EMAIL</th>
						</tr>
					</thead>

					<tbody>
					<?php
					foreach ($order_dtl as $odtl) {
					?>
						<tr>
							<td class="body-item mbr-fonts-style text-monospace"><?php echo $odtl->full_name; ?></td>
							<td class="body-item mbr-fonts-style text-monospace"><?php echo $odtl->email; ?></td>
						</tr>
					<?php
					}
					?>
					</tbody>
				</table>
	
			</div>
		</div>

	
    </section>
	
<?php
require_once('common/footer.php');
?>