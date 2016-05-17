<?php 

	class Producao8_m extends CI_Model {

		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  * 
		* 						PRODUÇÃO 8A 							*
		* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */ 

		function get_record_producao_geral($id)
		{

			$this->db->where('id', $id);

			$query = $this->db->get('producao_geral');

			if ($query->num_rows == 1) {
				return $query->result();

			} else {
				return false;
			}
		}

		function add_record_producao_geral($producao)
		{
			if ( ($this->db->insert('producao_geral', $producao) != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return $this->db->insert_id();

			} else {
				return false;
			}
		}

		function add_record_autor_producao_geral($id_producao, $data)
		{
			if ( ($this->db->insert('autor', $data) != null)
					&& ($this->db->affected_rows() > 0)
			   )
			{
				$data_nxm = array(
					'id_producao_geral' => $id_producao,
					'id_autor' => $this->db->insert_id()
				);

				if ( ($this->db->insert('producao_geral_autor', $data_nxm) != null)
						&& ($this->db->affected_rows() > 0)
				   )
				{
					return true;

				} else {
					return false;
				}

			} else {
				return false;
			}
		}

		function update_record_producao_geral($producao, $id)
		{
			$this->db->where('id', $id);

			if ( ($this->db->update('producao_geral', $producao) != null)
					//&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function delete_record_producao_geral_autor($id_autor, $id_producao)
		{

			$this->db->where('id_producao_geral', $id_producao);
			if ($id_autor != 'ALL') $this->db->where('id_autor', $id_autor);

			if ( ($this->db->delete('producao_geral_autor') != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function delete_record_producao_geral($id)
		{
			$this->db->where('id', $id);

			if ( ($this->db->delete('producao_geral') != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  * 
		* 						PRODUÇÃO 8B 							*
		* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */ 

		function get_record_producao_trabalho($id)
		{

			$this->db->where('id', $id);

			$query = $this->db->get('producao_trabalho');

			if ($query->num_rows == 1) {
				return $query->result();

			} else {
				return false;
			}
		}

		function add_record_producao_trabalho($producao)
		{
			if ( ($this->db->insert('producao_trabalho', $producao) != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return $this->db->insert_id();

			} else {
				return false;
			}
		}

		function add_record_autor_producao_trabalho($id_producao, $data)
		{
			if ( ($this->db->insert('autor', $data) != null)
					&& ($this->db->affected_rows() > 0)
			   )
			{
				$data_nxm = array(
					'id_producao_trabalho' => $id_producao,
					'id_autor' => $this->db->insert_id()
				);

				if ( ($this->db->insert('producao_trabalho_autor', $data_nxm) != null)
						&& ($this->db->affected_rows() > 0)
				   )
				{
					return true;

				} else {
					return false;
				}

			} else {
				return false;
			}
		}

		function update_record_producao_trabalho($producao, $id)
		{
			$this->db->where('id', $id);

			if ( ($this->db->update('producao_trabalho', $producao) != null)
					//&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function delete_record_producao_trabalho_autor($id_autor, $id_producao)
		{

			$this->db->where('id_producao_trabalho', $id_producao);
			if ($id_autor != 'ALL') $this->db->where('id_autor', $id_autor);

			if ( ($this->db->delete('producao_trabalho_autor') != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function delete_record_producao_trabalho($id)
		{
			$this->db->where('id', $id);

			if ( ($this->db->delete('producao_trabalho') != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  * 
		* 						PRODUÇÃO 8C 							*
		* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */ 

		function get_record_producao_artigo($id)
		{

			$this->db->where('id', $id);

			$query = $this->db->get('producao_artigo');

			if ($query->num_rows == 1) {
				return $query->result();

			} else {
				return false;
			}
		}

		function add_record_producao_artigo($producao)
		{
			if ( ($this->db->insert('producao_artigo', $producao) != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return $this->db->insert_id();

			} else {
				return false;
			}
		}

		function add_record_autor_producao_artigo($id_producao, $data)
		{
			if ( ($this->db->insert('autor', $data) != null)
					&& ($this->db->affected_rows() > 0)
			   )
			{
				$data_nxm = array(
					'id_producao_artigo' => $id_producao,
					'id_autor' => $this->db->insert_id()
				);

				if ( ($this->db->insert('producao_artigo_autor', $data_nxm) != null)
						&& ($this->db->affected_rows() > 0)
				   )
				{
					return true;

				} else {
					return false;
				}

			} else {
				return false;
			}
		}

		function update_record_producao_artigo($producao, $id)
		{
			$this->db->where('id', $id);

			if ( ($this->db->update('producao_artigo', $producao) != null)
					//&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function delete_record_producao_artigo_autor($id_autor, $id_producao)
		{

			$this->db->where('id_producao_artigo', $id_producao);
			if ($id_autor != 'ALL') $this->db->where('id_autor', $id_autor);

			if ( ($this->db->delete('producao_artigo_autor') != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function delete_record_producao_artigo($id)
		{
			$this->db->where('id', $id);

			if ( ($this->db->delete('producao_artigo') != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  * 
		* 						PRODUÇÃO 8D  							*
		* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */ 

		function get_record_producao_memoria($id)
		{

			$this->db->where('id', $id);

			$query = $this->db->get('producao_memoria');

			if ($query->num_rows == 1) {
				return $query->result();

			} else {
				return false;
			}
		}

		function add_record_producao_memoria($producao)
		{
			if ( ($this->db->insert('producao_memoria', $producao) != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return $this->db->insert_id();

			} else {
				return false;
			}
		}

		function update_record_producao_memoria($producao, $id)
		{
			$this->db->where('id', $id);

			if ( ($this->db->update('producao_memoria', $producao) != null)
					//&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function delete_record_producao_memoria($id)
		{
			$this->db->where('id', $id);

			if ( ($this->db->delete('producao_memoria') != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  * 
		* 						PRODUÇÃO 8E  							*
		* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */ 

		function get_record_producao_livro($id)
		{

			$this->db->where('id', $id);

			$query = $this->db->get('producao_livro');

			if ($query->num_rows == 1) {
				return $query->result();

			} else {
				return false;
			}
		}

		function add_record_producao_livro($producao)
		{
			if ( ($this->db->insert('producao_livro', $producao) != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return $this->db->insert_id();

			} else {
				return false;
			}
		}

		function add_record_autor_producao_livro($id_producao, $data)
		{
			if ( ($this->db->insert('autor', $data) != null)
					&& ($this->db->affected_rows() > 0)
			   )
			{
				$data_nxm = array(
					'id_producao_livro' => $id_producao,
					'id_autor' => $this->db->insert_id()
				);

				if ( ($this->db->insert('producao_livro_autor', $data_nxm) != null)
						&& ($this->db->affected_rows() > 0)
				   )
				{
					return true;

				} else {
					return false;
				}

			} else {
				return false;
			}
		}

		function update_record_producao_livro($producao, $id)
		{
			$this->db->where('id', $id);

			if ( ($this->db->update('producao_livro', $producao) != null)
					//&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function delete_record_producao_livro_autor($id_autor, $id_producao)
		{

			$this->db->where('id_producao_livro', $id_producao);
			if ($id_autor != 'ALL') $this->db->where('id_autor', $id_autor);

			if ( ($this->db->delete('producao_livro_autor') != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function delete_record_producao_livro($id)
		{
			$this->db->where('id', $id);

			if ( ($this->db->delete('producao_livro') != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

	} 