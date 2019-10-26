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

class Relatorio_dinamico extends CI_Controller
{

    private $access_level;
    private $excel;

    public function __construct()
    {

        parent::__construct();

        $this->load->database();            // Loading Database
        $this->load->library('session');    // Loading Session
        $this->load->helper('url');         // Loading Helper

        $this->load->model('relatorio_dinamico_m');  // Loading Model
    }

    /*
      Verificar níveis de acesso
     */

    public function index()
    {

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

    public function get_cursos()
    {
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

    private function append_header_sheet($writer, $title)
    {

        $style_border = (new StyleBuilder())
            ->setBackgroundColor(Color::rgb(170, 255, 128))
            ->setShouldWrapText(false)
            ->build();

        $style_body = (new StyleBuilder())
            ->setBackgroundColor(Color::rgb(230, 230, 230))
            ->setShouldWrapText(false)
            ->setFontBold()
            ->build();

        $writer->addRowWithStyle(array("-------------------------------------------------------------------------------------------------", "", "", "", "", "", "", "", "", "", ""), $style_border);
        $writer->addRowWithStyle(array("Programa Nacional de Educação na Reforma Agrária (Pronera)", "", "", "", "", "", "", "", "", "", ""), $style_body);
        $writer->addRowWithStyle(array("Cursos", "", "", "", "", "", "", "", "", "", ""), $style_body);
        $writer->addRowWithStyle(array("Relatório: " . $title, "", "", "", "", "", "", "", "", "", ""), $style_body);
        $writer->addRowWithStyle(array("Data de Emissão: " . date('d/m/y') . " Hora da Emissão: " . date("h:i:sa"), "", "", "", "", "", "", "", "", "", ""), $style_body);
        $writer->addRowWithStyle(array("-------------------------------------------------------------------------------------------------", "", "", "", "", "", "", "", "", "", ""), $style_border);
        $writer->addRow(array(""));
    }

    private function append_to_sheet($writer, $currentSheet, $aba)
    {
        if ($currentSheet) {
            $currentSheet->setName($aba['title']);
        }
        $style_header = (new StyleBuilder())
            ->setFontBold()
            ->setFontSize(13)
            ->setFontColor(Color::WHITE)
            ->setBackgroundColor(Color::rgb(91, 183, 91))
            ->build();

        $this->append_header_sheet($writer, $aba['title']);
        $writer->addRowWithStyle($aba['header'], $style_header);
        $writer->addRows($aba['data']);
    }

    private function write_ods($namefile, $abas)
    {
        $writter = WriterFactory::create(Type::ODS);
        $writter->openToBrowser($namefile . ".ods");
        $currentSheet = false;
        foreach ($abas as $aba) {
            if (!$currentSheet) {
                $currentSheet = $writter->getCurrentSheet();
            } else {
                $currentSheet = $writter->addNewSheetAndMakeItCurrent();
            }
            $this->append_to_sheet($writter, $currentSheet, $aba);
        }

        $writter->close();
    }

    private function write_xlsx($namefile, $abas)
    {
        $writter = WriterFactory::create(Type::XLSX);
        $writter->openToBrowser($namefile . ".xlsx");
        $currentSheet = false;
        foreach ($abas as $aba) {
            if (!$currentSheet) {
                $currentSheet = $writter->getCurrentSheet();
            } else {
                $currentSheet = $writter->addNewSheetAndMakeItCurrent();
            }
            $this->append_to_sheet($writter, $currentSheet, $aba);
        }

        $writter->close();
    }

    private function write_json($namefile, $abas)
    {
        $saida = array();
        foreach ($abas as $aba) {
            $saida[$aba['id']] = $aba['data'];
        }

        header("Content-disposition: attachment; filename=$namefile.json");
        echo json_encode($saida, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function gerarRelatorio()
    {
        session_start();
        ob_start("ob_gzhandler");

        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        ini_set('memory_limit', '2048M'); // or you could use 1G
        ini_set('max_execution_time', 900000);
        date_default_timezone_set('America/Sao_Paulo');

        define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

        $abas = array();
        $where_curso = $this->relatorio_dinamico_m->stmt_from_where_curso();
        if ($this->input->post('check_curso') == "true") {
            $abas[] = array(
                "title" => "Cursos",
                "id" => "cursos",
                "header" => array(
                    'COD', 'NOME', 'SUPERINTENDÊNCIA',
                    'NÍVEL_CURSO', 'MODALIDADE', 'ÁREA_CONHECIMENTO',
                    'COORDENADOR_GERAL', 'TITULAÇÃO_COORDENADOR_GERAL', 'COORDENADOR_PROJETO',
                    'TITULAÇÃO_COORDENADOR_PROJETO', 'VICE_COORDENADOR', 'TITULAÇÃO_VICE_COORDENADOR',
                    'COORDENADOR_PEDAGÓGICO', 'TITULAÇÃO_COORDENADOR_PEDAGÓGICO', 'DURAÇÃO_CURSO_ANOS',
                    'MÊS_ANO_PREVISTO_INICIO', 'MÊS_ANO_PREVISTO_TÉRMINO', 'MÊS_ANO_REALIZADO_INICIO',
                    'MÊS_ANO_REALIZADO_TÉRMINO', 'NÚMERO_TURMAS', 'NÚMERO_INGRESSANTES',
                    'NÚMERO_CONCLUINTES', 'NÚMERO_BOLSISTAS', 'TIPO_INSTRUMENTO', 'OBSERVAÇÃO'
                ),
                "data" => $this->relatorio_dinamico_m->abaCursos($where_curso)
            );
        }

        if ($this->input->post('check_municipio_curso') == "true") {
            $abas[] = array(
                "title" => "Localização dos cursos",
                "id" => "cursos_cidades",
                "header" => array('ID_CURSO', 'GEOCODE', 'MUNICÍPIO DE REALIZAÇÃO', 'ESTADO'),
                "data" => $this->relatorio_dinamico_m->abaCidadeCursos($where_curso)
            );
        }

        if ($this->input->post('check_educando') == "true") {
            $abas[] = array(
                "title" => "Educandos",
                "id" => "educandos",
                "header" => array('CURSO_VINCULADO', 'ID', 'NOME', 'CPF', 'RG', 'GÊNERO', 'DATA_NASCIMENTO', 'IDADE', 'TIPO_TERRITÓRIO', 'NOME_TERRITÓRIO', "COD_SIPRA", 'CONCLUINTE', 'GEOCODE', 'MUNICÍPIO DE ORIGEM', 'ESTADO'),
                "data" => $this->relatorio_dinamico_m->abaEducandos($where_curso)
            );
        }

        if ($this->input->post('check_professores') == "true") {
            $abas[] = array(
                "title" => "Professores",
                "id" => "professores",
                "header" => array('CURSO_VINCULADO', 'ID', 'NOME', 'CPF', 'RG', 'GÊNERO', 'TITULAÇÃO'),
                "data" => $this->relatorio_dinamico_m->abaProfessores($where_curso)
            );
        }

        if ($this->input->post('check_disciplinas') == "true") {
            $abas[] = array(
                "title" => "Disciplina",
                "id" => "disciplinas",
                "header" => array('CURSO_VINCULADO', 'NOME', 'PROFESSOR_RESPONSÁVEL'),
                "data" => $this->relatorio_dinamico_m->abaDisciplinas($where_curso)
            );
        }

        if ($this->input->post('check_instituicao_ensino') == "true") {
            $abas[] = array(
                "title" => "Instituições de Ensino",
                "id" => "instituicoes_de_ensino",
                "header" => array('CURSO_VINCULADO', 'ID', 'NOME', 'SIGLA', 'UNIDADE', 'DEPARTAMENTO', 'LOGRADOURO', 'Nº', 'COMPLEMENTO', 'BAIRRO', 'CEP', 'TELEFONE_1', 'TELEFONE_2', 'PÁGINA_WEB', 'CÂMPUS', 'NATUREZA_INSTITUIÇÃO', 'GEOCODE', 'CIDADE', 'ESTADO'),
                "data" => $this->relatorio_dinamico_m->abaInstituicoesEnsino($where_curso)
            );
        }

        if ($this->input->post('check_organizacao_demandante') == "true") {
            $abas[] = array(
                "title" => "Organizações Demandantes",
                "id" => "organizacoes_demandantes",
                "header" => array('CURSO_VINCULADO', 'ID', 'NOME', 'ABRANGÊNCIA', 'DATA_FUNDAÇÃO_NACIONAL', 'DATA_FUNDAÇÃO_ESTADUAL', 'Nº_ACAMPAMENTOS', 'Nº_ASSENTAMENTOS', 'Nº_FAMÍLIAS_ASSENTADAS', 'Nº_PESSOAS_ENVOLVIDAS_CURSO', 'FONTE_INFORMAÇÕES'),
                "data" => $this->relatorio_dinamico_m->abaOrganizacoesDemandantes($where_curso)
            );
        }

        if ($this->input->post('check_parceiros') == "true") {
            $abas[] = array(
                "title" => "Parcerias",
                "id" => "parceiros",
                "header" => array('CURSO_VINCULADO', 'ID', 'NOME', 'SIGLA', 'LOGRADOURO', 'Nº', 'COMPLEMENTO', 'BAIRRO', 'CEP', 'TELEFONE_1', 'TELEFONE_2', 'PAGINA_WEB', 'NATUREZA_INSTITUIÇÃO', 'ABRANGÊNCIA', 'GEOCODE', 'CIDADE', 'ESTADO', 'REALIZAÇÃO_CURSO', 'CERTIFICAÇÃO_CURSO', 'GESTÃO_ORÇAMENTÁRIA', 'OUTRAS', 'COMPLEMENTO'),
                "data" => $this->relatorio_dinamico_m->abaParceiros($where_curso)
            );
        }

        $fileformat = $this->input->post("format");

        $time = date("h:i:sa");
        $date = date("d_m_Y");
        $writer = false;
        $name = "REL_DINAMICO-DPRNRA-$time-$date";
        if ($fileformat == "ODS") {
            $this->write_ods($name, $abas);
        } else if ($fileformat == "XLSX") {
            $this->write_xlsx($name, $abas);
        } else if ($fileformat == "JSON") {
            $this->write_json($name, $abas);
        }

        $init_sheet = true;
    }
}

/* End of file relatorio_dinamico.php */
/* Location: ./application/controllers/relatorio_dinamico.php */
