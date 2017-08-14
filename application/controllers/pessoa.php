<?php

class Pessoa extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->database();   // Loading Database
        $this->load->library('session'); // Loading Session
        $this->load->helper('url');  // Loading Helper

        $this->load->model('pessoa_m');
    }

    function index() {

        $this->session->set_userdata('curr_content', 'cadastro_pessoa');
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

        $pessoa['id'] = 0;

        $this->session->set_userdata('curr_content', 'formulario_cad_pessoa');
        $this->session->set_userdata('curr_top_menu', 'menus/principal.php');

        $data['content'] = $this->session->userdata('curr_content');
        //$data['top_menu'] = $this->session->userdata('curr_top_menu');

        $valores['pessoa'] = $pessoa;
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

        $pessoa['id'] = $this->input->post('id_pessoa');

        if ($dados = $this->pessoa_m->get_record($pessoa['id'])) {

            $dados[0]->data_nascimento = implode("/", array_reverse(explode("-", $dados[0]->data_nascimento), true));

            $this->session->set_userdata('curr_content', 'formulario_cad_pessoa');
            $this->session->set_userdata('curr_top_menu', 'menus/principal.php');

            $data['content'] = $this->session->userdata('curr_content');
            //$data['top_menu'] = $this->session->userdata('curr_top_menu');

            $valores['dados'] = $dados;
            $valores['pessoa'] = $pessoa;
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

        if ($this->input->post('ckTelefone2') == 'true') {
            $tel2 = "NAOINFORMADO";
        } else {
            $tel2 = $this->input->post('telefone2');
        }

        $pessoa = array(
            'cpf' => trim($this->input->post('cpf')),
            'rg' => trim($this->input->post('rg')),
            'rg_emissor' => trim($this->input->post('rg_emissor')),
            'nome' => trim($this->input->post('nome')),
            'genero' => trim($this->input->post('sexo')),
            'data_nascimento' => implode("-", array_reverse(explode("/", $this->input->post('data_nascimento')), true)),
            'telefone_1' => trim($this->input->post('telefone1')),
            'telefone_2' => $tel2,
            'logradouro' => trim($this->input->post('rua')),
            'numero' => trim($this->input->post('numero')),
            'complemento' => trim($this->input->post('complemento')),
            'bairro' => trim($this->input->post('bairro')),
            'cep' => trim($this->input->post('cep')),
            'id_cidade' => trim($this->input->post('municipio')),
            'id_funcao' => trim($this->input->post('funcao')),
            'id_superintendencia' => trim($this->input->post('superintendencia'))
        );

        // Starts transaction
        $this->db->trans_begin();

        if ($inserted_id = $this->pessoa_m->add_record($pessoa)) {

            $conta = array(
                'email' => trim($this->input->post('email')),
                'senha' => md5($this->input->post('cpf')),
                'ativo_inativo' => 'A',
                'data_criacao' => date('Y-m-d H:i:s'),
                //'codigo_controle' => hash('md5', trim($this->input->post('cpf'))),
                'id_pessoa' => $inserted_id
            );

            if ($this->pessoa_m->add_record_conta($conta)) {

                $this->log->save("USUÁRIO ADICIONADO: ID '" . $inserted_id . "'");

                $this->db->trans_commit();

                $this->session->set_userdata('curr_content', 'cadastro_pessoa');
                $this->session->set_userdata('curr_top_menu', 'menus/principal.php');

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
                    'message' => 'Falha ao efetuar cadastro ' . $pessoa['cpf']
                );
            }

            // Duplicate entry for CPF key
        } else if ($this->db->_error_number() == 1062) {

            $this->db->trans_rollback();

            $response = array(
                'success' => false,
                'message' => 'CPF informado já cadastrado'
            );
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

        if ($this->input->post('ckTelefone2') == 'true') {
            $tel2 = "NAOINFORMADO";
        } else {
            $tel2 = $this->input->post('telefone2');
        }

        $pessoa = array(
            'cpf' => trim($this->input->post('cpf')),
            'rg' => trim($this->input->post('rg')),
            'rg_emissor' => trim($this->input->post('rg_emissor')),
            'nome' => trim($this->input->post('nome')),
            'genero' => trim($this->input->post('sexo')),
            'data_nascimento' => implode("-", array_reverse(explode("/", $this->input->post('data_nascimento')), true)),
            'telefone_1' => trim($this->input->post('telefone1')),
            'telefone_2' => $tel2,
            'logradouro' => trim($this->input->post('rua')),
            'numero' => trim($this->input->post('numero')),
            'complemento' => trim($this->input->post('complemento')),
            'bairro' => trim($this->input->post('bairro')),
            'cep' => trim($this->input->post('cep')),
            'id_cidade' => trim($this->input->post('municipio')),
            'id_funcao' => trim($this->input->post('funcao')),
            'id_superintendencia' => trim($this->input->post('superintendencia'))
        );

        // Starts transaction
        $this->db->trans_begin();

        if ($inserted_id = $this->pessoa_m->update_record($pessoa, $this->input->post('id'))) {

            $conta = array(
                'email' => trim($this->input->post('email'))
            );

            if ($this->pessoa_m->update_record_conta($conta, $this->input->post('id'))) {

                $this->log->save("USUÁRIO ATUALIZADO: ID '" . $this->input->post('id') . "'");

                $this->db->trans_commit();

                $this->session->set_userdata('curr_content', 'cadastro_pessoa');
                $this->session->set_userdata('curr_top_menu', 'menus/principal.php');

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

    function deactivate() {

        // Starts transaction
        $this->db->trans_begin();

        $this->load->model('conta');

        if ($this->pessoa_m->toggle_record($this->input->post('id_pessoa'), 'I')) {

            if ($this->pessoa_m->toggle_record_conta($this->input->post('id_pessoa'), 'I')) {

                $this->log->save("USUÁRIO DESATIVADO: ID '" . $this->input->post('id_pessoa') . "'");

                $this->db->trans_commit();

                $this->session->set_userdata('curr_content', 'cadastro_pessoa');
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

                $this->db->trans_rollback();

                $response = array(
                    'success' => false,
                    'message' => 'Falha ao desativar cadastro 1'
                );
            }
        } else {

            $this->db->trans_rollback();

            $response = array(
                'success' => false,
                'message' => 'Falha ao desativar cadastro 2'
            );
        }

        echo json_encode($response);
    }

    function reactivate() {

        // Starts transaction
        $this->db->trans_begin();

        if ($this->pessoa_m->toggle_record($this->input->post('id_pessoa'), 'A')) {

            if ($this->pessoa_m->toggle_record_conta($this->input->post('id_pessoa'), 'A')) {

                $this->log->save("USUÁRIO REATIVADO: ID '" . $this->input->post('id_pessoa') . "'");

                $this->db->trans_commit();

                $this->session->set_userdata('curr_content', 'cadastro_pessoa');
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

                $this->db->trans_rollback();

                $response = array(
                    'success' => false,
                    'message' => 'Falha ao reativar cadastro'
                );
            }
        } else {

            $this->db->trans_rollback();

            $response = array(
                'success' => false,
                'message' => 'Falha ao reativar cadastro'
            );
        }

        echo json_encode($response);
    }

    function reset_password() {
        // Starts transaction
        $this->db->trans_begin();

        $this->load->model('conta');

        $cpf = $this->input->post('cpf');

        if ($id = ($this->conta->reset_password($cpf, $cpf))) {

            $this->log->save("SENHA DE USUÁRIO RESETADA: ID '" . $id . "'");

            $this->db->trans_commit();

            $this->session->set_userdata('curr_content', 'cadastro_pessoa');
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
                'message' => 'Senha resetada'
            );
        } else {

            $this->db->trans_rollback();

            $response = array(
                'success' => false,
                'message' => 'Esta senha já está resetada!'
            );
        }

        echo json_encode($response);
    }

}
