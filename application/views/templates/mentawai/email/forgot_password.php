<?php

$CI =& get_instance();

?>

<html>
<body>
	<h1><?php echo sprintf(lang('email_forgot_password_heading'), $email);?></h1>
	<p><?php echo sprintf(lang('email_forgot_password_subheading'), anchor('/booking/reset-password/'. $forgotten_password_code.'/'.$CI->getEvent()->code, lang('email_forgot_password_link')));?></p>
</body>
</html>