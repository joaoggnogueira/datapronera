<?php

class Mapas_m extends CI_Model {

    public function __construct() {
        parent::__construct();

        $this->load->database();   // Loading Database 
        $this->load->library('session'); // Loading Session
        $this->load->helper('url');  // Loading Helper
    }

    function stringfy($array) {
        $array = json_encode($array);
        $array = str_replace("[", "(", $array);
        $array = str_replace("]", ")", $array);
        return $array;
    }

    function get_sugestao_assentamento($search) {
        
        $search = urldecode($search);
        
        $this->db->select("CONCAT((a.codigo),(' - '),(a.nome)) as busca");
        $this->db->from("assentamentos a");
        $this->db->join("educando e", "e.code_sipra_assentamento = a.codigo");
        $this->db->like('a.codigo', $search);
        $this->db->or_like('a.nome', $search);
        $this->db->limit(10);
        $this->db->distinct();

        $query = $this->db->get();
        
        //echo $this->db->last_query();
        
        $dados = $query->result();
        $result = array();
        foreach ($dados as $value) {
            $result[] = $value->busca;
        }

        return $result;
    }

    function relacao_sr_curso($sr) {

        $sr_id = (int) $sr;

        $stmt = "SELECT 
                c.`id` AS 'id',
                CONCAT(LPAD(sr.`id`,2,0),'.',LPAD(c.`id`,3,0)) AS 'cod',
                IF(c.`nprocesso`='' or c.`nprocesso` is null,'N/D',c.`nprocesso`) as 'SEI',
                c.`nome` as 'nome',
                IFNULL(m.`nome`,'NÃO INFORMADO') as 'Modalidade',
                IFNULL(IF(
                ca.`inicio_realizado` IS NULL or ca.`inicio_realizado` = 'NI',
                CONCAT(ca.`inicio_previsto`,' - ',ca.`termino_previsto`,' (PREVISTO)'),
                CONCAT(ca.`inicio_realizado`,' - ',ca.`termino_realizado`)
                ),'N/D') as 'vigencia',
                IF(ci.id IS NOT NULL, GROUP_CONCAT(ci.nome,' (',e.sigla,')'), 'N/D') as 'municípios'
            FROM `curso` c
            INNER JOIN `superintendencia` sr ON c.`id_superintendencia` = sr.`id` 
            INNER JOIN `curso_modalidade` m ON m.`id` = c.`id_modalidade`
            INNER JOIN `caracterizacao` ca ON ca.`id_curso` = c.`id` 
            LEFT JOIN `caracterizacao_cidade` cc ON cc.`id_caracterizacao` = ca.`id` 
            LEFT JOIN `cidade` ci ON ci.`id` = cc.`id_cidade`
            LEFT JOIN `estado` e ON e.`id` = ci.`id_estado`
            WHERE sr.`id` = $sr_id AND c.`ativo_inativo` = 'A'
            GROUP BY c.id";
        $query = $this->db->query($stmt);
        $result = $this->get_table($query);
        $table = $result['aaData'];

        return $result;
    }

    function get_curso_details($id_curso) {
        $sr_id = (int) $id_curso;

        $stmt = "SELECT "
                . "c.nome as 'nome', "
                . "sr.nome as 'sr', "
                . "IF(c.nprocesso LIKE '' OR c.nprocesso IS NULL,'<i>Não informado</i>',c.nprocesso) as 'sei', "
                . "CONCAT(IF(c.ninstrumento IS NULL OR cti.`id` = 8,'',CONCAT(c.ninstrumento,' - ')),IF(cti.`id` = 8,'<i>Não informado</i>',cti.nome)) as 'instrumento', "
                . "cm.nome as 'modalidade', "
                . "IFNULL(IF(
                    ca.`inicio_realizado` IS NULL OR ca.`inicio_realizado` = 'NI',
                    CONCAT(ca.`inicio_previsto`,' - ',ca.`termino_previsto`,' (PREVISTO)'),
                    CONCAT(ca.`inicio_realizado`,' - ',ca.`termino_realizado`, ' (REALIZADO)')
                    ),'<i>Não informado</i>') as 'vigencia', "
                . "IF(ci.id IS NOT NULL, GROUP_CONCAT(' ',ci.nome,' (',e.sigla,')'), '<i>Não informado</i>') as 'municipios', "
                . "CONCAT(CASE ca.`titulacao_coordenador_geral`
                            WHEN 'ESPECIALISTA' THEN 'Esp. '
                            WHEN 'MESTRE(A)' THEN 'Mr(a). '
                            WHEN 'DOUTOR(A)' THEN 'Dr(a). '
                            WHEN 'GRADUADO(A)' THEN 'Graduado(a). '
                            ELSE ''
                          END,IF(ca.`nome_coordenador_geral` = '' OR ca.`nome_coordenador_geral` IS NULL,'<i>Não informado</i>',ca.`nome_coordenador_geral`)) as 'c_geral', "
                . "CONCAT(CASE ca.`titulacao_coordenador`
                            WHEN 'ESPECIALISTA' THEN 'Esp. '
                            WHEN 'MESTRE(A)' THEN 'Mr(a). '
                            WHEN 'DOUTOR(A)' THEN 'Dr(a). '
                            WHEN 'GRADUADO(A)' THEN 'Graduado(a). '
                            ELSE ''
                          END,IF(ca.`nome_coordenador` = '' OR ca.`nome_coordenador` IS NULL,'<i>Não informado</i>',ca.`nome_coordenador`)) as 'c_curso', "
                . "CONCAT(CASE ca.`titulacao_vice_coordenador`
                            WHEN 'ESPECIALISTA' THEN 'Esp. '
                            WHEN 'MESTRE(A)' THEN 'Mr(a). '
                            WHEN 'DOUTOR(A)' THEN 'Dr(a). '
                            WHEN 'GRADUADO(A)' THEN 'Graduado(a). '
                            ELSE ''
                          END,IF(ca.`nome_vice_coordenador` = '' OR ca.`nome_vice_coordenador` IS NULL,'<i>Não informado</i>',ca.`nome_vice_coordenador`)) as 'vc_curso', "
                . "CONCAT(CASE ca.`titulacao_coordenador_pedagogico`
                            WHEN 'ESPECIALISTA' THEN 'Esp. '
                            WHEN 'MESTRE(A)' THEN 'Mr(a). '
                            WHEN 'DOUTOR(A)' THEN 'Dr(a). '
                            WHEN 'GRADUADO(A)' THEN 'Graduado(a). '
                            ELSE ''
                          END,IF(ca.`nome_coordenador_pedagogico` = '' OR ca.`nome_coordenador_pedagogico` IS NULL,'<i>Não informado</i>',ca.`nome_coordenador_pedagogico`)) as 'cp_curso' "
                . "FROM `curso` c "
                . "INNER JOIN `superintendencia` sr ON sr.id = c.id_superintendencia "
                . "INNER JOIN `curso_tipo_instrumento` cti ON cti.id = c.id_superintendencia "
                . "INNER JOIN `curso_modalidade` cm ON cm.id = c.id_modalidade "
                . "INNER JOIN `caracterizacao` ca ON ca.id_curso = c.id "
                . "LEFT JOIN `caracterizacao_cidade` cc ON cc.`id_caracterizacao` = ca.`id` "
                . "LEFT JOIN `cidade` ci ON ci.`id` = cc.`id_cidade` "
                . "LEFT JOIN `estado` e ON e.`id` = ci.`id_estado` "
                . "WHERE c.id = $id_curso";

        $query = $this->db->query($stmt);
        $result = $query->result();
        return $result[0];
    }

    function list_educandos($id_curso) {
        $sr_id = (int) $id_curso;

        $stmt = "SELECT 
            e.`nome`,
            IFNULL(e.`cpf`,'<i>Não Informado</i>'),
            IFNULL(e.`rg`,'<i>Não Informado</i>'),
            IF(e.`nome_territorio` IS NULL OR e.`nome_territorio` LIKE '' OR e.`nome_territorio` LIKE 'NÃO INFORMADO','<i>Não Informado</i>',e.`nome_territorio`),
            IFNULL(CONCAT(m.`nome`,' (',est.`sigla`,')'),'<i>Não Informado</i>')
            FROM `educando` e 
            LEFT JOIN `educando_cidade` ec ON ec.id_educando = e.id 
            LEFT JOIN `cidade` m ON m.id = ec.id_cidade 
            LEFT JOIN `estado` est ON est.id = m.`id_estado` 
            WHERE e.id_curso = $sr_id";

        $query = $this->db->query($stmt);
        $result = $this->get_table($query);
        $table = $result['aaData'];

        return $result;
    }

    //mapas
    function get_municipios_cursos($filtros) {

        $status = $this->stringfy($filtros['status']);
        $sr = $this->stringfy($filtros['sr']);

        $modalidade = $filtros['modalidade'];

        $modalidade_nil = $modalidade['nil'];
        if (isset($modalidade['ids'])) {
            $modalidade_ids = json_encode($modalidade['ids']);
            $modalidade_ids = str_replace("[", "(", $modalidade_ids);
            $modalidade_ids = str_replace("]", ")", $modalidade_ids);
        } else {
            $modalidade_ids = false;
        }

        $stmt = "
            SELECT 
                m.id as id,
                COUNT(m.id) as total,
                m.nome as municipio,
                est.nome as estado,
                lg.latitude as lat, 
                lg.longitude as lng,
                cr.inicio_realizado as inicio,
                cr.termino_realizado as termino,
                m.cod_municipio as cod
            FROM `curso` c
                INNER JOIN caracterizacao cr ON c.id = cr.id_curso
                INNER JOIN caracterizacao_cidade ccr ON ccr.id_caracterizacao = cr.id
                INNER JOIN cidade m ON m.id = ccr.id_cidade
                INNER JOIN estado est ON est.id = m.id_estado 
                INNER JOIN cidades_lat_long lg ON lg.id_geocode = m.cod_municipio
            WHERE 
                c.ativo_inativo = 'A' 
            ";

        if (count($filtros['vigencia']) < 2) {
            $atual = (((int) date("Y")) - 1950) * 12 + ((int) date("m"));

            if (in_array("AN", $filtros['vigencia'])) {
                $stmt .= " AND ($atual BETWEEN date_to_number(cr.`inicio_realizado`,('01/1950')) AND date_to_number(cr.`termino_realizado`,('01/2050'))) ";
            } else if (in_array("CC", $filtros['vigencia'])) {
                $stmt .= " AND ($atual NOT BETWEEN date_to_number(cr.`inicio_realizado`,('01/1950')) AND date_to_number(cr.`termino_realizado`,('01/2050'))) ";
            }
        }

        if (count($filtros['sr']) < 30) {
            $stmt .= " AND c.id_superintendencia in $sr ";
        }

        if (count($filtros['status']) < 3) {
            $stmt .= " AND c.status in $status ";
        }

        if ($modalidade_ids) {
            if ($modalidade_nil != 'false') {
                $stmt .= " AND (c.id_modalidade IN $modalidade_ids OR c.id_modalidade IS NULL)";
            } else {
                $stmt .= " AND c.id_modalidade IN $modalidade_ids";
            }
        } else if ($modalidade_nil != 'false') {
            $stmt .= " AND c.id_modalidade IS NULL";
        }

        $stmt .= " GROUP BY m.id ORDER BY total DESC";

        $query = $this->db->query($stmt);

        return $query->result();
    }

    function get_municipios_educandos($filtros) {

        $status = $this->stringfy($filtros['status']);
        $sr = $this->stringfy($filtros['sr']);

        $modalidade = $filtros['modalidade'];

        $modalidade_nil = $modalidade['nil'];
        if (isset($modalidade['ids'])) {
            $modalidade_ids = json_encode($modalidade['ids']);
            $modalidade_ids = str_replace("[", "(", $modalidade_ids);
            $modalidade_ids = str_replace("]", ")", $modalidade_ids);
        } else {
            $modalidade_ids = false;
        }

        $stmt = "
            SELECT 
                m.id as id,
                COUNT(m.id) as total,
                m.nome as municipio,
                est.nome as estado,
                lg.latitude as lat, 
                lg.longitude as lng,
                ca.inicio_realizado as inicio,
                ca.termino_realizado as termino,
                m.cod_municipio as cod
            FROM `educando` e
                INNER JOIN educando_cidade ec ON ec.id_educando = e.id
                INNER JOIN cidade m ON m.id = ec.id_cidade
                INNER JOIN estado est ON est.id = m.id_estado  
                INNER JOIN cidades_lat_long lg ON lg.id_geocode = m.cod_municipio 
                INNER JOIN curso c ON c.id = e.id_curso 
                INNER JOIN caracterizacao ca ON ca.id_curso = c.id 
            WHERE 
                c.ativo_inativo = 'A'
        ";

        if (count($filtros['vigencia']) < 2) {
            $atual = (((int) date("Y")) - 1950) * 12 + ((int) date("m"));

            if (in_array("AN", $filtros['vigencia'])) {
                $stmt .= " AND ($atual BETWEEN date_to_number(ca.`inicio_realizado`,('01/1950')) AND date_to_number(ca.`termino_realizado`,('01/2050'))) ";
            } else if (in_array("CC", $filtros['vigencia'])) {
                $stmt .= " AND ($atual NOT BETWEEN date_to_number(ca.`inicio_realizado`,('01/1950')) AND date_to_number(ca.`termino_realizado`,('01/2050'))) ";
            }
        }

        if (count($filtros['sr']) < 30) {
            $stmt .= " AND c.id_superintendencia in $sr ";
        }

        if (count($filtros['status']) < 3) {
            $stmt .= " AND c.status in $status ";
        }

        if (isset($filtros['assentamento'])) {
            $sipra = $filtros['assentamento'];
            if ($sipra != "NULL") {
                $stmt .= " AND e.code_sipra_assentamento LIKE '$sipra' ";
            } else {
                $stmt .= " AND e.code_sipra_assentamento IS NULL ";
            }
        }

        if ($modalidade_ids) {
            if ($modalidade_nil != 'false') {
                $stmt .= " AND (c.id_modalidade IN $modalidade_ids OR c.id_modalidade IS NULL)";
            } else {
                $stmt .= " AND c.id_modalidade IN $modalidade_ids";
            }
        } else if ($modalidade_nil != 'false') {
            $stmt .= " AND c.id_modalidade IS NULL";
        }

        $stmt .= " GROUP BY m.id ORDER BY total DESC";

        $query = $this->db->query($stmt);

        return $query->result();
    }

    //desabilitado
    function get_municipios_instituicoes($filtros) {

        $status = $this->stringfy($filtros['status']);

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

    //tabelas
    //Lista Cursos do mapa Educando
    function get_cursos_educandos($id_municipio, $filtros) {
        $status = $this->stringfy($filtros->status);
        $sr = $this->stringfy($filtros->sr);
        $modalidade = (array) $filtros->modalidade;

        $modalidade_nil = $modalidade['nil'];
        if (isset($modalidade['ids'])) {
            $modalidade_ids = json_encode($modalidade['ids']);
            $modalidade_ids = str_replace("[", "(", $modalidade_ids);
            $modalidade_ids = str_replace("]", ")", $modalidade_ids);
        } else {
            $modalidade_ids = false;
        }

        $stmt = "
            SELECT 
                DISTINCT CONCAT(LPAD(c.id_superintendencia, 2, 0 ),'.', LPAD(c.id, 3, 0 )), 
                `c`.`nome` , 
                `m`.`nome` as modal, 
                CONCAT((`cr`.`inicio_realizado`),(' - '),(`cr`.`termino_realizado`)),
                `c`.`id` as idcurso
            FROM `educando` e 
            INNER JOIN `educando_cidade` ec ON `ec`.`id_educando` = `e`.`id` 
            INNER JOIN `curso` c ON `c`.`id` = `e`.`id_curso` 
            INNER JOIN `curso_modalidade` m ON `m`.`id` = `c`.`id_modalidade`
            INNER JOIN caracterizacao cr ON c.id = cr.id_curso
            WHERE c.id_superintendencia IN $sr AND `ec`.`id_cidade` = '" . $id_municipio . "'  AND `c`.`ativo_inativo` = 'A' AND `c`.`status` IN $status
        ";
        if ($modalidade_ids) {
            if ($modalidade_nil != 'false') {
                $stmt .= " AND (c.id_modalidade IN $modalidade_ids OR c.id_modalidade IS NULL)";
            } else {
                $stmt .= " AND c.id_modalidade IN $modalidade_ids";
            }
        } else if ($modalidade_nil != 'false') {
            $stmt .= " AND c.id_modalidade IS NULL";
        }

        if (isset($filtros->assentamento)) {
            $sipra = $filtros->assentamento;
            if ($sipra != "NULL") {
                $stmt .= " AND e.code_sipra_assentamento LIKE '$sipra' ";
            } else {
                $stmt .= " AND e.code_sipra_assentamento IS NULL ";
            }
        }

        if (count($filtros->vigencia) < 2) {
            $atual = (((int) date("Y")) - 1950) * 12 + ((int) date("m"));

            if (in_array("AN", $filtros->vigencia)) {
                $stmt .= " AND ($atual BETWEEN date_to_number(cr.`inicio_realizado`,('01/1950')) AND date_to_number(cr.`termino_realizado`,('01/2050'))) ";
            } else if (in_array("CC", $filtros['vigencia'])) {
                $stmt .= " AND ($atual NOT BETWEEN date_to_number(cr.`inicio_realizado`,('01/1950')) AND date_to_number(cr.`termino_realizado`,('01/2050'))) ";
            }
        }
        
        $query = $this->db->query($stmt);

        $result = $this->get_table($query);
        $table = $result['aaData'];

        foreach ($table as $key => $row) {

            $this->db->select("COUNT(e.id) as total");
            $this->db->from("educando e");
            $this->db->join('educando_cidade ec', 'ec.id_educando = e.id');
            $this->db->join('curso c', 'c.id = e.id_curso');
            $this->db->where("c.id", $row[4]);
            $this->db->where('ec.id_cidade', $id_municipio);
            if (isset($filtros->assentamento)) {
                $sipra = $filtros->assentamento;
                if ($sipra != "NULL") {
                    $this->db->where('e.code_sipra_assentamento',$sipra);
                } else {
                    $this->db->where('e.code_sipra_assentamento IS NULL');
                }
            }
            $this->db->distinct();

            $query1 = $this->db->get();

            $fetch = $query1->result();

            $result['aaData'][$key][4] = $fetch[0]->total;

            $this->db->select("COUNT(e.id) as total_nacional");
            $this->db->from("educando e");
            $this->db->join('educando_cidade ec', 'ec.id_educando = e.id');
            $this->db->join('curso c', 'c.id = e.id_curso');
            $this->db->where("c.id", $row[4]);

            $this->db->distinct();

            $query1 = $this->db->get();

            $fetch = $query1->result();

            $result['aaData'][$key][4] .= " / " . $fetch[0]->total_nacional;
        }

        return $result;
    }

    //Lista Educandos do mapa Curso
    function get_educandos_cursos($id_municipio, $filtros) {

        $status = $this->stringfy($filtros->status);
        $sr = $this->stringfy($filtros->sr);
        $modalidade = (array) $filtros->modalidade;

        $modalidade_nil = $modalidade['nil'];
        if (isset($modalidade['ids'])) {
            $modalidade_ids = json_encode($modalidade['ids']);
            $modalidade_ids = str_replace("[", "(", $modalidade_ids);
            $modalidade_ids = str_replace("]", ")", $modalidade_ids);
        } else {
            $modalidade_ids = false;
        }

        $id = (int) $id_municipio;
        $stmt = "
            SELECT 
                e.nome as educando,
                CONCAT(m.nome,' (',est.sigla,')'),
                e.nome_territorio,
                e.tipo_territorio,
                CONCAT(LPAD(c.id_superintendencia, (2), (0) ),('.'), LPAD(c.id, (3), (0) )) as codcurso
            FROM `curso` c
            INNER JOIN caracterizacao cr ON c.id = cr.id_curso
            INNER JOIN caracterizacao_cidade ccr ON ccr.id_caracterizacao = cr.id
            INNER JOIN educando e ON e.id_curso = c.id
            LEFT JOIN educando_cidade ec ON ec.id_educando = e.id 
            LEFT JOIN cidade m ON m.id = ec.id_cidade 
            LEFT JOIN estado est ON est.id = m.id_estado 
            WHERE c.id_superintendencia IN $sr AND c.ativo_inativo = 'A' AND ccr.id_cidade = $id AND `c`.`status` IN $status ";

        if (count($filtros->vigencia) < 2) {
            $atual = (((int) date("Y")) - 1950) * 12 + ((int) date("m"));

            if (in_array("AN", $filtros->vigencia)) {
                $stmt .= " AND ($atual BETWEEN date_to_number(cr.`inicio_realizado`,('01/1950')) AND date_to_number(cr.`termino_realizado`,('01/2050'))) ";
            } else if (in_array("CC", $filtros['vigencia'])) {
                $stmt .= " AND ($atual NOT BETWEEN date_to_number(cr.`inicio_realizado`,('01/1950')) AND date_to_number(cr.`termino_realizado`,('01/2050'))) ";
            }
        }

        if ($modalidade_ids) {
            if ($modalidade_nil != 'false') {
                $stmt .= " AND (c.id_modalidade IN $modalidade_ids OR c.id_modalidade IS NULL)";
            } else {
                $stmt .= " AND c.id_modalidade IN $modalidade_ids";
            }
        } else if ($modalidade_nil != 'false') {
            $stmt .= " AND c.id_modalidade IS NULL";
        }

        $stmt .= " ORDER BY c.id";

        $query = $this->db->query($stmt);

        return $this->get_table($query);
    }

    function get_educandos($id_municipio, $filtros) {
        $status = $this->stringfy($filtros->status);
        $sr = $this->stringfy($filtros->sr);
        $modalidade = (array) $filtros->modalidade;

        $modalidade_nil = $modalidade['nil'];
        if (isset($modalidade['ids'])) {
            $modalidade_ids = json_encode($modalidade['ids']);
            $modalidade_ids = str_replace("[", "(", $modalidade_ids);
            $modalidade_ids = str_replace("]", ")", $modalidade_ids);
        } else {
            $modalidade_ids = false;
        }

        $this->db->select("e.nome, e.nome_territorio, e.code_sipra_assentamento, CONCAT(LPAD(c.id_superintendencia, (2), (0) ),('.'), LPAD(c.id, (3), (0) )) as codcurso");
        $this->db->from('educando e');
        $this->db->join('educando_cidade ec', 'ec.id_educando = e.id');
        $this->db->join('curso c', 'c.id = e.id_curso');
        $this->db->join('caracterizacao ca', 'ca.id_curso = c.id');
        $this->db->where('ec.id_cidade', $id_municipio);
        $this->db->where('c.ativo_inativo', 'A');

        $complemento_vigencia = "";
        $complemento_assentamento = "";

        if (count($filtros->vigencia) < 2) {
            $atual = (((int) date("Y")) - 1950) * 12 + ((int) date("m"));

            if (in_array("AN", $filtros->vigencia)) {
                $complemento_vigencia = " AND ($atual BETWEEN date_to_number(ca.`inicio_realizado`,('01/1950')) AND date_to_number(ca.`termino_realizado`,('01/2050'))) ";
            } else if (in_array("CC", $filtros['vigencia'])) {
                $complemento_vigencia = " AND ($atual NOT BETWEEN date_to_number(ca.`inicio_realizado`,('01/1950')) AND date_to_number(ca.`termino_realizado`,('01/2050'))) ";
            }
        }

        if (isset($filtros->assentamento)) {
            $sipra = $filtros->assentamento;
            if ($sipra != "NULL") {
                $complemento_assentamento .= " AND e.code_sipra_assentamento LIKE '$sipra' ";
            } else {
                $complemento_assentamento .= " AND e.code_sipra_assentamento IS NULL ";
            }
        }

        if ($modalidade_ids) {
            if ($modalidade_nil != 'false') {
                $this->db->where("c.id_superintendencia IN $sr AND c.status IN $status AND (c.id_modalidade IN $modalidade_ids OR c.id_modalidade IS NULL) $complemento_vigencia $complemento_assentamento");
            } else {
                $this->db->where("c.id_superintendencia IN $sr AND c.status IN $status AND c.id_modalidade IN $modalidade_ids $complemento_vigencia $complemento_assentamento");
            }
        } else if ($modalidade_nil != 'false') {
            $this->db->where("c.id_superintendencia IN $sr AND c.status IN $status && c.id_modalidade IS NULL $complemento_vigencia $complemento_assentamento");
        }

        return $this->get_table($this->db->get());
    }

    function get_instituicoes($id_municipio, $filtros) {
        $status = $this->stringfy($filtros->status);

        $this->db->select('ie.id,ie.nome,ie.sigla,ie.unidade,c.nome as curso');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso');
        $this->db->where('ie.id_cidade', $id_municipio);
        $this->db->where("c.status IN $status");
        return $this->get_table($this->db->get());
    }

    function get_cursos($id_municipio, $filtros) {

        $status = $this->stringfy($filtros->status);
        $sr = $this->stringfy($filtros->sr);
        $modalidade = (array) $filtros->modalidade;

        $modalidade_nil = $modalidade['nil'];
        if (isset($modalidade['ids'])) {
            $modalidade_ids = json_encode($modalidade['ids']);
            $modalidade_ids = str_replace("[", "(", $modalidade_ids);
            $modalidade_ids = str_replace("]", ")", $modalidade_ids);
        } else {
            $modalidade_ids = false;
        }
        $id = (int) $id_municipio;
        $stmt = "
            SELECT DISTINCT 
                CONCAT(LPAD(c.id_superintendencia, 2, 0 ),'.', LPAD(c.id, 3, 0 )), 
                `c`.`nome` , 
                `modal`.`nome` as mdldd, 
                ie.nome as inst, 
                c.id
            FROM `curso` c 
            INNER JOIN caracterizacao cr ON c.id = cr.id_curso
            INNER JOIN caracterizacao_cidade ccr ON ccr.id_caracterizacao = cr.id
            INNER JOIN cidade m ON m.id = ccr.id_cidade
            INNER JOIN estado est ON est.id = m.id_estado 
            INNER JOIN cidades_lat_long lg ON lg.id_geocode = m.cod_municipio 
            INNER JOIN `curso_modalidade` modal ON `modal`.`id` = `c`.`id_modalidade` 
            INNER JOIN instituicao_ensino ie ON ie.id_curso = c.id 
            WHERE c.id_superintendencia IN $sr AND c.ativo_inativo = 'A' AND c.status IN $status AND m.id = $id";

        if (count($filtros->vigencia) < 2) {
            $atual = (((int) date("Y")) - 1950) * 12 + ((int) date("m"));

            if (in_array("AN", $filtros->vigencia)) {
                $stmt .= " AND ($atual BETWEEN date_to_number(cr.`inicio_realizado`,('01/1950')) AND date_to_number(cr.`termino_realizado`,('01/2050'))) ";
            } else if (in_array("CC", $filtros['vigencia'])) {
                $stmt .= " AND ($atual NOT BETWEEN date_to_number(cr.`inicio_realizado`,('01/1950')) AND date_to_number(cr.`termino_realizado`,('01/2050'))) ";
            }
        }

        if ($modalidade_ids) {
            if ($modalidade_nil != 'false') {
                $stmt .= " AND (c.id_modalidade IN $modalidade_ids OR c.id_modalidade IS NULL)";
            } else {
                $stmt .= " AND c.id_modalidade IN $modalidade_ids";
            }
        } else if ($modalidade_nil != 'false') {
            $stmt .= " AND c.id_modalidade IS NULL";
        }

        $query = $this->db->query($stmt);

        $result = $this->get_table($query);
        $table = $result['aaData'];

        foreach ($table as $key => $row) {
            $idc = $row[4];
            $query1 = $this->db->query("
            SELECT COUNT(e.id) as total
            FROM educando e 
            INNER JOIN `curso` c ON c.id = e.id_curso 
            WHERE c.id = $idc");

            $fetch = $query1->result();

            $result['aaData'][$key][4] = $fetch[0]->total;
        }

        return $result;
    }

    //Buscas
    function search_educando($search, $filtros) {

        $search = urldecode($search);

        $status = $this->stringfy($filtros->status);
        $sr = $this->stringfy($filtros->sr);
        $modalidade = (array) $filtros->modalidade;

        $modalidade_nil = $modalidade['nil'];
        if (isset($modalidade['ids'])) {
            $modalidade_ids = json_encode($modalidade['ids']);
            $modalidade_ids = str_replace("[", "(", $modalidade_ids);
            $modalidade_ids = str_replace("]", ")", $modalidade_ids);
        } else {
            $modalidade_ids = false;
        }

        $this->db->select('ec.id_cidade as id,e.nome as nome,c.nome as curso');
        $this->db->from('educando e');
        $this->db->join('educando_cidade ec', 'ec.id_educando = e.id');
        $this->db->join('curso c', 'c.id = e.id_curso');
        $this->db->like('e.nome', "$search");
        $this->db->where('c.ativo_inativo', "A");

        if (count($filtros->sr) < 30) {
            $this->db->where("c.id_superintendencia IN $sr");
        }

        if (count($filtros->status) < 3) {
            $this->db->where("c.status IN $status");
        }

        if ($modalidade_ids) {
            if ($modalidade_nil != 'false') {
                $this->db->where("c.id_modalidade IN $modalidade_ids OR c.id_modalidade IS NULL");
            } else {
                $this->db->where("c.id_modalidade IN $modalidade_ids");
            }
        } else if ($modalidade_nil != 'false') {
            $this->db->where("c.id_modalidade IS NULL");
        }
        return $this->get_table($this->db->get());
    }

    function search_curso($search, $filtros) {

        $search = urldecode($search);

        $status = $this->stringfy($filtros->status);
        $sr = $this->stringfy($filtros->sr);
        $modalidade = (array) $filtros->modalidade;

        $modalidade_nil = $modalidade['nil'];
        if (isset($modalidade['ids'])) {
            $modalidade_ids = json_encode($modalidade['ids']);
            $modalidade_ids = str_replace("[", "(", $modalidade_ids);
            $modalidade_ids = str_replace("]", ")", $modalidade_ids);
        } else {
            $modalidade_ids = false;
        }

        $this->db->select('cc.id_cidade as id, c.nome as curso, cid.nome as município');
        $this->db->from('caracterizacao_cidade cc');
        $this->db->join('caracterizacao ca', 'cc.id_caracterizacao = ca.id');
        $this->db->join('curso c', 'c.id = ca.id_curso');
        $this->db->join('cidade cid', 'cid.id = cc.id_cidade');
        $this->db->like('c.nome', "$search");
        $this->db->where('c.ativo_inativo', "A");
        $this->db->where("c.status IN $status");
        $this->db->where("c.id_superintendencia IN $sr");
        if ($modalidade_ids) {
            if ($modalidade_nil != 'false') {
                $this->db->where("c.id_modalidade IN $modalidade_ids OR c.id_modalidade IS NULL");
            } else {
                $this->db->where("c.id_modalidade IN $modalidade_ids");
            }
        } else if ($modalidade_nil != 'false') {
            $this->db->where("c.id_modalidade IS NULL");
        }
        return $this->get_table($this->db->get());
    }

    function get_table($query) {
//        print_r($_GET);
        //var_dump($this->db->last_query());

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