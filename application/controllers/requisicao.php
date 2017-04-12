<?php

class Requisicao extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->database();   // Loading Database 
        $this->load->library('session'); // Loading Session
        $this->load->helper('url');  // Loading Helper

        $this->load->model('requisicao_m');
    }

    function index() {
        
    }

    function get_modalidades() {
        return $this->requisicao_m->get_modalidades();
    }
    
    function get_tipo_fiscalizacao(){
        return $this->requisicao_m->get_tipo_fiscalizacao();
    }
    
    function get_tipo_instrumento_curso() {
        return $this->requisicao_m->get_tipo_instrumento_curso();
    }

    function get_assentamentos() {
        return $this->requisicao_m->get_assentamentos($this->uri->segment(3));
    }

    function get_estados() {
        return $this->requisicao_m->get_estados();
    }

    function get_municipios() {
        return $this->requisicao_m->get_municipios($this->uri->segment(3));
    }

    function get_all_pesquisadores() {
        return $this->requisicao_m->get_all_pesquisadores();
    }

    function get_pesquisadores() {
        return $this->requisicao_m->get_pesquisadores($this->uri->segment(3));
    }

    function get_pesquisador_nome() {
        return $this->requisicao_m->get_pesquisador_nome($this->uri->segment(3));
    }

    function get_superintendencias() {
        return $this->requisicao_m->get_superintendencias();
    }

    function get_superintendencias_nome() {
        return $this->requisicao_m->get_superintendencias_nome($this->uri->segment(3), $this->uri->segment(4));
    }

    function get_superintendencias_cursos() {
        return $this->requisicao_m->get_superintendencias_cursos();
    }

    function get_funcoes() {
        return $this->requisicao_m->get_funcoes();
    }

    function get_cursos_by_super() {
        return $this->requisicao_m->get_cursos_by_super($this->uri->segment(3));
    }

    function get_modalidade_by_super() {
        return $this->requisicao_m->get_modalidade_by_super($this->uri->segment(3));
    }

    /* Requisições relatório dinâmico */
    function get_superintendencias_cursos_rel() {
        return $this->requisicao_m->get_superintendencias_cursos_rel();
    }

    function get_cursos_by_super_rel() {
        return $this->requisicao_m->get_cursos_by_super_rel($this->uri->segment(3));
    }

    function get_estados_rel() {
        return $this->requisicao_m->get_estados_rel();
    }

    function get_municipios_rel() {
        return $this->requisicao_m->get_municipios_rel($this->uri->segment(3));
    }

    function get_modalidades_rel() {
        return $this->requisicao_m->get_modalidades_rel();
    }

}

?>