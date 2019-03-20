<?php

class Parceiro extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->database();   // Loading Database 
        $this->load->library('session'); // Loading Session
        $this->load->helper('url');  // Loading Helper

        $this->load->model('parceiro_m');
    }

    function index() {

        $this->session->set_userdata('curr_content', 'parceiro');
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

        $parceiro['id'] = 0;

        $this->session->set_userdata('curr_content', 'formulario_parceiro');
        $this->session->set_userdata('curr_top_menu', 'menus/cursos.php');

        $data['content'] = $this->session->userdata('curr_content');
        //$data['top_menu'] = $this->session->userdata('curr_top_menu');

        $valores['dados'] = null;
        $valores['has_parceria'] = null;
        $valores['parceiro'] = $parceiro;
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

        $parceiro['id'] = $this->input->post('id_parceiro');

        if ($dados = $this->parceiro_m->get_record($parceiro['id'])) {

            $this->session->set_userdata('curr_content', 'formulario_parceiro');
            $this->session->set_userdata('curr_top_menu', 'menus/cursos.php');

            $data['content'] = $this->session->userdata('curr_content');
            //$data['top_menu'] = $this->session->userdata('curr_top_menu');

            $valores['dados'] = $dados;
            $valores['parceiro'] = $parceiro;
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
                'message' => 'Falha ao atualizar cadastro'
            );
        }

        echo json_encode($response);
    }

    function add() {

        if ($this->input->post('ckParceiro_site') == 'true') {
            $site = "NAOINFORMADO";
        } else {
            $site = $this->input->post('parceiro_site');
        }

        if ($this->input->post('ckParceiro_tel2') == 'true') {
            $tel2 = "NAOAPLICA";
        } else {
            $tel2 = trim($this->input->post('parceiro_tel2'));
        }

        $natureza = $this->input->post('rparceiro_natureza');
        $natureza_descricao = "";
        if ($natureza == "OUTROS") {
            $natureza_descricao = $this->input->post('parceiro_natureza_outros');
        }

        $tipo = $this->input->post('rparceiro_tipo');
        $tipo_outros = "";

        $realizacao = $gestao = $certificacao = $outros = $colegiado = $demandante = 0;

        if ($this->input->post('ckparceiro_tipo_01') == 'true') {
            $realizacao = 1;
        }

        if ($this->input->post('ckparceiro_tipo_02') == 'true') {
            $certificacao = 1;
        }

        if ($this->input->post('ckparceiro_tipo_03') == 'true') {
            $gestao = 1;
        }

        if ($this->input->post('ckparceiro_tipo_04') == 'true') {
            $demandante = 1;
        }

        if ($this->input->post('ckparceiro_tipo_05') == 'true') {
            $colegiado = 1;
        }

        if ($this->input->post('ckparceiro_tipo_outro') == 'true') {
            $tipo_outros = $this->input->post('parceiro_tipo_outros');
            $outros = 1;
        }

        $data = array(
            'nome' => trim($this->input->post('parceiro_nome')),
            'sigla' => trim($this->input->post('parceiro_sigla')),
            'rua' => trim($this->input->post('parceiro_rua')),
            'numero' => trim($this->input->post('parceiro_numero')),
            'complemento' => trim($this->input->post('parceiro_complemento')),
            'bairro' => trim($this->input->post('parceiro_bairro')),
            'cep' => trim($this->input->post('parceiro_cep')),
            'telefone1' => trim($this->input->post('parceiro_tel1')),
            'telefone2' => $tel2,
            'pagina_web' => trim($site),
            'id_cidade' => trim($this->input->post('parceiro_sel_mun')),
            'natureza' => trim($natureza),
            'natureza_descricao' => trim($natureza_descricao),
            'abrangencia' => trim($this->input->post('rparceiro_abrangencia')),
            'id_curso' => trim($this->session->userdata('id_curso'))
        );

        // Starts transaction
        $this->db->trans_begin();

        if ($inserted_id = $this->parceiro_m->add_record($data)) {

            $data_tipo = array(
                'realizacao' => $realizacao,
                'certificacao' => $certificacao,
                'gestao' => $gestao,
                'outros' => $outros,
                'demandante' => $demandante,
                'colegiado' => $colegiado,
                'complemento' => $tipo_outros,
                'id_parceiro' => $inserted_id
            );


            if ($this->parceiro_m->add_record_tipo_parceria($data_tipo)) {

                $this->log->save("PARCEIRO ADICIONADO: ID '" . $inserted_id . "'");

                $this->db->trans_commit();

                $this->session->set_userdata('curr_content', 'parceiro');
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

        if ($this->input->post('ckParceiro_site') == 'true') {
            $site = "NAOINFORMADO";
        } else {
            $site = $this->input->post('parceiro_site');
        }

        if ($this->input->post('ckParceiro_tel2') == 'true') {
            $tel2 = "NAOAPLICA";
        } else {
            $tel2 = trim($this->input->post('parceiro_tel2'));
        }

        $natureza = $this->input->post('rparceiro_natureza');
        $natureza_descricao = "";
        if ($natureza == "OUTROS") {
            $natureza_descricao = $this->input->post('parceiro_natureza_outros');
        }

        $tipo = $this->input->post('rparceiro_tipo');
        $tipo_outros = "";

        $realizacao = $gestao = $certificacao = $outros = $colegiado = $demandante = 0;

        if ($this->input->post('ckparceiro_tipo_01') == 'true') {
            $realizacao = 1;
        }

        if ($this->input->post('ckparceiro_tipo_02') == 'true') {
            $certificacao = 1;
        }

        if ($this->input->post('ckparceiro_tipo_03') == 'true') {
            $gestao = 1;
        }
        if ($this->input->post('ckparceiro_tipo_04') == 'true') {
            $demandante = 1;
        }

        if ($this->input->post('ckparceiro_tipo_05') == 'true') {
            $colegiado = 1;
        }

        if ($this->input->post('ckparceiro_tipo_outro') == 'true') {
            $tipo_outros = $this->input->post('parceiro_tipo_outros');
            $outros = 1;
        }

        $data = array(
            'nome' => trim($this->input->post('parceiro_nome')),
            'sigla' => trim($this->input->post('parceiro_sigla')),
            'rua' => trim($this->input->post('parceiro_rua')),
            'numero' => trim($this->input->post('parceiro_numero')),
            'complemento' => trim($this->input->post('parceiro_complemento')),
            'bairro' => trim($this->input->post('parceiro_bairro')),
            'cep' => trim($this->input->post('parceiro_cep')),
            'telefone1' => trim($this->input->post('parceiro_tel1')),
            'telefone2' => $tel2,
            'pagina_web' => trim($site),
            'id_cidade' => trim($this->input->post('parceiro_sel_mun')),
            'natureza' => trim($natureza),
            'natureza_descricao' => trim($natureza_descricao),
            'abrangencia' => trim($this->input->post('rparceiro_abrangencia')),
            'id_curso' => trim($this->session->userdata('id_curso'))
        );

        // Starts transaction
        $this->db->trans_begin();

        if ($inserted_id = $this->parceiro_m->update_record($data, $this->input->post('id'))) {

            $data_tipo = array(
                'realizacao' => $realizacao,
                'certificacao' => $certificacao,
                'gestao' => $gestao,
                'outros' => $outros,
                'demandante' => $demandante,
                'colegiado' => $colegiado,
                'complemento' => $tipo_outros,
                'id_parceiro' => $this->input->post('id')
            );

            if ($this->parceiro_m->update_record_tipo_parceria($data_tipo, $this->input->post('id'))) {

                $this->log->save("PARCEIRO ATUALIZADO: ID '" . $this->input->post('id') . "'");

                $this->db->trans_commit();

                $this->session->set_userdata('curr_content', 'parceiro');
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

        if ($this->parceiro_m->delete_record($this->input->post('id_parceiro'))) {

            $this->log->save("PARCEIRO REMOVIDO: ID '" . $this->input->post('id_parceiro') . "'");

            $this->session->set_userdata('curr_content', 'parceiro');
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
                'html' => $html,
                'message' => 'Falha ao remover cadastro'
            );
        }

        echo json_encode($response);
    }

    function get_estado($id_parceiro) {

        echo ($estado = $this->parceiro_m->get_estado($id_parceiro)) ? $estado : null;
    }

    function get_municipio($id_parceiro) {

        echo ($municipio = $this->parceiro_m->get_municipio($id_parceiro)) ? $municipio : null;
    }

}
