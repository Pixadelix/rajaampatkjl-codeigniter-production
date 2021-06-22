

<a name="buy"></a>

<?php

	include_once('order_list.php');
	
	if ( $order && !$order->isOpen() ) {
		return;
	}

?>

<section class="mbr-section form1 cid-qOZ4PquGYE mbr-parallax-background" id="form1-w" style="padding-top: 135px; padding-bottom: 135px;">
	
    <div class="container">
        <div class="row justify-content-center">
            <div class="title col-12 col-lg-8">
                <h2 class="mbr-section-title align-center pb-3 mbr-fonts-style display-2">
                    Add Ticket</h2>
                <h3 class="mbr-section-subtitle align-center mbr-light pb-3 mbr-fonts-style display-5">
                    Fill this form bellow to order your ticket.
                </h3>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="media-container-column col-lg-8" data-form-type="formoid">
                    
                    <form class="mbr-form" action="/booking/add/<?php echo $event->code; ?>" method="post">
                        <div class="row row-sm-offset">
							
							<?php
							$errors = validation_errors();
							if ( $errors ) {
							?>
							<div class="col-md-12 multi-horizontal form-error"><?php echo trim($errors); ?></div>	
							<?php
							}
							?>
							
							
                            <div class="col-md-12 multi-horizontal" data-for="name">
                                <div class="form-group">
                                    <label class="form-control-label mbr-fonts-style display-7" for="name-form1-w">Name</label>
                                    <input type="text" class="form-control" name="full_name" data-form-field="Name" required="true" id="name-form1-w" value="<?php echo set_value('full_name'); ?>">
                                </div>
                            </div>
                            <div class="col-md-12 multi-horizontal" data-for="email">
                                <div class="form-group">
                                    <label class="form-control-label mbr-fonts-style display-7" for="email-form1-w">Email</label>
                                    <input type="email" class="form-control" name="email" data-form-field="Email" required="true" id="email-form1-w" value="<?php echo set_value('email'); ?>">
                                </div>
                            </div>
                            <div class="col-md-12 multi-horizontal" data-for="phone">
                                <div class="form-group">
                                    <label class="form-control-label mbr-fonts-style display-7" for="phone-form1-w">Phone</label>
                                    <input type="tel" class="form-control" name="phone" data-form-field="Phone" required="true" id="phone-form1-w" value="<?php echo set_value('phone'); ?>">
                                </div>
                            </div>
                        </div>
                        
                        <span class="input-group-btn"><button href="" type="submit" class="btn btn-primary btn-form display-4">ADD TO CART</button></span>
                    </form>
            </div>
        </div>
    </div>
</section>

