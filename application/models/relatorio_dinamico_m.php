<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Relatorio_dinamico_m extends CI_Model {

	/**
     * Este método retorna todas as informações referentes aos Cursos com os seus dados Adjacentes
     * @method cursoAdj
     * @param  [Array]   $informacoes [Dados selecionados pelo usuário para ser buscado]
     * @return [Array]   [Resultados]
     */
    public function cursoAdj($informacoes)
    {
    	$informacoes = $this->db->escape_str($informacoes);

    	$informacoesNull = $this->rmPes($informacoes);

    	$query = $this->db->query
    	("SELECT

			$informacoes

			FROM curso Cur
			INNER JOIN superintendencia Sup ON Sup.id = Cur.id_superintendencia
			INNER JOIN curso_modalidade Moda ON Moda.id = Cur.id_modalidade
			INNER JOIN pessoa Pes ON Pes.id = Cur.id_pesquisador
			INNER JOIN cidade Cid ON Cid.id = Pes.id_cidade
			INNER JOIN estado Est ON Est.id = Cid.id_estado
			INNER JOIN funcao Fun ON Fun.id = Pes.id_funcao

			UNION

			SELECT

			$informacoesNull

			FROM curso Cur
			INNER JOIN superintendencia Sup ON Sup.id = Cur.id_superintendencia
			INNER JOIN curso_modalidade Moda ON Moda.id = Cur.id_modalidade
			AND Cur.id_pesquisador IS NULL
    	");

		return $query;
    }

    /**
     * Este método retorna todas as informações referentes aos Professores com os seus dados Adjacentes
     * @method professorAdj
     * @param  [Array]   $informacoes [Dados selecionados pelo usuário para ser buscado]
     * @return [Array]   [Resultados]
     */
    public function professorAdj($informacoes)
    {
    	$informacoes = $this->db->escape_str($informacoes);

    	$query = $this->db->query
    	("SELECT

			$informacoes

			FROM professor Pro
			INNER JOIN curso Cur ON Cur.id = Pro.id_curso
			INNER JOIN superintendencia Sup ON Sup.id = Cur.id_superintendencia
			INNER JOIN curso_modalidade Moda ON Moda.id = Cur.id_modalidade
    	");

		return $query;
    }

    /**
     * Este método retorna todas as informações referentes aos educandos com os seus dados Adjacentes
     * @method educandoAdj
     * @param  [Array]   $informacoes [Dados selecionados pelo usuário para ser buscado]
     * @return [Array]   [Resultados]
     */
    public function educandoAdj($informacoes)
    {
    	$informacoes = $this->db->escape_str($informacoes);

    	$informacoesNull = $this->rmEdu($informacoes);

    	$query = $this->db->query
    	("SELECT

    		$informacoes

    		FROM Educando Edu
    		INNER JOIN educando_cidade EduCid ON EduCid.id_cidade = Edu.id_cidade AND EduCid.id_educando = Edu.id
    		INNER JOIN cidade Cid ON EduCid.id_cidade = Cid.id
			INNER JOIN estado Est ON Est.id = Cid.id_estado
			INNER JOIN curso Cur ON Cur.id = Edu.id_curso
			INNER JOIN superintendencia Sup ON Sup.id = Cur.id_superintendencia
			INNER JOIN curso_modalidade Moda ON Moda.id = Cur.id_modalidade

			UNION

			SELECT

    		$informacoesNull

    		FROM Educando Edu
    		INNER JOIN curso Cur ON Cur.id = Edu.id_curso
			INNER JOIN superintendencia Sup ON Sup.id = Cur.id_superintendencia
			INNER JOIN curso_modalidade Moda ON Moda.id = Cur.id_modalidade
    	");

    	return $query;
    }

    /**
     * Este método retorna todas as informações referentes a Instituições de Ensino com os seus dados Adjacentes
     * @method instituicaoEnsinoAdj
     * @param  [Array]   $informacoes [Dados selecionados pelo usuário para ser buscado]
     * @return [Array]   [Resultados]
     */
    public function instituicaoEnsinoAdj($informacoes)
    {
    	$informacoes = $this->db->escape_str($informacoes);

    	$informacoesNull = $this->rmPes($informacoes);

    	$query = $this->db->query
    	("SELECT

			$informacoes

			FROM instituicao_ensino InsEn
			INNER JOIN curso Cur ON InsEn.id_curso = Cur.id
			INNER JOIN superintendencia Sup ON Sup.id = Cur.id_superintendencia
			INNER JOIN curso_modalidade Moda ON Moda.id = Cur.id_modalidade

			INNER JOIN pessoa Pes ON Pes.id = Cur.id_pesquisador

			INNER JOIN cidade Cid ON Cid.id = Pes.id_cidade
			INNER JOIN estado Est ON Est.id = Cid.id_estado
			INNER JOIN funcao Fun ON Fun.id = Pes.id_funcao

			UNION

			SELECT

			$informacoesNull

			FROM instituicao_ensino InsEn
			INNER JOIN curso Cur ON InsEn.id_curso = Cur.id
			INNER JOIN superintendencia Sup ON Sup.id = Cur.id_superintendencia
			INNER JOIN curso_modalidade Moda ON Moda.id = Cur.id_modalidade

			AND Cur.id_pesquisador IS NULL
    	");

		return $query;
    }

    /**
     * Este método retorna todas as informações referentes a Parceiros com os seus dados Adjacentes
     * @method parceiroAdj
     * @param  [Array]   $informacoes [Dados selecionados pelo usuário para ser buscado]
     * @return [Array]   [Resultados]
     */
    public function parceiroAdj($informacoes)
    {
    	$informacoes = $this->db->escape_str($informacoes);

    	$informacoesNull = $this->rmPes($informacoes);

    	$query = $this->db->query
    	("SELECT

			$informacoes

			FROM parceiro Par
			INNER JOIN curso Cur ON Par.id_curso = Cur.id
			INNER JOIN superintendencia Sup ON Sup.id = Cur.id_superintendencia
			INNER JOIN curso_modalidade Moda ON Moda.id = Cur.id_modalidade
			INNER JOIN pessoa Pes ON Pes.id = Cur.id_pesquisador
			INNER JOIN cidade Cid ON Cid.id = Pes.id_cidade
			INNER JOIN estado Est ON Est.id = Cid.id_estado
			INNER JOIN funcao Fun ON Fun.id = Pes.id_funcao

			UNION

			SELECT

			$informacoesNull

			FROM parceiro Par
			INNER JOIN curso Cur ON Par.id_curso = Cur.id
			INNER JOIN superintendencia Sup ON Sup.id = Cur.id_superintendencia
			INNER JOIN curso_modalidade Moda ON Moda.id = Cur.id_modalidade
			AND Cur.id_pesquisador IS NULL
		");

		return $query;
	}

	private function rmPes($dados)
	{
		$informacoesNull = str_replace('Pes.`cpf`', 			'NULL', $dados);
    	$informacoesNull = str_replace('Pes.`rg`', 				'NULL', $informacoesNull);
    	$informacoesNull = str_replace('Pes.`rg_emissor`', 		'NULL', $informacoesNull);
    	$informacoesNull = str_replace('Pes.`nome`', 			'NULL', $informacoesNull);
    	$informacoesNull = str_replace('Pes.`genero`', 			'NULL', $informacoesNull);
    	$informacoesNull = str_replace('Pes.`data_nascimento`', 'NULL', $informacoesNull);
    	$informacoesNull = str_replace('Pes.`telefone_1`', 		'NULL', $informacoesNull);
    	$informacoesNull = str_replace('Pes.`telefone_2`', 		'NULL', $informacoesNull);
    	$informacoesNull = str_replace('Pes.`ativo_inativo`', 	'NULL', $informacoesNull);
    	$informacoesNull = str_replace('Pes.`logradouro`', 		'NULL', $informacoesNull);
    	$informacoesNull = str_replace('Pes.`numero`', 			'NULL', $informacoesNull);
    	$informacoesNull = str_replace('Pes.`bairro`', 			'NULL', $informacoesNull);
    	$informacoesNull = str_replace('Pes.`cep`', 			'NULL', $informacoesNull);
    	$informacoesNull = str_replace('Pes.`complemento`', 	'NULL', $informacoesNull);
    	$informacoesNull = str_replace('Cid.`nome`', 			'NULL', $informacoesNull);
    	$informacoesNull = str_replace('Est.`sigla`', 			'NULL', $informacoesNull);
    	$informacoesNull = str_replace('Fun.`funcao`', 			'NULL', $informacoesNull);

    	return $informacoesNull;
	}

	private function rmEdu($dados)
	{
    	$informacoesNull = str_replace('Cid.`nome`', 			'NULL', $dados);
    	$informacoesNull = str_replace('Est.`sigla`', 			'NULL', $informacoesNull);

    	return $informacoesNull;
	}
}

/* End of file relatorio_dinamico_m.php */
/* Location: ./application/models/relatorio_dinamico_m.php */