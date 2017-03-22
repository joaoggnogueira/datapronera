<?php

class Fiscalizacao extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->database();   // Loading Database 
        $this->load->library('session'); // Loading Session
        $this->load->helper('url');  // Loading Helper

        $this->load->model('fiscalizacao_m');
    }

    function index() {

        $this->session->set_userdata('curr_content', 'fiscalizacao');
        $this->session->set_userdata('curr_top_menu', 'menus/cursos.php');

        $data['content'] = $this->session->userdata('curr_content');

        $html = array(
            'content' => $this->load->view($data['content'], '', true)
        );

        $response = array(
            'success' => true,
            'html' => $html
        );

        echo json_encode($response);
    }

    function index_add() {

        $fiscalizacao['id'] = 0;
        if ($superintendencia = $this->fiscalizacao_m->get_id_superintendencia($this->session->userdata('id_curso'))) {
            $this->session->set_userdata('curr_content', 'formulario_fiscalizacao');
            $this->session->set_userdata('curr_top_menu', 'menus/cursos.php');

            $data['content'] = $this->session->userdata('curr_content');
            
            $valores['superintendencia'] = $superintendencia[0]->id_superintendencia;
            $valores['dados'] = null;
            $valores['fiscalizacao'] = $fiscalizacao;
            $valores['operacao'] = $this->input->post('operacao');

            $html = array(
                'content' => $this->load->view($data['content'], $valores, true)
            );

            $response = array(
                'success' => true,
                'html' => $html
            );
        } else {
            $html = array(
                'content' => $this->load->view($data['content'], $valores, true)
            );
            $response = array(
                'success' => false,
                'html' => $html
            );
        }


        echo json_encode($response);
    }

    function index_update() {

        $fiscalizacao['id'] = $this->input->post('id_fiscalizacao');

        if ($dados = $this->fiscalizacao_m->get_record($fiscalizacao['id'])) {
            
            if($superintendencia = $this->fiscalizacao_m->get_id_superintendencia($this->session->userdata('id_curso'))){

                $dados[0]->data = implode("/", array_reverse(explode("-", $dados[0]->data), true));
                $this->session->set_userdata('curr_content', 'formulario_fiscalizacao');
                $this->session->set_userdata('curr_top_menu', 'menus/cursos.php');

                $data['content'] = $this->session->userdata('curr_content');
                
                $valores['superintendencia'] = $superintendencia[0]->id_superintendencia;
                $valores['dados'] = $dados;
                $valores['fiscalizacao'] = $fiscalizacao;
                $valores['operacao'] = $this->input->post('operacao');

                $html = array(
                    'content' => $this->load->view($data['content'], $valores, true)
                );

                $response = array(
                    'success' => true,
                    'html' => $html
                );
            }
        } else {

            $response = array(
                'success' => false,
                'message' => 'Falha ao atualizar cadastro'
            );
        }

        echo json_encode($response);
    }

    function add() {

        $data = array(
            'resumo' => trim($this->input->post('resumo')),
            'data' => implode("-", array_reverse(explode("/", $this->input->post('data')), true)),
            'id_curso' => $this->session->userdata('id_curso')
        );

        // Starts transaction
        $this->db->trans_begin();
        
        if ($this->input->post('tipo') == 'OUTRO') {

            $tipo = array(
                'nome' => trim($this->input->post('tipo_descricao')),
            );

            // Inserts course's genre
            $id_tipo = $this->fiscalizacao_m->add_record_tipo($tipo);
            $this->log->save("TIPO DE FISCALIZAÇÃO '" . $tipo["nome"] . "' ADICIONADO: ID '" . $id_tipo . "'");
        } else {
            $id_tipo = $this->input->post('tipo');
        }
            
        $data["id_tipo"] = $id_tipo;
        
        if (($inserted_id = $this->fiscalizacao_m->add_record($data))) {

            if (($membros = $this->input->post('membros'))) {

                foreach ($membros as $membro) {

                    $coord = array(
                        'id_fiscalizacao' => $inserted_id,
                        'id_pessoa' => $membro[1]
                    );

                    if (!$this->fiscalizacao_m->add_record_membro($coord))
                        break;

                    $this->log->save("MEMBRO '" . $membro[3] . "' ADICIONADO: FISCALIZAÇÃO ID '" . $inserted_id . "'");
                }
            }

            if ($this->db->trans_status() !== false) {

                $this->log->save("FISCALIZAÇÃO ADICIONADA: ID '" . $inserted_id . "'");

                $this->db->trans_commit();

                $this->session->set_userdata('curr_content', 'fiscalizacao');
                $this->session->set_userdata('curr_top_menu', 'menus/cursos.php');

                $data['content'] = $this->session->userdata('curr_content');

                $html = array(
                    'content' => $this->load->view($data['content'], '', true)
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
                    'message' => 'Falha ao efetuar cadastro. Erro 0x2'
                );
            }
        } else {

            $this->db->trans_rollback();

            $response = array(
                'success' => false,
                'message' => 'Falha ao efetuar cadastro. Erro 0x1'
            );
        }

        echo json_encode($response);
    }

    function update() {

        $data = array(
            'resumo' => trim($this->input->post('resumo')),
            'data' => implode("-", array_reverse(explode("/", $this->input->post('data')), true)),
            'id_curso' => $this->session->userdata('id_curso')
        );

        // Starts transaction
        $this->db->trans_begin();

        if ($this->input->post('tipo') == 'OUTRO') {

            $tipo = array(
                'nome' => trim($this->input->post('tipo_descricao')),
            );

            // Inserts course's genre
            $id_tipo = $this->fiscalizacao_m->add_record_tipo($tipo);
            $this->log->save("TIPO DE FISCALIZAÇÃO '" . $tipo["nome"] . "' ADICIONADO: ID '" . $id_tipo . "'");
        } else {
            $id_tipo = $this->input->post('tipo');
        }
        
        $data["id_tipo"] = $id_tipo;
        
        if ($this->fiscalizacao_m->update_record($data, $this->input->post('id'))) {

            // Algoritmo BURRO!
            // $this->organizacao_m->delete_record_coordenadores($this->input->post('id'));

            if ($membros_excluidos = $this->input->post('membros_excluidos')) {

                foreach ($membros_excluidos as $membros_excl) {

                    $this->log->save("MEMBRO '" . $membros_excl . "' REMOVIDO: FISCALIZACAO ID '" . $this->input->post('id') . "'");

                    if (!$this->fiscalizacao_m->delete_record_membro($membros_excl, $this->input->post('id')))
                        break;
                }
            }

            if ($membros = $this->input->post('membros')) {

                foreach ($membros as $membro) {

                    if ($membro[0] == 'N') {
                        $coord = array(
                            'id_fiscalizacao' => $this->input->post('id'),
                            'id_pessoa' => $membro[1]
                        );

                        if (!$this->fiscalizacao_m->add_record_membro($coord))
                            break;

                        $this->log->save("MEMBRO '" . $membro[3] . "' ADICIONADO: FISCALIZAÇÃO ID '" . $this->input->post('id') . "'");
                    }
                }
            }

            if ($this->db->trans_status() !== false) {

                $this->log->save("FISCALIZACAO ATUALIZADA: ID '" . $this->input->post('id') . "'");

                $this->db->trans_commit();

                $this->session->set_userdata('curr_content', 'fiscalizacao');
                $this->session->set_userdata('curr_top_menu', 'menus/cursos.php');

                $data['content'] = $this->session->userdata('curr_content');

                $html = array(
                    'content' => $this->load->view($data['content'], '', true)
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

        if ($this->fiscalizacao_m->delete_record($this->input->post('id_fiscalizacao'))) {

            $this->log->save("FISCALIZAÇÃO REMOVIDA: ID '" . $this->input->post('id_fiscalizacao') . "'");

            $this->session->set_userdata('curr_content', 'fiscalizacao');
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