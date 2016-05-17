<?php 
	
class Producao8d extends CI_Controller {

	public function __construct() {
        parent::__construct(); 

        $this->load->database();		 // Loading Database 
        $this->load->library('session'); // Loading Session
        $this->load->helper('url'); 	// Loading Helper
        
		$this->load->model('producao8_m');
    }

	function index() {

    	$this->session->set_userdata('curr_content', 'producao8d');
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

    	$this->session->set_userdata('curr_content', 'formulario_Producao8D');
    	$this->session->set_userdata('curr_top_menu', 'menus/cursos.php');

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

		$producao['id'] = $this->input->post('id_producao8d');
		
		if ($dados = $this->producao8_m->get_record_producao_memoria($producao['id'])) {

	    	$this->session->set_userdata('curr_content', 'formulario_Producao8D');
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
			'titulo' => trim($this->input->post('memoria_titulo')),
			'local_producao' => trim($this->input->post('memoria_local')),	
			'ano' => trim($this->input->post('memoria_ano')),
			'formato' => trim($this->input->post('rmemoria')),
			'disponibilidade' => trim($this->input->post('memoria_disponivel')),
			'pagina_web' => trim($this->input->post('memoria_site')),			
			'id_curso' => trim($this->session->userdata('id_curso'))
		);

		if ($inserted_id = $this->producao8_m->add_record_producao_memoria($data)) {

			$this->log->save("PRODUÇÃO MEMÓRIA ADICIONADA: ID '".$inserted_id."'");

			$this->session->set_userdata('curr_content', 'producao8d');
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

			$response = array(
				'success' => false,
				'message' => 'Falha ao efetuar cadastro'
			);
		}

		echo json_encode($response);
	}

	function update() {
		
		$data = array(
			'titulo' => trim($this->input->post('memoria_titulo')),
			'local_producao' => trim($this->input->post('memoria_local')),	
			'ano' => trim($this->input->post('memoria_ano')),
			'formato' => trim($this->input->post('rmemoria')),
			'disponibilidade' => trim($this->input->post('memoria_disponivel')),
			'pagina_web' => trim($this->input->post('memoria_site')),			
			'id_curso' => trim($this->session->userdata('id_curso'))
		);
		
		if ($this->producao8_m->update_record_producao_memoria($data, $this->input->post('id_producao'))) {

			$this->log->save("PRODUÇÃO MEMÓRIA ATUALIZADA: ID '".$this->input->post('id_producao')."'");

			$this->session->set_userdata('curr_content', 'producao8d');
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

			$response = array(
				'success' => false,
				'message' => 'Falha ao atualizar cadastro'
			);
		}

		echo json_encode($response);
	}

	function remove() {
		
		if ($this->producao8_m->delete_record_producao_memoria($this->input->post('id_producao8d'))) {

			$this->log->save("PRODUÇÃO MEMÓRIA REMOVIDA: ID '".$this->input->post('id_producao8d')."'");

			$this->session->set_userdata('curr_content', 'producao8d');
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
				'message' => 'Cadastro removido'
			);

		} else {

			$response = array(
				'success' => false,
				'message' => 'Falha ao remover cadastro'
			);
		}

		echo json_encode($response);
	}

}