<?php
defined('BASEPATH') OR exit('No direct script access allowed');

defined('APP_VERSION') OR define('APP_VERSION', '0.1.0-beta');

defined('PROJECT_NAME') OR define('PROJECT_NAME', 'Event');
defined('DEFAULT_CONTROLLER') OR define('DEFAULT_CONTROLLER', 'ticketing');
defined('LOGGED_IN_REDIRECT') OR define('LOGGED_IN_REDIRECT', '/ticket');
defined('COVER_WELCOME_PAGE') OR define('COVER_WELCOME_PAGE', '/assets/static/img/event.jpg');
defined('COVER_LOGIN_PAGE') OR define('COVER_LOGIN_PAGE', '/assets/static/img/event.jpg');
defined('LOGO_300') OR define('LOGO_300', '/assets/static/img/logo-200x50.png');
defined('LOGO_50') OR define('LOGO_50', '/assets/static/img/logo-50x50.png');
setlocale(LC_MONETARY, 'id_ID.UTF-8');
defined('PAID_AMT_D') OR define('PAID_AMT_D', 500000);
defined('CONTRIBUTION_D') OR define('CONTRIBUTION_D', trim(preg_replace('/\s+/', ' ', money_format('%= -#8.0n', PAID_AMT_D)).',- (Lima Ratus Ribu Rupiah)'));
defined('PAID_AMT_I') OR define('PAID_AMT_I', 1000000);
defined('CONTRIBUTION_I') OR define('CONTRIBUTION_I', trim(preg_replace('/\s+/', ' ', money_format('%= -#8.0n', PAID_AMT_I)).',- (One Million Rupiah)'));
defined('COPYRIGHT') OR define('COPYRIGHT', 'PT Tanair Media Seruni (MEDIAVISTA)');
$app_logo = "
    ______               ______
   / ____/   _____  ____/_  __/
  / __/ | | / / _ \/ __ \/ /   
 / /___ | |/ /  __/ / / / /    
/_____/ |___/\___/_/ /_/_/     

";
//http://patorjk.com/software/taag/#p=display&f=Slant&t=EvenT
defined('APP_LOGO') OR define('APP_LOGO', $app_logo);
defined('APP_CSS') OR define('APP_CSS', 'event.css');
defined('PDF_CLASS_PATH') OR define('PDF_CLASS_PATH', 'event');

defined('DE_VERSION') OR define('DE_VERSION', '1.7.0');

/* Type Message */
defined('TYPE_MESSAGE_ERROR')   OR define('TYPE_MESSAGE_ERROR',   'message_error');
defined('TYPE_MESSAGE_WARNING') OR define('TYPE_MESSAGE_WARNING', 'message_warning');
defined('TYPE_MESSAGE_SUCCESS') OR define('TYPE_MESSAGE_SUCCESS', 'message_success');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code
