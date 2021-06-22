<?php


$tickets = Model\Ticket\Sales::where(array(
		'app_user_id' => $user->user_id,
		'event_id'    => $event->id,
	))
	->all()
	;
	

if ( $tickets ) {
?>

<section class="section-table cid-qOZikgI47v mbr-parallax-background" id="table1-z" style="padding-top: 135px; padding-bottom: 135px;">
  <a href="/"></a>
  
  <div class="mbr-overlay" style="opacity: 0.9; background-color: rgb(255, 255, 255);">
  </div>
  <div class="container container-table">
      <h2 class="mbr-section-title mbr-fonts-style align-center pb-3 display-2">My Tickets</h2>
      <h3 class="mbr-section-subtitle mbr-fonts-style align-center pb-5 mbr-light display-5">List of your Tickets.     
      </h3>
      <div class="table-wrapper">
        <div class="container">
          
        </div>

        <div class="container scroll">
          <table class="table" cellspacing="0">
            <thead>
              <tr class="table-heads ">
			  <th class="head-item mbr-fonts-style display-7 text-center">EVENT</th>
              <th class="head-item mbr-fonts-style display-7 text-center">DATE</th>
			  <th class="head-item mbr-fonts-style display-7 text-center">NAME</th>
			  <th class="head-item mbr-fonts-style display-7 text-center">TICKET</th>
			  </tr>
            </thead>

            <tbody>
<?php
	foreach ( $tickets as $ticket ) {
?>

            <tr>
			  <td class="body-item mbr-fonts-style text-monospace text-center"><?php echo $ticket->event()->name; ?></td>
			  <td class="body-item mbr-fonts-style text-monospace text-center"><?php echo _ldate_($ticket->ticket_start_date); ?></td>
			  <td class="body-item mbr-fonts-style display-7"><?php echo $ticket->full_name; ?></td>
			  <td class="body-item mbr-fonts-style text-monospace text-center"><a href="/booking/ticket/<?php echo $ticket->order()->uuid; ?>/<?php echo $ticket->event()->code; ?>" target="_blank"><i class="fa fa-ticket"></i></a></td>
			</tr>
<?php
	}
?>
		    </tbody>
          </table>
	
        </div>

		
      </div>
    </div>
</section>
<?php
}
?>