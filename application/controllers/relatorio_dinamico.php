<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Relatorio_dinamico extends CI_Controller {

	private $access_level;
    private $excel;

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

    public function gerarRelatorio(){
        /** Error reporting **/
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        ini_set('memory_limit', '2048M'); // or you could use 1G
        ini_set('max_execution_time', 123456);
        date_default_timezone_set('Europe/London');

        define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

        /** Include path **/        
        set_include_path(__DIR__ . '/../third_party/phpexcel/classes');

        /** PHPExcel **/
        include 'PHPExcel.php';

        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array( ' memoryCacheSize ' => '8MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

        $this->excel = new PHPExcel();


        /** CRIO ARRAYS PRIMERO **/
        $array = array();

        /** SUPERINTENDÊNCIAS **/
        array_push($array, $this->relatorio_dinamico_m->abaSuperIntendencias($this->input->post('where_superintendencias')));
        array_unshift($array[0], array('ID', 'NOME', 'RESPONSÁVEL', 'STATUS', 'ESTADO'));

        /** CURSOS **/
        array_push($array, $this->relatorio_dinamico_m->abaCursos($this->input->post('where_curso')));
        array_unshift($array[1], array('ID', 'NOME', 'SUPERINTENDÊNCIA', 'NÍVEL_CURSO', 'OBSERVAÇÃO', 'ÁREA_CONHECIMENTO', 'COORDENADOR_GERAL', 'TITULAÇÃO_COORDENADOR_GERAL', 'COORDENADOR_PROJETO', 'TITULAÇÃO_COORDENADOR_PROJETO', 'VICE_COORDENADOR', 'TITULAÇÃO_VICE_COORDENADOR', 'COORDENADOR_PEDAGÓGICO', 'TITULAÇÃO_COORDENADOR_PEDAGÓGICO', 'DURAÇÃO_CURSO_ANOS', 'MÊS_ANO_PREVISTO_INICIO', 'MÊS_ANO_PREVISTO_TÉRMINO', 'MÊS_ANO_REALIZADO_INICIO', 'MÊS_ANO_REALIZADO_TÉRMINO', 'NÚMERO_TURMAS', 'NÚMERO_INGRESSANTES', 'NÚMERO_CONCLUINTES', 'NÚMERO_BOLSISTAS'));

        /** CIDADES_CURSOS **/
        array_push($array, $this->relatorio_dinamico_m->abaCidadeCursos($this->input->post('where_cidade_cursos')));
        array_unshift($array[2], array('ID_CURSO', 'CIDADE', 'ESTADO'));

        /** EDUCANDOS **/
        array_push($array, $this->relatorio_dinamico_m->abaEducandos($this->input->post('where_educandos')));
        array_unshift($array[3], array('CURSO_VINCULADO', 'ID', 'NOME', 'GÊNERO', 'DATA_NASCIMENTO', 'IDADE', 'TIPO_TERRITÓRIO', 'NOME_TERRITÓRIO', 'CONCLUINTE'));

        /** CIDADES_EDUCANDOS **/
        array_push($array, $this->relatorio_dinamico_m->abaCidadeEducandos($this->input->post('where_cidade_educandos')));
        array_unshift($array[4], array('CURSO_VINCULADO', 'ID_EDUCANDO', 'NOME_CIDADE', 'ESTADO'));

        /** PROFESSORES **/
        array_push($array, $this->relatorio_dinamico_m->abaProfessores($this->input->post('where_professores')));
        array_unshift($array[5], array('CURSO_VINCULADO', 'ID', 'NOME', 'GÊNERO', 'TITULAÇÃO'));

        /** DISCIPLINAS **/
        array_push($array, $this->relatorio_dinamico_m->abaDisciplinas($this->input->post('where_disciplinas')));
        array_unshift($array[6], array('CURSO_VINCULADO', 'ID', 'NOME', 'PROFESSOR_RESPONSÁVEL'));

        /** INSTITUICOES DE ENSINO **/
        array_push($array, $this->relatorio_dinamico_m->abaInstituicoesEnsino($this->input->post('where_ie')));
        array_unshift($array[7], array('CURSO_VINCULADO', 'ID', 'NOME', 'SIGLA', 'UNIDADE', 'DEPARTAMENTO', 'LOGRADOURO', 'Nº', 'COMPLEMENTO', 'BAIRRO', 'CEP', 'TELEFONE_1', 'TELEFONE_2', 'PÁGINA_WEB', 'CÂMPUS', 'NATUREZA_INSTITUIÇÃO'));

        /** CIDADES_INSTITUICOES_DE_ENSINO **/
        array_push($array, $this->relatorio_dinamico_m->abaCidadesInstituicoesEnsino($this->input->post('where_cidades_ie')));
        array_unshift($array[8], array('CURSO_VINCULADO', 'ID_INSTITUIÇÃO_ENSINO', 'CIDADE', 'ESTADO'));

        /** ORGANIZAÇÕES DEMANDANTES **/
        array_push($array, $this->relatorio_dinamico_m->abaOrganizacoesDemandantes($this->input->post('where_org_demandantes')));
        array_unshift($array[9], array('CURSO_VINCULADO', 'ID', 'NOME', 'ABRANGÊNCIA', 'DATA_FUNDAÇÃO_NACIONAL', 'DATA_FUNDAÇÃO_ESTADUAL', 'Nº_ACAMPAMENTOS Nº_ASSENTAMENTOS', 'Nº_FAMÍLIAS_ASSENTADAS', 'Nº_PESSOAS_ENVOLVIDAS_CURSO', 'FONTE_INFORMAÇÕES'));

        /** COORDENADORES DAS ORGANIZAÇÕES **/
        array_push($array, $this->relatorio_dinamico_m->abaCoordenadoresOrganizacoesDemandantes($this->input->post('where_coord_org_demandantes')));
        array_unshift($array[10], array('CURSO_VINCULADO', 'ORGANIZAÇÃO_DEMANDANTE_VINCULADA', 'ID', 'NOME', 'GRAU_ESCOLARIDADE_EPOCA_CURSO', 'GRAU_ESCOLARIDADE_ATUAL', 'ESTUDOU_CURSO_PRONERA'));

        /** PARCEIROS **/
        array_push($array, $this->relatorio_dinamico_m->abaParceiros($this->input->post('where_parceiros')));
        array_unshift($array[11], array('CURSO_VINCULADO', 'ID', 'NOME', 'SIGLA', 'LOGRADOURO', 'Nº', 'COMPLEMENTO', 'BAIRRO', 'CEP', 'TELEFONE_1', 'TELEFONE_2', 'PAGINA_WEB', 'NATUREZA_INSTITUIÇÃO', 'ABRANGÊNCIA'));

        /** CIDADES PARCEIROS **/
        array_push($array, $this->relatorio_dinamico_m->abaCidadesParceiros($this->input->post('where_cidades_parceiros')));
        array_unshift($array[12], array('ID_PARCEIRO', 'CIDADE', 'ESTADO'));

        /** TIPOS DE PARCERIA **/
        array_push($array, $this->relatorio_dinamico_m->abaTiposParceiros($this->input->post('where_tipos_parceiros')));
        array_unshift($array[13], array('ID_PARCEIRO', 'REALIZAÇÃO_CURSO', 'CERTIFICAÇÃO_CURSO', 'GESTÃO_ORÇAMENTÁRIA', 'OUTRAS', 'COMPLEMENTO'));

        /** FIM ARRAY **/

        /** GERO XLS **/

        /** SUPERINTENDENCIAS **/
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Superintendências');
        $this->excel->getActiveSheet()->fromArray($array[0], NULL, 'A1');

        /** CURSOS **/
        $this->excel->createSheet();
        $this->excel->setActiveSheetIndex(1);
        $this->excel->getActiveSheet()->setTitle('Cursos');
        $this->excel->getActiveSheet()->fromArray($array[1], NULL, 'A1');

        /** CIDADES_CURSOS **/
        $this->excel->createSheet();
        $this->excel->setActiveSheetIndex(2);
        $this->excel->getActiveSheet()->setTitle('Cidades Cursos');
        $this->excel->getActiveSheet()->fromArray($array[2], NULL, 'A1');

        /** EDUCANDOS **/
        $this->excel->createSheet();
        $this->excel->setActiveSheetIndex(3);
        $this->excel->getActiveSheet()->setTitle('Educandos');
        $this->excel->getActiveSheet()->fromArray($array[3], NULL, 'A1');

        /** CIDADES_EDUCANDOS **/
        $this->excel->createSheet();
        $this->excel->setActiveSheetIndex(4);
        $this->excel->getActiveSheet()->setTitle('Cidades Educandos');
        $this->excel->getActiveSheet()->fromArray($array[4], NULL, 'A1');

        /** PROFESSORES **/
        $this->excel->createSheet();
        $this->excel->setActiveSheetIndex(5);
        $this->excel->getActiveSheet()->setTitle('Professores');
        $this->excel->getActiveSheet()->fromArray($array[5], NULL, 'A1');

        /** DISCIPLINAS **/
        $this->excel->createSheet();
        $this->excel->setActiveSheetIndex(6);
        $this->excel->getActiveSheet()->setTitle('Disciplinas');
        $this->excel->getActiveSheet()->fromArray($array[6], NULL, 'A1');

        /** INSTITUICOES DE ENSINO **/
        $this->excel->createSheet();
        $this->excel->setActiveSheetIndex(7);
        $this->excel->getActiveSheet()->setTitle('Instituições de Ensino');
        $this->excel->getActiveSheet()->fromArray($array[7], NULL, 'A1');

        /** CIDADES_INSTITUICOES_DE_ENSINO **/
        $this->excel->createSheet();
        $this->excel->setActiveSheetIndex(8);
        $this->excel->getActiveSheet()->setTitle('Cidades das IE');
        $this->excel->getActiveSheet()->fromArray($array[8], NULL, 'A1');

        /** ORGANIZAÇÕES DEMANDANTES **/
        $this->excel->createSheet();
        $this->excel->setActiveSheetIndex(9);
        $this->excel->getActiveSheet()->setTitle('Organizações Demandantes');
        $this->excel->getActiveSheet()->fromArray($array[9], NULL, 'A1');

        /** COORDENADORES DAS ORGANIZAÇÕES **/
        $this->excel->createSheet();
        $this->excel->setActiveSheetIndex(10);
        $this->excel->getActiveSheet()->setTitle('Coordenadores das Org.');
        $this->excel->getActiveSheet()->fromArray($array[10], NULL, 'A1');

        /** PARCEIROS **/
        $this->excel->createSheet();
        $this->excel->setActiveSheetIndex(11);
        $this->excel->getActiveSheet()->setTitle('Parceiros');
        $this->excel->getActiveSheet()->fromArray($array[11], NULL, 'A1');

        /** CIDADES PARCEIROS **/
        $this->excel->createSheet();
        $this->excel->setActiveSheetIndex(12);
        $this->excel->getActiveSheet()->setTitle('Cidades dos Parceiros');
        $this->excel->getActiveSheet()->fromArray($array[12], NULL, 'A1');

        /** TIPOS DE PARCERIA **/
        $this->excel->createSheet();
        $this->excel->setActiveSheetIndex(13);
        $this->excel->getActiveSheet()->setTitle('Tipos de Parceria');
        $this->excel->getActiveSheet()->fromArray($array[13], NULL, 'A1');

        $filename='rel_dinamico.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }

}

/* End of file relatorio_dinamico.php */
/* Location: ./application/controllers/relatorio_dinamico.php */