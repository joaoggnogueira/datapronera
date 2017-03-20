<?php 

	class Organizacao_m extends CI_Model {


		function get_record($id)
		{
			$this->db->where('id', $id);

			$query = $this->db->get('organizacao_demandante');

			if ($query->num_rows == 1) {
				return $query->result();

			} else {
				return false;
			}
		}

		function add_record($movimento)
		{
			if ( ($this->db->insert('organizacao_demandante', $movimento) != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return $this->db->insert_id();

			} else {
				return false;
			}
		}

		function add_record_coordenadores($coord)
		{	
			if ( ($this->db->insert('organizacao_demandante_coordenador', $coord) != null)
					&& ($this->db->affected_rows() > 0)
			   )
			{
				return true;
				
			} else {
				return false;
			}
		}

		function update_record($movimento, $id)
		{
			$this->db->where('id', $id);

			if ( ($this->db->update('organizacao_demandante', $movimento) != null)
					//&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function delete_record($id)
		{
			$this->db->where('id', $id);

			if ( ($this->db->delete('organizacao_demandante') != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function delete_record_coordenadores($id_coordenador, $id_organizacao)
		{
			$this->db->where('id_organizacao_demandante', $id_organizacao);
			$this->db->where('id', $id_coordenador);
			$this->db->delete('organizacao_demandante_coordenador');
			return;
		}
	}
	
?>