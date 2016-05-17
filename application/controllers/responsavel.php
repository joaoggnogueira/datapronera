<?php 

	class Responsavel extends CI_Controller {

		public function __construct() {
	        parent::__construct(); 

	        $this->load->database();		 // Loading Database 
	        $this->load->library('session'); // Loading Session
	        $this->load->helper('url'); 	 // Loading Session
	        
			$this->load->model('responsavel_m');
	    }

		function index() {

			if ($result = $this->responsavel_m->get_record($this->session->userdata('id_curso'))) {

				$this->session->set_userdata('curr_content', 'formulario_responsavel');
		    	$this->session->set_userdata('curr_top_menu', 'menus/cursos.php');

		    	$data['content'] = $this->session->userdata('curr_content');		
				//$data['top_menu'] = $this->session->userdata('curr_top_menu');

				$values['data'] = $result;
				//$values['insurers'] = $this->responsavel_m->get_insurers();
				$values['informer'] = $this->responsavel_m->get_informers($this->session->userdata('id_curso'));

				$html = array(
					'content' => $this->load->view($data['content'], $values, true)
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
				'superintendencia_incra' => $this->input->post('superintendencia_incra'),
				'universidade_faculdade' => $this->input->post('univ_facul'),
				'movimento_social_sindical' => $this->input->post('mov_social_sindical'),
				'secretaria_municipal_educacao' => $this->input->post('secretaria_mun_educacao'),
				'secretaria_estadual_educacao' => $this->input->post('secretaria_est_educacao'),
				'instituto_federal' => $this->input->post('inst_federal'),
				'escola_tecnica' => $this->input->post('escola_tec'),
				'redes_ceffas' => $this->input->post('redes_ceffas'),
				'outras' => $this->input->post('outras'),
				'complemento' => $this->input->post('complemento')
			);

			// Starts transaction
			$this->db->trans_begin();

			if ($this->responsavel_m->update_record($data, $this->session->userdata('id_curso'))) {

				/* Algoritmo BURRO!
				$this->responsavel_m->delete_insurers($this->session->userdata('id_curso'));

				if ($asseguradores = $this->input->post('asseguradores')) {

				    foreach ($asseguradores as $assegurador) {
						
						$asseg = array(	
							'id_curso' => $this->session->userdata('id_curso'),
							'id_pessoa' => $assegurador
						);

						if (! $this->responsavel_m->add_insurers($asseg)) break;

						$this->log->save("ASSEGURADOR VINCULADO AO CURSO '".$this->session->userdata('id_curso')."': ID '".$assegurador."'");
					}
				}*/

				if ($this->db->trans_status() !== false) {

					$this->log->save("FORM. RESPONSÁVEIS ATUALIZADO: CURSO ID '".$this->session->userdata('id_curso')."'");

					$this->db->trans_commit();

					$this->session->set_userdata('curr_content', 'formulario_responsavel');
			    	$this->session->set_userdata('curr_top_menu', 'menus/cursos.php');

			    	$data['content'] = $this->session->userdata('curr_content');		
					//$data['top_menu'] = $this->session->userdata('curr_top_menu');

					$values['data'] = $this->responsavel_m->get_record($this->session->userdata('id_curso'));
					//$values['insurers'] = $this->responsavel_m->get_insurers();
					$values['informer'] = $this->responsavel_m->get_informers($this->session->userdata('id_curso'));

					$html = array(
						'content' => $this->load->view($data['content'], $values, true)
						//'top_menu' => $this->load->view($data['top_menu'], '', true)
					);

					$response = array(
						'success' => true,
						'html'    => $html,
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
	}