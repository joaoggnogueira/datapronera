<?php

class Relatorio_producoes_m extends CI_Model {

    public function proccess($stmt) {
        if (($bool = $this->db->query($stmt))) {
            $result = $bool->result_array();
            return $result;
        }
        return false;
    }

    public function producoes_8A($status, $sr = false) {
        $stmt = "
            SELECT 
                c.id as CURSO_VINCULADO, 
                g.id as ID, g.titulo as TÍTULO, 
                g.natureza_producao as NATUREZA_PRODUÇÃO,
                g.autor_classificacao as CLASSIFICAÇÃO_AUTOR, 
                if(g.ano=0,'NAO INFORMADO',g.ano) as ANO, 
                g.local_producao as LOCAL
            FROM `producao_geral` g, 
                `curso` c
            WHERE g.id_curso = c.id 
                AND c.ativo_inativo = 'A' 
                AND c.status IN $status 
        ";
        if ($sr) {
            $stmt .= " AND c.id_superintendencia = $sr";
        }
        return $this->proccess($stmt);
    }

    public function producoes_autores_8A($status, $sr = false) {
        $stmt = "
            SELECT 
                g.id_curso as CURSO_VINCULADO, 
                ga.id_producao_geral as ID_PRODUÇÃO,
                a.nome as NOME_AUTOR, 
                a.tipo as TIPO_AUTOR
            FROM 
                `producao_geral_autor` ga, 
                `curso`c, `autor` a, 
                `producao_geral` g
            WHERE 
                ga.id_producao_geral = g.id 
                AND g.id_curso = c.id 
                AND c.ativo_inativo = 'A' 
                AND c.status IN $status 
                AND ga.id_autor = a.id ";
        if ($sr) {
            $stmt .= " AND c.id_superintendencia = $sr";
        }
        return $this->proccess($stmt);
    }

    public function producoes_8B($status, $sr = false) {
        $stmt = "
            SELECT 
                t.id_curso as CURSO_VINCULADO, 
                t.id as ID,
                t.tipo as TIPO, 
                t.titulo as TÍTULO,
                t.programa_curso as PROGRAMA_ASSOCIADO, 
                t.instituicao as INSTITUIÇÃO_PROGRAMA, 
                t.local_defesa as LOCAL_DEFESA, 
                t.local_estagio as LOCAL_ESTAGIO, 
                t.orientador as ORIENTADOR,
                if(t.ano_defesa=0,'NAO INFORMADO',t.ano_defesa) as ANO, 
                t.formato as FORMATO,
                t.disponibilidade as DISPONIBILIDADE, 
                if(t.pagina_web = '','NÃO INFORMADO',t.pagina_web) as PAGINA_WEB
            FROM 
                `producao_trabalho` t, 
                `curso` c
            WHERE 
                t.id_curso = c.id 
                AND c.ativo_inativo = 'A' 
                AND c.status IN $status 
        ";
        if ($sr) {
            $stmt .= " AND c.id_superintendencia = $sr";
        }
        return $this->proccess($stmt);
    }

    public function producoes_8C($status, $sr = false) {
        $stmt = "
            SELECT 
                a.id_curso as CURSO_VINCULADO, 
                a.id as ID, 
                a.titulo as TÍTULO, 
                a.tipo as TIPO, 
                if(a.tipo_descricao = '','NÃO INFORMADO',a.tipo_descricao) as DESCRIÇÃO_TIPO,
                if(a.ano=0,'NAO INFORMADO',a.ano) as ANO, a.local_producao as LOCAL, a.formato as FORMATO,
                if(a.disponibilidade=0,'NAO INFORMADO',a.disponibilidade) as DISPONIBILIDADE,
                if(a.pagina_web = '','NÃO INFORMADO',a.pagina_web) as PAGINA_WEB
            FROM 
                `producao_artigo` a, 
                `curso` c
            WHERE 
                a.id_curso = c.id 
                AND c.ativo_inativo = 'A' 
                AND c.status IN $status 
        ";
        if ($sr) {
            $stmt .= " AND c.id_superintendencia = $sr";
        }
        return $this->proccess($stmt);
    }

    public function producoes_autores_8C($status, $sr = false) {
        $stmt = "
            SELECT 
                g.id_curso as CURSO_VINCULADO, 
                aa.id_producao_artigo as ID_PRODUÇÃO,
                a.nome as NOME_AUTOR, 
                a.tipo as TIPO_AUTOR
            FROM 
                `producao_artigo_autor` aa, 
                `curso`c, 
                `autor` a, 
                `producao_artigo` g
            WHERE 
                aa.id_producao_artigo = g.id 
                AND g.id_curso = c.id 
            AND 
                c.ativo_inativo = 'A' 
                AND c.status IN $status 
                AND aa.id_autor = a.id 
        ";
        if ($sr) {
            $stmt .= " AND c.id_superintendencia = $sr";
        }
        return $this->proccess($stmt);
    }

    public function producoes_8D($status, $sr = false) {
        $stmt = "
            SELECT 
                m.id_curso as CURSO_VINCULADO, 
                m.id as ID,
                m.titulo as TÍTULO, 
                if(m.ano=0,'NAO INFORMADO',m.ano) as ANO, if(m.local_producao='','NÃO INFORMADO',m.local_producao) as LOCAL,
                if(m.formato='','NÃO INFORMADO',m.formato) as FORMATO,
                if(m.disponibilidade=0,'NAO INFORMADO',m.disponibilidade) as DISPONIBILIDADE
            FROM 
                `producao_memoria` m, 
                `curso` c
            WHERE 
                m.id_curso = c.id 
                AND c.ativo_inativo = 'A' 
                AND c.status IN $status 
        ";
        if ($sr) {
            $stmt .= " AND c.id_superintendencia = $sr";
        }
        return $this->proccess($stmt);
    }

    public function producoes_8E($status, $sr = false) {
        $stmt = "
            SELECT 
                l.id_curso as CURSO_VINCULADO, 
                l.id as ID, 
                l.titulo as TÍTULO, 
                l.tipo as TIPO, 
                if(l.ano=0,'NAO INFORMADO',l.ano) as ANO, if(l.editora='','NÃO INFORMADO',l.editora) as EDITORA, 
                if(l.local_producao='','NÃO INFORMADO',l.local_producao) as LOCAL,
                if(l.formato='','NÃO INFORMADO',l.formato) as FORMATO
            FROM 
                `producao_livro` l, 
                `curso` c
            WHERE 
                l.id_curso = c.id 
                AND c.ativo_inativo = 'A' 
                AND c.status IN $status 
        ";
        if ($sr) {
            $stmt .= " AND c.id_superintendencia = $sr";
        }
        return $this->proccess($stmt);
    }

    public function producoes_autores_8E($status, $sr = false) {
        $stmt = "
            SELECT 
                l.id_curso as CURSO_VINCULADO, 
                al.id_producao_livro as ID_PRODUÇÃO,
                a.nome as NOME_AUTOR, 
                a.tipo as TIPO_AUTOR
            FROM 
                `producao_livro_autor` al, 
                `curso`c, 
                `autor` a, 
                `producao_livro` l
            WHERE 
                al.id_producao_livro = l.id 
                AND l.id_curso = c.id 
            AND 
                c.ativo_inativo = 'A' 
                AND c.status IN $status  
                AND al.id_autor = a.id 
        ";
        if ($sr) {
            $stmt .= " AND c.id_superintendencia = $sr";
        }
        return $this->proccess($stmt);
    }

}
