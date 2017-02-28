<?php

class Caracterizacao_m extends CI_Model {

    function get_record($id_curso) {
        // Getting couse's name and data caracterization
        $this->db->select('c.nome, c.id_modalidade, cr.*, c.data, sp.nome superintendencia');
        $this->db->from('caracterizacao cr');
        $this->db->join('curso c', 'cr.id_curso = c.id', 'left');
        $this->db->join('superintendencia sp', 'sp.id = c.id_superintendencia', 'left');
        $this->db->where('c.id', $id_curso);

        $query = $this->db->get();

        if ($query->num_rows == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    function add_record($caracterizacao) {
        if (($this->db->insert('caracterizacao', $caracterizacao) != null) && ($this->db->affected_rows() > 0)
        ) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    function update_record($caracterizacao, $id) {
        $this->db->where('id_curso', $id);

        if (($this->db->update('caracterizacao', $caracterizacao) != null)
        //&& ($this->db->affected_rows() > 0) 
        ) {
            return true;
        } else {
            return false;
        }
    }

    function add_record_municipios($mun) {
        if (($this->db->insert('caracterizacao_cidade', $mun) != null) && ($this->db->affected_rows() > 0)
        ) {
            return true;
        } else {
            return false;
        }
    }

    function delete_record_municipios($id_cidade, $id) {

        $this->db->where('id_cidade', $id_cidade);
        $this->db->where('id_caracterizacao', $id);
        $this->db->delete('caracterizacao_cidade');
        return;
    }

    function update_inicio_curso($data, $id_curso) {
        $this->db->where('id_curso', $id_curso);

        if (($this->db->update('caracterizacao', $data) != null)
        //&& ($this->db->affected_rows() > 0) 
        ) {
            return true;
        } else {
            return false;
        }
    }

}
