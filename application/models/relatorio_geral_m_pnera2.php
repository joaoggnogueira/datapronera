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

    function array_to_sql($stats) {
        $text = json_encode($stats);
        $text = str_replace("[", "(", $text);
        $text = str_replace("]", ")", $text);
        return $text;
    }

    function cursos_modalidade($access_level, $status) {

        $this->db->select('cm.nome AS modalidade, COUNT(c.id) AS cursos');
        $this->db->from('curso_modalidade cm');
        $this->db->join('curso c', 'cm.id = c.id_modalidade', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where_in('c.status', $status);

        if ($access_level <= 3) {
            $this->db->where('c.id_superintendencia', $this->session->userdata('id_superintendencia'));
        }

        $this->db->group_by('cm.nome');

        if (($query = $this->db->get()) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function cursos_nivel($access_level, $status) {

        $niveis = array(
            "EJA FUNDAMENTAL" => "('EJA ALFABETIZACAO','EJA ANOS INICIAIS','EJA ANOS FINAIS')",
            "ENSINO MÉDIO" => "('EJA NIVEL MEDIO (MAGISTERIO/FORMAL)','EJA NIVEL MEDIO (NORMAL)', 'NIVEL MEDIO/TECNICO (CONCOMITANTE)', 'NIVEL MEDIO/TECNICO (INTEGRADO)','NIVEL MEDIO PROFISSIONAL (POS-MEDIO)')",
            "ENSINO SUPERIOR" => "('GRADUACAO','ESPECIALIZACAO','RESIDENCIA AGRARIA','MESTRADO','DOUTORADO')"
        );

        $stms = array();
        foreach ($niveis as $key => $value) {
            $stm = "SELECT '$key' as nivel,IF(COUNT(c.id)<>0,COUNT(c.id),('-')) as total FROM curso c
                    LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
                    WHERE cm.nome IN $value
                    AND c.ativo_inativo = 'A'
                    AND c.status IN " . $this->array_to_sql($status) . "  ";
            if ($access_level <= 3) {
                $stm .= " AND c.id_superintendencia = " . $this->session->userdata('id_superintendencia');
            }
            array_push($stms, $stm);
        }

        $sql = implode(" UNION ALL ", $stms);

        if (($query = $this->db->query($sql)) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function cursos_nivel_superintendencia($status) {
        $stm1 = "SELECT s.id AS id,CONCAT(('SR - '),LPAD(s.id,(2),(0))) AS cod, s.nome AS nome FROM superintendencia s GROUP BY s.id";
        if ($bool = $this->db->query($stm1)) {
            $supers = $bool->result_array();
            $result = array();
            $cont = 0;
            $status_text = $this->array_to_sql($status);
            foreach ($supers as $row) {
                $stm2 = "SELECT '" . $row['nome'] . "' AS nome, '" . $row['cod'] . "' AS cod, 
                    IF((SELECT IF(COUNT(c.id)<>0,COUNT(c.id),('-')) FROM curso c
                                    LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
                                    WHERE cm.nome IN ('EJA ALFABETIZACAO','EJA ANOS INICIAIS','EJA ANOS FINAIS')
                                    AND c.id_superintendencia = '" . $row['id'] . "'
                                    AND c.ativo_inativo = 'A'
                                    AND c.status IN $status_text) IS NULL, 0, 
                            (SELECT IF(COUNT(c.id)<>0,COUNT(c.id),('-')) FROM curso c
                                    LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
                                    WHERE cm.nome IN ('EJA ALFABETIZACAO','EJA ANOS INICIAIS','EJA ANOS FINAIS')
                                    AND c.id_superintendencia = '" . $row['id'] . "'
                                    AND c.ativo_inativo = 'A'
                                    AND c.status IN $status_text)
                    ) AS eja_fundamental,
                    IF((SELECT IF(COUNT(c.id)<>0,COUNT(c.id),('-')) FROM curso c
                                    LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
                                    WHERE cm.nome IN ('EJA NIVEL MEDIO (MAGISTERIO/FORMAL)','EJA NIVEL MEDIO (NORMAL)', 'NIVEL MEDIO/TECNICO (CONCOMITANTE)', 'NIVEL MEDIO/TECNICO (INTEGRADO)','NIVEL MEDIO PROFISSIONAL (POS-MEDIO)')
                                    AND c.id_superintendencia = '" . $row['id'] . "'
                                    AND c.ativo_inativo = 'A'
                                    AND c.status IN $status_text) IS NULL, 0, 
                            (SELECT IF(COUNT(c.id)<>0,COUNT(c.id),('-')) FROM curso c
                                    LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
                                    WHERE cm.nome IN ('EJA NIVEL MEDIO (MAGISTERIO/FORMAL)','EJA NIVEL MEDIO (NORMAL)', 'NIVEL MEDIO/TECNICO (CONCOMITANTE)', 'NIVEL MEDIO/TECNICO (INTEGRADO)','NIVEL MEDIO PROFISSIONAL (POS-MEDIO)')
                                    AND c.id_superintendencia = '" . $row['id'] . "'
                                    AND c.ativo_inativo = 'A'
                                    AND c.status IN $status_text)
                    ) AS ensino_medio,
                    IF((SELECT IF(COUNT(c.id)<>0,COUNT(c.id),('-')) FROM curso c
                                    LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
                                    WHERE cm.nome IN ('GRADUACAO','ESPECIALIZACAO','RESIDENCIA AGRARIA','MESTRADO','DOUTORADO')
                                    AND c.id_superintendencia = '" . $row['id'] . "'
                                    AND c.ativo_inativo = 'A'
                                    AND c.status IN $status_text) IS NULL, 0, 
                            (SELECT IF(COUNT(c.id)<>0,COUNT(c.id),('-')) FROM curso c
                                    LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
                                    WHERE cm.nome IN ('GRADUACAO','ESPECIALIZACAO','RESIDENCIA AGRARIA','MESTRADO','DOUTORADO')
                                    AND c.id_superintendencia = '" . $row['id'] . "'
                                    AND c.ativo_inativo = 'A'
                                    AND c.status IN $status_text)
                    ) AS ensino_superior";
                if ($bool = $this->db->query($stm2)) {
                    $result_parcial = $bool->result_array();
                    $result[$cont] = $result_parcial[0];
                    $result[$cont]['total'] = $result_parcial[0]['eja_fundamental'] + $result_parcial[0]['ensino_medio'] + $result_parcial[0]['ensino_superior'];
                    if($result[$cont]['total']=='0') {
                        $result[$cont]['total'] = '-';
                    }
                    $cont++;
                }
            }
        }
        return $result;
    }

    function cursos_superintendencia($status) {

        $this->db->select("CONCAT(('SR - '),LPAD(s.id,(2),(0))) as id, s.nome AS superintendencia, COUNT(c.id) AS cursos");
        $this->db->from('superintendencia s');
        $this->db->join('curso c', 's.id = c.id_superintendencia', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where_in('c.status', $status);
        $this->db->group_by('s.id');
        $this->db->order_by('s.id');

        if (($query = $this->db->get()) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function alunos_ingressantes_modalidade($access_level, $status) {

        $this->db->select('
			cm.nome AS modalidade,
			IF (SUM(cr.numero_ingressantes) > 0, SUM(cr.numero_ingressantes), 0) AS alunos_ingressantes
		', false);
        $this->db->from('caracterizacao cr');
        $this->db->join('curso c', 'cr.id_curso = c.id', 'left');
        $this->db->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where_in('c.status', $status);
        $this->db->where('cr.numero_ingressantes >=', 0);

        if ($access_level <= 3) {
            $this->db->where('c.id_superintendencia', $this->session->userdata('id_superintendencia'));
        }

        $this->db->group_by('cm.id');

        if (($query = $this->db->get()) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function alunos_ingressantes_nivel($access_level, $status) {

        $niveis = array(
            "EJA FUNDAMENTAL" => "('EJA ALFABETIZACAO','EJA ANOS INICIAIS','EJA ANOS FINAIS')",
            "ENSINO MÉDIO" => "('EJA NIVEL MEDIO (MAGISTERIO/FORMAL)','EJA NIVEL MEDIO (NORMAL)', 'NIVEL MEDIO/TECNICO (CONCOMITANTE)', 'NIVEL MEDIO/TECNICO (INTEGRADO)','NIVEL MEDIO PROFISSIONAL (POS-MEDIO)')",
            "ENSINO SUPERIOR" => "('GRADUACAO','ESPECIALIZACAO','RESIDENCIA AGRARIA','MESTRADO','DOUTORADO')"
        );

        $stms = array();
        foreach ($niveis as $key => $value) {
            $stm = "SELECT '$key' AS nivel,SUM(cr.numero_ingressantes) as alunos
                    FROM caracterizacao cr
                    LEFT OUTER JOIN curso c ON (cr.id_curso = c.id)
                    LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
                    WHERE cm.nome IN $value 
                    AND c.ativo_inativo = 'A'
                    AND c.status IN " . $this->array_to_sql($status);

            if ($access_level <= 3) {
                $stm .= " AND c.id_superintendencia = " . $this->session->userdata('id_superintendencia');
            }
            array_push($stms, $stm);
        }
        $sql = implode(" UNION ALL ", $stms);

        //$this->db->select('cm.nivel AS modalidade,IF (SUM(cr.numero_ingressantes) > 0, SUM(cr.numero_ingressantes), 0) AS alunos_ingressantes', false);
        //$this->db->from('caracterizacao cr');
        //$this->db->join('curso c', 'cr.id_curso = c.id', 'left');
        //$this->db->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left');
        //$this->db->where('c.ativo_inativo', 'A');
        //$this->db->where('c.status', '2P');
        //$this->db->where('cr.numero_ingressantes >=', 0);
        //if ($access_level <= 3) {
        //	$this->db->where('c.id_superintendencia', $this->session->userdata('id_superintendencia'));
        //}
        //$this->db->group_by('cm.nivel');

        if (($query = $this->db->query($sql)) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function alunos_ingressantes_nivel_sr($status) {
        $stm1 = "SELECT s.id AS id, CONCAT(('SR - '),LPAD(s.id,(2),(0))) AS cod, s.nome AS nome FROM superintendencia s GROUP BY s.id";
        $title_status = $this->array_to_sql($status);
        if ($bool = $this->db->query($stm1)) {
            $supers = $bool->result_array();
            $result = array();
            $cont = 0;

            foreach ($supers as $row) {
                $stm2 = "SELECT '" . $row['nome'] . "' AS nome, '" . $row['cod'] . "' AS id, 
						IF((SELECT IF(SUM(cr.numero_ingressantes)<>0,SUM(cr.numero_ingressantes),('-')) FROM caracterizacao cr
								LEFT OUTER JOIN curso c ON (cr.id_curso = c.id)
								LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
								WHERE c.ativo_inativo =  'A' 
								AND c.status IN $title_status
								AND c.id_superintendencia = '" . $row['id'] . "'
								AND cm.nome IN ('EJA ALFABETIZACAO','EJA ANOS INICIAIS','EJA ANOS FINAIS')
							) IS NULL, 0, 
							(SELECT IF(SUM(cr.numero_ingressantes)<>0,SUM(cr.numero_ingressantes),('-')) FROM caracterizacao cr
								LEFT OUTER JOIN curso c ON (cr.id_curso = c.id)
								LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
								WHERE c.ativo_inativo =  'A' 
								AND c.status IN $title_status
								AND c.id_superintendencia = '" . $row['id'] . "'
								AND cm.nome IN ('EJA ALFABETIZACAO','EJA ANOS INICIAIS','EJA ANOS FINAIS'))
						) AS eja_fundamental,
						IF((SELECT IF(SUM(cr.numero_ingressantes)<>0,SUM(cr.numero_ingressantes),('-')) FROM caracterizacao cr
								LEFT OUTER JOIN curso c ON (cr.id_curso = c.id)
								LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
								WHERE c.ativo_inativo =  'A' 
								AND c.status IN $title_status
								AND c.id_superintendencia = '" . $row['id'] . "'
								AND cm.nome IN ('EJA NIVEL MEDIO (MAGISTERIO/FORMAL)','EJA NIVEL MEDIO (NORMAL)', 'NIVEL MEDIO/TECNICO (CONCOMITANTE)', 'NIVEL MEDIO/TECNICO (INTEGRADO)','NIVEL MEDIO PROFISSIONAL (POS-MEDIO)')
							) IS NULL, 0, 
							(SELECT IF(SUM(cr.numero_ingressantes)<>0,SUM(cr.numero_ingressantes),('-')) FROM caracterizacao cr
								LEFT OUTER JOIN curso c ON (cr.id_curso = c.id)
								LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
								WHERE c.ativo_inativo =  'A' 
								AND c.status IN $title_status
								AND c.id_superintendencia = '" . $row['id'] . "'
								AND cm.nome IN ('EJA NIVEL MEDIO (MAGISTERIO/FORMAL)','EJA NIVEL MEDIO (NORMAL)', 'NIVEL MEDIO/TECNICO (CONCOMITANTE)', 'NIVEL MEDIO/TECNICO (INTEGRADO)','NIVEL MEDIO PROFISSIONAL (POS-MEDIO)'))
						) AS ensino_medio,
						IF((SELECT IF(SUM(cr.numero_ingressantes)<>0,SUM(cr.numero_ingressantes),('-')) FROM caracterizacao cr
								LEFT OUTER JOIN curso c ON (cr.id_curso = c.id)
								LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
								WHERE c.ativo_inativo =  'A' 
								AND c.status IN $title_status
								AND c.id_superintendencia = '" . $row['id'] . "'
								AND cm.nome IN ('GRADUACAO','ESPECIALIZACAO','RESIDENCIA AGRARIA','MESTRADO','DOUTORADO')
							) IS NULL, 0, 
							(SELECT IF(SUM(cr.numero_ingressantes)<>0,SUM(cr.numero_ingressantes),('-')) FROM caracterizacao cr
								LEFT OUTER JOIN curso c ON (cr.id_curso = c.id)
								LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
								WHERE c.ativo_inativo =  'A' 
								AND c.status IN $title_status
								AND c.id_superintendencia = '" . $row['id'] . "'
								AND cm.nome IN ('GRADUACAO','ESPECIALIZACAO','RESIDENCIA AGRARIA','MESTRADO','DOUTORADO'))
						) AS ensino_superior";
                if ($bool = $this->db->query($stm2)) {
                    $result_parcial = $bool->result_array();
                    $result[$cont] = $result_parcial[0];
                    $result[$cont]['total'] = $result_parcial[0]['eja_fundamental'] + $result_parcial[0]['ensino_medio'] + $result_parcial[0]['ensino_superior'];
                    $cont++;
                }
            }
        }
        return $result;
    }

    function alunos_ingressantes_superintendencia($status) {

        $this->db->select("
			CONCAT(('SR - '),LPAD(s.id,(2),(0))) as id, s.nome AS superintendencia,
			IF (SUM(cr.numero_ingressantes) > 0, SUM(cr.numero_ingressantes), 0) AS alunos_ingressantes
		", false);
        $this->db->from('caracterizacao cr');
        $this->db->join('curso c', 'cr.id_curso = c.id', 'left');
        $this->db->join('superintendencia s', 'c.id_superintendencia = s.id', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where_in('c.status', $status);
        $this->db->where('cr.numero_ingressantes >=', 0);
        $this->db->group_by('s.id');

        if (($query = $this->db->get()) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function alunos_concluintes_modalidade($access_level, $status) {

        $this->db->select('
			cm.nome AS modalidade,
			IF (SUM(cr.numero_concluintes) > 0, SUM(cr.numero_concluintes), 0) AS alunos_concluintes
		', false);
        $this->db->from('caracterizacao cr');
        $this->db->join('curso c', 'cr.id_curso = c.id', 'left');
        $this->db->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where_in('c.status', $status);
        $this->db->where('cr.numero_concluintes >=', 0);

        if ($access_level <= 3) {
            $this->db->where('c.id_superintendencia', $this->session->userdata('id_superintendencia'));
        }

        $this->db->group_by('cm.id');

        if (($query = $this->db->get()) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function alunos_concluintes_nivel($access_level, $status) {

        $niveis = array(
            "EJA FUNDAMENTAL" => "('EJA ALFABETIZACAO','EJA ANOS INICIAIS','EJA ANOS FINAIS')",
            "ENSINO MÉDIO" => "('EJA NIVEL MEDIO (MAGISTERIO/FORMAL)','EJA NIVEL MEDIO (NORMAL)', 'NIVEL MEDIO/TECNICO (CONCOMITANTE)', 'NIVEL MEDIO/TECNICO (INTEGRADO)','NIVEL MEDIO PROFISSIONAL (POS-MEDIO)')",
            "ENSINO SUPERIOR" => "('GRADUACAO','ESPECIALIZACAO','RESIDENCIA AGRARIA','MESTRADO','DOUTORADO')"
        );
        $title_status = $this->array_to_sql($status);
        $stms = array();
        foreach ($niveis as $key => $value) {
            $stm = "SELECT '$key' AS nivel,SUM(cr.numero_concluintes) as alunos
                FROM caracterizacao cr
                LEFT OUTER JOIN curso c ON (cr.id_curso = c.id)
                LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
                WHERE cm.nome IN $value
                AND c.ativo_inativo = 'A'
                AND c.status IN $title_status";
            if ($access_level <= 3) {
                $stm .= " AND c.id_superintendencia = " . $this->session->userdata('id_superintendencia');
            }
            array_push($stms, $stm);
        }

        $sql = implode(" UNION ALL ", $stms);

        //$this->db->select('cm.nivel AS modalidade,IF (SUM(cr.numero_concluintes) > 0, SUM(cr.numero_concluintes), 0) AS alunos_concluintes', false);
        //$this->db->from('caracterizacao cr');
        //$this->db->join('curso c', 'cr.id_curso = c.id', 'left');
        //$this->db->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left');
        //$this->db->where('c.ativo_inativo', 'A');
        //$this->db->where('c.status', '2P');
        //$this->db->where('cr.numero_concluintes >=', 0);
        //if ($access_level <= 3) {
        //	$this->db->where('c.id_superintendencia', $this->session->userdata('id_superintendencia'));
        //}
        //$this->db->group_by('cm.nivel');

        if (($query = $this->db->query($sql)) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function alunos_concluintes_nivel_sr($status) {
        $stm1 = "SELECT s.id AS id, CONCAT(('SR - '),LPAD(s.id,(2),(0))) as cod , s.nome AS nome FROM superintendencia s GROUP BY s.id";
        $title_status = $this->array_to_sql($status);
        if ($bool = $this->db->query($stm1)) {
            $supers = $bool->result_array();
            $result = array();
            $cont = 0;

            foreach ($supers as $row) {
                $stm2 = "SELECT '" . $row['nome'] . "' AS nome, '" . $row['cod'] . "' AS id, 
						IF((SELECT IF(SUM(cr.numero_concluintes)<>0,SUM(cr.numero_concluintes),('-')) FROM caracterizacao cr
								LEFT OUTER JOIN curso c ON (cr.id_curso = c.id)
								LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
								WHERE c.ativo_inativo =  'A' 
								AND c.status IN $title_status
								AND c.id_superintendencia = '" . $row['id'] . "'
								AND cm.nome IN ('EJA ALFABETIZACAO','EJA ANOS INICIAIS','EJA ANOS FINAIS')
							) IS NULL, 0, 
							(SELECT IF(SUM(cr.numero_concluintes)<>0,SUM(cr.numero_concluintes),('-')) FROM caracterizacao cr
								LEFT OUTER JOIN curso c ON (cr.id_curso = c.id)
								LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
								WHERE c.ativo_inativo =  'A' 
								AND c.status IN $title_status
								AND c.id_superintendencia = '" . $row['id'] . "'
								AND cm.nome IN ('EJA ALFABETIZACAO','EJA ANOS INICIAIS','EJA ANOS FINAIS'))
						) AS eja_fundamental,
						IF((SELECT IF(SUM(cr.numero_concluintes)<>0,SUM(cr.numero_concluintes),('-')) FROM caracterizacao cr
								LEFT OUTER JOIN curso c ON (cr.id_curso = c.id)
								LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
								WHERE c.ativo_inativo =  'A' 
								AND c.status IN $title_status
								AND c.id_superintendencia = '" . $row['id'] . "'
								AND cm.nome IN ('EJA NIVEL MEDIO (MAGISTERIO/FORMAL)','EJA NIVEL MEDIO (NORMAL)', 'NIVEL MEDIO/TECNICO (CONCOMITANTE)', 'NIVEL MEDIO/TECNICO (INTEGRADO)','NIVEL MEDIO PROFISSIONAL (POS-MEDIO)')
							) IS NULL, 0, 
							(SELECT IF(SUM(cr.numero_concluintes)<>0,SUM(cr.numero_concluintes),('-')) FROM caracterizacao cr
								LEFT OUTER JOIN curso c ON (cr.id_curso = c.id)
								LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
								WHERE c.ativo_inativo =  'A' 
								AND c.status IN $title_status
								AND c.id_superintendencia = '" . $row['id'] . "'
								AND cm.nome IN ('EJA NIVEL MEDIO (MAGISTERIO/FORMAL)','EJA NIVEL MEDIO (NORMAL)', 'NIVEL MEDIO/TECNICO (CONCOMITANTE)', 'NIVEL MEDIO/TECNICO (INTEGRADO)','NIVEL MEDIO PROFISSIONAL (POS-MEDIO)'))
						) AS ensino_medio,
						IF((SELECT IF(SUM(cr.numero_concluintes)<>0,SUM(cr.numero_concluintes),('-')) FROM caracterizacao cr
								LEFT OUTER JOIN curso c ON (cr.id_curso = c.id)
								LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
								WHERE c.ativo_inativo =  'A' 
								AND c.status IN $title_status
								AND c.id_superintendencia = '" . $row['id'] . "'
								AND cm.nome IN ('GRADUACAO','ESPECIALIZACAO','RESIDENCIA AGRARIA','MESTRADO','DOUTORADO')
							) IS NULL, 0, 
							(SELECT IF(SUM(cr.numero_concluintes)<>0,SUM(cr.numero_concluintes),('-')) FROM caracterizacao cr
								LEFT OUTER JOIN curso c ON (cr.id_curso = c.id)
								LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
								WHERE c.ativo_inativo =  'A' 
								AND c.status IN $title_status
								AND c.id_superintendencia = '" . $row['id'] . "'
								AND cm.nome IN ('GRADUACAO','ESPECIALIZACAO','RESIDENCIA AGRARIA','MESTRADO','DOUTORADO'))
						) AS ensino_superior";
                if ($bool = $this->db->query($stm2)) {
                    $result_parcial = $bool->result_array();
                    $result[$cont] = $result_parcial[0];
                    $result[$cont]['total'] = $result_parcial[0]['eja_fundamental'] + $result_parcial[0]['ensino_medio'] + $result_parcial[0]['ensino_superior'];
                    $cont++;
                }
            }
        }
        return $result;
    }

    function alunos_concluintes_superintendencia($status) {

        $this->db->select("
			CONCAT(('SR - '),LPAD(s.id,(2),(0))) as id, s.nome AS superintendencia,
			IF (SUM(cr.numero_concluintes) > 0, SUM(cr.numero_concluintes), 0) AS alunos_concluintes
		", false);
        $this->db->from('caracterizacao cr');
        $this->db->join('curso c', 'cr.id_curso = c.id', 'left');
        $this->db->join('superintendencia s', 'c.id_superintendencia = s.id', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where_in('c.status', $status);
        $this->db->where('cr.numero_concluintes >=', 0);
        $this->db->group_by('s.id');

        if (($query = $this->db->get()) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function educandos_assentamento_modalidade($status) {
        $title_status = $this->array_to_sql($status);
        $sql = " SELECT
                       TRIM(tb1.assent) AS assent,
                        IF (tb2.qtde IS NULL, ('-'), tb2.qtde) AS eja_alf,
                        IF (tb3.qtde IS NULL, ('-'), tb3.qtde) AS eja_anos_inic,
                        IF (tb4.qtde IS NULL, ('-'), tb4.qtde) AS eja_anos_fin,
                        IF (tb5.qtde IS NULL, ('-'), tb5.qtde) AS eja_mag_form,
                        IF (tb6.qtde IS NULL, ('-'), tb6.qtde) AS eja_normal,
                        IF (tb7.qtde IS NULL, ('-'), tb7.qtde) AS medio_conc,
                        IF (tb8.qtde IS NULL, ('-'), tb8.qtde) AS medio_int,
                        IF (tb9.qtde IS NULL, ('-'), tb9.qtde) AS medio_prof_,
                        IF (tb10.qtde IS NULL, ('-'), tb10.qtde) AS graduacao,
                        IF (tb11.qtde IS NULL, ('-'), tb11.qtde) AS especializacao,
                        IF (tb12.qtde IS NULL, ('-'), tb12.qtde) AS res_agraria,
                        IF (tb13.qtde IS NULL, ('-'), tb13.qtde) AS mestrado,
                        IF (tb14.qtde IS NULL, ('-'), tb14.qtde) AS doutorado

                FROM 

                (SELECT DISTINCT ed.nome_territorio AS assent
                        FROM educando ed
                        INNER JOIN curso cs ON (cs.id = ed.id_curso)
                        WHERE cs.ativo_inativo = 'A' AND cs.status IN $title_status 
                        AND ed.tipo_territorio = 'ASSENTAMENTO'
                ) AS tb1

                LEFT OUTER JOIN

                (SELECT ed.nome_territorio AS assent, COUNT(ed.id) AS qtde
                        FROM educando ed
                        INNER JOIN curso cs ON (cs.id = ed.id_curso)
                        LEFT OUTER JOIN curso_modalidade cm ON (cs.id_modalidade = cm.id)
                        WHERE cs.ativo_inativo = 'A' AND cs.status IN $title_status 
                        AND cm.nome = 'EJA ALFABETIZACAO'
                        AND ed.tipo_territorio = 'ASSENTAMENTO'
                        GROUP BY ed.nome_territorio
                ) AS tb2

                ON (tb1.assent = tb2.assent)

                LEFT OUTER JOIN

                (SELECT ed.nome_territorio AS assent, COUNT(ed.id) AS qtde
                        FROM educando ed
                        INNER JOIN curso cs ON (cs.id = ed.id_curso)
                        LEFT OUTER JOIN curso_modalidade cm ON (cs.id_modalidade = cm.id)
                        WHERE cs.ativo_inativo = 'A' AND cs.status IN $title_status 
                        AND cm.nome = 'EJA ANOS INICIAIS'
                        AND ed.tipo_territorio = 'ASSENTAMENTO'
                        GROUP BY ed.nome_territorio
                ) AS tb3

                ON (tb1.assent = tb3.assent)

                LEFT OUTER JOIN

                (SELECT ed.nome_territorio AS assent, COUNT(ed.id) AS qtde
                        FROM educando ed
                        INNER JOIN curso cs ON (cs.id = ed.id_curso)
                        LEFT OUTER JOIN curso_modalidade cm ON (cs.id_modalidade = cm.id)
                        WHERE cs.ativo_inativo = 'A' AND cs.status IN $title_status 
                        AND cm.nome = 'EJA ANOS FINAIS'
                        AND ed.tipo_territorio = 'ASSENTAMENTO'
                        GROUP BY ed.nome_territorio
                ) AS tb4

                ON (tb1.assent = tb4.assent)

                LEFT OUTER JOIN

                (SELECT ed.nome_territorio AS assent, COUNT(ed.id) AS qtde
                        FROM educando ed
                        INNER JOIN curso cs ON (cs.id = ed.id_curso)
                        LEFT OUTER JOIN curso_modalidade cm ON (cs.id_modalidade = cm.id)
                        WHERE cs.ativo_inativo = 'A' AND cs.status IN $title_status 
                        AND cm.nome = 'EJA NIVEL MEDIO (MAGISTERIO/FORMAL)'
                        AND ed.tipo_territorio = 'ASSENTAMENTO'
                        GROUP BY ed.nome_territorio
                ) AS tb5

                ON (tb1.assent = tb5.assent)

                LEFT OUTER JOIN

                (SELECT ed.nome_territorio AS assent, COUNT(ed.id) AS qtde
                        FROM educando ed
                        INNER JOIN curso cs ON (cs.id = ed.id_curso)
                        LEFT OUTER JOIN curso_modalidade cm ON (cs.id_modalidade = cm.id)
                        WHERE cs.ativo_inativo = 'A' AND cs.status IN $title_status 
                        AND cm.nome = 'EJA NIVEL MEDIO (NORMAL)'
                        AND ed.tipo_territorio = 'ASSENTAMENTO'
                        GROUP BY ed.nome_territorio
                ) AS tb6

                ON (tb1.assent = tb6.assent)

                LEFT OUTER JOIN

                (SELECT ed.nome_territorio AS assent, COUNT(ed.id) AS qtde
                        FROM educando ed
                        INNER JOIN curso cs ON (cs.id = ed.id_curso)
                        LEFT OUTER JOIN curso_modalidade cm ON (cs.id_modalidade = cm.id)
                        WHERE cs.ativo_inativo = 'A' AND cs.status IN $title_status 
                        AND cm.nome = 'NIVEL MEDIO/TECNICO (CONCOMITANTE)'
                        AND ed.tipo_territorio = 'ASSENTAMENTO'
                        GROUP BY ed.nome_territorio
                ) AS tb7

                ON (tb1.assent = tb7.assent)

                LEFT OUTER JOIN

                (SELECT ed.nome_territorio AS assent, COUNT(ed.id) AS qtde
                        FROM educando ed
                        INNER JOIN curso cs ON (cs.id = ed.id_curso)
                        LEFT OUTER JOIN curso_modalidade cm ON (cs.id_modalidade = cm.id)
                        WHERE cs.ativo_inativo = 'A' AND cs.status IN $title_status 
                        AND cm.nome = 'NIVEL MEDIO/TECNICO (INTEGRADO)'
                        AND ed.tipo_territorio = 'ASSENTAMENTO'
                        GROUP BY ed.nome_territorio
                ) AS tb8

                ON (tb1.assent = tb8.assent)

                LEFT OUTER JOIN

                (SELECT ed.nome_territorio AS assent, COUNT(ed.id) AS qtde
                        FROM educando ed
                        INNER JOIN curso cs ON (cs.id = ed.id_curso)
                        LEFT OUTER JOIN curso_modalidade cm ON (cs.id_modalidade = cm.id)
                        WHERE cs.ativo_inativo = 'A' AND cs.status IN $title_status 
                        AND cm.nome = 'NIVEL MEDIO PROFISSIONAL (POS-MEDIO)'
                        AND ed.tipo_territorio = 'ASSENTAMENTO'
                        GROUP BY ed.nome_territorio
                ) AS tb9

                ON (tb1.assent = tb9.assent)

                LEFT OUTER JOIN

                (SELECT ed.nome_territorio AS assent, COUNT(ed.id) AS qtde
                        FROM educando ed
                        INNER JOIN curso cs ON (cs.id = ed.id_curso)
                        LEFT OUTER JOIN curso_modalidade cm ON (cs.id_modalidade = cm.id)
                        WHERE cs.ativo_inativo = 'A' AND cs.status IN $title_status 
                        AND cm.nome = 'GRADUACAO'
                        AND ed.tipo_territorio = 'ASSENTAMENTO'
                        GROUP BY ed.nome_territorio
                ) AS tb10

                ON (tb1.assent = tb10.assent)

                LEFT OUTER JOIN

                (SELECT ed.nome_territorio AS assent, COUNT(ed.id) AS qtde
                        FROM educando ed
                        INNER JOIN curso cs ON (cs.id = ed.id_curso)
                        LEFT OUTER JOIN curso_modalidade cm ON (cs.id_modalidade = cm.id)
                        WHERE cs.ativo_inativo = 'A' AND cs.status IN $title_status 
                        AND cm.nome = 'ESPECIALIZACAO'
                        AND ed.tipo_territorio = 'ASSENTAMENTO'
                        GROUP BY ed.nome_territorio
                ) AS tb11

                ON (tb1.assent = tb11.assent)

                LEFT OUTER JOIN

                (SELECT ed.nome_territorio AS assent, COUNT(ed.id) AS qtde
                        FROM educando ed
                        INNER JOIN curso cs ON (cs.id = ed.id_curso)
                        LEFT OUTER JOIN curso_modalidade cm ON (cs.id_modalidade = cm.id)
                        WHERE cs.ativo_inativo = 'A' AND cs.status IN $title_status 
                        AND cm.nome = 'RESIDENCIA AGRARIA'
                        AND ed.tipo_territorio = 'ASSENTAMENTO'
                        GROUP BY ed.nome_territorio
                ) AS tb12

                ON (tb1.assent = tb12.assent)

                LEFT OUTER JOIN

                (SELECT ed.nome_territorio AS assent, COUNT(ed.id) AS qtde
                        FROM educando ed
                        INNER JOIN curso cs ON (cs.id = ed.id_curso)
                        LEFT OUTER JOIN curso_modalidade cm ON (cs.id_modalidade = cm.id)
                        WHERE cs.ativo_inativo = 'A' AND cs.status IN $title_status 
                        AND cm.nome = 'MESTRADO'
                        AND ed.tipo_territorio = 'ASSENTAMENTO'
                        GROUP BY ed.nome_territorio
                ) AS tb13

                ON (tb1.assent = tb13.assent)

                LEFT OUTER JOIN

                (SELECT ed.nome_territorio AS assent, COUNT(ed.id) AS qtde
                        FROM educando ed
                        INNER JOIN curso cs ON (cs.id = ed.id_curso)
                        LEFT OUTER JOIN curso_modalidade cm ON (cs.id_modalidade = cm.id)
                        WHERE cs.ativo_inativo = 'A' AND cs.status IN $title_status 
                        AND cm.nome = 'DOUTORADO'
                        AND ed.tipo_territorio = 'ASSENTAMENTO'
                        GROUP BY ed.nome_territorio
                ) AS tb14

                ON (tb1.assent = tb14.assent)";

        if (($query = $this->db->query($sql)) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function educandos_assentamento_nivel($status) {

        $title_status = $this->array_to_sql($status);
        $sql = "SELECT
                        TRIM(tb1.assent) AS assent,
                        IF (tb2.qtde IS NULL, ('-'), tb2.qtde) AS eja_fundamental,
                        IF (tb3.qtde IS NULL, ('-'), tb3.qtde) AS nivel_medio,
                        IF (tb4.qtde IS NULL, ('-'), tb4.qtde) AS nivel_superior

                FROM 

                (SELECT DISTINCT ed.nome_territorio AS assent
                        FROM educando ed
                        INNER JOIN curso cs ON (cs.id = ed.id_curso)
                        WHERE cs.ativo_inativo = 'A' AND cs.status IN $title_status
                        AND ed.tipo_territorio = 'ASSENTAMENTO'
                ) AS tb1

                LEFT OUTER JOIN

                (SELECT ed.nome_territorio AS assent, COUNT(ed.id) AS qtde
                        FROM educando ed
                        INNER JOIN curso cs ON (cs.id = ed.id_curso)
                        LEFT OUTER JOIN curso_modalidade cm ON (cs.id_modalidade = cm.id)
                        WHERE cs.ativo_inativo = 'A' AND cs.status IN $title_status
                        AND cm.nome IN ('EJA ALFABETIZACAO','EJA ANOS INICIAIS','EJA ANOS FINAIS')
                        AND ed.tipo_territorio = 'ASSENTAMENTO'
                        GROUP BY ed.nome_territorio
                ) AS tb2

                ON (tb1.assent = tb2.assent)

                LEFT OUTER JOIN

                (SELECT ed.nome_territorio AS assent, COUNT(ed.id) AS qtde
                        FROM educando ed
                        INNER JOIN curso cs ON (cs.id = ed.id_curso)
                        LEFT OUTER JOIN curso_modalidade cm ON (cs.id_modalidade = cm.id)
                        WHERE cs.ativo_inativo = 'A' AND cs.status IN $title_status
                        AND cm.nome IN ('EJA NIVEL MEDIO (MAGISTERIO/FORMAL)','EJA NIVEL MEDIO (NORMAL)', 'NIVEL MEDIO/TECNICO (CONCOMITANTE)', 'NIVEL MEDIO/TECNICO (INTEGRADO)','NIVEL MEDIO PROFISSIONAL (POS-MEDIO)')
                        AND ed.tipo_territorio = 'ASSENTAMENTO'
                        GROUP BY ed.nome_territorio
                ) AS tb3

                ON (tb1.assent = tb3.assent)

                LEFT OUTER JOIN

                (SELECT ed.nome_territorio AS assent, COUNT(ed.id) AS qtde
                        FROM educando ed
                        INNER JOIN curso cs ON (cs.id = ed.id_curso)
                        LEFT OUTER JOIN curso_modalidade cm ON (cs.id_modalidade = cm.id)
                        WHERE cs.ativo_inativo = 'A' AND cs.status IN $title_status
                        AND cm.nome IN ('GRADUACAO','ESPECIALIZACAO','RESIDENCIA AGRARIA','MESTRADO','DOUTORADO')
                        AND ed.tipo_territorio = 'ASSENTAMENTO'
                        GROUP BY ed.nome_territorio
                ) AS tb4

                ON (tb1.assent = tb4.assent)";

        if (($query = $this->db->query($sql)) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function lista_educandos_cursos_sr($id, $status) {
        $sr = (int) $id;
        $this->db->select('
                    e.nome,
                    e.tipo_territorio,
                    e.nome_territorio,
                    CONCAT(LPAD(c.id_superintendencia, (2), (0) ),("."), LPAD(c.id, (3), (0) )) AS cod_curso,
                    c.nome AS nome_curso,
                    cm.nome AS modalidade
		', false);

        $this->db->from('educando e');
        $this->db->join('curso c', 'e.id_curso = c.id');
        $this->db->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left');
        $this->db->where('c.id_superintendencia', $sr);
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where_in('c.status', $status);

        if (($query = $this->db->get()) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function municipios_curso_modalidade($access_level, $status) {

        $this->db->select('
			cm.nome AS modalidade,
			e.sigla AS estado,
			cd.cod_municipio,
			cd.nome AS cidade,
			CONCAT(LPAD(c.id_superintendencia, (2), (0) ),("."), LPAD(c.id, (3), (0) )) AS id_curso,
			c.nome AS curso
		');

        $this->db->from('curso c');
        $this->db->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left');
        $this->db->join('caracterizacao cr', 'c.id = cr.id_curso', 'left');
        $this->db->join('caracterizacao_cidade cc', 'cr.id = cc.id_caracterizacao', 'left');
        $this->db->join('cidade cd', 'cc.id_cidade = cd.id', 'left');
        $this->db->join('estado e', 'cd.id_estado = e.id', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where_in('c.status', $status);

        if ($access_level <= 3) {
            $this->db->where('c.id_superintendencia', $this->session->userdata('id_superintendencia'));
        }

        $this->db->group_by('c.nome, cm.nome, e.sigla, cd.cod_municipio, cd.nome, c.id');
        if (($query = $this->db->get()) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function municipios_curso($access_level, $status) {

        $this->db->select('e.sigla AS estado, cd.cod_municipio, cd.nome AS cidade, COUNT(c.id) AS cursos');
        $this->db->from('caracterizacao_cidade cc');
        $this->db->join('caracterizacao cr', 'cc.id_caracterizacao = cr.id', 'left');
        $this->db->join('curso c', 'cr.id_curso = c.id', 'left');
        $this->db->join('cidade cd', 'cc.id_cidade = cd.id', 'left');
        $this->db->join('estado e', 'cd.id_estado = e.id', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where_in('c.status', $status);
        $this->db->where('cd.cod_municipio IS NOT ', 'NULL', false);

        if ($access_level <= 3) {
            $this->db->where('c.id_superintendencia', $this->session->userdata('id_superintendencia'));
        }

        $this->db->group_by('cd.cod_municipio, cd.nome, e.sigla');
        $this->db->order_by('e.sigla, cd.nome');

        if (($query = $this->db->get()) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function lista_cursos_modalidade($access_level, $status) {

        $this->db->select('cm.nome AS modalidade, CONCAT(LPAD(c.id_superintendencia, (2), (0) ),("."), LPAD(c.id, (3), (0) )) AS id_curso, c.nome AS curso');
        $this->db->from('curso c');
        $this->db->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left');
        $this->db->join('superintendencia s', 'c.id_superintendencia = s.id', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where_in('c.status', $status);

        if ($access_level <= 3) {
            $this->db->where('c.id_superintendencia', $this->session->userdata('id_superintendencia'));
        }

        $this->db->order_by('cm.nome, s.id, c.id');

        if (($query = $this->db->get()) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function lista_cursos_modalidade_sr($access_level, $status) {

        $this->db->select('CONCAT(("SR - "),LPAD(s.id,(2),(0))) AS id_superintendencia, s.nome AS superintendencia, cm.nome AS modalidade, CONCAT(LPAD(c.id_superintendencia, (2), (0) ),("."), LPAD(c.id, (3), (0) )) AS id_curso, c.nome AS curso');
        $this->db->from('curso c');
        $this->db->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left');
        $this->db->join('superintendencia s', 'c.id_superintendencia = s.id', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where_in('c.status', $status);

        if ($access_level <= 3) {
            $this->db->where('c.id_superintendencia', $this->session->userdata('id_superintendencia'));
        }

        $this->db->order_by('s.id, cm.nome, c.id');

        if (($query = $this->db->get()) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function alunos_curso($idSr, $status) {
        $sr = (int) $idSr;
        $this->db->select('CONCAT(LPAD(c.id_superintendencia, (2), (0) ),("."), LPAD(c.id, (3), (0) )) as id_curso, c.nome as curso, e.nome as educando');
        $this->db->from('educando e');
        $this->db->join('curso c', 'e.id_curso = c.id', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where_in('c.status', $status);
        $this->db->where('c.id_superintendencia', $sr);
        $this->db->order_by('c.id');

        if (($query = $this->db->get()) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function titulacao_educadores($access_level, $status) {

        $titulacoes = array(
            '("ENSINO FUNDAMENTAL COMPLETO")' => 'ENSINO FUNDAMENTAL COMPLETO',
            '("ENSINO FUNDAMENTAL INCOMPLETO")' => 'ENSINO FUNDAMENTAL INCOMPLETO',
            '("ENSINO MEDIO COMPLETO")' => 'ENSINO MÉDIO COMPLETO',
            '("ENSINO MEDIO INCOMPLETO")' => 'ENSINO MÉDIO INCOMPLETO',
            '("GRADUADO(A)")' => 'GRADUADO(A)',
            '("ESPECIALISTA")' => 'ESPECIALISTA',
            '("MESTRE(A)")' => 'MESTRE(A)',
            '("DOUTOR(A)")' => 'DOUTOR(A)',
            '("","NAOINFORMADO","###")' => 'NÃO INFORMADO'
        );

        $complement = ($access_level <= 3) ? "AND c.id_superintendencia = " . $this->session->userdata('id_superintendencia') : "";

        $stms = array();
        $title_status = $this->array_to_sql($status);
        foreach ($titulacoes as $key => $value) {

            $stm = "SELECT CAST('" . $value . "' AS CHAR(40)) AS titulacao,
					IF (
						(((SELECT COUNT(p.id) FROM professor p
							LEFT OUTER JOIN curso c ON (p.id_curso = c.id)
							WHERE c.ativo_inativo = 'A' $complement
							AND c.status IN $title_status
							AND p.titulacao IN  $key ) * 100) /
								(SELECT COUNT(p.id) FROM professor p
									LEFT OUTER JOIN curso c ON (p.id_curso = c.id)
									WHERE c.ativo_inativo = 'A' $complement
									AND c.status IN $title_status)
						) IS NULL, 0,
						(((SELECT COUNT(p.id) FROM professor p
							LEFT OUTER JOIN curso c ON (p.id_curso = c.id)
							WHERE c.ativo_inativo = 'A' $complement
							AND c.status IN $title_status
							AND p.titulacao IN  $key ) * 100) /
								(SELECT COUNT(p.id) FROM professor p
									LEFT OUTER JOIN curso c ON (p.id_curso = c.id)
									WHERE c.ativo_inativo = 'A' $complement
									AND c.status IN $title_status)
						)
					) AS educadores";

            array_push($stms, $stm);
        }

        $sql = implode(" UNION ALL ", $stms);

        if (($query = $this->db->query($sql)) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function titulacao_educadores_superintendencia($status) {

        $titulacoes = array(
            '("ENSINO FUNDAMENTAL COMPLETO")' => 'ensino_fundamental_completo',
            '("ENSINO FUNDAMENTAL INCOMPLETO")' => 'ensino_fundamental_incompleto',
            '("ENSINO MEDIO COMPLETO")' => 'ensino_medio_completo',
            '("ENSINO MEDIO INCOMPLETO")' => 'ensino_medio_incompleto',
            '("GRADUADO(A)")' => 'graduado',
            '("ESPECIALISTA")' => 'especialista',
            '("MESTRE(A)")' => 'mestre',
            '("DOUTOR(A)")' => 'doutor',
            '("","NAOINFORMADO","###")' => 'undefined'
        );

        $select = 'SELECT CONCAT(("SR - "),LPAD(s.id,(2),(0))) AS id, s.nome,';
        $title_status = $this->array_to_sql($status);
        $stms = array();
        foreach ($titulacoes as $key => $value) {

            $stm = "IF (
			        (((SELECT COUNT(p.id) FROM professor p
			            LEFT OUTER JOIN curso c ON (p.id_curso = c.id)
			            LEFT OUTER JOIN superintendencia sp ON (c.id_superintendencia = sp.id)
			            WHERE c.ativo_inativo = 'A' AND c.status IN $title_status
			            AND p.titulacao IN $key
			            AND sp.id = s.id) * 100) /
			                (SELECT COUNT(p.id) FROM professor p
			                    LEFT OUTER JOIN curso c ON (p.id_curso = c.id)
			                    LEFT OUTER JOIN superintendencia sp ON (c.id_superintendencia = sp.id)
			                    WHERE c.ativo_inativo = 'A' AND c.status IN $title_status
			                    AND sp.id = s.id)
			        ) IS NULl, 0,
			        (((SELECT COUNT(p.id) FROM professor p
			            LEFT OUTER JOIN curso c ON (p.id_curso = c.id)
			            LEFT OUTER JOIN superintendencia sp ON (c.id_superintendencia = sp.id)
			            WHERE c.ativo_inativo = 'A' AND c.status IN $title_status
			            AND p.titulacao IN $key
			            AND sp.id = s.id) * 100) /
			                (SELECT COUNT(p.id) FROM professor p
			                    LEFT OUTER JOIN curso c ON (p.id_curso = c.id)
			                    LEFT OUTER JOIN superintendencia sp ON (c.id_superintendencia = sp.id)
			                    WHERE c.ativo_inativo = 'A' AND c.status IN $title_status
			                    AND sp.id = s.id)
			        )
			    ) AS $value";
            array_push($stms, $stm);
        }

        $clause = "FROM superintendencia s GROUP BY s.id";

        $sql = implode(" ", array($select, implode(",", $stms), $clause));

        if (($query = $this->db->query($sql)) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function educadores_nivel($access_level, $status) {
        $title_status = $this->array_to_sql($status);
        $niveis = array(
            "EJA FUNDAMENTAL" => "('EJA ALFABETIZACAO','EJA ANOS INICIAIS','EJA ANOS FINAIS')",
            "ENSINO MÉDIO" => "('EJA NIVEL MEDIO (MAGISTERIO/FORMAL)','EJA NIVEL MEDIO (NORMAL)', 'NIVEL MEDIO/TECNICO (CONCOMITANTE)', 'NIVEL MEDIO/TECNICO (INTEGRADO)','NIVEL MEDIO PROFISSIONAL (POS-MEDIO)')",
            "ENSINO SUPERIOR" => "('GRADUACAO','ESPECIALIZACAO','RESIDENCIA AGRARIA','MESTRADO','DOUTORADO')"
        );

        $stms = array();
        foreach ($niveis as $key => $value) {

            if ($access_level <= 3) {
                $stm = "SELECT '" . $key . "' AS nivel,
                        IF(
                            (SELECT COUNT(p.id) FROM professor p
                                    LEFT OUTER JOIN curso c ON (p.id_curso = c.id)
                                    LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
                                    WHERE cm.nome IN " . $value . "
                                    AND c.ativo_inativo = 'A'
                                    AND c.status IN $title_status
                                    AND c.id_superintendencia = " . $this->session->userdata('id_superintendencia') . "
                            ) > 0, 
                            (SELECT COUNT(p.id) FROM professor p
                                    LEFT OUTER JOIN curso c ON (p.id_curso = c.id)
                                    LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
                                    WHERE cm.nome IN " . $value . "
                                    AND c.ativo_inativo = 'A'
                                    AND c.status IN $title_status
                                    AND c.id_superintendencia = " . $this->session->userdata('id_superintendencia') . "
                            ), 0
                        ) AS educadores";
            } else {
                $stm = "SELECT '" . $key . "' AS nivel,
                    IF(
                            (SELECT COUNT(p.id) FROM professor p
                                    LEFT OUTER JOIN curso c ON (p.id_curso = c.id)
                                    LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
                                    WHERE cm.nome IN " . $value . "
                                    AND c.ativo_inativo = 'A'
                                    AND c.status IN $title_status
                            ) > 0, 
                            (SELECT COUNT(p.id) FROM professor p
                                    LEFT OUTER JOIN curso c ON (p.id_curso = c.id)
                                    LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
                                    WHERE cm.nome IN " . $value . "
                                    AND c.ativo_inativo = 'A'
                                    AND c.status IN $title_status
                            ), 0
                    ) AS educadores";
            }
            array_push($stms, $stm);
        }

        $sql = implode(" UNION ALL ", $stms);

        //$this->db->select('cm.nivel, COUNT(p.id)');
        //$this->db->from('professor p');
        //$this->db->join('curso c', 'p.id_curso = c.id', 'left');
        //$this->db->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left');
        //$this->db->where('c.ativo_inativo', 'A');
        //$this->db->where('c.status', '2P');
        //if ($access_level <= 3) {
        //	$this->db->where('c.id_superintendencia', $this->session->userdata('id_superintendencia'));
        //}
        //$this->db->group_by('cm.nivel');

        if (($query = $this->db->query($sql)) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function educadores_curso($access_level, $status) {

        $this->db->select('CONCAT(LPAD(c.id_superintendencia, (2), (0) ),("."), LPAD(c.id, (3), (0) )) AS id_curso, c.nome AS curso, COUNT(p.id) AS educadores');
        $this->db->from('professor p');
        $this->db->join('curso c', 'p.id_curso = c.id', 'left');
        $this->db->join('superintendencia s', 'c.id_superintendencia = s.id', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where_in('c.status', $status);

        if ($access_level <= 3) {
            $this->db->where('c.id_superintendencia', $this->session->userdata('id_superintendencia'));
        }

        $this->db->group_by('c.id');
        $this->db->order_by('c.id, c.nome');

        if (($query = $this->db->get()) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function educadores_superintendencia($status) {

        $this->db->select('CONCAT(("SR - "),LPAD(s.id,(2),(0))) AS id, s.nome AS superintendencia, COUNT(p.id) AS educadores');
        $this->db->from('professor p');
        $this->db->join('curso c', 'p.id_curso = c.id', 'left');
        $this->db->join('superintendencia s', 'c.id_superintendencia = s.id', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where_in('c.status', $status);
        $this->db->group_by('s.id');

        if (($query = $this->db->get()) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function genero_educadores_modalidade($access_level, $status) {

        $title_status = $this->array_to_sql($status);
        $generos = array('masculino' => 'M', 'feminino' => 'F');


        $complement = ($access_level <= 3) ? "AND c.id_superintendencia = " . $this->session->userdata('id_superintendencia') : "";

        $select = "SELECT cm.nome AS modalidade,";

        $stms = array();
        foreach ($generos as $key => $value) {

            $stm = "IF (
			        (((SELECT COUNT(p.id) FROM professor p
			            LEFT OUTER JOIN curso c ON (c.id = p.id_curso)
			            LEFT OUTER JOIN curso_modalidade cmd ON (c.id_modalidade = cmd.id)
			            WHERE c.ativo_inativo = 'A' $complement
			            AND c.status IN $title_status
			            AND cmd.id = cm.id
			            AND p.genero = '" . $value . "') * 100) /
			                (SELECT COUNT(p.id) FROM professor p
			                    LEFT OUTER JOIN curso c ON (c.id = p.id_curso)
			                    LEFT OUTER JOIN curso_modalidade cmd ON (c.id_modalidade = cmd.id)
					            WHERE c.ativo_inativo = 'A' $complement
					            AND c.status IN $title_status
					            AND cmd.id = cm.id)
			        ) IS NULL, 0,
			        (((SELECT COUNT(p.id) FROM professor p
			            LEFT OUTER JOIN curso c ON (c.id = p.id_curso)
			            LEFT OUTER JOIN curso_modalidade cmd ON (c.id_modalidade = cmd.id)
			            WHERE c.ativo_inativo = 'A' $complement
			            AND c.status IN $title_status
			            AND cmd.id = cm.id
			            AND p.genero = '" . $value . "') * 100) /
			                (SELECT COUNT(p.id) FROM professor p
			                    LEFT OUTER JOIN curso c ON (c.id = p.id_curso)
			                    LEFT OUTER JOIN curso_modalidade cmd ON (c.id_modalidade = cmd.id)
					            WHERE c.ativo_inativo = 'A' $complement
					            AND c.status IN $title_status
					            AND cmd.id = cm.id)
			        )
			    ) AS $key";

            array_push($stms, $stm);
        }

        $clause = "FROM curso_modalidade cm GROUP BY cm.id";

        $sql = implode(" ", array($select, implode(",", $stms), $clause));

        if (($query = $this->db->query($sql)) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function educandos_superintendencia($status) {

        $this->db->select('CONCAT(("SR - "),LPAD(s.id,(2),(0))) as id, s.nome, COUNT(e.id) AS educandos');
        $this->db->from('educando e');
        $this->db->join('curso c', 'e.id_curso = c.id', 'left');
        $this->db->join('superintendencia s', 'c.id_superintendencia = s.id', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where_in('c.status', $status);
        $this->db->group_by('s.id');

        if (($query = $this->db->get()) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function municipio_origem_educandos($access_level, $status) {

        $this->db->select('
			e.sigla AS estado,
			cd.nome AS municipio,
			cd.cod_municipio AS cod_municipio,
			IF (COUNT(e.id) > 0, COUNT(e.id), 0) AS educandos
		', false);

        $this->db->from('educando_cidade ec');
        $this->db->join('cidade cd', 'ec.id_cidade = cd.id', 'left');
        $this->db->join('estado e', 'cd.id_estado = e.id', 'left');
        $this->db->join('educando ed', 'ec.id_educando = ed.id', 'left');
        $this->db->join('curso c', 'ed.id_curso = c.id', 'left');
        $this->db->where_in('c.status', $status);
        $this->db->where('c.ativo_inativo', 'A');

        if ($access_level <= 3) {
            $this->db->where('c.id_superintendencia', $this->session->userdata('id_superintendencia'));
        }

        $this->db->group_by('cd.cod_municipio, e.sigla, cd.nome, cd.id');
        $this->db->order_by('e.sigla');

        if (($query = $this->db->get()) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function territorio_educandos_modalidade($access_level, $status) {

        $territorios = array(
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

        $complement = ($access_level <= 3) ? "AND c.id_superintendencia = " . $this->session->userdata('id_superintendencia') : "";
        $title_status = $this->array_to_sql($status);
        $select = "SELECT cm.nome,";

        $stms = array();
        foreach ($territorios as $key => $value) {

            $stm = "(SELECT IF(COUNT(e.id)<>0,COUNT(e.id),('-')) AS educandos
					FROM educando e
        			LEFT OUTER JOIN curso c ON (e.id_curso = c.id)
        			LEFT OUTER JOIN curso_modalidade cmd ON (c.id_modalidade = cmd.id)
        			WHERE c.ativo_inativo = 'A' $complement
        			AND c.status IN $title_status
        			AND cmd.id = cm.id
        			AND e.tipo_territorio = '" . $value . "') AS $key";

            array_push($stms, $stm);
        }

        $clause = "FROM curso_modalidade cm";

        $sql = implode(" ", array($select, implode(",", $stms), $clause));

        if (($query = $this->db->query($sql)) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function territorio_educandos_superintendencia($status) {

        $territorios = array(
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

        $select = 'SELECT CONCAT(("SR - "),LPAD(s.id,(2),(0))) as id, s.nome,';
        $title_status = $this->array_to_sql($status);
        $stms = array();
        foreach ($territorios as $key => $value) {

            $stm = "(SELECT IF(COUNT(e.id)<>0,COUNT(e.id),('-')) AS educandos FROM educando e
        			LEFT OUTER JOIN curso c ON (e.id_curso = c.id)
        			LEFT OUTER JOIN superintendencia sp ON (c.id_superintendencia = sp.id)
        			WHERE c.ativo_inativo = 'A'
        			AND c.status IN $title_status
        			AND sp.id = s.id
        			AND e.tipo_territorio = '" . $value . "') AS $key";

            array_push($stms, $stm);
        }

        $clause = "FROM superintendencia s WHERE s.id <> 31";

        $sql = implode(" ", array($select, implode(",", $stms), $clause));

        if (($query = $this->db->query($sql)) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function idade_educandos_modalidade($access_level, $status) {

        $this->db->select('
			cm.nome AS modalidade,
			IF (AVG(e.idade) IS NOT NULL, AVG(e.idade), 0) AS idade
		', false);

        $this->db->from('educando e');
        $this->db->join('curso c', 'e.id_curso = c.id', 'left');
        $this->db->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left');
        $this->db->join('caracterizacao cr', 'c.id = cr.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where_in('c.status', $status);
        $this->db->where('e.idade >', 0);
        $this->db->where('e.data_nascimento <>', '0000-00-00');
        $this->db->where('e.data_nascimento <>', '1900-01-01');
        $this->db->where('cr.inicio_realizado <>', 'NI');

        if ($access_level <= 3) {
            $this->db->where('c.id_superintendencia', $this->session->userdata('id_superintendencia'));
        }

        $this->db->group_by('cm.id');

        if (($query = $this->db->get()) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function genero_educandos_modalidade($access_level, $status) {

        $title_status = $this->array_to_sql($status);
        $generos = array('masculino' => 'M', 'feminino' => 'F');

        $complement = ($access_level <= 3) ? "AND c.id_superintendencia = " . $this->session->userdata('id_superintendencia') : "";

        $select = "SELECT cm.nome AS modalidade,";

        $stms = array();
        foreach ($generos as $key => $value) {

            $stm = "IF (
			        (((SELECT COUNT(e.id) FROM educando e
			            LEFT OUTER JOIN curso c ON (c.id = e.id_curso)
			            LEFT OUTER JOIN curso_modalidade cmd ON (c.id_modalidade = cmd.id)
			            WHERE c.ativo_inativo = 'A' $complement
			            AND c.status IN $title_status
			            AND cmd.id = cm.id
			            AND e.genero = '" . $value . "') * 100) /
			                (SELECT COUNT(e.id) FROM educando e
			                    LEFT OUTER JOIN curso c ON (c.id = e.id_curso)
			                    LEFT OUTER JOIN curso_modalidade cmd ON (c.id_modalidade = cmd.id)
					            WHERE c.ativo_inativo = 'A' $complement
					            AND c.status IN $title_status
					            AND cmd.id = cm.id)
			        ) IS NULL, 0,
			        (((SELECT COUNT(e.id) FROM educando e
			            LEFT OUTER JOIN curso c ON (c.id = e.id_curso)
			            LEFT OUTER JOIN curso_modalidade cmd ON (c.id_modalidade = cmd.id)
			            WHERE c.ativo_inativo = 'A' $complement
			            AND c.status IN $title_status
			            AND cmd.id = cm.id
			            AND e.genero = '" . $value . "') * 100) /
			                (SELECT COUNT(e.id) FROM educando e
			                    LEFT OUTER JOIN curso c ON (c.id = e.id_curso)
			                    LEFT OUTER JOIN curso_modalidade cmd ON (c.id_modalidade = cmd.id)
					            WHERE c.ativo_inativo = 'A' $complement
					            AND c.status IN $title_status
					            AND cmd.id = cm.id)
			        )
			    ) AS $key";

            array_push($stms, $stm);
        }

        $clause = "FROM curso_modalidade cm GROUP BY cm.id";

        $sql = implode(" ", array($select, implode(",", $stms), $clause));

        if (($query = $this->db->query($sql)) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function localizacao_instituicoes_ensino($access_level, $status) {

        $this->db->select('IF(e.sigla IS NULL,("N/A"),(e.sigla)) AS estado, IF(cd.nome IS NULL,("N/A"),(cd.nome)) AS municipio, IF(cd.cod_municipio IS NULL,("N/A"),(cd.cod_municipio)) as cod_municipio, i.nome AS instituicao');
        $this->db->from('instituicao_ensino i');
        $this->db->join('cidade cd', 'i.id_cidade = cd.id', 'left');
        $this->db->join('estado e', 'cd.id_estado = e.id', 'left');
        $this->db->join('curso c', 'i.id_curso = c.id', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where_in('c.status', $status);
        $this->db->distinct();

        if ($access_level <= 3) {
            $this->db->where('c.id_superintendencia', $this->session->userdata('id_superintendencia'));
        }

        $this->db->order_by('e.sigla, cd.nome, i.nome');

        if (($query = $this->db->get()) != null) {
            return $query->result_array();
        } else {
            echo $this->db->last_query();
            return false;
        }
    }

    function instituicoes_ensino_modalidade($access_level, $status) {

        $this->db->select('cm.nome AS modalidade, COUNT(DISTINCT ie.nome) AS instituicoes');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'ie.id_curso = c.id', 'left');
        $this->db->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where_in('c.status', $status);

        if ($access_level <= 3) {
            $this->db->where('c.id_superintendencia', $this->session->userdata('id_superintendencia'));
        }

        $this->db->group_by('cm.id'); // Verificar isso


        if (($query = $this->db->get()) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function instituicoes_ensino_municipio($access_level, $status) {

        $this->db->select(
                'IF(e.sigla IS NULL,("N/A"),(e.sigla)) AS estado,'
              . ' IF(cd.cod_municipio IS NULL,("N/A"),(cd.cod_municipio)) as cod_municipio,'
              . ' IF(cd.nome IS NULL,("N/A"),(cd.nome)) AS municipio,'
              . ' COUNT(DISTINCT ie.nome) AS instituicoes');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'ie.id_curso = c.id', 'left');
        $this->db->join('cidade cd', 'ie.id_cidade = cd.id', 'left');
        $this->db->join('estado e', 'cd.id_estado = e.id', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where_in('c.status', $status);

        if ($access_level <= 3) {
            $this->db->where('c.id_superintendencia', $this->session->userdata('id_superintendencia'));
        }

        $this->db->group_by('cd.id');
        $this->db->order_by('e.sigla, cd.nome');


        if (($query = $this->db->get()) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function instituicoes_ensino_estado($status) {

        $this->db->select('IF(e.sigla IS NULL,("N/A"),(CONCAT((e.nome),(" ("),(e.sigla),(")")))) AS estado, COUNT(DISTINCT ie.nome) AS instituicoes');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'ie.id_curso = c.id', 'left');
        $this->db->join('cidade cd', 'ie.id_cidade = cd.id', 'left');
        $this->db->join('estado e', 'cd.id_estado = e.id', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where_in('c.status', $status);
        $this->db->group_by('e.sigla');


        if (($query = $this->db->get()) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function instituicoes_ensino_nivel($access_level, $status) {

        $title_status = $this->array_to_sql($status);

        $niveis = array(
            "EJA FUNDAMENTAL" => "('EJA ALFABETIZACAO','EJA ANOS INICIAIS','EJA ANOS FINAIS')",
            "ENSINO MÉDIO" => "('EJA NIVEL MEDIO (MAGISTERIO/FORMAL)','EJA NIVEL MEDIO (NORMAL)', 'NIVEL MEDIO/TECNICO (CONCOMITANTE)', 'NIVEL MEDIO/TECNICO (INTEGRADO)','NIVEL MEDIO PROFISSIONAL (POS-MEDIO)')",
            "ENSINO SUPERIOR" => "('GRADUACAO','ESPECIALIZACAO','RESIDENCIA AGRARIA','MESTRADO','DOUTORADO')"
        );

        $stms = array();
        foreach ($niveis as $key => $value) {
            if ($access_level <= 3) {
                $stm = "SELECT '" . $key . "' AS nivel,
                    IF(
                            (SELECT COUNT(DISTINCT ie.nome) FROM instituicao_ensino ie
                                    LEFT OUTER JOIN curso c ON (ie.id_curso = c.id)
                                    LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
                                    WHERE cm.nome IN " . $value . "
                                    AND c.ativo_inativo = 'A' 
                                    AND c.status IN $title_status
                                    AND c.id_superintendencia = " . $this->session->userdata('id_superintendencia') . "
                            ) > 0, 
                            (SELECT COUNT(DISTINCT ie.nome) FROM instituicao_ensino ie
                                    LEFT OUTER JOIN curso c ON (ie.id_curso = c.id)
                                    LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
                                    WHERE cm.nome IN " . $value . "
                                    AND c.ativo_inativo = 'A'
                                    AND c.status IN $title_status
                                    AND c.id_superintendencia = " . $this->session->userdata('id_superintendencia') . "
                            ), 0
                    ) AS instituicoes";
            } else {
                $stm = "SELECT '" . $key . "' AS nivel,
                    IF(
                            (SELECT COUNT(DISTINCT ie.nome) FROM instituicao_ensino ie
                                    LEFT OUTER JOIN curso c ON (ie.id_curso = c.id)
                                    LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
                                    WHERE cm.nome IN " . $value . "
                                    AND c.ativo_inativo = 'A'
                                    AND c.status IN $title_status
                            ) > 0, 
                            (SELECT COUNT(DISTINCT ie.nome) FROM instituicao_ensino ie
                                    LEFT OUTER JOIN curso c ON (ie.id_curso = c.id)
                                    LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
                                    WHERE cm.nome IN " . $value . "
                                    AND c.ativo_inativo = 'A'
                                    AND c.status IN $title_status
                            ), 0
                    ) AS instituicoes";
            }
            array_push($stms, $stm);
        }

        $sql = implode(" UNION ALL ", $stms);

        //$this->db->select('cm.nivel, COUNT(DISTINCT ie.nome) AS instituicoes');
        //$this->db->from('instituicao_ensino ie');
        //$this->db->join('curso c', 'ie.id_curso = c.id', 'left');
        //$this->db->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left');
        //$this->db->where('c.ativo_inativo', 'A');
        //$this->db->where('c.status', '2P');
        //if ($access_level <= 3) {
        //	$this->db->where('c.id_superintendencia', $this->session->userdata('id_superintendencia'));
        //}
        //$this->db->group_by('cm.nivel');


        if (($query = $this->db->query($sql)) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function instituicoes_ensino_superintendencia($status) {

        $this->db->select('CONCAT(("SR - "),LPAD(s.id,(2),(0))) as id, s.nome AS superintendencia, COUNT(DISTINCT ie.nome) AS instituicoes');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'ie.id_curso = c.id', 'left');
        $this->db->join('superintendencia s', 'c.id_superintendencia = s.id', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where_in('c.status', $status);
        $this->db->group_by('s.id');

        if (($query = $this->db->get()) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function cursos_natureza_inst_ensino($access_level, $status) {

        $title_status = $this->array_to_sql($status);

        $naturezas = array(
            'PUBLICA MUNICIPAL' => 'PÚBLICA MUNICIPAL',
            'PUBLICA ESTADUAL' => 'PÚBLICA ESTADUAL',
            'PUBLICA FEDERAL' => 'PÚBLICA FEDEREAL',
            'PRIVADA SEM FINS LUCRATIVOS' => 'PRIVADA SEM FINS LUCRATIVOS'
        );

        $complement = ($access_level <= 3) ? "AND c.id_superintendencia = " . $this->session->userdata('id_superintendencia') : "";

        $stms = array();
        foreach ($naturezas as $key => $value) {

            $stm = "SELECT CAST('" . $value . "' AS CHAR(40)) AS natureza,
					IF (COUNT(ie.id) > 0, COUNT(ie.id), 0) AS instituicoes
					FROM instituicao_ensino ie
                	LEFT OUTER JOIN curso c ON (ie.id_curso = c.id)
                	WHERE c.ativo_inativo = 'A' $complement
                	AND c.status IN $title_status
                	AND ie.natureza_instituicao = '" . $key . "'";

            array_push($stms, $stm);
        }

        $sql = implode(" UNION ALL ", $stms);

        if (($query = $this->db->query($sql)) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function instituicao_ensino_cursos($access_level, $status) {

        $title_status = $this->array_to_sql($status);

        $this->db->select('IF(ie.nome IS NULL,("N/A"),(ie.nome)) AS instituicao, COUNT(ie.id) AS cursos');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'ie.id_curso = c.id', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where_in('c.status', $status);

        if ($access_level <= 3) {
            $this->db->where('c.id_superintendencia', $this->session->userdata('id_superintendencia'));
        }

        $this->db->group_by('ie.nome');

        if (($query = $this->db->get()) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function organizacoes_demandantes_modalidade($access_level, $status) {

        $this->db->select('
			cm.nome AS modalidade,
			IF (COUNT(od.id) > 0, COUNT(od.id), 0) AS organizacoes
		', false);

        $this->db->from('organizacao_demandante od');
        $this->db->join('curso c', 'od.id_curso = c.id', 'left');
        $this->db->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where_in('c.status', $status);
        $this->db->group_by('cm.nome');

        if ($access_level <= 3) {
            $this->db->where('c.id_superintendencia', $this->session->userdata('id_superintendencia'));
        }

        if (($query = $this->db->get()) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function membros_org_demandantes_modalidade($access_level, $status) {

        $title_status = $this->array_to_sql($status);

        $estudo = array('sim' => 'S', 'nao' => 'N', 'ni' => 'i');

        $complement = ($access_level <= 3) ? "AND c.id_superintendencia = " . $this->session->userdata('id_superintendencia') : "";

        $select = "SELECT cm.nome AS modalidade,";

        $stms = array();
        foreach ($estudo as $key => $value) {

            $stm = "IF ((((SELECT COUNT(odc.id) FROM organizacao_demandante_coordenador odc
			            LEFT OUTER JOIN organizacao_demandante od ON (odc.id_organizacao_demandante = od.id)
			            LEFT OUTER JOIN curso c ON (od.id_curso = c.id)
			            LEFT OUTER JOIN curso_modalidade cmd ON (c.id_modalidade = cmd.id)
			            WHERE c.ativo_inativo = 'A' $complement
			            AND c.status IN $title_status
			            AND odc.estuda_pronera = '" . $value . "'
			            AND cmd.id = cm.id) * 100) /
			                (SELECT COUNT(odc.id) FROM organizacao_demandante_coordenador odc
			                    LEFT OUTER JOIN organizacao_demandante od ON (odc.id_organizacao_demandante = od.id)
			                    LEFT OUTER JOIN curso c ON (od.id_curso = c.id)
			                    LEFT OUTER JOIN curso_modalidade cmd ON (c.id_modalidade = cmd.id)
			                    WHERE c.ativo_inativo = 'A' $complement
			                    AND c.status IN $title_status
			                    AND cmd.id = cm.id)
			        ) IS NULL, 0,
			        (((SELECT COUNT(odc.id) FROM organizacao_demandante_coordenador odc
			            LEFT OUTER JOIN organizacao_demandante od ON (odc.id_organizacao_demandante = od.id)
			            LEFT OUTER JOIN curso c ON (od.id_curso = c.id)
			            LEFT OUTER JOIN curso_modalidade cmd ON (c.id_modalidade = cmd.id)
			            WHERE c.ativo_inativo = 'A' $complement
			            AND c.status IN $title_status
			            AND odc.estuda_pronera = '" . $value . "'
			            AND cmd.id = cm.id) * 100) /
			                (SELECT COUNT(odc.id) FROM organizacao_demandante_coordenador odc
			                    LEFT OUTER JOIN organizacao_demandante od ON (odc.id_organizacao_demandante = od.id)
			                    LEFT OUTER JOIN curso c ON (od.id_curso = c.id)
			                    LEFT OUTER JOIN curso_modalidade cmd ON (c.id_modalidade = cmd.id)
			                    WHERE c.ativo_inativo = 'A' $complement
			                    AND c.status  IN $title_status
			                    AND cmd.id = cm.id)
			        )
			    ) AS $key";

            array_push($stms, $stm);
        }

        $clause = "FROM curso_modalidade cm GROUP BY cm.id";

        $sql = implode(" ", array($select, implode(",", $stms), $clause));

        if (($query = $this->db->query($sql)) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function organizacao_demandante_cursos($access_level, $status) {

        $this->db->select('od.nome AS organizacao, COUNT(od.id) AS cursos');
        $this->db->from('organizacao_demandante od');
        $this->db->join('curso c', 'od.id_curso = c.id', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where_in('c.status', $status);

        if ($access_level <= 3) {
            $this->db->where('c.id_superintendencia', $this->session->userdata('id_superintendencia'));
        }

        $this->db->group_by('od.nome');

        if (($query = $this->db->get()) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function localizacao_parceiros($access_level, $status) {

        $this->db->select('e.sigla AS estado, cd.cod_municipio, cd.nome AS municipio, p.nome AS parceiro');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'p.id_curso = c.id', 'left');
        $this->db->join('cidade cd', 'p.id_cidade = cd.id', 'left');
        $this->db->join('estado e', 'cd.id_estado = e.id', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where_in('c.status', $status);
        $this->db->where('p.id_cidade <>', 0);

        if ($access_level <= 3) {
            $this->db->where('c.id_superintendencia', $this->session->userdata('id_superintendencia'));
        }

        $this->db->group_by('e.sigla, cd.nome, p.nome, cd.cod_municipio');

        if (($query = $this->db->get()) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function parceiros_modalidade($access_level, $status) {

        $this->db->select('
			cm.nome AS modalidade,
			IF (COUNT(p.id) > 0, COUNT(p.id), 0) AS parceiros
		', false);

        $this->db->from('parceiro p');
        $this->db->join('curso c', 'p.id_curso = c.id', 'left');
        $this->db->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where_in('c.status', $status);

        if ($access_level <= 3) {
            $this->db->where('c.id_superintendencia', $this->session->userdata('id_superintendencia'));
        }

        $this->db->group_by('cm.nome');

        if (($query = $this->db->get()) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function parceiros_superintendencia($status) {

        $this->db->select('CONCAT(("SR - "),LPAD(s.id, (2), (0) )) as id, s.nome AS superintendencia, COUNT(p.id) AS parceiros');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'p.id_curso = c.id', 'left');
        $this->db->join('superintendencia s', 'c.id_superintendencia = s.id', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where_in('c.status', $status);
        $this->db->group_by('s.id');

        if (($query = $this->db->get()) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function parceiros_natureza($access_level, $status) {

        $this->db->select('p.natureza, COUNT(p.id) AS parceiros');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'p.id_curso = c.id', 'left');
        $this->db->where('p.natureza IS NOT NULL', null, false);
        $this->db->where('p.natureza <>', '');
        $this->db->where_in('c.status', $status);

        if ($access_level <= 3) {
            $this->db->where('c.id_superintendencia', $this->session->userdata('id_superintendencia'));
        }

        $this->db->group_by('p.natureza');

        if (($query = $this->db->get()) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function lista_parceiros($access_level, $status) {

        $this->db->select('p.nome AS parceiro, p.sigla AS sigla, p.abrangencia AS abrangencia');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'p.id_curso = c.id', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where_in('c.status', $status);

        if ($access_level <= 3) {
            $this->db->where('c.id_superintendencia', $this->session->userdata('id_superintendencia'));
        }

        $this->db->group_by('p.nome');

        if (($query = $this->db->get()) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function producoes_estado($status) {
        
        $title_status = $this->array_to_sql($status);
        
        $tabelas = array(
            'pg' => 'producao_geral',
            'pt' => 'producao_trabalho',
            'pa' => 'producao_artigo',
            'pm' => 'producao_memoria',
            'pl' => 'producao_livro'
        );

        $select = "SELECT e.sigla, ";

        $stms = array();
        foreach ($tabelas as $key => $value) {

            $stm = "(SELECT IF(COUNT(p.id) <> 0,COUNT(p.id),('-')) as count FROM $value p
					LEFT OUTER JOIN curso c ON (p.id_curso = c.id)
					LEFT OUTER JOIN superintendencia s ON (c.id_superintendencia = s.id)
			        LEFT OUTER JOIN estado et ON (s.id_estado = et.id)
			        WHERE c.ativo_inativo = 'A'
			        AND c.status IN $title_status
			        AND et.id = e.id) AS $key";

            array_push($stms, $stm);
        }

        $clause = "FROM estado e
			 GROUP BY e.id
			 ORDER BY e.sigla";

        $sql = implode(" ", array($select, implode(",", $stms), $clause));

        if (($query = $this->db->query($sql)) != null) {
            return $query->result_array();
        } else {
            echo $this->db->last_query();
            return false;
        }
    }

    function producoes_superintendencia($status) {

        $title_status = $this->array_to_sql($status);        
        
        $tabelas = array(
            'pg' => 'producao_geral',
            'pt' => 'producao_trabalho',
            'pa' => 'producao_artigo',
            'pm' => 'producao_memoria',
            'pl' => 'producao_livro'
        );

        $select = "SELECT s.id, s.nome, ";

        $stms = array();
        foreach ($tabelas as $key => $value) {

            $stm = "(SELECT IF(COUNT(p.id) <> 0,COUNT(p.id),('-')) FROM $value p
					LEFT OUTER JOIN curso c ON (p.id_curso = c.id)
					LEFT OUTER JOIN superintendencia si ON (c.id_superintendencia = si.id)
					WHERE c.ativo_inativo = 'A'
					AND c.status IN $title_status
					AND si.id = s.id) AS $key";

            array_push($stms, $stm);
        }

        $clause = "FROM superintendencia s
			 GROUP BY s.id";

        $sql = implode(" ", array($select, implode(",", $stms), $clause));

        if (($query = $this->db->query($sql)) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function producoes_tipo($access_level, $status) {
        
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

        $complement = ($access_level <= 3) ? "AND c.id_superintendencia = " . $this->session->userdata('id_superintendencia') . " " : " ";

        $stms = array();
        foreach ($producoes as $key => $value) {

            $stm = "SELECT CAST('" . $value['cast'] . "' AS CHAR(30)) AS natureza_producao,
					COUNT(p.id) AS producoes FROM " . $value['tabela'] . " p
        			LEFT OUTER JOIN curso c ON (p.id_curso = c.id)
       				WHERE c.ativo_inativo = 'A' AND c.status IN $title_status $complement";

            if (strpos($value['tabela'], 'geral') !== false) {
                $stm .= "AND p.natureza_producao = '" . $key . "'";
            } else if (strpos($value['tabela'], 'trabalho') !== false) {
                $stm .= "AND p.tipo = '" . $key . "'";
            }
            array_push($stms, $stm);
        }

        $sql = implode(" UNION ALL ", $stms);

        $sql .= "AND p.natureza_producao NOT IN('VIDEO','CARTILHA / APOSTILA','TEXTO','MUSICA','CADERNO')";

        if (($query = $this->db->query($sql)) != null) {
            return $query->result_array();
        } else {
            return false;
        }
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

        if (($query = $this->db->query($sql)) != null) {
            return $query->result_array();
        } else {
            return false;
        }
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

        if (($query = $this->db->query($sql)) != null) {
            return $query->result_array();
        } else {
            return false;
        }
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

        if (($query = $this->db->query($sql)) != null) {
            return $query->result_array();
        } else {
            return false;
        }
    }

}
