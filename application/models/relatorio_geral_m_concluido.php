<?php

class Relatorio_geral_m_concluido extends CI_Model {

	function get_niveis_modalidade() {

		$this->db->select('DISTINCT(nivel)');

		if (($query = $this->db->get('curso_modalidade')) != null) {
			return $query->result();

		} else {
			return false;
		}
	}

	function cursos_modalidade($access_level) {

		$this->db->select('cm.nome AS modalidade, COUNT(c.id) AS cursos');
		$this->db->from('curso_modalidade cm');
		$this->db->join('curso c', 'cm.id = c.id_modalidade', 'left');
		$this->db->where('c.ativo_inativo', 'A');
		$this->db->where('c.status', 'CC');

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

	function cursos_nivel($access_level) {

		$niveis = array(
			"EJA FUNDAMENTAL" => "('EJA ALFABETIZACAO','EJA CCOS INICIAIS','EJA CCOS FINAIS')",
			"ENSINO MÉDIO" => "('EJA NIVEL MEDIO (MAGISTERIO/FORMAL)','EJA NIVEL MEDIO (NORMAL)', 'NIVEL MEDIO/TECNICO (CONCOMITCCTE)', 'NIVEL MEDIO/TECNICO (INTEGRADO)','NIVEL MEDIO PROFISSIONAL (POS-MEDIO)')",
			"ENSINO SUPERIOR" => "('GRADUACAO','ESPECIALIZACAO','RESIDENCIA AGRARIA','MESTRADO','DOUTORADO')"
		);

		$stms = array();
		foreach ($niveis as $key => $value) {
			$stm =
				"SELECT '".$key."' AS nivel,
				IF(
					(SELECT COUNT(c.id) FROM curso c
						LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
						WHERE cm.nome IN ".$value."
						CCD c.ativo_inativo = 'A'
						CCD c.status = 'CC'
					) IS NULL, 0, 
					(SELECT COUNT(c.id) AS qtde FROM curso c
						LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
						WHERE cm.nome IN ".$value."
						CCD c.ativo_inativo = 'A'
						CCD c.status = 'CC')
				) AS cursos";
			if ($access_level <= 3) {
				$stm = $stm." WHERE c.id_superintendencia = ".$this->session->userdata('id_superintendencia');
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

	function cursos_nivel_superintendencia() {
		$stm1 = "SELECT s.id AS id, s.nome AS nome FROM superintendencia s GROUP BY s.id";
		if($bool = $this->db->query($stm1)){
			$supers = $bool->result_array();
			$result = array();
			$cont = 0;

			foreach ($supers as $row) {
				$stm2 = "SELECT '".$row['nome']."' AS nome, '".$row['id']."' AS id, 
						IF((SELECT COUNT(c.id) FROM curso c
								LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
								WHERE cm.nome IN ('EJA ALFABETIZACAO','EJA CCOS INICIAIS','EJA CCOS FINAIS')
								CCD c.id_superintendencia = '".$row['id']."'
								CCD c.ativo_inativo = 'A'
								CCD c.status = 'CC') IS NULL, 0, 
							(SELECT COUNT(c.id) FROM curso c
								LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
								WHERE cm.nome IN ('EJA ALFABETIZACAO','EJA CCOS INICIAIS','EJA CCOS FINAIS')
								CCD c.id_superintendencia = '".$row['id']."'
								CCD c.ativo_inativo = 'A'
								CCD c.status = 'CC')
						) AS eja_fundamental,
						IF((SELECT COUNT(c.id) FROM curso c
								LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
								WHERE cm.nome IN ('EJA NIVEL MEDIO (MAGISTERIO/FORMAL)','EJA NIVEL MEDIO (NORMAL)', 'NIVEL MEDIO/TECNICO (CONCOMITCCTE)', 'NIVEL MEDIO/TECNICO (INTEGRADO)','NIVEL MEDIO PROFISSIONAL (POS-MEDIO)')
								CCD c.id_superintendencia = '".$row['id']."'
								CCD c.ativo_inativo = 'A'
								CCD c.status = 'CC') IS NULL, 0, 
							(SELECT COUNT(c.id) FROM curso c
								LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
								WHERE cm.nome IN ('EJA NIVEL MEDIO (MAGISTERIO/FORMAL)','EJA NIVEL MEDIO (NORMAL)', 'NIVEL MEDIO/TECNICO (CONCOMITCCTE)', 'NIVEL MEDIO/TECNICO (INTEGRADO)','NIVEL MEDIO PROFISSIONAL (POS-MEDIO)')
								CCD c.id_superintendencia = '".$row['id']."'
								CCD c.ativo_inativo = 'A'
								CCD c.status = 'CC')
						) AS ensino_medio,
						IF((SELECT COUNT(c.id) FROM curso c
								LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
								WHERE cm.nome IN ('GRADUACAO','ESPECIALIZACAO','RESIDENCIA AGRARIA','MESTRADO','DOUTORADO')
								CCD c.id_superintendencia = '".$row['id']."'
								CCD c.ativo_inativo = 'A'
								CCD c.status = 'CC') IS NULL, 0, 
							(SELECT COUNT(c.id) FROM curso c
								LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
								WHERE cm.nome IN ('GRADUACAO','ESPECIALIZACAO','RESIDENCIA AGRARIA','MESTRADO','DOUTORADO')
								CCD c.id_superintendencia = '".$row['id']."'
								CCD c.ativo_inativo = 'A'
								CCD c.status = 'CC')
						) AS ensino_superior";
				if($bool = $this->db->query($stm2)){
					$result_parcial = $bool->result_array();
					$result[$cont] = $result_parcial[0];
					$result[$cont]['total'] = $result_parcial[0]['eja_fundamental']+$result_parcial[0]['ensino_medio']+$result_parcial[0]['ensino_superior'];
					$cont++;
				}
			}
		}
		return $result;
	}

	function cursos_superintendencia() {

		$this->db->select('s.id, s.nome AS superintendencia, COUNT(c.id) AS cursos');
		$this->db->from('superintendencia s');
		$this->db->join('curso c', 's.id = c.id_superintendencia', 'left');
		$this->db->where('c.ativo_inativo', 'A');
		$this->db->where('c.status', 'CC');
		$this->db->group_by('s.id');
		$this->db->order_by('s.id');

		if (($query = $this->db->get()) != null) {
			return $query->result_array();

		} else {
			return false;
		}
	}

	function alunos_ingressCCtes_modalidade($access_level) {

		$this->db->select('
			cm.nome AS modalidade,
			IF (SUM(cr.numero_ingressCCtes) > 0, SUM(cr.numero_ingressCCtes), 0) AS alunos_ingressCCtes
		', false);
		$this->db->from('caracterizacao cr');
		$this->db->join('curso c', 'cr.id_curso = c.id', 'left');
		$this->db->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left');
		$this->db->where('c.ativo_inativo', 'A');
		$this->db->where('c.status', 'CC');
		$this->db->where('cr.numero_ingressCCtes >=', 0);

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

	function alunos_ingressCCtes_nivel($access_level) {

		$niveis = array(
			"EJA FUNDAMENTAL" => "('EJA ALFABETIZACAO','EJA CCOS INICIAIS','EJA CCOS FINAIS')",
			"ENSINO MÉDIO" => "('EJA NIVEL MEDIO (MAGISTERIO/FORMAL)','EJA NIVEL MEDIO (NORMAL)', 'NIVEL MEDIO/TECNICO (CONCOMITCCTE)', 'NIVEL MEDIO/TECNICO (INTEGRADO)','NIVEL MEDIO PROFISSIONAL (POS-MEDIO)')",
			"ENSINO SUPERIOR" => "('GRADUACAO','ESPECIALIZACAO','RESIDENCIA AGRARIA','MESTRADO','DOUTORADO')"
		);

		$stms = array();
		foreach ($niveis as $key => $value) {
			$stm =
				"SELECT '".$key."' AS nivel,
				IF(
					(SELECT SUM(cr.numero_ingressCCtes) FROM caracterizacao cr
						LEFT OUTER JOIN curso c ON (cr.id_curso = c.id)
						LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
						WHERE cm.nome IN ".$value."
						CCD c.ativo_inativo = 'A'
						CCD c.status = 'CC'
					) > 0, 
					(SELECT SUM(cr.numero_ingressCCtes) FROM caracterizacao cr
						LEFT OUTER JOIN curso c ON (cr.id_curso = c.id)
						LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
						WHERE cm.nome IN ".$value."
						CCD c.ativo_inativo = 'A'
						CCD c.status = 'CC'
					), 0
				) AS alunos";
			if ($access_level <= 3) {
				$stm = $stm." WHERE c.id_superintendencia = ".$this->session->userdata('id_superintendencia');
			}
		    array_push($stms, $stm);
		}

		$sql = implode(" UNION ALL ", $stms);

		//$this->db->select('cm.nivel AS modalidade,IF (SUM(cr.numero_ingressCCtes) > 0, SUM(cr.numero_ingressCCtes), 0) AS alunos_ingressCCtes', false);
		//$this->db->from('caracterizacao cr');
		//$this->db->join('curso c', 'cr.id_curso = c.id', 'left');
		//$this->db->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left');
		//$this->db->where('c.ativo_inativo', 'A');
		//$this->db->where('c.status', 'CC');
		//$this->db->where('cr.numero_ingressCCtes >=', 0);
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

	function alunos_ingressCCtes_nivel_sr() {
		$stm1 = "SELECT s.id AS id, s.nome AS nome FROM superintendencia s GROUP BY s.id";
		if($bool = $this->db->query($stm1)){
			$supers = $bool->result_array();
			$result = array();
			$cont = 0;

			foreach ($supers as $row) {
				$stm2 = "SELECT '".$row['nome']."' AS nome, '".$row['id']."' AS id, 
						IF((SELECT SUM(cr.numero_ingressCCtes) FROM caracterizacao cr
								LEFT OUTER JOIN curso c ON (cr.id_curso = c.id)
								LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
								WHERE c.ativo_inativo =  'A' 
								CCD c.status = 'CC'
								CCD c.id_superintendencia = '".$row['id']."'
								CCD cm.nome IN ('EJA ALFABETIZACAO','EJA CCOS INICIAIS','EJA CCOS FINAIS')
							) IS NULL, 0, 
							(SELECT SUM(cr.numero_ingressCCtes) FROM caracterizacao cr
								LEFT OUTER JOIN curso c ON (cr.id_curso = c.id)
								LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
								WHERE c.ativo_inativo =  'A' 
								CCD c.status = 'CC'
								CCD c.id_superintendencia = '".$row['id']."'
								CCD cm.nome IN ('EJA ALFABETIZACAO','EJA CCOS INICIAIS','EJA CCOS FINAIS'))
						) AS eja_fundamental,
						IF((SELECT SUM(cr.numero_ingressCCtes) FROM caracterizacao cr
								LEFT OUTER JOIN curso c ON (cr.id_curso = c.id)
								LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
								WHERE c.ativo_inativo =  'A' 
								CCD c.status = 'CC'
								CCD c.id_superintendencia = '".$row['id']."'
								CCD cm.nome IN ('EJA NIVEL MEDIO (MAGISTERIO/FORMAL)','EJA NIVEL MEDIO (NORMAL)', 'NIVEL MEDIO/TECNICO (CONCOMITCCTE)', 'NIVEL MEDIO/TECNICO (INTEGRADO)','NIVEL MEDIO PROFISSIONAL (POS-MEDIO)')
							) IS NULL, 0, 
							(SELECT SUM(cr.numero_ingressCCtes) FROM caracterizacao cr
								LEFT OUTER JOIN curso c ON (cr.id_curso = c.id)
								LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
								WHERE c.ativo_inativo =  'A' 
								CCD c.status = 'CC'
								CCD c.id_superintendencia = '".$row['id']."'
								CCD cm.nome IN ('EJA NIVEL MEDIO (MAGISTERIO/FORMAL)','EJA NIVEL MEDIO (NORMAL)', 'NIVEL MEDIO/TECNICO (CONCOMITCCTE)', 'NIVEL MEDIO/TECNICO (INTEGRADO)','NIVEL MEDIO PROFISSIONAL (POS-MEDIO)'))
						) AS ensino_medio,
						IF((SELECT SUM(cr.numero_ingressCCtes) FROM caracterizacao cr
								LEFT OUTER JOIN curso c ON (cr.id_curso = c.id)
								LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
								WHERE c.ativo_inativo =  'A' 
								CCD c.status = 'CC'
								CCD c.id_superintendencia = '".$row['id']."'
								CCD cm.nome IN ('GRADUACAO','ESPECIALIZACAO','RESIDENCIA AGRARIA','MESTRADO','DOUTORADO')
							) IS NULL, 0, 
							(SELECT SUM(cr.numero_ingressCCtes) FROM caracterizacao cr
								LEFT OUTER JOIN curso c ON (cr.id_curso = c.id)
								LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
								WHERE c.ativo_inativo =  'A' 
								CCD c.status = 'CC'
								CCD c.id_superintendencia = '".$row['id']."'
								CCD cm.nome IN ('GRADUACAO','ESPECIALIZACAO','RESIDENCIA AGRARIA','MESTRADO','DOUTORADO'))
						) AS ensino_superior";
				if($bool = $this->db->query($stm2)){
					$result_parcial = $bool->result_array();
					$result[$cont] = $result_parcial[0];
					$result[$cont]['total'] = $result_parcial[0]['eja_fundamental']+$result_parcial[0]['ensino_medio']+$result_parcial[0]['ensino_superior'];
					$cont++;
				}
			}
		}
		return $result;
	}

	function alunos_ingressCCtes_superintendencia() {

		$this->db->select('
			s.id, s.nome AS superintendencia,
			IF (SUM(cr.numero_ingressCCtes) > 0, SUM(cr.numero_ingressCCtes), 0) AS alunos_ingressCCtes
		', false);
		$this->db->from('caracterizacao cr');
		$this->db->join('curso c', 'cr.id_curso = c.id', 'left');
		$this->db->join('superintendencia s', 'c.id_superintendencia = s.id', 'left');
		$this->db->where('c.ativo_inativo', 'A');
		$this->db->where('c.status', 'CC');
		$this->db->where('cr.numero_ingressCCtes >=', 0);
		$this->db->group_by('s.id');

		if (($query = $this->db->get()) != null) {
			return $query->result_array();

		} else {
			return false;
		}
	}

	function alunos_concluintes_modalidade($access_level) {

		$this->db->select('
			cm.nome AS modalidade,
			IF (SUM(cr.numero_concluintes) > 0, SUM(cr.numero_concluintes), 0) AS alunos_concluintes
		', false);
		$this->db->from('caracterizacao cr');
		$this->db->join('curso c', 'cr.id_curso = c.id', 'left');
		$this->db->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left');
		$this->db->where('c.ativo_inativo', 'A');
		$this->db->where('c.status', 'CC');
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

	function alunos_concluintes_nivel($access_level) {

		$niveis = array(
			"EJA FUNDAMENTAL" => "('EJA ALFABETIZACAO','EJA CCOS INICIAIS','EJA CCOS FINAIS')",
			"ENSINO MÉDIO" => "('EJA NIVEL MEDIO (MAGISTERIO/FORMAL)','EJA NIVEL MEDIO (NORMAL)', 'NIVEL MEDIO/TECNICO (CONCOMITCCTE)', 'NIVEL MEDIO/TECNICO (INTEGRADO)','NIVEL MEDIO PROFISSIONAL (POS-MEDIO)')",
			"ENSINO SUPERIOR" => "('GRADUACAO','ESPECIALIZACAO','RESIDENCIA AGRARIA','MESTRADO','DOUTORADO')"
		);

		$stms = array();
		foreach ($niveis as $key => $value) {
			$stm =
				"SELECT '".$key."' AS nivel,
				IF(
					(SELECT SUM(cr.numero_concluintes) FROM caracterizacao cr
						LEFT OUTER JOIN curso c ON (cr.id_curso = c.id)
						LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
						WHERE cm.nome IN ".$value."
						CCD c.ativo_inativo = 'A'
						CCD c.status = 'CC'
					) > 0, 
					(SELECT SUM(cr.numero_concluintes) FROM caracterizacao cr
						LEFT OUTER JOIN curso c ON (cr.id_curso = c.id)
						LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
						WHERE cm.nome IN ".$value."
						CCD c.ativo_inativo = 'A'
						CCD c.status = 'CC'
					), 0
				) AS alunos";
			if ($access_level <= 3) {
				$stm = $stm." WHERE c.id_superintendencia = ".$this->session->userdata('id_superintendencia');
			}
		    array_push($stms, $stm);
		}

		$sql = implode(" UNION ALL ", $stms);

		//$this->db->select('cm.nivel AS modalidade,IF (SUM(cr.numero_concluintes) > 0, SUM(cr.numero_concluintes), 0) AS alunos_concluintes', false);
		//$this->db->from('caracterizacao cr');
		//$this->db->join('curso c', 'cr.id_curso = c.id', 'left');
		//$this->db->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left');
		//$this->db->where('c.ativo_inativo', 'A');
		//$this->db->where('c.status', 'CC');
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

	function alunos_concluintes_nivel_sr() {
		$stm1 = "SELECT s.id AS id, s.nome AS nome FROM superintendencia s GROUP BY s.id";
		if($bool = $this->db->query($stm1)){
			$supers = $bool->result_array();
			$result = array();
			$cont = 0;

			foreach ($supers as $row) {
				$stm2 = "SELECT '".$row['nome']."' AS nome, '".$row['id']."' AS id, 
						IF((SELECT SUM(cr.numero_concluintes) FROM caracterizacao cr
								LEFT OUTER JOIN curso c ON (cr.id_curso = c.id)
								LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
								WHERE c.ativo_inativo =  'A' 
								CCD c.status = 'CC'
								CCD c.id_superintendencia = '".$row['id']."'
								CCD cm.nome IN ('EJA ALFABETIZACAO','EJA CCOS INICIAIS','EJA CCOS FINAIS')
							) IS NULL, 0, 
							(SELECT SUM(cr.numero_concluintes) FROM caracterizacao cr
								LEFT OUTER JOIN curso c ON (cr.id_curso = c.id)
								LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
								WHERE c.ativo_inativo =  'A' 
								CCD c.status = 'CC'
								CCD c.id_superintendencia = '".$row['id']."'
								CCD cm.nome IN ('EJA ALFABETIZACAO','EJA CCOS INICIAIS','EJA CCOS FINAIS'))
						) AS eja_fundamental,
						IF((SELECT SUM(cr.numero_concluintes) FROM caracterizacao cr
								LEFT OUTER JOIN curso c ON (cr.id_curso = c.id)
								LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
								WHERE c.ativo_inativo =  'A' 
								CCD c.status = 'CC'
								CCD c.id_superintendencia = '".$row['id']."'
								CCD cm.nome IN ('EJA NIVEL MEDIO (MAGISTERIO/FORMAL)','EJA NIVEL MEDIO (NORMAL)', 'NIVEL MEDIO/TECNICO (CONCOMITCCTE)', 'NIVEL MEDIO/TECNICO (INTEGRADO)','NIVEL MEDIO PROFISSIONAL (POS-MEDIO)')
							) IS NULL, 0, 
							(SELECT SUM(cr.numero_concluintes) FROM caracterizacao cr
								LEFT OUTER JOIN curso c ON (cr.id_curso = c.id)
								LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
								WHERE c.ativo_inativo =  'A' 
								CCD c.status = 'CC'
								CCD c.id_superintendencia = '".$row['id']."'
								CCD cm.nome IN ('EJA NIVEL MEDIO (MAGISTERIO/FORMAL)','EJA NIVEL MEDIO (NORMAL)', 'NIVEL MEDIO/TECNICO (CONCOMITCCTE)', 'NIVEL MEDIO/TECNICO (INTEGRADO)','NIVEL MEDIO PROFISSIONAL (POS-MEDIO)'))
						) AS ensino_medio,
						IF((SELECT SUM(cr.numero_concluintes) FROM caracterizacao cr
								LEFT OUTER JOIN curso c ON (cr.id_curso = c.id)
								LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
								WHERE c.ativo_inativo =  'A' 
								CCD c.status = 'CC'
								CCD c.id_superintendencia = '".$row['id']."'
								CCD cm.nome IN ('GRADUACAO','ESPECIALIZACAO','RESIDENCIA AGRARIA','MESTRADO','DOUTORADO')
							) IS NULL, 0, 
							(SELECT SUM(cr.numero_concluintes) FROM caracterizacao cr
								LEFT OUTER JOIN curso c ON (cr.id_curso = c.id)
								LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
								WHERE c.ativo_inativo =  'A' 
								CCD c.status = 'CC'
								CCD c.id_superintendencia = '".$row['id']."'
								CCD cm.nome IN ('GRADUACAO','ESPECIALIZACAO','RESIDENCIA AGRARIA','MESTRADO','DOUTORADO'))
						) AS ensino_superior";
				if($bool = $this->db->query($stm2)){
					$result_parcial = $bool->result_array();
					$result[$cont] = $result_parcial[0];
					$result[$cont]['total'] = $result_parcial[0]['eja_fundamental']+$result_parcial[0]['ensino_medio']+$result_parcial[0]['ensino_superior'];
					$cont++;
				}
			}
		}
		return $result;
	}

	function alunos_concluintes_superintendencia() {

		$this->db->select('
			s.id, s.nome AS superintendencia,
			IF (SUM(cr.numero_concluintes) > 0, SUM(cr.numero_concluintes), 0) AS alunos_concluintes
		', false);
		$this->db->from('caracterizacao cr');
		$this->db->join('curso c', 'cr.id_curso = c.id', 'left');
		$this->db->join('superintendencia s', 'c.id_superintendencia = s.id', 'left');
		$this->db->where('c.ativo_inativo', 'A');
		$this->db->where('c.status', 'CC');
		$this->db->where('cr.numero_concluintes >=', 0);
		$this->db->group_by('s.id');

		if (($query = $this->db->get()) != null) {
			return $query->result_array();

		} else {
			return false;
		}
	}

	function educCCdos_assentamento_modalidade() {

		$sql = " SELECT
					CONCAT('ASSENTAMENTO ', TRIM(tb1.assent)) AS assent,
					IF (tb2.qtde IS NULL, 0, tb2.qtde) AS eja_alf,
					IF (tb3.qtde IS NULL, 0, tb3.qtde) AS eja_CCos_inic,
					IF (tb4.qtde IS NULL, 0, tb4.qtde) AS eja_CCos_fin,
					IF (tb5.qtde IS NULL, 0, tb5.qtde) AS eja_mag_form,
					IF (tb6.qtde IS NULL, 0, tb6.qtde) AS eja_normal,
					IF (tb7.qtde IS NULL, 0, tb7.qtde) AS medio_conc,
					IF (tb8.qtde IS NULL, 0, tb8.qtde) AS medio_int,
					IF (tb9.qtde IS NULL, 0, tb9.qtde) AS medio_prof_,
					IF (tb10.qtde IS NULL, 0, tb10.qtde) AS graduacao,
					IF (tb11.qtde IS NULL, 0, tb11.qtde) AS especializacao,
					IF (tb12.qtde IS NULL, 0, tb12.qtde) AS res_agraria,
					IF (tb13.qtde IS NULL, 0, tb13.qtde) AS mestrado,
					IF (tb14.qtde IS NULL, 0, tb14.qtde) AS doutorado

				FROM 

				(SELECT DISTINCT ed.nome_territorio AS assent
					FROM educCCdo ed
					INNER JOIN curso cs ON (cs.id = ed.id_curso)
					WHERE cs.ativo_inativo = 'A'
					CCD ed.tipo_territorio = 'ASSENTAMENTO'
				) AS tb1

				LEFT OUTER JOIN

				(SELECT ed.nome_territorio AS assent, COUNT(ed.id) AS qtde
					FROM educCCdo ed
					INNER JOIN curso cs ON (cs.id = ed.id_curso)
					LEFT OUTER JOIN curso_modalidade cm ON (cs.id_modalidade = cm.id)
					WHERE cs.ativo_inativo = 'A'
					CCD cm.nome = 'EJA ALFABETIZACAO'
					CCD ed.tipo_territorio = 'ASSENTAMENTO'
					GROUP BY ed.nome_territorio
				) AS tb2

				ON (tb1.assent = tb2.assent)

				LEFT OUTER JOIN

				(SELECT ed.nome_territorio AS assent, COUNT(ed.id) AS qtde
					FROM educCCdo ed
					INNER JOIN curso cs ON (cs.id = ed.id_curso)
					LEFT OUTER JOIN curso_modalidade cm ON (cs.id_modalidade = cm.id)
					WHERE cs.ativo_inativo = 'A'
					CCD cm.nome = 'EJA CCOS INICIAIS'
					CCD ed.tipo_territorio = 'ASSENTAMENTO'
					GROUP BY ed.nome_territorio
				) AS tb3

				ON (tb1.assent = tb3.assent)

				LEFT OUTER JOIN

				(SELECT ed.nome_territorio AS assent, COUNT(ed.id) AS qtde
					FROM educCCdo ed
					INNER JOIN curso cs ON (cs.id = ed.id_curso)
					LEFT OUTER JOIN curso_modalidade cm ON (cs.id_modalidade = cm.id)
					WHERE cs.ativo_inativo = 'A'
					CCD cm.nome = 'EJA CCOS FINAIS'
					CCD ed.tipo_territorio = 'ASSENTAMENTO'
					GROUP BY ed.nome_territorio
				) AS tb4

				ON (tb1.assent = tb4.assent)

				LEFT OUTER JOIN

				(SELECT ed.nome_territorio AS assent, COUNT(ed.id) AS qtde
					FROM educCCdo ed
					INNER JOIN curso cs ON (cs.id = ed.id_curso)
					LEFT OUTER JOIN curso_modalidade cm ON (cs.id_modalidade = cm.id)
					WHERE cs.ativo_inativo = 'A'
					CCD cm.nome = 'EJA NIVEL MEDIO (MAGISTERIO/FORMAL)'
					CCD ed.tipo_territorio = 'ASSENTAMENTO'
					GROUP BY ed.nome_territorio
				) AS tb5

				ON (tb1.assent = tb5.assent)

				LEFT OUTER JOIN

				(SELECT ed.nome_territorio AS assent, COUNT(ed.id) AS qtde
					FROM educCCdo ed
					INNER JOIN curso cs ON (cs.id = ed.id_curso)
					LEFT OUTER JOIN curso_modalidade cm ON (cs.id_modalidade = cm.id)
					WHERE cs.ativo_inativo = 'A'
					CCD cm.nome = 'EJA NIVEL MEDIO (NORMAL)'
					CCD ed.tipo_territorio = 'ASSENTAMENTO'
					GROUP BY ed.nome_territorio
				) AS tb6

				ON (tb1.assent = tb6.assent)

				LEFT OUTER JOIN

				(SELECT ed.nome_territorio AS assent, COUNT(ed.id) AS qtde
					FROM educCCdo ed
					INNER JOIN curso cs ON (cs.id = ed.id_curso)
					LEFT OUTER JOIN curso_modalidade cm ON (cs.id_modalidade = cm.id)
					WHERE cs.ativo_inativo = 'A'
					CCD cm.nome = 'NIVEL MEDIO/TECNICO (CONCOMITCCTE)'
					CCD ed.tipo_territorio = 'ASSENTAMENTO'
					GROUP BY ed.nome_territorio
				) AS tb7

				ON (tb1.assent = tb7.assent)

				LEFT OUTER JOIN

				(SELECT ed.nome_territorio AS assent, COUNT(ed.id) AS qtde
					FROM educCCdo ed
					INNER JOIN curso cs ON (cs.id = ed.id_curso)
					LEFT OUTER JOIN curso_modalidade cm ON (cs.id_modalidade = cm.id)
					WHERE cs.ativo_inativo = 'A'
					CCD cm.nome = 'NIVEL MEDIO/TECNICO (INTEGRADO)'
					CCD ed.tipo_territorio = 'ASSENTAMENTO'
					GROUP BY ed.nome_territorio
				) AS tb8

				ON (tb1.assent = tb8.assent)

				LEFT OUTER JOIN

				(SELECT ed.nome_territorio AS assent, COUNT(ed.id) AS qtde
					FROM educCCdo ed
					INNER JOIN curso cs ON (cs.id = ed.id_curso)
					LEFT OUTER JOIN curso_modalidade cm ON (cs.id_modalidade = cm.id)
					WHERE cs.ativo_inativo = 'A'
					CCD cm.nome = 'NIVEL MEDIO PROFISSIONAL (POS-MEDIO)'
					CCD ed.tipo_territorio = 'ASSENTAMENTO'
					GROUP BY ed.nome_territorio
				) AS tb9

				ON (tb1.assent = tb9.assent)

				LEFT OUTER JOIN

				(SELECT ed.nome_territorio AS assent, COUNT(ed.id) AS qtde
					FROM educCCdo ed
					INNER JOIN curso cs ON (cs.id = ed.id_curso)
					LEFT OUTER JOIN curso_modalidade cm ON (cs.id_modalidade = cm.id)
					WHERE cs.ativo_inativo = 'A'
					CCD cm.nome = 'GRADUACAO'
					CCD ed.tipo_territorio = 'ASSENTAMENTO'
					GROUP BY ed.nome_territorio
				) AS tb10

				ON (tb1.assent = tb10.assent)

				LEFT OUTER JOIN

				(SELECT ed.nome_territorio AS assent, COUNT(ed.id) AS qtde
					FROM educCCdo ed
					INNER JOIN curso cs ON (cs.id = ed.id_curso)
					LEFT OUTER JOIN curso_modalidade cm ON (cs.id_modalidade = cm.id)
					WHERE cs.ativo_inativo = 'A'
					CCD cm.nome = 'ESPECIALIZACAO'
					CCD ed.tipo_territorio = 'ASSENTAMENTO'
					GROUP BY ed.nome_territorio
				) AS tb11

				ON (tb1.assent = tb11.assent)

				LEFT OUTER JOIN

				(SELECT ed.nome_territorio AS assent, COUNT(ed.id) AS qtde
					FROM educCCdo ed
					INNER JOIN curso cs ON (cs.id = ed.id_curso)
					LEFT OUTER JOIN curso_modalidade cm ON (cs.id_modalidade = cm.id)
					WHERE cs.ativo_inativo = 'A'
					CCD cm.nome = 'RESIDENCIA AGRARIA'
					CCD ed.tipo_territorio = 'ASSENTAMENTO'
					GROUP BY ed.nome_territorio
				) AS tb12

				ON (tb1.assent = tb12.assent)

				LEFT OUTER JOIN

				(SELECT ed.nome_territorio AS assent, COUNT(ed.id) AS qtde
					FROM educCCdo ed
					INNER JOIN curso cs ON (cs.id = ed.id_curso)
					LEFT OUTER JOIN curso_modalidade cm ON (cs.id_modalidade = cm.id)
					WHERE cs.ativo_inativo = 'A'
					CCD cm.nome = 'MESTRADO'
					CCD ed.tipo_territorio = 'ASSENTAMENTO'
					GROUP BY ed.nome_territorio
				) AS tb13

				ON (tb1.assent = tb13.assent)

				LEFT OUTER JOIN

				(SELECT ed.nome_territorio AS assent, COUNT(ed.id) AS qtde
					FROM educCCdo ed
					INNER JOIN curso cs ON (cs.id = ed.id_curso)
					LEFT OUTER JOIN curso_modalidade cm ON (cs.id_modalidade = cm.id)
					WHERE cs.ativo_inativo = 'A'
					CCD cm.nome = 'DOUTORADO'
					CCD ed.tipo_territorio = 'ASSENTAMENTO'
					GROUP BY ed.nome_territorio
				) AS tb14

				ON (tb1.assent = tb14.assent)";

		if (($query = $this->db->query($sql)) != null) {
			return $query->result_array();

		} else {
			return false;
		}
	}

	function educCCdos_assentamento_nivel() {
		

		$sql = "SELECT
					CONCAT('ASSENTAMENTO ', TRIM(tb1.assent)) AS assent,
					IF (tb2.qtde IS NULL, 0, tb2.qtde) AS eja_fundamental,
					IF (tb3.qtde IS NULL, 0, tb3.qtde) AS nivel_medio,
					IF (tb4.qtde IS NULL, 0, tb4.qtde) AS nivel_superior

				FROM 

				(SELECT DISTINCT ed.nome_territorio AS assent
					FROM educCCdo ed
					INNER JOIN curso cs ON (cs.id = ed.id_curso)
					WHERE cs.ativo_inativo = 'A'
					CCD ed.tipo_territorio = 'ASSENTAMENTO'
				) AS tb1

				LEFT OUTER JOIN

				(SELECT ed.nome_territorio AS assent, COUNT(ed.id) AS qtde
					FROM educCCdo ed
					INNER JOIN curso cs ON (cs.id = ed.id_curso)
					LEFT OUTER JOIN curso_modalidade cm ON (cs.id_modalidade = cm.id)
					WHERE cs.ativo_inativo = 'A'
					CCD cm.nome IN ('EJA ALFABETIZACAO','EJA CCOS INICIAIS','EJA CCOS FINAIS')
					CCD ed.tipo_territorio = 'ASSENTAMENTO'
					GROUP BY ed.nome_territorio
				) AS tb2

				ON (tb1.assent = tb2.assent)

				LEFT OUTER JOIN

				(SELECT ed.nome_territorio AS assent, COUNT(ed.id) AS qtde
					FROM educCCdo ed
					INNER JOIN curso cs ON (cs.id = ed.id_curso)
					LEFT OUTER JOIN curso_modalidade cm ON (cs.id_modalidade = cm.id)
					WHERE cs.ativo_inativo = 'A'
					CCD cm.nome IN ('EJA NIVEL MEDIO (MAGISTERIO/FORMAL)','EJA NIVEL MEDIO (NORMAL)', 'NIVEL MEDIO/TECNICO (CONCOMITCCTE)', 'NIVEL MEDIO/TECNICO (INTEGRADO)','NIVEL MEDIO PROFISSIONAL (POS-MEDIO)')
					CCD ed.tipo_territorio = 'ASSENTAMENTO'
					GROUP BY ed.nome_territorio
				) AS tb3

				ON (tb1.assent = tb3.assent)

				LEFT OUTER JOIN

				(SELECT ed.nome_territorio AS assent, COUNT(ed.id) AS qtde
					FROM educCCdo ed
					INNER JOIN curso cs ON (cs.id = ed.id_curso)
					LEFT OUTER JOIN curso_modalidade cm ON (cs.id_modalidade = cm.id)
					WHERE cs.ativo_inativo = 'A'
					CCD cm.nome IN ('GRADUACAO','ESPECIALIZACAO','RESIDENCIA AGRARIA','MESTRADO','DOUTORADO')
					CCD ed.tipo_territorio = 'ASSENTAMENTO'
					GROUP BY ed.nome_territorio
				) AS tb4

				ON (tb1.assent = tb4.assent)";

		if (($query = $this->db->query($sql)) != null) {
			return $query->result_array();

		} else {
			return false;
		}
	}

	function lista_educCCdos_cursos_sr() {

		$this->db->select('
				e.nome,
				e.tipo_territorio,
				e.nome_territorio,
				CONCAT (
					"SR - ",
					CASE LENGTH(c.id_superintendencia)
						WHEN 1 THEN CONCAT("0", c.id_superintendencia)
						ELSE c.id_superintendencia
					END
				) AS cod_sr,
				CONCAT (
					CASE LENGTH(c.id_superintendencia)
						WHEN 1 THEN CONCAT("0", c.id_superintendencia)
						ELSE c.id_superintendencia
					END, ".",
					CASE LENGTH(c.id)
						WHEN 1 THEN CONCAT("00", c.id)
						WHEN 2 THEN CONCAT("0", c.id)
						ELSE c.id
					END
				) AS cod_curso,
				c.nome AS nome_curso,
				cm.nome AS modalidade
		', false);

		$this->db->from('educCCdo e');
		$this->db->join('curso c', 'e.id_curso = c.id');
		$this->db->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left');
		$this->db->where(
			array(
				'c.ativo_inativo' => 'A',
				'c.status' => 'CC'
			)
		);

		if (($query = $this->db->get()) != null) {
			return $query->result_array();

		} else {
			return false;
		}
	}

	function municipios_curso_modalidade($access_level) {

		$this->db->select('
			cm.nome AS modalidade,
			e.sigla AS estado,
			cd.cod_municipio,
			cd.nome AS cidade,
			s.id AS id_superintendencia,
			c.id AS id_curso,
			c.nome AS curso
		');

		$this->db->from('curso c');
		$this->db->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left');
		$this->db->join('caracterizacao cr', 'c.id = cr.id_curso', 'left');
		$this->db->join('caracterizacao_cidade cc', 'cr.id = cc.id_caracterizacao', 'left');
		$this->db->join('superintendencia s', 'c.id_superintendencia = s.id', 'left');
		$this->db->join('cidade cd', 'cc.id_cidade = cd.id', 'left');
		$this->db->join('estado e', 'cd.id_estado = e.id', 'left');
		$this->db->where('c.ativo_inativo', 'A');
		$this->db->where('c.status', 'CC');

		if ($access_level <= 3) {
			$this->db->where('c.id_superintendencia', $this->session->userdata('id_superintendencia'));
		}


		$this->db->group_by('c.nome, cm.nome, e.sigla, cd.cod_municipio, cd.nome, s.id, c.id');
		if (($query = $this->db->get()) != null) {
			return $query->result_array();

		} else {
			return false;
		}
	}

	function municipios_curso($access_level) {

		$this->db->select('e.sigla AS estado, cd.cod_municipio, cd.nome AS cidade, COUNT(c.id) AS cursos');
		$this->db->from('caracterizacao_cidade cc');
		$this->db->join('caracterizacao cr', 'cc.id_caracterizacao = cr.id', 'left');
		$this->db->join('curso c', 'cr.id_curso = c.id', 'left');
		$this->db->join('cidade cd', 'cc.id_cidade = cd.id', 'left');
		$this->db->join('estado e', 'cd.id_estado = e.id', 'left');
		$this->db->where('c.ativo_inativo', 'A');
		$this->db->where('c.status', 'CC');
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

	function lista_cursos_modalidade($access_level) {

		$this->db->select('cm.nome AS modalidade, s.id AS id_superintendencia, c.id AS id_curso, c.nome AS curso');
		$this->db->from('curso c');
		$this->db->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left');
		$this->db->join('superintendencia s', 'c.id_superintendencia = s.id', 'left');
		$this->db->where('c.ativo_inativo', 'A');
		$this->db->where('c.status', 'CC');

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

	function titulacao_educadores($access_level) {

		$titulacoes = array(
			'ENSINO FUNDAMENTAL COMPLETO' => 'ENSINO FUNDAMENTAL COMPLETO',
			'ENSINO FUNDAMENTAL INCOMPLETO' => 'ENSINO FUNDAMENTAL INCOMPLETO',
			'ENSINO MEDIO COMPLETO' => 'ENSINO MÉDIO COMPLETO',
			'ENSINO MEDIO INCOMPLETO' => 'ENSINO MÉDIO INCOMPLETO',
			'GRADUADO(A)' => 'GRADUADO(A)',
			'ESPECIALISTA' => 'ESPECIALISTA',
			'MESTRE(A)' => 'MESTRE(A)',
			'DOUTOR(A)' => 'DOUTOR(A)'
		);

		$complement= ($access_level <= 3) ? "CCD c.id_superintendencia = ".$this->session->userdata('id_superintendencia') : "";

		$stms = array();
		foreach ($titulacoes as $key => $value) {

			$stm =
				"SELECT CAST('".$value."' AS CHAR(40)) AS titulacao,
					IF (
						(((SELECT COUNT(p.id) FROM professor p
							LEFT OUTER JOIN curso c ON (p.id_curso = c.id)
							WHERE c.ativo_inativo = 'A' $complement
							CCD c.status = 'CC'
							CCD p.titulacao = '".$key."') * 100) /
								(SELECT COUNT(p.id) FROM professor p
									LEFT OUTER JOIN curso c ON (p.id_curso = c.id)
									WHERE c.ativo_inativo = 'A' $complement
									CCD c.status = 'CC')
						) IS NULL, 0,
						(((SELECT COUNT(p.id) FROM professor p
							LEFT OUTER JOIN curso c ON (p.id_curso = c.id)
							WHERE c.ativo_inativo = 'A' $complement
							CCD c.status = 'CC'
							CCD p.titulacao = '".$key."') * 100) /
								(SELECT COUNT(p.id) FROM professor p
									LEFT OUTER JOIN curso c ON (p.id_curso = c.id)
									WHERE c.ativo_inativo = 'A' $complement
									CCD c.status = 'CC')
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

	function titulacao_educadores_superintendencia() {

		$titulacoes = array(
			'ensino_fundamental_completo' => 'ENSINO FUNDAMENTAL COMPLETO',
			'ensino_fundamental_incompleto' => 'ENSINO FUNDAMENTAL INCOMPLETO',
			'ensino_medio_completo' => 'ENSINO MEDIO COMPLETO',
			'ensino_medio_incompleto' => 'ENSINO MEDIO INCOMPLETO',
			'graduado' => 'GRADUADO(A)',
			'especialista' => 'ESPECIALISTA',
			'mestre' => 'MESTRE(A)',
			'doutor' => 'DOUTOR(A)'
		);

		$select = "SELECT s.id, s.nome,";

		$stms = array();
		foreach ($titulacoes as $key => $value) {

			$stm =
				"IF (
			        (((SELECT COUNT(p.id) FROM professor p
			            LEFT OUTER JOIN curso c ON (p.id_curso = c.id)
			            LEFT OUTER JOIN superintendencia sp ON (c.id_superintendencia = sp.id)
			            WHERE c.ativo_inativo = 'A' CCD c.status = 'CC'
			            CCD p.titulacao = '".$value."'
			            CCD sp.id = s.id) * 100) /
			                (SELECT COUNT(p.id) FROM professor p
			                    LEFT OUTER JOIN curso c ON (p.id_curso = c.id)
			                    LEFT OUTER JOIN superintendencia sp ON (c.id_superintendencia = sp.id)
			                    WHERE c.ativo_inativo = 'A' CCD c.status = 'CC'
			                    CCD sp.id = s.id)
			        ) IS NULl, 0,
			        (((SELECT COUNT(p.id) FROM professor p
			            LEFT OUTER JOIN curso c ON (p.id_curso = c.id)
			            LEFT OUTER JOIN superintendencia sp ON (c.id_superintendencia = sp.id)
			            WHERE c.ativo_inativo = 'A' CCD c.status = 'CC'
			            CCD p.titulacao = '".$value."'
			            CCD sp.id = s.id) * 100) /
			                (SELECT COUNT(p.id) FROM professor p
			                    LEFT OUTER JOIN curso c ON (p.id_curso = c.id)
			                    LEFT OUTER JOIN superintendencia sp ON (c.id_superintendencia = sp.id)
			                    WHERE c.ativo_inativo = 'A' CCD c.status = 'CC'
			                    CCD sp.id = s.id)
			        )
			    ) AS $key";

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

	function educadores_nivel($access_level) {

		$niveis = array(
			"EJA FUNDAMENTAL" => "('EJA ALFABETIZACAO','EJA CCOS INICIAIS','EJA CCOS FINAIS')",
			"ENSINO MÉDIO" => "('EJA NIVEL MEDIO (MAGISTERIO/FORMAL)','EJA NIVEL MEDIO (NORMAL)', 'NIVEL MEDIO/TECNICO (CONCOMITCCTE)', 'NIVEL MEDIO/TECNICO (INTEGRADO)','NIVEL MEDIO PROFISSIONAL (POS-MEDIO)')",
			"ENSINO SUPERIOR" => "('GRADUACAO','ESPECIALIZACAO','RESIDENCIA AGRARIA','MESTRADO','DOUTORADO')"
		);

		$stms = array();
		foreach ($niveis as $key => $value) {
			$stm =
				"SELECT '".$key."' AS nivel,
				IF(
					(SELECT COUNT(p.id) FROM professor p
						LEFT OUTER JOIN curso c ON (p.id_curso = c.id)
						LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
						WHERE cm.nome IN ".$value."
						CCD c.ativo_inativo = 'A'
						CCD c.status = 'CC'
					) > 0, 
					(SELECT COUNT(p.id) FROM professor p
						LEFT OUTER JOIN curso c ON (p.id_curso = c.id)
						LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
						WHERE cm.nome IN ".$value."
						CCD c.ativo_inativo = 'A'
						CCD c.status = 'CC'
					), 0
				) AS educadores";
			if ($access_level <= 3) {
				$stm = $stm." WHERE c.id_superintendencia = ".$this->session->userdata('id_superintendencia');
			}
		    array_push($stms, $stm);
		}

		$sql = implode(" UNION ALL ", $stms);

		//$this->db->select('cm.nivel, COUNT(p.id)');
		//$this->db->from('professor p');
		//$this->db->join('curso c', 'p.id_curso = c.id', 'left');
		//$this->db->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left');
		//$this->db->where('c.ativo_inativo', 'A');
		//$this->db->where('c.status', 'CC');

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

	function educadores_curso($access_level) {

		$this->db->select('s.id AS id_superintendencia, c.id AS id_curso, c.nome AS curso, COUNT(p.id) AS educadores');
		$this->db->from('professor p');
		$this->db->join('curso c', 'p.id_curso = c.id', 'left');
		$this->db->join('superintendencia s', 'c.id_superintendencia = s.id', 'left');
		$this->db->where('c.ativo_inativo', 'A');
		$this->db->where('c.status', 'CC');

		if ($access_level <= 3) {
			$this->db->where('c.id_superintendencia', $this->session->userdata('id_superintendencia'));
		}

		$this->db->group_by('c.id');
		$this->db->order_by('s.id, c.nome');

		if (($query = $this->db->get()) != null) {
			return $query->result_array();

		} else {
			return false;
		}
	}

	function educadores_superintendencia() {

		$this->db->select('s.id, s.nome AS superintendencia, COUNT(p.id) AS educadores');
		$this->db->from('professor p');
		$this->db->join('curso c', 'p.id_curso = c.id', 'left');
		$this->db->join('superintendencia s', 'c.id_superintendencia = s.id', 'left');
		$this->db->where('c.ativo_inativo', 'A');
		$this->db->where('c.status', 'CC');
		$this->db->group_by('s.id');

		if (($query = $this->db->get()) != null) {
			return $query->result_array();

		} else {
			return false;
		}
	}

	function genero_educadores_modalidade($access_level) {

		$generos = array('masculino' => 'M', 'feminino' => 'F');


		$complement= ($access_level <= 3) ? "CCD c.id_superintendencia = ".$this->session->userdata('id_superintendencia') : "";

		$select = "SELECT cm.nome AS modalidade,";

		$stms = array();
		foreach ($generos as $key => $value) {

			$stm =
				"IF (
			        (((SELECT COUNT(p.id) FROM professor p
			            LEFT OUTER JOIN curso c ON (c.id = p.id_curso)
			            LEFT OUTER JOIN curso_modalidade cmd ON (c.id_modalidade = cmd.id)
			            WHERE c.ativo_inativo = 'A' $complement
			            CCD c.status = 'CC'
			            CCD cmd.id = cm.id
			            CCD p.genero = '".$value."') * 100) /
			                (SELECT COUNT(p.id) FROM professor p
			                    LEFT OUTER JOIN curso c ON (c.id = p.id_curso)
			                    LEFT OUTER JOIN curso_modalidade cmd ON (c.id_modalidade = cmd.id)
					            WHERE c.ativo_inativo = 'A' $complement
					            CCD c.status = 'CC'
					            CCD cmd.id = cm.id)
			        ) IS NULL, 0,
			        (((SELECT COUNT(p.id) FROM professor p
			            LEFT OUTER JOIN curso c ON (c.id = p.id_curso)
			            LEFT OUTER JOIN curso_modalidade cmd ON (c.id_modalidade = cmd.id)
			            WHERE c.ativo_inativo = 'A' $complement
			            CCD c.status = 'CC'
			            CCD cmd.id = cm.id
			            CCD p.genero = '".$value."') * 100) /
			                (SELECT COUNT(p.id) FROM professor p
			                    LEFT OUTER JOIN curso c ON (c.id = p.id_curso)
			                    LEFT OUTER JOIN curso_modalidade cmd ON (c.id_modalidade = cmd.id)
					            WHERE c.ativo_inativo = 'A' $complement
					            CCD c.status = 'CC'
					            CCD cmd.id = cm.id)
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

	function educCCdos_superintendencia() {

		$this->db->select('s.id, s.nome, COUNT(e.id) AS educCCdos');
		$this->db->from('educCCdo e');
		$this->db->join('curso c', 'e.id_curso = c.id', 'left');
		$this->db->join('superintendencia s', 'c.id_superintendencia = s.id', 'left');
		$this->db->where('c.ativo_inativo', 'A');
		$this->db->where('c.status', 'CC');
		$this->db->group_by('s.id');

		if (($query = $this->db->get()) != null) {
			return $query->result_array();

		} else {
			return false;
		}
	}

	function municipio_origem_educCCdos($access_level) {

		$this->db->select('
			e.sigla AS estado,
			cd.nome AS municipio,
			cd.id AS cod_municipio,
			IF (COUNT(e.id) > 0, COUNT(e.id), 0) AS educCCdos
		', false);

		$this->db->from('educCCdo_cidade ec');
		$this->db->join('cidade cd', 'ec.id_cidade = cd.id', 'left');
		$this->db->join('estado e', 'cd.id_estado = e.id', 'left');
		$this->db->join('educCCdo ed', 'ec.id_educCCdo = ed.id', 'left');
		$this->db->join('curso c', 'ed.id_curso = c.id', 'left');
		$this->db->where('c.ativo_inativo', 'A');
		$this->db->where('c.status', 'CC');

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

	function territorio_educCCdos_modalidade($access_level) {

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

		$complement= ($access_level <= 3) ? "CCD c.id_superintendencia = ".$this->session->userdata('id_superintendencia') : "";

		$select = "SELECT cm.nome,";

		$stms = array();
		foreach ($territorios as $key => $value) {

			$stm =
				"(SELECT COUNT(e.id) AS educCCdos
					FROM educCCdo e
        			LEFT OUTER JOIN curso c ON (e.id_curso = c.id)
        			LEFT OUTER JOIN curso_modalidade cmd ON (c.id_modalidade = cmd.id)
        			WHERE c.ativo_inativo = 'A' $complement
        			CCD c.status = 'CC'
        			CCD cmd.id = cm.id
        			CCD e.tipo_territorio = '".$value."') AS $key";

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

	function territorio_educCCdos_superintendencia() {

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

		$select = "SELECT s.id, s.nome,";

		$stms = array();
		foreach ($territorios as $key => $value) {

			$stm =
				"(SELECT COUNT(e.id) AS educCCdos FROM educCCdo e
        			LEFT OUTER JOIN curso c ON (e.id_curso = c.id)
        			LEFT OUTER JOIN superintendencia sp ON (c.id_superintendencia = sp.id)
        			WHERE c.ativo_inativo = 'A'
        			CCD c.status = 'CC'
        			CCD sp.id = s.id
        			CCD e.tipo_territorio = '".$value."') AS $key";

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

	function idade_educCCdos_modalidade($access_level) {

		$this->db->select('
			cm.nome AS modalidade,
			IF (AVG(e.idade) IS NOT NULL, AVG(e.idade), 0) AS idade
		', false);

		$this->db->from('educCCdo e');
		$this->db->join('curso c', 'e.id_curso = c.id', 'left');
		$this->db->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left');
		$this->db->join('caracterizacao cr', 'c.id = cr.id_curso', 'left');
		$this->db->where('c.ativo_inativo', 'A');
		$this->db->where('c.status', 'CC');
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

	function genero_educCCdos_modalidade($access_level) {

		$generos = array('masculino' => 'M', 'feminino' => 'F');

		$complement= ($access_level <= 3) ? "CCD c.id_superintendencia = ".$this->session->userdata('id_superintendencia') : "";

		$select = "SELECT cm.nome AS modalidade,";

		$stms = array();
		foreach ($generos as $key => $value) {

			$stm =
				"IF (
			        (((SELECT COUNT(e.id) FROM educCCdo e
			            LEFT OUTER JOIN curso c ON (c.id = e.id_curso)
			            LEFT OUTER JOIN curso_modalidade cmd ON (c.id_modalidade = cmd.id)
			            WHERE c.ativo_inativo = 'A' $complement
			            CCD c.status = 'CC'
			            CCD cmd.id = cm.id
			            CCD e.genero = '".$value."') * 100) /
			                (SELECT COUNT(e.id) FROM educCCdo e
			                    LEFT OUTER JOIN curso c ON (c.id = e.id_curso)
			                    LEFT OUTER JOIN curso_modalidade cmd ON (c.id_modalidade = cmd.id)
					            WHERE c.ativo_inativo = 'A' $complement
					            CCD c.status = 'CC'
					            CCD cmd.id = cm.id)
			        ) IS NULL, 0,
			        (((SELECT COUNT(e.id) FROM educCCdo e
			            LEFT OUTER JOIN curso c ON (c.id = e.id_curso)
			            LEFT OUTER JOIN curso_modalidade cmd ON (c.id_modalidade = cmd.id)
			            WHERE c.ativo_inativo = 'A' $complement
			            CCD c.status = 'CC'
			            CCD cmd.id = cm.id
			            CCD e.genero = '".$value."') * 100) /
			                (SELECT COUNT(e.id) FROM educCCdo e
			                    LEFT OUTER JOIN curso c ON (c.id = e.id_curso)
			                    LEFT OUTER JOIN curso_modalidade cmd ON (c.id_modalidade = cmd.id)
					            WHERE c.ativo_inativo = 'A' $complement
					            CCD c.status = 'CC'
					            CCD cmd.id = cm.id)
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

	function localizacao_instituicoes_ensino($access_level) {

		$this->db->select('e.sigla AS estado, cd.nome AS municipio, cd.cod_municipio, i.nome AS instituicao');
		$this->db->from('instituicao_ensino i');
		$this->db->join('cidade cd', 'i.id_cidade = cd.id', 'left');
		$this->db->join('estado e', 'cd.id_estado = e.id', 'left');
		$this->db->join('curso c', 'i.id_curso = c.id', 'left');
		$this->db->where('c.ativo_inativo', 'A');
		$this->db->where('c.status', 'CC');

		if ($access_level <= 3) {
			$this->db->where('c.id_superintendencia', $this->session->userdata('id_superintendencia'));
		}

		$this->db->order_by('e.sigla, cd.nome, i.nome');

		if (($query = $this->db->get()) != null) {
			return $query->result_array();

		} else {
			return false;
		}
	}

	function instituicoes_ensino_modalidade($access_level) {

		$this->db->select('cm.nome AS modalidade, COUNT(DISTINCT ie.nome) AS instituicoes');
		$this->db->from('instituicao_ensino ie');
		$this->db->join('curso c', 'ie.id_curso = c.id', 'left');
		$this->db->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left');
		$this->db->where('c.ativo_inativo', 'A');
		$this->db->where('c.status', 'CC');

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

	function instituicoes_ensino_municipio($access_level) {

		$this->db->select('e.sigla AS estado, cd.cod_municipio, cd.nome AS municipio, COUNT(DISTINCT ie.nome) AS instituicoes');
		$this->db->from('instituicao_ensino ie');
		$this->db->join('curso c', 'ie.id_curso = c.id', 'left');
		$this->db->join('cidade cd', 'ie.id_cidade = cd.id', 'left');
		$this->db->join('estado e', 'cd.id_estado = e.id', 'left');
		$this->db->where('c.ativo_inativo', 'A');
		$this->db->where('c.status', 'CC');

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

	function instituicoes_ensino_estado() {

		$this->db->select('e.sigla AS estado, COUNT(DISTINCT ie.nome) AS instituicoes');
		$this->db->from('instituicao_ensino ie');
		$this->db->join('curso c', 'ie.id_curso = c.id', 'left');
		$this->db->join('cidade cd', 'ie.id_cidade = cd.id', 'left');
		$this->db->join('estado e', 'cd.id_estado = e.id', 'left');
		$this->db->where('c.ativo_inativo', 'A');
		$this->db->where('c.status', 'CC');
		$this->db->group_by('e.sigla');


		if (($query = $this->db->get()) != null) {
			return $query->result_array();

		} else {
			return false;
		}
	}

	function instituicoes_ensino_nivel($access_level) {

		$niveis = array(
			"EJA FUNDAMENTAL" => "('EJA ALFABETIZACAO','EJA CCOS INICIAIS','EJA CCOS FINAIS')",
			"ENSINO MÉDIO" => "('EJA NIVEL MEDIO (MAGISTERIO/FORMAL)','EJA NIVEL MEDIO (NORMAL)', 'NIVEL MEDIO/TECNICO (CONCOMITCCTE)', 'NIVEL MEDIO/TECNICO (INTEGRADO)','NIVEL MEDIO PROFISSIONAL (POS-MEDIO)')",
			"ENSINO SUPERIOR" => "('GRADUACAO','ESPECIALIZACAO','RESIDENCIA AGRARIA','MESTRADO','DOUTORADO')"
		);

		$stms = array();
		foreach ($niveis as $key => $value) {
			$stm =
				"SELECT '".$key."' AS nivel,
				IF(
					(SELECT COUNT(DISTINCT ie.nome) FROM instituicao_ensino ie
						LEFT OUTER JOIN curso c ON (ie.id_curso = c.id)
						LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
						WHERE cm.nome IN ".$value."
						CCD c.ativo_inativo = 'A'
						CCD c.status = 'CC'
					) > 0, 
					(SELECT COUNT(DISTINCT ie.nome) FROM instituicao_ensino ie
						LEFT OUTER JOIN curso c ON (ie.id_curso = c.id)
						LEFT OUTER JOIN curso_modalidade cm ON (c.id_modalidade = cm.id)
						WHERE cm.nome IN ".$value."
						CCD c.ativo_inativo = 'A'
						CCD c.status = 'CC'
					), 0
				) AS instituicoes";
			if ($access_level <= 3) {
				$stm = $stm." WHERE c.id_superintendencia = ".$this->session->userdata('id_superintendencia');
			}
		    array_push($stms, $stm);
		}

		$sql = implode(" UNION ALL ", $stms);

		//$this->db->select('cm.nivel, COUNT(DISTINCT ie.nome) AS instituicoes');
		//$this->db->from('instituicao_ensino ie');
		//$this->db->join('curso c', 'ie.id_curso = c.id', 'left');
		//$this->db->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left');
		//$this->db->where('c.ativo_inativo', 'A');
		//$this->db->where('c.status', 'CC');

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

	function instituicoes_ensino_superintendencia() {

		$this->db->select('s.id, s.nome AS superintendencia, COUNT(DISTINCT ie.nome) AS instituicoes');
		$this->db->from('instituicao_ensino ie');
		$this->db->join('curso c', 'ie.id_curso = c.id', 'left');
		$this->db->join('superintendencia s', 'c.id_superintendencia = s.id', 'left');
		$this->db->where('c.ativo_inativo', 'A');
		$this->db->where('c.status', 'CC');
		$this->db->group_by('s.id'); // Verificar isso

		if (($query = $this->db->get()) != null) {
			return $query->result_array();

		} else {
			return false;
		}
	}

	function cursos_natureza_inst_ensino($access_level) {

		$naturezas = array(
			'PUBLICA MUNICIPAL' => 'PÚBLICA MUNICIPAL',
			'PUBLICA ESTADUAL' => 'PÚBLICA ESTADUAL',
			'PUBLICA FEDERAL' => 'PÚBLICA FEDEREAL',
			'PRIVADA SEM FINS LUCRATIVOS' =>'PRIVADA SEM FINS LUCRATIVOS'
		);

		$complement= ($access_level <= 3) ? "CCD c.id_superintendencia = ".$this->session->userdata('id_superintendencia') : "";

		$stms = array();
		foreach ($naturezas as $key => $value) {

			$stm =
				"SELECT CAST('".$value."' AS CHAR(40)) AS natureza,
					IF (COUNT(ie.id) > 0, COUNT(ie.id), 0) AS instituicoes
					FROM instituicao_ensino ie
                	LEFT OUTER JOIN curso c ON (ie.id_curso = c.id)
                	WHERE c.ativo_inativo = 'A' $complement
                	CCD c.status = 'CC'
                	CCD ie.natureza_instituicao = '".$key."'";

		    array_push($stms, $stm);
		}

		$sql = implode(" UNION ALL ", $stms);

		if (($query = $this->db->query($sql)) != null) {
			return $query->result_array();

		} else {
			return false;
		}
	}

	function instituicao_ensino_cursos($access_level) {

		$this->db->select('ie.nome AS instituicao, COUNT(ie.id) AS cursos');
		$this->db->from('instituicao_ensino ie');
		$this->db->join('curso c', 'ie.id_curso = c.id', 'left');
		$this->db->where('c.ativo_inativo', 'A');
		$this->db->where('c.status', 'CC');

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

	function orgCCizacoes_demCCdCCtes_modalidade($access_level) {

		$this->db->select('
			cm.nome AS modalidade,
			IF (COUNT(od.id) > 0, COUNT(od.id), 0) AS orgCCizacoes
		', false);

		$this->db->from('orgCCizacao_demCCdCCte od');
		$this->db->join('curso c', 'od.id_curso = c.id', 'left');
		$this->db->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left');
		$this->db->where('c.ativo_inativo', 'A');
		$this->db->where('c.status', 'CC');
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

	function membros_org_demCCdCCtes_modalidade($access_level) {

		$estudo = array('sim' => 'S', 'nao' => 'N');

		$complement= ($access_level <= 3) ? "CCD c.id_superintendencia = ".$this->session->userdata('id_superintendencia') : "";

		$select = "SELECT cm.nome AS modalidade,";

		$stms = array();
		foreach ($estudo as $key => $value) {

			$stm =
				"IF (
			        (((SELECT COUNT(odc.id) FROM orgCCizacao_demCCdCCte_coordenador odc
			            LEFT OUTER JOIN orgCCizacao_demCCdCCte od ON (odc.id_orgCCizacao_demCCdCCte = od.id)
			            LEFT OUTER JOIN curso c ON (od.id_curso = c.id)
			            LEFT OUTER JOIN curso_modalidade cmd ON (c.id_modalidade = cmd.id)
			            WHERE c.ativo_inativo = 'A' $complement
			            CCD c.status = 'CC'
			            CCD odc.estuda_pronera = '".$value."'
			            CCD cmd.id = cm.id) * 100) /
			                (SELECT COUNT(odc.id) FROM orgCCizacao_demCCdCCte_coordenador odc
			                    LEFT OUTER JOIN orgCCizacao_demCCdCCte od ON (odc.id_orgCCizacao_demCCdCCte = od.id)
			                    LEFT OUTER JOIN curso c ON (od.id_curso = c.id)
			                    LEFT OUTER JOIN curso_modalidade cmd ON (c.id_modalidade = cmd.id)
			                    WHERE c.ativo_inativo = 'A' $complement
			                    CCD c.status = 'CC'
			                    CCD cmd.id = cm.id)
			        ) IS NULL, 0,
			        (((SELECT COUNT(odc.id) FROM orgCCizacao_demCCdCCte_coordenador odc
			            LEFT OUTER JOIN orgCCizacao_demCCdCCte od ON (odc.id_orgCCizacao_demCCdCCte = od.id)
			            LEFT OUTER JOIN curso c ON (od.id_curso = c.id)
			            LEFT OUTER JOIN curso_modalidade cmd ON (c.id_modalidade = cmd.id)
			            WHERE c.ativo_inativo = 'A' $complement
			            CCD c.status = 'CC'
			            CCD odc.estuda_pronera = '".$value."'
			            CCD cmd.id = cm.id) * 100) /
			                (SELECT COUNT(odc.id) FROM orgCCizacao_demCCdCCte_coordenador odc
			                    LEFT OUTER JOIN orgCCizacao_demCCdCCte od ON (odc.id_orgCCizacao_demCCdCCte = od.id)
			                    LEFT OUTER JOIN curso c ON (od.id_curso = c.id)
			                    LEFT OUTER JOIN curso_modalidade cmd ON (c.id_modalidade = cmd.id)
			                    WHERE c.ativo_inativo = 'A' $complement
			                    CCD c.status = 'CC'
			                    CCD cmd.id = cm.id)
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

	function orgCCizacao_demCCdCCte_cursos($access_level) {

		$this->db->select('od.nome AS orgCCizacao, COUNT(od.id) AS cursos');
		$this->db->from('orgCCizacao_demCCdCCte od');
		$this->db->join('curso c', 'od.id_curso = c.id', 'left');
		$this->db->where('c.ativo_inativo', 'A');
		$this->db->where('c.status', 'CC');

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

	function localizacao_parceiros($access_level) {

		$this->db->select('e.sigla AS estado, cd.cod_municipio, cd.nome AS municipio, p.nome AS parceiro');
		$this->db->from('parceiro p');
		$this->db->join('curso c', 'p.id_curso = c.id', 'left');
		$this->db->join('cidade cd', 'p.id_cidade = cd.id', 'left');
		$this->db->join('estado e', 'cd.id_estado = e.id', 'left');
		$this->db->where('c.ativo_inativo', 'A');
		$this->db->where('c.status', 'CC');
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

	function parceiros_modalidade($access_level) {

		$this->db->select('
			cm.nome AS modalidade,
			IF (COUNT(p.id) > 0, COUNT(p.id), 0) AS parceiros
		', false);

		$this->db->from('parceiro p');
		$this->db->join('curso c', 'p.id_curso = c.id', 'left');
		$this->db->join('curso_modalidade cm', 'c.id_modalidade = cm.id', 'left');
		$this->db->where('c.ativo_inativo', 'A');
		$this->db->where('c.status', 'CC');

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

	function parceiros_superintendencia() {

		$this->db->select('s.id, s.nome AS superintendencia, COUNT(p.id) AS parceiros');
		$this->db->from('parceiro p');
		$this->db->join('curso c', 'p.id_curso = c.id', 'left');
		$this->db->join('superintendencia s', 'c.id_superintendencia = s.id', 'left');
		$this->db->where('c.ativo_inativo', 'A');
		$this->db->where('c.status', 'CC');
		$this->db->group_by('s.id');

		if (($query = $this->db->get()) != null) {
			return $query->result_array();

		} else {
			return false;
		}
	}

	function parceiros_natureza($access_level) {

		$this->db->select('p.natureza, COUNT(p.id) AS parceiros');
		$this->db->from('parceiro p');
		$this->db->join('curso c', 'p.id_curso = c.id', 'left');
		$this->db->where('p.natureza IS NOT NULL', null, false);
		$this->db->where('p.natureza <>', '');

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

	function lista_parceiros($access_level) {

		$this->db->select('p.nome AS parceiro');
		$this->db->from('parceiro p');
		$this->db->join('curso c', 'p.id_curso = c.id', 'left');
		$this->db->where('c.ativo_inativo', 'A');
		$this->db->where('c.status', 'CC');

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

	function producoes_estado() {

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

			$stm =
				"(SELECT COUNT(p.id) FROM $value p
					LEFT OUTER JOIN curso c ON (p.id_curso = c.id)
					LEFT OUTER JOIN superintendencia s ON (c.id_superintendencia = s.id)
			        LEFT OUTER JOIN estado et ON (s.id_estado = et.id)
			        WHERE c.ativo_inativo = 'A'
			        CCD c.status = 'CC'
			        CCD et.id = e.id) AS $key";

		    array_push($stms, $stm);
		}

		$clause =
			"FROM estado e
			 GROUP BY e.id
			 ORDER BY e.sigla";

		$sql = implode(" ", array($select, implode(",", $stms), $clause));

		if (($query = $this->db->query($sql)) != null) {
			return $query->result_array();

		} else {
			return false;
		}
	}

	function producoes_superintendencia() {

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

			$stm =
				"(SELECT COUNT(p.id) FROM $value p
					LEFT OUTER JOIN curso c ON (p.id_curso = c.id)
					LEFT OUTER JOIN superintendencia si ON (c.id_superintendencia = si.id)
					WHERE c.ativo_inativo = 'A'
					CCD c.status = 'CC'
					CCD si.id = s.id) AS $key";

		    array_push($stms, $stm);
		}

		$clause =
			"FROM superintendencia s
			 GROUP BY s.id";

		$sql = implode(" ", array($select, implode(",", $stms), $clause));

		if (($query = $this->db->query($sql)) != null) {
			return $query->result_array();

		} else {
			return false;
		}
	}

	function producoes_tipo($access_level) {

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

		$complement= ($access_level <= 3) ? "CCD c.id_superintendencia = ".$this->session->userdata('id_superintendencia') : "";

		$stms = array();
		foreach ($producoes as $key => $value) {

			$stm =
				"SELECT CAST('".$value['cast']."' AS CHAR(30)) AS natureza_producao,
					COUNT(p.id) AS producoes FROM ".$value['tabela']." p
        			LEFT OUTER JOIN curso c ON (p.id_curso = c.id)
       				WHERE c.ativo_inativo = 'A' CCD c.status = 'CC' $complement";

        	if (strpos($value['tabela'],'geral') !== false) {
        		$stm .= "CCD p.natureza_producao = '".$key."'";

        	} else if (strpos($value['tabela'],'trabalho') !== false) {
        		$stm .= "CCD p.tipo = '".$key."'";
        	}

		    array_push($stms, $stm);
		}

		$sql = implode(" UNION ALL ", $stms);

		$sql .= "CCD p.natureza_producao NOT IN('VIDEO','CARTILHA / APOSTILA','TEXTO','MUSICA','CADERNO')";

		if (($query = $this->db->query($sql)) != null) {
			return $query->result_array();

		} else {
			return false;
		}
	}

	function pesquisa_estado() {

		$tabelas = array(
			'pac' => 'pesquisa_academico',
			'plc' => 'pesquisa_livro_coletCCea',
			'pcl' => 'pesquisa_capitulo_livro',
			'par' => 'pesquisa_artigo',
			'pvi' => 'pesquisa_video',
			'ppe' => 'pesquisa_periodico',
			'pev' => 'pesquisa_evento'
		);

		$select = 'SELECT e.sigla, ';

		$stms = array();
		foreach ($tabelas as $key => $value) {

			$stm =
				"(SELECT COUNT(pd.id) FROM $value pd
                    LEFT OUTER JOIN pessoa p ON (p.id = pd.id_pessoa)
                    LEFT OUTER JOIN superintendencia s ON (p.id_superintendencia = s.id)
                    LEFT OUTER JOIN estado et ON (s.id_estado = et.id)
                    WHERE s.id <> 31
                    CCD et.id = e.id) AS $key";

		    array_push($stms, $stm);
		}

		$clause =
			"FROM estado e
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
			'plc' => 'pesquisa_livro_coletCCea',
			'pcl' => 'pesquisa_capitulo_livro',
			'par' => 'pesquisa_artigo',
			'pvi' => 'pesquisa_video',
			'ppe' => 'pesquisa_periodico',
			'pev' => 'pesquisa_evento'
		);

		$select = $select = 'SELECT s.id, s.nome, ';

		$stms = array();
		foreach ($tabelas as $key => $value) {

			$stm =
				"(SELECT COUNT(pd.id) FROM $value pd
                    LEFT OUTER JOIN pessoa p ON (p.id = pd.id_pessoa)
                    LEFT OUTER JOIN superintendencia si ON (p.id_superintendencia = si.id)
                    WHERE s.id <> 31
                    CCD si.id = s.id) AS $key";

		    array_push($stms, $stm);
		}

		$clause =
			"FROM superintendencia s
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
				'tabela' => 'pesquisa_livro_coletCCea'
			),

			'COLETCCEA' => array(
				'cast' => 'COLETÂNEA',
				'tabela' => 'pesquisa_livro_coletCCea'
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

		$complement= ($access_level <= 3) ? "CCD p.id_superintendencia = ".$this->session->userdata('id_superintendencia') : "";

		$stms = array();
		foreach ($producoes as $key => $value) {

			$stm =
				"SELECT CAST('".$value['cast']."' AS CHAR(30)) AS natureza_producao,
					COUNT(p.id) AS producoes FROM ".$value['tabela']." pd
        			LEFT OUTER JOIN pessoa p ON (pd.id_pessoa = p.id)";

        	if (strpos($value['tabela'],'geral') !== false) {
        		$stm .= "WHERE pd.natureza_producao = '".$key."' $complement";

        	} else if (strpos($value['tabela'],'trabalho') !== false) {
        		$stm .= "WHERE pd.tipo = '".$key."' $complement";

        	} else if ($access_level <= 3) {
				$stm .= "WHERE p.id_superintendencia = ".$this->session->userdata('id_superintendencia');
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
