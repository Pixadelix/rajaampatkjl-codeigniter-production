<a name="login"></a>

<section class="cid-qOTOTVrHzg mbr-fullscreen mbr-parallax-background" id="header15-p">
    <div class="mbr-overlay" style="opacity: 0.4; background-color: rgb(228, 210, 149);"></div>
		<div class="container align-right">
			<div class="row justify-content-center">
			
			<?php if ( !$user ) { ?>
				
				<div class="title col-12 col-lg-6">
					<h2 class="mbr-section-title align-center pb-3 mbr-fonts-style display-2">Registered User</h2>
					<h3 class="mbr-section-subtitle align-center mbr-light pb-3 mbr-fonts-style display-5">Please Login here.</h3>
				</div>
				<div class="col-lg-6 col-md-5">
					<div class="form-container">
						<div class="media-container-column" data-form-type="formoid">
            
							<form class="mbr-form" action="/booking/login/<?php echo $event->code; ?>#login" method="get">
								<div data-for="name">
									<div class="form-group">
										<input type="email" class="form-control px-3" name="user_email" data-form-field="Email" placeholder="Email" required="true" id="name-header15-p">
									</div>
								</div>
								<div data-for="email">
									<div class="form-group">
										<input type="password" class="form-control px-3" name="user_pass" data-form-field="Password" placeholder="Password" required="true" id="email-header15-p">
									</div>
								</div>
                
								<div class="form_error text-center">
									<?php if( null != $this->session->flashdata('success')):?>
									<div class='alert alert-success'>
										<?php echo $this->session->flashdata('success');?>
									</div>
									<?php elseif( null != $this->session->flashdata('error')):?>
									<div class='alert alert-danger '>
										<?php echo $this->session->flashdata('error');?>
									</div>							
									<?php endif;?>
								</div>
				
								
								<span class="input-group-btn"><button href="" type="submit" class="btn btn-form btn-success-outline display-4"><span class="mbrib-login mbr-iconfont mbr-iconfont-btn fa fa-sign-in"></span>Login</button></span>
								<span class="gdpr-block mbr-white"><label><input type="checkbox" name="gdpr" id="gdpr-header15-p" required="">By continuing you agree to our <a href="/tos">Terms of Service</a> and <a href="/privacy-policy">Privacy Policy</a>.</label></span></form>
							</form>
						</div>
					</div>
				</div>

			<?php } else { ?>


				<div class="title col-12 col-lg-6">
					<h2 class="mbr-section-title align-center pb-3 mbr-fonts-style display-2">Welcome back</h2>
				</div>
				<div class="col-lg-6 col-md-6">
					<div class="form-container">
						<div class="media-container-column" data-form-type="formoid">
                
							<div class="mbr-white">
								<h2 class="mbr-section-title mbr-bold pb-3 mbr-fonts-style display-6"><?php echo $user->user_name; ?></h2>
							</div>
                
							<span class="input-group-btn">
								<a href="/booking/logout/<?php echo $event->code; ?>" class="btn btn-form btn-warning-outline display-6" style="border-radius: 100px;"><span class="mbrib-login mbr-iconfont mbr-iconfont-btn fa fa-user"></span>Profile</a>
								<a href="/booking/logout/<?php echo $event->code; ?>" class="btn btn-form btn-success-outline display-6" style="border-radius: 100px;"><span class="mbrib-login mbr-iconfont mbr-iconfont-btn fa fa-sign-out"></span>Logout</a>
							</span>
			
						</div>
					</div>
				</div>
			<?php
				#include_once('buy_ticket.php');
			}
			?>

		</div>
    </div>
</section>