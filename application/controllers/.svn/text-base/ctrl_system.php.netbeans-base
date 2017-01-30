<?php

class Ctrl_system extends CI_Controller {

	function load_html($_file, $_elem, $_subfolder = null) {

		if (isset($_subfolder)) $_subfolder .= "/";

		$data[$_elem] = $_subfolder.$_file.'.php';
		$html = $this->load->view($data[$_elem], '', true);

		$this->session->set_userdata('curr_'.$_elem, $data[$_elem]);

		echo $html;
	}
}