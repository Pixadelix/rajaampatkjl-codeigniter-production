<?php namespace Model\Cd;

namespace Model\Cd;

use \Gas\Core;
use \Gas\ORM;

class Appusers extends ORM {
	
	public $table = 'cd_appusers';
	
	public $primary_key = 'id';
	
	public $foreign_key = array(
		
	);
	
	public static $CI = null;
	
	function _init() {

		self::$relationships = array(
		);
		
		self::$fields = array(
			'id'                      => ORM::field('auto'),
			'email'                   => ORM::field('string'),
			'forgotten_password_code' => ORM::field('string'),
			'forgotten_password_time' => ORM::field('timestamp'),

		);

		// initialize hash method options (Bcrypt)
		self::$CI =& get_instance();
		self::$CI->hash_method    = self::$CI->config->item('hash_method', 'ion_auth');
		self::$CI->default_rounds = self::$CI->config->item('default_rounds', 'ion_auth');
		self::$CI->random_rounds  = self::$CI->config->item('random_rounds', 'ion_auth');
		self::$CI->min_rounds     = self::$CI->config->item('min_rounds', 'ion_auth');
		self::$CI->max_rounds     = self::$CI->config->item('max_rounds', 'ion_auth');
		self::$CI->store_salt     = self::$CI->config->item('store_salt', 'ion_auth');
		self::$CI->salt_length    = self::$CI->config->item('salt_length', 'ion_auth');
		
		$params['salt_prefix'] = self::$CI->config->item('salt_prefix', 'ion_auth');
		self::$CI->load->library('bcrypt', $params);
	}
	
	public function forgotten_password() {
		return $this->forgotten_password2();
	}
	
	public function forgotten_password2() {
		
		// All some more randomness
		$activation_code_part = "";
		if(function_exists("openssl_random_pseudo_bytes")) {
			$activation_code_part = openssl_random_pseudo_bytes(128);
		}

		for($i=0;$i<1024;$i++) {
			$activation_code_part = sha1($activation_code_part . mt_rand() . microtime());
		}

		$key = $this->hash_code($activation_code_part.$this->email);
		
		// preg_quote() in PHP 5.3 escapes -, so the str_replace() and addition of - to preg_quote() is to maintain backwards
		// compatibility as many are unaware of how characters in the permitted_uri_chars will be parsed as a regex pattern
		if ( ! preg_match("|^[".str_replace(array('\\-', '\-'), '-', preg_quote(self::$CI->config->item('permitted_uri_chars'), '-'))."]+$|i", $key)) {
			$key = preg_replace("/[^".self::$CI->config->item('permitted_uri_chars')."]+/i", "-", $key);
		}
		
		$this->forgotten_password_code = $key;
		$this->forgotten_password_time = time();

		if ( $this->save(true) ) {

			self::$CI->load->config('booking', true);
			#die(var_dump(self::$CI->config->item('email_templates', 'booking').self::$CI->config->item('email_forgot_password', 'booking')));
			
			$data = array(
				'email'                   => $this->email,
				'forgotten_password_code' => $this->forgotten_password_code
			);
			
			//die(var_dump(self::$CI->config->item('admin_email', 'ion_auth'), self::$CI->config->item('site_title', 'ion_auth')));
			$message = self::$CI->load->view(self::$CI->config->item('email_templates', 'booking').self::$CI->config->item('email_forgot_password', 'booking'), $data, true);
			self::$CI->email->clear();
			self::$CI->email->from(self::$CI->config->item('admin_email', 'ion_auth'), self::$CI->config->item('site_title', 'ion_auth'));
			self::$CI->email->to($this->email);
			self::$CI->email->subject(self::$CI->config->item('site_title', 'ion_auth') . ' - ' . self::$CI->lang->line('email_forgotten_password_subject'));
			self::$CI->email->message($message);

			if (self::$CI->email->send()) {
				#$this->set_message('forgot_password_successful');
				return true;
			} else {
				#$this->set_error('forgot_password_unsuccessful');
				return false;
			}

		} else {
			return false;
		}
		
	}
	
	
	public function hash_code($password)
	{
		#return $password;
		return $this->hash_password($password, FALSE, TRUE);
	}
	
	public function hash_password($password, $salt=false, $use_sha1_override=FALSE)
	{
		if (empty($password)) {
			return FALSE;
		}

		// bcrypt
		if ($use_sha1_override === FALSE && self::$CI->hash_method == 'bcrypt') {
			return self::$CI->bcrypt->hash($password);
		}

		if (self::$CI->store_salt && $salt) {
			return  sha1($password . $salt);
		} else {
			$salt = salt();
			return  $salt . substr(sha1($salt . $password), 0, self::$CI->salt_length);
		}
	}
}
