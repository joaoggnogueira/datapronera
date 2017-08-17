<?php

class Relatorio_pesquisas_m extends CI_Model {

    public function proccess($stmt) {
        if (($bool = $this->db->query($stmt))) {
            $result = $bool->result_array();
            return $result;
        }
        return false;
    }


    public function pesquisas_academica() {
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
        ";

        return $this->proccess($stmt);
    }

    public function pesquisas_autores_academica() {
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

    public function pesquisas_livro() {
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

    public function pesquisas_autores_livro() {
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

    public function pesquisas_coletaneas() {
        $stmt = "
            SELECT 
                c.id as ID, 
                c.titulo as TÍTULO
            FROM 
                `coletanea` c
        ";
        return $this->proccess($stmt);
    }

    public function pesquisas_capitulo_livro() {
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

    public function pesquisas_autores_capitulo_livro() {
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

    public function pesquisas_artigo() {
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

    public function pesquisas_autores_artigo() {
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

    public function pesquisas_video() {
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

    public function pesquisas_autores_video() {
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

    public function pesquisas_periodicos() {
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

    public function pesquisas_autores_periodicos() {
        $stmt = "
            SELECT 
                p.id_pesquisa_periodico as ID_PERIÓDICO,
                a.nome as ORGANIZADOR
            FROM 
                `pesquisa_periodico_autor` p , `autor` a
        ";
        return $this->proccess($stmt);
    }

    public function pesquisas_eventos() {
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

    public function pesquisas_organizadores_eventos() {
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

    public function pesquisas_realizadores_eventos() {
        $stmt = "
            SELECT 
                e.id_pesquisa_evento as ID_EVENTO,
                if(e.nome='','NAO INFORMADO',e.nome) as REALIZADOR
            FROM 
                `pesquisa_evento_organizacao` e
        ";
        return $this->proccess($stmt);
    }

    public function pesquisas_documentacao_eventos() {
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
