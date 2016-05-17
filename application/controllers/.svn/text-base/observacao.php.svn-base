<?php 
	
class Observacao extends CI_Controller {

	public function __construct() {
        parent::__construct(); 

        $this->load->database();		 // Loading Database 
        $this->load->library('session'); // Loading Session
        $this->load->helper('url'); 	// Loading Helper
        
		$this->load->model('curso_m');
    }

	function index() {
		
		$curso['id'] = $this->session->userdata('id_curso');

		if ($dados = $this->curso_m->get_record($curso['id'])) {

			$this->session->set_userdata('curr_content', 'formulario_observacao');
	    	$this->session->set_userdata('curr_top_menu', 'menus/cursos.php');

	    	$data['content'] = $this->session->userdata('curr_content');		
			//$data['top_menu'] = $this->session->userdata('curr_top_menu');

			$valores['data'] = $dados;
			$valores['curso'] = $curso;

			$html = array(
				'content' => $this->load->view($data['content'], $valores, true),
				//'top_menu' => $this->load->view($data['top_menu'], '', true)
			);

			$response = array(
				'success' => true,
				'html' => $html
			);

		} else {

			$response = array(
				'success' => false,
				'message' => 'Falha na requisição, tente novamente em instantes'
			);
		}

		echo json_encode($response);
	}

	function update() {

		$data = array(
			'obs' => trim($this->input->post('obs'))
		);

		if ($this->curso_m->update_record($data, $this->session->userdata('id_curso'))) {

			$this->log->save("OBSERVAÇÃO ATUALIZADA: CURSO ID '".$this->session->userdata('id_curso')."'");

			$valores['curso'] = $this->session->userdata('id_curso');
			$valores['data'] = $this->curso_m->get_record($valores['curso']);

			$this->session->set_userdata('curr_content', 'formulario_observacao');
	    	$this->session->set_userdata('curr_top_menu', 'menus/cursos.php');

	    	$data['content'] = $this->session->userdata('curr_content');		
			//$data['top_menu'] = $this->session->userdata('curr_top_menu');

			$html = array(
				'content' => $this->load->view($data['content'], $valores, true)
				//'top_menu' => $this->load->view($data['top_menu'], '', true)
			);

			$response = array(
				'success' => true,
				'html' => $html,
				'message' => 'Cadastro atualizado com sucesso'
			);

		} else {

			$response = array(
				'success' => false,
				'message' => 'Falha ao atualizar cadastro'
			);			
		}

		echo json_encode($response);
	}
}