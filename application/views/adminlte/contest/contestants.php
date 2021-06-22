<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1><?php echo isset($PAGE_TITLE) ? $PAGE_TITLE : 'Blank page'; ?> 
		<small></small></h1>
		<?php echo isset($bread) ? $bread : null; ?>
	</section>
	<!-- Main content -->
	<section class="content">
		<!-- Default box -->
		<div class="box box-solid box-warning crowded-box">
			<div class="box-header with-border">
				<h3 class="box-title">Contests</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="box-body full">
				<table id="contests-editor" class="table-crowded display table table-condensed table-striped table-hover table-bordered" data-page-length="25" style="width:100%">
				</table>
			</div>
		</div>
		
		<!-- Default box -->
		<div class="box box-solid box-success crowded-box">
			<div class="box-header with-border">
				<h3 class="box-title">Data</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="box-body full">
				<table id="contestants-editor" class="table-crowded display table table-condensed table-striped table-hover table-bordered" data-page-length="25" style="width:100%">
				</table>
			</div>
			<div class="box-footer">List of contestants.</div>
		</div>
	</section>
</div>
