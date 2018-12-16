<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/** Include path * */
set_include_path(__DIR__ . '/../third_party/spout-2.7.1/src/Spout/Autoloader');

/** PHPExcel * */
include_once("autoload.php");

use Box\Spout\Writer\WriterFactory;
use Box\Spout\Common\Type;
use Box\Spout\Writer\Style\StyleBuilder;
use Box\Spout\Writer\Style\Color;

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

    public function get_cursos() {
        $where_from_where = $this->relatorio_dinamico_m->stmt_from_where_curso();
        $lista = $this->relatorio_dinamico_m->list_cursos($where_from_where);
        if (count($lista) == 0) {
            echo "<option value='0' disabled selected>Nenhum curso correspondente</option>";
        } else {
            echo "<option value='0' disabled selected>Cursos de acordo com os filtros acima</option>";
            foreach ($lista as $curso) {
                echo "<option value=" . $curso['id'] . ">" . $curso['title'] . "</option>";
            }
        }
    }
    
    private function append_header($writer, $title){
        
        $style_border = (new StyleBuilder())
           ->setBackgroundColor(Color::rgb(170,255,128))
            ->setShouldWrapText(false)
           ->build();
        
        $style_body = (new StyleBuilder())
           ->setBackgroundColor(Color::rgb(230,230,230))
            ->setShouldWrapText(false)
            ->setFontBold()
           ->build();
        
        $writer->addRowWithStyle(array("-------------------------------------------------------------------------------------------------","","","","","","","","","",""), $style_border);
        $writer->addRowWithStyle(array("Programa Nacional de Educação na Reforma Agrária (Pronera)","","","","","","","","","",""), $style_body);
        $writer->addRowWithStyle(array("Cursos","","","","","","","","","",""), $style_body);
        $writer->addRowWithStyle(array("Relatório: " . $title,"","","","","","","","","",""), $style_body);
        $writer->addRowWithStyle(array("Data de Emissão: " . date('d/m/y') . " Hora da Emissão: ".date("h:i:sa"),"","","","","","","","","",""), $style_body);
        $writer->addRowWithStyle(array("-------------------------------------------------------------------------------------------------","","","","","","","","","",""), $style_border);
        $writer->addRow(array(""));
    }
    
    private function xls_this($writer, $currentSheet, $title, $header, $data) {
        $currentSheet->setName($title);
        
        $style_header = (new StyleBuilder())
           ->setFontBold()
           ->setFontSize(13)
           ->setFontColor(Color::WHITE)
           ->setBackgroundColor(Color::rgb(91,183,91))
           ->build();
        
        $this->append_header($writer, $title);
        $writer->addRowWithStyle($header, $style_header);
        $writer->addRows($data);
    }

    private function get_sheet(&$init_sheet,$writter){
        if($init_sheet){
            $init_sheet = false;
            return $writter->getCurrentSheet();
        } else {
            return $writter->addNewSheetAndMakeItCurrent();
        }
    }

    public function gerarRelatorio() {
        
        ob_start("ob_gzhandler");
        
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        ini_set('memory_limit', '2048M'); // or you could use 1G
        ini_set('max_execution_time', 123456);
        date_default_timezone_set('Europe/London');

        define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

        $where_curso = $this->relatorio_dinamico_m->stmt_from_where_curso();

        $writer = WriterFactory::create(Type::XLSX); // for XLSX files
        $time = date("h:i:sa");
        $date = date("d_m_Y");
        $writer->openToBrowser("REL_DINAMICO-DPRNRA-$time-$date.xlsx"); // stream data directly to the browser

        $init_sheet = true;
        
        if ($this->input->post('check_curso') == "true") {
            $currentSheet = $this->get_sheet($init_sheet, $writer);
            $data = $this->relatorio_dinamico_m->abaCursos($where_curso);
            $this->xls_this($writer, $currentSheet, 'Cursos', array('COD', 'NOME' , 'SUPERINTENDÊNCIA',
                'NÍVEL_CURSO', 'MODALIDADE', 'ÁREA_CONHECIMENTO', 
                'COORDENADOR_GERAL', 'TITULAÇÃO_COORDENADOR_GERAL', 'COORDENADOR_PROJETO', 
                'TITULAÇÃO_COORDENADOR_PROJETO', 'VICE_COORDENADOR', 'TITULAÇÃO_VICE_COORDENADOR', 
                'COORDENADOR_PEDAGÓGICO', 'TITULAÇÃO_COORDENADOR_PEDAGÓGICO', 'DURAÇÃO_CURSO_ANOS', 
                'MÊS_ANO_PREVISTO_INICIO', 'MÊS_ANO_PREVISTO_TÉRMINO', 'MÊS_ANO_REALIZADO_INICIO', 
                'MÊS_ANO_REALIZADO_TÉRMINO', 'NÚMERO_TURMAS', 'NÚMERO_INGRESSANTES', 
                'NÚMERO_CONCLUINTES', 'NÚMERO_BOLSISTAS', 'OBSERVAÇÃO'), $data);
        }
        
        if ($this->input->post('check_municipio_curso') == "true") {
            $currentSheet = $this->get_sheet($init_sheet, $writer);
            $data = $this->relatorio_dinamico_m->abaCidadeCursos($where_curso);
            $this->xls_this($writer, $currentSheet, 'Localização dos cursos', array('ID_CURSO', 'GEOCODE', 'MUNICÍPIO DE REALIZAÇÃO', 'ESTADO'), $data);
        }
        
        if ($this->input->post('check_educando') == "true") {
            $currentSheet = $this->get_sheet($init_sheet, $writer);
            $data = $this->relatorio_dinamico_m->abaEducandos($where_curso);
            $this->xls_this($writer, $currentSheet, 'Educandos', array('CURSO_VINCULADO', 'ID', 'NOME', 'GÊNERO', 'DATA_NASCIMENTO', 'IDADE', 'TIPO_TERRITÓRIO', 'NOME_TERRITÓRIO', 'CONCLUINTE','GEOCODE', 'MUNICÍPIO DE ORIGEM', 'ESTADO'), $data);
        }
        
        if ($this->input->post('check_professores') == "true") {
            $currentSheet = $this->get_sheet($init_sheet, $writer);
            $data = $this->relatorio_dinamico_m->abaProfessores($where_curso);
            $this->xls_this($writer, $currentSheet, 'Professores', array('CURSO_VINCULADO', 'ID', 'NOME', 'GÊNERO', 'TITULAÇÃO'), $data);
        }
        
        if ($this->input->post('check_disciplinas') == "true") {
            $currentSheet = $this->get_sheet($init_sheet, $writer);
            $data = $this->relatorio_dinamico_m->abaDisciplinas($where_curso);
            $this->xls_this($writer, $currentSheet, 'Disciplina', array('CURSO_VINCULADO', 'NOME', 'PROFESSOR_RESPONSÁVEL'), $data);
        }
        
        if ($this->input->post('check_instituicao_ensino') == "true") {
            $currentSheet = $this->get_sheet($init_sheet, $writer);
            $data = $this->relatorio_dinamico_m->abaInstituicoesEnsino($where_curso);
            $this->xls_this($writer, $currentSheet, 'Instituições de Ensino', array('CURSO_VINCULADO', 'ID', 'NOME', 'SIGLA', 'UNIDADE', 'DEPARTAMENTO', 'LOGRADOURO', 'Nº', 'COMPLEMENTO', 'BAIRRO', 'CEP', 'TELEFONE_1', 'TELEFONE_2', 'PÁGINA_WEB', 'CÂMPUS', 'NATUREZA_INSTITUIÇÃO', 'GEOCODE', 'CIDADE', 'ESTADO'), $data);
        }

        if ($this->input->post('check_organizacao_demandante') == "true") {
            $currentSheet = $this->get_sheet($init_sheet, $writer);
            $data = $this->relatorio_dinamico_m->abaOrganizacoesDemandantes($where_curso);
            $this->xls_this($writer, $currentSheet, 'Organizações Demandantes', array('CURSO_VINCULADO', 'ID', 'NOME', 'ABRANGÊNCIA', 'DATA_FUNDAÇÃO_NACIONAL', 'DATA_FUNDAÇÃO_ESTADUAL', 'Nº_ACAMPAMENTOS','Nº_ASSENTAMENTOS', 'Nº_FAMÍLIAS_ASSENTADAS', 'Nº_PESSOAS_ENVOLVIDAS_CURSO', 'FONTE_INFORMAÇÕES'), $data);
        }
        
        if ($this->input->post('check_parceiros') == "true") {
            $currentSheet = $this->get_sheet($init_sheet, $writer);
            $data = $this->relatorio_dinamico_m->abaParceiros($where_curso);
            $this->xls_this($writer, $currentSheet, 'Parcerias', array('CURSO_VINCULADO', 'ID', 'NOME', 'SIGLA', 'LOGRADOURO', 'Nº', 'COMPLEMENTO', 'BAIRRO', 'CEP', 'TELEFONE_1', 'TELEFONE_2', 'PAGINA_WEB', 'NATUREZA_INSTITUIÇÃO', 'ABRANGÊNCIA', 'GEOCODE', 'CIDADE', 'ESTADO', 'REALIZAÇÃO_CURSO', 'CERTIFICAÇÃO_CURSO', 'GESTÃO_ORÇAMENTÁRIA', 'OUTRAS', 'COMPLEMENTO'), $data);
        }

        $writer->close();
    }

}

/* End of file relatorio_dinamico.php */
/* Location: ./application/controllers/relatorio_dinamico.php */