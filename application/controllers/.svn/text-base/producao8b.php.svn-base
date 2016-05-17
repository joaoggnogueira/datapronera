<?php 
	
class Producao8b extends CI_Controller {

	public function __construct() {
        parent::__construct(); 

        $this->load->database();		 // Loading Database 
        $this->load->library('session'); // Loading Session
        $this->load->helper('url'); 	// Loading Helper
        
		$this->load->model('producao8_m');
    }

	function index() {

    	$this->session->set_userdata('curr_content', 'producao8b');
    	$this->session->set_userdata('curr_top_menu', 'menus/cursos.php');

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

		$producao['id'] = 0;

    	$this->session->set_userdata('curr_content', 'formulario_Producao8B');
    	$this->session->set_userdata('curr_top_menu', 'menus/cursos.php');

    	$data['content'] = $this->session->userdata('curr_content');		
		//$data['top_menu'] = $this->session->userdata('curr_top_menu');

		$valores['operacao'] =  $this->input->post('operacao');
		$valores['producao'] = $producao;

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

		$producao['id'] = $this->input->post('id_producao8b');
		
		if ($dados = $this->producao8_m->get_record_producao_trabalho($producao['id'])) {

	    	$this->session->set_userdata('curr_content', 'formulario_Producao8B');
	    	$this->session->set_userdata('curr_top_menu', 'menus/cursos.php');

	    	$data['content'] = $this->session->userdata('curr_content');		
			//$data['top_menu'] = $this->session->userdata('curr_top_menu');

			$valores['dados'] = $dados;
			$valores['producao'] = $producao;
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
		

		$data = array(
			'titulo' => trim($this->input->post('titulo')),
			'tipo' => trim($this->input->post('rtipo')),
			'programa_curso' => trim($this->input->post('programa')),			
			'instituicao' => trim($this->input->post('instituicao')),
			'local_defesa' => trim($this->input->post('local_defesa')),
			'local_estagio' => trim($this->input->post('local_estagio')),
			'ano_defesa' => trim($this->input->post('ano_defesa')),			
			'orientador' => trim($this->input->post('orientador')),
			'formato' => trim($this->input->post('rformato')),
			'disponibilidade' => trim($this->input->post('disponivel')),
			'pagina_web' => trim($this->input->post('pagina_web')),			
			'id_curso' => trim($this->session->userdata('id_curso'))
		);

		// Starts transaction
		$this->db->trans_begin();

		if ($inserted_id = $this->producao8_m->add_record_producao_trabalho($data)) {

			if ($autores = $this->input->post('autores')) {

			    foreach ($autores as $autor) {
					
					$data_author = array(	
						'nome' => trim($autor[2]),
						'tipo' => "AUTOR(A)"
					);

					if (! $this->producao8_m->add_record_autor_producao_trabalho($inserted_id, $data_author)) break;

					$this->log->save($data_author['tipo']." '".$data_author['nome']."' ADICIONADO(A): PRODUÇÃO GERAL ID '".$inserted_id."'");
				}
			}

			if ($this->db->trans_status() !== false) {

				$this->log->save("PRODUÇÃO TRABALHO ADICIONADA: ID '".$inserted_id."'");

				$this->db->trans_commit();

				$this->session->set_userdata('curr_content', 'producao8b');
		    	$this->session->set_userdata('curr_top_menu', 'menus/cursos.php');

		    	$data['content'] = $this->session->userdata('curr_content');		
				//$data['top_menu'] = $this->session->userdata('curr_top_menu');

				$html = array(
					'content' => $this->load->view($data['content'], '', true)
					//'top_menu' => $this->load->view($data['top_menu'], '', true)
				);

				$response = array(
					'success' => true,
					'html' => $html,
					'message' => 'Cadastro efetuado'
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
		
		echo json_encode($response);
	}

	function update() {

		$data = array(
			'titulo' => trim($this->input->post('titulo')),
			'tipo' => trim($this->input->post('rtipo')),
			'programa_curso' => trim($this->input->post('programa')),			
			'instituicao' => trim($this->input->post('instituicao')),
			'local_defesa' => trim($this->input->post('local_defesa')),
			'local_estagio' => trim($this->input->post('local_estagio')),
			'ano_defesa' => trim($this->input->post('ano_defesa')),			
			'orientador' => trim($this->input->post('orientador')),
			'formato' => trim($this->input->post('rformato')),
			'disponibilidade' => trim($this->input->post('disponivel')),
			'pagina_web' => trim($this->input->post('pagina_web')),			
			'id_curso' => trim($this->session->userdata('id_curso'))
		);

		// Starts transaction
		$this->db->trans_begin();

		if ($this->producao8_m->update_record_producao_trabalho($data, $this->input->post('id_producao'))) {

			if ($autor_excluidos = $this->input->post('autor_excluidos')) {

			    foreach ($autor_excluidos as $excluido) {

			    	$this->log->save("AUTOR(A) '".$excluido."' REMOVIDO(A): PRODUÇÃO TRABALHO ID '".$this->input->post('id_producao')."'");

					if (! $this->producao8_m->delete_record_producao_trabalho_autor($excluido, $this->input->post('id_producao'))) break;
					
				}
			}

			if ($autores = $this->input->post('autores')) {

			    foreach ($autores as $autor) {
					
					if ($autor[0] == 'N'){
						$data_author = array(	
							'nome' => trim($autor[2]),
							'tipo' => "AUTOR(A)"
						);

						if (! $this->producao8_m->add_record_autor_producao_trabalho($this->input->post('id_producao'), $data_author)) break;

						$this->log->save($data_author['tipo']." '".$data_author['nome']."' ADICIONADO(A): PRODUÇÃO TRABALHO ID '".$this->input->post('id_producao')."'");
					}
				}
			}

			if ($this->db->trans_status() !== false) {

				$this->log->save("PRODUÇÃO TRABALHO ATUALIZADA: ID '".$this->input->post('id_producao')."'");

				$this->db->trans_commit();

				$this->session->set_userdata('curr_content', 'producao8b');
		    	$this->session->set_userdata('curr_top_menu', 'menus/cursos.php');

		    	$data['content'] = $this->session->userdata('curr_content');		
				//$data['top_menu'] = $this->session->userdata('curr_top_menu');

				$html = array(
					'content' => $this->load->view($data['content'], '', true)
					//'top_menu' => $this->load->view($data['top_menu'], '', true)
				);

				$response = array(
					'success' => true,
					'html' => $html,
					'message' => 'Cadastro atualizado'
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

	function remove() {
		
		// Starts transaction
		$this->db->trans_begin();

		if ($this->producao8_m->delete_record_producao_trabalho_autor('ALL', $this->input->post('id_producao8b'))) {
		
			if ($this->producao8_m->delete_record_producao_trabalho($this->input->post('id_producao8b'))) {

				$this->log->save("PRODUÇÃO TRABALHO REMOVIDA: ID '".$this->input->post('id_producao8b')."'");

				$this->db->trans_commit();

				$this->session->set_userdata('curr_content', 'producao8b');
		    	$this->session->set_userdata('curr_top_menu', 'menus/cursos.php');

		    	$data['content'] = $this->session->userdata('curr_content');		
				//$data['top_menu'] = $this->session->userdata('curr_top_menu');

				$html = array(
					'content' => $this->load->view($data['content'], '', true)
					//'top_menu' => $this->load->view($data['top_menu'], '', true),
				);

				$response = array(
					'success' => true,
					'html'	  => $html,
					'message' => 'Cadastro removido'
				);

			} else {

				$this->db->trans_rollback();

				$response = array(
					'success' => false,
					'message' => 'Falha ao remover cadastro'
				);
			}

		} else {

			$this->db->trans_rollback();

			$response = array(
				'success' => false,
				'message' => 'Falha ao remover cadastro'
			);
		}

		echo json_encode($response);
	}

}
 ?>