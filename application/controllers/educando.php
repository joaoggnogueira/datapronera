<?php

class Educando extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->database();   // Loading Database 
        $this->load->library('session'); // Loading Session
        $this->load->helper('url');  // Loading Helper

        $this->load->model('educando_m');
        $this->load->model('caracterizacao_m');
    }

    function index() {

        $this->session->set_userdata('curr_content', 'educando');
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

        $educando['id'] = 0;

        if ($dados = $this->educando_m->get_course_record($this->session->userdata('id_curso'))) {

            $this->session->set_userdata('curr_content', 'formulario_educando');
            $this->session->set_userdata('curr_top_menu', 'menus/cursos.php');

            $data['content'] = $this->session->userdata('curr_content');

            $valores['dados'] = $dados;
            $valores['educando'] = $educando;
            $valores['operacao'] = $this->input->post('operacao');


            $municipio_estado = $this->educando_m->get_estado_municipio($educando['id']);
            if (!isset($municipio_estado)) {
                $municipio_estado[0]['estado'] == 0;
                $municipio_estado[0]['cidade'] == 0;
            }
            $valores['municipio_estado'] = $municipio_estado;

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

    function index_update() {

        $educando['id'] = $this->input->post('id_educando');

        if ($dados = $this->educando_m->get_record($educando['id'])) {

            $this->session->set_userdata('curr_content', 'formulario_educando');
            $this->session->set_userdata('curr_top_menu', 'menus/cursos.php');

            $data['content'] = $this->session->userdata('curr_content');
            //$data['top_menu'] = $this->session->userdata('curr_top_menu');

            $dados[0]->data_nascimento = implode("/", array_reverse(explode("-", $dados[0]->data_nascimento), true));
            $valores['dados'] = $dados;
            $valores['educando'] = $educando;
            $valores['operacao'] = $this->input->post('operacao');

            $municipio_estado = $this->educando_m->get_estado_municipio($educando['id']);
            if (!isset($municipio_estado)) {
                $municipio_estado[0]['estado'] == 0;
                $municipio_estado[0]['cidade'] == 0;
            }
            $valores['municipio_estado'] = $municipio_estado;
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

        if ($this->input->post('ckSexo_ni') == 'true') {
            $sexo = 'N';
        } else
            $sexo = $this->input->post('reducando_sexo');

        if ($this->input->post('ckEducando_data_nasc') == 'true') {
            $data_nascimento = '1900-01-01';
        } else {
            $data_nascimento = implode("-", array_reverse(explode("/", $this->input->post('educando_data_nasc')), true));
        }

        if ($this->input->post('ckEducando_idade') == 'true') {
            $idade = '-1';
        } else {
            $idade = $this->input->post('educando_idade');
        }

        if ($this->input->post('ckEducandoConcluinte_ni') == 'true') {
            $concluinte = 'I';
        } else {
            $concluinte = $this->input->post('reducando_concluinte');
        }

        $cpf = ($this->input->post('ckCPF_ni') == 'true') ? 'NAOINFORMADO' :
                trim($this->input->post('educando_cpf'));

        $cpf = ($this->input->post('ckCPF_na') == 'true') ? 'NAOAPLICA' :
                $cpf;

        $rg = ($this->input->post('ckRg_ni') == 'true') ? 'NAOINFORMADO' :
                trim($this->input->post('educando_rg'));

        $rg = ($this->input->post('ckRg_na') == 'true') ? 'NAOAPLICA' :
                $rg;

        $data = array(
            'nome' => trim($this->input->post('educando_nome')),
            'rg' => $rg,
            'cpf' => $cpf,
            'genero' => trim($sexo),
            'data_nascimento' => trim($data_nascimento),
            'idade' => trim($idade),
            'tipo_territorio' => trim($this->input->post('educando_tipo_terr')),
            'nome_territorio' => trim($this->input->post('educando_nome_terr')),
            'code_sipra_assentamento' => trim($this->input->post('terr_sipra_code')),
            'concluinte' => trim($concluinte),
            'id_curso' => $this->session->userdata('id_curso')
        );

        // Starts transaction
        $this->db->trans_begin();

        if (($inserted_id = $this->educando_m->add_record($data))) {
            $ckEst_ni = $this->input->post("ckEst_ni");
            if (($ckEst_ni != "true" && $municipios = $this->input->post('municipios'))) {

                $data_mun = array(
                    'id_educando' => $inserted_id,
                    'id_cidade' => $municipios
                );

                if (!$this->educando_m->add_record_municipio($data_mun)) {

                    $response = array(
                        'success' => false,
                        'message' => 'Falha ao vincular municipio',
                    );
                    echo json_encode($response);
                    return;
                }
                $this->log->save("MUNICÍPIO '" . $data_mun['id_cidade'] . "' ADICIONADO: EDUCANDO ID '" . $inserted_id . "'");
            }

            if ($this->input->post('atualizar_ic') == 1) {

                $data_curso = array(
                    'inicio_realizado' => $this->input->post('inicio_curso')
                );

                $this->caracterizacao_m->update_inicio_curso($data_curso, $this->session->userdata('id_curso'));

                $this->log->save("DATA INÍCIO CURSO ATUALIZADA: CURSO ID '" . $this->session->userdata('id_curso') . "'");
            }

            if ($this->db->trans_status() !== false) {

                $this->log->save("EDUCANDO ADICIONADO: ID '" . $inserted_id . "'");

                $this->db->trans_commit();

                $this->session->set_userdata('curr_content', 'educando');
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
                    'message' => 'Cadastro efetuado com sucesso'
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

        if ($this->input->post('ckSexo_ni') == 'true') {
            $sexo = 'N';
        } else
            $sexo = $this->input->post('reducando_sexo');

        if ($this->input->post('ckEducando_data_nasc') == 'true') {
            $data_nascimento = '1900-01-01';
        } else {
            $data_nascimento = implode("-", array_reverse(explode("/", $this->input->post('educando_data_nasc')), true));
        }

        if ($this->input->post('ckEducando_idade') == 'true') {
            $idade = '-1';
        } else {
            $idade = $this->input->post('educando_idade');
        }

        if ($this->input->post('ckEducandoConcluinte_ni') == 'true') {
            $concluinte = 'I';
        } else {
            $concluinte = $this->input->post('reducando_concluinte');
        }

        $cpf = ($this->input->post('ckCPF_ni') == 'true') ? 'NAOINFORMADO' : trim($this->input->post('educando_cpf'));
        $cpf = ($this->input->post('ckCPF_na') == 'true') ? 'NAOAPLICA' : $cpf;
        $rg = ($this->input->post('ckRg_ni') == 'true') ? 'NAOINFORMADO' : trim($this->input->post('educando_rg'));
        $rg = ($this->input->post('ckRg_na') == 'true') ? 'NAOAPLICA' : $rg;

        $data = array(
            'nome' => trim($this->input->post('educando_nome')),
            'rg' => $rg,
            'cpf' => $cpf,
            'genero' => trim($sexo),
            'data_nascimento' => trim($data_nascimento),
            'idade' => trim($idade),
            'tipo_territorio' => trim($this->input->post('educando_tipo_terr')),
            'nome_territorio' => trim($this->input->post('educando_nome_terr')),
            'code_sipra_assentamento' => trim($this->input->post('terr_sipra_code')),
            'concluinte' => trim($concluinte),
            'id_curso' => $this->session->userdata('id_curso')
        );

        // Starts transaction
        $this->db->trans_begin();

        if ($this->educando_m->update_record($data, $this->input->post('id'))) {
            $ckEst_ni = $this->input->post("ckEst_ni");
            if ($ckEst_ni == "true") {
                if (!$this->educando_m->remove_record_municipio($this->input->post('id'))) {
                    $response = array(
                        'success' => false,
                        'message' => 'Falha desvincular município',
                    );
                    echo json_encode($response);
                    return;
                }
            } else {
                if (($municipios = $this->input->post('municipios'))) {
                    $data_mun = array(
                        'id_cidade' => $municipios
                    );
                    
                    $record_total = $this->educando_m->get_educando_cidade($this->input->post('id'));
                    if(count($record_total) == 0){
                        $data_mun['id_educando'] = $this->input->post('id');
                        if (!$this->educando_m->add_record_municipio($data_mun)) {
                            $response = array(
                                'success' => false,
                                'message' => 'Falha ao vincular municipio',
                            );
                            echo json_encode($response);
                            return;
                        }
                    } else {
                        if (!$this->educando_m->update_record_municipio($data_mun, $this->input->post('id'))) {
                            $response = array(
                                'success' => false,
                                'message' => 'Falha ao alterar municipio',
                            );
                            echo json_encode($response);
                            return;
                        }
                    }
                    

                    $this->log->save("MUNICÍPIO '" . $data_mun['id_cidade'] . "' ADICIONADO: EDUCANDO ID '" . $this->input->post('id') . "'");
                }
            }
            if ($this->input->post('atualizar_ic') == 1) {

                $data_curso = array(
                    'inicio_realizado' => $this->input->post('inicio_curso')
                );

                $this->caracterizacao_m->update_inicio_curso($data_curso, $this->session->userdata('id_curso'));

                $this->log->save("DATA INÍCIO CURSO ATUALIZADA: CURSO ID '" . $this->session->userdata('id_curso') . "'");
            }

            if ($this->db->trans_status() !== false) {

                $this->log->save("EDUCANDO ATUALIZADO: ID '" . $this->input->post('id') . "'");

                $this->db->trans_commit();

                $this->session->set_userdata('curr_content', 'educando');
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

        if ($this->educando_m->delete_record($this->input->post('id_educando'))) {

            $this->log->save("EDUCANDO REMOVIDO: ID '" . $this->input->post('id_educando') . "'");

            $this->session->set_userdata('curr_content', 'educando');
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

    function get_tipo_acamp() {

        $query = $this->educando_m->get_tipo_acamp($this->uri->segment(3));
        echo $query;
    }
    
    function sugestao_genero(){
        echo $this->educando_m->sugestao_genero($this->uri->segment(3));
    }

}

?>