<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1><?php echo isset($PAGE_TITLE) ? $PAGE_TITLE : 'Blank page'; ?> 
		<small>PDF Generator</small></h1>
		<?php echo isset($bread) ? $bread : null; ?>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-lg-6">
				<div class="box box-danger">
					<div class="box-header with-border">
						<h3 class="box-title">Paramaters</h3>
					</div>

					<div class="box-body">
						<div class="form-group">
							<label> </label>
						</div>

						<div class="form-group">
							<div class="row-margin">
								<div class="col-xs-12">
									<input id="start-from" class="slider form-control"
										type="text"
										style="width:100%;"
										data-slider-handle="custom"
										data-slider-min="0"
										data-slider-max="30000"
										data-slider-step="100"
										data-slider-value="[0, 3000]"
										data-slider-orientation="horizontal"
										data-slider-selection="before"
										data-slider-tooltip="always">
								</div>
							</div>
						</div>
					</div>
					
					<div class="box-body">
						<div class="form-group">
							<p class="help-block">Due to limited resource, maximum span range for generating PDF is set to 3000 document numbers (ex: 5000-8000).</p>
						</div>
					</div>

					<div class="box-footer">
						<button id="btn-generate-ticket-numbers" type="submit" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Generate</button>
					</div>

				</div>
			</div>
		</div>
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<style>
.slider .slider-selection {
	background: rgba(255, 150, 150, 1);
}

.slider-handle.custom {
	background: white;
}

.slider-handle.custom::before {
	font: normal normal normal 14px/1 FontAwesome;
	line-height: 20px;
	font-size: 25px;
	content: '\f1c1';
}
.slider-handle.min-slider-handle.custom::before {
	color: gray;
}
.slider-handle.max-slider-handle.custom::before {
	color: red;
}
</style>

