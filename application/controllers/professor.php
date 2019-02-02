<?php

class Professor extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->database();   // Loading Database 
        $this->load->library('session'); // Loading Session
        $this->load->helper('url');  // Loading Helper

        $this->load->model('professor_m');
    }

    function index() {

        $this->session->set_userdata('curr_content', 'professor');
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

        $professor['id'] = 0;

        $this->session->set_userdata('curr_content', 'formulario_professor');
        $this->session->set_userdata('curr_top_menu', 'menus/cursos.php');

        $data['content'] = $this->session->userdata('curr_content');
        //$data['top_menu'] = $this->session->userdata('curr_top_menu');

        $valores['dados'] = null;
        $valores['professor'] = $professor;
        $valores['operacao'] = $this->input->post('operacao');

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

        $professor['id'] = $this->input->post('id_professor');

        if ($dados = $this->professor_m->get_record($professor['id'])) {

            $this->session->set_userdata('curr_content', 'formulario_professor');
            $this->session->set_userdata('curr_top_menu', 'menus/cursos.php');

            $data['content'] = $this->session->userdata('curr_content');
            //$data['top_menu'] = $this->session->userdata('curr_top_menu');

            $valores['dados'] = $dados;
            $valores['professor'] = $professor;
            $valores['operacao'] = $this->input->post('operacao');

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
                'message' => 'Falha na requisição, tente novamente em instantes'
            );
        }

        echo json_encode($response);
    }

    function add() {

        $disciplinas_ni = ($this->input->post('ckDisciplinas_ni') == 'true') ? 'V' : 'F';

        $sexo = ($this->input->post('ckSexo_ni') == 'true') ? "N" :
                trim($this->input->post('rprof_sexo'));

        $titulacao = ($this->input->post('ckTitulacao_ni') == 'true') ? "NAOINFORMADO" :
                trim($this->input->post('rprof_escola'));

        $cpf = ($this->input->post('ckCPF_ni') == 'true') ? 'NAOINFORMADO' :
                trim($this->input->post('professor_cpf'));

        $cpf = ($this->input->post('ckCPF_na') == 'true') ? 'NAOAPLICA' :
                $cpf;

        $rg = ($this->input->post('ckRg_ni') == 'true') ? 'NAOINFORMADO' :
                trim($this->input->post('professor_rg'));

        $rg = ($this->input->post('ckRg_na') == 'true') ? 'NAOAPLICA' :
                $rg;

        $data = array(
            'nome' => trim($this->input->post('professor_nome')),
            'rg' => $rg,
            'cpf' => $cpf,
            'genero' => $sexo,
            'titulacao' => $titulacao,
            'id_curso' => $this->session->userdata('id_curso'),
            'disciplina_ni' => $disciplinas_ni
        );

        // Starts transaction
        $this->db->trans_begin();

        if (($inserted_id = $this->professor_m->add_record($data))) {

            if (($disciplinas = $this->input->post('disciplinas'))) {

                foreach ($disciplinas as $disciplina) {

                    if ($disciplina[0] == 'N') {
                        $disc = array(
                            'nome' => $disciplina[2],
                            'id_professor' => $inserted_id,
                            'id_curso' => $this->session->userdata('id_curso')
                        );

                        if (!$this->professor_m->add_record_disciplina($disc))
                            break;

                        $this->log->save("DISCIPLINA '" . $disc['nome'] . "' ADICIONADA: PROFESSOR ID '" . $inserted_id . "'");
                    }
                }
            }

            if ($this->db->trans_status() !== false) {

                $this->log->save("PROFESSOR ADICIONADO: ID '" . $inserted_id . "'");

                $this->db->trans_commit();

                $this->session->set_userdata('curr_content', 'professor');
                $this->session->set_userdata('curr_top_menu', 'menus/cursos.php');

                $data['content'] = $this->session->userdata('curr_content');
                //$data['top_menu'] = $this->session->userdata('curr_top_menu');

                $html = array(
                    'content' => $this->load->view($data['content'], '', true)
                        //'top_menu' => $this->load->view($data['top_menu'], '', true),
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

        $disciplinas_ni = ($this->input->post('ckDisciplinas_ni') == 'true') ? 1 : 0;

        $sexo = ($this->input->post('ckSexo_ni') == 'true') ? "N" :
                trim($this->input->post('rprof_sexo'));

        $titulacao = ($this->input->post('ckTitulacao_ni') == 'true') ? "NAOINFORMADO" :
                trim($this->input->post('rprof_escola'));

        $cpf = ($this->input->post('ckCPF_ni') == 'true') ? 'NAOINFORMADO' :
                trim($this->input->post('professor_cpf'));

        $cpf = ($this->input->post('ckCPF_na') == 'true') ? 'NAOAPLICA' :
                $cpf;

        $rg = ($this->input->post('ckRg_ni') == 'true') ? 'NAOINFORMADO' :
                trim($this->input->post('professor_rg'));

        $rg = ($this->input->post('ckRg_na') == 'true') ? 'NAOAPLICA' :
                $rg;

        $data = array(
            'nome' => trim($this->input->post('professor_nome')),
            'rg' => $rg,
            'cpf' => $cpf,
            'genero' => $sexo,
            'titulacao' => $titulacao,
            'id_curso' => $this->session->userdata('id_curso'),
            'disciplina_ni' => $disciplinas_ni
        );

        // Starts transaction
        $this->db->trans_begin();

        if ($this->professor_m->update_record($data, $this->input->post('id'))) {

            // Algoritmo BURRO!
            // $this->professor_m->delete_record_disciplinas($this->input->post('id'));

            if ($disciplinas_excl = $this->input->post('disc_excluidas')) {

                foreach ($disciplinas_excl as $disciplina_exc) {

                    $this->log->save("DISCIPLINA '" . $disciplina_exc . "' REMOVIDA: PROFESSOR ID '" . $this->input->post('id') . "'");

                    if (!$this->professor_m->delete_record_disciplinas($disciplina_exc, $this->input->post('id')))
                        break;
                }
            }

            if ($disciplinas = $this->input->post('disciplinas')) {

                foreach ($disciplinas as $disciplina) {

                    if ($disciplina[0] == 'N') {
                        $disc = array(
                            'nome' => $disciplina[2],
                            'id_professor' => $this->input->post('id'),
                            'id_curso' => $this->session->userdata('id_curso')
                        );

                        if (!$this->professor_m->add_record_disciplina($disc))
                            break;

                        $this->log->save("DISCIPLINA '" . $disc['nome'] . "' ADICIONADA: PROFESSOR ID '" . $this->input->post('id') . "'");
                    }
                }
            }

            if ($this->db->trans_status() !== false) {

                $this->log->save("PROFESSOR ATUALIZADO: ID '" . $this->input->post('id') . "'");

                $this->db->trans_commit();

                $this->session->set_userdata('curr_content', 'professor');
                $this->session->set_userdata('curr_top_menu', 'menus/cursos.php');

                $data['content'] = $this->session->userdata('curr_content');
                //$data['top_menu'] = $this->session->userdata('curr_top_menu');

                $html = array(
                    'content' => $this->load->view($data['content'], '', true)
                        //'top_menu' => $this->load->view($data['top_menu'], '', true),
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

        if ($this->professor_m->delete_record($this->input->post('id_professor'))) {

            $this->log->save("PROFESSOR REMOVIDO: ID '" . $this->input->post('id_professor') . "'");

            $this->session->set_userdata('curr_content', 'professor');
            $this->session->set_userdata('curr_top_menu', 'menus/cursos.php');

            $data['content'] = $this->session->userdata('curr_content');
            //$data['top_menu'] = $this->session->userdata('curr_top_menu');

            $html = array(
                'content' => $this->load->view($data['content'], '', true)
                    //'top_menu' => $this->load->view($data['top_menu'], '', true),
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
    
    function sugestao_genero(){
        $result = $this->professor_m->sugestao_genero($this->uri->segment(3));
        if($result == "I"){
            $this->load->model('educando_m');
            $result = $this->educando_m->sugestao_genero($this->uri->segment(3));
        }
        echo $result;
    }
    
    function sugestao_disciplina(){
        echo $this->professor_m->sugestao_disciplina($this->uri->segment(3));
    }

}

?>