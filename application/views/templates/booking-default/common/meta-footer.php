
  <script src="<?php echo $root_assets_path;?>assets/web/assets/jquery/jquery.min.js"></script>
  <script src="<?php echo $root_assets_path;?>assets/popper/popper.min.js"></script>
  <script src="<?php echo $root_assets_path;?>assets/tether/tether.min.js"></script>
  <!--script src="<?php echo $root_assets_path;?>assets/bootstrap/js/bootstrap.min.js"></script-->
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
  <script src="<?php echo $root_assets_path;?>assets/smoothscroll/smooth-scroll.js"></script>
  <script src="<?php echo $root_assets_path;?>assets/dropdown/js/script.min.js"></script>
  <script src="<?php echo $root_assets_path;?>assets/playervimeo/vimeo_player.js"></script>
  <script src="<?php echo $root_assets_path;?>assets/ytplayer/jquery.mb.ytplayer.min.js"></script>
  <script src="<?php echo $root_assets_path;?>assets/vimeoplayer/jquery.mb.vimeo_player.js"></script>
  <script src="<?php echo $root_assets_path;?>assets/parallax/jarallax.min.js"></script>
  <script src="<?php echo $root_assets_path;?>assets/countdown/jquery.countdown.min.js"></script>
  <script src="<?php echo $root_assets_path;?>assets/touchswipe/jquery.touch-swipe.min.js"></script>
  <script src="<?php echo $root_assets_path;?>assets/theme/js/script.js"></script>
  
<?php
echo enqueued_scripts();
echo enqueued_resources();
?>

<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
<script>
window.addEventListener("load", function(){
window.cookieconsent.initialise({
  "palette": {
    "popup": {
      "background": "#000"
    },
    "button": {
      "background": "transparent",
      "text": "#f1d600",
      "border": "#f1d600"
    }
  }
})});
</script>


<!-- Google Tracking Code -->
<script type="text/plain" cookie-consent="tracking">
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', /* Google Property ID */, 'auto');
ga('send', 'pageview');
</script>

</body>
</html>
