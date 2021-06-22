			<?php
			$this->lang->load('ps', 'english');
			?>
			<ul class="breadcrumb">
				<li><a href="<?php echo site_url(). "/dashboard";?>"><?php echo $this->lang->line('dashboard_label')?></a> <span class="divider"></span></li>
				<li><a href="<?php echo site_url('items');?>"><?php echo $this->lang->line('item_list_label')?></a> <span class="divider"></span></li>
				<li><?php echo $this->lang->line('add_new_item_button')?></li>
			</ul>
			<div class="wrapper wrapper-content animated fadeInRight">
			<?php
			$attributes = array('id' => 'item-form','enctype' => 'multipart/form-data');
			echo form_open(('items/add'), $attributes);
			?>
				<legend><?php echo $this->lang->line('item_info_label')?></legend>

				<?php $this->load->view( 'flash_message' ); ?>
					
				<div class="row">
					<div class="col-sm-6">
							<div class="form-group">
								<label><?php echo $this->lang->line('item_name_label')?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('item_name_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'name',
										'id' => 'name',
										'class' => 'form-control',
										'placeholder' => $this->lang->line('item_name_label'),
										'value' => ''
									));
								?>
							</div>
							
							<div class="form-group">
								<label><?php echo $this->lang->line('cat_label')?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('cat_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<select class="form-control" name="cat_id" id="cat_id">
								<option><?php echo $this->lang->line('select_cat_message')?></option>
								<?php
									$categories = $this->category->get_all($this->city->get_current_city()->id);
									foreach($categories->result() as $cat)
										echo "<option value='".$cat->id."'>".$cat->name."</option>";
								?>
								</select>
							</div>
							
							<div class="form-group">
								<label><?php echo $this->lang->line('sub_cat_label')?>
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('sub_cat_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<select class="form-control" name="sub_cat_id" id="sub_cat_id">
									<option><?php echo $this->lang->line('select_sub_cat_message')?></option>
								</select>
							</div>

							<div class="form-group">
								<label><?php echo $this->lang->line('phone_label')?> 
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('phone_tooltips')?>">
								    	<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'phone',
										'id' => '',
										'class' => 'form-control',
										'placeholder' => $this->lang->line('phone_label'),
										'value' => ''
									));
								?>
							</div>

							<div class="form-group">
								<label><?php echo $this->lang->line('email_label')?> 
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('email_tooltips')?>">
								    	<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'email',
										'id' => '',
										'class' => 'form-control',
										'placeholder' => $this->lang->line('email_label'),
										'value' => ''
									));
								?>
							</div>
							
							<div class="form-group">
								<label><?php echo $this->lang->line('description_label')?> 
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('item_description_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<textarea class="form-control" name="description" placeholder="<?php echo $this->lang->line('description_label')?>" rows="8"></textarea>
							</div>
							
							<div class="form-group">
								<label><?php echo $this->lang->line('item_address_label')?> 
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('address_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<textarea class="form-control" name="address" placeholder="<?php echo $this->lang->line('item_address_label')?>" rows="3"></textarea>
							</div>

														
					</div>
					
					<div class="col-sm-6">
							
							<div class="form-group">
						        <label><?php echo $this->lang->line('find_location_label')?>
						        	<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('find_location_tooltips')?>">
						        		<span class='glyphicon glyphicon-info-sign menu-icon'>
						        	</a>
						        </label><br>
						
						        <?php 
						        	echo form_input( array(
						        		'type' => 'text',
						        		'name' => 'find_location',
						        		'id' => 'find_location',
						        		'class' => 'form-control',
						        		'placeholder' => 'Type & Find Location',
						        		'value' => ''
						        	));
						        ?>
						    </div>
						    
						    <div id="us3" style="width: 550px; height: 300px;"></div>
						    <div class="clearfix">&nbsp;</div>
						    <div class="m-t-small">
						        <div class="form-group">
							        <label><?php echo $this->lang->line('city_lat_label')?>
							        	<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('city_lat_tooltips')?>">
							        		<span class='glyphicon glyphicon-info-sign menu-icon'>
							        	</a>
							        </label>
									<br>
							        <?php 
							        	echo form_input( array(
							        		'type' => 'text',
							        		'name' => 'lat',
							        		'id' => 'lat',
							        		'class' => 'form-control',
							        		'placeholder' => '',
							        		'value' => ''
							        	));
							        ?>
						        </div>
						        
						        <div class="form-group">
							        <label><?php echo $this->lang->line('city_lng_label')?>
							        	<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('city_lng_tooltips')?>">
							        		<span class='glyphicon glyphicon-info-sign menu-icon'>
							        	</a>
							        </label><br>
							        <?php 
							        	echo form_input( array(
							        		'type' => 'text',
							        		'name' => 'lng',
							        		'id' => 'lng',
							        		'class' => 'form-control',
							        		'placeholder' => '',
							        		'value' => ''
							        	));
							        ?>
						        </div>
						    </div>
							
							
							<div class="form-group">
								<label><?php echo $this->lang->line('search_tag_label')?> 
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('search_tag_tooltips')?>">
								    	<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<?php 
									echo form_input( array(
										'type' => 'text',
										'name' => 'search_tag',
										'id' => '',
										'class' => 'form-control',
										'placeholder' => $this->lang->line('search_tag_label'),
										'value' => ''
									));
								?>
							</div>
					</div>
				</div>
				
				<input type="submit" name="save" value="<?php echo $this->lang->line('save_button')?>" class="btn btn-primary"/>
				<input type="submit" name="gallery" value="<?php echo $this->lang->line('save_go_button')?>" class="btn btn-primary"/>
				<a href="<?php echo site_url('items');?>" class="btn btn-primary"><?php echo $this->lang->line('cancel_button')?></a>
			</form>
			</div>
			<script>
			$(document).ready(function(){
				$('#item-form').validate({
					rules:{
						name:{
							required: true,
							minlength: 4,
							remote: {
								url: '<?php echo site_url("items/exists");?>',
					        	type: "GET",
					        	data: {
					        		name: function () {
					        			return $('#name').val();
					        		},
					          	sub_cat_id: function() {
					          		return $('#sub_cat_id').val();
					          	}
					        	}
							}
						},
						unit_price: {
							number: true
						}
					},
					messages:{
						name:{
							required: "Please fill item Name.",
							minlength: "The length of item Name must be greater than 4",
							remote: "Item Name is already existed in the system"
						},
						unit_price: {
							number: "Only number is allowed."
						}
					}
				});
				
				$('#cat_id').change(function(){
					var catId = $(this).val();
					$.ajax({
						url: '<?php echo site_url('items/get_sub_cats');?>/'+catId,
						method: 'GET',
						dataType: 'JSON',
						success:function(data){
							$('#sub_cat_id').html("");
							$.each(data, function(i, obj){
							    $('#sub_cat_id').append('<option value="'+ obj.id +'">' + obj.name + '</option>');
							});
							$('#name').val($('#name').val() + " ").blur();
						}
					});
				});
				
				$('#sub_cat_id').on('change', function(){
					$('#name').val($('#name').val() + " ").blur();
				});
				
				$(function () { $("[data-toggle='tooltip']").tooltip(); });
				
				$('#us3').locationpicker({
				    location: {latitude: 0.0, longitude: 0.0},
				    radius: 300,
				    inputBinding: {
				        latitudeInput: $('#lat'),
				        longitudeInput: $('#lng'),
				        radiusInput: $('#us3-radius'),
				        locationNameInput: $('#find_location')
				    },
				    enableAutocomplete: true,
				    onchanged: function (currentLocation, radius, isMarkerDropped) {
				        // Uncomment line below to show alert on each Location Changed event
				        //alert("Location changed. New location (" + currentLocation.latitude + ", " + currentLocation.longitude + ")");
				    }
				});
				
			});
			</script>

