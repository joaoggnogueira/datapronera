<?php 

	class Pessoa_m extends CI_Model {

		function get_record($id)
		{	

			$this->db->select('p.*, c.email, e.id AS id_estado');
			$this->db->from('pessoa p');
			$this->db->join('conta c', 'p.id = c.id_pessoa', 'left');
			$this->db->join('cidade cd', 'p.id_cidade = cd.id', 'left');
			$this->db->join('estado e', 'cd.id_estado = e.id', 'left');
			$this->db->where('p.id', $id);

			$query = $this->db->get();

			if ($query->num_rows == 1) {
				return $query->result();

			} else {
				return false;
			}
		}

		function add_record($pessoa)
		{
			if ( ($this->db->insert('pessoa', $pessoa) != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return $this->db->insert_id();

			} else {
				return false;
			}
		}

		function update_record($pessoa, $id)
		{
			$this->db->where('id', $id);

			if ( ($this->db->update('pessoa', $pessoa) != null)
					//&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function toggle_record($id, $ativo_inativo)
		{
			$pessoa = array(
				'ativo_inativo' => $ativo_inativo
			);

			$this->db->where('id', $id);

			if ( ($this->db->update('pessoa', $pessoa) != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function add_record_conta($conta)
		{
			if ( ($this->db->insert('conta', $conta) != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return $this->db->insert_id();

			} else {
				return false;
			}
		}

		function update_record_conta($conta, $id_pessoa)
		{
			$this->db->where('id_pessoa', $id_pessoa);

			if ( ($this->db->update('conta', $conta) != null)
					//&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function toggle_record_conta($id_pessoa, $ativo_inativo)
		{
			$conta = array(
				'ativo_inativo' => $ativo_inativo
			);

			$this->db->where('id_pessoa', $id_pessoa);

			if ( ($this->db->update('conta', $conta) != null)
					//&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}	

	}