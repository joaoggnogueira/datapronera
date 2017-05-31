<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Relatorio_mapas extends CI_Controller {

    private $access_level;

    public function __construct() {

        parent::__construct();

        $this->load->database();            // Loading Database
        $this->load->library('session');    // Loading Session
        $this->load->helper('url');         // Loading Helper
    }

    /*
      Verificar níveis de acesso
     */
    public function index() {

      //if ($this->session->userdata('access_level') > 3){
      $this->session->set_userdata('curr_content', 'relatorio/mapas/index');
      $this->session->set_userdata('curr_top_menu', 'menus/principal.php');
      //}

        $data['content'] = $this->session->userdata('curr_content');

        $html = array(
            'content' => $this->load->view($data['content'], '', true)
        );

        $response = array(
            'success' => true,
            'html' => $html
        );

        echo json_encode($response);
    }

}

/* End of file relatorio_dinamico.php */
/* Location: ./application/controllers/relatorio_dinamico.php */