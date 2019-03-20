<?php

class Relatorio_geral_m_pnera2 extends CI_Model {

    function get_niveis_modalidade() {

        $this->db->select('DISTINCT(nivel)');

        if (($query = $this->db->get('curso_modalidade')) != null) {
            return $query->result();
        } else {
            return false;
        }
    }

    //PREPARE-SE PARA MORRER FUNÇÃO
    function array_to_sql($stats) {
        $text = json_encode($stats);
        $text = str_replace("[", "(", $text);
        $text = str_replace("]", ")", $text);
        return $text;
    }

    function db_join_and_where_vigencia_filter($vigencia, $join) {
        if ($vigencia != "BOTH") {
            if ($join) {
                $this->db->join("caracterizacao cr", "cr.id_curso = c.id");
            }
            $atual = (((int) date("Y")) - 1950) * 12 + ((int) date("m"));
            if ($vigencia == "AN") {
                $this->db->where("($atual BETWEEN date_to_number(cr.`inicio_realizado`,('01/1950')) AND date_to_number(cr.`termino_realizado`,('01/2050')))");
            } else if ($vigencia == "CC") {
                $this->db->where("($atual NOT BETWEEN date_to_number(cr.`inicio_realizado`,('01/1950')) AND date_to_number(cr.`termino_realizado`,('01/2050')))");
            }
        }
    }

    function db_where_sr_filter($access_level) {
        if ($access_level <= 3) {
            $this->db->where('c.id_superintendencia', $this->session->userdata('id_superintendencia'));
        }
    }

    function db_where_status_filter($status) {
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where_in('c.status', $status);
    }

    function get_tipo_territorio() {
        return array(
            'acampamento' => 'ACAMPAMENTO',
            'assentamento' => 'ASSENTAMENTO',
            'comunidade' => 'COMUNIDADE',
            'quilombola' => 'QUILOMBOLA',
            'comunidade_ribeirinha' => 'COMUNIDADE RIBEIRINHA',
            'floresta_nacional' => 'FLORESTA NACIONAL',
            'resex' => 'RESEX',
            'flona' => 'FLONA',
            'rds' => 'RDS',
            'outro' => 'OUTRO',
            'nao_preenchido' => '',
            'nao_informado' => '###'
        );
    }

    function get_titulacao_professor($short_name = false) {
        return ($short_name ? array(
            'ensino_fundamental_completo' => array("ENSINO FUNDAMENTAL COMPLETO"),
            'ensino_fundamental_incompleto' => array("ENSINO FUNDAMENTAL INCOMPLETO"),
            'ensino_medio_completo' => array("ENSINO MEDIO COMPLETO"),
            'ensino_medio_incompleto' => array("ENSINO MEDIO INCOMPLETO"),
            'graduado' => array("GRADUADO(A)"),
            'especialista' => array("ESPECIALISTA"),
            'mestre' => array("MESTRE(A)"),
            'doutor' => array("DOUTOR(A)"),
            'undefined' => array("", "NAOINFORMADO", "###")) : array(
            'ENSINO FUNDAMENTAL COMPLETO' => array("ENSINO FUNDAMENTAL COMPLETO"),
            'ENSINO FUNDAMENTAL INCOMPLETO' => array("ENSINO FUNDAMENTAL INCOMPLETO"),
            'ENSINO MÉDIO COMPLETO' => array("ENSINO MEDIO COMPLETO"),
            'ENSINO MÉDIO INCOMPLETO' => array("ENSINO MEDIO INCOMPLETO"),
            'GRADUADO(A)' => array("GRADUADO(A)"),
            'ESPECIALISTA' => array("ESPECIALISTA"),
            'MESTRE(A)' => array("MESTRE(A)"),
            'DOUTOR(A)' => array("DOUTOR(A)"),
            'NÃO INFORMADO' => array("", "NAOINFORMADO", "###")
        ));
    }

    function get_niveis($short_name = false) {
        if ($short_name) {
            return array(
                "eja_fundamental" => array(17, 19, 23),
                "ensino_medio" => array(18, 24, 16, 21, 20, 31),
                "ensino_superior" => array(15, 25, 22, 30, 32, 34, 35, 33)
            );
        } else {
            return array(
                "EJA FUNDAMENTAL" => array(17, 19, 23),
                "ENSINO MÉDIO" => array(18, 24, 16, 21, 20, 31),
                "ENSINO SUPERIOR" => array(15, 25, 22, 30, 32, 34, 35, 33)
            );
        }
    }

    function get_modalidades() {
        return array(
            "15" => "graduacao",
            "16" => "medio_conc",
            "17" => "eja_alf",
            "18" => "eja_mag_form",
            "19" => "eja_anos_inic",
            "20" => "medio_prof_",
            "21" => "medio_int",
            "22" => "res_agraria",
            "23" => "eja_anos_fin",
            "24" => "eja_normal",
            "25" => "especializacao",
            "30" => "mestrado"
        );
    }

    function db_result() {
        if (($query = $this->db->get()) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /**
     * $array_to[$index_to] <- $array_from[$index_from] (join by glue)
     */
    function array_push_column(&$array_to, $index_to, $array_from, $index_from, $glue) {
        $hash = array();
        foreach ($array_from as $key => $value) {
            $hash[$value[$glue]] = $value;
        }

        foreach ($array_to as $key => $value) {
            if (isset($hash[$value[$glue]])) {
                $array_to[$key][$index_to] = $hash[$value[$glue]][$index_from];
            }
        }
    }

    function array_push_keys($array, $keys, $defaultValue) {
        foreach ($keys as $key) {
            $array[$key] = $defaultValue;
        }
        return $array;
    }

    function matrix_push_keys($matriz, $keys, $defaultValue) {
        foreach ($matriz as $index => $rows) {
            $matriz[$index] = $this->array_push_keys($rows, $keys, $defaultValue);
        }
        return $matriz;
    }

    function percent_rows($result_final, $columns) {
        foreach ($result_final as $key_result => $result) {
            $sum = 0;
            foreach ($columns as $key => $value) {
                if (isset($result[$key])) {
                    $sum += (int) $result[$key];
                } else {
                    $result_final[$key_result][$key] = "-";
                }
            }
            foreach ($columns as $key => $value) {
                if ($sum != 0) {
                    $result_final[$key_result][$key] = 100.0 * ($result_final[$key_result][$key] / $sum);
                }
            }
        }
        return $result_final;
    }

    function percent_column($result_final, $columnanme, $sum) {
        if ($sum != 0) {
            foreach ($result_final as $key => $result) {
                $result_final[$key][$columnanme] = ($result[$columnanme] / $sum) * 100;
            }
            return $result_final;
        } else {
            return array();
        }
    }

    function cursos_modalidade($access_level, $vigencia, $status) {
        $this->db->select('cm.nome AS modalidade, COUNT(c.id) AS cursos')
                ->from('curso_modalidade cm')
                ->join('curso c', 'cm.id = c.id_modalidade', 'left');
        $this->db_join_and_where_vigencia_filter($vigencia, true);
        $this->db_where_status_filter($status);
        $this->db_where_sr_filter($access_level);

        $this->db->group_by('cm.nome');
        return $this->db_result();
    }

    function cursos_nivel($access_level, $vigencia, $status) {
        $niveis = $this->get_niveis();
        $result_final = array();
        foreach ($niveis as $key => $value) {
            $this->db->select("('$key') as nivel,IF(COUNT(c.id)<>0,COUNT(c.id),('-')) as total")->from('curso c');
            $this->db_join_and_where_vigencia_filter($vigencia, true);
            $this->db->where_in('c.id_modalidade', $value);
            $this->db_where_status_filter($status);
            $this->db_where_sr_filter($access_level);
            $result = $this->db_result();
            array_push($result_final, $result[0]);
        }
        return $result_final;
    }

    function cursos_nivel_superintendencia($vigencia, $status) {
        $niveis = $this->get_niveis(true);
        $this->db->select("s.id as id, CONCAT(('SR - '),LPAD(s.id,(2),(0)),(' '),(s.nome)) as nome, (0) as total")->from("superintendencia s")->order_by('s.id');
        $result_final = $this->db_result();
        foreach ($niveis as $key => $value) { //itera os 3 níveis de curso
            $this->db->select("s.id as id, COUNT(c.id) as total")->from("superintendencia s")->join("curso c", "s.id = c.id_superintendencia", "left");
            $this->db_join_and_where_vigencia_filter($vigencia, true);
            $this->db_where_status_filter($status);
            $this->db->where_in('c.id_modalidade', $value)->group_by('s.id');
            $result = $this->db_result();
            $this->array_push_column($result_final, $key, $result, "total", "id");
            foreach ($result_final as $key_row => $row) {
                if (!isset($row[$key])) {
                    $result_final[$key_row][$key] = 0;
                }
                $result_final[$key_row]['total'] += (int) $result_final[$key_row][$key];
            }
        }
        return $result_final;
    }

    function cursos_superintendencia($access_level, $vigencia, $status) {

        $this->db->select("CONCAT(('SR - '),LPAD(s.id,(2),(0))) as id, s.nome AS superintendencia, COUNT(c.id) AS cursos")
                ->from('superintendencia s')
                ->join('curso c', 's.id = c.id_superintendencia', 'left');
        $this->db_join_and_where_vigencia_filter($vigencia, true);
        $this->db_where_status_filter($status);
        $this->db_where_sr_filter($access_level);
        $this->db->group_by('s.id')->order_by('s.id');

        return $this->db_result();
    }

    function alunos_ingressantes_modalidade($access_level, $vigencia, $status) {

        $this->db->select('
			cm.nome AS modalidade,
			IF (SUM(cr.numero_ingressantes) > 0, SUM(cr.numero_ingressantes), 0) AS alunos_ingressantes
		', false)
                ->from('caracterizacao cr')
                ->join('curso c', 'cr.id_curso = c.id', 'left')
                ->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left');
        $this->db_join_and_where_vigencia_filter($vigencia, false);
        $this->db_where_status_filter($status);
        $this->db->where('cr.numero_ingressantes >=', 0);
        $this->db_where_sr_filter($access_level);

        $this->db->group_by('cm.id');

        return $this->db_result();
    }

    function alunos_ingressantes_nivel($access_level, $vigencia, $status) {
        $niveis = $this->get_niveis();
        $result_final = array();
        foreach ($niveis as $key => $value) {
            $this->db->select("('$key') AS nivel,SUM(cr.numero_ingressantes) as alunos")
                    ->from("caracterizacao cr")
                    ->join("curso c", "cr.id_curso = c.id", "left");
            $this->db_join_and_where_vigencia_filter($vigencia, false);
            $this->db_where_status_filter($status);
            $this->db_where_sr_filter($access_level);
            $this->db->where_in("c.id_modalidade", $value);
            $result = $this->db_result();
            array_push($result_final, $result[0]);
        }
        return $result_final;
    }

    function alunos_ingressantes_nivel_sr($vigencia, $status) {
        $niveis = $this->get_niveis(true);
        $this->db->select("s.id as id, s.nome AS nome, CONCAT(('SR - '),LPAD(s.id,(2),(0)),(' '),(s.nome)) as cod, (0) as total")->from("superintendencia s")->order_by('s.id');
        $result_final = $this->db_result();
        foreach ($niveis as $key => $value) { //itera os 3 níveis de curso
            $this->db->select("s.id as id, SUM(cr.numero_ingressantes) as total")->from("superintendencia s")
                    ->join("curso c", "s.id = c.id_superintendencia", "left")
                    ->join("caracterizacao cr", "cr.id_curso = c.id");
            $this->db_join_and_where_vigencia_filter($vigencia, false);
            $this->db_where_status_filter($status);
            $this->db->where("cr.numero_concluintes >", 0)->where_in('c.id_modalidade', $value)->group_by('s.id');
            $result = $this->db_result();
            $this->array_push_column($result_final, $key, $result, "total", "id");
            foreach ($result_final as $key_row => $row) {
                if (!isset($row[$key])) {
                    $result_final[$key_row][$key] = 0;
                }
                $result_final[$key_row]['total'] += (int) $result_final[$key_row][$key];
            }
        }
        return $result_final;
    }

    function alunos_ingressantes_superintendencia($vigencia, $status) {

        $this->db->select("
			CONCAT(('SR - '),LPAD(s.id,(2),(0))) as id, s.nome AS superintendencia,
			IF (SUM(cr.numero_ingressantes) > 0, SUM(cr.numero_ingressantes), 0) AS alunos_ingressantes
		", false)
                ->from('caracterizacao cr')
                ->join('curso c', 'cr.id_curso = c.id', 'left')
                ->join('superintendencia s', 'c.id_superintendencia = s.id', 'left');
        $this->db_join_and_where_vigencia_filter($vigencia, false);
        $this->db_where_status_filter($status);
        $this->db->where('cr.numero_ingressantes >=', 0);
        $this->db->group_by('s.id');

        return $this->db_result();
    }

    function alunos_concluintes_modalidade($access_level, $vigencia, $status) {

        $this->db->select('
			cm.nome AS modalidade,
			IF (SUM(cr.numero_concluintes) > 0, SUM(cr.numero_concluintes), 0) AS alunos_concluintes
		', false)->from('caracterizacao cr')
                ->join('curso c', 'cr.id_curso = c.id', 'left')
                ->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left');
        $this->db_join_and_where_vigencia_filter($vigencia, false);
        $this->db_where_status_filter($status);
        $this->db->where('cr.numero_concluintes >=', 0);
        $this->db_where_sr_filter($access_level);
        $this->db->group_by('cm.id');

        return $this->db_result();
    }

    function alunos_concluintes_nivel($access_level, $vigencia, $status) {
        $niveis = $this->get_niveis();
        $result_final = array();
        foreach ($niveis as $key => $value) {
            $this->db->select("('$key') as nivel,SUM(cr.numero_concluintes) as alunos")
                    ->from('curso c')
                    ->join('caracterizacao cr', 'cr.id_curso = c.id');
            $this->db_join_and_where_vigencia_filter($vigencia, false);
            $this->db->where_in('c.id_modalidade', $value);
            $this->db_where_status_filter($status);
            $this->db_where_sr_filter($access_level);
            $result = $this->db_result();
            array_push($result_final, $result[0]);
        }
        return $result_final;
    }

    function alunos_concluintes_nivel_sr($vigencia, $status) {
        $niveis = $this->get_niveis(true);
        $this->db->select("s.id as id, s.nome AS nome, CONCAT(('SR - '),LPAD(s.id,(2),(0)),(' '),(s.nome)) as cod, (0) as total")->from("superintendencia s")->order_by('s.id');
        $result_final = $this->db_result();
        foreach ($niveis as $key => $value) { //itera os 3 níveis de curso
            $this->db->select("s.id as id, SUM(cr.numero_concluintes) as total")->from("superintendencia s")
                    ->join("curso c", "s.id = c.id_superintendencia", "left")
                    ->join("caracterizacao cr", "cr.id_curso = c.id");
            $this->db_join_and_where_vigencia_filter($vigencia, false);
            $this->db_where_status_filter($status);
            $this->db->where("cr.numero_concluintes >", 0)->where_in('c.id_modalidade', $value)->group_by('s.id');
            $result = $this->db_result();
            $this->array_push_column($result_final, $key, $result, "total", "id");
            foreach ($result_final as $key_row => $row) {
                if (!isset($row[$key])) {
                    $result_final[$key_row][$key] = 0;
                }
                $result_final[$key_row]['total'] += (int) $result_final[$key_row][$key];
            }
        }
        return $result_final;
    }

    function alunos_cadastrados_curso($access_level, $vigencia, $status) {
        $this->db->select('CONCAT(" ",LPAD(c.id_superintendencia, (2), (0) ),("."), LPAD(c.id, (3), (0) )) AS cod,
                        c.nome as nome,
                        COUNT(e.id) as cadastrados,
                        IF(cr.numero_ingressantes = -1 OR cr.numero_ingressantes = "" OR cr.numero_ingressantes IS NULL,("N/D"),(cr.numero_ingressantes)) as ingressante,
                        IF(cr.numero_concluintes = -1 OR cr.numero_concluintes = "" OR cr.numero_ingressantes IS NULL,("N/D"),(cr.numero_concluintes)) as concluintes
		', false)
                ->from('curso c')->join('caracterizacao cr', 'cr.id_curso = c.id')->join('educando e', 'e.id_curso = c.id', 'left');
        $this->db_join_and_where_vigencia_filter($vigencia, false);
        $this->db_where_status_filter($status);
        $this->db_where_sr_filter($access_level);

        $this->db->group_by('c.id')->order_by('c.id_superintendencia, c.id');
        $rows_result = $this->db_result();
        $total_row = array("cod" => "", "nome" => "TOTAL", "cadastrados" => 0, "ingressante" => 0, "concluintes" => 0);
        foreach ($rows_result as $row) {
            $total_row['cadastrados'] += (int) $row['cadastrados'];
            $total_row['ingressante'] += (int) $row['ingressante'];
            $total_row['concluintes'] += (int) $row['concluintes'];
        }
        $rows_result[] = $total_row;
        return $rows_result;
    }

    function alunos_concluintes_superintendencia($access_level, $vigencia, $status) {

        $this->db->select("
			CONCAT(('SR - '),LPAD(s.id,(2),(0))) as id, s.nome AS superintendencia,
			IF (SUM(cr.numero_concluintes) > 0, SUM(cr.numero_concluintes), 0) AS alunos_concluintes
		", false)
                ->from('caracterizacao cr')
                ->join('curso c', 'cr.id_curso = c.id', 'left')
                ->join('superintendencia s', 'c.id_superintendencia = s.id', 'left');
        $this->db_join_and_where_vigencia_filter($vigencia, false);
        $this->db_where_status_filter($status);
        $this->db->where('cr.numero_concluintes >=', 0);
        $this->db_where_sr_filter($access_level);
        $this->db->group_by('s.id');

        return $this->db_result();
    }

    function educandos_assentamento_modalidade($access_level, $vigencia, $status) {
        $this->db->select("ed.nome_territorio AS a, c.id_modalidade as i, COUNT(ed.nome_territorio) as t")
                ->from("educando ed")
                ->join("curso c", "c.id = ed.id_curso");
        $this->db_join_and_where_vigencia_filter($vigencia, true);
        $this->db_where_status_filter($status);
        $this->db_where_sr_filter($access_level);
        $this->db->group_by("ed.nome_territorio, c.id_modalidade")->order_by("ed.nome_territorio, c.id_modalidade");
        $array = $this->db_result();
        $hash_modalidade = $this->get_modalidades(true);
        $array_count = array_values($hash_modalidade);
        $result = array();
        $atual_assent = $this->array_push_keys(array('assent' => $array[0]['a']), $array_count, 0);
        foreach ($array as $reg) {
            if ($atual_assent['assent'] != $reg['a']) {
                $result[] = $atual_assent;
                $atual_assent = $this->array_push_keys(array('assent' => $reg['a']), $array_count, 0);
            }
            $atual_assent[$hash_modalidade[$reg['i']]] = (int) $reg['t'];
        }
        return $result;
    }

    function educandos_assentamento_nivel($access_level, $vigencia, $status) {
        $niveis = $this->get_niveis(true);
        $this->db->select("ed.nome_territorio AS assent, ('-') as eja_fundamental, ('-') as ensino_medio, ('-') as ensino_superior")
                ->from("educando ed")->join("curso c", "c.id = ed.id_curso");
        $this->db_join_and_where_vigencia_filter($vigencia, true);
        $this->db_where_status_filter($status);
        $this->db_where_sr_filter($access_level);
        $this->db->distinct();
        $result_final = $this->db_result();

        foreach ($niveis as $key => $value) { //itera os 3 níveis de curso
            $this->db->select("('$key') as nivel, ed.nome_territorio AS assent, COUNT(ed.nome_territorio) as total")
                    ->from("educando ed")->join("curso c", "c.id = ed.id_curso")->where_in('c.id_modalidade', $value);
            $this->db_join_and_where_vigencia_filter($vigencia, true);
            $this->db_where_status_filter($status);
            $this->db_where_sr_filter($access_level);
            $this->db->group_by("ed.nome_territorio")->order_by("ed.nome_territorio");
            $result = $this->db_result();
            $this->array_push_column($result_final, $key, $result, "total", "assent");
        }
        return $result_final;
    }

    function lista_educandos_cursos_sr($id, $vigencia, $status) {
        $sr = (int) $id;
        $this->db->select('
                    e.nome,
                    e.tipo_territorio,
                    e.nome_territorio,
                    CONCAT(" ",LPAD(c.id_superintendencia, (2), (0) ),("."), LPAD(c.id, (3), (0) )) AS cod_curso,
                    c.nome AS nome_curso,
                    cm.nome AS modalidade
		', false);

        $this->db->from('educando e')
                ->join('curso c', 'e.id_curso = c.id')
                ->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left');
        $this->db_join_and_where_vigencia_filter($vigencia, true);
        $this->db->where('c.id_superintendencia', $sr);
        $this->db_where_status_filter($status);

        return $this->db_result();
    }

    function municipios_curso_modalidade($access_level, $vigencia, $status) {
        $this->db->select('cm.nome AS modalidade,
			e.sigla AS estado,
			cd.cod_municipio,
			cd.nome AS cidade,
			CONCAT(" ",LPAD(c.id_superintendencia, (2), (0) ),("."), LPAD(c.id, (3), (0) )) AS id_curso,
			c.nome AS curso');
        $this->db->from('curso c')
                ->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left')
                ->join('caracterizacao cr', 'c.id = cr.id_curso', 'left')
                ->join('caracterizacao_cidade cc', 'cr.id = cc.id_caracterizacao', 'left')
                ->join('cidade cd', 'cc.id_cidade = cd.id', 'left')
                ->join('estado e', 'cd.id_estado = e.id', 'left');
        $this->db_join_and_where_vigencia_filter($vigencia, false);
        $this->db_where_status_filter($status);
        $this->db_where_sr_filter($access_level);
        $this->db->group_by('c.nome, cm.nome, e.sigla, cd.cod_municipio, cd.nome, c.id');

        return $this->db_result();
    }

    function municipios_curso($access_level, $vigencia, $status) {
        $this->db->select('e.sigla AS estado, cd.cod_municipio, cd.nome AS cidade, COUNT(c.id) AS cursos');
        $this->db->from('caracterizacao_cidade cc')
                ->join('caracterizacao cr', 'cc.id_caracterizacao = cr.id', 'left')
                ->join('curso c', 'cr.id_curso = c.id', 'left')
                ->join('cidade cd', 'cc.id_cidade = cd.id', 'left')
                ->join('estado e', 'cd.id_estado = e.id', 'left');
        $this->db_join_and_where_vigencia_filter($vigencia, false);
        $this->db_where_status_filter($status);
        $this->db->where('cd.cod_municipio IS NOT ', 'NULL', false);
        $this->db_where_sr_filter($access_level);
        $this->db->group_by('cd.cod_municipio, cd.nome, e.sigla')->order_by('e.sigla, cd.nome');

        return $this->db_result();
    }

    function lista_cursos_modalidade($access_level, $vigencia, $status) {
        $this->db->select('cm.nome AS modalidade, CONCAT(" ",LPAD(c.id_superintendencia, (2), (0) ),("."), LPAD(c.id, (3), (0) )) AS id_curso, c.nome AS curso')
                ->from('curso c')
                ->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left')
                ->join('superintendencia s', 'c.id_superintendencia = s.id', 'left');
        $this->db_join_and_where_vigencia_filter($vigencia, true);
        $this->db_where_status_filter($status);
        $this->db_where_sr_filter($access_level);

        $this->db->order_by('cm.nome, s.id, c.id');

        return $this->db_result();
    }

    function lista_cursos_modalidade_sr($access_level, $vigencia, $status) {

        $this->db->select('CONCAT(("SR - "),LPAD(s.id,(2),(0))) AS id_superintendencia, s.nome AS superintendencia, cm.nome AS modalidade, CONCAT(" ",LPAD(c.id_superintendencia, (2), (0) ),("."), LPAD(c.id, (3), (0) )) AS id_curso, c.nome AS curso')
                ->from('curso c')
                ->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left')
                ->join('superintendencia s', 'c.id_superintendencia = s.id', 'left');
        $this->db_join_and_where_vigencia_filter($vigencia, true);
        $this->db_where_status_filter($status);
        $this->db_where_sr_filter($access_level);
        $this->db->order_by('s.id, cm.nome, c.id');

        return $this->db_result();
    }

    function alunos_curso($idSr, $vigencia, $status) {
        $sr = (int) $idSr;
        $this->db->select('CONCAT(" ",LPAD(c.id_superintendencia, (2), (0) ),("."), LPAD(c.id, (3), (0) )) as id_curso, c.nome as curso, e.nome as educando')
                ->from('educando e')
                ->join('curso c', 'e.id_curso = c.id', 'left');
        $this->db_join_and_where_vigencia_filter($vigencia, true);
        $this->db_where_status_filter($status);
        $this->db->where('c.id_superintendencia', $sr)->order_by('c.id');

        return $this->db_result();
    }

    function titulacao_educadores($access_level, $vigencia, $status) {
        $titulacoes = $this->get_titulacao_professor();
        $result_final = array();
        $sum = 0;
        foreach ($titulacoes as $key => $value) {
            $this->db->select("('$key') as titulacao, COUNT(p.id) as educadores")
                    ->from("professor p")
                    ->join("curso c", "p.id_curso = c.id");
            $this->db_join_and_where_vigencia_filter($vigencia, true);
            $this->db_where_status_filter($status);
            $this->db_where_sr_filter($access_level);
            $this->db->where_in("p.titulacao", $value);
            $result = $this->db_result();
            $sum += (int) $result[0]['educadores'];
            array_push($result_final, $result[0]);
        }
        return $this->percent_column($result_final, "educadores", $sum);
    }

    function titulacao_educadores_superintendencia($vigencia, $status) {
        $titulacoes = $this->get_titulacao_professor(true);

        $this->db->select("s.id as id_sr, CONCAT(('SR - '),LPAD(s.id,(2),(0)),(' '),(s.nome)) as id")->from("superintendencia s");
        $result_final = $this->db_result();

        foreach ($titulacoes as $key => $value) {
            $this->db->select("s.id as id_sr, COUNT(p.id) as educadores")
                    ->from("superintendencia s")
                    ->join("curso c", "s.id = c.id_superintendencia")
                    ->join("professor p", "p.id_curso = c.id");
            $this->db_join_and_where_vigencia_filter($vigencia, true);
            $this->db_where_status_filter($status);
            $this->db->where_in("p.titulacao", $value)->group_by("s.id");
            $result = $this->db_result();
            $this->array_push_column($result_final, $key, $result, "educadores", "id_sr");
        }
        return $this->percent_rows($result_final, $titulacoes);
    }

    function educadores_nivel($access_level, $vigencia, $status) {
        $niveis = $this->get_niveis();
        $result_final = array();
        $sum = 0;
        foreach ($niveis as $key => $value) {
            $this->db->select("('$key') as nivel, COUNT(p.id) as educadores")
                    ->from("professor p")
                    ->join("curso c", "p.id_curso = c.id");
            $this->db_join_and_where_vigencia_filter($vigencia, true);
            $this->db->where_in('c.id_modalidade', $value);
            $this->db_where_status_filter($status);
            $this->db_where_sr_filter($access_level);
            $result = $this->db_result();
            $sum += $result[0]['educadores'];
            array_push($result_final, $result[0]);
        }
        foreach ($result_final as $key => $value) {
            $result_final[$key]['educadores'] = ($value['educadores'] / $sum) * 100;
        }
        return $result_final;
    }

    function educadores_curso($access_level, $vigencia, $status) {

        $this->db->select('CONCAT(" ",LPAD(c.id_superintendencia, (2), (0) ),("."), LPAD(c.id, (3), (0) )) AS id_curso, c.nome AS curso, COUNT(p.id) AS educadores')
                ->from('professor p')
                ->join('curso c', 'p.id_curso = c.id', 'left')
                ->join('superintendencia s', 'c.id_superintendencia = s.id', 'left');
        $this->db_join_and_where_vigencia_filter($vigencia, true);
        $this->db_where_status_filter($status);
        $this->db_where_sr_filter($access_level);
        $this->db->group_by('c.id')
                ->order_by('c.id, c.nome');

        return $this->db_result();
    }

    function educadores_superintendencia($vigencia, $status) {

        $this->db->select('CONCAT(("SR - "),LPAD(s.id,(2),(0))) AS id, s.nome AS superintendencia, COUNT(p.id) AS educadores')
                ->from('professor p')
                ->join('curso c', 'p.id_curso = c.id', 'left')
                ->join('superintendencia s', 'c.id_superintendencia = s.id', 'left');
        $this->db_join_and_where_vigencia_filter($vigencia, true);
        $this->db_where_status_filter($status);
        $this->db->group_by('s.id');

        return $this->db_result();
    }

    function genero_educadores_modalidade($access_level, $vigencia, $status) {
        $generos = array('masculino' => 'M', 'feminino' => 'F');
        $this->db->select("cm.id as id,cm.nome as modalidade")->from("curso_modalidade cm");
        $result_final = $this->db_result();
        foreach ($generos as $key => $value) {
            $this->db->select("c.id_modalidade as id, COUNT(p.id) as educadores")
                    ->from("professor p")
                    ->join("curso c", "p.id_curso = c.id");
            $this->db_join_and_where_vigencia_filter($vigencia, true);
            $this->db_where_status_filter($status);
            $this->db_where_sr_filter($access_level);
            $this->db->where("p.genero", $value)->group_by('c.id_modalidade');
            $result = $this->db_result();
            $this->array_push_column($result_final, $key, $result, "educadores", "id");
        }
        return $this->percent_rows($result_final, $generos);
    }

    function educandos_superintendencia($vigencia, $status) {

        $this->db->select('CONCAT(("SR - "),LPAD(s.id,(2),(0))) as id, s.nome, COUNT(e.id) AS educandos')
                ->from('educando e')
                ->join('curso c', 'e.id_curso = c.id', 'left')
                ->join('superintendencia s', 'c.id_superintendencia = s.id', 'left');
        $this->db_join_and_where_vigencia_filter($vigencia, true);
        $this->db_where_status_filter($status);
        $this->db->group_by('s.id');

        return $this->db_result();
    }

    function municipio_origem_educandos($access_level, $vigencia, $status) {

        $this->db->select('e.sigla AS estado,
			cd.nome AS municipio,
			cd.cod_municipio AS cod_municipio,
			IF (COUNT(e.id) > 0, COUNT(e.id), 0) AS educandos
		', false);

        $this->db->from('educando_cidade ec')
                ->join('cidade cd', 'ec.id_cidade = cd.id', 'left')
                ->join('estado e', 'cd.id_estado = e.id', 'left')
                ->join('educando ed', 'ec.id_educando = ed.id', 'left')
                ->join('curso c', 'ed.id_curso = c.id', 'left');
        $this->db_join_and_where_vigencia_filter($vigencia, true);
        $this->db_where_status_filter($status);
        $this->db_where_sr_filter($access_level);

        $this->db->group_by('cd.cod_municipio, e.sigla, cd.nome, cd.id')->order_by('e.sigla');

        return $this->db_result();
    }

    function territorio_educandos_superintendencia($vigencia, $status) {
        $territorios = $this->get_tipo_territorio();
        $keys_territorios = array_keys($territorios);

        $this->db->select("s.id as id_sr, CONCAT(('SR - '),LPAD(s.id,(2),(0))) as id, s.nome as nome")->from("superintendencia s");
        $result_final = $this->matrix_push_keys($this->db_result(), $keys_territorios, "-");

        foreach ($territorios as $key => $value) {
            $this->db->select("IF(COUNT(e.id)<>0,COUNT(e.id),('-')) AS educandos, c.id_superintendencia id_sr")
                    ->from("educando e")
                    ->join("curso c", "e.id_curso = c.id");
            $this->db_join_and_where_vigencia_filter($vigencia, true);
            $this->db_where_status_filter($status);
            $this->db->where("e.tipo_territorio", $value)->group_by("c.id_superintendencia");
            $result = $this->db_result();
            $this->array_push_column($result_final, $key, $result, "educandos", "id_sr");
        }

        return $result_final;
    }

    function idade_educandos_modalidade($access_level, $vigencia, $status) {

        $this->db->select('cm.nome AS modalidade,IF (AVG(e.idade) IS NOT NULL, AVG(e.idade), 0) AS idade', false)
                ->from('educando e')
                ->join('curso c', 'e.id_curso = c.id', 'left')
                ->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left')
                ->join('caracterizacao cr', 'c.id = cr.id_curso', 'left')
                ->where('e.idade >', 0)
                ->where('e.data_nascimento <>', '0000-00-00')
                ->where('e.data_nascimento <>', '1900-01-01')
                ->where('cr.inicio_realizado <>', 'NI');

        $this->db_where_status_filter($status);
        $this->db_join_and_where_vigencia_filter($vigencia, false);
        $this->db_where_sr_filter($access_level);
        $this->db->group_by('cm.id');

        return $this->db_result();
    }

    function genero_educandos_modalidade($access_level, $vigencia, $status) {
        $generos = array('masculino' => 'M', 'feminino' => 'F');
        $this->db->select("cm.id as id, cm.nome as modalidade")->from("curso_modalidade cm");
        $result_final = $this->db_result();
        foreach ($generos as $key => $value) {
            $this->db->select("c.id_modalidade as id, COUNT(e.id) as educandos")
                    ->from("educando e")
                    ->join("curso c", "e.id_curso = c.id");
            $this->db_join_and_where_vigencia_filter($vigencia, true);
            $this->db_where_status_filter($status);
            $this->db_where_sr_filter($access_level);
            $this->db->where("e.genero", $value)->group_by('c.id_modalidade');
            $result = $this->db_result();
            $this->array_push_column($result_final, $key, $result, "educandos", "id");
        }
        return $this->percent_rows($result_final, $generos);
    }

    function localizacao_instituicoes_ensino($access_level, $vigencia, $status) {

        $this->db->select('IF(e.sigla IS NULL,("N/A"),(e.sigla)) AS estado, IF(cd.nome IS NULL,("N/A"),(cd.nome)) AS municipio, IF(cd.cod_municipio IS NULL,("N/A"),(cd.cod_municipio)) as cod_municipio, i.nome AS instituicao')
                ->from('instituicao_ensino i')
                ->join('cidade cd', 'i.id_cidade = cd.id', 'left')
                ->join('estado e', 'cd.id_estado = e.id', 'left')
                ->join('curso c', 'i.id_curso = c.id', 'left');
        $this->db_join_and_where_vigencia_filter($vigencia, true);
        $this->db_where_status_filter($status);
        $this->db_where_sr_filter($access_level);
        $this->db->distinct()->order_by('e.sigla, cd.nome, i.nome');

        return $this->db_result();
    }

    function instituicoes_ensino_modalidade($access_level, $vigencia, $status) {

        $this->db->select('cm.nome AS modalidade, COUNT(DISTINCT ie.nome) AS instituicoes')
                ->from('instituicao_ensino ie')
                ->join('curso c', 'ie.id_curso = c.id', 'left')
                ->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left');
        $this->db_join_and_where_vigencia_filter($vigencia, true);
        $this->db_where_status_filter($status);
        $this->db_where_sr_filter($access_level);
        $this->db->group_by('cm.id');

        return $this->db_result();
    }

    function instituicoes_ensino_municipio($access_level, $vigencia, $status) {

        $this->db->select('IF(e.sigla IS NULL,("N/A"),(e.sigla)) AS estado,'
                        . ' IF(cd.cod_municipio IS NULL,("N/A"),(cd.cod_municipio)) as cod_municipio,'
                        . ' IF(cd.nome IS NULL,("N/A"),(cd.nome)) AS municipio,'
                        . ' COUNT(DISTINCT ie.nome) AS instituicoes')
                ->from('instituicao_ensino ie')
                ->join('curso c', 'ie.id_curso = c.id', 'left')
                ->join('cidade cd', 'ie.id_cidade = cd.id', 'left')
                ->join('estado e', 'cd.id_estado = e.id', 'left');
        $this->db_join_and_where_vigencia_filter($vigencia, true);
        $this->db_where_status_filter($status);
        $this->db_where_sr_filter($access_level);
        $this->db->group_by('cd.id')->order_by('e.sigla, cd.nome');

        return $this->db_result();
    }

    function instituicoes_ensino_estado($vigencia, $status) {

        $this->db->select('IF(e.sigla IS NULL,("N/A"),(CONCAT((e.nome),(" ("),(e.sigla),(")")))) AS estado, COUNT(DISTINCT ie.nome) AS instituicoes')
                ->from('instituicao_ensino ie')
                ->join('curso c', 'ie.id_curso = c.id', 'left')
                ->join('cidade cd', 'ie.id_cidade = cd.id', 'left')
                ->join('estado e', 'cd.id_estado = e.id', 'left');
        $this->db_join_and_where_vigencia_filter($vigencia, true);
        $this->db_where_status_filter($status);
        $this->db->group_by('e.sigla');

        return $this->db_result();
    }

    function instituicoes_ensino_nivel($access_level, $vigencia, $status) {
        $niveis = $this->get_niveis();
        $result_final = array();
        foreach ($niveis as $key => $value) {
            $this->db->select("('$key') as nivel, COUNT(DISTINCT ie.nome) as instituicoes")
                    ->from("instituicao_ensino ie")
                    ->join("curso c", "ie.id_curso = c.id");
            $this->db_join_and_where_vigencia_filter($vigencia, true);
            $this->db->where_in('c.id_modalidade', $value);
            $this->db_where_status_filter($status);
            $this->db_where_sr_filter($access_level);
            $result = $this->db_result();
            array_push($result_final, $result[0]);
        }

        return $result_final;
    }

    function instituicoes_ensino_superintendencia($vigencia, $status) {

        $this->db->select('CONCAT(("SR - "),LPAD(s.id,(2),(0))) as id, s.nome AS superintendencia, COUNT(DISTINCT ie.nome) AS instituicoes')
                ->from('instituicao_ensino ie')
                ->join('curso c', 'ie.id_curso = c.id', 'left')
                ->join('superintendencia s', 'c.id_superintendencia = s.id', 'left');
        $this->db_join_and_where_vigencia_filter($vigencia, true);
        $this->db_where_status_filter($status);
        $this->db->group_by('s.id');

        return $this->db_result();
    }

    function cursos_natureza_inst_ensino($access_level, $vigencia, $status) {
        $this->db->select("ie.natureza_instituicao AS natureza, COUNT(DISTINCT ie.nome) as instituicoes")
                ->from("instituicao_ensino ie")
                ->join("curso c", "ie.id_curso = c.id");
        $this->db_join_and_where_vigencia_filter($vigencia, true);
        $this->db_where_status_filter($status);
        $this->db_where_sr_filter($access_level);
        $this->db->where("ie.nome <>", "")->group_by("ie.natureza_instituicao");
        return $this->db_result();
    }

    function instituicao_ensino_cursos($access_level, $vigencia, $status) {

        $this->db->select('IF(ie.nome IS NULL,("N/A"),(ie.nome)) AS instituicao, COUNT(ie.id) AS cursos')
                ->from('instituicao_ensino ie')
                ->join('curso c', 'ie.id_curso = c.id', 'left');
        $this->db_join_and_where_vigencia_filter($vigencia, true);
        $this->db_where_status_filter($status);
        $this->db_where_sr_filter($access_level);
        $this->db->group_by('ie.nome');

        return $this->db_result();
    }

    function organizacoes_demandantes_modalidade($access_level, $vigencia, $status) {

        $this->db->select('cm.nome AS modalidade,IF (COUNT(DISTINCT od.nome) > 0, COUNT(DISTINCT od.nome), 0) AS organizacoes', false)
                ->from('organizacao_demandante od')
                ->join('curso c', 'od.id_curso = c.id', 'left')
                ->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left');
        $this->db_join_and_where_vigencia_filter($vigencia, true);
        $this->db_where_status_filter($status);
        $this->db_where_sr_filter($access_level);
        $this->db->group_by('cm.nome');

        return $this->db_result();
    }

    function membros_org_demandantes_modalidade($access_level, $vigencia, $status) {
        $estudo = array('sim' => 'S', 'nao' => 'N', 'ni' => 'i');
        $this->db->select("cm.id as id, cm.nome AS modalidade")->from("curso_modalidade cm");
        $result_final = $this->db_result();

        foreach ($estudo as $key => $value) {
            $this->db->select("cmd.id as id, COUNT(odc.id) as total")
                    ->from("organizacao_demandante_coordenador odc")
                    ->join("organizacao_demandante od", "odc.id_organizacao_demandante = od.id", 'left outer')
                    ->join("curso c", "od.id_curso = c.id", 'left outer')
                    ->join("curso_modalidade cmd", "c.id_modalidade = cmd.id", 'left outer');
            $this->db_join_and_where_vigencia_filter($vigencia, true);
            $this->db_where_status_filter($status);
            $this->db_where_sr_filter($access_level);
            $this->db->where("odc.estuda_pronera", $value);
            $this->db->group_by("cmd.id");
            $result = $this->db_result();
            $this->array_push_column($result_final, $key, $result, "total", "id");
        }
        
        return $this->percent_rows($result_final, $estudo);
    }

    function organizacao_demandante_cursos($access_level, $vigencia, $status) {

        $this->db->select('od.nome AS organizacao, COUNT(od.id) AS cursos')
                ->from('organizacao_demandante od')
                ->join('curso c', 'od.id_curso = c.id', 'left');
        $this->db_join_and_where_vigencia_filter($vigencia, true);
        $this->db_where_status_filter($status);
        $this->db_where_sr_filter($access_level);
        $this->db->group_by('od.nome');

        return $this->db_result();
    }

    function localizacao_parceiros($access_level, $vigencia, $status) {

        $this->db->select('e.sigla AS estado, cd.cod_municipio, cd.nome AS municipio, p.nome AS parceiro')
                ->from('parceiro p')
                ->join('curso c', 'p.id_curso = c.id', 'left')
                ->join('cidade cd', 'p.id_cidade = cd.id', 'left')
                ->join('estado e', 'cd.id_estado = e.id', 'left');
        $this->db_join_and_where_vigencia_filter($vigencia, true);
        $this->db_where_status_filter($status);
        $this->db->where('p.id_cidade <>', 0);
        $this->db_where_sr_filter($access_level);

        $this->db->group_by('e.sigla, cd.nome, p.nome, cd.cod_municipio');

        return $this->db_result();
    }

    function parceiros_modalidade($access_level, $vigencia, $status) {

        $this->db->select('cm.nome AS modalidade,IF (COUNT(p.id) > 0, COUNT(p.id), 0) AS parceiros', false)
                ->from('parceiro p')
                ->join('curso c', 'p.id_curso = c.id', 'left')
                ->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left');
        $this->db_join_and_where_vigencia_filter($vigencia, true);
        $this->db_where_status_filter($status);
        $this->db_where_sr_filter($access_level);
        $this->db->group_by('cm.nome');

        return $this->db_result();
    }

    function parceiros_superintendencia($vigencia, $status) {

        $this->db->select('CONCAT(("SR - "),LPAD(s.id, (2), (0) )) as id, s.nome AS superintendencia, COUNT(p.id) AS parceiros')
                ->from('parceiro p')
                ->join('curso c', 'p.id_curso = c.id', 'left')
                ->join('superintendencia s', 'c.id_superintendencia = s.id', 'left');
        $this->db_join_and_where_vigencia_filter($vigencia, true);
        $this->db_where_status_filter($status);
        $this->db->group_by('s.id');

        return $this->db_result();
    }

    function parceiros_natureza($access_level, $vigencia, $status) {

        $this->db->select('p.natureza, COUNT(p.id) AS parceiros')
                ->from('parceiro p')
                ->join('curso c', 'p.id_curso = c.id', 'left');
        $this->db_join_and_where_vigencia_filter($vigencia, true);
        $this->db->where('p.natureza IS NOT NULL', null, false)
                ->where('p.natureza <>', '');
        $this->db_where_status_filter($status);
        $this->db_where_sr_filter($access_level);
        $this->db->group_by('p.natureza');

        return $this->db_result();
    }

    function lista_parceiros($access_level, $vigencia, $status) {

        $this->db->select('p.nome AS parceiro, p.sigla AS sigla, p.abrangencia AS abrangencia')
                ->from('parceiro p')
                ->join('curso c', 'p.id_curso = c.id', 'left');
        $this->db_join_and_where_vigencia_filter($vigencia, true);
        $this->db_where_status_filter($status);
        $this->db_where_sr_filter($access_level);
        $this->db->group_by('p.nome');

        return $this->db_result();
    }

    function producoes_estado($vigencia, $status) {

        $title_status = $this->array_to_sql($status);

        $tabelas = array(
            'pg' => 'producao_geral',
            'pt' => 'producao_trabalho',
            'pa' => 'producao_artigo',
            'pm' => 'producao_memoria',
            'pl' => 'producao_livro'
        );

        $select = "SELECT e.sigla, ";
        $join_vigencia = "";
        $where_vigencia = "";
        if ($vigencia != "BOTH") {
            $join_vigencia = " INNER JOIN caracterizacao cr ON cr.id_curso = c.id";
            $atual = (((int) date("Y")) - 1950) * 12 + ((int) date("m"));
            if ($vigencia == "AN") {
                $where_vigencia = ("AND ($atual BETWEEN date_to_number(cr.`inicio_realizado`,('01/1950')) AND date_to_number(cr.`termino_realizado`,('01/2050')))");
            } else if ($vigencia == "CC") {
                $where_vigencia = ("AND ($atual NOT BETWEEN date_to_number(cr.`inicio_realizado`,('01/1950')) AND date_to_number(cr.`termino_realizado`,('01/2050')))");
            }
        }


        $stms = array();
        foreach ($tabelas as $key => $value) {

            $stm = "(SELECT IF(COUNT(p.id) <> 0,COUNT(p.id),('-')) as count FROM $value p
					LEFT OUTER JOIN curso c ON (p.id_curso = c.id)
					LEFT OUTER JOIN superintendencia s ON (c.id_superintendencia = s.id)
			        LEFT OUTER JOIN estado et ON (s.id_estado = et.id)
                                $join_vigencia
			        WHERE c.ativo_inativo = 'A'
			        AND c.status IN $title_status
                                $where_vigencia
			        AND et.id = e.id) AS $key";

            array_push($stms, $stm);
        }

        $clause = "FROM estado e
			 GROUP BY e.id
			 ORDER BY e.sigla";

        $sql = implode(" ", array($select, implode(",", $stms), $clause));

        return $this->db_result();
    }

    function producoes_superintendencia($vigencia, $status) {

        $title_status = $this->array_to_sql($status);

        $tabelas = array(
            'pg' => 'producao_geral',
            'pt' => 'producao_trabalho',
            'pa' => 'producao_artigo',
            'pm' => 'producao_memoria',
            'pl' => 'producao_livro'
        );
        $join_vigencia = "";
        $where_vigencia = "";
        if ($vigencia != "BOTH") {
            $join_vigencia = " INNER JOIN caracterizacao cr ON cr.id_curso = c.id";
            $atual = (((int) date("Y")) - 1950) * 12 + ((int) date("m"));
            if ($vigencia == "AN") {
                $where_vigencia = ("AND ($atual BETWEEN date_to_number(cr.`inicio_realizado`,('01/1950')) AND date_to_number(cr.`termino_realizado`,('01/2050')))");
            } else if ($vigencia == "CC") {
                $where_vigencia = ("AND ($atual NOT BETWEEN date_to_number(cr.`inicio_realizado`,('01/1950')) AND date_to_number(cr.`termino_realizado`,('01/2050')))");
            }
        }
        $select = "SELECT s.id, s.nome, ";

        $stms = array();
        foreach ($tabelas as $key => $value) {

            $stm = "(SELECT IF(COUNT(p.id) <> 0,COUNT(p.id),('-')) FROM $value p
					LEFT OUTER JOIN curso c ON (p.id_curso = c.id)
					LEFT OUTER JOIN superintendencia si ON (c.id_superintendencia = si.id)
                                        $join_vigencia
					WHERE c.ativo_inativo = 'A'
                                        $where_vigencia
					AND c.status IN $title_status
					AND si.id = s.id) AS $key";

            array_push($stms, $stm);
        }

        $clause = "FROM superintendencia s
			 GROUP BY s.id";

        $sql = implode(" ", array($select, implode(",", $stms), $clause));

        return $this->db_result();
    }

    function producoes_tipo($access_level, $vigencia, $status) {

        $title_status = $this->array_to_sql($status);

        $producoes = array(
            'VIDEO' => array(
                'cast' => 'VÍDEO',
                'tabela' => 'producao_geral'
            ),
            'CARTILHA / APOSTILA' => array(
                'cast' => 'CARTILHA/APOSTILA',
                'tabela' => 'producao_geral'
            ),
            'TEXTO' => array(
                'cast' => 'TEXTO',
                'tabela' => 'producao_geral'
            ),
            'MUSICA' => array(
                'cast' => 'MÚSICA',
                'tabela' => 'producao_geral'
            ),
            'CADERNO' => array(
                'cast' => 'CADERNO',
                'tabela' => 'producao_geral'
            ),
            'MONOGRAFIA / TCC' => array(
                'cast' => 'MONOGRAFIA/TCC',
                'tabela' => 'producao_trabalho'
            ),
            'RELATORIO DE ESTAGIO' => array(
                'cast' => 'RELATÓRIO DE ESTÁGIO',
                'tabela' => 'producao_trabalho'
            ),
            'DISSERTACAO' => array(
                'cast' => 'DISSERTAÇÃO',
                'tabela' => 'producao_trabalho'
            ),
            'TESE' => array(
                'cast' => 'TESE',
                'tabela' => 'producao_trabalho'
            ),
            'ARTIGO' => array(
                'cast' => 'ARTIGO',
                'tabela' => 'producao_artigo'
            ),
            'MEMORIA' => array(
                'cast' => 'MEMÓRIA',
                'tabela' => 'producao_memoria'
            ),
            'LIVRO' => array(
                'cast' => 'LIVRO',
                'tabela' => 'producao_livro'
            ),
            'OUTROS' => array(
                'cast' => 'OUTROS',
                'tabela' => 'producao_geral'
            )
        );
        $join_vigencia = "";
        $where_vigencia = "";
        if ($vigencia != "BOTH") {
            $join_vigencia = " INNER JOIN caracterizacao cr ON cr.id_curso = c.id";
            $atual = (((int) date("Y")) - 1950) * 12 + ((int) date("m"));
            if ($vigencia == "AN") {
                $where_vigencia = ("AND ($atual BETWEEN date_to_number(cr.`inicio_realizado`,('01/1950')) AND date_to_number(cr.`termino_realizado`,('01/2050')))");
            } else if ($vigencia == "CC") {
                $where_vigencia = ("AND ($atual NOT BETWEEN date_to_number(cr.`inicio_realizado`,('01/1950')) AND date_to_number(cr.`termino_realizado`,('01/2050')))");
            }
        }
        $complement = ($access_level <= 3) ? "AND c.id_superintendencia = " . $this->session->userdata('id_superintendencia') . " " : " ";

        $stms = array();
        foreach ($producoes as $key => $value) {

            $stm = "SELECT CAST('" . $value['cast'] . "' AS CHAR(30)) AS natureza_producao,
					COUNT(p.id) AS producoes FROM " . $value['tabela'] . " p
        			LEFT OUTER JOIN curso c ON (p.id_curso = c.id)
                                $join_vigencia
       				WHERE c.ativo_inativo = 'A' 
                                $where_vigencia
                                AND c.status IN $title_status $complement";

            if (strpos($value['tabela'], 'geral') !== false) {
                $stm .= "AND p.natureza_producao = '" . $key . "'";
            } else if (strpos($value['tabela'], 'trabalho') !== false) {
                $stm .= "AND p.tipo = '" . $key . "'";
            }
            array_push($stms, $stm);
        }

        $sql = implode(" UNION ALL ", $stms);

        $sql .= "AND p.natureza_producao NOT IN('VIDEO','CARTILHA / APOSTILA','TEXTO','MUSICA','CADERNO')";

        return $this->db_result();
    }

    function pesquisa_estado() {

        $tabelas = array(
            'pac' => 'pesquisa_academico',
            'plc' => 'pesquisa_livro_coletanea',
            'pcl' => 'pesquisa_capitulo_livro',
            'par' => 'pesquisa_artigo',
            'pvi' => 'pesquisa_video',
            'ppe' => 'pesquisa_periodico',
            'pev' => 'pesquisa_evento'
        );

        $select = 'SELECT e.sigla, ';

        $stms = array();
        foreach ($tabelas as $key => $value) {

            $stm = "(SELECT IF(COUNT(pd.id)<>0,COUNT(pd.id),('-')) FROM $value pd
                    LEFT OUTER JOIN pessoa p ON (p.id = pd.id_pessoa)
                    LEFT OUTER JOIN superintendencia s ON (p.id_superintendencia = s.id)
                    LEFT OUTER JOIN estado et ON (s.id_estado = et.id)
                    WHERE s.id <> 31
                    AND et.id = e.id) AS $key";

            array_push($stms, $stm);
        }

        $clause = "FROM estado e
			 GROUP BY e.id
			 ORDER BY e.sigla";

        $sql = implode(" ", array($select, implode(",", $stms), $clause));

        return $this->db_result();
    }

    function pesquisa_superintendencia() {

        $tabelas = array(
            'pac' => 'pesquisa_academico',
            'plc' => 'pesquisa_livro_coletanea',
            'pcl' => 'pesquisa_capitulo_livro',
            'par' => 'pesquisa_artigo',
            'pvi' => 'pesquisa_video',
            'ppe' => 'pesquisa_periodico',
            'pev' => 'pesquisa_evento'
        );

        $select = $select = 'SELECT CONCAT(("SR - "),LPAD(s.id,(2),(0))) as id, s.nome, ';

        $stms = array();
        foreach ($tabelas as $key => $value) {

            $stm = "(SELECT IF(COUNT(pd.id)<>0,COUNT(pd.id),('-')) FROM $value pd
                    LEFT OUTER JOIN pessoa p ON (p.id = pd.id_pessoa)
                    LEFT OUTER JOIN superintendencia si ON (p.id_superintendencia = si.id)
                    WHERE s.id <> 31
                    AND si.id = s.id) AS $key";

            array_push($stms, $stm);
        }

        $clause = "FROM superintendencia s
			 GROUP BY s.id";

        $sql = implode(" ", array($select, implode(",", $stms), $clause));

        return $this->db_result();
    }

    function pesquisa_tipo($access_level) {

        $producoes = array(
            'DISSERTACAO' => array(
                'cast' => 'DISSERTAÇÃO',
                'tabela' => 'pesquisa_academico'
            ),
            'TESE' => array(
                'cast' => 'TESE',
                'tabela' => 'pesquisa_academico'
            ),
            'MONOGRAFIA / TCC' => array(
                'cast' => 'MONOGRAFIA/TCC',
                'tabela' => 'pesquisa_academico'
            ),
            'LIVRO' => array(
                'cast' => 'LIVRO',
                'tabela' => 'pesquisa_livro_coletanea'
            ),
            'COLETANEA' => array(
                'cast' => 'COLETÂNEA',
                'tabela' => 'pesquisa_livro_coletanea'
            ),
            'CAPITULO DE LIVRO' => array(
                'cast' => 'CAPÍTULO DE LIVRO',
                'tabela' => 'pesquisa_capitulo_livro'
            ),
            'ARTIGO' => array(
                'cast' => 'ARTIGO',
                'tabela' => 'pesquisa_artigo'
            ),
            'VIDEO / DOCUMENTARIO' => array(
                'cast' => 'VÍDEO/DOCUMENTÁRIO',
                'tabela' => 'pesquisa_video'
            ),
            'PERIODICO' => array(
                'cast' => 'PERIÓDICO',
                'tabela' => 'pesquisa_periodico'
            ),
            'EVENTO' => array(
                'cast' => 'EVENTO',
                'tabela' => 'pesquisa_evento'
            )
        );

        $complement = ($access_level <= 3) ? "AND p.id_superintendencia = " . $this->session->userdata('id_superintendencia') : "";

        $stms = array();
        foreach ($producoes as $key => $value) {

            $stm = "SELECT CAST('" . $value['cast'] . "' AS CHAR(30)) AS natureza_producao,
					COUNT(p.id) AS producoes FROM " . $value['tabela'] . " pd
        			LEFT OUTER JOIN pessoa p ON (pd.id_pessoa = p.id)";

            if (strpos($value['tabela'], 'geral') !== false) {
                $stm .= "WHERE pd.natureza_producao = '" . $key . "' $complement";
            } else if (strpos($value['tabela'], 'trabalho') !== false) {
                $stm .= "WHERE pd.tipo = '" . $key . "' $complement";
            } else if ($access_level <= 3) {
                $stm .= "WHERE p.id_superintendencia = " . $this->session->userdata('id_superintendencia');
            }

            array_push($stms, $stm);
        }

        $sql = implode(" UNION ALL ", $stms);

        return $this->db_result();
    }

}
