<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1><?php echo isset($PAGE_TITLE) ? $PAGE_TITLE : 'Blank page'; ?> 
		<small>Report</small></h1>
		<?php echo isset($bread) ? $bread : null; ?>
	</section>
	<!-- Main content -->
	<section class="content">
		<!-- Default box -->
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo (isset($TITLE)) ? $TITLE : 'Report Data'; ?></h3>
				<div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
			</div>
			<div class="box-body crowded-box">
				<div class="input-group margin">
					<span class="input-group-addon bg-red">Year</span>
					<select id="select-year" class="form-control select2" style="width: 100%;" data-placeholder="Please choose a desired Year">
					</select>
					<span class="input-group-btn">
						<button id="btn-go" type="button" class="btn btn-info btn-flat">Go !</button>
					</span>
				</div>
			
				<div class="row">
					<div class="col-lg-6">
						<table id="report-datatable" class="table-crowded display table table-condensed table-striped table-hover table-bordered" data-page-length="10" style="width:100%">
							<tfoot>
								<tr>
									<th class="text-right">Total:</th>
									<th id="report-total" class="text-right roboto-mono"></th>
									<th></th>
								</tr>
							</tfoot>
						</table>
					</div>
					<div class="col-lg-6">
						<div class="chart chart-container">
							<canvas id="canvas-report-chart" style="height:600px"></canvas>
						</div>
					</div>
				</div>
			</div>
			
			<div class="box-footer"></div>
			
		</div>
		<!-- /.box -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
