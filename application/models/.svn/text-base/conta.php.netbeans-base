<?php

class Conta extends CI_Model {

	function allow() {

		$this->db->select('p.id, p.cpf, c.senha, c.email, p.nome, p.id_funcao, f.nivel_acesso, p.id_superintendencia');
		$this->db->from('conta c');
		$this->db->join('pessoa p','p.id = c.id_pessoa','left');
		$this->db->join('funcao f','f.id = p.id_funcao','left');
		$this->db->where('p.cpf', $this->input->post('cpf'));
		$this->db->where('c.ativo_inativo', 'A');

		$result = $this->db->get();		

		if ($result->num_rows == 1) {
			return $result->row();

		} else {
			return false;
		}
	}

	function validate($_password) {

		if ($_password == md5($this->input->post('senha'))) {
			return true;

		} else {
			return false;
		}
	}

	function check_email() {

		$this->db->where('email', $this->input->post('email'));

		$result = $this->db->get('conta');

		if ($result->num_rows == 1) {
			return true;

		} else {
			return false;
		}
	}

	function update_password($_cpf, $_old_password, $_new_password) {

		$data = array(
			'senha' => md5($_new_password)
		);

		$this->db->where('cpf', $_cpf);

		if  ( (($query = $this->db->get('pessoa')) != null)
				&& ($query->num_rows == 1)
			) 
		{
			$row = $query->row();
			$id_pessoa = $row->id;

			$where = array(
				'id_pessoa' => $id_pessoa,
				'senha'  => $_old_password
			);

			if ( ($this->db->update('conta', $data, $where) != null)
					&& ($this->db->affected_rows() > 0)
			   )
			{
				return $id_pessoa;

			} else {
				return false;
			}

		} else {
			return false;
		}
	}

	function deactive_conta($id_pessoa) {

		$conta = array(
			'ativo_inativo' => 'I'
		);

		$this->db->where('id_pessoa', $id_pessoa);

		if ( ($this->db->update('conta', $conta) != null)
				&& ($this->db->affected_rows() > 0) 
		   )
		{
			return true;

		} else {
			return false;
		}
	}

	function update_email($_cpf, $_password, $_new_email) {

		$data = array(
			'email' => $_new_email
		);

		$this->db->where('cpf', $_cpf);

		if  ( (($query = $this->db->get('pessoa')) != null)
				&& ($query->num_rows == 1)
			) 
		{
			$row = $query->row();
			$id_pessoa = $row->id;

			$where = array(
				'id_pessoa' => $id_pessoa,
				'senha' => $_password
			);

			if ( ($this->db->update('conta', $data, $where) != null)
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

	function reset_password($_cpf, $_new_password) {

		$data = array(
			'senha' => md5($_new_password)
		);

		$this->db->where('cpf', $_cpf);

		if  ( (($query = $this->db->get('pessoa')) != null)
				&& ($query->num_rows == 1)
			) 
		{
			$row = $query->row();
			$id_pessoa = $row->id;

			$where = array(
				'id_pessoa' => $id_pessoa
			);

			if ( ($this->db->update('conta', $data, $where) != null)
					&& ($this->db->affected_rows() > 0)
			   )
			{
				return $id_pessoa;

			} else {
				return false;
			}

		} else {
			return false;
		}
	}

}