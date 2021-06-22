<?php
global $root_assets_path;

$root_assets_path = isset($event->template) ? '/assets/static/templates/'.$event->template_path.'/' : '/assets/static/templates/booking-default/';

?>

<!DOCTYPE html>
<html >
<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="generator" content="MEDIAVISTA, mediavista.id">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <meta name="description" content="">
  <title><?php echo $PAGE_TITLE; ?></title>
  <link rel="stylesheet" href="<?php echo $root_assets_path;?>assets/web/assets/mobirise-icons/mobirise-icons.css">
  <link rel="stylesheet" href="<?php echo $root_assets_path;?>assets/tether/tether.min.css">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
  <!--link rel="stylesheet" href="<?php echo $root_assets_path;?>assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $root_assets_path;?>assets/bootstrap/css/bootstrap-grid.min.css">
  <link rel="stylesheet" href="<?php echo $root_assets_path;?>assets/bootstrap/css/bootstrap-reboot.min.css"-->
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
  .form-error {
	  color: #fe9090;
	  padding: 20px;
	  margin-bottom: 40px;
	  background-color: rgba(0,0,0,0.5);
  }
  span.input-group-btn a.btn,
  span.input-group-btn button.btn {
	  border-radius: 100px;
  }
  text-monospace {
	  font-family: monospace;
  }


  .cid-qOTKi1gC8V .navbar-dropdown.bg-color.transparent.opened {
	  background: #fafafa;
  }

  </style>
  
</head>
<body>

