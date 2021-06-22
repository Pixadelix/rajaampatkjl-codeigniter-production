<style>
#ticket-sales-form {
    display: flex;
    flex-flow: row wrap;
}
 
#ticket-sales-form fieldset {
    flex: 2;
}
 
#ticket-sales-form fieldset.full {
    flex: 3 100%;
}
</style>

<!-- script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /-->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1><?php echo isset($PAGE_TITLE) ? $PAGE_TITLE : 'Blank page'; ?> 
		<small>Registered Visitors</small></h1>
		<?php echo isset($bread) ? $bread : null; ?>
	</section>
	<!-- Main content -->
	<section class="content">
		<!-- Default box -->

		<div class="box box-info box-solid">
			<div class="box-header with-border">
				<h3 class="box-title">Query Parameter</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="box-body crowded-box">
				
				<div class="form-group">
					<label class=" control-label nowrap">Date Range</label>
					<input id="dates" name="dates" class="form-control" style="width: 100%" data-placeholder="Date Range">
					<small class="form-text text-muted">note: max. date range is 31 days.</small>
				</div>
				

			</div>
			<div class="box-footer">
				<button id="btn-go" class="btn btn-app btn-flat"><i class="fa fa-database"></i>Run Query</button>
			</div>
		</div>

		<div class="box box-solid box-success crowded-box">
			<div class="box-header with-border">
				<h3 class="box-title">Registered Visitors</h3>
				<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
				</div>
			</div>
			<div class="box-body full">
				<table id="ticket-sales-editor" class="table-crowded display table table-condensed table-striped table-hover table-bordered" data-page-length="25" style="width:100%">
					<?php /*<thead>
						<tr>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
						</tr>
					</tbody>
					<tfoot></tfoot>
					*/?>
					</table>
				</div>
			<div class="box-footer">List of registered visitors.</div>
		</div>
		
	</section>
</div>
