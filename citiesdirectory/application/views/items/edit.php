			<?php
			$this->lang->load('ps', 'english');
			?>
			<ul class="breadcrumb">
				<li><a href="<?php echo site_url() . "/dashboard";?>"><?php echo $this->lang->line('dashboard_label')?></a> <span class="divider"></span></li>
				<li><a href="<?php echo site_url('items');?>"><?php echo $this->lang->line('item_list_label')?></a> <span class="divider"></span></li>
				<li><?php echo $this->lang->line('update_item_label')?></li>
			</ul>
			<div class="wrapper wrapper-content animated fadeInRight">
			<?php
			$attributes = array('id' => 'item-form','enctype' => 'multipart/form-data');
			echo form_open(("items/edit/".$item->id), $attributes);	
			
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
										'value' => html_entity_decode( $item->name )
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
								<?php
									foreach($this->category->get_all($this->city->get_current_city()->id)->result() as $cat){
										echo "<option value='".$cat->id."'";
										if($item->cat_id == $cat->id) 
											echo " selected ";
										echo ">".$cat->name."</option>";
									}
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
								<?php
									foreach($this->sub_category->get_all_by_cat_id($item->cat_id)->result() as $sub_cat){
										echo "<option value='".$sub_cat->id."'";
										if($item->sub_cat_id == $sub_cat->id) 
											echo " selected ";
										echo ">".$sub_cat->name."</option>";
									}
								?>
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
										'value' => html_entity_decode( $item->phone )
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
										'value' => html_entity_decode( $item->email )
									));
								?>
							</div>
							
							<div class="form-group">
								<label><?php echo $this->lang->line('description_label')?> 
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('item_description_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<textarea class="form-control" name="description" placeholder="<?php echo $this->lang->line('description_label')?>" rows="8"><?php echo $item->description;?></textarea>
							</div>
							
							<div class="form-group">
								<label><?php echo $this->lang->line('item_address_label')?> 
									<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('address_tooltips')?>">
										<span class='glyphicon glyphicon-info-sign menu-icon'>
									</a>
								</label>
								<textarea class="form-control" name="address" placeholder="<?php echo $this->lang->line('address_label')?>" rows="3"><?php echo $item->address;?></textarea>
							</div>
							
							
							<div class="form-group">
								<label><?php echo $this->lang->line('publish_label')?>
								<a href="#" class="tooltip-ps" data-toggle="tooltip" title="<?php echo $this->lang->line('publish_tooltips')?>">
									<span class='glyphicon glyphicon-info-sign menu-icon'>
								</a>
								: 
								</label>
								<?php
									echo form_checkbox("is_published",$item->is_published,$item->is_published);
								 ?>
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
							        		'value' => $item->lat
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
							        		'value' => $item->lng
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
										'id' => 'search_tag',
										'class' => 'form-control',
										'placeholder' => $this->lang->line('search_tag_label'),
										'value' => html_entity_decode( $item->search_tag )
									));
								?>
							</div>
							
					</div>
				</div>
				
				<input type="submit" value="<?php echo $this->lang->line('update_button')?>" class="btn btn-primary"/>
				<a class="btn btn-primary" href="<?php echo site_url('items/gallery/'.$item->id);?>"><?php echo $this->lang->line('goto_gallery_button')?></a>
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
									url: '<?php echo site_url("items/exists/".$item->id);?>',
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
								required: "Please fill item name.",
								minlength: "The length of item name must be greater than 4",
								remote: "item name is already existed in the system"
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
					    location: {latitude: <?php echo $item->lat;?>, longitude: <?php echo $item->lng;?>},
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

