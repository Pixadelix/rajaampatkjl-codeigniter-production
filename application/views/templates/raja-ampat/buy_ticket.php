<?php

if ( ! $user ) {
	return;
}

?>

<a name="buy"></a>

<?php

	include_once('order_list.php');

?>

<section class="cid-qOTOTVrHzg mbr-fullscreen mbr-parallax-background mbr-white" id="header15-p">
    <div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(88, 70, 9); a: rgb(228, 210, 149);"></div>
    <div class="container align-right">
        <div class="row">
            <div class="mbr-white col-12 col-md-6 content-container">
                <h2 class="mbr-section-title align-center pb-3 mbr-fonts-style display-2"><i class="fa fa-fw fa-2x fa-credit-card" style="opacity: .8;"></i> Buy Ticket</h2>
                <h3 class="mbr-section-subtitle align-center mbr-light pb-3 mbr-fonts-style display-5">Fill this form to order your ticket.</h3>
            </div>
        
			<div class="col-12 col-md-6">
				<div class="form-contaier">
					<div class="media-container-column" data-form-type="formoid">
                    
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
										<input type="text" class="form-control" name="full_name" placeholder="Name" data-form-field="Name" required="true" id="name-form1-w" value="<?php echo set_value('full_name'); ?>">
									</div>
								</div>
								<div class="col-md-12 multi-horizontal" data-for="email">
									<div class="form-group">
										<label class="form-control-label mbr-fonts-style display-7" for="email-form1-w">Email</label>
										<input type="email" class="form-control" name="email" placeholder="Email" data-form-field="Email" required="true" id="email-form1-w" value="<?php echo set_value('email'); ?>">
									</div>
								</div>
								<div class="col-md-12 multi-horizontal" data-for="phone">
									<div class="form-group">
										<label class="form-control-label mbr-fonts-style display-7" for="phone-form1-w">Phone</label>
										<input type="tel" class="form-control" name="phone" placeholder="Phone" data-form-field="Phone" required="true" id="phone-form1-w" value="<?php echo set_value('phone'); ?>">
									</div>
								</div>
								<div class="col-md-12 multi-horizontal" data-for="id_card_number">
									<div class="form-group">
										<label class="form-control-label mbr-fonts-style display-7" for="id-card-number-form1-w">ID Number (Passport)</label>
										<input type="text" class="form-control" name="id_card_number" placeholder="ID Number (Passport)" data-form-field="ID Number (Passport)" required="true" id="id-card-number-form1-w" value="<?php echo set_value('id_card_number'); ?>">
									</div>
								</div>
								
								<div class="col-md-12 multi-horizontal" data-for="phone">
									<div class="form-group">
										<label class="form-control-label mbr-fonts-style display-7" for="phone-form1-w">Country</label>
										<?php
										$ci =& get_instance();
										$countries = $ci->db->query('select code as country_code, name as country_name from sys_countries where name != "" or code != "" or name is not null or code is not null order by name asc')->result_array();

										$opts = array_column($countries, 'country_name', 'country_code');
										//$opts = array_merge(array('' => 'Please choose country'), $opts);
										//var_dump($opts); die;

										echo form_dropdown(
											'country_code', $opts, null,
											array(
												'id' => 'country-form1-w',
												'name' => 'country_code',
												'class' => 'form-control select2',
												'data-placeholder' => 'Choose your country',
												'data-allow-clear' => 'true',
												'data-close-on-select' => 'true',
												'data-form-field' => 'Country',
												'required' => 'true',
											)
										);
										?>

									</div>
								
								
									<span class="input-group-btn">
										<button type="submit" class="btn btn-success-outline btn-form display-4"><span class="mbrib-login mbr-iconfont mbr-iconfont-btn fa fa-shopping-cart"></span>Add to Cart</button>
									</span>
								
								</div>
							</div>
						</form>
					</div>
				</div>
            </div>
        </div>
    </div>
</section>

