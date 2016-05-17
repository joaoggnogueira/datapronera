<?php 

	class Educando_m extends CI_Model {


		function get_record($id)
		{
			$this->db->select('e.*, cr.inicio_realizado inicio_curso');
			$this->db->from('educando e');
			$this->db->join('caracterizacao cr', 'cr.id_curso = e.id_curso', 'left');
			$this->db->where('e.id', $id);

			$query = $this->db->get();

			if ($query->num_rows == 1) {
				return $query->result();

			} else {
				return false;
			}
		}

		function get_course_record($id_curso)
		{

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

		function get_tipo_acamp($id)
		{
			$this->db->where('id', $id);
			$this->db->select('tipo_territorio');
			$query = $this->db->get('educando');
			
			$dados =  $query->result();
			return ($dados[0]->tipo_territorio);
		}
		function get_estado_municipio($id)
		{
			$query = $this->db->query("select estado.id as 'estado', cidade.id as 'cidade' from educando_cidade, cidade, estado where cidade.id = educando_cidade.id_cidade and estado.id = cidade.id_estado and id_educando = ".$id);
			$dados = $query->result();
			return $dados;
		}

		function add_record($educando)
		{
			if ( ($this->db->insert('educando', $educando) != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return $this->db->insert_id();

			} else {
				return false;
			}
		}

		function add_record_municipio($mun)
		{
			if ( ($this->db->insert('educando_cidade', $mun) != null)
					&& ($this->db->affected_rows() > 0)
			   )
			{
				return true;
				
			} else {
				return false;
			}
		}
		function update_record_municipio($municipio, $id){
			$this->db->where('id_educando', $id);
			$this->db->update('educando_cidade', $municipio);
			return;
		}
		function update_record($educando, $id)
		{
			$this->db->where('id', $id);

			if ( ($this->db->update('educando', $educando) != null)
					//&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}

		function delete_record_municipio($id_cidade, $id)
		{
			$this->db->where('id_educando', $id);
			$this->db->where('id_cidade', $id_cidade);
			$this->db->delete('educando_cidade');
			return;
		}

		function delete_record($id)
		{
			$this->db->where('id', $id);

			if ( ($this->db->delete('educando') != null)
					&& ($this->db->affected_rows() > 0) 
			   )
			{
				return true;

			} else {
				return false;
			}
		}
	} 


 ?>