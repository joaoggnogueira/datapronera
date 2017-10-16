<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Relatorio_dinamico_m extends CI_Model {

    public function abaSuperIntendencias($where = ""){

        $query = $this->db->query("
        SELECT
          s.id AS ID,
          s.nome AS NOME,
          s.nome_responsavel AS RESPONSÁVEL,
          CASE(s.ativo_inativo)
          WHEN 'A' THEN 'ATIVA'
          ELSE 'NÃO INFORMADO' END AS STATUS,
          e.sigla AS ESTADO
        FROM
          `superintendencia` s,
          `estado` e
        WHERE
          s.id_estado = e.id
          $where
        ");
        return $query->result_array();
    }
      
    public function abaCursos($where = ""){

        $query = $this->db->query("
            SELECT c.id as ID, c.nome as NOME, 
              c.id_superintendencia as SUPERINDENTÊNCIA, 
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
                c.obs as OBSERVAÇÃO_CURSO,
                cr.area_conhecimento as AREA_CONHECIMENTO,
                cr.nome_coordenador_geral as COORDENADOR_GERAL,
                cr.titulacao_coordenador_geral as TITULAÇÃO_COORDENADOR_GERAL,
                cr.nome_coordenador as COORDENADOR_PROJETO,
                cr.titulacao_coordenador as TITULAÇÃO_COORDENADOR_PROJETO,
                cr.nome_vice_coordenador as VICE_COORDENADOR,
                cr.titulacao_vice_coordenador as TITULACAO_VICE_COORDENADOR,
                cr.nome_coordenador_pedagogico as COORDENADOR_PEDAGÓGICO,
                cr.titulacao_coordenador_pedagogico as TITULAÇÃO_COORDENADOR_PEDAGÓGICO,
                cr.duracao_curso as DURAÇÃO_CURSO_ANOS,
                cr.inicio_previsto as MÊS_ANO_PREVISTO_INICIO,
                cr.termino_previsto as MÊS_ANO_PREVISTO_TÉRMINO,
                cr.inicio_realizado as MES_ANO_REALIZADO_INICIO,
                cr.termino_realizado as MÊS_ANO_REALIZADO_TÉRMINO,
                if(cr.numero_turmas=-1,'NAO INFORMADO',cr.numero_turmas) as NÚMERO_TURMAS,
                if(cr.numero_ingressantes=-1,'NAO INFORMADO',cr.numero_ingressantes) as NÚMERO_INGRESSANTES,
                if(cr.numero_concluintes=-1,'NAO INFORMADO',cr.numero_concluintes) as NÚMERO_CONCLUINTES,
                if(cr.numero_bolsistas=-1,'NAO INFORMADO',cr.numero_bolsistas) as NÚMERO_BOLSISTAS    
            FROM `curso` c, `curso_modalidade` cm, `caracterizacao` cr  
            WHERE c.id_modalidade = cm.id AND cr.id_curso = c.id AND c.ativo_inativo = 'A'
            $where

            ");
        return $query->result_array();
    }

    public function abaCidadeCursos($where = ""){

        $query = $this->db->query("
            SELECT cr.id_curso as ID_CURSO, ci.cod_municipio as GEOCODE, ci.nome as CIDADE, e.sigla as ESTADO   
            FROM `caracterizacao_cidade` cc, `caracterizacao` cr, `cidade` ci, `estado` e, `curso` c, `curso_modalidade` cm
            WHERE cr.id_curso = c.id AND cc.id_caracterizacao = cr.id AND cc.id_cidade = ci.id 
            AND ci.id_estado = e.id AND c.ativo_inativo = 'A'
            $where
        ");
        return $query->result_array();
    }

    public function abaEducandos($where = ""){
        // if($where != ""){
        //     $where = $this->db->escape_str($where);
        // }

        //var_dump($where);die;

        $query = $this->db->query("
            SELECT DISTINCT  e.id_curso as CURSO_VINCULADO, e.id as ID, e.nome as NOME,
            CASE e.genero
            WHEN 'M' THEN 'MASCULINO'
            WHEN 'F' THEN 'FEMININO'
            WHEN 'N' THEN 'NÃO INFORMADO'
            END as GÊNERO,
            DATE_FORMAT(e.data_nascimento, '%d/%m/%y') as DATA_NASCIMENTO,
            if(e.idade=-1,'NAO INFORMADO',e.idade) as IDADE,
            e.tipo_territorio as TIPO_TERRITÓRIO,
            e.nome_territorio as NOME_TERRITÓRIO,
            CASE e.concluinte
            WHEN 'I' THEN 'NÃO INFORMADO'
            WHEN 'S' THEN 'SIM'
            WHEN 'N' THEN 'NÃO'
            END as CONCLUINTE
            FROM `educando` e, `curso` c, `caracterizacao` cr, `curso_modalidade` cm
            WHERE e.id_curso = c.id AND cr.id_curso = c.id AND c.ativo_inativo = 'A'
            $where
        ");

        return $query->result_array();
    }
    
    
    public function abaCidadeEducandos($where = ""){

        $query = $this->db->query("
            SELECT DISTINCT ed.id_curso as CURSO_VINCULADO, ec.id_educando as ID_EDUCANDO, c.nome as NOME_CIDADE, e.sigla as ESTADO 
            FROM `educando`ed, `educando_cidade` ec, `cidade` c, `estado` e, `curso` cs, `caracterizacao` cr, `curso_modalidade` cm
            WHERE ed.id = ec.id_educando AND cr.id_curso = cs.id AND ec.id_cidade = c.id AND c.id_estado = e.id AND cs.id = ed.id_curso
            $where
        ");
        return $query->result_array();
    }

    public function abaProfessores($where = ""){
        // if($where != ""){
        //     $where = $this->db->escape_str($where);
        // }
        $query = $this->db->query("
            SELECT DISTINCT p.id_curso as CURSO_VINCULADO, p.id as ID, p.nome as NOME,
            CASE p.genero 
            WHEN 'M' THEN 'MASCULINO' 
            WHEN 'F' THEN 'FEMININO' 
            WHEN 'I' THEN 'NÃO INFORMADO' END as GÊNERO, 
            p.titulacao as TITULAÇÃO 
            FROM `professor` p, `curso` c, `caracterizacao` cr, `curso_modalidade` cm
            WHERE p.id_curso = c.id AND cr.id_curso = c.id AND c.ativo_inativo = 'A'
            $where
        ");
        return $query->result_array();
    }

    public function abaDisciplinas($where = ""){

        $query = $this->db->query("
            SELECT d.id_curso as CURSO_VINCULADO, d.id as ID, d.nome as NOME, d.id_professor as PROFESSOR_RESPONSÁVEL
            FROM `disciplina` d, `curso`c, `caracterizacao` cr, `curso_modalidade` cm
            WHERE d.id_curso = c.id AND cr.id_curso = c.id AND c.ativo_inativo = 'A'
            $where
        ");
        return $query->result_array();
        
    }

    public function abaInstituicoesEnsino($where = ""){

        $query = $this->db->query("
            SELECT DISTINCT ie.id_curso as CURSO_VINCULADO, ie.id as ID, ie.nome as NOME, ie.sigla as SIGLA, ie.unidade as UNIDADE,
            if(ie.departamento='NI','NAO INFORMADO',ie.departamento) as DEPARTAMENTO,
            ie.rua as LOGRADOURO, ie.numero as Nº, 
            if(ie.complemento='NI','NAO INFORMADO',ie.complemento) as COMPLEMENTO,
            ie.bairro as BAIRRO, ie.cep as CEP,
            ie.telefone1 as TELEFONE_1, ie.telefone2 as TELEFONE_2,
            if(ie.pagina_web='NI','NAO INFORMADO',ie.pagina_web) as PAGINA_WEB,
            ie.campus as CAMPUS, ie.natureza_instituicao as NATUREZA_INSTITUIÇÃO
            FROM `instituicao_ensino` ie, `curso` c, `caracterizacao` cr, `curso_modalidade` cm
            WHERE ie.id_curso = c.id AND cr.id_curso = c.id AND c.ativo_inativo = 'A'
            $where
        ");
        return $query->result_array();
    }

    public function abaCidadesInstituicoesEnsino($where = ""){

        $query = $this->db->query("
            SELECT DISTINCT ie.id_curso as CURSO_VINCULADO, ie.id as ID_INSTITUIÇÃO_ENSINO, c.nome as CIDADE, e.sigla as ESTADO 
            FROM `instituicao_ensino` ie, `cidade`c, `estado`e, `curso` cs, `caracterizacao` cr, `curso_modalidade` cm
            WHERE ie.id_cidade IS NOT NULL AND ie.id_cidade = c.id AND c.id_estado = e.id AND cs.id = ie.id_curso AND cr.id_curso = cs.id
            $where
        ");
        return $query->result_array();
    }

    public function abaOrganizacoesDemandantes($where = ""){

        $query = $this->db->query("
            SELECT od.id_curso as CURSO_VINCULADO, od.id as ID, od.nome as NOME, od.abrangencia as ABRANGÊNCIA,
            DATE_FORMAT(od.data_fundacao_nacional, '%d/%m/%y') as DATA_FUNDAÇÃO_NACIONAL,
            DATE_FORMAT(od.data_fundacao_estadual, '%d/%m/%y') as DATA_FUNDAÇÃO_ESTADUAL,
            if(od.numero_acampamentos=-1,'NAO INFORMADO',od.numero_acampamentos) as Nº_ACAMPAMENTOS,
            if(od.numero_assentamentos=-1,'NAO INFORMADO',od.numero_assentamentos) as Nº_ASSENTAMENTOS,
            if(od.numero_familias_assentadas=-1,'NAO INFORMADO',od.numero_familias_assentadas) as Nº_FAMÍLIAS_ASSENTADAS,
            if(od.numero_pessoas=-1,'NAO INFORMADO',od.numero_pessoas) as Nº_PESSOAS_ENVOLVIDAS_CURSO,
            od.fonte_informacao as FONTE_INFORMAÇÕES
            FROM `organizacao_demandante` od, `curso` c, `caracterizacao` cr, `curso_modalidade` cm
            WHERE od.id_curso = c.id AND c.ativo_inativo = 'A' AND cr.id_curso = c.id
            $where
        ");
        return $query->result_array();
    }

    public function abaCoordenadoresOrganizacoesDemandantes($where = ""){

        $query = $this->db->query("
            SELECT DISTINCT o.id_curso as CURSO_VINCULADO, od.id_organizacao_demandante as ORGANIZAÇÃO_DEMANDANTE_VINCULADA,
            od.id as ID, od.nome as NOME, od.grau_escolaridade_epoca as GRAU_ESCOLARIDADE_EPOCA_CURSO,
            od.grau_escolaridade_atual as GRAU_ESCOLARIDADE_ATUAL,
            CASE od.estuda_pronera
            WHEN 'I' THEN 'NÃO INFORMADO'
            WHEN 'S' THEN 'SIM'
            WHEN 'N' THEN 'NÃO'
            END as ESTUDOU_CURSO_PRONERA
            FROM `organizacao_demandante_coordenador` od, `organizacao_demandante` o, `curso` cs, `caracterizacao` cr, `curso_modalidade` cm
            WHERE o.id = od.id_organizacao_demandante AND cs.id = o.id_curso AND cr.id_curso = cs.id
            $where
        ");
        return $query->result_array();

    }

    public function abaParceiros($where = ""){

        $query = $this->db->query("
            SELECT DISTINCT  p.id_curso as CURSO_VINCULADO, p.id as ID, p.nome as NOME, p.sigla as SIGLA,
            p.rua as LOGRADOURO, p.numero as Nº, 
            if(p.complemento='NI','NAO INFORMADO',p.complemento) as COMPLEMENTO,
            p.bairro as BAIRRO, p.cep as CEP,
            p.telefone1 as TELEFONE_1, p.telefone2 as TELEFONE_2,
            if(p.pagina_web='NI','NAO INFORMADO',p.pagina_web) as PAGINA_WEB,
            p.natureza as NATUREZA_INSTITUIÇÃO,
            p.abrangencia as ABRANGÊNCIA
            FROM `parceiro` p, `curso`c, `caracterizacao` cr, `curso_modalidade` cm
            WHERE p.id_curso = c.id AND c.ativo_inativo = 'A' AND cr.id_curso = c.id
            $where
        ");

        return $query->result_array();

    }
    public function abaCidadesParceiros($where = ""){

        $query = $this->db->query("
            SELECT p.id as ID_PARCEIRO, c.nome as CIDADE, e.sigla as ESTADO 
            FROM `parceiro` p, `cidade`c, `estado`e, `curso` cp, `caracterizacao` cr, `curso_modalidade` cm
            WHERE p.id_cidade IS NOT NULL AND p.id_cidade = c.id AND c.id_estado = e.id AND p.id_curso = cp.id AND cr.id_curso = cp.id
            $where
        ");

        return $query->result_array();

    }

    public function abaTiposParceiros($where = ""){
        $query = $this->db->query("
            SELECT pp.id_parceiro as ID_PARCEIRO,
            CASE realizacao 
            WHEN 1 THEN 'SIM' 
            WHEN 0 THEN 'NÃO' END as REALIZAÇÃO_CURSO,
            CASE certificacao 
            WHEN 1 THEN 'SIM' 
            WHEN 0 THEN 'NÃO' END as CERTIFICAÇÃO_CURSO, 
            CASE gestao 
            WHEN 1 THEN 'SIM' 
            WHEN 0 THEN 'NÃO' END as GESTÃO_ORÇAMENTÁRIA, 
            CASE outros
            WHEN 1 THEN 'SIM' 
            WHEN 0 THEN 'NÃO' END as OUTRAS,
            pp.complemento as COMPLEMENTO
            FROM `parceiro_parceria` pp, `parceiro` p, `curso` c, `caracterizacao` cr, `curso_modalidade` cm
            WHERE pp.id_parceiro = p.id AND p.id_curso = c.id AND c.ativo_inativo = 'A' AND cr.id_curso = c.id
            $where
        ");

        return $query->result_array();
    }
}

/* End of file relatorio_dinamico_m.php */
/* Location: ./application/models/relatorio_dinamico_m.php */