
  <script src="<?php echo $root_assets_path;?>assets/web/assets/jquery/jquery.min.js"></script>
  <script src="<?php echo $root_assets_path;?>assets/popper/popper.min.js"></script>
  <script src="<?php echo $root_assets_path;?>assets/tether/tether.min.js"></script>
  <!--script src="<?php echo $root_assets_path;?>assets/bootstrap/js/bootstrap.min.js"></script-->
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
  <script src="<?php echo $root_assets_path;?>assets/smoothscroll/smooth-scroll.js"></script>
  <script src="<?php echo $root_assets_path;?>assets/dropdown/js/script.min.js"></script>
  <script src="<?php echo $root_assets_path;?>assets/playervimeo/vimeo_player.js"></script>
  <!--script src="<?php echo $root_assets_path;?>assets/ytplayer/jquery.mb.ytplayer.min.js"></script-->
  <!--script src="<?php echo $root_assets_path;?>assets/vimeoplayer/jquery.mb.vimeo_player.js"></script-->
  <script src="<?php echo $root_assets_path;?>assets/parallax/jarallax.min.js"></script>
  <!--script src="<?php echo $root_assets_path;?>assets/countdown/jquery.countdown.min.js"></script-->
  <script src="<?php echo $root_assets_path;?>assets/touchswipe/jquery.touch-swipe.min.js"></script>
  <script src="<?php echo $root_assets_path;?>assets/theme/js/script.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
  
<?php
echo enqueued_scripts();
echo enqueued_resources();
?>

<script>
$("#country-form1-w").select2();
<?php
if ( isset ( $order_dtl ) && $order_dtl->country_code ) {
?>
$("#country-form1-w").val('<?php echo $order_dtl->country_code; ?>').trigger('change');
<?php
} else {
?>
$("select").select2("val", null);
<?php
}
?>
</script>
	<script src="<?php echo $root_assets_path;?>assets/cookies-alert-plugin/cookies-alert-core.js"></script>
	<script src="<?php echo $root_assets_path;?>assets/cookies-alert-plugin/cookies-alert-script.js"></script>
	<input name="cookieData" type="hidden" data-cookie-text="We use cookies to give you the best experience. Read our <a href='/privacy-policy'>cookie policy</a>.">
</body>
</html>
