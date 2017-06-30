<?php

class Mapas_m extends CI_Model {

    public function __construct() {
        parent::__construct();

        $this->load->database();   // Loading Database 
        $this->load->library('session'); // Loading Session
        $this->load->helper('url');  // Loading Helper
    }


    function get_municipios_cursos() {

        $query = $this->db->query("
            SELECT m.id as id,COUNT(m.id) as total,m.nome as municipio,est.nome as estado,lg.latitude as lat, lg.longitude as lng 
            FROM `curso` c
            INNER JOIN caracterizacao cr ON c.id = cr.id_curso
            INNER JOIN caracterizacao_cidade ccr ON ccr.id_caracterizacao = cr.id
            INNER JOIN cidade m ON m.id = ccr.id_cidade
            INNER JOIN estado est ON est.id = m.id_estado 
            INNER JOIN cidades_lat_long lg ON lg.id_geocode = m.cod_municipio
            WHERE c.ativo_inativo = 'A' 
            GROUP BY m.id");
        return $query->result();
    }

    function get_municipios_educandos() {

        $query = $this->db->query("
            SELECT m.id as id,COUNT(m.id) as total,m.nome as municipio,est.nome as estado,lg.latitude as lat, lg.longitude as lng FROM `educando` e
            INNER JOIN educando_cidade ec ON ec.id_educando = e.id
            INNER JOIN cidade m ON m.id = ec.id_cidade
            INNER JOIN estado est ON est.id = m.id_estado  
            INNER JOIN cidades_lat_long lg ON lg.id_geocode = m.cod_municipio 
            INNER JOIN curso c ON c.id = e.id_curso 
            WHERE c.ativo_inativo = 'A' 
            GROUP BY m.id
        ");
        return $query->result();
    }

    
    function get_municipios_instituicoes(){
        $query = $this->db->query("
            SELECT m.id as id,COUNT(m.id) as total,m.nome as municipio,est.nome as estado,lg.latitude as lat, lg.longitude as lng 
            FROM `instituicao_ensino` ie
            INNER JOIN cidade m ON m.id = ie.id_cidade 
            INNER JOIN estado est ON est.id = m.id_estado  
            INNER JOIN cidades_lat_long lg ON lg.id_geocode = m.cod_municipio 
            GROUP BY m.id
        ");
        
        return $query->result();
    }

    function get_cursos_educandos($id_municipio) {
        $query = $this->db->query("
            SELECT DISTINCT CONCAT(LPAD(c.id_superintendencia, 2, 0 ),'.', LPAD(c.id, 3, 0 )), `c`.`nome` , `m`.`nome` as modal
            FROM `educando` e 
            INNER JOIN `educando_cidade` ec ON `ec`.`id_educando` = `e`.`id` 
            INNER JOIN `curso` c ON `c`.`id` = `e`.`id_curso` 
            INNER JOIN `curso_modalidade` m ON `m`.`id` = `c`.`id_modalidade` 
            WHERE `ec`.`id_cidade` = '".$id_municipio."'  AND `c`.`ativo_inativo` = 'A'
        ");

        
        return $this->get_table($query);
    }
    
    function get_educandos($id_municipio) {
        $this->db->select('e.nome,e.nome_territorio, e.tipo_territorio, e.code_sipra_assentamento');
        $this->db->from('educando e');
        $this->db->join('educando_cidade ec', 'ec.id_educando = e.id');
        $this->db->join('curso c', 'c.id = e.id_curso');
        $this->db->where('ec.id_cidade', $id_municipio);
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->distinct();
        return $this->get_table($this->db->get());
    }
    
    function get_instituicoes($id_municipio){
        $this->db->select('id,nome,sigla,unidade,natureza_instituicao');
        $this->db->from('instituicao_ensino ie');
        $this->db->where('ie.id_cidade', $id_municipio);
        return $this->get_table($this->db->get());
    }
    
    function get_cursos($id_municipio){
        $id = (int)$id_municipio;
        $query = $this->db->query("
            SELECT DISTINCT CONCAT(LPAD(c.id_superintendencia, 2, 0 ),'.', LPAD(c.id, 3, 0 )), `c`.`nome` , `modal`.`nome` as mdldd
            FROM `curso` c 
            INNER JOIN caracterizacao cr ON c.id = cr.id_curso
            INNER JOIN caracterizacao_cidade ccr ON ccr.id_caracterizacao = cr.id
            INNER JOIN cidade m ON m.id = ccr.id_cidade
            INNER JOIN estado est ON est.id = m.id_estado 
            INNER JOIN cidades_lat_long lg ON lg.id_geocode = m.cod_municipio 
            INNER JOIN `curso_modalidade` modal ON `modal`.`id` = `c`.`id_modalidade` 
            WHERE c.ativo_inativo = 'A' AND m.id = ".$id);
        return $this->get_table($query);
    }

    function get_table($query) {
        $dados = $query->result_array();
        
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

        return $output;
    }

}

?>