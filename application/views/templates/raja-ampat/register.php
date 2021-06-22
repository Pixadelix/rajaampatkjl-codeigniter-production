<a name="registration"></a>

<?php
if ( ! $user ) {
?>

<section class="cid-qOTOTVrHzg mbr-fullscreen mbr-parallax-background" id="header15-p">
    <div class="mbr-overlay" style="opacity: 0.4; background-color: rgb(228, 210, 149);"></div>
    <div class="container align-right">
	
        <div class="row justify-content-center">
            <div class="title col-12 col-lg-8">
                <h2 class="mbr-section-title align-center pb-3 mbr-fonts-style display-2">
                    Registration</h2>
                <h3 class="mbr-section-subtitle align-center mbr-light pb-3 mbr-fonts-style display-5">
                    Please complete the data</h3>
            </div>
			<?php
			$errors = validation_errors();
			if ( $errors ) {
			?>
			<div class="form-error col-12 col-lg-8"><?php echo trim($errors); ?></div>	
			<?php
			}
			?>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="media-container-column col-lg-8" data-form-type="formoid">
                    
            
                    <form class="mbr-form" action="/booking/register/<?php echo $event->code;  ?>#registration" method="post">
                        <div class="row row-sm-offset">
                            <div class="col-md-12 multi-horizontal" data-for="username">
                                <div class="form-group">
                                    <label class="form-control-label mbr-fonts-style display-7" for="username">Name</label>
                                    <input type="text" class="form-control" name="username" data-form-field="Name" required="" id="username" value="<?php echo set_value('username'); ?>">
                                </div>
                            </div>
                            <div class="col-md-12 multi-horizontal" data-for="email">
                                <div class="form-group">
                                    <label class="form-control-label mbr-fonts-style display-7" for="email">Email</label>
                                    <input type="email" class="form-control" name="email" data-form-field="Email" required="" id="email" value="<?php echo set_value('email'); ?>">
                                </div>
                            </div>
                            <div class="col-md-6 multi-horizontal" data-for="phone">
                                <div class="form-group">
                                    <label class="form-control-label mbr-fonts-style display-7" for="phone">Phone</label>
                                    <input type="tel" class="form-control" name="phone" data-form-field="Phone" id="phone" value="<?php echo set_value('phone'); ?>">
                                </div>
                            </div>
							<div class="col-md-6 multi-horizontal" data-for="company_name">
                                <div class="form-group">
                                    <label class="form-control-label mbr-fonts-style display-7" for="company_name">Company</label>
                                    <input type="text" class="form-control" name="company_name" data-form-field="Company" id="company_name" value="<?php echo set_value('company_name'); ?>">
                                </div>
                            </div>
							<div class="col-md-6 multi-horizontal" data-for="password">
                                <div class="form-group">
                                    <label class="form-control-label mbr-fonts-style display-7" for="password">Password</label>
                                    <input type="password" class="form-control" name="password" data-form-field="Password" id="password">
                                </div>
                            </div>
							<div class="col-md-6 multi-horizontal" data-for="retype_password">
                                <div class="form-group">
                                    <label class="form-control-label mbr-fonts-style display-7" for="retype_password">Confirm Password</label>
                                    <input type="password" class="form-control" name="retype_password" data-form-field="Phone" id="retype_password">
                                </div>
                            </div>
                        </div>
                        <span class="input-group-btn">
                            <button href="" type="submit" class="btn btn-primary btn-form display-4">REGISTER NOW</button>
                        </span>
                    </form>
            </div>
        </div>
    </div>
</section>

<?php
}
?>

