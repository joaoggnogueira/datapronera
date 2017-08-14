<?php

class Acesso_publico_m extends CI_Model {

    function allow($email, $senha) {

        $this->db->select('id,nome,id_cidade');
        $this->db->from('conta_publica c');
        $this->db->where('c.email', $email);
        $this->db->where('c.senha', $senha);

        $result = $this->db->get();

        if ($result->num_rows == 1) {
            return $result->row();
        } else {
            return false;
        }
    }

    function update($id, $data) {

        $where = array(
            'id' => $id
        );

        return (($this->db->update('conta_publica', $data, $where) != null) && ($this->db->affected_rows() > 0));
    }
    function update_password($id, $_old_password, $_new_password) {

        $data = array(
            'senha' => $_new_password
        );

        $where = array(
            'id' => $id,
            'senha' => $_old_password
        );

        return (($this->db->update('conta_publica', $data, $where) != null) && ($this->db->affected_rows() > 0));
    }

    function update_email($id, $_password, $_new_email) {

        $data = array(
            'email' => $_new_email
        );

        $where = array(
            'id' => $id,
            'senha' => $_password
        );

        return (($this->db->update('conta_publica', $data, $where) != null) && ($this->db->affected_rows() > 0));
        
    }

    function signup($pessoa) {
        if (($this->db->insert('conta_publica', $pessoa) != null) && ($this->db->affected_rows() > 0)
        ) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

}
