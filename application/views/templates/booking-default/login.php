<a name="login"></a>

<?php
if ( !$user ) {
?>

<section class="cid-qOTOTVrHzg mbr-parallax-background" id="header15-p">

    <div class="mbr-overlay" style="opacity: 0.5; background-color: rgb(7, 59, 76);"></div>

    <div class="container align-right">
<div class="row">
    <div class="mbr-white col-lg-8 col-md-7 content-container">
        <h1 class="mbr-section-title mbr-bold pb-3 mbr-fonts-style display-1">Already Registered?</h1>
        
    </div>
    <div class="col-lg-4 col-md-5">
    <div class="form-container">
        <div class="media-container-column" data-form-type="formoid">
            
            <form class="mbr-form" action="/booking/login/<?php echo $event->code; ?>#login" method="post">
                <div data-for="user_email">
                    <div class="form-group">
                        <input type="email" class="form-control px-3" name="user_email" data-form-field="Email" placeholder="Email" required="true" id="name-header15-p">
                    </div>
                </div>
                <div data-for="user_pass">
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
				
                <span class="input-group-btn">
					<button href="" type="submit" class="btn btn-primary btn-form display-4" style="width: 100%">LOGIN</button>
					<a href="/booking/forgot-password" class="" style="color: yellow;">Forgot Password</a>
				</span>
            </form>
        </div>
    </div>
    </div>
</div>
    </div>
    
</section>

<?php
} else {
?>

<section class="cid-qOTOTVrHzg mbr-parallax-background" id="header15-p">

    

    <div class="mbr-overlay" style="opacity: 0.5; background-color: rgb(7, 59, 76);"></div>

    <div class="container align-right">
<div class="row">
    <div class="mbr-white col-lg-7 col-md-7 content-container">
        <h1 class="mbr-section-title mbr-bold pb-3 mbr-fonts-style display-1">Welcome Back</h1>
        
    </div>
    <div class="col-lg-5 col-md-5">
    <div class="form-container">
        <div class="media-container-column" data-form-type="formoid">
                
			<div class="mbr-white">
				<h2 class="mbr-section-title mbr-bold pb-3 mbr-fonts-style display-6"><?php echo $user->user_name; ?></h2>
			</div>
                
            <span class="input-group-btn">
				<a href="/booking/logout/<?php echo $event->code; ?>" class="btn btn-primary btn-form display-4">PROFILE</a>
				<a href="/booking/logout/<?php echo $event->code; ?>" class="btn btn-secondary btn-form display-4">LOGOUT</a>
			</span>
			
        </div>
    </div>
    </div>
</div>
    </div>
    
</section>

<?php


include_once('buy_ticket.php');

}
?>