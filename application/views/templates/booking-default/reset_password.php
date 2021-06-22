<?php
require_once('common/header.php');

$CI =& get_instance();

?>

<section class="cid-qOTO6dIh7U  mbr-parallax-background" id="header15-p">

    <div class="mbr-overlay" style="opacity: 0.5; background-color: rgb(7, 59, 76);"></div>

    <div class="container align-right">
		<div class="row">
			<div class="mbr-white col-lg-8 col-md-7 content-container">
				<h1 class="mbr-section-title mbr-bold pb-3 mbr-fonts-style display-1">Forgot Password?</h1>
        
			</div>
			<div class="col-lg-4 col-md-5">
				<div class="form-container">
					<div class="media-container-column" data-form-type="formoid">

						<h3 class="mbr-section-subtitle align-center mbr-light pb-3 mbr-fonts-style display-5"><?php echo lang('reset_password_heading');?></h3>



						<?php
						echo form_open('/booking/reset-password/' . $code .'/'.$CI->getEvent()->code,
							array(
								'class' => 'mbr-form'
							)
						);
						?>

							<div>
								<label for="new_password"><?php echo sprintf(lang('reset_password_new_password_label'), $min_password_length);?></label> <br />
								<div class="form-group">
									<?php
									echo form_input($new_password);
									?>
								</div>
							</div>

							<div>
								<div class="form-group">
								<?php echo lang('reset_password_new_password_confirm_label', 'new_password_confirm');?> <br />
								<?php
									echo form_input($new_password_confirm);
								?>
								</div>
							</div>

							<?php echo form_input($user_id);?>
							<?php echo form_hidden($csrf); ?>
							
							<?php
							if ( $message) {
							?>
							<div class="form_error text-center">
								<div class='alert alert-info'>
									<div id="infoMessage"><?php echo $message;?></div>
								</div>
							</div>
							<?php
							}
							?>

							<span class="input-group-btn">
								<?php
									echo form_button(
										array(
											'content' => 'RESET PASSWORD',
											'type' => 'submit',
											'class' => 'btn btn-primary btn-form display-4',
											'style' => 'width: 100%',
										)
									);
								?>
							</span>

						<?php echo form_close();?>


					</div>
				</div>
			</div>
		</div>
    </div>
    
</section>

<?php
require_once('common/footer.php');
?>
