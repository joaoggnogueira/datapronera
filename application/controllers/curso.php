<?php 
	
class Curso extends CI_Controller {

	public function __construct() {
        parent::__construct(); 

        $this->load->database();		 // Loading Database 
        $this->load->library('session'); // Loading Session
        $this->load->helper('url'); 	 // Loading Helper
        
		$this->load->model('curso_m');
		$this->load->model('responsavel_m');
		$this->load->model('caracterizacao_m');
		$this->load->model('instituicao_m');
    }

	function index() {

    	$this->session->set_userdata('curr_content', 'cadastro_curso');
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

	function index_add() {

		$curso['id'] = 0;

    	$this->session->set_userdata('curr_content', 'formulario_cad_curso');
    	$this->session->set_userdata('curr_top_menu', 'menus/principal.php');

    	$data['content'] = $this->session->userdata('curr_content');		
		//$data['top_menu'] = $this->session->userdata('curr_top_menu');

		$valores['curso'] = $curso;
		$valores['operacao'] =  $this->input->post('operacao');

		$html = array(
			'content' => $this->load->view($data['content'], $valores, true)
			//'top_menu' => $this->load->view($data['top_menu'], '', true)
		);

		$response = array(
			'success' => true,
			'html' => $html
		);

		echo json_encode($response);
	}

	function index_update() {
		
		$curso['id'] = $this->input->post('id_curso');
		
		if ($dados = $this->curso_m->get_record($curso['id'])) {

			$this->session->set_userdata('curr_content', 'formulario_cad_curso');
	    	$this->session->set_userdata('curr_top_menu', 'menus/principal.php');

	    	$data['content'] = $this->session->userdata('curr_content');		
			//$data['top_menu'] = $this->session->userdata('curr_top_menu');

			$valores['dados'] = $dados;
			$valores['curso'] = $curso;
			$valores['operacao'] =  $this->input->post('operacao');

			$html = array(
				'content' => $this->load->view($data['content'], $valores, true)
				//'top_menu' => $this->load->view($data['top_menu'], '', true)
			);

			$response = array(
				'success' => true,
				'html' => $html
			);

		}  else {

			$response = array(
				'success' => false,
				'message' => 'Falha na requisição, tente novamente em instantes'
			);
		}

		echo json_encode($response);
	}

	function add() {

		// Starts transaction
		$this->db->trans_begin();

		if ($this->input->post('modalidade') == 'OUTRA') {

			$modalidade = array(
				'nome' => trim($this->input->post('modalidade_descricao')),
				'descricao' => null,
				'nivel' => null
			);

			// Inserts course's genre
			$id_modalidade = $this->curso_m->add_record_modalidade($modalidade);

		} else {
			$id_modalidade = $this->input->post('modalidade');
		}

		$curso = array(
			'nome' => trim($this->input->post('nome')),
			'ativo_inativo' => 'A',
			'status' => 'AN',
			'id_superintendencia' => $this->input->post('superintendencia'),
			'id_pesquisador' => 
				(strlen($this->input->post('pesquisador')) > 0 ?
					$this->input->post('pesquisador') : NULL),
			'id_modalidade' => $id_modalidade,
                        'data' => $this->input->post('data'),
			'obs' => null
		);

		// Inserts a new course
		if ($inserted_id = $this->curso_m->add_record($curso)) {

			$responsavel = array(
				'id_curso' => $inserted_id
			);	

			// Inserts a new form 1
			if ($this->responsavel_m->add_record($responsavel)) {

				$caracterizacao = array(
					'id_curso' => $inserted_id
				);

				// Inserts a new form 2
				if ($this->caracterizacao_m->add_record($caracterizacao)) {

					$instituicao = array(
						'id_curso' => $inserted_id
					);

					// Inserts a new form 5
					if ($this->instituicao_m->add_record($instituicao)) {

						if ($this->db->trans_status() !== false) {

							$this->log->save("CURSO ADICIONADO: ID '".$inserted_id."'");

							$this->db->trans_commit();

							$this->session->set_userdata('curr_content', 'cadastro_curso');
					    	$this->session->set_userdata('curr_top_menu', 'menus/principal.php');

					    	$data['content'] = $this->session->userdata('curr_content');		
							//$data['top_menu'] = $this->session->userdata('curr_top_menu');

							$html = array(
								'content' => $this->load->view($data['content'], '', true)
								//'top_menu' => $this->load->view($data['top_menu'], '', true)
							);

							$response = array(
								'success' => true,
								'html'    => $html,
								'message' => 'Cadastro efetuado com sucesso'
							);

						} else {
				
							$this->db->trans_rollback();

							$response = array(
								'success' => false,
								'message' => 'Falha ao efetuar cadastro'
							);
						}

					} else {
				
						$this->db->trans_rollback();

						$response = array(
							'success' => false,
							'message' => 'Falha ao efetuar cadastro'
						);
					}

				} else {
				
					$this->db->trans_rollback();

					$response = array(
						'success' => false,
						'message' => 'Falha ao efetuar cadastro'
					);
				}

			} else {
				
				$this->db->trans_rollback();

				$response = array(
					'success' => false,
					'message' => 'Falha ao efetuar cadastro'
				);
			}

		} else {
				
			$this->db->trans_rollback();

			$response = array(
				'success' => false,
				'message' => 'Falha ao efetuar cadastro'
			);
		}

		echo json_encode($response);
	}

	function update() {

		// Starts transaction
		$this->db->trans_begin();

		if ($this->input->post('modalidade') == 'OUTRA') {

			$modalidade = array(
				'nome' => trim($this->input->post('modalidade_descricao')),
				'descricao' => null,
				'nivel' => null
			);

			// Inserts course's genre
			$id_modalidade = $this->curso_m->add_record_modalidade($modalidade);

		} else {
			$id_modalidade = $this->input->post('modalidade');
		}

		$curso = array(
			'nome' => trim($this->input->post('nome')),
			'ativo_inativo' => 'A',
			'id_superintendencia' => $this->input->post('superintendencia'),
			'id_pesquisador' => $this->input->post('pesquisador'),
			'id_modalidade' => $id_modalidade,
                        'data' => $this->input->post('data')
		);

		if ($this->curso_m->update_record($curso, $this->input->post('id_curso'))) {

			if ($this->db->trans_status() !== false) {

				$this->log->save("CURSO ATUALIZADO: ID '".$this->input->post('id_curso')."'");

				$this->db->trans_commit();

				$this->session->set_userdata('curr_content', 'cadastro_curso');
		    	$this->session->set_userdata('curr_top_menu', 'menus/principal.php');

		    	$data['content'] = $this->session->userdata('curr_content');		
				//$data['top_menu'] = $this->session->userdata('curr_top_menu');

				$html = array(
					'content' => $this->load->view($data['content'], '', true)
					//'top_menu' => $this->load->view($data['top_menu'], '', true)
				);

				$response = array(
					'success' => true,
					'html'    => $html,
					'message' => 'Cadastro atualizado com sucesso'
				);

			} else {
	
				$this->db->trans_rollback();

				$response = array(
					'success' => false,
					'message' => 'Falha ao atualizar cadastro'
				);
			}

		} else {
	
			$this->db->trans_rollback();

			$response = array(
				'success' => false,
				'message' => 'Falha ao atualizar cadastro'
			);
		}

		echo json_encode($response);
	}

	function deactivate() {

		if ($this->curso_m->toggle_record($this->input->post('id_curso'), 'I')) {

			$this->log->save("CURSO DESATIVADO: ID '".$this->input->post('id_curso')."'");

			$this->session->set_userdata('curr_content', 'cadastro_curso');
	    	$this->session->set_userdata('curr_top_menu', 'menus/principal.php');

	    	$data['content'] = $this->session->userdata('curr_content');		
			//$data['top_menu'] = $this->session->userdata('curr_top_menu');

			$html = array(
				'content' => $this->load->view($data['content'], '', true)
				//'top_menu' => $this->load->view($data['top_menu'], '', true)
			);

			$response = array(
				'success' => true,
				'html'    => $html,
				'message' => 'Cadastro desativado com sucesso'
			);

		} else {

			$response = array(
				'success' => false,
				'message' => 'Falha ao desativar cadastro'
			);
		}

		echo json_encode($response);
	}

	function reactivate() {

		if ($this->curso_m->toggle_record($this->input->post('id_curso'), 'A')) {

			$this->log->save("CURSO REATIVADO: ID '".$this->input->post('id_curso')."'");

			$this->session->set_userdata('curr_content', 'cadastro_curso');
	    	$this->session->set_userdata('curr_top_menu', 'menus/principal.php');

	    	$data['content'] = $this->session->userdata('curr_content');		
			//$data['top_menu'] = $this->session->userdata('curr_top_menu');

			$html = array(
				'content' => $this->load->view($data['content'], '', true)
				//'top_menu' => $this->load->view($data['top_menu'], '', true)
			);

			$response = array(
				'success' => true,
				'html'    => $html,
				'message' => 'Cadastro reativado com sucesso'
			);

		} else {

			$response = array(
				'success' => false,
				'message' => 'Falha ao reativar cadastro'
			);
		}

		echo json_encode($response);
	}

	function toogle_status($status) {

		if ($status == 'AN') {

			$course = $this->input->post('id_curso');
			$msg_log = "CURSO REABILITADO PARA CADASTRO: ID '".$course."'";

			$msg_success = "Cadastro reabilitado com sucesso";
			$msg_error = "Falha ao reabilidar cadastro";

		} else {

			$course = $this->session->userdata('id_curso');
			$msg_log = "CADASTRO DE CURSO FINALIZADO: ID '".$course."'";

			$msg_success = "Cadastro de curso finalizado com sucesso";
			$msg_error = "Falha ao finalizar cadastro de curso";
		}

		if ($this->curso_m->toogle_status($course, $status)) {

			$this->log->save($msg_log);

			$this->session->set_userdata('curr_content', 'cursos');
	    	$this->session->set_userdata('curr_top_menu', 'menus/principal.php');
	    	$this->session->set_userdata('curr_course_info', 'blank.php');

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
				'html'    => $html,
				'message' => $msg_success
			);

		} else {

			$response = array(
				'success' => false,
				'message' => $msg_error
			);
		}

		echo json_encode($response);
	}
}