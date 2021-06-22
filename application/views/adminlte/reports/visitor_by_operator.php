
<style>
	.select2-selection {
		min-height: 34px !important;
/*		max-height: 34px !important;
/*		overflow: auto; */
	}
</style>

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
		<div class="box box-info box-solid">
			<div class="box-header with-border">
				<h3 class="box-title">Query Parameter</h3>
				<div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
			</div>
			<div class="box-body crowded-box">

				<div class="input-group margin-bottom">
					<span class="input-group-addon alert-info">Year</span>
					<select id="select-year" class="form-control select2" tyle="width: 100%;" data-placeholder="Please choose a desired Year">
					</select>
				</div>
				<div class="input-group margin-bottom">
					<span class="input-group-addon alert-info">Country</span>
					<?php
					$ci =& get_instance();
					$countries = $ci->db->query('select id as country_id, concat("[", coalesce(code, "--"), "] ", name) as country_name from sys_countries where name != "" or code != "" or name is not null or code is not null order by name asc')->result_array();

					//var_dump($countries); die;
					//$opts = array('*' => '* All Country');
					$opts = array_column($countries, 'country_name', 'country_id');
					//var_dump($opts); die;

					echo form_dropdown(
						'country[]', $opts, null,
						array(
							'id' => 'select-country',
							'class' => 'form-control select2',
							//'style' => 'width: 100%;',
							'data-placeholder' => 'Filter by Country',
							'data-allow-clear' => 'true',
							'data-close-on-select' => 'false',
							'multiple' => 'multiple',
						)
						//'id="select-country" class="form-control select2" style="width: 100%;" data-placeholder="Please choose a Country"'
					);
					?>
				</div>
			</div>
			<div class="box-footer">
				<button id="btn-table" class="btn btn-app"><i class="fa fa-database"></i>Run Query</button>
			</div>
		</div>
		<div class="box box-success box-solid">
			<div class="box-header with-border">
				<h3 class="box-title">Data</h3>
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
					<canvas id="canvas-report-chart" style="height:450px"></canvas>
				</div>
			</div>

		</div>
				
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
