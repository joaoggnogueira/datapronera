<?php

class Assentamento extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->database();   // Loading Database 
        $this->load->library('session'); // Loading Session
        $this->load->helper('url');  // Loading Helper

        $this->load->model('superintendencia_m');
    }

    function index() {

        $this->session->set_userdata('curr_content', 'cadastro_assentamento');
        $this->session->set_userdata('curr_top_menu', 'menus/principal.php');

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

        $superintendencia['id'] = 0;

        $this->session->set_userdata('curr_content', 'formulario_cad_superintendencia');
        $this->session->set_userdata('curr_top_menu', 'menus/principal.php');

        $data['content'] = $this->session->userdata('curr_content');
        //$data['top_menu'] = $this->session->userdata('curr_top_menu');

        $valores['superintendencia'] = $superintendencia;
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

        $superintendencia['id'] = $this->input->post('id_super');

        if ($dados = $this->superintendencia_m->get_record($superintendencia['id'])) {

            $this->session->set_userdata('curr_content', 'formulario_cad_superintendencia');
            $this->session->set_userdata('curr_top_menu', 'menus/principal.php');

            $data['content'] = $this->session->userdata('curr_content');
            //$data['top_menu'] = $this->session->userdata('curr_top_menu');

            $valores['dados'] = $dados;
            $valores['superintendencia'] = $superintendencia;
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
                'message' => 'Falha na requisição. Tente novamente em instantes.'
            );
        }

        echo json_encode($response);
    }

    function add() {

        $data = array(
            'nome' => trim($this->input->post('nome')),
            'nome_responsavel' => trim($this->input->post('responsavel')),
            'ativo_inativo' => 'A',
            'id_estado' => trim($this->input->post('estado'))
        );

        if ($inserted_id = $this->superintendencia_m->add_record($data)) {

            $this->log->save("SUPERINTENDÊNCIA ADICIONADA: ID '" . $inserted_id . "'");

            $this->session->set_userdata('curr_content', 'cadastro_super');
            $this->session->set_userdata('curr_top_menu', 'menus/principal.php');

            $data['content'] = $this->session->userdata('curr_content');
            $data['top_menu'] = $this->session->userdata('curr_top_menu');

            $html = array(
                'content' => $this->load->view($data['content'], '', true),
                'top_menu' => $this->load->view($data['top_menu'], '', true)
            );

            $response = array(
                'success' => true,
                'html' => $html,
                'message' => 'Cadastro eftuado'
            );
        } else {

            $response = array(
                'success' => false,
                'message' => 'Falha ao eftuar cadastro'
            );
        }

        echo json_encode($response);
    }

    function update() {

        $data = array(
            'nome' => trim($this->input->post('nome')),
            'nome_responsavel' => trim($this->input->post('responsavel')),
            'id_estado' => $this->input->post('estado'),
            'ativo_inativo' => 'A'
        );

        if ($this->superintendencia_m->update_record($data, $this->input->post('id'))) {

            $this->log->save("SUPERINTENDÊNCIA ATUALIZADA: ID '" . $this->input->post('id') . "'");

            $this->session->set_userdata('curr_content', 'cadastro_super');
            $this->session->set_userdata('curr_top_menu', 'menus/principal.php');

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

    function deactivate() {

        if ($this->superintendencia_m->toggle_record($this->input->post('id_super'), 'I')) {

            $this->log->save("SUPERINTENDÊNCIA DESATIVADA: ID '" . $this->input->post('id_super') . "'");

            $this->session->set_userdata('curr_content', 'cadastro_super');
            $this->session->set_userdata('curr_top_menu', 'menus/principal.php');

            $data['content'] = $this->session->userdata('curr_content');
            //$data['top_menu'] = $this->session->userdata('curr_top_menu');

            $html = array(
                'content' => $this->load->view($data['content'], '', true)
                    //'top_menu' => $this->load->view($data['top_menu'], '', true)
            );

            $response = array(
                'success' => true,
                'html' => $html,
                'message' => 'Cadastro desativado'
            );
        } else {

            $response = array(
                'success' => false,
                'message' => 'Falha ao desativar cadastro'
            );
        }

        echo json_encode($response);
    }

    function reactivate() {

        if ($this->superintendencia_m->toggle_record($this->input->post('id_super'), 'A')) {

            $this->log->save("SUPERINTENDÊNCIA REATIVADA: ID '" . $this->input->post('id_super') . "'");

            $this->session->set_userdata('curr_content', 'cadastro_super');
            $this->session->set_userdata('curr_top_menu', 'menus/principal.php');

            $data['content'] = $this->session->userdata('curr_content');
            //$data['top_menu'] = $this->session->userdata('curr_top_menu');

            $html = array(
                'content' => $this->load->view($data['content'], '', true)
                    //'top_menu' => $this->load->view($data['top_menu'], '', true)
            );

            $response = array(
                'success' => true,
                'html' => $html,
                'message' => 'Cadastro reativado'
            );
        } else {

            $response = array(
                'success' => false,
                'message' => 'Falha ao reativar cadastro'
            );
        }

        echo json_encode($response);
    }

}
