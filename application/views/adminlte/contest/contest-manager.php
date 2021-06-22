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
						<h3 class="box-title">Contest Manager</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="box-body">
						<form method="post" action="/contest/dashboard/upload" enctype="multipart/form-data">
							<?php
								if ( isset($upload_status) ) {
									echo is_array($upload_status) ? implode('<br/>', $upload_status) : $upload_status;
								}
							?>
							<div class="form-group">
							  <label for="exampleInputFile">Upload Contest CSV Data</label>
							  <input type="file" name="csv">
							  <p class="help-block">Please upload downloaded csv from Google Form</p>
							  <button type="submit" class="btn btn-primary">Submit</button>
							</div>
						</form>
						
						<table id="contests-editor" class="table-crowded display table table-condensed table-striped table-hover table-bordered" data-page-length="25" style="width:100%">
						</table>
						
					</div>
				</div>
				
				<!-- Default box -->
				<div class="box box-solid box-info crowded-box">
					<div class="box-header with-border">
						<h3 class="box-title">Questions Manager</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="box-body">
						<table id="questions-editor" class="table-crowded display table table-condensed table-striped table-hover table-bordered" data-page-length="25" style="width:100%">
						</table>
						
					</div>
				</div>
			</div>
			
			<div class="col-md-6">
				<!-- Default box -->
				<div class="box box-solid box-success crowded-box">
					<div class="box-header with-border">
						<h3 class="box-title">Contestants</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="box-body full">
						<table id="score-summary-editor" class="table-crowded display table table-condensed table-striped table-hover table-bordered" data-page-length="25" style="width:100%">
						</table>
					</div>
					<div class="box-footer">List of contestants.</div>
				</div>
			</div>
		</div>
		
		
	</section>
</div>


<div id="questions-form">
	
		
	
    <fieldset class="">
		<editor-field name="cts_questions.score_min"></editor-field>
		<editor-field name="cts_questions.score_step"></editor-field>
		
		<editor-field name="cts_questions.q02_scoring"></editor-field>
		<editor-field name="cts_questions.q04_scoring"></editor-field>
		<editor-field name="cts_questions.q06_scoring"></editor-field>
		<editor-field name="cts_questions.q08_scoring"></editor-field>
		<editor-field name="cts_questions.q10_scoring"></editor-field>
		<editor-field name="cts_questions.q12_scoring"></editor-field>
		<editor-field name="cts_questions.q14_scoring"></editor-field>
		<editor-field name="cts_questions.q16_scoring"></editor-field>
		<editor-field name="cts_questions.q18_scoring"></editor-field>
		<editor-field name="cts_questions.q20_scoring"></editor-field>
		<editor-field name="cts_questions.q22_scoring"></editor-field>
		<editor-field name="cts_questions.q24_scoring"></editor-field>
		<editor-field name="cts_questions.q26_scoring"></editor-field>
		<editor-field name="cts_questions.q28_scoring"></editor-field>
		<editor-field name="cts_questions.q30_scoring"></editor-field>
		
		<editor-field name="cts_questions.q32_scoring"></editor-field>
		<editor-field name="cts_questions.q34_scoring"></editor-field>
		<editor-field name="cts_questions.q36_scoring"></editor-field>
		<editor-field name="cts_questions.q38_scoring"></editor-field>
		<editor-field name="cts_questions.q40_scoring"></editor-field>

		<editor-field name="cts_questions.q42_scoring"></editor-field>
		<editor-field name="cts_questions.q44_scoring"></editor-field>
		<editor-field name="cts_questions.q46_scoring"></editor-field>
		<editor-field name="cts_questions.q48_scoring"></editor-field>
		<editor-field name="cts_questions.q50_scoring"></editor-field>
		
		<editor-field name="cts_questions.q52_scoring"></editor-field>
		<editor-field name="cts_questions.q54_scoring"></editor-field>
		<editor-field name="cts_questions.q56_scoring"></editor-field>
		<editor-field name="cts_questions.q58_scoring"></editor-field>
		<editor-field name="cts_questions.q60_scoring"></editor-field>
		
		<editor-field name="cts_questions.q62_scoring"></editor-field>
		<editor-field name="cts_questions.q64_scoring"></editor-field>
		<editor-field name="cts_questions.q66_scoring"></editor-field>
		<editor-field name="cts_questions.q68_scoring"></editor-field>
		<editor-field name="cts_questions.q70_scoring"></editor-field>
		
		<editor-field name="cts_questions.q72_scoring"></editor-field>
		<editor-field name="cts_questions.q74_scoring"></editor-field>
		<editor-field name="cts_questions.q76_scoring"></editor-field>
		<editor-field name="cts_questions.q78_scoring"></editor-field>
		<editor-field name="cts_questions.q80_scoring"></editor-field>
		
		<editor-field name="cts_questions.q82_scoring"></editor-field>
		<editor-field name="cts_questions.q84_scoring"></editor-field>
		<editor-field name="cts_questions.q86_scoring"></editor-field>
		<editor-field name="cts_questions.q88_scoring"></editor-field>
		<editor-field name="cts_questions.q90_scoring"></editor-field>
		
		<editor-field name="cts_questions.q92_scoring"></editor-field>
		<editor-field name="cts_questions.q94_scoring"></editor-field>
		<editor-field name="cts_questions.q96_scoring"></editor-field>
		<editor-field name="cts_questions.q98_scoring"></editor-field>
		<editor-field name="cts_questions.q100_scoring"></editor-field>
		
		<editor-field name="cts_questions.q102_scoring"></editor-field>
		<editor-field name="cts_questions.q104_scoring"></editor-field>
		<editor-field name="cts_questions.q106_scoring"></editor-field>
		<editor-field name="cts_questions.q108_scoring"></editor-field>
		<editor-field name="cts_questions.q110_scoring"></editor-field>
		<editor-field name="cts_questions.q112_scoring"></editor-field>
		<editor-field name="cts_questions.q114_scoring"></editor-field>
		<editor-field name="cts_questions.q116_scoring"></editor-field>
		<editor-field name="cts_questions.q118_scoring"></editor-field>
		<editor-field name="cts_questions.q120_scoring"></editor-field>
	</fieldset>
	<fieldset class="">
		<editor-field name="cts_questions.score_max"></editor-field>
		
		<editor-field name="cts_questions.q01_scoring"></editor-field>
		<editor-field name="cts_questions.q03_scoring"></editor-field>
		<editor-field name="cts_questions.q05_scoring"></editor-field>
		<editor-field name="cts_questions.q07_scoring"></editor-field>
		<editor-field name="cts_questions.q09_scoring"></editor-field>
		<editor-field name="cts_questions.q11_scoring"></editor-field>
		<editor-field name="cts_questions.q13_scoring"></editor-field>
		<editor-field name="cts_questions.q15_scoring"></editor-field>
		<editor-field name="cts_questions.q17_scoring"></editor-field>
		<editor-field name="cts_questions.q19_scoring"></editor-field>
		<editor-field name="cts_questions.q21_scoring"></editor-field>
		<editor-field name="cts_questions.q23_scoring"></editor-field>
		<editor-field name="cts_questions.q25_scoring"></editor-field>
		<editor-field name="cts_questions.q27_scoring"></editor-field>
		<editor-field name="cts_questions.q29_scoring"></editor-field>
		
		<editor-field name="cts_questions.q31_scoring"></editor-field>
		<editor-field name="cts_questions.q33_scoring"></editor-field>
		<editor-field name="cts_questions.q35_scoring"></editor-field>
		<editor-field name="cts_questions.q37_scoring"></editor-field>
		<editor-field name="cts_questions.q39_scoring"></editor-field>
		
		<editor-field name="cts_questions.q41_scoring"></editor-field>
		<editor-field name="cts_questions.q43_scoring"></editor-field>
		<editor-field name="cts_questions.q45_scoring"></editor-field>
		<editor-field name="cts_questions.q47_scoring"></editor-field>
		<editor-field name="cts_questions.q49_scoring"></editor-field>
		
		<editor-field name="cts_questions.q51_scoring"></editor-field>
		<editor-field name="cts_questions.q53_scoring"></editor-field>
		<editor-field name="cts_questions.q55_scoring"></editor-field>
		<editor-field name="cts_questions.q57_scoring"></editor-field>
		<editor-field name="cts_questions.q59_scoring"></editor-field>
		
		<editor-field name="cts_questions.q61_scoring"></editor-field>
		<editor-field name="cts_questions.q63_scoring"></editor-field>
		<editor-field name="cts_questions.q65_scoring"></editor-field>
		<editor-field name="cts_questions.q67_scoring"></editor-field>
		<editor-field name="cts_questions.q69_scoring"></editor-field>
		
		<editor-field name="cts_questions.q71_scoring"></editor-field>
		<editor-field name="cts_questions.q73_scoring"></editor-field>
		<editor-field name="cts_questions.q75_scoring"></editor-field>
		<editor-field name="cts_questions.q77_scoring"></editor-field>
		<editor-field name="cts_questions.q79_scoring"></editor-field>
		
		<editor-field name="cts_questions.q81_scoring"></editor-field>
		<editor-field name="cts_questions.q83_scoring"></editor-field>
		<editor-field name="cts_questions.q85_scoring"></editor-field>
		<editor-field name="cts_questions.q87_scoring"></editor-field>
		<editor-field name="cts_questions.q89_scoring"></editor-field>
		
		<editor-field name="cts_questions.q91_scoring"></editor-field>
		<editor-field name="cts_questions.q93_scoring"></editor-field>
		<editor-field name="cts_questions.q95_scoring"></editor-field>
		<editor-field name="cts_questions.q97_scoring"></editor-field>
		<editor-field name="cts_questions.q99_scoring"></editor-field>
		
		<editor-field name="cts_questions.q101_scoring"></editor-field>
		<editor-field name="cts_questions.q103_scoring"></editor-field>
		<editor-field name="cts_questions.q105_scoring"></editor-field>
		<editor-field name="cts_questions.q107_scoring"></editor-field>
		<editor-field name="cts_questions.q109_scoring"></editor-field>
		<editor-field name="cts_questions.q111_scoring"></editor-field>
		<editor-field name="cts_questions.q113_scoring"></editor-field>
		<editor-field name="cts_questions.q115_scoring"></editor-field>
		<editor-field name="cts_questions.q117_scoring"></editor-field>
		<editor-field name="cts_questions.q119_scoring"></editor-field>
    </fieldset>
</div>

<style>
#questions-form {
    display: flex;
    flex-flow: row wrap;
}

#questions-form fieldset {
    flex: 1;
    -border: 1px solid #aaa;
    -margin: 0.5em;
}
</style>