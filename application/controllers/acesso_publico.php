<?php

class Acesso_publico extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->database();   // Loading Database 
        $this->load->library('session'); // Loading Session
        $this->load->helper('url');   // Loading Helper

        $this->load->model('acesso_publico_m');
    }

    function index() {
        $html = array(
            'content' => $this->load->view('inicio_publico', '', true)
        );
        $response = array(
            'success' => true,
            'html' => $html
        );
        echo json_encode($response);
    }

    function gerenciar_index() {

        $this->session->set_userdata('curr_content', 'gerenciar_conta_publica');

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

    function sign_in() {

        // Checks if account is allowed to sign in on system
        $email = trim($this->input->post('email'));
        $senha = md5($this->input->post('senha'));
        if (($account_data = $this->acesso_publico_m->allow($email, $senha))) {

            $user_data = array(
                'name' => $account_data->nome,
                'id' => $account_data->id,
                'password' => $senha,
                'email' => $email,
                'id_cidade' => $account_data->id_cidade,
                'is_logged_in' => true,
                'publico' => true,
                'curr_content' => 'inicio_publico',
                'curr_top_menu' => 'menus/publico.php',
                'curr_course_info' => 'blank.php'
            );

            // Set data array on user session
            $this->session->set_userdata($user_data);

            $this->log->save("LOGIN PUBLICO: $email");
            $data['content'] = $this->session->userdata('curr_content');
            $data['top_menu'] = $this->session->userdata('curr_top_menu');
            $data['course_info'] = $this->session->userdata('curr_course_info');

            $html = array(
                'content' => $this->load->view($data['content'], '', true),
                'top_menu' => $this->load->view($data['top_menu'], '', true),
                'course_info' => $this->load->view($data['course_info'], '', true)
            );

            $response = array(
                'success' => true,
                'html' => $html
            );
        } else {
            $response = array(
                'success' => false,
                'message' => "Email ou Senha incorreta!"
            );
        }


        echo json_encode($response);
    }

    function password_reset() {
        $senha = $this->input->post('nova_senha');
        if (strlen($senha) < 5) {
            echo json_encode(array(
                'success' => false,
                'message' => 'A senha nova deve ter no minimo 5 caracteres'
            ));
            return;
        }
        $id = $this->session->userdata('id');
        $senha_atual = md5($this->input->post('senha_atual'));
        $senha_nova = md5($senha);

        if (($this->acesso_publico_m->update_password($id, $senha_atual, $senha_nova))) {

            $this->log->save("SENHA DE ACESSO PUBLICO ATUALIZADA: $id");

            $html = array(
                'content' => $this->load->view($this->session->userdata('curr_content'), '', true)
            );

            $response = array(
                'success' => true,
                'message' => "Senha atualizada com sucesso",
                'html' => $html
            );
        } else {

            $response = array(
                'success' => false,
                'message' => "Falha ao atualizar senha. Verifique se a senha atual está correta"
            );
        }

        echo json_encode($response);
    }

    function update() {

        $id = $this->session->userdata('id');
        $data = Array(
            "nome" => trim($this->input->post('nome')),
            "id_cidade" => trim($this->input->post('municipio'))
        );

        if ($this->acesso_publico_m->update($id, $data)) {

            $this->log->save("DADOS DE ACESSO PUBLICO ATUALIZADO :$id");

            $this->session->set_userdata('name', $data['nome']);
            $this->session->set_userdata('id_cidade', $data['id_cidade']);

            $html = array(
                'content' => $this->load->view($this->session->userdata('curr_content'), '', true),
                'top_menu' => $this->load->view($this->session->userdata('curr_top_menu'), '', true)
            );

            $response = array(
                'success' => true,
                'message' => "Dados atualizado com sucesso",
                'html' => $html
            );
        } else {

            $response = array(
                'success' => false,
                'message' => "Falha ao atualizar ddados"
            );
        }

        echo json_encode($response);
    }

    function email_reset() {

        $id = $this->session->userdata('id');
        $senha_atual = md5($this->input->post('senha_atual_email'));
        $novo_email = trim($this->input->post('novo_email'));

        if ($this->acesso_publico_m->update_email($id, $senha_atual, $novo_email)) {

            $this->log->save("EMAIL DE ACESSO PUBLICO ATUALIZADO :$id");

            $this->session->set_userdata('email', $novo_email);

            $html = array(
                'content' => $this->load->view($this->session->userdata('curr_content'), '', true)
            );

            $response = array(
                'success' => true,
                'message' => "Email atualizado com sucesso",
                'html' => $html
            );
        } else {

            $response = array(
                'success' => false,
                'message' => "Falha ao atualizar email",
                'email' => $this->session->userdata('email')
            );
        }

        echo json_encode($response);
    }

    function signup() {

        $captcha = $this->input->post('captcha');

        require('.\vendor\google\recaptcha\src\autoload.php');

        $secret = "6LfMWCMTAAAAAOWQFgfqw9pToMzC-qOxm4tPGW7g";

        $response = null;

        $reCaptcha = new \ReCaptcha\ReCaptcha($secret);
        if ($captcha) {
            $response = $reCaptcha->verify($captcha);
            if ($response != null && $response->isSuccess()) {

                $senha = $this->input->post('senha');

                if (strlen($senha) < 5) {
                    echo json_encode(array(
                        'success' => false,
                        'message' => 'A senha deve ter no minimo 5 caracteres'
                    ));
                    return;
                }

                $pessoa = array(
                    'nome' => trim($this->input->post('nome')),
                    'id_cidade' => trim($this->input->post('municipio')),
                    'email' => trim($this->input->post('email')),
                    'senha' => md5($senha),
                    'data_criacao' => date('Y-m-d H:i:s')
                );

                // Starts transaction
                $this->db->trans_begin();

                if (($inserted_id = $this->acesso_publico_m->signup($pessoa))) {

                    $this->log->save("USUÁRIO COM ACESSO PÚBLICO CADASTRADO: ID '" . $inserted_id . "'");

                    $this->db->trans_commit();

                    $html = array(
                        'content' => $this->load->view('loginpublico.php', '', true)
                    );

                    $response = array(
                        'success' => true,
                        'html' => $html,
                        'message' => 'Cadastro efetuado'
                    );

                    // Duplicate entry for EMAIL key
                } else if ($this->db->_error_number() == 1062) {

                    $this->db->trans_rollback();

                    $response = array(
                        'success' => false,
                        'message' => 'E-mail informado já cadastrado'
                    );
                } else {
                    $this->db->trans_rollback();

                    $response = array(
                        'success' => false,
                        'message' => 'Falha ao efetuar cadastro da sua conta'
                    );
                }
            } else {
                $this->db->trans_rollback();

                $response = array(
                    'success' => false,
                    'message' => 'Falha na requisição do Recaptcha'
                );                
            }
        } else {
            $this->db->trans_rollback();

            $response = array(
                'success' => false,
                'message' => 'Por favor, valide o captcha!'
            );
        }

        echo json_encode($response);
    }

}
