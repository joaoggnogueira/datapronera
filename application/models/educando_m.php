<?php

class Educando_m extends CI_Model {

    function get_record($id) {
        $this->db->select('e.*, s.id_estado sr_uf ,est.sigla uf ,cr.inicio_realizado inicio_curso');
        $this->db->from('educando e');
        $this->db->join('caracterizacao cr', 'cr.id_curso = e.id_curso', 'left');
        $this->db->join('educando_cidade edci', 'edci.id_educando = e.id', 'left');
        $this->db->join('cidade ci', 'edci.id_cidade = ci.id', 'left');
        $this->db->join('estado est', 'ci.id_estado = est.id', 'left');
        $this->db->join('curso cu', 'cu.id = e.id_cidade', 'left');
        $this->db->join('superintendencia s', 's.id = cu.id_superintendencia', 'left');

        $this->db->where('e.id', $id);

        $query = $this->db->get();

        if ($query->num_rows == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_educando_cidade($id) {
        $this->db->select('ec.*');
        $this->db->from('educando_cidade ec');
        $this->db->where('ec.id_educando', $id);

        $query = $this->db->get();
        return $query->result();
    }

    function get_course_record($id_curso) {

        $this->db->select('inicio_realizado inicio_curso');
        $this->db->from('caracterizacao');
        $this->db->where('id_curso', $this->session->userdata('id_curso'));

        $query = $this->db->get();

        if ($query->num_rows == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_tipo_acamp($id) {
        $this->db->where('id', $id);
        $this->db->select('tipo_territorio');
        $query = $this->db->get('educando');

        $dados = $query->result();
        return ($dados[0]->tipo_territorio);
    }

    function get_estado_municipio($id) {
        $query = $this->db->query("select estado.id as 'estado', cidade.id as 'cidade' from educando_cidade, cidade, estado where cidade.id = educando_cidade.id_cidade and estado.id = cidade.id_estado and id_educando = " . $id);
        $dados = $query->result();
        return $dados;
    }

    function add_record($educando) {
        if (($this->db->insert('educando', $educando) != null) && ($this->db->affected_rows() > 0)
        ) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    function add_record_municipio($mun) {
        if (($this->db->insert('educando_cidade', $mun) != null) && ($this->db->affected_rows() > 0)
        ) {
            return true;
        } else {
            return false;
        }
    }

    function update_record_municipio($municipio, $id) {
        $this->db->where('id_educando', $id);
        return $this->db->update('educando_cidade', $municipio);
    }

    function update_record($educando, $id) {
        $this->db->where('id', $id);

        if (($this->db->update('educando', $educando) != null)
        //&& ($this->db->affected_rows() > 0) 
        ) {
            return true;
        } else {
            return false;
        }
    }

    function remove_record_municipio($id) {
        $this->db->where('id_educando', $id);
        return $this->db->delete('educando_cidade');
    }

    function delete_record_municipio($id_cidade, $id) {
        $this->db->where('id_educando', $id);
        $this->db->where('id_cidade', $id_cidade);
        $this->db->delete('educando_cidade');
        return;
    }

    function delete_record($id) {
        $this->db->where('id', $id);

        if (($this->db->delete('educando') != null) && ($this->db->affected_rows() > 0)
        ) {
            return true;
        } else {
            return false;
        }
    }

    function sugestao_assentamento_sipra($search) {
        $search = urldecode($search);

        $this->db->select('a.codigo as c, a.nome as n, COUNT(e.id) as t');
        $this->db->from('assentamentos a');
        $this->db->like('a.codigo', $search);
        $this->db->or_like('a.nome', $search);
        $this->db->join("educando e", "e.code_sipra_assentamento = a.codigo", "left");
        $this->db->group_by("a.idAssentamento");
        //echo $this->db->last_query();
        
        return $this->get_table($this->db->get());
    }

    function sugestao_assentamento_nonsipra($search) {
        $search = urldecode($search);

        $this->db->select("nome_territorio as n, tipo_territorio as c, COUNT(id) as t");
        $this->db->from("educando");
        $this->db->like("nome_territorio", $search);
        $this->db->where("(code_sipra_assentamento IS NULL OR code_sipra_assentamento like '')", null, false);
        $this->db->group_by("nome_territorio, tipo_territorio");
        //echo $this->db->last_query();
        return $this->get_table($this->db->get());
    }

    function recent_assentamento_sipra(){
        $id_curso = $this->session->userdata('id_curso');
        
        $this->db->select('a.codigo as c, a.nome as n, COUNT(e.id) as t');
        $this->db->from('assentamentos a');
        $this->db->where('e.id_curso', $id_curso);
        $this->db->join("educando e", "e.code_sipra_assentamento = a.codigo", "left");
        $this->db->group_by("a.idAssentamento");
        //echo $this->db->last_query();
        
        return $this->get_table($this->db->get());
    }
    
    function recent_assentamento_nonsipra(){
        $id_curso = $this->session->userdata('id_curso');
                
        $this->db->select("nome_territorio as n, tipo_territorio as c, COUNT(id) as t");
        $this->db->from("educando");
        $this->db->where("id_curso", $id_curso);
        $this->db->where("(code_sipra_assentamento IS NULL OR code_sipra_assentamento LIKE '')", null, false);
        $this->db->where("(nome_territorio IS NOT NULL AND nome_territorio NOT LIKE '' AND nome_territorio NOT LIKE 'NÃO ENCONTRADO')",null,false);
        $this->db->where("(tipo_territorio IS NOT NULL AND tipo_territorio NOT LIKE '')",null,false);
        $this->db->group_by("nome_territorio, tipo_territorio");
        
        return $this->get_table($this->db->get());
    }

    function sugestao_genero($name) {
        $name = explode(" ", urldecode($name));
        $name = $name[0] . " %";
        $sql = "SELECT 
        (SELECT COUNT(id) FROM `educando` WHERE `nome` like ? AND`genero` like 'F') as 'feminino',
        (SELECT COUNT(id) FROM `educando` WHERE `nome` like ? AND`genero` like 'M') as 'masculino'";

        $query = $this->db->query($sql, array($name, $name));
        $dados = $query->result();

        $feminino = (int) $dados[0]->feminino;
        $masculino = (int) $dados[0]->masculino;

        if ($feminino == $masculino) {
            return "I";
        } else {
            return ($feminino > $masculino ? "F" : "M");
        }
    }

    function get_table($query) {
//        print_r($_GET);
//        var_dump($this->db->last_query());

        $dados = $query->result_array();

        /** Output * */
        $output = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );

        foreach ($dados as $item) {
            $row = array();

            foreach ($item as $cell) {
                $row[] = $cell;
            }

            $output['aaData'][] = $row;
        }

        return $output;
    }

}

?>