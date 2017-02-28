<?php 

	class Curso_m extends CI_Model {

		function get_record($id)
		{
			$this->db->where('id', $id);

			$query = $this->db->get('curso');

			if ($query->num_rows == 1) {
				return $query->result();

			} else {
				return false;
			}
		}

		function add_record($curso)
		{
			if ( ($this->db->insert('curso', $curso) != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return $this->db->insert_id();

			} else {
				return false;
			}
		}

		function update_record($curso, $id)
		{
			$this->db->where('id', $id);

			if ( ($this->db->update('curso', $curso) != null)
					//&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		/*function delete_record($id)
		{
			$this->db->where('id', $id);

			if ( ($this->db->delete('curso') != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}*/

		function toggle_record($id, $ativo_inativo)
		{
			$data = array(
				'ativo_inativo' => $ativo_inativo
			);

			$this->db->where('id', $id);

			if ( ($this->db->update('curso', $data) != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function add_record_modalidade($modalidade)
		{
			if ( ($this->db->insert('curso_modalidade', $modalidade) != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return $this->db->insert_id();

			} else {
				return false;
			}
		}

		function update_record_modalidade($modalidade, $id_curso)
		{
			$this->db->where('id_curso', $id_curso);

			if ( ($this->db->update('curso_modalidade', $modalidade) != null)
					//&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function delete_record_modalidade($id_curso)
		{
			$this->db->where('id_curso', $id_curso);

			if ( ($this->db->delete('curso_modalidade') != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function get_status($id_curso) {

			$this->db->select('status');
			$this->db->from('curso');
			$this->db->where('id', $id_curso);

			if (($query = $this->db->get()) != NULL) {

				return $query->row();

			} else {				
				return false;
			}
		}

		function toogle_status($id_curso, $status){
			
			$this->db->where('id', $id_curso);

			$data = array(
				'status' => $status
			);

			if ( ($this->db->update('curso', $data) != null)
					//&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}
	} 
 ?>