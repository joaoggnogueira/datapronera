<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Relatorio_dinamico extends CI_Controller {

	private $access_level;

    public function __construct() {

        parent::__construct();

        $this->load->database();            // Loading Database
        $this->load->library('session');    // Loading Session
        $this->load->helper('url');         // Loading Helper

        $this->load->model('relatorio_dinamico_m');  // Loading Model
    }

    /*
    	Verificar níveis de acesso
     */
    public function index() {

    	//if ($this->session->userdata('access_level') > 3){
			$this->session->set_userdata('curr_content', 'rel_dinamico');
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

    /**
     * Redireciona o chamado para o método mais a baixo, filtrando segundo ao dado informado e evitando a criação
     * do arquivo PDF desnecessariamente.
     * @method Router
     * @param  [type] $informacoes [description]
     */
    public function Router($informacoes)
    {
        switch ($informacoes) {
    		case 'curso':
                $informacoes = $this->input->post('data');
                $this->dataModeler($informacoes, 'Curso');
    			break;

            case 'professor':
                $informacoes = $this->input->post('data');
                $this->dataModeler($informacoes, 'Professor');
                break;

            case 'educando':
                $informacoes = $this->input->post('data');
                $this->dataModeler($informacoes, 'Educando');
                break;

            case 'ies':
                $informacoes = $this->input->post('data');
                $this->dataModeler($informacoes, 'Instituição de Ensino');
                break;

            case 'parceiro':
                $informacoes = $this->input->post('data');
                $this->dataModeler($informacoes, 'Parceiro');
                break;
    	}

    }

    /**
     * Este método requisita e recebe os dados solicitados pelo usuário a model, e então os repassa para a view onde será
     * montado os resultados da pesquisa para que possa ser salvo em PDF.
     * @method dataModeler
     * @param  [Array]        $informacoes [São as colunas que se deseja receber do Banco de dados]
     * @param  [String]       $tipo [Utilizado para definir qual o método do model será chamado]
     * @return [null]
     */
    public function dataModeler($informacoes, $tipo)
    {
        $this->load->library('pdf');

        $pdf = $this->pdf->load();
        $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');

        $data['titulo_relatorio'] = "Relatório Dinâmico - Predefinições de Usuário<br> Informação principal - $tipo<br>";
        $html = $this->load->view('include/header_pdf', $data, true);

        $pdf->WriteHTML($html);

        $atributos = $this->montarAtributos($informacoes);

        switch ($tipo) {
            case 'Curso':
                $query = $this->relatorio_dinamico_m->cursoAdj($atributos);
                break;

            case 'Professor':
                $query = $this->relatorio_dinamico_m->professorAdj($atributos);
                break;

            case 'Educando':
                $query = $this->relatorio_dinamico_m->educandoAdj($atributos);
                break;

            case 'Instituição de Ensino':
                $query = $this->relatorio_dinamico_m->instituicaoEnsinoAdj($atributos);
                break;

            case 'Parceiro':
                $query = $this->relatorio_dinamico_m->parceiroAdj($atributos);
                break;
        }

        $data = array('query' => $query->result_array(), 'campos' => $informacoes);
        $html = $this->load->view('relatorio/dinamico/relatorio', $data, true);

        $pdf->WriteHTML($html);
        $pdf->Output("rldm.pdf", 'F');
    }

    private function montarAtributos($informacoes, $str='')
    {
        foreach ($informacoes as $value)
        {
            $str = $str.$value.", ";
        }

        return substr($str, 0, -2);
    }

    /*
    	curso (OK), professor (OK), educando (OK) (educando_cidade (N)),
        movimento (N), parceiro (OK), instituicao_ensino (OK)
     */

}

/* End of file relatorio_dinamico.php */
/* Location: ./application/controllers/relatorio_dinamico.php */