<?php

class Ctrl_conta extends CI_Controller {

    function index() {

        $this->session->set_userdata('curr_content', 'gerenciar_conta');
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

    function index_acesso_publico() {
        $data['content'] = 'loginpublico.php';
        echo $this->load->view($data['content'], '', true);
    }

    function index_password_retrieval() {

        $data['content'] = 'recuperar_senha.php';
        echo $this->load->view($data['content'], '', true);
    }

    function index_password_reset() {

        $data['content'] = 'redefinir_senha.php';
        $data['top_menu'] = 'blank.php';
        $data['course_info'] = 'blank.php';
        $data['cpf'] = $this->uri->segment(3);
        $this->load->view('include/template.php', $data);
    }

    function password_retrieval() {

        $this->load->model('conta');     // Loading Conta Model
        $this->load->library('encrypt'); // Loading Encrypt Library
        // Checks if account is allowed to sign in on system
        if ($account_data = $this->conta->allow()) {

            // User email
            $email = $account_data->email;

            // User's old password
            $old_password = $account_data->senha;

            // User's id
            $id = $account_data->id;

            // Hash to reset password
            $hash = substr(md5(date("D M j G:i:s T Y")), 0, 15);

            // Reseting user password
            if ($this->conta->update_password($this->input->post('cpf'), $old_password, $hash)) {

                // Configure email with Google SMTP
                $config = array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'ssl://smtp.googlemail.com',
                    'smtp_port' => 465,
                    'smtp_user' => 'suporte.datapronera@gmail.com',
                    'smtp_pass' => 'pnera2*12',
                    //'smtp_user' => 'noreply.email.acc@gmail.com',
                    //'smtp_pass' => 'noreply123',
                    'mailtype' => 'html'
                );

                // Loading Email Library
                $this->load->library('email', $config);
                $this->email->set_newline("\r\n");

                // Setting email information
                $this->email->from('noreply-email.acc@gmail.com', 'DATAPRONERA');
                $this->email->to($email);
                $this->email->subject('Redefinição de senha');

                // Encrypting CPF number
                $encrypted_cpf = $this->encrypt->encode($this->input->post('cpf'));
                $encrypted_cpf = str_replace(array('+', '/', '='), array('-', '_', ''), $encrypted_cpf);

                // URL to update password
                $anchor = anchor("ctrl_conta/index_password_reset/$encrypted_cpf", 'Clique aqui', '');

                // Body email message
                $body = "Este é um email automático, não é necessário respondê-lo. <br />
	                     Sua nova senha de acesso é: <strong> $hash </strong> <br />
	                     Para alterar sua senha $anchor.";

                $this->email->message($body);

                // Sending email
                if ($this->email->send()) {

                    $this->log->save("SENHA DE ACESSO REQUISITADA", $id);

                    $this->session->set_userdata('curr_content', 'login');

                    $data['content'] = $this->session->userdata('curr_content');

                    $html = array(
                        'content' => $this->load->view($data['content'], '', true)
                    );

                    $response = array(
                        'success' => true,
                        'html' => $html,
                        'message' => "Email enviado"
                    );
                } else {

                    $response = array(
                        'success' => false,
                        'message' => "Falha ao enviar email. Tente novamente em instantes"
                    );
                }
            } else {

                $response = array(
                    'success' => false,
                    'message' => "Falha ao recuperar senha. Tente novamente em instantes"
                );
            }
        } else {

            $response = array(
                'success' => false,
                'message' => "Não foi encontrada nenhuma conta vinculada ao CPF informado"
            );
        }

        echo json_encode($response);
    }

    function password_reset() {

        $this->load->model('conta');     // Loading Conta Model
        $this->load->library('encrypt'); // Loading Encrypt Library

        $encrypted_cpf = str_replace(array('-', '_', ''), array('+', '/', '='), $this->input->post('cpf'));

        if ($id = $this->conta->update_password(
                $this->encrypt->decode($encrypted_cpf), md5($this->input->post('senha_atual')), $this->input->post('nova_senha')
                )) {

            $this->log->save("SENHA DE ACESSO ATUALIZADA", $id);

            if ($this->system->is_logged_in()) {

                $this->session->set_userdata('curr_content', 'gerenciar_conta');
            } else {
                $this->session->set_userdata('curr_content', 'login');
            }

            $data['content'] = $this->session->userdata('curr_content');
            $values['encrypted_cpf'] = $this->input->post('cpf');

            $html = array(
                'content' => $this->load->view($data['content'], $values, true)
            );

            $response = array(
                'success' => true,
                'html' => $html,
                'message' => "Senha atualizada com sucesso"
            );
        } else {

            $response = array(
                'success' => false,
                'message' => "Falha ao atualizar senha"
            );
        }

        echo json_encode($response);
    }

    function email_reset() {

        $this->load->model('conta');     // Loading Conta Model
        $this->load->library('encrypt'); // Loading Encrypt Library

        $encrypted_cpf = str_replace(array('-', '_', ''), array('+', '/', '='), $this->input->post('cpf'));

        if ($this->conta->update_email(
                        $this->encrypt->decode($encrypted_cpf), md5($this->input->post('senha_atual_email')), $this->input->post('novo_email')
                )) {

            $this->log->save("EMAIL ATUALIZADO");

            $this->session->set_userdata('email', $this->input->post('novo_email'));
            $this->session->set_userdata('curr_content', 'gerenciar_conta');

            $data['content'] = $this->session->userdata('curr_content');
            $values['encrypted_cpf'] = $this->input->post('cpf');

            $html = array(
                'content' => $this->load->view($data['content'], $values, true)
            );

            $response = array(
                'success' => true,
                'html' => $html,
                'message' => "Email atualizado com sucesso"
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

}
