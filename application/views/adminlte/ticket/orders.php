<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1><?php echo isset($PAGE_TITLE) ? $PAGE_TITLE : 'Blank page'; ?> 
		<small>Orders & Payments</small></h1>
		<?php echo isset($bread) ? $bread : null; ?>
	</section>
	<!-- Main content -->
	<section class="content">
	
		<div class="row">
			<div class="col-md-12">
				<!-- Default box -->
				<div class="box box-solid box-success crowded-box">
					<div class="box-header with-border">
						<h3 class="box-title">Orders</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="box-body">
						<table id="orders-editor" class="table-crowded display table table-condensed table-striped table-hover table-bordered" data-page-length="25" style="width:100%">
						</table>
					</div>
					<div class="box-footer">List of orders.</div>
				</div>
			</div>
			
			<div class="col-md-4">	
				<!-- Default box -->
				<div class="box box-solid box-danger crowded-box">
					<div class="box-header with-border">
						<h3 class="box-title">Payment</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="box-body">
						<table id="payment-editor" class="table-crowded display table table-condensed table-striped table-hover table-bordered" data-page-length="25" style="width:100%">
						</table>
					</div>
					<div class="box-footer">List of payment.</div>
				</div>
			</div>
			
			<div class="col-md-4">
				<!-- Default box -->
				<div class="box box-solid box-warning crowded-box">
					<div class="box-header with-border">
						<h3 class="box-title">Order details</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="box-body">
						<table id="orders-dtl-editor" class="table-crowded display table table-condensed table-striped table-hover table-bordered" data-page-length="25" style="width:100%">
						</table>
					</div>
					<div class="box-footer">List of order details.</div>
				</div>
			</div>
			
			<div class="col-md-4">	
				<!-- Default box -->
				<div class="box box-solid box-success crowded-box">
					<div class="box-header with-border">
						<h3 class="box-title">Tickets</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="box-body">
						<table id="sales-editor" class="table-crowded display table table-condensed table-striped table-hover table-bordered" data-page-length="25" style="width:100%">
						</table>
					</div>
					<div class="box-footer">List of tickets.</div>
				</div>
			</div>
			
		</div>
	</section>
</div>
