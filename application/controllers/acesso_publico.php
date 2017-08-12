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

    function signup() {

        $pessoa = array(
            'nome' => trim($this->input->post('nome')),
            'id_cidade' => trim($this->input->post('municipio')),
            'email' => trim($this->input->post('email')),
            'senha' => md5($this->input->post('senha')),
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

        echo json_encode($response);
    }

    function gerenciar_index() {
        
    }

}
