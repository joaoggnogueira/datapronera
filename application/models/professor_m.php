<?php

class Professor_m extends CI_Model {

    function get_record($id) {
        $this->db->where('id', $id);

        $query = $this->db->get('professor');

        if ($query->num_rows == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    function add_record($professor) {
        if (($this->db->insert('professor', $professor) != null) && ($this->db->affected_rows() > 0)
        ) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    function add_record_disciplina($disciplina) {
        if (($this->db->insert('disciplina', $disciplina) != null) && ($this->db->affected_rows() > 0)
        ) {
            return true;
        } else {
            return false;
        }
    }

    function update_record($professor, $id) {
        $this->db->where('id', $id);

        if (($this->db->update('professor', $professor) != null)
        //&& ($this->db->affected_rows() > 0) 
        ) {
            return true;
        } else {
            return false;
        }
    }

    function delete_record($id) {
        $this->db->where('id', $id);

        if (($this->db->delete('professor') != null) && ($this->db->affected_rows() > 0)
        ) {
            return true;
        } else {
            return false;
        }
    }

    function delete_record_disciplinas($disc_id, $id_professor) {
        $this->db->where('id_professor', $id_professor);
        $this->db->where('id', $disc_id);
        $this->db->delete('disciplina');
        return $this->db->affected_rows() != 0;
    }

    function sugestao_genero($name) {
        $name = explode(" ", urldecode($name));
        $name = $name[0] . " %";
        $sql = "SELECT 
        (SELECT COUNT(id) FROM `professor` WHERE `nome` like ? AND`genero` like 'F') as 'feminino',
        (SELECT COUNT(id) FROM `professor` WHERE `nome` like ? AND`genero` like 'M') as 'masculino'";

        $query = $this->db->query($sql, array($name, $name));
        $dados = $query->result();

        $feminino = (int) $dados[0]->feminino;
        $masculino = (int) $dados[0]->masculino;

        if ($feminino + $masculino == 0) {
            return "I";
        } else {
            return ($feminino > $masculino ? "F" : "M");
        }
    }
    
    function sugestao_disciplina($name){
        $name = urldecode($name);
        $name = "$name%";
        $sql = "SELECT DISTINCT `nome` FROM `disciplina` WHERE `nome` like ? ORDER BY `nome`";
        
        $query = $this->db->query($sql, array($name, $name));
        $data_result = $query->result();
        $result = array();
        foreach($data_result as $key => $dado){
            $result[] = $dado->nome;
        }
        return json_encode($result);
    }

}

?>