<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/** Include path **/        
set_include_path(__DIR__ . '/../third_party/spout-2.7.1/src/Spout/Autoloader');

/** PHPExcel **/
include_once("autoload.php");

use Box\Spout\Writer\WriterFactory;
use Box\Spout\Common\Type;

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

        /** CRIO ARRAYS PRIMERO **/
        $array = array();

        /** SUPERINTENDÊNCIAS **/
        array_push($array, $this->relatorio_dinamico_m->abaSuperIntendencias($this->input->post('where_superintendencias')));
        array_unshift($array[0], array('ID', 'NOME', 'RESPONSÁVEL', 'STATUS', 'ESTADO'));

        /** CURSOS **/
        array_push($array, $this->relatorio_dinamico_m->abaCursos($this->input->post('where_curso')));
        array_unshift($array[1], array('ID', 'NOME', 'SUPERINTENDÊNCIA', 'NÍVEL_CURSO', 'MODALIDADE', 'OBSERVAÇÃO', 'ÁREA_CONHECIMENTO', 'COORDENADOR_GERAL', 'TITULAÇÃO_COORDENADOR_GERAL', 'COORDENADOR_PROJETO', 'TITULAÇÃO_COORDENADOR_PROJETO', 'VICE_COORDENADOR', 'TITULAÇÃO_VICE_COORDENADOR', 'COORDENADOR_PEDAGÓGICO', 'TITULAÇÃO_COORDENADOR_PEDAGÓGICO', 'DURAÇÃO_CURSO_ANOS', 'MÊS_ANO_PREVISTO_INICIO', 'MÊS_ANO_PREVISTO_TÉRMINO', 'MÊS_ANO_REALIZADO_INICIO', 'MÊS_ANO_REALIZADO_TÉRMINO', 'NÚMERO_TURMAS', 'NÚMERO_INGRESSANTES', 'NÚMERO_CONCLUINTES', 'NÚMERO_BOLSISTAS'));

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

        $writer = WriterFactory::create(Type::XLSX); // for XLSX files
        //$writer = WriterFactory::create(Type::CSV); // for CSV files
        //$writer = WriterFactory::create(Type::ODS); // for ODS files

        //$writer->openToFile($filePath); // write data to a file or to a PHP stream
        $writer->openToBrowser('rel_dinamico.xlsx'); // stream data directly to the browser

        /** SUPERINTENDENCIAS **/
        $currentSheet = $writer->getCurrentSheet();
        $currentSheet->setName('Superintendências');
        $writer->addRows($array[0]);

        /** CURSOS **/

        $currentSheet = $writer->addNewSheetAndMakeItCurrent();
        $currentSheet->setName('Cursos');
        $writer->addRows($array[1]); // writes the row to the new sheet

        /** CIDADES_CURSOS **/
        $currentSheet = $writer->addNewSheetAndMakeItCurrent();
        $currentSheet->setName('Cidades Cursos');
        $writer->addRows($array[2]); // writes the row to the new sheet

        /** EDUCANDOS **/
        $currentSheet = $writer->addNewSheetAndMakeItCurrent();
        $currentSheet->setName('Educandos');
        $writer->addRows($array[3]); // writes the row to the new sheet

        /** CIDADES_EDUCANDOS **/
        $currentSheet = $writer->addNewSheetAndMakeItCurrent();
        $currentSheet->setName('Cidades Educandos');
        $writer->addRows($array[4]); // writes the row to the new sheet

        /** PROFESSORES **/
        $currentSheet = $writer->addNewSheetAndMakeItCurrent();
        $currentSheet->setName('Professores');
        $writer->addRows($array[5]); // writes the row to the new sheet

        /** DISCIPLINAS **/
        $currentSheet = $writer->addNewSheetAndMakeItCurrent();
        $currentSheet->setName('Disciplinas');
        $writer->addRows($array[6]); // writes the row to the new sheet

        /** INSTITUICOES DE ENSINO **/
        $currentSheet = $writer->addNewSheetAndMakeItCurrent();
        $currentSheet->setName('Instituições de Ensino');
        $writer->addRows($array[7]); // writes the row to the new sheet

        /** CIDADES_INSTITUICOES_DE_ENSINO **/
        $currentSheet = $writer->addNewSheetAndMakeItCurrent();
        $currentSheet->setName('Cidades Instituições de Ensino');
        $writer->addRows($array[8]); // writes the row to the new sheet

        /** ORGANIZAÇÕES DEMANDANTES **/
        $currentSheet = $writer->addNewSheetAndMakeItCurrent();
        $currentSheet->setName('Organizações Demandantes');
        $writer->addRows($array[9]); // writes the row to the new sheet

        /** COORDENADORES DAS ORGANIZAÇÕES **/
        $currentSheet = $writer->addNewSheetAndMakeItCurrent();
        $currentSheet->setName('Coordenadores Organizações');
        $writer->addRows($array[10]); // writes the row to the new sheet

        /** PARCEIROS **/
        $currentSheet = $writer->addNewSheetAndMakeItCurrent();
        $currentSheet->setName('Parceiros');
        $writer->addRows($array[11]); // writes the row to the new sheet

        /** CIDADES PARCEIROS **/
        $currentSheet = $writer->addNewSheetAndMakeItCurrent();
        $currentSheet->setName('Cidades Parceiros');
        $writer->addRows($array[12]); // writes the row to the new sheet

        /** TIPOS DE PARCERIA **/
        $currentSheet = $writer->addNewSheetAndMakeItCurrent();
        $currentSheet->setName('Tipos Parceria');
        $writer->addRows($array[13]); // writes the row to the new sheet


        $writer->close();

    }

}

/* End of file relatorio_dinamico.php */
/* Location: ./application/controllers/relatorio_dinamico.php */