<!DOCTYPE html>
<html lang="en">
 	<head>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="">
	    <meta name="author" content="">

	    <link rel="icon" type="image/png" href="<?php echo base_url('/images/favicon.ico'); ?>">

	    <title>
	    	<?php
	    		$this->lang->load('ps', 'english');
	    		echo $this->lang->line('site_title');
	    	?>
	    </title>

	    <!-- Bootstrap core CSS -->
	    <link href="<?php echo base_url('css/bootstrap.min.css');?>" rel="stylesheet">

	    <!-- Custom styles for this template -->
		 <link href="<?php echo base_url('fonts/ptsan/stylesheet.css');?>" rel="stylesheet">
	    <link href="<?php echo base_url('css/dashboard.css');?>" rel="stylesheet">
	    
	    
	    <!-- Placed at the end of the document so the pages load faster -->
	    <script src="<?php echo base_url('js/jquery.js');?>"></script>
	    <script src="<?php echo base_url('js/bootstrap.min.js');?>"></script>
	    <script src="<?php echo base_url('js/dashboard.js');?>"></script>
	    <script src="<?php echo base_url('js/jquery.validate.js');?>"></script>

	    <?php $this->load->view( 'analytic' ); ?>
	</head>

	<?php $this->load->view( 'ads' ); ?>

  	<body background="<?php echo base_url('images/cd-bg-img.jpg'); ?>">
		<div class='fluid-container'>
			<div class='row'>
				<div class='col-sm-4 col-sm-offset-4'>

	        		<?php
	        		$attributes = array('id' => 'login-form','method' => 'POST');
	        		echo form_open('/login', $attributes);
	        		?>

						<h2>
						<label class="login-title">
						Cities Directory
						</label>
						</h2>
						<hr/>
						<?php if( null != $this->session->flashdata('success')):?>
							<div class='alert alert-success fade in'>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<?php echo $this->session->flashdata('success');?>
							</div>
						<?php elseif( null != $this->session->flashdata('error')):?>
							<div class='alert alert-danger fade in'>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<?php echo $this->session->flashdata('error');?>
							</div>							
						<?php endif;?>
						
						<div class="form-group">
							<label><font color="#fff">Email Address</font></label>
							<?php 
								echo form_input( array(
									'type' => 'text',
									'name' => 'user_email',
									'id' => 'inputEmail',
									'class' => 'form-control',
									'placeholder' => 'Email Address',
									'value' => ''
								));
							?>
						</div>
						
						<div class="form-group">
							<label><font color="#fff">Password</font></label>
							<input class="form-control" type="password" id="inputPassword" placeholder="Password" name='user_pass'>
						</div>
						
						<button class="btn btn-primary" type="submit">Sign in</button>
										
					<?php echo form_close();  ?>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function(){
			$('#login-form').validate({
				rules:{
					user_email: {
						required: true,
						// email: true
					},
					user_pass: "required"
				},
				messages:{
					user_email: {
						required: "Please fill username",
						// email: "Invalid Email Address"
					},
					user_pass: "Please fill password"
				}
			});
		});
	</script>
  </body>
</html>