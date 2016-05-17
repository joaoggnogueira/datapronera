<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CI_System {

	var $CI;

	public function __construct() {

		$this->CI =& get_instance();
	}

	public function is_logged_in() {

		$is_logged_in = $this->CI->session->userdata('is_logged_in');

		if (isset($is_logged_in) && $is_logged_in) {
			return true;
		}

		return false;
	}
}