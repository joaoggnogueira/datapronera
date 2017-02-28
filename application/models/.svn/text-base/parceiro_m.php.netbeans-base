<?php 

	class Parceiro_m extends CI_Model {


		function get_record($id)
		{
			$this->db->select('p.*, pp.realizacao, pp.certificacao, pp.gestao, pp.outros, pp.complemento parc_complemento');
			$this->db->from('parceiro p');
			$this->db->join('parceiro_parceria pp', 'p.id = pp.id_parceiro', 'left');
			$this->db->where('p.id', $id);

			$query = $this->db->get();

			if ($query->num_rows == 1) {
				return $query->result();

			} else {
				return false;
			}
		}

		function get_estado($id)
	{	
		$this->db->select('e.id id_estado');
		$this->db->from('parceiro p');
		$this->db->join('cidade c', 'c.id =  p.id_cidade', 'left');
		$this->db->join('cidade e', 'e.id =  c.id_estado', 'left');
		$this->db->where('p.id', $id);
		$query = $this->db->get();

		if ($query->num_rows == 1) {

			$row = $query->row();

			return $row->id_estado;

		} else {
			return false;
		}
	}

	function get_municipio($id)
	{	
		$this->db->where('id', $id);
		$this->db->select('id_cidade');

		$query = $this->db->get('parceiro');

		if ($query->num_rows == 1) {

			$row = $query->row();

			return $row->id_cidade;

		} else {
			return false;
		}
	}	

		function add_record($parceiro)
		{
			if ( ($this->db->insert('parceiro', $parceiro) != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return $this->db->insert_id();

			} else {
				return false;
			}
		}

		function add_record_tipo_parceria($tipo)
		{	
			if ( ($this->db->insert('parceiro_parceria', $tipo) != null)
					&& ($this->db->affected_rows() > 0)
			   )
			{
				return true;
				
			} else {
				return false;
			}
		}

		function update_record($parceiro, $id)
		{
			$this->db->where('id', $id);

			if ( ($this->db->update('parceiro', $parceiro) != null)
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

			if ( ($this->db->delete('parceiro') != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function update_record_tipo_parceria($tipo, $id)
		{
			$this->db->where('id_parceiro', $id);

			if ( ($this->db->update('parceiro_parceria', $tipo) != null)
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