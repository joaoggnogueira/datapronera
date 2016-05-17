<?php 

	class Superintendencia_m extends CI_Model {

		function get_record($id)
		{
			$this->db->where('id', $id);

			$query = $this->db->get('superintendencia');

			if ($query->num_rows == 1) {
				return $query->result();

			} else {
				return false;
			}
		}

		function add_record($superintendencia)
		{
			if ( ($this->db->insert('superintendencia', $superintendencia) != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return $this->db->insert_id();

			} else {
				return false;
			}
		}

		function update_record($superintendencia, $id)
		{
			$this->db->where('id', $id);

			if ( ($this->db->update('superintendencia', $superintendencia) != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function toggle_record($id, $ativo_inativo)
		{
			$superintendencia = array(
				'ativo_inativo' => $ativo_inativo
			);

			$this->db->where('id', $id);

			if ( ($this->db->update('superintendencia', $superintendencia) != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}
	} 
 ?>