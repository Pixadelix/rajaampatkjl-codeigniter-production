			<?php
			$this->lang->load('ps', 'english');
			?>
			<ul class="breadcrumb">
				<?php
					$city_id = $this->session->userdata('city_id');
					if (isset($city_id) && trim($city_id) != "") {
				?>
						<li><a href="<?php echo site_url('dashboard/index/'. $city_id);?>"><?php echo $this->lang->line('dashboard_label')?></a> <span class="divider"></span></li>
				<?php
					} else {
				?>
						<li><a href="<?php echo site_url('cities');?>"><?php echo $this->lang->line('cities_list_label')?></a> <span class="divider"></span></li>
				<?php
					}
				?>
				
				<li><?php echo $this->lang->line('update_profile_label')?></li>
			</ul>
			<div class="wrapper wrapper-content animated fadeInRight">
				<?php
				$attributes = array('id' => 'user-form');
				echo form_open(('profile'), $attributes);
				?>
					<div class="row">
						<div class="col-sm-6">
							<legend><?php echo $this->lang->line('user_info_label')?></legend>
							
							<!-- Message -->
							<?php if($status == 'success'): ?>
								<div class="alert alert-success fade in">
									<?php echo $message;?>
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								</div>
							<?php elseif($status == 'error'):?>
								<div class="alert alert-danger fade in">
									<?php echo $message;?>
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								</div>
							<?php endif;?>
							
							<div class="form-group">
								<label><?php echo $this->lang->line('username_label')?></label>
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'user_name',
										'id' => 'user_name',
										'class' => 'form-control',
										'placeholder' => 'username',
										'value' => html_entity_decode( $user->user_name )
									));
								?>
							</div>
							
							<div class="form-group">
								<label><?php echo $this->lang->line('email_label')?></label>
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'user_email',
										'id' => 'user_email',
										'class' => 'form-control',
										'placeholder' => 'email',
										'value' => html_entity_decode( $user->user_email )
									));
								?>
							</div>
							
							<div class="form-group">
								<label><?php echo $this->lang->line('password_label')?></label>
								<input class="form-control" type="password" placeholder="password" name='user_password' id='user_password'>
							</div>
										
							<div class="form-group">
								<label><?php echo $this->lang->line('confirm_password_label')?></label>
								<input class="form-control" type="password" placeholder="confirm password" name='conf_password' id='conf_password'>
							</div>
						</div>
						
						<div class="col-sm-6">
							
						</div>
					</div>
								
					
					<hr/>
					
					<button type="submit" class="btn btn-primary"><?php echo $this->lang->line('save_button')?></button>
					<a href="<?php echo site_url('dashboard');?>" class="btn"><?php echo $this->lang->line('cancel_button')?></a>
				</form>
			</div>
			<script>
				$(document).ready(function(){
					$('#user-form').validate({
						rules:{
							user_name:{
								required: true,
								minlength: 4,
								remote: '<?php echo site_url('dashboard/exists/'.$user->user_id);?>'
							},
							user_password:{
								minlength: 4
							},
							conf_password:{
								equalTo: '#user_password'
							}
						},
						messages:{
							user_name:{
								required: "Please fill user name.",
								minlength: "The length of username must be greater than 4",
								remote: "Username is already existed in the system"
							},
							user_password:{
								minlength: "The length of password must be greater than 4"
							},
							conf_password:{
								equalTo: "Password and confirm password do not match."
							}
						}
					});
				});
			</script>