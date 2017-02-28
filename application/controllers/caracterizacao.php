<?php

class Caracterizacao extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->database();   // Loading Database 
        $this->load->library('session'); // Loading Session
        $this->load->helper('url');   // Loading Session

        $this->load->model('caracterizacao_m');
        $this->load->model('curso_m');
    }

    function index() {

        if ($dados = $this->caracterizacao_m->get_record($this->session->userdata('id_curso'))) {

            $this->session->set_userdata('curr_content', 'formulario_caracterizacao');
            $this->session->set_userdata('curr_top_menu', 'menus/cursos.php');

            $valores['dados'] = $dados;

            $data['content'] = $this->session->userdata('curr_content');
            //$data['top_menu'] = $this->session->userdata('curr_top_menu');

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

    function update() {

        if ($this->input->post('ckTitulo_coord_geral_ni') == 'true') {
            $titulacao_coord_geral_proj = "NAOINFORMADO";
        } else {
            $titulacao_coord_geral_proj = $this->input->post('rtitulo_coord_geral');
        }

        if ($this->input->post('ckCoord_proj_nome') == 'true') {
            $nome_coord_proj = "NAOAPLICA";
        } else {
            $nome_coord_proj = $this->input->post('nome_coord');
        }

        if ($this->input->post('ckTitulo_coord_ni') == 'true') {
            $titulacao_coord_proj = "NAOINFORMADO";
        } else if ($this->input->post('ckTitulo_coord_na') == 'true') {
            $titulacao_coord_proj = "NAOAPLICA";
        } else {
            $titulacao_coord_proj = $this->input->post('rtitulo_coord');
        }

        if ($this->input->post('ckVice_naplica') == 'true') {
            $nome_vice_coord_proj = "NAOAPLICA";
        } else {
            $nome_vice_coord_proj = $this->input->post('vice_nome');
        }

        if ($this->input->post('ckVice_titulo_ni') == 'true') {
            $titulacao_vice_coord_proj = "NAOINFORMADO";
        } else if ($this->input->post('ckVice_titulo_naplica') == 'true') {
            $titulacao_vice_coord_proj = "NAOAPLICA";
        } else {
            $titulacao_vice_coord_proj = $this->input->post('rvice_titulo');
        }

        if ($this->input->post('ckCoord_ped_naplica') == 'true') {
            $nome_coord_pedag_proj = "NAOAPLICA";
        } else {
            $nome_coord_pedag_proj = $this->input->post('nome_coord_pedag');
        }

        if ($this->input->post('ckTit_coord_pedag_ni') == 'true') {
            $titulacao_coord_pedag_proj = "NAOINFORMADO";
        } else if ($this->input->post('ckTit_coord_pedag_naplica') == 'true') {
            $titulacao_coord_pedag_proj = "NAOAPLICA";
        } else {
            $titulacao_coord_pedag_proj = $this->input->post('rTit_coord_pedag');
        }

        if ($this->input->post('ckCurso_duracao') == 'true') {
            $duracao_curso = "-1";
        } else {
            $duracao_curso = $this->input->post('duracao');
        }

        if ($this->input->post('ckCurso_previsto_inicio') == 'true') {
            $inicio_previsto = "NI";
        } else {
            $inicio_previsto = $this->input->post('previsto_inicio');
        }

        if ($this->input->post('ckCurso_previsto_termino') == 'true') {
            $termino_previsto = "NI";
        } else {
            $termino_previsto = $this->input->post('previsto_termino');
        }

        if ($this->input->post('ckCurso_realizado_inicio') == 'true') {
            $inicio_realizado = "NI";
        } else {
            $inicio_realizado = $this->input->post('realizado_inicio');
        }

        if ($this->input->post('ckCurso_realizado_termino') == 'true') {
            $termino_realizado = "NI";
        } else {
            $termino_realizado = $this->input->post('realizado_termino');
        }

        if ($this->input->post('ckCurso_finalizado') != 'true') {
            $curso_descr = "";
        } else {
            $curso_descr = "NAOCONCLUIDO";
        }

        if ($this->input->post('finalizacao_descrever') != "") {
            $curso_descr = $this->input->post('finalizacao_descrever');
        }

        if ($this->input->post('ckCurso_numero_turmas') == 'true') {
            $numero_turmas = "-1";
        } else {
            $numero_turmas = $this->input->post('numero_turmas');
        }

        if ($this->input->post('ckCurso_num_aluno_ingre') == 'true') {
            $numero_ingressantes = "-1";
        } else {
            $numero_ingressantes = $this->input->post('num_aluno_ingre');
        }

        if ($this->input->post('ckCurso_num_aluno_concl') == 'true') {
            $numero_concluintes = "-1";
        } else {
            $numero_concluintes = $this->input->post('num_aluno_concl');
        }

        if ($this->input->post('ckImpedimento_ni') == 'true') {
            $impedimento_curso = "NI";
        } else {
            $impedimento_curso = $this->input->post('rimpedimento');
        }

        if ($impedimento_curso == "SIM") {
            $impedimento_curso_descr = $this->input->post('impedimento_descrever');
        } else {
            $impedimento_curso_descr = "";
        }

        if ($this->input->post('ckReferencia_ni') == 'true') {
            $referencia_curso = "-1";
        } else {
            $referencia_curso = $this->input->post('rreferencia');
        }

        if ($this->input->post('ckMatriz_ni') == 'true') {
            $matriz_curricular_curso = "-1";
        } else {
            $matriz_curricular_curso = $this->input->post('ralteracao');
        }

        if ($this->input->post('ckDesdobramento_ni') == 'true') {
            $desdobramento = "NI";
        } else {
            $desdobramento = $this->input->post('rdesdobramento');
        }

        if ($desdobramento == "OUTROS") {
            $desdobramento_descr = $this->input->post('desdobramento_text_outros');
        } else {
            $desdobramento_descr = "";
        }

        if ($this->input->post('ckDocumentos_ni') == 'true') {
            $documentos_normativos = "NI";
        } else {
            $documentos_normativos = $this->input->post('rdoc');
        }

        if ($documentos_normativos == "SIM") {
            $documentos_normativos_descr = $this->input->post('doc_descrever');
        } else {
            $documentos_normativos_descr = "";
        }

        if ($this->input->post('ckEspaco_ni') == 'true') {
            $espaco_especifico = "NI";
        } else {
            $espaco_especifico = $this->input->post('respaco');
        }

        if ($espaco_especifico == "SIM") {
            $espaco_especifico_descr = $this->input->post('espaco_descrever');
        } else {
            $espaco_especifico_descr = "";
        }

        if ($this->input->post('ckAvaliacao_ni') == 'true') {
            $avaliacao_mec = "NI";
        } else {
            $avaliacao_mec = $this->input->post('ravaliacao');
        }

        if ($avaliacao_mec == "SIM") {
            $avaliacao_mec_descr = $this->input->post('avaliacao_descrever');
        } else {
            $avaliacao_mec_descr = "";
        }

        if ($this->input->post('ckCurso_num_bolsistas_ni') == 'true') {
            $numero_bolsistas = "-1";
        } else {
            $numero_bolsistas = $this->input->post('num_bolsistas');
        }

        if ($this->input->post('ckPrevisto_tempo_comunidade_ni') == 'true') {
            $previsto_tempo_comunidade = "-1";
        } else {
            $previsto_tempo_comunidade = $this->input->post('rPrevisto_tempo_comunidade');
        }

        $data = array(
            'area_conhecimento' => trim($this->input->post('area')),
            'nome_coordenador_geral' => trim($this->input->post('nome_coord_geral')),
            'titulacao_coordenador_geral' => trim($titulacao_coord_geral_proj),
            'nome_coordenador' => trim($nome_coord_proj),
            'titulacao_coordenador' => trim($titulacao_coord_proj),
            'nome_vice_coordenador' => trim($nome_vice_coord_proj),
            'titulacao_vice_coordenador' => trim($titulacao_vice_coord_proj),
            'nome_coordenador_pedagogico' => trim($nome_coord_pedag_proj),
            'titulacao_coordenador_pedagogico' => trim($titulacao_coord_pedag_proj),
            'duracao_curso' => trim($duracao_curso),
            'inicio_previsto' => trim($inicio_previsto),
            'termino_previsto' => trim($termino_previsto),
            'inicio_realizado' => trim($inicio_realizado),
            'termino_realizado' => trim($termino_realizado),
            'curso_descricao' => trim($curso_descr),
            'numero_turmas' => trim($numero_turmas),
            'numero_ingressantes' => trim($numero_ingressantes),
            'numero_concluintes' => trim($numero_concluintes),
            'impedimento_curso' => trim($impedimento_curso),
            'impedimento_curso_descricao' => trim($impedimento_curso_descr),
            'referencia_curso' => trim($referencia_curso),
            'matriz_curricular_curso' => trim($matriz_curricular_curso),
            'desdobramento' => trim($desdobramento),
            'desdobramento_descricao' => trim($desdobramento_descr),
            'documentos_normativos' => trim($documentos_normativos),
            'documentos_normativos_descricao' => trim($documentos_normativos_descr),
            'espaco_especifico' => trim($espaco_especifico),
            'espaco_especifico_descricao' => trim($espaco_especifico_descr),
            'avaliacao_mec' => trim($avaliacao_mec),
            'avaliacao_mec_descricao' => trim($avaliacao_mec_descr),
            'numero_bolsistas' => trim($numero_bolsistas),
            'previsto_tempo_comunidade' => trim($previsto_tempo_comunidade),
            'id_curso' => $this->session->userdata('id_curso')
        );

        // Starts transaction
        $this->db->trans_begin();

        if ($this->caracterizacao_m->update_record($data, $this->session->userdata('id_curso'))) {

            if ($this->input->post('modalidade') == 'OUTRA') {

                $modalidade = array(
                    'nome' => trim($this->input->post('modalidade_descricao')),
                    'descricao' => null,
                    'nivel' => null
                );

                // Inserts course's genre
                $id_modalidade = $this->curso_m->add_record_modalidade($modalidade);
            } else {
                $id_modalidade = $this->input->post('modalidade');
            }

            $curso = array(
                'id_modalidade' => $id_modalidade,
                'data'          => $this->input->post('data')
            );

            if ($this->curso_m->update_record($curso, $this->session->userdata('id_curso'))) {

                // Algoritmo BURRO!
                // $this->caracterizacao_m->delete_record_municipios($this->input->post('id'));

                if ($mun_excluidos = $this->input->post('mun_excluidos')) {

                    foreach ($mun_excluidos as $excluido) {

                        if (!$this->caracterizacao_m->delete_record_municipios($excluido, $this->input->post('id')))
                            break;
                    }
                }

                if ($municipios = $this->input->post('municipios')) {

                    foreach ($municipios as $municipio) {

                        if ($municipio[0] == 'N') {
                            $data_mun = array(
                                'id_caracterizacao' => $this->input->post('id'),
                                'id_cidade' => $municipio[1]
                            );

                            if (!$this->caracterizacao_m->add_record_municipios($data_mun))
                                break;
                        }
                    }
                }

                if ($this->db->trans_status() !== false) {

                    $this->log->save("FORM. CARACTERIZAÇÃO ATUALIZADO: CURSO ID '" . $this->session->userdata('id_curso') . "'");

                    $this->db->trans_commit();

                    // -- RECUPERA NOVOS DADOS ------------------------------------------------------

                    $valores['dados'] = $this->caracterizacao_m->get_record($this->session->userdata('id_curso'));
                    // -------------------------------------------------------------------------------

                    $this->session->set_userdata('curr_content', 'formulario_caracterizacao');
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

}
