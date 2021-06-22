<?php
global $root_assets_path;

$root_assets_path = $event->template_path ? '/assets/static/templates/'.$event->template_path.'/' : '/assets/static/templates/booking-default/';

?>

<!DOCTYPE html>
<html >
<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
  <meta name="description" content="">
  <title><?php echo $PAGE_TITLE; ?></title>
  <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="<?php echo $root_assets_path;?>assets/web/assets/mobirise-icons/mobirise-icons.css">
  <link rel="stylesheet" href="<?php echo $root_assets_path;?>assets/tether/tether.min.css">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
  <!--link rel="stylesheet" href="<?php echo $root_assets_path;?>assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $root_assets_path;?>assets/bootstrap/css/bootstrap-grid.min.css">
  <link rel="stylesheet" href="<?php echo $root_assets_path;?>assets/bootstrap/css/bootstrap-reboot.min.css"-->
  <link rel="stylesheet" href="<?php echo $root_assets_path;?>assets/gdpr-plugin/gdpr-styles.css">
  <link rel="stylesheet" href="<?php echo $root_assets_path;?>assets/dropdown/css/style.css">
  <link rel="stylesheet" href="<?php echo $root_assets_path;?>assets/socicon/css/styles.css">
  <link rel="stylesheet" href="<?php echo $root_assets_path;?>assets/theme/css/style.css">
  <link rel="stylesheet" href="<?php echo $root_assets_path;?>assets/mobirise/css/mbr-additional.css" type="text/css">
  <link rel="stylesheet" href="/assets/static/css/font-awesome-4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico"/>
  
<?php
echo enqueued_styles();
echo enqueued_style_resources();
?>

<style>

.select2-container--default .select2-selection--single {
	min-height: 3.5em;
	padding-top: 12px;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
	top: 12px;
}
.cid-qOTOTVrHzg .form-container {
	padding: 20px;
	border-radius: 10px;
	/*background: linear-gradient(rgba(6,89,82,05), rgba(2, 25, 26, 0.8));*/
	box-shadow: 5px 10px 18px rgba(0,0,0,.5);
}
</style>
  
</head>
<body>

