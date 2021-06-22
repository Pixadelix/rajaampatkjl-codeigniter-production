<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class RA_Exceptions extends CI_Exceptions {
	
	private $CI;

	function __construct() {
		parent::__construct();

		$this->CI =& get_instance();
		$this->CI->data['PAGE_TITLE'] = 'An Error has occured';
		$this->CI->data['DEFAULT_PAGE_TITLE'] = PROJECT_NAME;
	}

	public function show_error($heading, $message, $template = '/adminlte/errors/html/error_general', $status_code = 500) {
		if ( is_cli() ) {
			return parent::show_error($heading, $message, $template, $status_code);
		}
		$ci = $this->CI;
		
		if(!$ci) {
			return parent::show_error($heading, $message, $template, $status_code);
		} else {
			if (!$page = $ci->uri->uri_string()) {
				$page = 'home';
			}
            
            $mode = is_cli() ? 'errors/cli' : 'adminlte/errors/html';
			
			switch($status_code) {
				case 403:
					$heading = 'Access Forbidden';
					$template = "$mode/error_general";
					//$template = "matrix_error_general";
					break;
				case 404:
					$heading = 'Page Not Found';
					$template = "$mode/error_404";
					//$template = "matrix_error_404";
					break;
				case 422:
					$heading = 'Unprocessable Entity';
					$template = "$mode/error_general";
					//$template = "matrix_error_general";
					break;
				case 500:
					$heading = 'What? What did I just say?';
					$template = "$mode/error_500";
					//$template = "matrix_error_500";
					break;
				case 503:
					$heading = 'Undergoing Maintenance';
					$template = "$mode/error_general";
					//$template = "matrix_error_general";
					break;
				default:
					$heading = 'Error';
					$template = "$mode/error_500";
					//$template = "matrix_error_500";
					break;
			}
			
			log_message('error', $status_code . ' ' . $heading . ' --> '. $page);

			if(is_array($message)) {
				$message = '<p>'.implode('</p><p>', $message).'</p>';
			}

			$ci->data['status_code'] = $status_code;
			$ci->data['heading'] = $heading;
			$ci->data['message'] = $message;
		
			$theme = 'adminlte';
			
			//ob_start();
			//include(VIEWPATH.'adminlte/matrix/meta_header.php');
			//include(VIEWPATH.$template);
			//include(VIEWPATH.'adminlte/matrix/meta_footer.php');
			//$buffer = ob_get_contents();
			//ob_end_clean();
			//echo $buffer;
			//return;
			return parent::show_error($heading, $message, $template, $status_code);
		}

		
        return parent::show_error($heading, $message, 'error_general', $status_code);
		
	}


	public function show_404($page = '', $log_error = TRUE) {
		//var_dump($this);die;
		//$this->CI->output->set_status_header('404'); 
		
		//echo $this->CI->load->view("/adminlte/matrix/meta_header", $this->CI->data, true);
		//echo $this->CI->load->view("/adminlte/errors/html/error_404", $this->CI->data, true);
		//echo $this->CI->load->view("/adminlte/matrix/meta_footer", $this->CI->data, true);
		
		ob_start();
		include(VIEWPATH.'/adminlte/matrix/meta_header.php');
		include(VIEWPATH.'/adminlte/errors/html/404.php');
		include(VIEWPATH.'/adminlte/matrix/meta_footer.php');
		$buffer = ob_get_contents();
		ob_end_clean();
		echo $buffer;
		
	}
}

?>
