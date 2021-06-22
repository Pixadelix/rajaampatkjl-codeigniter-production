<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1><?php echo isset($PAGE_TITLE) ? $PAGE_TITLE : 'Blank page'; ?> 
		<small>List of Sequences</small></h1>
		<?php echo isset($bread) ? $bread : null; ?>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="box box-solid box-danger crowded-box">
			<div class="box-header with-border">
				<h3 class="box-title">Sequence</h3>
				<div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
			</div>
			<div class="box-body">
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4><i class="icon fa fa-exclamation-triangle"></i> WARNING!</h4>
					FOR ADVANCED USERS ONLY PLEASE DO NOT USE UNLESS YOU KNOW WHAT YOU ARE DOING.
				</div>
                <table id="sequence-editor" class="display table table-condensed table-striped table-hover table-bordered" data-page-length="25" style="width:100%">
                </table>
            </div>
			<div class="box-footer">
				<p class="text-muted well well-sm no-shadow"><strong>Hint</strong>: Adjust sequence current value for desired value.</p>
			</div>
		</div>
    </section>
</div>