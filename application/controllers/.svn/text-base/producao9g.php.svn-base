<?php 
	
class Producao9g extends CI_Controller {

	public function __construct() {
        parent::__construct(); 

        $this->load->database();		 // Loading Database 
        $this->load->library('session'); // Loading Session
        $this->load->helper('url'); 	// Loading Helper
        
		$this->load->model('producao9_m');
    }

	function index() {

    	$this->session->set_userdata('curr_content', 'producao9g');
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

		$producao['id'] = 0;

    	$this->session->set_userdata('curr_content', 'formProducaoPesquisa9G');
    	$this->session->set_userdata('curr_top_menu', 'menus/principal.php');

    	$data['content'] = $this->session->userdata('curr_content');		
		//$data['top_menu'] = $this->session->userdata('curr_top_menu');

		$valores['operacao'] = $this->input->post('operacao');
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

		$producao['id'] = $this->input->post('id_producao9g');
		
		if ($dados = $this->producao9_m->get_record_pesquisa_evento($producao['id'])) {

			$dados[0]->data_producao =
				implode("/", array_reverse(explode("-", $dados[0]->data_producao),true));

	    	$this->session->set_userdata('curr_content', 'formProducaoPesquisa9G');
	    	$this->session->set_userdata('curr_top_menu', 'menus/principal.php');

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
			'local_producao' => trim($this->input->post('local')),		
			'id_cidade' => trim($this->input->post('sel_mun')),
			'data_producao' => implode("-", array_reverse(explode("/", trim($this->input->post('data'))),true)),
			'abrangencia' => trim($this->input->post('revento')),
			'participantes' => trim($this->input->post('participante')),
			'id_pessoa' => 1//$this->session->userdata('cpf')
		);

		if ($inserted_id = $this->producao9_m->add_record_pesquisa_evento($data)) {

			if ($organizadores = $this->input->post('organizadores')) {

			    foreach ($organizadores as $organizador) {
					
					$data_author = array(	
						'nome' => $organizador[2],
						'tipo' => "ORGANIZADOR(A)"
					);

					if (! $this->producao9_m->add_record_pesquisa_evento_autor($inserted_id, $data_author)) break;
				}
			}

			if ($organizacoes = $this->input->post('organizacoes')) {

			    foreach ($organizacoes as $organizacao) {
					
					$data_org = array(	
						'id_pesquisa_evento' => $inserted_id,
						'nome' => $organizacao[2]
					);

					if (! $this->producao9_m->add_record_pesquisa_evento_organizacao($data_org)) break;
				}
			}

			$documento = array(
				'id_pesquisa_evento' => $inserted_id,
				'op_nao' => trim($this->input->post('ck_nao')),		
				'memoria' => trim($this->input->post('ck_memoria')),
				'memoria_descricao' => trim($this->input->post('memoria_descricao')),
				'carta' => trim($this->input->post('ck_carta')),
				'carta_descricao' => trim($this->input->post('carta_descricao')),
				'relatorio' => trim($this->input->post('ck_relatorio')),
				'relatorio_descricao' => trim($this->input->post('relatorio_descricao')),
				'anais' => trim($this->input->post('ck_anais')),
				'anais_descricao' => trim($this->input->post('anais_descricao')),
				'video' => trim($this->input->post('ck_video')),
				'video_descricao' => trim($this->input->post('video_descricao'))
			);
			
			if ($this->producao9_m->add_record_pesquisa_evento_documento($documento)) {

				if ($this->db->trans_status() !== false) {

					$this->db->trans_commit();

					$this->session->set_userdata('curr_content', 'producao9g');
			    	$this->session->set_userdata('curr_top_menu', 'menus/principal.php');

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
			'local_producao' => trim($this->input->post('local')),		
			'id_cidade' => trim($this->input->post('sel_mun')),
			'data_producao' => implode("-", array_reverse(explode("/", trim($this->input->post('data'))),true)),
			'abrangencia' => trim($this->input->post('revento')),
			'participantes' => trim($this->input->post('participante')),
			'id_pessoa' => 1//$this->session->userdata('cpf')
		);

		if ($this->producao9_m->update_record_pesquisa_evento($data, $this->input->post('id_producao'))) {

			if ($organizador_excluidos = $this->input->post('organizador_excluidos')) {

			    foreach ($organizador_excluidos as $excluido) {

					if (! $this->producao9_m->delete_record_pesquisa_evento_autor($excluido, $this->input->post('id_producao'))) break;
					
				}
			}

			if ($organizadores = $this->input->post('organizadores')) {

			    foreach ($organizadores as $organizador) {
					
					if ($organizador[0] == 'N'){
						$data_author = array(	
							'nome' => $organizador[2],
							'tipo' => "ORGANIZADOR(A)"
						);

						if (! $this->producao9_m->add_record_pesquisa_evento_autor($this->input->post('id_producao'), $data_author)) break;
					}
				}
			}

			if ($organizacoes = $this->input->post('organizacoes')) {


				if ($organizacao_excluidos = $this->input->post('organizacao_excluidos')) {

				    foreach ($organizacao_excluidos as $excluido) {

						if (! $this->producao9_m->delete_record_pesquisa_evento_organizacao($excluido, $this->input->post('id_producao'))) break;
						
					}
				}

			    foreach ($organizacoes as $organizacao) {
					
					if ($organizacao[0] == 'N'){
						$data_org = array(	
							'id_pesquisa_evento' => $this->input->post('id_producao'),
							'nome' => $organizacao[2]
						);

						if (! $this->producao9_m->add_record_pesquisa_evento_organizacao($data_org)) break;
					}
				}
			}

			$documento = array(
				'id_pesquisa_evento' => $this->input->post('id_producao'),
				'op_nao' => trim($this->input->post('ck_nao')),		
				'memoria' => trim($this->input->post('ck_memoria')),
				'memoria_descricao' => trim($this->input->post('memoria_descricao')),
				'carta' => trim($this->input->post('ck_carta')),
				'carta_descricao' => trim($this->input->post('carta_descricao')),
				'relatorio' => trim($this->input->post('ck_relatorio')),
				'relatorio_descricao' => trim($this->input->post('relatorio_descricao')),
				'anais' => trim($this->input->post('ck_anais')),
				'anais_descricao' => trim($this->input->post('anais_descricao')),
				'video' => trim($this->input->post('ck_video')),
				'video_descricao' => trim($this->input->post('video_descricao'))
			);
			
			if ($this->producao9_m->update_record_pesquisa_evento_documento($documento, $this->input->post('id_producao'))) {

				if ($this->db->trans_status() !== false) {

					$this->db->trans_commit();

					$this->session->set_userdata('curr_content', 'producao9g');
			    	$this->session->set_userdata('curr_top_menu', 'menus/principal.php');

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

		// Deleting authors
		if ($this->producao9_m->delete_record_pesquisa_evento_autor($this->input->post('id_producao9g'))) {

			// Deleting organizations
			if ($this->producao9_m->delete_record_pesquisa_evento_organizacao($this->input->post('id_producao9g'))) {

				// Deleting final documents
				if ($this->producao9_m->delete_record_pesquisa_evento_documento($this->input->post('id_producao9g'))) {

					// Deleting production
					if ($this->producao9_m->delete_record_pesquisa_evento($this->input->post('id_producao9g'))) {

						$this->db->trans_commit();

						$this->session->set_userdata('curr_content', 'producao9g');
				    	$this->session->set_userdata('curr_top_menu', 'menus/principal.php');

				    	$data['content'] = $this->session->userdata('curr_content');		
						//$data['top_menu'] = $this->session->userdata('curr_top_menu');

						$html = array(
							'content' => $this->load->view($data['content'], '', true)
							//'top_menu' => $this->load->view($data['top_menu'], '', true)
						);

						$response = array(
							'success' => true,
							'html' => $html,
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

	function get_estado(){
		$query = $this->producao9_m->get_estado_pesquisa_evento($this->uri->segment(3));
		echo $query;
	}

	function get_cidade(){
		$query = $this->producao9_m->get_cidade_pesquisa_evento($this->uri->segment(3));
		echo $query;
	}

}