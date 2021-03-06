<?php

class Curso_m extends CI_Model {

    function get_record($id) {
        $this->db->where('id', $id);

        $query = $this->db->get('curso');

        if ($query->num_rows == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    function add_record($curso) {
        if (($this->db->insert('curso', $curso) != null) && ($this->db->affected_rows() > 0)
        ) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    
    function get_sr_uf($curso_id){
        $this->db->select("s.id_estado uf");
        $this->db->from('curso c');
        $this->db->join('superintendencia s', 's.id = c.id_superintendencia', 'left');
        $this->db->where('c.id', $curso_id);
        
        $query = $this->db->get();

        $dados = $query->result();
        
        return $dados[0]->uf;
    }

    function update_record($curso, $id) {
        $this->db->where('id', $id);

        if (($this->db->update('curso', $curso) != null)
        //&& ($this->db->affected_rows() > 0) 
        ) {
            return true;
        } else {
            return false;
        }
    }

    /* function delete_record($id)
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
      } */

    function toggle_record($id, $ativo_inativo) {
        $data = array(
            'ativo_inativo' => $ativo_inativo
        );

        $this->db->where('id', $id);

        if (($this->db->update('curso', $data) != null) && ($this->db->affected_rows() > 0)
        ) {
            return true;
        } else {
            return false;
        }
    }

    function delete_record_pesquisadores($id_pesquisador, $id_curso) {
        $this->db->where('id_pessoa', $id_pesquisador);
        $this->db->where('id_curso', $id_curso);
        $this->db->delete('pesquisador_curso');
        return true;
    }

    function add_record_pesquisador($pesquisador) {
        if (($this->db->insert('pesquisador_curso', $pesquisador) != null) && ($this->db->affected_rows() > 0)) {
            return true;
        } else {
            return false;
        }
    }

    function add_record_instrumento($instrumento) {
        if (($this->db->insert('curso_tipo_instrumento', $instrumento) != null) && ($this->db->affected_rows() > 0)
        ) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    function add_record_modalidade($modalidade) {
        if (($this->db->insert('curso_modalidade', $modalidade) != null) && ($this->db->affected_rows() > 0)
        ) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    function update_record_modalidade($modalidade, $id_curso) {
        $this->db->where('id_curso', $id_curso);

        if (($this->db->update('curso_modalidade', $modalidade) != null)
        //&& ($this->db->affected_rows() > 0) 
        ) {
            return true;
        } else {
            return false;
        }
    }

    function delete_record_modalidade($id_curso) {
        $this->db->where('id_curso', $id_curso);

        if (($this->db->delete('curso_modalidade') != null) && ($this->db->affected_rows() > 0)
        ) {
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

    function toogle_status($id_curso, $status) {

        $this->db->where('id', $id_curso);

        $data = array(
            'status' => $status
        );

        if (($this->db->update('curso', $data) != null)
        //&& ($this->db->affected_rows() > 0) 
        ) {
            return true;
        } else {
            return false;
        }
    }

}

?>