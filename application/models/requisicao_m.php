<?php

class Requisicao_m extends CI_Model {

    public function __construct() {
        parent::__construct();

        $this->load->database();   // Loading Database 
        $this->load->library('session'); // Loading Session
        $this->load->helper('url');  // Loading Helper
    }

    function get_tipo_fiscalizacao() {
        $this->db->where(array(
            'nome <>' => ''
        ));

        $this->db->order_by('nome');
        $query = $this->db->get('fiscalizacao_tipo');

        $resultado = "<option value=\"0\" disabled selected> Selecione o tipo </option>";

        foreach ($query->result() as $row) {

            $resultado .= "<option value=" . $row->id . ">" . $row->nome . "</option>";
        }

        $resultado .= "<option value=\"OUTRO\"> OUTRO </option>";

        echo $resultado;
    }

    function get_tipo_instrumento_curso() {
        $this->db->where(array(
            'nome <>' => ''
        ));

        $this->db->order_by('nome');
        $query = $this->db->get('curso_tipo_instrumento');

        $resultado = "<option value=\"0\" disabled selected> Selecione o tipo do instrumento </option>";

        foreach ($query->result() as $row) {

            $resultado .= "<option value=" . $row->id . ">" . $row->nome . "</option>";
        }

        $resultado .= "<option value=\"OUTRO\"> OUTRO </option>";

        echo $resultado;
    }

    function get_modalidades() {
        $this->db->where(
                array(
                    'nome <>' => '',
                    'nome <>' => 'OUTROS'
                )
        );
        $this->db->order_by('nome');
        $query = $this->db->get('curso_modalidade');

        $resultado = "<option value=\"0\" disabled selected> Selecione a Modalidade </option>";

        foreach ($query->result() as $row) {

            $resultado .= "<option value=" . $row->id . ">" . $row->nome . "</option>";
        }

        $resultado .= "<option value=\"OUTRA\"> OUTRA </option>";

        echo $resultado;
    }

    function get_assentamentos($estado) {
        $this->db->select('a.codigo, a.nome');
        $this->db->from('assentamentos a');
        $this->db->join('superintendencia s', 's.id = a.id_superintendencia', 'left');
        $this->db->join('estado e', 'e.id = s.id_estado', 'left');
        $this->db->where('e.sigla', $estado);

        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $resultado .= "<option value='" . $row->codigo . "' title='" . $row->nome . "'>" . $row->codigo . " - " . $row->nome . "</option>";
        }

        echo $resultado;
    }

    function get_estados() {
        $this->db->order_by('sigla');
        $query = $this->db->get('estado');
        $resultado = "<option value=\"0\" disabled selected> Selecione o Estado </option>";

        foreach ($query->result() as $row) {
            $resultado .= "<option value=" . $row->id . ">" . $row->sigla . "</option>";
        }

        echo $resultado;
    }

    function get_municipios($id_estado) {
        $this->db->where('id_estado', $id_estado);
        $this->db->order_by('nome');
        $query = $this->db->get('cidade');
        $resultado = "<option value=\"0\" disabled selected> Selecione o Município </option>";

        foreach ($query->result() as $row) {
            $resultado .= "<option value=" . $row->id . ">" . $row->nome . "</option>";
        }

        echo $resultado;
    }

    function get_pesquisadores($id_sr) {
        $this->db->select('id, nome');
        $this->db->from('pessoa');
        $this->db->where(
                array(
                    'id_superintendencia' => $id_sr,
                    'ativo_inativo' => 'A'
                )
        );
        $this->db->order_by('nome');

        $query = $this->db->get();

        $resultado = "<option value=\"0\" disabled selected> Selecione o Responsável </option>";

        foreach ($query->result() as $row) {
            $resultado .= "<option value=" . $row->id . ">" . $row->nome . "</option>";
        }

        echo $resultado;
    }

    function get_all_pesquisadores() {
        $this->db->select('id, nome');
        $this->db->from('pessoa');
        $this->db->where(
                array(
                    'ativo_inativo' => 'A'
                )
        );
        $this->db->order_by('nome');

        $query = $this->db->get();

        $resultado = "<option value=\"0\" disabled selected> Selecione o Responsável </option>";

        foreach ($query->result() as $row) {
            $resultado .= "<option value=" . $row->id . ">" . $row->nome . "</option>";
        }

        echo $resultado;
    }

    function get_superintendencias() {
        $query = $this->db->get('superintendencia');
        $this->db->order_by('nome');
        $resultado = "<option value=\"0\" disabled selected> Selecione a Superintendência </option>";

        foreach ($query->result() as $row) {
            $resultado .= "<option value=" . $row->id . ">" . $row->nome . "</option>";
        }

        echo $resultado;
    }

    function get_totaleducandos($id) {
        $sr = (int) $id;
        $this->db->select('c.id as id_curso, c.nome as curso, e.nome as educando, c.id_superintendencia AS id_superintendencia');
        $this->db->from('educando e');
        $this->db->join('curso c', 'e.id_curso = c.id', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.status', '2P');
        $this->db->where('c.id_superintendencia', $sr);
        
        $query = $this->db->get();
        
        return $query->num_rows();
    }

    function get_superintendencias_nome($id, $super) {
        $this->db->where('id', $super);
        $query = $this->db->get('superintendencia');

        $dados = $query->result();

        $resultado = "";

        if ($id == 1)
            $resultado = $dados[0]->id . " - ";
        $resultado .= $dados[0]->nome;

        return $resultado;
    }

    function get_cursos_nome($id) {
        $this->db->select('c.id, c.nome, c.id_superintendencia super');
        $this->db->from('curso c');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $id);
        $query = $this->db->get();

        $dados = $query->result();

        $super_formatado = "";

        if ($dados[0]->super < 10) {
            $super_formatado = "0";
        }

        $super_formatado .= $dados[0]->super;

        $id_formatado = "";

        if ($dados[0]->id < 100) {
            $id_formatado = "0";
        }
        if ($dados[0]->id < 10) {
            $id_formatado .= "0";
        }

        $id_formatado .= $dados[0]->id;

        $resultado = $super_formatado . '.' . $id_formatado . ' - ' . $dados[0]->nome;

        return $resultado;
    }

    function get_pesquisador_nome($id_pesquisador) {
        $this->db->select('nome');
        $this->db->where('id', $id_pesquisador);
        $query = $this->db->get('pessoa');

        $dados = $query->result();
        $resultado = $dados[0]->nome;
        echo $resultado;
    }

    function get_modalidade_nome($modalidade) {
        $this->db->select('nome');
        $this->db->where('id', $modalidade);
        $query = $this->db->get('curso_modalidade');

        $dados = $query->result();

        $resultado = $dados[0]->nome;

        return $resultado;
    }

    function get_superintendencias_cursos() {
        $this->db->not_like('id', '31');
        $this->db->order_by('nome');
        $query = $this->db->get('superintendencia');
        $resultado = "<option value=\"0\" disabled selected> Selecione a Superintendência </option>";

        foreach ($query->result() as $row) {
            $resultado .= "<option value=" . $row->id . ">" . $row->nome . "</option>";
        }

        echo $resultado;
    }

    function get_superintendencias_cursos_clear($super) {
        $this->db->select('id, nome');

        if ($super == 0)
            $this->db->not_like('id', '31');
        else if ($super != 0 && $super != 31)
            $this->db->where('id', $super);
        else if ($super == 31)
            $this->db->not_like('id', '31');

        $this->db->order_by('nome');
        $query = $this->db->get('superintendencia');

        return $query->result();
    }

    function get_cursos_by_super($super) {
        $this->db->select('c.id, c.nome, c.id_superintendencia super');
        $this->db->from('curso c');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id_superintendencia', $super);
        $query = $this->db->get();
        $resultado = "<option value=\"0\" disabled selected> Selecione o Curso </option>";


        $super_formatado = "";

        if ($super < 10) {
            $super_formatado = "0";
        }

        $super_formatado .= $super;

        foreach ($query->result() as $row) {
            $id_formatado = "";

            if ($row->id < 100) {
                $id_formatado = "0";
            }
            if ($row->id < 10) {
                $id_formatado .= "0";
            }

            $id_formatado .= $row->id;

            $resultado .= "<option value=" . $row->id . ">" . $super_formatado . '.' . $id_formatado . ' - ' . $row->nome . "</option>";
        }

        echo $resultado;
    }

    function get_modalidade_by_super($super) {
        $this->db->select('cm.*');
        $this->db->distinct();
        $this->db->from('curso_modalidade cm');
        $this->db->join('curso c', 'cm.id = c.id_modalidade', 'left');
        $this->db->join('superintendencia s', 's.id = c.id_superintendencia', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('s.id', $super);
        $query = $this->db->get();
        $this->db->order_by('nome');

        $resultado = "<option value=\"0\" disabled selected> Selecione a Modalidade </option>";

        foreach ($query->result() as $row) {

            $resultado .= "<option value=" . $row->id . ">" . $row->nome . "</option>";
        }

        echo $resultado;
    }

    function get_funcoes() {

        $where = array(
            'nivel_acesso <=' => $this->session->userdata('access_level')
        );

        $this->db->where($where);
        $this->db->order_by('funcao');
        $query = $this->db->get('funcao');
        $resultado = "<option value=\"0\" disabled selected> Selecione a Função </option>";

        foreach ($query->result() as $row) {
            $resultado .= "<option value=" . $row->id . ">" . $row->funcao . "</option>";
        }

        echo $resultado;
    }

    /* RELATORIO DINAMICO */

    function get_estados_rel() {
        $this->db->order_by('sigla');
        $query = $this->db->get('estado');
        $resultado = "<option value=\"0\" selected> Todos os Estados </option>";

        foreach ($query->result() as $row) {
            $resultado .= "<option value=" . $row->id . ">" . $row->sigla . "</option>";
        }

        echo $resultado;
    }

    function get_municipios_rel($id_estado) {
        $this->db->where('id_estado', $id_estado);
        $this->db->order_by('nome');
        $query = $this->db->get('cidade');
        $resultado = "<option value=\"0\" selected> Todos os municípios </option>";

        foreach ($query->result() as $row) {
            $resultado .= "<option value=" . $row->id . ">" . $row->nome . "</option>";
        }

        echo $resultado;
    }

    function get_superintendencias_cursos_rel() {
        $this->db->not_like('id', '31');
        $this->db->order_by('nome');
        $query = $this->db->get('superintendencia');
        $resultado = "<option value=\"0\" selected> Todas as Superintendências </option>";

        foreach ($query->result() as $row) {
            $resultado .= "<option value=" . $row->id . ">" . $row->nome . "</option>";
        }

        echo $resultado;
    }

    function get_cursos_by_super_rel($super) {
        $this->db->select('c.id, c.nome, c.id_superintendencia super');
        $this->db->from('curso c');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id_superintendencia', $super);
        $query = $this->db->get();
        $resultado = "<option value=\"0\" selected>Todos os cursos </option>";


        $super_formatado = "";

        if ($super < 10) {
            $super_formatado = "0";
        }

        $super_formatado .= $super;

        foreach ($query->result() as $row) {
            $id_formatado = "";

            if ($row->id < 100) {
                $id_formatado = "0";
            }
            if ($row->id < 10) {
                $id_formatado .= "0";
            }

            $id_formatado .= $row->id;

            $resultado .= "<option value=" . $row->id . ">" . $super_formatado . '.' . $id_formatado . ' - ' . $row->nome . "</option>";
        }

        echo $resultado;
    }

    function get_modalidades_rel() {
        $this->db->where(
                array(
                    'nome <>' => '',
                    'id <>' => '27',
                    'nome <>' => 'OUTROS'
                )
        );
        $this->db->order_by('nome');
        $query = $this->db->get('curso_modalidade');

        $resultado = "<option value=\"0\" selected> Todas as Modalidade </option>";

        foreach ($query->result() as $row) {

            $resultado .= "<option value=" . $row->id . ">" . $row->nome . "</option>";
        }

        $resultado .= "<option value=\"OUTRA\"> OUTRA </option>";

        echo $resultado;
    }

}

?>