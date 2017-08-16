<?php

class Relatorio_producoes_m extends CI_Model {

    public function proccess($stmt) {
        if (($bool = $this->db->query($stmt))) {
            $result = $bool->result_array();
            return $result;
        }
        return false;
    }

    //PRODUÇÔES

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

    //PESQUISAS

    public function pesquisas_academica($status, $sr = false) {
        $stmt = "
            SELECT 
                a.id as ID, 
                a.natureza_producao as TIPO, 
                a.titulo as TÍTULO,
                a.programa_curso as CURSO, 
                a.instituicao as INSTITUIÇÃO,
                a.local_producao as LOCAL, 
                if(a.ano=0,'NÃO INFORMADO',a.ano) as ANO,
                if(a.orientador='','NÃO INFORMADO',a.orientador) as ORIENTADOR,
                if(a.disponibilidade='','NÃO INFORMADO',a.disponibilidade) as DISPONÍVEL
            FROM 
                `pesquisa_academico` a
            INNER JOIN pessoa p ON p.id = a.id_pessoa 
        ";
        if ($sr) {
            $stmt .= "WHERE p.id_superintendencia = $sr";
        }
        return $this->proccess($stmt);
    }

    public function pesquisas_autores_academica($status, $sr = false) {
        $stmt = "
            SELECT 
                pa.id_pesquisa_academico as ID_ACADÊMICO, 
                a.nome as AUTOR
            FROM 
                `pesquisa_academico_autor` pa, 
                `autor` a
            WHERE 
                pa.id_autor = a.id
        ";
        return $this->proccess($stmt);
    }

    public function pesquisas_livro($status, $sr = false) {
        $stmt = "
            SELECT 
                l.id as ID, 
                l.titulo as TÍTULO, 
                if(l.local_producao='','NÃO INFORMADO',l.local_producao) as LOCAL,
                if(l.editora='','NÃO INFORMADO',l.editora) as EDITORA,
                if(l.ano=0,'NÃO INFORMADO',l.ano) as ANO,
                if(l.formato='','NÃO INFORMADO',l.formato) as FORMATO,
                if(l.disponibilidade='','NÃO INFORMADO',l.disponibilidade) as DISPONÍVEL
            FROM 
                `livro` l
        ";
        return $this->proccess($stmt);
    }

    public function pesquisas_autores_livro($status, $sr = false) {
        $stmt = "
            SELECT 
                la.id_livro as ID_LIVRO, 
                a.nome as AUTOR,
                a.tipo as COLABORAÇÃO
            FROM 
                `livro_autor` la, 
                `autor` a
            WHERE 
                la.id_autor = a.id
        ";
        return $this->proccess($stmt);
    }

    public function pesquisas_coletaneas($status, $sr = false) {
        $stmt = "
            SELECT 
                c.id as ID, 
                c.titulo as TÍTULO
            FROM 
                `coletanea` c
        ";
        return $this->proccess($stmt);
    }

    public function pesquisas_capitulo_livro($status, $sr = false) {
        $stmt = "
            SELECT 
                cl.id as ID, 
                cl.titulo_capitulo as TÍTULO_CAPÍTULO,
                cl.titulo_livro as TÍTULO_LIVRO,
                if(cl.local_producao='','NÃO INFORMADO',cl.local_producao) as LOCAL,
                if(cl.editora='','NÃO INFORMADO',cl.editora) as EDITORA,
                if(cl.ano=0,'NÃO INFORMADO',cl.ano) as ANO,
                if(cl.disponibilidade='','NÃO INFORMADO',cl.disponibilidade) as DISPONÍVEL
            FROM 
                `pesquisa_capitulo_livro` cl
        ";
        return $this->proccess($stmt);
    }

    public function pesquisas_autores_capitulo_livro($status, $sr = false) {
        $stmt = "
            SELECT 
                cl.id_pesquisa_capitulo_livro as ID_CAPÍTULO,
                a.nome as AUTOR, 
                a.tipo as COLABORAÇÃO
            FROM 
                `pesquisa_capitulo_livro_autor` cl, 
                `autor` a
            WHERE 
                cl.id_autor = a.id
        ";
        return $this->proccess($stmt);
    }

    public function pesquisas_artigo($status, $sr = false) {
        $stmt = "
            SELECT 
                a.id as ID, 
                a.titulo as TÍTULO,
                a.tipo as TIPO,
                if(a.tipo_nome='','NÃO INFORMADO',a.tipo_nome) as TIPO_NOME,
                if(a.local_producao='','NÃO INFORMADO',a.local_producao) as LOCAL,
                if(a.ano=0,'NÃO INFORMADO',a.ano) as ANO,
                if(a.disponibilidade='','NÃO INFORMADO',a.disponibilidade) as DISPONÍVEL
            FROM 
                `pesquisa_artigo` a
        ";
        return $this->proccess($stmt);
    }

    public function pesquisas_autores_artigo($status, $sr = false) {
        $stmt = "
            SELECT 
                pa.id_pesquisa_artigo as ID_ARTIGO, 
                a.nome as AUTOR
            FROM 
                `pesquisa_artigo_autor` pa, 
                `autor` a
            WHERE 
                pa.id_autor = a.id
        ";
        return $this->proccess($stmt);
    }

    public function pesquisas_video($status, $sr = false) {
        $stmt = "
            SELECT 
                v.id as ID, 
                v.titulo as TÍTULO,
                if(v.local_producao='','NÃO INFORMADO',v.local_producao) as LOCAL,
                if(v.ano=0,'NÃO INFORMADO',v.ano) as ANO,
                v.duracao as DURAÇÃO_MINUTOS,
                if(v.disponibilidade='','NÃO INFORMADO',v.disponibilidade) as DISPONÍVEL
            FROM 
                `pesquisa_video` v 
        ";
        return $this->proccess($stmt);
    }

    public function pesquisas_autores_video($status, $sr = false) {
        $stmt = "
            SELECT 
                v.id_pesquisa_video as ID_VÍDEO,
                a.nome as PRODUTOR
            FROM 
                `pesquisa_video_autor` v , 
                `autor` a
            WHERE 
                v.id_autor = a.id
        ";
        return $this->proccess($stmt);
    }

    public function pesquisas_periodicos($status, $sr = false) {
        $stmt = "
            SELECT 
                p.id as ID, 
                p.titulo as TÍTULO,
                if(p.local_producao='','NÃO INFORMADO',p.local_producao) as LOCAL,
                if(p.editora='','NÃO INFORMADO',p.editora) as EDITORA,
                if(p.ano=0,'NÃO INFORMADO',p.ano) as ANO,
                if(p.disponibilidade='','NÃO INFORMADO',p.disponibilidade) as DISPONÍVEL
            FROM 
                `pesquisa_periodico` p
        ";
        return $this->proccess($stmt);
    }

    public function pesquisas_autores_periodicos($status, $sr = false) {
        $stmt = "
            SELECT 
                p.id_pesquisa_periodico as ID_PERIÓDICO,
                a.nome as ORGANIZADOR
            FROM 
                `pesquisa_periodico_autor` p , `autor` a
        ";
        return $this->proccess($stmt);
    }

    public function pesquisas_eventos($status, $sr = false) {
        $stmt = "
            SELECT 
                e.id as ID, 
                e.titulo as TÍTULO,
                if(e.local_producao='','NÃO INFORMADO',e.local_producao) as LOCAL,
                c.nome as CIDADE, es.sigla as ESTADO,
                DATE_FORMAT(e.data_producao, '%d/%m/%y') as DATA_PRODUÇÃO,
                e.abrangencia as ABRANGÊNCIA, 
                if(e.participantes<1,'NÃO INFORMADO',e.participantes) as NUMERO_PARTICIPANTES
            FROM 
                `pesquisa_evento` e, 
                `cidade` c, 
                `estado` es
            WHERE 
                e.id_cidade = c.id 
                AND c.id_estado = es.id
        ";
        return $this->proccess($stmt);
    }

    public function pesquisas_organizadores_eventos($status, $sr = false) {
        $stmt = "
            SELECT 
                e.id_pesquisa_evento as ID_EVENTO, 
                if(a.nome='','NAO INFORMADO',a.nome) as ORGANIZADOR
            FROM 
                `pesquisa_evento_autor` e , 
                `autor` a
            WHERE 
                e.id_autor = a.id
        ";
        return $this->proccess($stmt);
    }

    public function pesquisas_realizadores_eventos($status, $sr = false) {
        $stmt = "
            SELECT 
                e.id_pesquisa_evento as ID_EVENTO,
                if(e.nome='','NAO INFORMADO',e.nome) as REALIZADOR
            FROM 
                `pesquisa_evento_organizacao` e
        ";
        return $this->proccess($stmt);
    }

    public function pesquisas_documentacao_eventos($status, $sr = false) {
        $stmt = "
            SELECT 
                e.id_pesquisa_evento as ID_EVENTO,
            CASE 
                e.op_nao 
                WHEN 1 THEN 'SIM' 
                WHEN 0 THEN 'NÃO'
            END as NÃO_PRODUZIDO,
            CASE e.memoria 
                WHEN 1 THEN 'SIM' 
                WHEN 0 THEN 'NÃO' 
            END as MEMÓRIA,
            if(e.memoria_descricao='','NAO INFORMADO', e.memoria_descricao) as COMPLEMENTO_MEMÓRIA,
            CASE e.carta 
                WHEN 1 THEN 'SIM' 
                WHEN 0 THEN 'NÃO'
            END as CARTA,
            if(e.carta_descricao='','NAO INFORMADO', e.carta_descricao) as COMPLEMENTO_CARTA,
            CASE e.relatorio 
                WHEN 1 THEN 'SIM' 
                WHEN 0 THEN 'NÃO'
            END as RELATÓRIO,
            if(e.relatorio_descricao='','NAO INFORMADO', e.relatorio_descricao) as COMPLEMENTO_RELATÓRIO,
            CASE e.anais
                WHEN 1 THEN 'SIM' 
                WHEN 0 THEN 'NÃO' 
            END as ANAIS,
            if(e.anais='','NAO INFORMADO', e.anais) as COMPLEMENTO_ANAIS,
            CASE e.video 
                WHEN 1 THEN 'SIM' 
                WHEN 0 THEN 'NÃO' 
            END as VÍDEO,
            if(e.video_descricao='','NAO INFORMADO', e.video_descricao) as COMPLEMENTO_VÍDEO
            FROM 
                `pesquisa_evento_documento` e
        ";
        return $this->proccess($stmt);
    }

}
