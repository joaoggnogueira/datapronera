<?php 

	class Professor_m extends CI_Model {


		function get_record($id)
		{	
			$this->db->where('id', $id);

			$query = $this->db->get('professor');

			if ($query->num_rows == 1) {
				return $query->result();

			} else {
				return false;
			}
		}

		function add_record($professor)
		{
			if ( ($this->db->insert('professor', $professor) != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return $this->db->insert_id();

			} else {
				return false;
			}
		}

		function add_record_disciplina($disciplina)
		{	
			if ( ($this->db->insert('disciplina', $disciplina) != null)
					&& ($this->db->affected_rows() > 0)
			   )
			{
				return true;
				
			} else {
				return false;
			}
		}

		function update_record($professor, $id)
		{
			$this->db->where('id', $id);

			if ( ($this->db->update('professor', $professor) != null)
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

			if ( ($this->db->delete('professor') != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function delete_record_disciplinas($disc_id, $id_professor)
		{
			$this->db->where('id_professor', $id_professor);
			$this->db->where('id', $disc_id);
			$this->db->delete('disciplina');
			return $this->db->affected_rows() != 0;
		}
	} 


 ?>