<?php 
	
class Organizacao extends CI_Controller {

	public function __construct() {
        parent::__construct(); 

        $this->load->database();		 // Loading Database 
        $this->load->library('session'); // Loading Session
        $this->load->helper('url'); 	// Loading Helper
        
		$this->load->model('organizacao_m');
    }

	function index() {

    	$this->session->set_userdata('curr_content', 'organizacao');
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

		$organizacao['id'] = 0;

    	$this->session->set_userdata('curr_content', 'formulario_organizacao');
    	$this->session->set_userdata('curr_top_menu', 'menus/cursos.php');

    	$data['content'] = $this->session->userdata('curr_content');		
		//$data['top_menu'] = $this->session->userdata('curr_top_menu');

		$valores['dados'] = null;
		$valores['organizacao'] = $organizacao;
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

		$organizacao['id'] = $this->input->post('id_organizacao');

		if ($dados = $this->organizacao_m->get_record($organizacao['id'])) {

			$dados[0]->data_fundacao_nacional =
				implode("/", array_reverse(explode("-", $dados[0]->data_fundacao_nacional),true));

			$dados[0]->data_fundacao_estadual =
				implode("/", array_reverse(explode("-", $dados[0]->data_fundacao_estadual),true));

	    	$this->session->set_userdata('curr_content', 'formulario_organizacao');
	    	$this->session->set_userdata('curr_top_menu', 'menus/cursos.php');

	    	$data['content'] = $this->session->userdata('curr_content');		
			//$data['top_menu'] = $this->session->userdata('curr_top_menu');

			$valores['dados'] = $dados;
			$valores['organizacao'] = $organizacao;
			$valores['operacao'] =  $this->input->post('operacao');

			$html = array(
				'content' => $this->load->view($data['content'], $valores, true)
				//'top_menu' => $this->load->view($data['top_menu'], '', true)
			);

			$response = array(
				'success' => true,
				'html' => $html
			);

		} else {
			
			$response = array(
				'success' => false,
				'message' => 'Falha ao atualizar cadastro'
			);
		}
		
		echo json_encode($response);
	}

	function add() {	
		
		if ($this->input->post('ckMovimento_data_naplica') == 'true') {
			$fundacao_nac = "1900-01-01";

		} else {
			$fundacao_nac =
				implode("-", array_reverse(explode("/", $this->input->post('movimento_fundacao_nac')),true));
		}

		if ($this->input->post('ckMovimento_data_naoinform') == 'true') {
			$fundacao_est = "0000-00-00";

		} else {
			$fundacao_est =
				implode("-", array_reverse(explode("/", $this->input->post('movimento_fundacao_est')),true));
		}

		if ($this->input->post('ckMovimento_num_assent') == 'true') {
			$num_assent = "-1";

		} else {
			$num_assent = trim($this->input->post('movimento_num_assent'));
		}

		if ($this->input->post('ckMovimento_num_acamp') == 'true') {
			$num_acamp = "-1";

		} else {
			$num_acamp = trim($this->input->post('movimento_num_acamp'));
		}

		if ($this->input->post('ckMovimento_num_familia') == 'true') {
			$num_familia = "-1";

		} else {
			$num_familia = trim($this->input->post('movimento_num_familia'));
		}

		if ($this->input->post('ckMovimento_num_pessoa') == 'true') {
			$num_pessoa = "-1";

		} else {
			$num_pessoa = trim($this->input->post('movimento_num_pessoa'));
		}

		if ($this->input->post('ckMovimento_fonte_info') == 'true') {
			$fonte_info = "NAOINFORMADO";

		} else {
			$fonte_info = trim($this->input->post('movimento_fonte_inform'));
		}

		$data = array(
			'nome' => trim($this->input->post('movimento_nome')),
			'abrangencia' => trim($this->input->post('rmovimento_abrangencia')),
			'data_fundacao_nacional' => trim($fundacao_nac),
			'data_fundacao_estadual' =>  trim($fundacao_est),
			'numero_assentamentos' => trim($num_assent),
			'numero_acampamentos' => trim($num_acamp),
			'numero_familias_assentadas' =>  trim($num_familia),
			'numero_pessoas' =>  trim($num_pessoa),
			'fonte_informacao' => $fonte_info,
			'id_curso' => $this->session->userdata('id_curso')     
        );

        // Starts transaction
		$this->db->trans_begin();

		if ($inserted_id = $this->organizacao_m->add_record($data)) {

			if ($membros = $this->input->post('membros')) {

			    foreach ($membros as $membro) {
					
			    	$estudo = ($membro[5] == "SIM") ? 'S' : 'N';

					$coord = array(	
						'nome' => $membro[2],
						'grau_escolaridade_epoca' => $membro[3],
						'grau_escolaridade_atual' => $membro[4],
						'estuda_pronera' => $estudo,
						'id_organizacao_demandante' => $inserted_id
					);

					if (! $this->organizacao_m->add_record_coordenadores($coord)) break;

					$this->log->save("MEMBRO '".$coord['nome']."' ADICIONADO: ORGANIZAÇÃO ID '".$inserted_id."'");
				}
			}

			if ($this->db->trans_status() !== false) {

				$this->log->save("ORGANIZAÇÃO ADICIONADA: ID '".$inserted_id."'");

				$this->db->trans_commit();

				$this->session->set_userdata('curr_content', 'organizacao');
		    	$this->session->set_userdata('curr_top_menu', 'menus/cursos.php');

		    	$data['content'] = $this->session->userdata('curr_content');		
				//$data['top_menu'] = $this->session->userdata('curr_top_menu');

				$html = array(
					'content' => $this->load->view($data['content'], '', true)
					//'top_menu' => $this->load->view($data['top_menu'], '', true)
				);

				$response = array(
					'success' => true,
					'html'	  => $html,
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

		if ($this->input->post('ckMovimento_data_naplica') == 'true') {
			$fundacao_nac = "1900-01-01";

		} else {
			$fundacao_nac =
				implode("-", array_reverse(explode("/", $this->input->post('movimento_fundacao_nac')),true));
		}

		if ($this->input->post('ckMovimento_data_naoinform') == 'true') {
			$fundacao_est = "0000-00-00";

		} else {
			$fundacao_est =
				implode("-", array_reverse(explode("/", $this->input->post('movimento_fundacao_est')),true));
		}

		if ($this->input->post('ckMovimento_num_assent') == 'true') {
			$num_assent = "-1";

		} else {
			$num_assent = trim($this->input->post('movimento_num_assent'));
		}

		if ($this->input->post('ckMovimento_num_acamp') == 'true') {
			$num_acamp = "-1";

		} else {
			$num_acamp = trim($this->input->post('movimento_num_acamp'));
		}

		if ($this->input->post('ckMovimento_num_familia') == 'true') {
			$num_familia = "-1";

		} else {
			$num_familia = trim($this->input->post('movimento_num_familia'));
		}

		if ($this->input->post('ckMovimento_num_pessoa') == 'true') {
			$num_pessoa = "-1";

		} else {
			$num_pessoa = trim($this->input->post('movimento_num_pessoa'));
		}

		if ($this->input->post('ckMovimento_fonte_info') == 'true') {
			$fonte_info = "NAOINFORMADO";

		} else {
			$fonte_info = trim($this->input->post('movimento_fonte_inform'));
		}

		$data = array(
			'nome' => trim($this->input->post('movimento_nome')),
			'abrangencia' => trim($this->input->post('rmovimento_abrangencia')),
			'data_fundacao_nacional' => trim($fundacao_nac),
			'data_fundacao_estadual' =>  trim($fundacao_est),
			'numero_assentamentos' => trim($num_assent),
			'numero_acampamentos' => trim($num_acamp),
			'numero_familias_assentadas' =>  trim($num_familia),
			'numero_pessoas' =>  trim($num_pessoa),
			'fonte_informacao' => $fonte_info,
			'id_curso' => $this->session->userdata('id_curso')     
        );

        // Starts transaction
		$this->db->trans_begin();

		if ($this->organizacao_m->update_record($data, $this->input->post('id'))) {
			
			// Algoritmo BURRO!
			// $this->organizacao_m->delete_record_coordenadores($this->input->post('id'));

			if ($membros_excluidos = $this->input->post('membros_excluidos')) {

			    foreach ($membros_excluidos as $membros_excl) {					

			    	$this->log->save("MEMBRO '".$membros_excl."' REMOVIDO: ORGANIZAÇÃO ID '".$this->input->post('id')."'");

					if (! $this->organizacao_m->delete_record_coordenadores($membros_excl, $this->input->post('id'))) break;
				}
			}

			if ($membros = $this->input->post('membros')) {

			    foreach ($membros as $membro) {
					
			    	if ($membro[0] == 'N'){
			    		$estudo = ($membro[5] == "SIM") ? 'S' : 'N';

						$coord = array(	
							'nome' => $membro[2],
							'grau_escolaridade_epoca' => $membro[3],
							'grau_escolaridade_atual' => $membro[4],
							'estuda_pronera' => $estudo,
							'id_organizacao_demandante' => $this->input->post('id')
						);

						if (! $this->organizacao_m->add_record_coordenadores($coord)) break;

						$this->log->save("MEMBRO '".$coord['nome']."' ADICIONADO: ORGANIZAÇÃO ID '".$this->input->post('id')."'");
					}
				}
			}

			if ($this->db->trans_status() !== false) {

				$this->log->save("ORGANIZAÇÃO ATUALIZADA: ID '".$this->input->post('id')."'");

				$this->db->trans_commit();

				$this->session->set_userdata('curr_content', 'organizacao');
		    	$this->session->set_userdata('curr_top_menu', 'menus/cursos.php');

		    	$data['content'] = $this->session->userdata('curr_content');		
				//$data['top_menu'] = $this->session->userdata('curr_top_menu');

				$html = array(
					'content' => $this->load->view($data['content'], '', true)
					//'top_menu' => $this->load->view($data['top_menu'], '', true)
				);

				$response = array(
					'success' => true,
					'html'	  => $html,
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

		if ($this->organizacao_m->delete_record($this->input->post('id_organizacao'))) {

			$this->log->save("ORGANIZAÇÃO REMOVIDA: ID '".$this->input->post('id_organizacao')."'");
		
			$this->session->set_userdata('curr_content', 'organizacao');
	    	$this->session->set_userdata('curr_top_menu', 'menus/cursos.php');

	    	$data['content'] = $this->session->userdata('curr_content');		
			$data['top_menu'] = $this->session->userdata('curr_top_menu');

			$html = array(
				'content' => $this->load->view($data['content'], '', true),
				'top_menu' => $this->load->view($data['top_menu'], '', true)
			);

			$response = array(
				'success' => true,
				'html' => $html,
				'message' => 'Cadastro removido'
			);

		} else {

			$response = array(
				'success' => false,
				'html' => $html,
				'message' => 'Falha ao remover cadastro'
			);
		}

		echo json_encode($response);
	}
}
 ?>