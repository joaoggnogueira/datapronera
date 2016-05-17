<?php 
	
class Producao9f extends CI_Controller {

	public function __construct() {
        parent::__construct(); 

        $this->load->database();		 // Loading Database 
        $this->load->library('session'); // Loading Session
        $this->load->helper('url'); 	// Loading Helper
        
		$this->load->model('producao9_m');
    }

	function index() {

    	$this->session->set_userdata('curr_content', 'producao9f');
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

    	$this->session->set_userdata('curr_content', 'formProducaoPesquisa9F');
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

		$producao['id'] = $this->input->post('id_producao9f');
		
		if ($dados = $this->producao9_m->get_record_pesquisa_periodico($producao['id'])) {

	    	$this->session->set_userdata('curr_content', 'formProducaoPesquisa9F');
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
			'editora' => trim($this->input->post('editora')),
			'ano' => trim($this->input->post('ano')),
			'disponibilidade' => trim($this->input->post('disponibilidade')),
			'id_pessoa' => 1//$this->session->userdata('cpf')
		);

		// Starts transaction
		$this->db->trans_begin();

		if ($inserted_id = $this->producao9_m->add_record_pesquisa_periodico($data)) {

			if ($organizadores = $this->input->post('organizadores')) {

			    foreach ($organizadores as $organizador) {
					
					$data_author = array(	
						'nome' => $organizador[2],
						'tipo' => "ORGANIZADOR(A)"
					);

					if (! $this->producao9_m->add_record_pesquisa_periodico_autor($inserted_id, $data_author)) break;
				}
			}

			if ($this->db->trans_status() !== false) {

				$this->db->trans_commit();

				$this->session->set_userdata('curr_content', 'producao9f');
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
		
		echo json_encode($response);
	}

	function update() {

		$data = array(
			'titulo' => trim($this->input->post('titulo')),
			'local_producao' => trim($this->input->post('local')),
			'editora' => trim($this->input->post('editora')),
			'ano' => trim($this->input->post('ano')),
			'disponibilidade' => trim($this->input->post('disponibilidade')),
			'id_pessoa' => 1//$this->session->userdata('cpf')
		);

		// Starts transaction
		$this->db->trans_begin();

		if ($this->producao9_m->update_record_pesquisa_periodico($data, $this->input->post('id_producao'))) {

			if ($organizador_excluidos = $this->input->post('organizador_excluidos')) {

			    foreach ($organizador_excluidos as $excluido) {

					if (! $this->producao9_m->delete_record_pesquisa_periodico_autor($excluido, $this->input->post('id_producao'))) break;
					
				}
			}

			if ($organizadores = $this->input->post('organizadores')) {

			    foreach ($organizadores as $organizador) {
					if ($organizador[0] == 'N'){
						$data_author = array(	
							'nome' => $organizador[2],
							'tipo' => "ORGANIZADOR(A)"
						);

						if (! $this->producao9_m->add_record_pesquisa_periodico_autor($this->input->post('id_producao'), $data_author)) break;
					}
				}
			}

			if ($this->db->trans_status() !== false) {

				$this->db->trans_commit();

				$this->session->set_userdata('curr_content', 'producao9f');
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
		
		echo json_encode($response);
	}

	function remove() {
		
		// Starts transaction
		$this->db->trans_begin();

		if ($this->producao9_m->delete_record_pesquisa_periodico_autor('ALL', $this->input->post('id_producao9f'))) {
		
			if ($this->producao9_m->delete_record_pesquisa_periodico($this->input->post('id_producao9f'))) {

				$this->db->trans_commit();

				$this->session->set_userdata('curr_content', 'producao9f');
		    	$this->session->set_userdata('curr_top_menu', 'menus/principal.php');

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