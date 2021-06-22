<?php
$photo = null;
if ( isset($profile->profile_photo) ||$profile->profile_photo ) {
    $photo = Model\Content\Posts::find($profile->profile_photo);
}
?>

<style>
	/* reset form-control height if empty */
	.form-control {
		height: 34px;
	}
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1><?php echo isset($PAGE_TITLE) ? $PAGE_TITLE : 'Blank page'; ?> 
		<small></small></h1>
		<?php echo isset($bread) ? $bread : null; ?>
	</section>
	<!-- Main content -->
	<section class="content" data-editor-id="<?php echo $profile->id; ?>">
		<div class="row">
			<div class="col-md-3">
				<!-- Profile Image -->
				<div class="box box-primary">
					<div class="box-body box-profile">
                        <dd><img data-editor-field="sip_users.profile_photo" class="profile-user-img img-responsive img-circle" src="/<?php echo $photo ? $photo->media_web_path : 'assets/static/img/avatar.jpeg'; ?>" alt="User profile picture"></dd>
						<h3 class="profile-username text-center"><?php echo "$profile->first_name $profile->last_name"; ?></h3>
						<p class="text-muted text-center">
                        </p>
                    </div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
			<!-- /.col -->
			<div class="col-md-9">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						
						
						<?php if ( isset($settings) && $settings ) { ?><li><a href="#settings" data-toggle="tab">Settings</a></li><?php } ?>
					</ul>
					<div class="tab-content">
						<!-- /.tab-pane -->
                        <?php if ( isset($settings) && $settings ) { ?>
						<div class="tab-pane active" id="settings">

						</div>
                        <?php } ?>
						<!-- /.tab-pane -->
					</div>
					<!-- /.tab-content -->
				</div>
				<!-- /.nav-tabs-custom -->
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->