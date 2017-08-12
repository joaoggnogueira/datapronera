<?php

class Acesso_publico_m extends CI_Model {

    function allow($email,$senha) {

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

    function signup($pessoa) {
        if (($this->db->insert('conta_publica', $pessoa) != null) && ($this->db->affected_rows() > 0)
        ) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

}
