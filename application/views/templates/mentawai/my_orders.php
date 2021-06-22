<?php



	
if ( $orders_hist ) {
?>


<section class="section-table cid-qOZikgI47v mbr-parallax-background" id="table1-z" style="padding-top: 135px; padding-bottom: 135px;">
<a href="/"></a>
  
  <div class="mbr-overlay" style="opacity: 0.9; background-color: rgb(255, 255, 255);">
  </div>
  <div class="container container-table">
      <h2 class="mbr-section-title mbr-fonts-style align-center pb-3 display-2">Transaction History</h2>
      <h3 class="mbr-section-subtitle mbr-fonts-style align-center pb-5 mbr-light display-5">List of your transactions.     
      </h3>
      <div class="table-wrapper">
        <div class="container">
          
        </div>

        <div class="container scroll">
          <table class="table" cellspacing="0">
            <thead>
              <tr class="table-heads ">
			  <th class="head-item mbr-fonts-style display-7 text-center">EVENT</th>
			  <th class="head-item mbr-fonts-style display-7 text-center">TRANSACTION DATE</th>
			  <th class="head-item mbr-fonts-style display-7 text-center">STATUS</th>
			  <th class="head-item mbr-fonts-style display-7 text-right">VALUE</th>
			  <th class="head-item mbr-fonts-style display-7 text-right">INVOICE</th>
			  
			  </tr>
            </thead>

            <tbody>
<?php
	foreach ( $orders_hist as $o ) {
		//var_dump($o->create_at); continue;
?>
            <tr>
			  <td class="body-item mbr-fonts-style text-monospace text-center"><?php echo $o->event()->name; ?></td>
			  <td class="body-item mbr-fonts-style text-monospace text-center"><?php echo _ldate_($o->create_at, '%A, %d %B %Y %H:%M %Z'); ?></td>
			  
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
			  
			  ?></td>
			  <td class="body-item mbr-fonts-style display-7 text-right" nowrap>
				<span class="text-monospace"><?php echo money_format('%= (#10.0n', $o->total_amount+$o->tax_amount+$o->disc_amount); ?></span>
			  </td>
			  
			  <td class="body-item mbr-fonts-style display-7 text-center">
				<a href="/booking/invoice/<?php echo $o->uuid."/$event->code"; ?>" target="_blank"><i class="fa fa-file-pdf-o text-danger"></i></a>
			  </td>
			</tr>
		    </tbody>

<?php
	}
?>
          </table>
	
        </div>

		
      </div>
    </div>
</section>
<?php
}
?>