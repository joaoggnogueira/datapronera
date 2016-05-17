<?php 

class Instituicao_m extends CI_Model {


	function get_record($id_curso)
	{
		$this->db->where('id_curso', $id_curso);

		$query = $this->db->get('instituicao_ensino');

		if ($query->num_rows == 1) {
			return $query->result();

		} else {
			return false;
		}
	}	

	function get_estado($id_curso)
	{	
		$this->db->select('e.id id_estado');
		$this->db->from('instituicao_ensino ie');
		$this->db->join('cidade c', 'c.id =  ie.id_cidade', 'left');
		$this->db->join('cidade e', 'e.id =  c.id_estado', 'left');
		$this->db->where('ie.id_curso', $id_curso);
		$query = $this->db->get();

		if ($query->num_rows == 1) {

			$row = $query->row();

			return $row->id_estado;

		} else {
			return false;
		}
	}

	function get_municipio($id_curso)
	{	
		$this->db->where('id_curso', $id_curso);
		$this->db->select('id_cidade');

		$query = $this->db->get('instituicao_ensino');

		if ($query->num_rows == 1) {

			$row = $query->row();

			return $row->id_cidade;

		} else {
			return false;
		}
	}	

	function add_record($instituicao)
	{
		if ( ($this->db->insert('instituicao_ensino', $instituicao) != null)
				&& ($this->db->affected_rows() > 0)
		   )
		{
			return true;
			
		} else {
			return false;
		}
	}

	function update_record($instituicao, $id)
	{
		$this->db->where('id_curso', $id);

		if ( ($this->db->update('instituicao_ensino', $instituicao) != null)
				//&& ($this->db->affected_rows() > 0) 
		   )
		{
			return true;

		} else {
			return false;
		}
	}
} 
