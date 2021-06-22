<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1><?php echo isset($PAGE_TITLE) ? $PAGE_TITLE : 'Blank page'; ?> 
		<small>Event & Price Setting</small></h1>
		<?php echo isset($bread) ? $bread : null; ?>
	</section>
	<!-- Main content -->
	<section class="content">
	
		<div class="row">
		<div class="col-md-9">
			<!-- Default box -->
			<div class="box box-solid box-success crowded-box">
				<div class="box-header with-border">
					<h3 class="box-title">Ticket Pricing</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
					</div>
				</div>
				<div class="box-body full">
					<table id="product-events-editor" class="table-crowded display table table-condensed table-striped table-hover table-bordered" data-page-length="25" style="width:100%">
					</table>
				</div>
				<div class="box-footer">List of available events and pricing.</div>
			</div>
		</div>
		
		<div class="col-md-3">
			<!-- Default box -->
			<div class="box box-solid box-info crowded-box">
				<div class="box-header with-border">
					<h3 class="box-title">Taxes Settings</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
					</div>
				</div>
				<div class="box-body">
					<table id="taxes-editor" class="table-crowded display table table-condensed table-striped table-hover table-bordered" data-page-length="25" style="width:100%">
					</table>
				</div>
				<div class="box-footer">List of available taxes and discounts.</div>
			</div>
		</div>
		</div>
	</section>
</div>
