<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Relatorio_mapas extends CI_Controller {

    private $access_level;

    public function __construct() {

        parent::__construct();

        $this->load->database();            // Loading Database
        $this->load->library('session');    // Loading Session
        $this->load->helper('url');         // Loading Helper
        
        $this->load->model('mapas_m');
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
    
    //MAPAS
    function get_municipios_cursos(){
        echo json_encode($this->mapas_m->get_municipios_cursos());
    }

    function get_municipios_educandos(){
        echo json_encode($this->mapas_m->get_municipios_educandos());
    }

    function get_municipios_instituicoes(){
        echo json_encode($this->mapas_m->get_municipios_instituicoes());
    }
    
    //TABELAS

    function get_instituicoes(){
        echo json_encode($this->mapas_m->get_instituicoes($this->uri->segment(3)));
    }
    
    function get_cursos(){
        echo json_encode($this->mapas_m->get_cursos($this->uri->segment(3)));
    }

    function get_educandos(){
        echo json_encode($this->mapas_m->get_educandos($this->uri->segment(3)));
    }
    
    function get_cursos_educandos(){
        echo json_encode($this->mapas_m->get_cursos_educandos($this->uri->segment(3)));
    }
    
}

/* End of file relatorio_mapas.php */
/* Location: ./application/controllers/relatorio_mapas.php */