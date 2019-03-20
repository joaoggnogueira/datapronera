<?php

class Request extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();   // Loading Database
        $this->load->library('session'); // Loading Session
        $this->load->helper('url');  // Loading Helper
        //$this->load->model('responsavel_m');
        $this->load->model('caracterizacao_m');
        $this->load->model('professor_m');
    }

    function acessar_curso() {

        $this->load->model('curso_m');
        header('Content-Type: application/json; charset=utf-8');
        
        $this->session->set_userdata('id_curso', $this->input->post('id_curso'));
        if ($status = $this->curso_m->get_status($this->input->post('id_curso'))) {
            if ($result = $this->caracterizacao_m->get_record($this->session->userdata('id_curso'))) {

                $this->log->save("CURSO ACESSADO: ID '" . $this->input->post('id_curso') . "'");

                $this->session->set_userdata('curr_content', 'formulario_caracterizacao');
                $this->session->set_userdata('curr_top_menu', 'menus/cursos.php');
                $this->session->set_userdata('curr_course_info', 'course_info.php');
                $this->session->set_userdata('status_curso', $status->status);

                $data['content'] = $this->session->userdata('curr_content');
                $data['top_menu'] = $this->session->userdata('curr_top_menu');
                $data['course_info'] = $this->session->userdata('curr_course_info');

                $values['dados'] = $result;
                //$values['insurers'] = $this->responsavel_m->get_insurers();
                //$values['informer'] = $this->responsavel_m->get_informers($this->session->userdata('id_curso'));

                $course['cod'] = $this->input->post('codigo');
                $nome = $this->input->post('nome');
                if(strlen($nome) > 60) {
                    $nome = substr($nome, 0, 55) . " [...]";
                }
                $nome = str_replace("ª", "a", $nome);
                $course['name'] = $nome;
                
                $course['data'] = $this->input->post('data');
                $this->session->set_userdata('cod_course', $course['cod']);
                $this->session->set_userdata('name_course', $course['name']);

                $html = array(
                    'content' => $this->load->view($data['content'], $values, true),
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
                    'message' => 'Falha na requisição, tente novamente em instantes'
                );
            }
        } else {

            $response = array(
                'success' => false,
                'message' => 'Falha na requisição, tente novamente em instantes'
            );
        }

        echo json_encode($response);
    }

    function contato() {

        $this->db->select('p.nome nome, f.funcao funcao, s.nome super, c.email email');
        $this->db->from('pessoa p');
        $this->db->join('funcao f', 'f.id = p.id_funcao', 'left');
        $this->db->join('superintendencia s', 's.id = p.id_superintendencia', 'left');
        $this->db->join('conta c', 'c.id_pessoa = p.id', 'left');
        $this->db->where('p.ativo_inativo', 'A');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->not_like('p.id_superintendencia', 31);
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $row[0] = ($item->nome);
            $row[1] = ($item->funcao);
            $row[2] = ($item->super);
            $row[3] = ($item->email);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function get_curso($sts_1, $sts_2 = null) {

        $this->db->select(""
                . "CONCAT(LPAD(c.id_superintendencia,(2),(0)),('.'),LPAD(c.id,(3),(0))),"
                . " nome,"
                . " IF(c.nprocesso IS NULL,CONCAT(c.ninstrumento,('(SICONV)')),(c.nprocesso)), "
                . " IF(ca.inicio_realizado IS NULL,IF(ca.inicio_previsto IS NULL,(''),CONCAT(ca.inicio_previsto,(' (PREVISTO)'))),(ca.inicio_realizado)) AS inicio, "
                . " IF(ca.termino_realizado IS NULL,IF(ca.termino_previsto IS NULL,(''),CONCAT(ca.termino_previsto,(' (PREVISTO)'))),(ca.termino_realizado)) as termino "
        );
        $this->db->from('curso c');
        $this->db->join("caracterizacao ca", "ca.id_curso = c.id");
        $this->db->where('c.ativo_inativo', 'A');

        // COORD. CURSO, CPN, ASSEGURADOR
        if ($this->session->userdata('access_level') < 3 && $sts_1 != '2P') {
            $this->db->where('c.id_superintendencia', $this->session->userdata('id_superintendencia'));
        }

        $this->db->where('c.status', $sts_1);

        if ($sts_2) {
            $this->db->or_where('c.status', $sts_2);
        }

        $this->db->order_by('c.id_superintendencia, c.id, c.nprocesso');
        $query = $this->db->get();

        $dados = $query->result();


        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            foreach ($item as $cell) {
                $row[] = $cell;
            }

            $output['aaData'][] = $row;
        }

        echo json_encode($output);
    }

    function get_pessoa_cadastro($ativo_inativo) {

        $this->db->select('p.id, p.cpf, p.nome, p.rg, f.funcao');
        $this->db->from('pessoa p');
        $this->db->join('funcao f', 'f.id = p.id_funcao', 'left');

        // Gabriel - Alterou
        $where = "p.ativo_inativo = '" . $ativo_inativo . "' AND f.nivel_acesso <= " . $this->session->userdata('access_level') . "";

        $this->db->where($where);

        $this->db->order_by('f.nivel_acesso ASC');

        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $row[0] = ($item->id);
            $row[1] = ($item->cpf);
            $row[2] = ($item->nome);
            $row[3] = ($item->rg);
            $row[4] = ($item->funcao);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function get_curso_cadastro($ativo_inativo) {

        $this->db->select('c.id curso_id, c.id_superintendencia superintendencia, c.nome curso_nome, p.nome responsavel, s.nome super_nome');
        $this->db->from('curso c');
        $this->db->join('pessoa p', 'c.id_pesquisador = p.id', 'left');
        $this->db->join('superintendencia s', 'c.id_superintendencia = s.id', 'left');
        $this->db->where('c.ativo_inativo', $ativo_inativo);

        // ASSEGURADOR, COORD. CURSO, CPN
        if ($this->session->userdata('access_level') < 3) {
            $this->db->where('s.id', $this->session->userdata('id_superintendencia'));
        }

        $this->db->order_by('c.id_superintendencia, c.id');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $super = "";
            $codigo = "";

            if ($item->superintendencia < 10) {
                $super = "0";
            }
            if ($item->curso_id < 100) {
                $codigo = "0";
            }
            if ($item->curso_id < 10) {
                $codigo .= "0";
            }

            $codigo .= $item->curso_id;
            $super .= $item->superintendencia;

            $row[0] = ($item->curso_id);
            $row[1] = ($super . "." . $codigo);
            $row[2] = ($item->curso_nome);
            $row[3] = ($item->super_nome);
            $row[4] = ($item->responsavel);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function get_assentamento_cadastro(){
        $this->db->select('a.idAssentamento id, a.codigo sipra, a.nome nome, a.estado uf, s.nome sr');
        $this->db->from('assentamentos a');
        $this->db->join('superintendencia s','s.id = a.id_superintendencia');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();
            $row[0] = ($item->id);
            $row[1] = ($item->sipra);
            $row[2] = ($item->nome);
            $row[3] = ($item->uf);
            $row[4] = ($item->sr);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }
    
    function get_super_cadastro($ativo_inativo) {

        $this->db->select('s.id, s.nome nome, s.nome_responsavel responsavel, s.id_estado estado');
        $this->db->from('superintendencia s');
        $this->db->where('s.ativo_inativo', $ativo_inativo);
        $this->db->order_by('s.id');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $codigo = "";

            if ($item->id < 10) {
                $codigo = "0";
            }

            $codigo .= $item->id;

            $row[0] = ($item->id);
            $row[1] = ("SR - " . $codigo);
            $row[2] = ($item->nome);
            $row[3] = ($item->responsavel);
            $row[4] = ($item->estado);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function get_curso_pesquisadores($idCurso) {

        if ($idCurso >= 0) {
            $this->db->select('p.id as id,p.nome as nome');
            $this->db->from('pessoa p');
            $this->db->join('pesquisador_curso pc', 'pc.id_pessoa = p.id', 'left');
            $this->db->where('pc.id_curso', $idCurso);
            $this->db->order_by('p.id');
            $query = $this->db->get();

            $dados = $query->result();
            /** Output * */
            $output = array(
                "sEcho" => 1,
                "iTotalRecords" => 0,
                "iTotalDisplayRecords" => 0,
                "aaData" => array()
            );

            foreach ($dados as $item) {
                $row = array();

                $row[0] = 'R';
                $row[1] = utf8_encode($item->id);
                $row[2] = ($item->nome);

                array_push($output['aaData'], $row);
            }
        } else {
            $output = array(
                "sEcho" => 1,
                "iTotalRecords" => 0,
                "iTotalDisplayRecords" => 0,
                "aaData" => array()
            );
        }

        echo json_encode($output);
    }

    function get_carac_mun() {

        $this->db->select('cid.id_estado, e.sigla estado, cc.id_cidade, cid.nome cidade');
        $this->db->from('caracterizacao_cidade cc');
        $this->db->join('caracterizacao ca', 'ca.id = cc.id_caracterizacao', 'left');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->join('cidade cid', 'cid.id = cc.id_cidade', 'left');
        $this->db->join('estado e', 'cid.id_estado = e.id', 'left');
        $this->db->where('c.id', $this->session->userdata('id_curso'));
        $this->db->order_by('cid.id_estado, cc.id_cidade');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $row[0] = 'R';
            $row[1] = utf8_encode($item->id_cidade);
            $row[2] = ($item->cidade);
            $row[3] = utf8_encode($item->id_estado);
            $row[4] = ($item->estado);

            array_push($output['aaData'], $row);
        }

        echo json_encode($output);
    }

    function get_asseguradores() {

        $this->db->select('p.cpf, p.nome');
        $this->db->from('curso_assegurador ca');
        $this->db->join('pessoa p', 'ca.id_pessoa = p.id', 'left');
        $this->db->where('ca.id_curso', $this->session->userdata('id_curso'));

        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $row[0] = utf8_encode($item->cpf);
            $row[1] = ($item->nome);

            $output['aaData'][] = $row;
        }

        echo json_encode($output);
    }

    function get_professor() {

        $this->db->select('p.id professor_id, UPPER(p.nome) professor, p.genero professor_sexo, p.titulacao professor_titulacao');
        $this->db->from('professor p');
        $this->db->where('p.id_curso', $this->session->userdata('id_curso'));
        $this->db->order_by('p.nome');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $sexo = "NAO INFORMADO";

            if ($item->professor_sexo == 'M') {
                $sexo = "MASCULINO";
            } else if ($item->professor_sexo == 'F') {
                $sexo = "FEMININO";
            }

            $titulacao = $item->professor_titulacao;
            if ($item->professor_titulacao == '###' || $item->professor_titulacao == 'NAOINFORMADO') {
                $titulacao = "NAO INFORMADO";
            }


            $row[0] = utf8_encode($item->professor_id);
            $row[1] = ($item->professor);
            $row[2] = utf8_encode($sexo);
            $row[3] = utf8_encode($titulacao);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function get_disciplinas() {

        $this->db->select('d.id disciplinas_id, d.nome disciplina');
        $this->db->from('disciplina d');
        $this->db->where('d.id_professor', $this->uri->segment(3));
        $this->db->order_by('d.nome');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $row[0] = 'R';
            $row[1] = utf8_encode($item->disciplinas_id);
            $row[2] = ($item->disciplina);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function get_educando() {

        $this->db->select("e.id educando_id, UPPER(e.nome) educando, CONCAT((c.nome),(' ('),(est.sigla),(')')) educando_cidade, e.data_nascimento educando_datanasc, e.nome_territorio nome_acampamento");
        $this->db->from('educando e');
        $this->db->join('educando_cidade ec', 'ec.id_educando = e.id', 'left');
        $this->db->join('cidade c', 'c.id = ec.id_cidade', 'left');
        $this->db->join('estado est', 'est.id = c.id_estado', 'left');
        $this->db->where('e.id_curso', $this->session->userdata('id_curso'));
        $this->db->order_by('e.nome');

        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $data = implode("/", array_reverse(explode("-", $item->educando_datanasc), true));

            if ($data == '01/01/1900' || $data == '00/00/0000') {
                $data = "NÃO INFORMADO";
            }

            $row[0] = utf8_encode($item->educando_id);
            $row[1] = ($item->educando);
            $row[2] = ($item->educando_cidade);
            $row[3] = $data;
            $row[4] = ($item->nome_acampamento);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function get_educando_mun() {

        $this->db->select('ec.id_cidade, c.id_estado, c.nome cidade, e.sigla estado');
        $this->db->from('educando_cidade ec');
        $this->db->join('cidade c', 'c.id = ec.id_cidade', 'left');
        $this->db->join('estado e', 'c.id_estado = e.id', 'left');
        $this->db->where('ec.id_educando', $this->uri->segment(3));
        $this->db->order_by('c.id_estado,ec.id_cidade');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $row[0] = 'R';
            $row[1] = utf8_encode($item->id_cidade);
            $row[2] = ($item->cidade);
            $row[3] = ($item->id_estado);
            $row[4] = ($item->estado);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function get_fiscalizacao() {

        $this->db->select('f.id fiscalizacao_id, t.nome tipo, f.data data');
        $this->db->from('fiscalizacao f');
        $this->db->join('fiscalizacao_tipo t', 't.id = f.id_tipo', 'left');
        $this->db->where('f.id_curso', $this->session->userdata('id_curso'));
        $this->db->order_by('data');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $data_nacional = explode("-", $item->data);
            $data = $data_nacional[2] . "/" . $data_nacional[1] . "/" . $data_nacional[0];

            $row[0] = utf8_encode($item->fiscalizacao_id);
            $row[1] = ($item->tipo);
            $row[2] = $data;

            $output['aaData'][] = $row;
        }

        echo json_encode($output);
    }

    function get_organizacao() {


        $this->db->select('o.id organizacao_id, o.nome organizacao, o.abrangencia organizacao_abrang, o.data_fundacao_nacional organizacao_data_nacional, o.data_fundacao_estadual organizacao_data_estado');
        $this->db->from('organizacao_demandante o');
        $this->db->where('o.id_curso', $this->session->userdata('id_curso'));
        $this->db->order_by('o.nome');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            if ($item->organizacao_data_nacional == '0000-00-00') {
                $final_nacional = "NÃO INFORMADO";
            } else if ($item->organizacao_data_nacional == '1900-01-01') {
                $final_nacional = "NÃO SE APLICA";
            } else {
                $data_nacional = explode("-", $item->organizacao_data_nacional);
                $final_nacional = $data_nacional[2] . "/" . $data_nacional[1] . "/" . $data_nacional[0];
            }

            if ($item->organizacao_data_estado == '0000-00-00') {
                $final_estado = "NÃO INFORMADO";
            } else {
                $data_estado = explode("-", $item->organizacao_data_estado);
                $final_estado = $data_estado[2] . "/" . $data_estado[1] . "/" . $data_estado[0];
            }

            $row[0] = utf8_encode($item->organizacao_id);
            $row[1] = ($item->organizacao);
            $row[2] = ($item->organizacao_abrang);
            $row[3] = $final_nacional;
            $row[4] = $final_estado;

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function get_funcao() {
        $this->db->select('f.funcao as funcao');
        $this->db->from('pessoa p');
        $this->db->join('funcao f', 'p.id_funcao = f.id', 'left');
        $this->db->where('p.id', $this->uri->segment(3));
        $query = $this->db->get();
        $dados = $query->result();
        echo $dados[0]->funcao;
    }

    function get_fiscalizadores($idFiscalizacao) {
        if ($idFiscalizacao >= 0) {
            $this->db->select('m.id_pessoa as id_pessoa, s.id as id_superintendencia,p.nome as nome, f.funcao as funcao');
            $this->db->from('fiscalizacao_membro m');
            $this->db->join('pessoa p', 'p.id = m.id_pessoa', 'left');
            $this->db->join('superintendencia s', 's.id = p.id_superintendencia', 'left');
            $this->db->join('funcao f', 'f.id = p.id_funcao', 'left');
            $this->db->where('m.id_fiscalizacao', $this->uri->segment(3));
            $this->db->order_by('p.nome');
            $query = $this->db->get();

            $dados = $query->result();

            /** Output * */
            $output = array(
                "sEcho" => 1,
                "iTotalRecords" => 0,
                "iTotalDisplayRecords" => 0,
                "aaData" => array()
            );

            foreach ($dados as $item) {
                $row = array();

                $row[0] = 'R';
                $row[1] = ($item->id_pessoa);
                $row[2] = 'SR - ' . ($item->id_superintendencia);
                $row[3] = ($item->nome);
                $row[4] = ($item->funcao);

                $output['aaData'][] = $row;
            }
        } else {
            $output = array(
                "sEcho" => 1,
                "iTotalRecords" => 0,
                "iTotalDisplayRecords" => 0,
                "aaData" => array()
            );
        }
        echo json_encode($output);
    }

    function get_membros() {

        $this->db->select('oc.id, oc.nome, oc.grau_escolaridade_epoca , oc.grau_escolaridade_atual, oc.estuda_pronera');
        $this->db->from('organizacao_demandante_coordenador oc');
        $this->db->where('oc.id_organizacao_demandante', $this->uri->segment(3));
        $this->db->order_by('oc.nome');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            if ($item->estuda_pronera == "S")
                $estuda = "SIM";
            else
                $estuda = "NÃO";

            $row[0] = 'R';
            $row[1] = ($item->id);
            $row[2] = ($item->nome);
            $row[3] = ($item->grau_escolaridade_epoca);
            $row[4] = ($item->grau_escolaridade_atual);
            $row[5] = ($estuda);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function get_parceiro() {

        $this->db->select('p.id parceiro_id, p.nome parceiro, p.sigla parceiro_sigla, c.nome municipio, e.sigla estado');
        $this->db->from('parceiro p');
        $this->db->join('cidade c', 'c.id = p.id_cidade', 'left');
        $this->db->join('estado e', 'c.id_estado = e.id', 'left');
        $this->db->where('p.id_curso', $this->session->userdata('id_curso'));
        $this->db->order_by('p.id');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $row[0] = ($item->parceiro_id);
            $row[1] = ($item->parceiro);
            $row[2] = ($item->parceiro_sigla);
            $row[3] = ($item->municipio);
            $row[4] = ($item->estado);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function get_producao8a() {

        $this->db->select('o.id, o.titulo, o.natureza_producao, o.ano');
        $this->db->from('producao_geral o');
        $this->db->where('o.id_curso', $this->session->userdata('id_curso'));
        $this->db->order_by('o.id');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $row[0] = ($item->id);
            $row[1] = ($item->titulo);
            $row[2] = ($item->natureza_producao);
            $row[3] = ($item->ano);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function get_autor_producao_geral() {

        $this->db->select('a.id, a.nome, a.tipo');
        $this->db->from('autor a');
        $this->db->join('producao_geral_autor o', 'o.id_autor = a.id', 'left');
        $this->db->where('o.id_producao_geral', $this->uri->segment(3));
        $this->db->order_by('a.nome');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $row[0] = 'R';
            $row[1] = ($item->id);
            $row[2] = ($item->nome);
            $row[3] = ($item->tipo);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function get_producao8b() {

        $this->db->select('o.id, o.titulo, o.ano_defesa');
        $this->db->from('producao_trabalho o');
        $this->db->where('o.id_curso', $this->session->userdata('id_curso'));
        $this->db->order_by('o.id');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $row[0] = ($item->id);
            $row[1] = ($item->titulo);
            $row[2] = ($item->ano_defesa);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function get_autor_producao_trabalho() {

        $this->db->select('a.id, a.nome');
        $this->db->from('autor a');
        $this->db->join('producao_trabalho_autor o', 'o.id_autor = a.id', 'left');
        $this->db->where('o.id_producao_trabalho', $this->uri->segment(3));
        $this->db->order_by('a.nome');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $row[0] = 'R';
            $row[1] = ($item->id);
            $row[2] = ($item->nome);

            $output['aaData'][] = $row;
        }

        echo json_encode($output);
    }

    function get_producao8c() {

        $this->db->select('o.id, o.titulo, o.ano');
        $this->db->from('producao_artigo o');
        $this->db->where('o.id_curso', $this->session->userdata('id_curso'));
        $this->db->order_by('o.id');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $row[0] = ($item->id);
            $row[1] = ($item->titulo);
            $row[2] = ($item->ano);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function get_autor_producao_artigo() {

        $this->db->select('a.id, a.nome');
        $this->db->from('autor a');
        $this->db->join('producao_artigo_autor o', 'o.id_autor = a.id', 'left');
        $this->db->where('o.id_producao_artigo', $this->uri->segment(3));
        $this->db->order_by('a.nome');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $row[0] = 'R';
            $row[1] = ($item->id);
            $row[2] = ($item->nome);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function get_producao8d() {

        $this->db->select('o.id, o.titulo, o.ano');
        $this->db->from('producao_memoria o');
        $this->db->where('o.id_curso', $this->session->userdata('id_curso'));
        $this->db->order_by('o.id');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $row[0] = ($item->id);
            $row[1] = ($item->titulo);
            $row[2] = ($item->ano);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function get_producao8e() {

        $this->db->select('o.id, o.titulo, o.tipo, o.ano');
        $this->db->from('producao_livro o');
        $this->db->where('o.id_curso', $this->session->userdata('id_curso'));
        $this->db->order_by('o.id');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $row[0] = ($item->id);
            $row[1] = ($item->titulo);
            $row[2] = ($item->tipo);
            $row[3] = ($item->ano);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function get_autor_producao_livro() {

        $this->db->select('a.id, a.nome, a.tipo');
        $this->db->from('autor a');
        $this->db->join('producao_livro_autor o', 'o.id_autor = a.id', 'left');
        $this->db->where('o.id_producao_livro', $this->uri->segment(3));
        $this->db->order_by('a.nome');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $row[0] = 'R';
            $row[1] = ($item->id);
            $row[2] = ($item->nome);
            $row[3] = ($item->tipo);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function get_pesquisa_academico($status) {

        $this->db->select('n.id, n.titulo, n.natureza_producao, n.ano');
        $this->db->from('pesquisa_academico n');
        $this->db->where('n.status', $status);
        $this->db->order_by('n.titulo');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $row[0] = ($item->id);
            $row[1] = ($item->titulo);
            $row[2] = ($item->natureza_producao);
            $row[3] = ($item->ano);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function get_pesquisa_academico_autor() {

        $this->db->select('a.id, a.nome');
        $this->db->from('autor a');
        $this->db->join('pesquisa_academico_autor n', 'n.id_autor = a.id', 'left');
        $this->db->where('n.id_pesquisa_academico', $this->uri->segment(3));
        $this->db->order_by('a.nome');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $row[0] = 'R';
            $row[1] = ($item->id);
            $row[2] = ($item->nome);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function get_pesquisa_livro($status = NULL) {

        $this->db->select('l.id, l.titulo, l.editora, l.ano');
        $this->db->from('livro l');

        if ($status != NULL) {
            $this->db->where('l.status', $status);
        }

        $this->db->order_by('l.titulo');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $row[0] = ($item->id);
            $row[1] = ($item->titulo);
            $row[2] = ($item->editora);
            $row[3] = ($item->ano);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function get_pesquisa_coletanea_livro() {

        $this->db->select('l.id, l.titulo, l.editora, l.ano');
        $this->db->from('livro l');
        $this->db->join('coletanea_livro cl', 'l.id = cl.id_livro', 'left');
        $this->db->where('cl.id_coletanea', $this->uri->segment(3));
        $this->db->order_by('l.titulo');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $row[0] = ($item->id);
            $row[1] = ($item->titulo);
            $row[2] = ($item->editora);
            $row[3] = ($item->ano);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function get_pesquisa_livro_autor() {

        $this->db->select('a.id, a.nome, a.tipo');
        $this->db->from('autor a');
        $this->db->join('livro_autor l', 'l.id_autor = a.id', 'left');
        $this->db->where('l.id_livro', $this->uri->segment(3));
        $this->db->order_by('a.nome');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $row[0] = 'R';
            $row[1] = ($item->id);
            $row[2] = ($item->nome);
            $row[3] = ($item->tipo);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function get_pesquisa_coletanea($status) {

        $this->db->select('c.id, c.titulo');
        $this->db->from('coletanea c');
        $this->db->where('c.status', $status);
        $this->db->order_by('c.titulo');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $row[0] = ($item->id);
            $row[1] = ($item->titulo);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function get_pesquisa_capitulo_livro($status) {

        $this->db->select('n.id, n.titulo_capitulo, n.editora, n.ano');
        $this->db->from('pesquisa_capitulo_livro n');
        $this->db->where('n.status', $status);
        $this->db->order_by('n.titulo_capitulo');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $row[0] = ($item->id);
            $row[1] = ($item->titulo_capitulo);
            $row[2] = ($item->editora);
            $row[3] = ($item->ano);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function get_pesquisa_capitulo_livro_autor() {

        $this->db->select('a.id, a.nome');
        $this->db->from('autor a');
        $this->db->join('pesquisa_capitulo_livro_autor n', 'n.id_autor = a.id', 'left');
        $this->db->where('n.id_pesquisa_capitulo_livro', $this->uri->segment(3));
        $this->db->where('a.tipo', 'AUTOR(A)');
        $this->db->order_by('a.nome');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $row[0] = 'R';
            $row[1] = ($item->id);
            $row[2] = ($item->nome);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function get_pesquisa_capitulo_livro_organizador() {

        $this->db->select('a.id, a.nome');
        $this->db->from('autor a');
        $this->db->join('pesquisa_capitulo_livro_autor n', 'n.id_autor = a.id', 'left');
        $this->db->where('n.id_pesquisa_capitulo_livro', $this->uri->segment(3));
        $this->db->where('a.tipo', 'ORGANIZADOR(A)');
        $this->db->order_by('a.nome');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $row[0] = 'R';
            $row[1] = ($item->id);
            $row[2] = ($item->nome);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function get_pesquisa_artigo($status) {

        $this->db->select('n.id, n.titulo, n.ano');
        $this->db->from('pesquisa_artigo n');
        $this->db->where('n.status', $status);
        $this->db->order_by('n.titulo');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $row[0] = ($item->id);
            $row[1] = ($item->titulo);
            $row[2] = ($item->ano);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function get_pesquisa_artigo_autor() {

        $this->db->select('a.id, a.nome');
        $this->db->from('autor a');
        $this->db->join('pesquisa_artigo_autor n', 'n.id_autor = a.id', 'left');
        $this->db->where('n.id_pesquisa_artigo', $this->uri->segment(3));
        $this->db->where('a.tipo', 'AUTOR(A)');
        $this->db->order_by('a.nome');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $row[0] = 'R';
            $row[1] = ($item->id);
            $row[2] = ($item->nome);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function get_pesquisa_video($status) {

        $this->db->select('n.id, n.titulo, n.ano');
        $this->db->from('pesquisa_video n');
        $this->db->where('n.status', $status);
        $this->db->order_by('n.titulo');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $row[0] = ($item->id);
            $row[1] = ($item->titulo);
            $row[2] = ($item->ano);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function get_pesquisa_video_autor() {

        $this->db->select('a.id, a.nome');
        $this->db->from('autor a');
        $this->db->join('pesquisa_video_autor n', 'n.id_autor = a.id', 'left');
        $this->db->where('n.id_pesquisa_video', $this->uri->segment(3));
        $this->db->order_by('a.nome');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $row[0] = 'R';
            $row[1] = ($item->id);
            $row[2] = ($item->nome);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function get_pesquisa_periodico($status) {

        $this->db->select('n.id, n.titulo, n.editora, n.ano');
        $this->db->from('pesquisa_periodico n');
        $this->db->where('n.status', $status);
        $this->db->order_by('n.titulo');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $row[0] = ($item->id);
            $row[1] = ($item->titulo);
            $row[2] = ($item->editora);
            $row[3] = ($item->ano);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function get_pesquisa_periodico_autor() {

        $this->db->select('a.id, a.nome');
        $this->db->from('autor a');
        $this->db->join('pesquisa_periodico_autor n', 'n.id_autor = a.id', 'left');
        $this->db->where('n.id_pesquisa_periodico', $this->uri->segment(3));
        $this->db->order_by('a.nome');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $row[0] = 'R';
            $row[1] = ($item->id);
            $row[2] = ($item->nome);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function get_pesquisa_evento($status) {

        $this->db->select('n.id, n.titulo, n.abrangencia, n.data_producao');
        $this->db->from('pesquisa_evento n');
        $this->db->where('n.status', $status);
        $this->db->order_by('n.titulo');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $data = implode("/", array_reverse(explode("-", $item->data_producao), true));

            $row = array();

            $row[0] = ($item->id);
            $row[1] = ($item->titulo);
            $row[2] = ($item->abrangencia);
            $row[3] = ($data);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function get_pesquisa_evento_organizador() {

        $this->db->select('a.id, a.nome');
        $this->db->from('autor a');
        $this->db->join('pesquisa_evento_autor n', 'n.id_autor = a.id', 'left');
        $this->db->where('n.id_pesquisa_evento', $this->uri->segment(3));
        $this->db->order_by('a.nome');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $row[0] = 'R';
            $row[1] = ($item->id);
            $row[2] = ($item->nome);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    function get_pesquisa_evento_organizacao() {

        $this->db->select('n.id, n.nome');
        $this->db->from('pesquisa_evento_organizacao n');
        $this->db->where('n.id_pesquisa_evento', $this->uri->segment(3));
        $this->db->order_by('n.nome');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            $row[0] = 'R';
            $row[1] = ($item->id);
            $row[2] = ($item->nome);

            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

}

?>