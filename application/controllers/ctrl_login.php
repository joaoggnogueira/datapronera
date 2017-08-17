<?php

class Ctrl_login extends CI_Controller {

	function index() {

		if (! $this->system->is_logged_in()) {
			$data['content'] = 'login.php';
			$data['top_menu'] = 'blank.php';
			$data['course_info'] = 'blank.php';
                        $data['data'] = '';

		} else {
			$data['content'] = $this->session->userdata('curr_content');
			$data['top_menu'] = $this->session->userdata('curr_top_menu');
			$data['course_info'] = $this->session->userdata('curr_course_info');
                        $data['data'] = $this->session->userdata('curr_data');
		}

		$this->load->view('include/template.php', $data);
	}

	function sign_in() {

		$this->load->model('conta'); // Loading Conta Model

		// Checks if account is allowed to sign in on system
		if ($account_data = $this->conta->allow()) {

			// Attempt signing in on system
			if ($this->conta->validate($account_data->senha)) {

				// Extracting first name
				$name = explode(" ", $account_data->nome);

				$user_data = array(
					'name' => $name[0],
					'id' => $account_data->id,
					'cpf' => $this->input->post('cpf'),
					'password' => md5($this->input->post('senha')),
					'email' => $account_data->email,
					'id_funcao' => $account_data->id_funcao,
					'access_level' => $account_data->nivel_acesso,
					'id_superintendencia' => $account_data->id_superintendencia,
					'is_logged_in' => true,
                                        'acesso_publico' => false,
					'curr_content' => 'cursos',
					'curr_top_menu' => 'menus/principal.php',
					'curr_course_info' => 'blank.php',
					'id_curso' => 0
				);

				// Set data array on user session
				$this->session->set_userdata($user_data);

				$this->log->save('LOGIN');

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

			} else {
				$response = array(
					'success' => false,
					'message' => "Senha inválida para o CPF informado"
				);
			}

		} else {
			$response = array(
				'success' => false,
				'message' => "Entrada não autorizada para o CPF informado"
			);
		}

		echo json_encode($response);
	}

	function sign_out() {

		$this->log->save('LOGOUT');

		$this->session->sess_destroy();
		redirect(base_url());
	}
}