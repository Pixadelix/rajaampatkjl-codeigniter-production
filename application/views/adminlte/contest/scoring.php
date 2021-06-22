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
	
		<div class="row">
			<div class="col-md-6">
				<!-- Default box -->
				<div class="box box-solid box-warning crowded-box">
					<div class="box-header with-border">
						<h3 class="box-title">Contest List</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="box-body">
						<table id="contests-editor" class="table-crowded display table table-condensed table-striped table-hover table-bordered" data-page-length="25" style="width:100%">
						</table>
						
					</div>
				</div>
				
				<!-- Default box -->
				<div class="box box-solid box-success crowded-box">
					<div class="box-header with-border">
						<h3 class="box-title">Contestants List</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="box-body">
						<table id="contestants-editor" class="table-crowded display table table-condensed table-striped table-hover table-bordered" data-page-length="25" style="width:100%">
						</table>
					</div>
					<div class="box-footer">List of contestants.</div>
				</div>
				
			</div>
			
			<div class="col-md-6">
				<!-- Default box -->
				<div class="box box-solid box-purple crowded-box">
					<div class="box-header with-border">
						<h3 class="box-title">Scoring</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
						</div>
					</div>
					<div id="score" class="box-body box-comments" style="overflow: auto; height: 700px">
						
						<div class="small-box bg-purple">
							<div class="inner">
								<h3>Contest<sup style="font-size: 20px"></sup>
							</h3>
							<p>Scoring</p>
						</div>
						<div class="icon">
							<i class="fa fa-star"></i>
						</div>
							<a href="#score-editor" class="small-box-footer">
								<i class="fa fa-arrow-circle-left"></i> Please specify a contestant
							</a>
						</div>
					</div>
					<div class="box-footer">
						<button id="submit-score" class="btn btn-warning" style="display: none;"><i class="fa fa-trophy"></i> Submit Score</button>
					</div>
				</div>
				
			</div>
			
		</div>
		
	</section>
</div>




<style>
.row-margin, .box-comment {
	margin-bottom: 20px;
}
#score .slider .slider-selection {
	-background: #2196f3;
	-background: rgba(100,255,100,1);
	background: linear-gradient(to right, rgba(255,255,0,1), rgba(0,255,0,1));
}
#score .slider .slider-rangeHighlight.category1 {
	background: linear-gradient(to right, rgba(255,0,0,.2), rgba(255,255,0,.2));
	border-top-right-radius: 0px;
	border-bottom-right-radius: 0px;
	
}
#score .slider .slider-rangeHighlight.category2 {
	background: linear-gradient(to right, rgba(255,255,0,.2), rgba(0,255,0,.2));
	border-top-left-radius: 0px;
	border-bottom-left-radius: 0px;
}
.slider-handle.custom::before {
	font: normal normal normal 14px/1 FontAwesome;
	line-height: 20px;
	font-size: 25px;
	content: '\f005';
}
.slider-handle.custom::before {
	color: #800;
}
</style>