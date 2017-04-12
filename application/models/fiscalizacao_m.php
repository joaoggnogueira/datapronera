<?php

class Fiscalizacao_m extends CI_Model {

    function get_id_superintendencia($id) {
        $this->db->select('c.id_superintendencia id_superintendencia');
        $this->db->from('curso c');
        $this->db->where('c.id', $id);
        $query = $this->db->get();
        if ($query->num_rows == 1) {
            $dados = $query->result();
        } else {
            return false;
        }
        return $dados;
    }

    function get_record($id) {
        $this->db->where('id', $id);

        $query = $this->db->get('fiscalizacao');

        if ($query->num_rows == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    function add_record($fiscalizacao) {
        if (($this->db->insert('fiscalizacao', $fiscalizacao) != null) && ($this->db->affected_rows() > 0)
        ) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    function update_record($fiscalizacao, $id) {
        $this->db->where('id', $id);

        if (($this->db->update('fiscalizacao', $fiscalizacao) != null)
        //&& ($this->db->affected_rows() > 0) 
        ) {
            return true;
        } else {
            return false;
        }
    }

    function delete_record($id) {
        $this->db->where('id', $id);

        if (($this->db->delete('fiscalizacao') != null) && ($this->db->affected_rows() > 0)
        ) {
            return true;
        } else {
            return false;
        }
    }

    function add_record_membro($coord) {
        if (($this->db->insert('fiscalizacao_membro', $coord) != null) && ($this->db->affected_rows() > 0)
        ) {
            return true;
        } else {
            return false;
        }
    }

    function delete_record_membro($id_pessoa, $id_fiscalizacao) {
        $this->db->where('id_fiscalizacao', $id_fiscalizacao);
        $this->db->where('id_pessoa', $id_pessoa);
        $this->db->delete('fiscalizacao_membro');
        return;
    }

    function delete_all_record_membro($id_fiscalizacao) {
        $this->db->where('id_fiscalizacao', $id_fiscalizacao);
        $this->db->delete('fiscalizacao_membro');
        return;
    }

    function add_record_tipo($tipo) {
        if (($this->db->insert('fiscalizacao_tipo', $tipo) != null) && ($this->db->affected_rows() > 0)
        ) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    function add_record_file($id_fiscalizacao, $file_data) {
        $fileName = $file_data['name'];
        $tmpName = $file_data['tmp_name'];
        $fileSize = $file_data['size'];
        $fileType = $file_data['type'];

        $content = file_get_contents($tmpName);
        $data = array(
            "name" => $fileName,
            "size" => $fileSize,
            "type" => $fileType,
            "content" => $content,
            "id_fiscalizacao" => $id_fiscalizacao
        );
        if (($this->db->insert('fiscalizacao_arquivo', $data) != null) && ($this->db->affected_rows() > 0)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    function remove_all_records_file($id_fiscalizacao) {
        $this->db->where('id_fiscalizacao', $id_fiscalizacao);
        return $this->db->delete('fiscalizacao_arquivo');
    }
    
    function get_records_file($id_fiscalizacao) {
        $this->db->where('id_fiscalizacao', $id_fiscalizacao);

        $query = $this->db->get('fiscalizacao_arquivo');

        if ($query->num_rows == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

}