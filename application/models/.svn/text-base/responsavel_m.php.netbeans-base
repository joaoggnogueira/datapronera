<?php 
	
	class Responsavel_m extends CI_Model {

		function get_record($_id_curso) {

			$this->db->select('p1.nome AS pesquisador, p2.nome AS auxiliar, s.nome AS superintendencia, e.sigla AS uf');
			$this->db->from('curso c');
			$this->db->join('pessoa p2', 'c.id_pesquisador = p2.id', 'left');
			$this->db->join('pessoa_supervisor ps','p2.id = ps.id_pessoa', 'left');
			$this->db->join('pessoa p1','ps.id_supervisor = p1.id', 'left');
			$this->db->join('superintendencia s','c.id_superintendencia = s.id', 'left');
			$this->db->join('estado e','s.id_estado = e.id', 'left');
			$this->db->where('c.id', $_id_curso);

			$result = $this->db->get();

			if ($result->num_rows == 1) {
				return $result->row();

			} else {
				return false;
			}
		}

		/*function get_insurers() {

			$this->db->select('id, nome');
			$this->db->from('pessoa');
			$this->db->where('id_funcao', 1);
			$this->db->order_by('nome');

			$result = $this->db->get();

			return $result->result();
		}*/

		function get_informers($_id_curso) {

			$this->db->where('id_curso', $_id_curso);

			$result = $this->db->get('curso_fonte_informacao');

			return $result->row();
		}

		function add_record($_source) {

			if ( ($this->db->insert('curso_fonte_informacao', $_source) != null)
					&& ($this->db->affected_rows() > 0)
			   )
			{
				return true;
				
			} else {
				return false;
			}
		}

		function update_record($_fontes, $_id_curso) {
			
			$this->db->where('id_curso', $_id_curso);

			if ( ($this->db->update('curso_fonte_informacao', $_fontes) != null)
					//&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function add_insurers($_insurers) {

			if ( ($this->db->insert('curso_assegurador', $_insurers) != null)
					&& ($this->db->affected_rows() > 0)
			   )
			{
				return true;
				
			} else {
				return false;
			}
		}

		function delete_insurers($_id_curso) {

			$this->db->where('id_curso', $_id_curso);
			$this->db->delete('curso_assegurador');
			
			return;
		}
	}