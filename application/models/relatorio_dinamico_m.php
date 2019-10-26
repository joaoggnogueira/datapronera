<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Relatorio_dinamico_m extends CI_Model {

    public function stmt_from_where_curso() {

        $status_curso = $this->input->post('status_curso');
        $status_curso = str_replace("[", "(", $status_curso);
        $status_curso = str_replace("]", ")", $status_curso);
        
        $nivel = substr($this->input->post('nivel'), 0, 3);

        $curso = (int) $this->input->post('curso');
        $superintendencia = (int) $this->input->post('superintendencia');
        $modalidade = (int) $this->input->post('modalidade');
        $municipio = (int) $this->input->post('municipio');
        $estado = (int) $this->input->post('estado');

        $inicio0_realizado = (int) $this->input->post('inicio0_realizado');
        $inicio1_realizado = (int) $this->input->post('inicio1_realizado');
        $termino0_realizado = (int) $this->input->post('termino0_realizado');
        $termino1_realizado = (int) $this->input->post('termino1_realizado');

        $stmt_from = " `curso` c ";
        $stmt_where = " (c.`ativo_inativo` LIKE 'A') ";
        $stmt_from_flag = array();
        if ($curso != 0) { //CURSO ESPECIFICO
            $stmt_where .= " AND (c.id = $curso) ";
        } else { //MAIS DE UM CURSO
            if ($modalidade != 0) {
                $stmt_where .= " AND (c.id_modalidade = $modalidade) ";
            } else if ($nivel != "0") {
                switch ($nivel) {
                    case 'EJA':
                        $stmt_where .= " AND (c.id_modalidade IN ((17), (19), (23))) ";
                        break;
                    case 'EM':
                        $stmt_where .= " AND (c.id_modalidade IN ((18), (24), (16), (21), (20))) ";
                        break;
                    case 'ES':
                        $stmt_where .= " AND (c.id_modalidade IN ((15), (25), (22), (30))) ";
                        break;
                }
            }
            if (($inicio0_realizado != 0 && $inicio1_realizado != 0) || ($termino0_realizado != 0 && $termino1_realizado != 0) || $estado != 0) {
                $stmt_from_flag['caracterizacao'] = true;
                $stmt_from .= " INNER JOIN `caracterizacao` ca ON ca.id_curso = c.id ";

                if ($inicio0_realizado != 0 && $inicio1_realizado != 0) {
                    $stmt_where .= " AND (CAST(RIGHT(ca.inicio_realizado, 4) as SIGNED) BETWEEN $inicio0_realizado AND $inicio1_realizado) ";
                }

                if ($termino0_realizado != 0 && $termino1_realizado != 0) {
                    $stmt_where .= " AND (CAST(RIGHT(ca.termino_realizado, 4) as SIGNED) BETWEEN $termino0_realizado AND $termino1_realizado) ";
                }

                if ($estado != 0) {
                    $stmt_from_flag['caracterizacao_cidade'] = true;
                    $stmt_from .= " INNER JOIN `caracterizacao_cidade` caci ON caci.id_caracterizacao = ca.id ";
                    if ($municipio != 0) {
                        $stmt_where .= " AND (caci.id_cidade = $municipio) ";
                    } else {
                        $stmt_from_flag['cidade'] = true;
                        $stmt_from .= " INNER JOIN `cidade` ci ON ci.id = caci.id_cidade ";
                        $stmt_where .= " AND (ci.id_estado = $estado) ";
                    }
                }
            }

            if ($superintendencia != 0) {
                $stmt_where .= " AND (c.id_superintendencia = $superintendencia) ";
            }
            if ($status_curso != "0") {
                $stmt_where .= " AND (c.status IN $status_curso) ";
            }
        }
        $result = array("from" => $stmt_from, "where" => $stmt_where, "stmt_from_flag" => $stmt_from_flag);
        return $result;
    }

    public function list_cursos($where_from) {

        $stmt = "SELECT "
                . " DISTINCT CONCAT(LPAD(c.id_superintendencia, (2), (0) ),('.'), LPAD(c.id, (3), (0) ),(' - '),(c.nome)) as title, "
                . " c.id "
                . " FROM " . $where_from['from']
                . " WHERE " . $where_from['where']
                . " ORDER BY c.id ";
        $query = $this->db->query($stmt);
        return $query->result_array();
    }

    public function abaCursos($where_from) {

        $stmt_from = $where_from['from'];
        $stmt_where = $where_from['where'];
        if (!isset($where_from['stmt_from_flag']['caracterizacao'])) {
            $stmt_from .= " INNER JOIN `caracterizacao` ca ON ca.id_curso = c.id ";
        }
        $query = $this->db->query("
            SELECT 
              CONCAT(LPAD(c.id_superintendencia, (2), (0) ),('.'), LPAD(c.id, (3), (0) )) as COD, 
              c.nome as NOME, 
              CONCAT(('SR '),(LPAD(s.id,(2),(0))),(' - '),(s.nome)) AS SR,
              CASE cm.nome
                WHEN 'EJA ALFABETIZACAO' THEN 'EJA FUNDAMENTAL'
                WHEN 'EJA ANOS INICIAIS' THEN 'EJA FUNDAMENTAL'
                WHEN 'EJA ANOS FINAIS' THEN 'EJA FUNDAMENTAL'
                WHEN 'EJA NIVEL MEDIO (MAGISTERIO/FORMAL)' THEN 'ENSINO MÉDIO'
                WHEN 'EJA NIVEL MEDIO (NORMAL)' THEN 'ENSINO MÉDIO'
                WHEN 'NIVEL MEDIO/TECNICO (CONCOMITANTE)' THEN 'ENSINO MÉDIO'
                WHEN 'NIVEL MEDIO/TECNICO (INTEGRADO)' THEN 'ENSINO MÉDIO'
                WHEN 'NIVEL MEDIO PROFISSIONAL (POS-MEDIO)' THEN 'ENSINO MÉDIO'
                WHEN 'GRADUACAO' THEN 'ENSINO SUPERIOR'
                WHEN 'ESPECIALIZACAO' THEN 'ENSINO SUPERIOR'
                WHEN 'RESIDENCIA AGRARIA' THEN 'ENSINO SUPERIOR'
                WHEN 'MESTRADO' THEN 'ENSINO SUPERIOR'
                WHEN 'DOUTORADO' THEN 'ENSINO SUPERIOR'
              END AS NIVEL_CURSO,
                cm.nome as MODALIDADE,
                ca.area_conhecimento as AREA_CONHECIMENTO,
                ca.nome_coordenador_geral as COORDENADOR_GERAL,
                ca.titulacao_coordenador_geral as TITULAÇÃO_COORDENADOR_GERAL,
                ca.nome_coordenador as COORDENADOR_PROJETO,
                ca.titulacao_coordenador as TITULAÇÃO_COORDENADOR_PROJETO,
                ca.nome_vice_coordenador as VICE_COORDENADOR,
                ca.titulacao_vice_coordenador as TITULACAO_VICE_COORDENADOR,
                ca.nome_coordenador_pedagogico as COORDENADOR_PEDAGÓGICO,
                ca.titulacao_coordenador_pedagogico as TITULAÇÃO_COORDENADOR_PEDAGÓGICO,
                ca.duracao_curso as DURAÇÃO_CURSO_ANOS,
                ca.inicio_previsto as MÊS_ANO_PREVISTO_INICIO,
                ca.termino_previsto as MÊS_ANO_PREVISTO_TÉRMINO,
                ca.inicio_realizado as MES_ANO_REALIZADO_INICIO,
                ca.termino_realizado as MÊS_ANO_REALIZADO_TÉRMINO,
                if((ca.numero_turmas=-1),('NAO INFORMADO'),(ca.numero_turmas)) as NÚMERO_TURMAS,
                if((ca.numero_ingressantes=-1),('NAO INFORMADO'),(ca.numero_ingressantes)) as NÚMERO_INGRESSANTES,
                if((ca.numero_concluintes=-1),('NAO INFORMADO'),(ca.numero_concluintes)) as NÚMERO_CONCLUINTES,
                if((ca.numero_bolsistas=-1),('NAO INFORMADO'),(ca.numero_bolsistas)) as NÚMERO_BOLSISTAS,   
                if((c.id_instrumento=0),('NAO CADASTRADO'),(cti.nome)) as TIPO_INSTRUMENTO,   
                c.obs as OBSERVAÇÃO_CURSO
            FROM  $stmt_from
            INNER JOIN `curso_modalidade` cm ON cm.id = c.id_modalidade
            INNER JOIN `superintendencia` s ON s.id = c.id_superintendencia
            INNER JOIN `curso_tipo_instrumento` cti ON cti.id = c.id_instrumento
            WHERE $stmt_where ORDER BY c.id");
        $result = $query->result_array();
        return $result;
    }

    public function abaCidadeCursos($where_from) {
        $stmt_from = $where_from['from'];
        $stmt_where = $where_from['where'];
        if (!isset($where_from['stmt_from_flag']['caracterizacao'])) {
            $stmt_from .= " INNER JOIN `caracterizacao` ca ON ca.id_curso = c.id ";
        }
        if (!isset($where_from['stmt_from_flag']['caracterizacao_cidade'])) {
            $stmt_from .= " INNER JOIN `caracterizacao_cidade` caci ON caci.id_caracterizacao = ca.id ";
        }
        if (!isset($where_from['stmt_from_flag']['cidade'])) {
            $stmt_from .= " INNER JOIN `cidade` ci ON caci.id_cidade = ci.id ";
        }

        $query = $this->db->query("
            SELECT 
                DISTINCT 
                CONCAT(LPAD(c.id_superintendencia, (2), (0) ),('.'), LPAD(c.id, (3), (0) )) as COD, 
                ci.cod_municipio as GEOCODE, 
                ci.nome as CIDADE, 
                CONCAT((e.nome),(' ('),(e.sigla),(')')) as ESTADO   
            FROM 
                $stmt_from
                INNER JOIN `estado` e ON e.`id` = ci.`id_estado`
            WHERE 
                $stmt_where
        ");
        return $query->result_array();
    }

    public function abaEducandos($where_from) {
        $stmt_from = $where_from['from'];
        $stmt_where = $where_from['where'];

        $genero_educando = substr($this->input->post('genero_educando'), 0, 1);
        $nascimento_educando = (int) $this->input->post('nascimento_educando');

        $stmt_genero_educando = "";
        $stmt_nascimento_educando = "";

        if ($genero_educando != "0") {
            $stmt_genero_educando = " AND (ed.genero LIKE '$genero_educando') ";
        }

        if ($nascimento_educando != "0") {
            $stmt_nascimento_educando = " AND (CAST(LEFT(ed.data_nascimento, 4) as SIGNED) = $nascimento_educando) ";
        }

        $query = $this->db->query("
            SELECT DISTINCT  
                CONCAT(LPAD(c2.id_superintendencia, (2), (0) ),('.'), LPAD(c2.id, (3), (0) )) as CURSO_VINCULADO, 
                ed.id as ID, 
                ed.nome as NOME,
                ed.cpf as CPF,
                ed.rg as RG,
                CASE ed.genero
                    WHEN 'M' THEN 'MASCULINO'
                    WHEN 'F' THEN 'FEMININO'
                    WHEN 'N' THEN 'NÃO INFORMADO'
                END as GÊNERO,
                DATE_FORMAT(ed.data_nascimento, '%d/%m/%y') as DATA_NASCIMENTO,
                if(ed.idade=-1,('NAO INFORMADO'),(ed.idade)) as IDADE,
                ed.tipo_territorio as TIPO_TERRITÓRIO,
                ed.nome_territorio as NOME_TERRITÓRIO,
                ed.code_sipra_assentamento as COD_SIPRA,
                CASE ed.concluinte
                    WHEN 'I' THEN 'NÃO INFORMADO'
                    WHEN 'S' THEN 'SIM'
                    WHEN 'N' THEN 'NÃO'
                END as CONCLUINTE,
                ci2.cod_municipio as GEOCODE, 
                ci2.nome as CIDADE, 
                CONCAT((e2.nome),(' ('),(e2.sigla),(')')) as ESTADO  
            FROM curso c2
                INNER JOIN `educando` ed ON ed.id_curso = c2.id
                LEFT JOIN `educando_cidade` edci ON edci.id_educando = ed.id
                LEFT JOIN `cidade` ci2 ON ci2.id = edci.id_cidade
                LEFT JOIN `estado` e2 ON e2.id = ci2.id_estado
            WHERE
                ed.id_curso IN (SELECT c.`id` FROM $stmt_from WHERE $stmt_where )
                $stmt_genero_educando $stmt_nascimento_educando
            ORDER BY 
                ed.id_curso, 
                ed.nome
        ");
        return $query->result_array();
    }

    public function abaProfessores($where_from) {
        $stmt_from = $where_from['from'];
        $stmt_where = $where_from['where'];

        $genero_professor = substr($this->input->post('genero_professor'), 0, 1);
        $stmt_genero_professor = "";
        if ($genero_professor != "0") {
            $stmt_genero_professor = " AND (p.genero LIKE '$genero_professor') ";
        }
        $query = $this->db->query("
            SELECT DISTINCT 
            CONCAT(LPAD(c2.id_superintendencia, (2), (0) ),('.'), LPAD(c2.id, (3), (0) )) as CURSO_VINCULADO, 
            p.id as ID, 
            p.nome as NOME,
            p.cpf as CPF,
            p.rg as RG,
            CASE p.genero 
                WHEN 'M' THEN 'MASCULINO' 
                WHEN 'F' THEN 'FEMININO' 
                WHEN 'I' THEN 'NÃO INFORMADO' 
            END as GÊNERO, 
            p.titulacao as TITULAÇÃO 
            FROM 
                `professor` p INNER JOIN `curso` c2 ON p.id_curso = c2.id 
            WHERE 
                p.id_curso IN (SELECT c.`id` FROM $stmt_from WHERE $stmt_where )
                $stmt_genero_professor
            ORDER BY 
                p.id_curso, 
                p.nome
        ");
        return $query->result_array();
    }

    public function abaDisciplinas($where_from) {
        $stmt_from = $where_from['from'];
        $stmt_where = $where_from['where'];

        $genero_professor = substr($this->input->post('genero_professor'), 0, 1);
        $stmt_genero_professor = "";
        if ($genero_professor != "0") {
            $stmt_genero_professor = " AND (p.genero LIKE '$genero_professor') ";
        }
        $query = $this->db->query("
            SELECT DISTINCT 
            CONCAT(LPAD(c2.id_superintendencia, (2), (0) ),('.'), LPAD(c2.id, (3), (0) )) as CURSO_VINCULADO, 
            d.nome as NOME, 
            d.id_professor as PROFESSOR_RESPONSÁVEL
            FROM 
                `professor` p 
                INNER JOIN `curso` c2 ON p.id_curso = c2.id 
                INNER JOIN `disciplina` d ON d.id_professor = p.id
            WHERE 
                p.id_curso IN (SELECT c.`id` FROM $stmt_from WHERE $stmt_where )
                $stmt_genero_professor
            ORDER BY 
                p.id_curso
        ");
        return $query->result_array();
    }

    public function abaInstituicoesEnsino($where_from) {
        $stmt_from = $where_from['from'];
        $stmt_where = $where_from['where'];

        $query = $this->db->query("
            SELECT DISTINCT 
                CONCAT(LPAD(c2.id_superintendencia, (2), (0) ),('.'), LPAD(c2.id, (3), (0) )) as CURSO_VINCULADO,
                ie.id as ID, 
                ie.nome as NOME, 
                ie.sigla as SIGLA, 
                ie.unidade as UNIDADE,
                if(ie.departamento='NI','NAO INFORMADO',ie.departamento) as DEPARTAMENTO,
                ie.rua as LOGRADOURO, ie.numero as Nº, 
                if(ie.complemento='NI','NAO INFORMADO',ie.complemento) as COMPLEMENTO,
                ie.bairro as BAIRRO, ie.cep as CEP,
                ie.telefone1 as TELEFONE_1, ie.telefone2 as TELEFONE_2,
                if(ie.pagina_web='NI','NAO INFORMADO',ie.pagina_web) as PAGINA_WEB,
                ie.campus as CAMPUS, 
                ie.natureza_instituicao as NATUREZA_INSTITUIÇÃO,
                ci2.cod_municipio as GEOCODE, 
                ci2.nome as CIDADE, 
                CONCAT((e2.nome),(' ('),(e2.sigla),(')')) as ESTADO  
            FROM 
                `curso` c2
                INNER JOIN `instituicao_ensino` ie ON ie.id_curso = c2.id
                INNER JOIN `cidade` ci2 ON ci2.id = ie.id_curso
                INNER JOIN `estado` e2 ON e2.id = ci2.id_estado
            WHERE 
                ie.id_curso IN (SELECT c.`id` FROM $stmt_from WHERE $stmt_where )
            ORDER BY 
                ie.id_curso
        ");
        return $query->result_array();
    }

    public function abaOrganizacoesDemandantes($where_from) {
        $stmt_from = $where_from['from'];
        $stmt_where = $where_from['where'];

        $query = $this->db->query("
            SELECT 
                CONCAT(LPAD(c2.id_superintendencia, (2), (0) ),('.'), LPAD(c2.id, (3), (0) )) as CURSO_VINCULADO, 
                od.id as ID, 
                od.nome as NOME, 
                od.abrangencia as ABRANGÊNCIA,
                DATE_FORMAT(od.data_fundacao_nacional, '%d/%m/%y') as DATA_FUNDAÇÃO_NACIONAL,
                DATE_FORMAT(od.data_fundacao_estadual, '%d/%m/%y') as DATA_FUNDAÇÃO_ESTADUAL,
                if(od.numero_acampamentos=-1,'NAO INFORMADO',od.numero_acampamentos) as Nº_ACAMPAMENTOS,
                if(od.numero_assentamentos=-1,'NAO INFORMADO',od.numero_assentamentos) as Nº_ASSENTAMENTOS,
                if(od.numero_familias_assentadas=-1,'NAO INFORMADO',od.numero_familias_assentadas) as Nº_FAMÍLIAS_ASSENTADAS,
                if(od.numero_pessoas=-1,'NAO INFORMADO',od.numero_pessoas) as Nº_PESSOAS_ENVOLVIDAS_CURSO,
                od.fonte_informacao as FONTE_INFORMAÇÕES
            FROM 
                `curso` c2 
                INNER JOIN `organizacao_demandante` od ON od.id_curso = c2.id
            WHERE 
                c2.id IN (SELECT c.`id` FROM $stmt_from WHERE $stmt_where )
            ORDER BY 
                od.id_curso
        ");
        return $query->result_array();
    }

    public function abaParceiros($where_from) {
        $stmt_from = $where_from['from'];
        $stmt_where = $where_from['where'];
        $tipo_parceria_aux = json_decode($this->input->post("tipo_parceria_aux"));

        $stmt_tipo_parceria_aux = "";
        switch ($tipo_parceria_aux->realizacao_curso) {
            case 's': $stmt_tipo_parceria_aux .= " AND (pp.realizacao = 1) "; break;
            case 'n': $stmt_tipo_parceria_aux .= " AND (pp.realizacao = 0) "; break;
        }
        switch ($tipo_parceria_aux->certificacao_curso) {
            case 's': $stmt_tipo_parceria_aux .= " AND (pp.certificacao = 1) "; break;
            case 'n': $stmt_tipo_parceria_aux .= " AND (pp.certificacao = 0) "; break;
        }
        switch ($tipo_parceria_aux->gestao_orcamentaria) {
            case 's': $stmt_tipo_parceria_aux .= " AND (pp.gestao = 1) "; break;
            case 'n': $stmt_tipo_parceria_aux .= " AND (pp.gestao = 0) "; break;
        }
        switch ($tipo_parceria_aux->outras) {
            case 's': $stmt_tipo_parceria_aux .= " AND (pp.outros = 1) "; break;
            case 'n': $stmt_tipo_parceria_aux .= " AND (pp.outros = 0) "; break;
        }
        
        //tipo_parceria_aux
        $query = $this->db->query("
            SELECT DISTINCT  
                CONCAT(LPAD(c2.id_superintendencia, (2), (0) ),('.'), LPAD(c2.id, (3), (0) )) as CURSO_VINCULADO, 
                p.id as ID, 
                p.nome as NOME, 
                p.sigla as SIGLA,
                p.rua as LOGRADOURO, 
                p.numero as Nº, 
                if(p.complemento='NI','NAO INFORMADO',p.complemento) as COMPLEMENTO,
                p.bairro as BAIRRO, p.cep as CEP,
                p.telefone1 as TELEFONE_1, p.telefone2 as TELEFONE_2,
                if(p.pagina_web='NI','NAO INFORMADO',p.pagina_web) as PAGINA_WEB,
                p.natureza as NATUREZA_INSTITUIÇÃO,
                p.abrangencia as ABRANGÊNCIA,
                ci2.cod_municipio as GEOCODE, 
                ci2.nome as CIDADE, 
                e2.sigla as ESTADO,
                CASE realizacao 
                    WHEN 1 THEN 'SIM' 
                    WHEN 0 THEN 'NÃO' 
                END as REALIZAÇÃO_CURSO,
                CASE certificacao 
                    WHEN 1 THEN 'SIM' 
                    WHEN 0 THEN 'NÃO' 
                END as CERTIFICAÇÃO_CURSO, 
                CASE gestao 
                    WHEN 1 THEN 'SIM' 
                    WHEN 0 THEN 'NÃO' 
                END as GESTÃO_ORÇAMENTÁRIA, 
                CASE outros
                    WHEN 1 THEN 'SIM' 
                    WHEN 0 THEN 'NÃO' 
                END as OUTRAS,
                pp.complemento as COMPLEMENTO
            FROM 
                `curso` c2 
                INNER JOIN `parceiro` p ON p.id_curso = c2.id
                INNER JOIN `parceiro_parceria` pp ON pp.id_parceiro = p.id
                LEFT JOIN `cidade` ci2 ON ci2.id = p.id_cidade
                LEFT JOIN `estado` e2 ON e2.id = ci2.id_estado
            WHERE 
                c2.id IN (SELECT c.`id` FROM $stmt_from WHERE $stmt_where )
                $stmt_tipo_parceria_aux 
            ORDER BY 
                p.id_curso
                
        ");

        return $query->result_array();
    }

}

/* End of file relatorio_dinamico_m.php */
/* Location: ./application/models/relatorio_dinamico_m.php */