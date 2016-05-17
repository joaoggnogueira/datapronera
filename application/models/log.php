<?php
	
	class Log extends CI_Model {

		function __construct() {			
			parent::__construct();
		}

		function save($_msg, $_id_pessoa = null) {

			$log = array(
				'mensagem'  => strtoupper($_msg),
				'ip'	    => $this->input->ip_address(),
				'data_hora' => date('Y-m-d H:i:s'),
				'id_pessoa' => $_id_pessoa ? $_id_pessoa : $this->session->userdata('id')
			);

			if ( ($this->db->insert('log', $log) != null)
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