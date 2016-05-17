<?php

	class Ctrl_curso extends CI_Controller {

		public function __construct() {
	        parent::__construct(); 

	        $this->load->database();		 // Loading Database 
	        $this->load->library('session'); // Loading Session
	        $this->load->helper('url'); 	// Loading Helper
	    }

	    public function index() {

	    	$this->session->set_userdata('curr_content', 'cursos');
	    	$this->session->set_userdata('curr_top_menu', 'menus/principal.php');

	    	$data['content'] = $this->session->userdata('curr_content');		
	    	//$data['top_menu'] = $this->session->userdata('curr_top_menu');

	    	$html = array(
				'content' => $this->load->view($data['content'], '', true)
				//'top_menu' => $this->load->view($data['top_menu'], '', true)
			);

			$response = array(
				'success' => true,
				'html' => $html
			);

			echo json_encode($response);
	    }

	    public function back() {

	    	$this->session->set_userdata('curr_content', 'cursos');
	    	$this->session->set_userdata('curr_top_menu', 'menus/principal.php');
	    	$this->session->set_userdata('curr_course_info', 'blank.php');
	    	$this->session->set_userdata('id_curso', null);
	    	$this->session->set_userdata('status_curso', null);

	    	$data['content'] = $this->session->userdata('curr_content');		
	    	$data['top_menu'] = $this->session->userdata('curr_top_menu');
	    	$data['course_info'] = $this->session->userdata('curr_course_info');

	    	$html = array(
				'content' => $this->load->view($data['content'], '', true),
				'top_menu' => $this->load->view($data['top_menu'], '', true),
				'course_info' => $this->load->view($data['course_info'], '', true)
			);

			$response = array(
				'success' => true,
				'html' => $html
			);

			echo json_encode($response);
	    }
	}