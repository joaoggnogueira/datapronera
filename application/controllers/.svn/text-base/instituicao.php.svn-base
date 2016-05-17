<?php

class Instituicao extends CI_Controller {

	public function __construct() {
        parent::__construct(); 

        $this->load->database();		 // Loading Database 
        $this->load->library('session'); // Loading Session
        $this->load->helper('url'); 	 // Loading Session
        
		$this->load->model('instituicao_m');
    }

	function index() {
		
		if ($dados = $this->instituicao_m->get_record($this->session->userdata('id_curso'))) {

			$this->session->set_userdata('curr_content', 'formulario_instituicao');
	    	$this->session->set_userdata('curr_top_menu', 'menus/cursos.php');

	    	$data['content'] = $this->session->userdata('curr_content');		
			//$data['top_menu'] = $this->session->userdata('curr_top_menu');

			$valores['dados'] = $dados;

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

	function update() {

		if ($this->input->post('ckInstituicao_tel2') == 'true') {
			$tel2 = "NAOINFORMADO";

		} else {
			$tel2 = $this->input->post('instituicao_tel2');
		}

		if ($this->input->post('ckInstituicao_campus') == 'true') {
			$campus = "NAOINFORMADO";

		} else {
			$campus = $this->input->post('instituicao_campus');
		}

		if ($this->input->post('ckInstituicao_pag_web') == 'true') {
			$pag_web = "naoinformado";

		} else {
			$pag_web = $this->input->post('instituicao_site');
		}

		$data = array(
			'nome' => trim($this->input->post('instituicao_nome')),
			'sigla' => trim($this->input->post('instituicao_sigla')),
			'unidade' => trim($this->input->post('instituicao_unidade')),
			'departamento' => trim($this->input->post('instituicao_depto')),
			'rua' => trim($this->input->post('instituicao_rua')),
			'numero' => trim($this->input->post('instituicao_numero')),
			'complemento' => trim($this->input->post('instituicao_complemento')),
			'bairro' => trim($this->input->post('instituicao_bairro')),
			'cep' => trim($this->input->post('instituicao_cep')),
			'telefone1' => trim($this->input->post('instituicao_tel1')),
			'telefone2' => $tel2,
			'pagina_web' => $pag_web,
			'campus' => $campus,
			'id_cidade' => trim($this->input->post('instituicao_sel_mun')),
			'natureza_instituicao' => trim($this->input->post('rInstituicao_natureza')),
			'id_curso' => trim($this->session->userdata('id_curso'))
		);

		if ($this->instituicao_m->update_record($data, $this->session->userdata('id_curso'))) {

			$this->log->save("FORM. INSTITUIÇÃO ATUALIZADO: CURSO ID '".$this->session->userdata('id_curso')."'");

			$dados = $this->instituicao_m->get_record($this->session->userdata('id_curso'));

			$valores['dados'] = $dados ? $dados : '';

			$this->session->set_userdata('curr_content', 'formulario_instituicao');
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

	function get_estado() {

		echo ($estado = $this->instituicao_m->get_estado($this->session->userdata('id_curso'))) ? $estado : null;
	}

	function get_municipio() {

		echo ($municipio = $this->instituicao_m->get_municipio($this->session->userdata('id_curso'))) ? $municipio : null;
	}
}
