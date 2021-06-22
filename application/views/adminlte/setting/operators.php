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

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1><?php echo isset($PAGE_TITLE) ? $PAGE_TITLE : 'Blank page'; ?> 
		<small>List of Operators</small></h1>
		<?php echo isset($bread) ? $bread : null; ?>
	</section>
	<!-- Main content -->
	<section class="content">
		<!-- Default box -->
		<div class="box box-solid box-danger crowded-box">
			<div class="box-header with-border">
				<h3 class="box-title">Operators</h3>
				<div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
			</div>
			<div class="box-body">
                <table id="operators-editor" class="display table table-condensed table-striped table-hover table-bordered" data-page-length="25" style="width:100%">
                </table>
            </div>
			<div class="box-footer">List of operators.</div>
		</div>
    </section>
</div>