<style>
.map-container{
    height: 400px;
}

.jvmap-smart{
    width: 100%; 
    height: 100%;  
}
.text-center{
    text-align:center;
    font-weight: 300;
    font-size: 2rem;
}
.map-container:after, .clearfix{
    display: block;
    content: '';
    clear: both;
}
.roboto-mono, .text-smaller {
	font-size: smaller;
}
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo isset($PAGE_TITLE) ? $PAGE_TITLE : 'Blank page'; ?>
            <small>it all starts here</small></h1>
        <?php echo isset($bread) ? $bread : null; ?>
    </section>
    <!-- Main content -->
    <section class="content">

        <div class="row">
            <section class="col-lg-7 connectedSortable ui-sortable">
				<div class="row">
					<div class="col-md-6">
						<div class="small-box bg-green">
							<div class="inner">
								<h3><?php echo isset($today_ticket_sales) ? $today_ticket_sales : 0; ?></h3>
								<p>Ticket sold today</p>
							</div>
							<div class="icon"><i class="fa fa-ticket"></i></div>
							<a href="/ticket/sale" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
						</div>
					</div>
					<div class="col-md-6">
						<div class="small-box bg-aqua">
							<div class="inner">
								<h3><?php echo isset($this_month_ticket_sales) ? $this_month_ticket_sales : 0; ?></h3>
								<p>Ticket sold this month</p>
							</div>
							<div class="icon"><i class="fa fa-ticket"></i></div>
							<a href="/ticket/sale" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
						</div>
					</div>
					
				</div>
				
				
				
				<div>
					<div class="box box-primary crowded-box">
						<div class="box-header with-border">
							<h3 class="box-title">Visitor per Countries by Year</h3>
							<div class="box-tools pull-right">
								<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								<!--button type="button" class="btn btn-box-tool btn-sm yearrange pull-right" data-toggle="tooltip" title="Date range">
									<i class="fa fa-calendar"></i>
								</button-->
							</div>
						</div>
						<div class="box-body">
							<div class="form-group">
								<label>Year</label>
								<select id="select-year-visitor-by-country" class="form-control select2" style="width: 100%;">
									<!--option selected="selected">2018</option>
									<option>2017</option-->
								</select>
							</div>
							<table id="country-datatable" class="table-crowded display table table-condensed table-striped table-hover table-bordered" data-page-length="10" style="width:100%">
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
						<div id="btn-year-container" class="box-footer">

						</div>
					</div>
				</div>

            </section>
			
			<section class="col-lg-5 connectedSortable ui-sortable">

				
				
				<div class="box box-solid bg-light-blue-gradient">
                    <div class="box-header">
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <!--button type="button" class="btn btn-primary btn-sm daterange pull-right" data-toggle="tooltip" title="Date range">
                  <i class="fa fa-calendar"></i></button-->
                            <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
                  <i class="fa fa-minus"></i></button>
                        </div>
                        <!-- /. tools -->

                        <i class="fa fa-map-marker"></i>

                        <h3 class="box-title">
                            All Time Visitors Mapping
                        </h3>
                    </div>
                    <div class="box-body">
						<div class="map-container">
                        	<div id="world-map" class="jvmap-smart" tyle="min-height: 300px; height: 300px; width: 100%;"></div>
						</div>
                    </div>
                    <!-- /.box-body-->
                    <div class="box-footer no-border">
                        <div id="sparkline" class="row">
                            <!--div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                                <div id="sparkline-1"></div>
                                <div class="knob-label">2017</div>
                            </div>
                            <!-- ./col -->
                            <!--div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                                <div id="sparkline-2"></div>
                                <div class="knob-label">2018</div>
                            </div>
                            <!-- ./col -->
                            
                            <!-- ./col -->
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
                <!-- /.box -->

				<div class="">
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Visitors per Month by Year</h3>
							<div class="box-tools pull-right">
								<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
							</div>
						</div>
						<div class="box-body">
							<div class="chart chart-container">
								<canvas id="salesPerMonth" style="height:300px"></canvas>
							</div>
						</div>
					</div>
				</div>
            </section>
        </div>
    </section>

</div>
