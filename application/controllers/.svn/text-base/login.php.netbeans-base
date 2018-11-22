<?php

class Login extends CI_Controller {

	public function __construct() {
        parent::__construct(); 

        $this->load->database();		 // Loading Database 
        $this->load->library('session'); // Loading Session
        $this->load->helper('url'); // Loading Session
    }

	function index() {

		$data['content'] = 'login.php';

		$this->load->view('include/template.php', $data);
	}

	function sign_in() {

		$this->load->model('conta'); // Loading Conta Model

		// Checks if account is allowed to sign in on system
		if ($this->conta->allow()) {

			// Attempt signing in on system
			if ($this->conta->validate()) {

				$data = array(
					'cpf' => $this->input->post('cpf'),
					'senha' => md5($this->input->post('senha')),
					'logado' => true
				);

				// Set data array on user session
				$this->session->set_userdata($data);

				$response = array(
					"success" => true,
					"message" => null
				);

			} else {
				$response = array(
					"success" => false,
					"message" => "Senha inválida para o CPF informado"
				);
			}

		} else {
			$response = array(
				"success" => false,
				"message" => "Entrada não autorizada para o CPF informado"
			);
		}

		echo json_encode($response);
	}
}