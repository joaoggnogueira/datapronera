<?php 

	class Producao9_m extends CI_Model {

		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  * 
		* 						PRODUÇÃO 9A 							*
		* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */ 

		function get_record_pesquisa_academico($id)
		{	
			$this->db->where('id', $id);

			$query = $this->db->get('pesquisa_academico');

			if ($query->num_rows == 1) {
				return $query->result();

			} else {
				return false;
			}
		}

		function add_record_pesquisa_academico($producao)
		{
			if ( ($this->db->insert('pesquisa_academico', $producao) != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return $this->db->insert_id();

			} else {
				return false;
			}
		}

		function add_record_pesquisa_academico_autor($id_producao, $data)
		{
			if ( ($this->db->insert('autor', $data) != null)
					&& ($this->db->affected_rows() > 0)
			   )
			{
				$data_nxm = array(
					'id_pesquisa_academico' => $id_producao,
					'id_autor' => $this->db->insert_id()
				);

				if ( ($this->db->insert('pesquisa_academico_autor', $data_nxm) != null)
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

		function update_record_pesquisa_academico($producao, $id)
		{
			$this->db->where('id', $id);

			if ( ($this->db->update('pesquisa_academico', $producao) != null)
					//&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function delete_record_pesquisa_academico_autor($id_autor, $id_producao)
		{

			$this->db->where('id_pesquisa_academico', $id_producao);
			if ($id_autor != 'ALL')$this->db->where('id_autor', $id_autor);

			if ( ($this->db->delete('pesquisa_academico_autor') != null)
					//&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function delete_record_pesquisa_academico($id)
		{
			$this->db->where('id', $id);

			if ( ($this->db->delete('pesquisa_academico') != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  * 
		*					PRODUÇÃO 9B - LIVRO							*
		* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */ 

		function get_record_pesquisa_livro($id)
		{	
			$this->db->where('id', $id);

			$query = $this->db->get('livro');

			if ($query->num_rows == 1) {
				return $query->result();

			} else {
				return false;
			}
		}

		function add_record_pesquisa_livro($producao)
		{
			if ( ($this->db->insert('livro', $producao) != null)
					&& ($this->db->affected_rows() > 0)
			   )
			{
				return $this->db->insert_id();

			} else {
				return false;
			}
		}

		function add_record_pesquisa_livro_autor($id_producao, $data)
		{
			if ( ($this->db->insert('autor', $data) != null)
					&& ($this->db->affected_rows() > 0)
			   )
			{
				$data_nxm = array(
					'id_livro' => $id_producao,
					'id_autor' => $this->db->insert_id()
				);

				if ( ($this->db->insert('livro_autor', $data_nxm) != null)
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

		function update_record_pesquisa_livro($producao, $id)
		{
			$this->db->where('id', $id);

			if ( ($this->db->update('livro', $producao) != null)
					//&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function delete_record_pesquisa_livro($id_producao)
		{
			$this->db->where('id', $id_producao);

			if ( ($this->db->delete('livro') != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function delete_record_pesquisa_livro_autor($id_autor, $id_producao)
		{
			$this->db->where('id_livro', $id_producao);
			//if ($id_autor != 'ALL') $this->db->where('id_autor', $id_autor);

			if ( ($this->db->delete('livro_autor') != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  * 
		*					PRODUÇÃO 9B - COLETANEA						*
		* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

		function get_record_pesquisa_coletanea($id)
		{	
			$this->db->where('id', $id);

			$query = $this->db->get('coletanea');

			if ($query->num_rows == 1) {
				return $query->result();

			} else {
				return false;
			}
		}

		function add_record_pesquisa_coletanea($producao)
		{
			if ( ($this->db->insert('coletanea', $producao) != null)
					&& ($this->db->affected_rows() > 0)
			   )
			{
				return $this->db->insert_id();

			} else {
				return false;
			}
		}

		function add_record_pesquisa_coletanea_livro($data)
		{
			if ( ($this->db->insert('coletanea_livro', $data) != null)
					&& ($this->db->affected_rows() > 0)
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function update_record_pesquisa_coletanea($producao, $id)
		{
			$this->db->where('id', $id);

			if ( ($this->db->update('coletanea', $producao) != null)
					//&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function delete_record_pesquisa_coletanea($id_producao)
		{
			$this->db->where('id', $id_producao);

			if ( ($this->db->delete('coletanea') != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function delete_record_pesquisa_coletanea_livro($id_livro, $id_producao)
		{
			$this->db->where('id_coletanea', $id_producao);
			//if ($id_autor != 'ALL') $this->db->where('id_autor', $id_autor);

			if ( ($this->db->delete('coletanea_livro') != null)
					//&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}


		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  * 
		* 						PRODUÇÃO 9C 							*
		* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */ 

		function get_record_pesquisa_capitulo_livro($id)
		{	
			$this->db->where('id', $id);

			$query = $this->db->get('pesquisa_capitulo_livro');

			if ($query->num_rows == 1) {
				return $query->result();

			} else {
				return false;
			}
		}

		function add_record_pesquisa_capitulo_livro($producao)
		{
			if ( ($this->db->insert('pesquisa_capitulo_livro', $producao) != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return $this->db->insert_id();

			} else {
				return false;
			}
		}

		function add_record_pesquisa_capitulo_livro_autor($id_producao, $data)
		{
			if ( ($this->db->insert('autor', $data) != null)
					&& ($this->db->affected_rows() > 0)
			   )
			{
				$data_nxm = array(
					'id_pesquisa_capitulo_livro' => $id_producao,
					'id_autor' => $this->db->insert_id()
				);

				if ( ($this->db->insert('pesquisa_capitulo_livro_autor', $data_nxm) != null)
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

		function update_record_pesquisa_capitulo_livro($producao, $id)
		{
			$this->db->where('id', $id);

			if ( ($this->db->update('pesquisa_capitulo_livro', $producao) != null)
					//&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function delete_record_pesquisa_capitulo_livro_autor($id_autor, $id_producao)
		{

			$this->db->where('id_pesquisa_capitulo_livro', $id_producao);
			if ($id_autor != 'ALL') $this->db->where('id_autor', $id_autor);

			if ( ($this->db->delete('pesquisa_capitulo_livro_autor') != null)
					//&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function delete_record_pesquisa_capitulo_livro($id)
		{
			$this->db->where('id', $id);

			if ( ($this->db->delete('pesquisa_capitulo_livro') != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  * 
		* 						PRODUÇÃO 9D  							*
		* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */ 

		function get_record_pesquisa_artigo($id)
		{	
			$this->db->where('id', $id);

			$query = $this->db->get('pesquisa_artigo');

			if ($query->num_rows == 1) {
				return $query->result();

			} else {
				return false;
			}
		}

		function add_record_pesquisa_artigo($producao)
		{
			if ( ($this->db->insert('pesquisa_artigo', $producao) != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return $this->db->insert_id();

			} else {
				return false;
			}
		}

		function add_record_pesquisa_artigo_autor($id_producao, $data)
		{
			if ( ($this->db->insert('autor', $data) != null)
					&& ($this->db->affected_rows() > 0)
			   )
			{
				$data_nxm = array(
					'id_pesquisa_artigo' => $id_producao,
					'id_autor' => $this->db->insert_id()
				);

				if ( ($this->db->insert('pesquisa_artigo_autor', $data_nxm) != null)
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

		function update_record_pesquisa_artigo($producao, $id)
		{
			$this->db->where('id', $id);

			if ( ($this->db->update('pesquisa_artigo', $producao) != null)
					//&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function delete_record_pesquisa_artigo_autor($id_autor, $id_producao)
		{
			$this->db->where('id_pesquisa_artigo', $id_producao);
			if ($id_autor != 'ALL')$this->db->where('id_autor', $id_autor);

			if ( ($this->db->delete('pesquisa_artigo_autor') != null)
					//&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function delete_record_pesquisa_artigo($id)
		{
			$this->db->where('id', $id);

			if ( ($this->db->delete('pesquisa_artigo') != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  * 
		* 						PRODUÇÃO 9E  							*
		* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */ 

		function get_record_pesquisa_video($id)
		{	
			$this->db->where('id', $id);

			$query = $this->db->get('pesquisa_video');

			if ($query->num_rows == 1) {
				return $query->result();

			} else {
				return false;
			}
		}

		function add_record_pesquisa_video($producao)
		{
			if ( ($this->db->insert('pesquisa_video', $producao) != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return $this->db->insert_id();

			} else {
				return false;
			}
		}

		function add_record_pesquisa_video_autor($id_producao, $data)
		{
			if ( ($this->db->insert('autor', $data) != null)
					&& ($this->db->affected_rows() > 0)
			   )
			{
				$data_nxm = array(
					'id_pesquisa_video' => $id_producao,
					'id_autor' => $this->db->insert_id()
				);

				if ( ($this->db->insert('pesquisa_video_autor', $data_nxm) != null)
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

		function update_record_pesquisa_video($producao, $id)
		{
			$this->db->where('id', $id);

			if ( ($this->db->update('pesquisa_video', $producao) != null)
					//&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function delete_record_pesquisa_video_autor($id_autor, $id_producao)
		{
			$this->db->where('id_pesquisa_video', $id_producao);
			if ($id_autor != 'ALL')$this->db->where('id_autor', $id_autor);

			if ( ($this->db->delete('pesquisa_video_autor') != null)
					//&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function delete_record_pesquisa_video($id)
		{
			$this->db->where('id', $id);

			if ( ($this->db->delete('pesquisa_video') != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  * 
		* 						PRODUÇÃO 9F  							*
		* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */ 

		function get_record_pesquisa_periodico($id)
		{	
			$this->db->where('id', $id);

			$query = $this->db->get('pesquisa_periodico');

			if ($query->num_rows == 1) {
				return $query->result();

			} else {
				return false;
			}
		}

		function add_record_pesquisa_periodico($producao)
		{
			if ( ($this->db->insert('pesquisa_periodico', $producao) != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return $this->db->insert_id();

			} else {
				return false;
			}
		}

		function add_record_pesquisa_periodico_autor($id_producao, $data)
		{
			if ( ($this->db->insert('autor', $data) != null)
					&& ($this->db->affected_rows() > 0)
			   )
			{
				$data_nxm = array(
					'id_pesquisa_periodico' => $id_producao,
					'id_autor' => $this->db->insert_id()
				);

				if ( ($this->db->insert('pesquisa_periodico_autor', $data_nxm) != null)
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

		function update_record_pesquisa_periodico($producao, $id)
		{
			$this->db->where('id', $id);

			if ( ($this->db->update('pesquisa_periodico', $producao) != null)
					//&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function delete_record_pesquisa_periodico_autor($id_autor, $id_producao)
		{
			$this->db->where('id_pesquisa_periodico', $id_producao);
			if ($id_autor != 'ALL')$this->db->where('id_autor', $id_autor);

			if ( ($this->db->delete('pesquisa_periodico_autor') != null)
					//&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function delete_record_pesquisa_periodico($id)
		{
			$this->db->where('id', $id);

			if ( ($this->db->delete('pesquisa_periodico') != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  * 
		* 						PRODUÇÃO 9G  							*
		* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */ 

		function get_record_pesquisa_evento($id)
		{		
			$this->db->select('n.*, nhd.*');
			$this->db->from('pesquisa_evento n');
			$this->db->join('pesquisa_evento_documento nhd', 'n.id = nhd.id_pesquisa_evento', 'left');
			$this->db->where('n.id', $id);

			$query = $this->db->get();

			if ($query->num_rows == 1) {
				return $query->result();

			} else {
				return false;
			}
		}

		function add_record_pesquisa_evento($producao)
		{
			if ( ($this->db->insert('pesquisa_evento', $producao) != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return $this->db->insert_id();

			} else {
				return false;
			}
		}

		function add_record_pesquisa_evento_documento($documento)
		{
			if ( ($this->db->insert('pesquisa_evento_documento', $documento) != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function add_record_pesquisa_evento_autor($id_producao, $data)
		{
			if ( ($this->db->insert('autor', $data) != null)
					&& ($this->db->affected_rows() > 0)
			   )
			{
				$data_nxm = array(
					'id_pesquisa_evento' => $id_producao,
					'id_autor' => $this->db->insert_id()
				);

				if ( ($this->db->insert('pesquisa_evento_autor', $data_nxm) != null)
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

		function add_record_pesquisa_evento_organizacao($data)
		{
			if ( ($this->db->insert('pesquisa_evento_organizacao', $data) != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return $this->db->insert_id();

			} else {
				return false;
			}
		}

		function update_record_pesquisa_evento($producao, $id)
		{
			$this->db->where('id', $id);

			if ( ($this->db->update('pesquisa_evento', $producao) != null)
					//&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function update_record_pesquisa_evento_documento($data, $id_producao)
		{

			$this->db->where('id_pesquisa_evento', $id_producao);

			if ( ($this->db->update('pesquisa_evento_documento', $data) != null)
					//&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function delete_record_pesquisa_evento($id)
		{
			$this->db->where('id', $id);

			if ( ($this->db->delete('pesquisa_evento') != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function delete_record_pesquisa_evento_autor($id_autor, $id_producao)
		{
			$this->db->where('id_pesquisa_evento', $id_producao);
			if ($id_autor != 'ALL')$this->db->where('id_autor', $id_autor);

			if ( ($this->db->delete('pesquisa_evento_autor') != null)
					//&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function delete_record_pesquisa_evento_organizacao($id_organizacao, $id_producao)
		{
			$this->db->where('id_pesquisa_evento', $id_producao);
			$this->db->where('id', $id_organizacao);

			if ( ($this->db->delete('pesquisa_evento_organizacao') != null)
					//&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function delete_record_pesquisa_evento_documento($id_producao)
		{
			$this->db->where('id_pesquisa_evento', $id_producao);

			if ( ($this->db->delete('pesquisa_evento_documento') != null)
					//&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function get_estado_pesquisa_evento($id)
		{
			$this->db->where('n.id', $id);
			$this->db->select('c.id_estado estado');
			$this->db->from('pesquisa_evento n');
			$this->db->join('cidade c', 'c.id = n.id_cidade', 'left');
			$query = $this->db->get();
			
			$dados =  $query->result();
			return ($dados[0]->estado);
		}

		function get_cidade_pesquisa_evento($id)
		{
			$this->db->where('n.id', $id);
			$this->db->select('n.id_cidade');
			$this->db->from('pesquisa_evento n');
			$query = $this->db->get();
			
			$dados =  $query->result();
			return ($dados[0]->id_cidade);
		}
	}

?>