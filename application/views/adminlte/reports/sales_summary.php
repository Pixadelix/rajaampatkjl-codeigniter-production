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
					<label class=" control-label nowrap">Year</label>
					<select id="select-year" class="form-control select2" style="width: 100%" data-placeholder="Please choose a desired Year">
					</select>
				</div>
				<hr/>
				<div class="row">
					<div class="form-group col-sm-6">
						<label class="control-label nowrap">Domestik (environmental services)</label>
						<input type="number" class="form-control" id="dom" placeholder="Domestik variable" value="425000">
					</div>

					<div class="form-group col-sm-6">
						<label class="control-label">International (environmental services)</label>
						<input type="number" class="form-control" id="intl" placeholder="International variable" value="700000">
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-6">
						<label class="control-label nowrap">Domestik (retribution)</label>
						<input type="number" class="form-control" id="dom2" placeholder="Domestik variable" value="75000">
					</div>

					<div class="form-group col-sm-6">
						<label class="control-label">International (retribution)</label>
						<input type="number" class="form-control" id="intl2" placeholder="International variable" value="300000">
					</div>
				</div>

			</div>
			<div class="box-footer">
				<button id="btn-go" class="btn btn-app btn-flat"><i class="fa fa-database"></i>Run Query</button>
			</div>
		</div>
		
		<div class="box box-success box-solid">
			<div class="box-header with-border">
				<h3 class="box-title">A. Environmental Services</h3>
				<div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
			</div>
			<div class="box-body crowded-box">
				<table id="report-datatable" class="table-crowded display table table-condensed table-striped table-hover table-bordered" data-page-length="10" style="width:100%">
					<tfoot>
						<tr>
							<th class="text-right">Total:</th>
							<th id="jan-total" class="text-right roboto-mono"></th>
							<th id="feb-total" class="text-right roboto-mono"></th>
							<th id="mar-total" class="text-right roboto-mono"></th>
							<th id="apr-total" class="text-right roboto-mono"></th>
							<th id="may-total" class="text-right roboto-mono"></th>
							<th id="jun-total" class="text-right roboto-mono"></th>
							<th id="jul-total" class="text-right roboto-mono"></th>
							<th id="aug-total" class="text-right roboto-mono"></th>
							<th id="sep-total" class="text-right roboto-mono"></th>
							<th id="oct-total" class="text-right roboto-mono"></th>
							<th id="nov-total" class="text-right roboto-mono"></th>
							<th id="dec-total" class="text-right roboto-mono"></th>
							<th id="cnt-total" class="text-right roboto-mono"></th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
		
		<div class="box box-darkred box-solid">
			<div class="box-header with-border">
				<h3 class="box-title">B. Retribution</h3>
				<div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
			</div>
			<div class="box-body crowded-box">
				<table id="report-datatable-2" class="table-crowded display table table-condensed table-striped table-hover table-bordered" data-page-length="10" style="width:100%">
					<tfoot>
						<tr>
							<th class="text-right">Total:</th>
							<th id="jan-total-2" class="text-right monospace"></th>
							<th id="feb-total-2" class="text-right monospace"></th>
							<th id="mar-total-2" class="text-right monospace"></th>
							<th id="apr-total-2" class="text-right monospace"></th>
							<th id="may-total-2" class="text-right monospace"></th>
							<th id="jun-total-2" class="text-right monospace"></th>
							<th id="jul-total-2" class="text-right monospace"></th>
							<th id="aug-total-2" class="text-right monospace"></th>
							<th id="sep-total-2" class="text-right monospace"></th>
							<th id="oct-total-2" class="text-right monospace"></th>
							<th id="nov-total-2" class="text-right monospace"></th>
							<th id="dec-total-2" class="text-right monospace"></th>
							<th id="cnt-total-2" class="text-right monospace"></th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
		
		<div class="box box-warning box-solid">
			<div class="box-header with-border">
				<h3 class="box-title">Chart</h3>
				<div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
			</div>
			<div class="box-body crowded-box">
				<div class="chart chart-container">
					<canvas id="canvas-report-chart" style="height:600px"></canvas>
				</div>
				</div>
			</div>
		</div>
		<!-- /.box -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
