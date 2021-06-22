<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once(VIEWPATH.'adminlte/matrix/meta_header.php');

?>

<style>
h1 { font-size: 25px; }
p { font-size: 20px; }
</style>
  
<body>
	<div class="matrix-page"><div class="matrix-overlay"></div></div>

	<div class="login-box">
		<div class="login-logo">
			<a><h1 class="link_me"><?php echo $heading; ?></h1></a>
		</div>
		<p><?php echo $message; ?></p>
	</div>
	
</body>

<?php

include_once(VIEWPATH.'adminlte/matrix/meta_footer.php');

?>