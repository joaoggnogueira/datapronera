<?php

class Relatorio_geral_pnera2 extends CI_Controller {

    private $access_level;

    public function __construct() {
        parent::__construct();

        $this->load->database();            // Loading Database
        $this->load->library('session');    // Loading Session
        $this->load->helper('url');         // Loading Helper

        $this->load->model('relatorio_geral_m_pnera2');     // Loading Model
        $this->load->model('barchart');              // Loading Model
    }

    public function index() {

        // Administradores e Pesquisadores Nacionais
        if ($this->session->userdata('access_level') > 3) {
            $this->session->set_userdata('curr_content', 'rel_geral_nacional_pnera2');

        // Pesquisadores Estaduais e Auxiliares de Pesquisa
        } else if ($this->session->userdata('access_level') > 1) {
            $this->session->set_userdata('curr_content', 'rel_geral_estadual_pnera2');
        }

        $this->session->set_userdata('curr_top_menu', 'menus/principal.php');

        $data['content'] = $this->session->userdata('curr_content');
        //$data['top_menu'] = $this->session->userdata('curr_top_menu');

        $html = array(
            'content' => $this->load->view($data['content'], '', true)
            //'top_menu' => $this->load->view($data['top_menu'], '', true)
        );

        $response = array(
            'success' => true,
            'html' => $html
        );

        echo json_encode($response);
    }

    private function create_header($name, $tipo){
        $xls = array();
        if($tipo == 1){
            $cabe = array("------------------------------------------------------------------------------------------", "", "", "", "", "", "", "","","");
            array_push($xls, $cabe);
            $cabe = array("Programa Nacional de Educação na Reforma Agrária (Pronera)", "", "", "", "", "", "", "","","");
            array_push($xls, $cabe);
            $cabe = array("II Pesquisa Nacional sobre a Educação na Reforma Agrária (II PNERA)", "", "", "", "", "", "", "","","");
            array_push($xls, $cabe);
            $cabe = array($name, "", "", "", "", "", "", "", "", "");
            array_push($xls, $cabe);
            $cabe = array("Data de Emissão: ".date('d/m/y'), "", "", "", "", "", "", "","","");
            array_push($xls, $cabe);
            $cabe = array("------------------------------------------------------------------------------------------", "", "", "", "", "", "","","");
            array_push($xls, $cabe);
            $cabe = array("", "", "", "", "", "", "", "","","");
            array_push($xls, $cabe);
        }
        if($tipo == 2){
            $cabe = array("--------------------------------------------------------", "", "", "", "", "", "");
            array_push($xls, $cabe);
            $cabe = array("Programa Nacional de Educação na Reforma Agrária (Pronera)", "", "", "", "", "", "");
            array_push($xls, $cabe);
            $cabe = array("II Pesquisa Nacional sobre a Educação na Reforma Agrária (II PNERA)", "", "", "", "", "", "");
            array_push($xls, $cabe);
            $cabe = array($name, "", "", "", "", "", "");
            array_push($xls, $cabe);
            $cabe = array("Data de Emissão: ".date('d/m/y'), "", "", "", "", "", "");
            array_push($xls, $cabe);
            $cabe = array("--------------------------------------------------------","", "", "", "", "", "");
            array_push($xls, $cabe);
            $cabe = array("", "", "", "", "", "", "", "","","");
            array_push($xls, $cabe);
        }
        
        return $xls;
    }

    private function leading_zeros($string, $length) {

        while (strlen($string) < $length) {
            $string = "0" . $string;
        }

        return $string;
    }

    public function cursos_modalidade() {

        if ($result = $this->relatorio_geral_m_pnera2->cursos_modalidade($this->session->userdata('access_level'))) {

            $xls = array();
            $xls = $this->create_header("Cursos por modalidade", 2);
            $titles = array("MODALIDADE", "CURSOS");

            array_push($xls, $titles);

            foreach ($result as $row) {
                array_push($xls, $row);
            }

            // Set the position where the chart should appear in the worksheet
            $this->barchart->set_topLeftCell('I1');
            $this->barchart->set_bottomRightCell('Q35');

            $this->barchart->set_chart_colors(array('8B1A1A'));             // array - colors
            $this->barchart->set_title("CURSOS POR MODALIDADE");            // string

            $this->barchart->set_chart_data($xls);                          // data array
            $this->barchart->set_filename('CURSOS-MODALIDADE.xls');         // filename

            $this->barchart->create_chart();
        }
    }

    public function cursos_nivel() {

        if ($result = $this->relatorio_geral_m_pnera2->cursos_nivel($this->session->userdata('access_level'))) {

            $xls = array();
            $xls = $this->create_header("Cursos por nível", 2);
            $titles = array("NÍVEL", "CURSOS");

            array_push($xls, $titles);

            foreach ($result as $row) {
                array_push($xls, $row);
            }

            // Set the position where the chart should appear in the worksheet
            $this->barchart->set_topLeftCell('I1');
            $this->barchart->set_bottomRightCell('Q25');

            $this->barchart->set_chart_colors(array('8B1A1A'));             // array - colors
            $this->barchart->set_title("CURSOS POR NÍVEL");                 // string

            $this->barchart->set_chart_data($xls);                          // data array
            $this->barchart->set_filename('CURSOS-NIVEL.xls');              // filename

            $this->barchart->create_chart();
        }
    }

    public function cursos_nivel_superintendencia() {

        $titles = array();
        $levels = array();

        if ($result = $this->relatorio_geral_m_pnera2->get_niveis_modalidade()) {

            $titles[0] = "CÓDIGO";
            $titles[1] = "SUPERINTENDÊNCIA";

            foreach ($result as $row) {
                array_push($titles, $row->nivel);
                array_push($levels, $row->nivel);
            }

            if ($result = $this->relatorio_geral_m_pnera2->cursos_nivel_superintendencia($levels)) {

                $xls = array();
                $xls = $this->create_header("Cursos por nível e superintendência", 1);
                array_push($xls, $titles);

                foreach ($result as $row) {
                    $row['id'] = "SR - " . $this->leading_zeros($row['id'], 2);
                    array_push($xls, $row);
                }

                $this->barchart->set_include_charts(false); // hide charts

                $this->barchart->set_chart_data($xls);                              // data array
                $this->barchart->set_filename('CURSOS-NIVEL-SUPERINTENDENCIA.xls'); // filename

                $this->barchart->create_chart();
            }
        }
    }

    public function cursos_superintendencia() {

        if ($result = $this->relatorio_geral_m_pnera2->cursos_superintendencia()) {

            $xls = array();
            $xls = $this->create_header("Cursos por superintendência", 2);
            $titles = array("CÓDIGO", "SUPERINTENDÊNCIA", "CURSOS");

            array_push($xls, $titles);

            foreach ($result as $row) {
                $row['id'] = "SR - " . $this->leading_zeros($row['id'], 2);
                array_push($xls, $row);
            }

            // Set the position where the chart should appear in the worksheet
            $this->barchart->set_topLeftCell('I1');
            $this->barchart->set_bottomRightCell('Q35');

            $this->barchart->set_legend_col('B');
            $this->barchart->set_num_legend_columns(2);

            $this->barchart->set_chart_colors(array('8B1A1A'));                   // array - colors
            $this->barchart->set_title("CURSOS POR SUPERINTENDÊNCIA");            // string

            $this->barchart->set_chart_data($xls);                                // data array
            $this->barchart->set_filename('CURSOS-SUPERINTENDENCIA.xls');         // filename

            $this->barchart->create_chart();
        }
    }

    public function alunos_ingressantes_modalidade() {

        if ($result = $this->relatorio_geral_m_pnera2->alunos_ingressantes_modalidade($this->session->userdata('access_level'))) {

            $xls = array();
            $xls = $this->create_header("Alunos ingressantes por modalidade", 2);
            $titles = array("MODALIDADE", "ALUNOS INGRESSANTES");

            array_push($xls, $titles);

            foreach ($result as $row) {
                array_push($xls, $row);
            }

            // Set the position where the chart should appear in the worksheet
            $this->barchart->set_topLeftCell('I1');
            $this->barchart->set_bottomRightCell('R35');

            // Separador de milhar, com 0 casas decimais.
            $this->barchart->set_number_format('_(* #,##0_);_(* (#,##0);_(* "-"??_);_(@_)');

            $this->barchart->set_chart_colors(array('8B5742'));                  // array - colors
            $this->barchart->set_title("ALUNOS INGRESSANTES POR MODALIDADE");    // string

            $this->barchart->set_chart_data($xls);                               // data array
            $this->barchart->set_filename('ALUNOS-INGRESSANTES-MODALIDADE.xls'); // filename

            $this->barchart->create_chart();
        }
    }

    public function alunos_ingressantes_nivel() {

        if ($result = $this->relatorio_geral_m_pnera2->alunos_ingressantes_nivel($this->session->userdata('access_level'))) {

            $xls = array();
            $xls = $this->create_header("Alunos ingressantes por nível", 2);
            $titles = array("NÍVEL", "ALUNOS INGRESSANTES");

            array_push($xls, $titles);

            foreach ($result as $row) {
                array_push($xls, $row);
            }

            // Set the position where the chart should appear in the worksheet
            $this->barchart->set_topLeftCell('I1');
            $this->barchart->set_bottomRightCell('R35');

            // Separador de milhar, com 0 casas decimais.
            $this->barchart->set_number_format('_(* #,##0_);_(* (#,##0);_(* "-"??_);_(@_)');

            $this->barchart->set_chart_colors(array('8B5742'));                  // array - colors
            $this->barchart->set_title("ALUNOS INGRESSANTES POR NÍVEL");    // string

            $this->barchart->set_chart_data($xls);                               // data array
            $this->barchart->set_filename('ALUNOS-INGRESSANTES-NIVEL.xls'); // filename

            $this->barchart->create_chart();
        }
    }

    public function alunos_ingressantes_nivel_sr() {

        $titles = array();
        $levels = array();

        if ($result = $this->relatorio_geral_m_pnera2->get_niveis_modalidade()) {

            $titles[0] = "CÓDIGO";
            $titles[1] = "SUPERINTENDÊNCIA";

            foreach ($result as $row) {
                array_push($titles, $row->nivel);
                array_push($levels, $row->nivel);
            }

            if ($result = $this->relatorio_geral_m_pnera2->alunos_ingressantes_nivel_sr($levels)) {

                $xls = array();
                $xls = $this->create_header("Alunos ingressantes por nível e superintendência", 1);
                array_push($xls, $titles);

                foreach ($result as $row) {
                    $row['id'] = "SR - " . $this->leading_zeros($row['id'], 2);
                    array_push($xls, $row);
                }

                $this->barchart->set_include_charts(false); // hide charts

                // Separador de milhar, com 0 casas decimais.
                $this->barchart->set_number_format('_(* #,##0_);_(* (#,##0);_(* "-"??_);_(@_)');

                $this->barchart->set_chart_data($xls);                                           // data array
                $this->barchart->set_filename('ALUNOS-INGRESSANTES-NIVEL-SUPERINTENDENCIA.xls'); // filename

                $this->barchart->create_chart();
            }
        }
    }

    public function alunos_concluintes_nivel_sr() {

        $titles = array();
        $levels = array();

        if ($result = $this->relatorio_geral_m_pnera2->get_niveis_modalidade()) {

            $titles[0] = "CÓDIGO";
            $titles[1] = "SUPERINTENDÊNCIA";

            foreach ($result as $row) {
                array_push($titles, $row->nivel);
                array_push($levels, $row->nivel);
            }

            if ($result = $this->relatorio_geral_m_pnera2->alunos_concluintes_nivel_sr($levels)) {

                $xls = array();
                $xls = $this->create_header("Alunos concluintes por nível e superintendência", 1);
                array_push($xls, $titles);

                foreach ($result as $row) {
                    $row['id'] = "SR - " . $this->leading_zeros($row['id'], 2);
                    array_push($xls, $row);
                }

                $this->barchart->set_include_charts(false); // hide charts

                // Separador de milhar, com 0 casas decimais.
                $this->barchart->set_number_format('_(* #,##0_);_(* (#,##0);_(* "-"??_);_(@_)');

                $this->barchart->set_chart_data($xls);                                           // data array
                $this->barchart->set_filename('ALUNOS-CONCLUINTES-NIVEL-SUPERINTENDENCIA.xls'); // filename

                $this->barchart->create_chart();
            }
        }
    }

    public function alunos_ingressantes_superintendencia() {

        if ($result = $this->relatorio_geral_m_pnera2->alunos_ingressantes_superintendencia()) {

            $xls = array();
            $xls = $this->create_header("Alunos ingressantes por superintendência", 2);
            $titles = array("CÓDIGO", "SUPERINTENDÊNCIA", "ALUNOS INGRESSANTES");

            array_push($xls, $titles);

            foreach ($result as $row) {
                $row['id'] = "SR - " . $this->leading_zeros($row['id'], 2);
                array_push($xls, $row);
            }

            // Set the position where the chart should appear in the worksheet
            $this->barchart->set_topLeftCell('I1');
            $this->barchart->set_bottomRightCell('R35');

            $this->barchart->set_legend_col('B');
            $this->barchart->set_num_legend_columns(2);

            // Separador de milhar, com 0 casas decimais.
            $this->barchart->set_number_format('_(* #,##0_);_(* (#,##0);_(* "-"??_);_(@_)');

            $this->barchart->set_chart_colors(array('8B5742'));                        // array - colors
            $this->barchart->set_title("ALUNOS INGRESSANTES POR SUPERINTENDÊNCIA");    // string

            $this->barchart->set_chart_data($xls);                                     // data array
            $this->barchart->set_filename('ALUNOS-INGRESSANTES-SUPERINTENDENCIA.xls'); // filename

            $this->barchart->create_chart();
        }
    }

    public function alunos_concluintes_modalidade() {

        if ($result = $this->relatorio_geral_m_pnera2->alunos_concluintes_modalidade($this->session->userdata('access_level'))) {

            $xls = array();
            $xls = $this->create_header("Alunos concluintes por modalidade", 2);
            $titles = array("MODALIDADE", "ALUNOS CONCLUINTES");

            array_push($xls, $titles);

            foreach ($result as $row) {
                array_push($xls, $row);
            }

            // Set the position where the chart should appear in the worksheet
            $this->barchart->set_topLeftCell('I1');
            $this->barchart->set_bottomRightCell('R35');

            // Separador de milhar, com 0 casas decimais.
            $this->barchart->set_number_format('_(* #,##0_);_(* (#,##0);_(* "-"??_);_(@_)');

            $this->barchart->set_chart_colors(array('8B5742'));                  // array - colors
            $this->barchart->set_title("ALUNOS CONCLUINTES POR MODALIDADE");    // string

            $this->barchart->set_chart_data($xls);                               // data array
            $this->barchart->set_filename('ALUNOS-CONCLUINTES-MODALIDADE.xls'); // filename

            $this->barchart->create_chart();
        }
    }

    public function alunos_concluintes_nivel() {

        if ($result = $this->relatorio_geral_m_pnera2->alunos_concluintes_nivel($this->session->userdata('access_level'))) {

            $xls = array();
            $xls = $this->create_header("Alunos concluintes por nível", 2);
            $titles = array("NÍVEL", "ALUNOS CONCLUINTES");

            array_push($xls, $titles);

            foreach ($result as $row) {
                array_push($xls, $row);
            }

            // Set the position where the chart should appear in the worksheet
            $this->barchart->set_topLeftCell('I1');
            $this->barchart->set_bottomRightCell('R35');

            // Separador de milhar, com 0 casas decimais.
            $this->barchart->set_number_format('_(* #,##0_);_(* (#,##0);_(* "-"??_);_(@_)');

            $this->barchart->set_chart_colors(array('8B5742'));                  // array - colors
            $this->barchart->set_title("ALUNOS CONCLUINTES POR NÍVEL");    // string

            $this->barchart->set_chart_data($xls);                               // data array
            $this->barchart->set_filename('ALUNOS-CONCLUINTES-NIVEL.xls'); // filename

            $this->barchart->create_chart();
        }
    }

    public function alunos_concluintes_superintendencia() {

        if ($result = $this->relatorio_geral_m_pnera2->alunos_concluintes_superintendencia()) {

            $xls = array();
            $xls = $this->create_header("Alunos concluintes por superintendência", 2);
            $titles = array("CÓDIGO", "SUPERINTENDÊNCIA", "ALUNOS CONCLUINTES");

            array_push($xls, $titles);

            foreach ($result as $row) {
                $row['id'] = "SR - " . $this->leading_zeros($row['id'], 2);
                array_push($xls, $row);
            }

            // Set the position where the chart should appear in the worksheet
            $this->barchart->set_topLeftCell('I1');
            $this->barchart->set_bottomRightCell('R35');

            $this->barchart->set_legend_col('B');
            $this->barchart->set_num_legend_columns(2);

            // Separador de milhar, com 0 casas decimais.
            $this->barchart->set_number_format('_(* #,##0_);_(* (#,##0);_(* "-"??_);_(@_)');

            $this->barchart->set_chart_colors(array('8B5742'));                        // array - colors
            $this->barchart->set_title("ALUNOS CONCLUINTES POR SUPERINTENDÊNCIA");    // string

            $this->barchart->set_chart_data($xls);                                     // data array
            $this->barchart->set_filename('ALUNOS-CONCLUINTES-SUPERINTENDENCIA.xls'); // filename

            $this->barchart->create_chart();
        }
    }

    public function educandos_assentamento_modalidade() {

        // GAMBIARRRA para aumentar a área de memória 
        ini_set('memory_limit', '1024M');

        if ($result = $this->relatorio_geral_m_pnera2->educandos_assentamento_modalidade()) {

            $xls = array();
            $xls = $this->create_header("Educandos por assentamento e modalidade de curso", 1);
            $titles = array("NOME TERRITÓRIO", "EJA ALFABETIZACAO", "EJA ANOS INICIAIS", "EJA ANOS FINAIS",
                "EJA NIVEL MEDIO (MAGISTERIO/FORMAL)", "EJA NIVEL MEDIO (NORMAL)", "NIVEL MEDIO/TECNICO (CONCOMITANTE)",
                "NIVEL MEDIO/TECNICO (INTEGRADO)", "NIVEL MEDIO PROFISSIONAL (POS-MEDIO)", "GRADUACAO", "ESPECIALIZACAO",
                "RESIDENCIA AGRARIA", "MESTRADO", "DOUTORADO");

            array_push($xls, $titles);

            foreach ($result as $row) {

                array_push($xls, $row);
            }

            $this->barchart->set_include_charts(false); // hide charts

            $this->barchart->set_chart_data($xls);
            $this->barchart->set_filename('EDUCANDOS-ASSENTAMENTO-MODALIDADE.xls'); // filename

            $this->barchart->create_chart();
        }
    }

    public function educandos_assentamento_nivel() {

        // GAMBIARRRA para aumentar a área de memória 
        ini_set('memory_limit', '2048M');

        if ($result = $this->relatorio_geral_m_pnera2->educandos_assentamento_nivel()) {

            $xls = array();
            $xls = $this->create_header("Educandos por assentamento e nível de curso", 1);
            $titles = array("NOME TERRITÓRIO", "EJA FUNDAMENTAL", "ENSINO MÉDIO", "ENSINO SUPERIOR");

            array_push($xls, $titles);

            foreach ($result as $row) {

                array_push($xls, $row);
            }

            $this->barchart->set_include_charts(false); // hide charts

            $this->barchart->set_chart_data($xls);
            $this->barchart->set_filename('EDUCANDOS-ASSENTAMENTO-NIVEL.xls'); // filename

            $this->barchart->create_chart();
        }
    }

    public function lista_educandos_cursos_sr() {

        // GAMBIARRRA para aumentar a área de memória 
        ini_set('memory_limit', '1024M');

        if ($result = $this->relatorio_geral_m_pnera2->lista_educandos_cursos_sr()) {

            $xls = array();
            $xls = $this->create_header("Educandos, superintendência e curso", 1);
            $titles = array("NOME EDUCANDO", "TIPO TERRITÓRIO", "NOME TERRITÓRIO", "CÓD. SR", "CÓD. CURSO", "NOME CURSO", "MODALIDADE CURSO");

            array_push($xls, $titles);

            foreach ($result as $row) {

                array_push($xls, $row);
            }

            $this->barchart->set_include_charts(false); // hide charts

            $this->barchart->set_chart_data($xls);
            $this->barchart->set_filename('LISTA-EDUCANDOS-CURSOS-SR.xls'); // filename

            $this->barchart->create_chart();
        } else {
            echo "ERRO";
        }
    }

    public function municipios_curso_modalidade() {
        $result = $this->relatorio_geral_m_pnera2->municipios_curso_modalidade($this->session->userdata('access_level'));
        //var_dump($result);
        if ($result) {
            $xls = array();
            $xls = $this->create_header("Municípios de realização dos cursos por modalidade", 1);
            $titles = array("MODALIDADE", "ESTADO", "CÓD. MUNICÍPIO", "MUNICÍPIO", "CÓD. CURSO", "CURSO");

            array_push($xls, $titles);

            foreach ($result as $row) {

                $row['id_curso'] = $this->leading_zeros($row['id_superintendencia'], 2) . $this->leading_zeros($row['id_curso'], 3);

                unset($row['id_superintendencia']);
                array_push($xls, $row);
            }

            $this->barchart->set_include_charts(false); // hide charts

            $this->barchart->set_chart_data($xls);
            $this->barchart->set_filename('MUNICIPIOS-CURSO-MODALIDADE.xls'); // filename

            $this->barchart->create_chart();
        }
    }

    public function municipios_curso() {

        if ($result = $this->relatorio_geral_m_pnera2->municipios_curso($this->session->userdata('access_level'))) {

            $xls = array();
            $xls = $this->create_header("Municípios de realização dos cursos", 1);
            $titles = array("ESTADO", "MUNICÍPIO", "CÓD. MUNICÍPIO", "CURSOS");

            array_push($xls, $titles);

            foreach ($result as $row) {
                array_push($xls, $row);
            }

            // Set the position where the chart should appear in the worksheet
            $this->barchart->set_topLeftCell('I1');
            $this->barchart->set_bottomRightCell('Q35');

            $this->barchart->set_legend_col('B');
            $this->barchart->set_num_legend_columns(2);

            // Separador de milhar, com 0 casas decimais.
            $this->barchart->set_number_format('_(* #,##0_);_(* (#,##0);_(* "-"??_);_(@_)');

            $this->barchart->set_chart_colors(array('8B5742'));                   // array - colors
            $this->barchart->set_title("MUNICÍPIOS DE REALIZAÇÃO DOS CURSOS");    // string

            $this->barchart->set_chart_data($xls);                                // data array
            $this->barchart->set_filename('MUNICIPIOS-CURSO.xls');                // filename

            $this->barchart->create_chart();
        }
    }

    public function lista_cursos_modalidade() {

        if ($result = $this->relatorio_geral_m_pnera2->lista_cursos_modalidade($this->session->userdata('access_level'))) {

            $xls = array();
            $xls = $this->create_header("Lista de cursos por modalidade", 1);
            $titles = array("MODALIDADE","CÓDIGO", "CURSO");

            array_push($xls, $titles);

            foreach ($result as $row) {

                $row['id_curso'] = $this->leading_zeros($row['id_superintendencia'], 2) . $this->leading_zeros($row['id_curso'], 3);

                unset($row['id_superintendencia']);
                array_push($xls, $row);
            }

            $this->barchart->set_include_charts(false); // hide charts

            $this->barchart->set_chart_data($xls);
            $this->barchart->set_filename('LISTA-CURSOS-MODALIDADE.xls'); // filename

            $this->barchart->create_chart();
        }
    }

    public function titulacao_educadores() {

        if ($result = $this->relatorio_geral_m_pnera2->titulacao_educadores($this->session->userdata('access_level'))) {

            $xls = array();
            $xls = $this->create_header("Escolaridade/titulação dos educadores", 2);
            $titles = array("TITULAÇÃO", "% EDUCADORES");

            array_push($xls, $titles);

            foreach ($result as $row) {
                array_push($xls, $row);
            }

            // Set the position where the chart should appear in the worksheet
            $this->barchart->set_topLeftCell('I1');
            $this->barchart->set_bottomRightCell('R28');

            $this->barchart->set_number_format('0.0');                           // decimal format

            $this->barchart->set_chart_colors(array('6B8E23'));                  // array - colors
            $this->barchart->set_title("ESCOLARIDADE/TITULAÇÃO DOS EDUCADORES"); // string

            $this->barchart->set_chart_data($xls);                               // data array
            $this->barchart->set_filename('TITULACAO-EDUCADORES.xls');           // filename

            $this->barchart->create_chart();
        }
    }

    public function titulacao_educadores_superintendencia() {

        if ($result = $this->relatorio_geral_m_pnera2->titulacao_educadores_superintendencia()) {

            $xls = array();
            $xls = $this->create_header("Escolaridade/titulação dos educadores por superintendência", 2);
            $titles = array("CÓDIGO", "SUPERINTENDÊNCIA", "% ENSINO FUNDAMENTAL COMPLETO", "% ENSINO FUNDAMENTAL INCOMPLETO",
                "% ENSINO MÉDIO COMPLETO", "% ENSINO MÉDIO INCOMPLETO", "% GRADUADO(A)", "% ESPECIALISTA", "% MESTRE(A)", "% DOUTOR(A)");

            array_push($xls, $titles);

            foreach ($result as $row) {
                $row['id'] = "SR - " . $this->leading_zeros($row['id'], 2);
                array_push($xls, $row);
            }

            $this->barchart->set_include_charts(false); // hide charts

            $this->barchart->set_number_format('0.0');                           // decimal format

            $this->barchart->set_chart_data($xls);                               // data array
            $this->barchart->set_filename('TITULACAO-EDUCADORES-SUPERINTENDENCIA.xls');           // filename

            $this->barchart->create_chart();
        }
    }

    public function educadores_nivel() {

        if ($result = $this->relatorio_geral_m_pnera2->educadores_nivel($this->session->userdata('access_level'))) {

            $xls = array();
            $xls = $this->create_header("Educadores por nível", 2);
            $titles = array("NÍVEL", "EDUCADORES");

            array_push($xls, $titles);

            foreach ($result as $row) {
                array_push($xls, $row);
            }

            // Set the position where the chart should appear in the worksheet
            $this->barchart->set_topLeftCell('I1');
            $this->barchart->set_bottomRightCell('Q25');

            // Separador de milhar, com 0 casas decimais.
            $this->barchart->set_number_format('_(* #,##0_);_(* (#,##0);_(* "-"??_);_(@_)');

            $this->barchart->set_chart_colors(array('8B5742'));    // array - colors
            $this->barchart->set_title("EDUCADORES POR NÍVEL");    // string

            $this->barchart->set_chart_data($xls);                 // data array
            $this->barchart->set_filename('EDUCADORES-NIVEL.xls'); // filename

            $this->barchart->create_chart();
        }
    }

    public function educadores_curso() {

        if ($result = $this->relatorio_geral_m_pnera2->educadores_curso($this->session->userdata('access_level'))) {

            $xls = array();
            $xls = $this->create_header("Educadores por curso", 2);
            $titles = array("CÓDIGO", "CURSO", "EDUCADORES");

            array_push($xls, $titles);

            foreach ($result as $row) {

                $row['id_curso'] = $this->leading_zeros($row['id_superintendencia'], 2) . $this->leading_zeros($row['id_curso'], 3);

                unset($row['id_superintendencia']);
                array_push($xls, $row);
            }

            // Set the position where the chart should appear in the worksheet
            $this->barchart->set_topLeftCell('I1');
            $this->barchart->set_bottomRightCell('V35');

            $this->barchart->set_legend_col('B');
            $this->barchart->set_num_legend_columns(2);

            // Separador de milhar, com 0 casas decimais.
            $this->barchart->set_number_format('_(* #,##0_);_(* (#,##0);_(* "-"??_);_(@_)');

            $this->barchart->set_chart_colors(array('8B5742'));    // array - colors
            $this->barchart->set_title("EDUCADORES POR CURSO");    // string

            $this->barchart->set_chart_data($xls);                 // data array
            $this->barchart->set_filename('EDUCADORES-CURSO.xls'); // filename

            $this->barchart->create_chart();
        }
    }

    public function educadores_superintendencia() {

        if ($result = $this->relatorio_geral_m_pnera2->educadores_superintendencia()) {

            $xls = array();
            $xls = $this->create_header("Educadores por superintendência", 2);
            $titles = array("CÓDIGO", "SUPERINTENDÊNCIA", "EDUCADORES");

            array_push($xls, $titles);

            foreach ($result as $row) {
                $row['id'] = "SR - " . $this->leading_zeros($row['id'], 2);
                array_push($xls, $row);
            }

            // Set the position where the chart should appear in the worksheet
            $this->barchart->set_topLeftCell('I1');
            $this->barchart->set_bottomRightCell('Q50');

            $this->barchart->set_legend_col('B');
            $this->barchart->set_num_legend_columns(2);

            // Separador de milhar, com 0 casas decimais.
            $this->barchart->set_number_format('_(* #,##0_);_(* (#,##0);_(* "-"??_);_(@_)');

            $this->barchart->set_chart_colors(array('006400'));                   // array - colors
            $this->barchart->set_title("EDUCADORES POR SUPERINTENDÊNCIA");        // string

            $this->barchart->set_chart_data($xls);                                // data array
            $this->barchart->set_filename('EDUCADORES-SUPERINTENDENCIA.xls');     // filename

            $this->barchart->create_chart();
        }
    }

    public function genero_educadores_modalidade() {

        if ($result = $this->relatorio_geral_m_pnera2->genero_educadores_modalidade($this->session->userdata('access_level'))) {

            $xls = array();
            $xls = $this->create_header("Participação de homens e mulheres como educadores dos cursos por modalidade", 2);
            $titles = array("MODALIDADE", "% MASCULINO", "% FEMININO");

            array_push($xls, $titles);

            foreach ($result as $row) {
                array_push($xls, $row);
            }

            // Set the position where the chart should appear in the worksheet
            $this->barchart->set_topLeftCell('I1');
            $this->barchart->set_bottomRightCell('Q28');

            $this->barchart->set_chartType('stacked');                                 // stacked
            $this->barchart->set_number_format('0.0');                           // decimal format

            $this->barchart->set_chart_colors(array('87CEEB','EE5C42'));         // array - colors
            $this->barchart->set_title("EDUCADORES POR GÊNERO E MODALIDADE");    // string

            $this->barchart->set_chart_data($xls);                               // data array
            $this->barchart->set_filename('EDUCADORES-GENERO-MODALIDADE.xls');   // filename

            $this->barchart->create_chart();
        }
    }

    public function educandos_superintendencia() {

        if ($result = $this->relatorio_geral_m_pnera2->educandos_superintendencia()) {

            $xls = array();
            $xls = $this->create_header("Educandos por superintendência", 2);
            $titles = array("CÓDIGO", "SUPERINTENDÊNCIA", "EDUCANDOS");

            array_push($xls, $titles);

            foreach ($result as $row) {
                $row['id'] = "SR - " . $this->leading_zeros($row['id'], 2);
                array_push($xls, $row);
            }

            // Set the position where the chart should appear in the worksheet
            $this->barchart->set_topLeftCell('I1');
            $this->barchart->set_bottomRightCell('Q50');

            $this->barchart->set_legend_col('B');
            $this->barchart->set_num_legend_columns(2);

            // Separador de milhar, com 0 casas decimais.
            $this->barchart->set_number_format('_(* #,##0_);_(* (#,##0);_(* "-"??_);_(@_)');

            $this->barchart->set_chart_colors(array('006400'));                   // array - colors
            $this->barchart->set_title("EDUCANDOS POR SUPERINTENDÊNCIA");        // string

            $this->barchart->set_chart_data($xls);                                // data array
            $this->barchart->set_filename('EDUCANDOS-SUPERINTENDENCIA.xls');     // filename

            $this->barchart->create_chart();
        }
    }

    public function municipio_origem_educandos() {

        if ($result = $this->relatorio_geral_m_pnera2->municipio_origem_educandos($this->session->userdata('access_level'))) {

            $xls = array();
            $xls = $this->create_header("Município de origem dos educandos", 1);
            $titles = array("ESTADO", "MUNICÍPIO", "CÓD MUNICÍPIO", "EDUCANDOS");

            array_push($xls, $titles);

            foreach ($result as $row) {
                array_push($xls, $row);
            }

            $this->barchart->set_include_charts(false); // hide charts

            $this->barchart->set_chart_data($xls);
            $this->barchart->set_filename('MUNICIPIO-ORIGEM-EDUCANDOS.xls'); // filename

            $this->barchart->create_chart();
        }
    }

    public function territorio_educandos_modalidade() {

        if ($result = $this->relatorio_geral_m_pnera2->territorio_educandos_modalidade($this->session->userdata('access_level'))) {

            $xls = array();
            $xls = $this->create_header("Território de origem dos educandos por modalidade", 1);
            $titles = array("MODALIDADE", "ACAMPAMENTO", "ASSENTAMENTO", "COMUNIDADE", "COMUNIDADE RIBEIRINHA",
                "FLONA", "FLORESTA NACIONAL", "QUILOMBOLA", "RDS", "RESEX", "OUTRO", "NÃO PREENCHIDO", "NÃO INFORMADO");

            array_push($xls, $titles);

            foreach ($result as $row) {
                array_push($xls, $row);
            }

            $this->barchart->set_include_charts(false); // hide charts

            $this->barchart->set_chart_data($xls);
            $this->barchart->set_filename('TERRITORIO-EDUCANDOS-MODALIDADE.xls'); // filename

            $this->barchart->create_chart();
        }
    }

    public function territorio_educandos_superintendencia() {

        if ($result = $this->relatorio_geral_m_pnera2->territorio_educandos_superintendencia()) {

            $xls = array();
            $xls = $this->create_header("Território de origem dos educandos por superintendência", 1);
            $titles = array("CÓDIGO", "SUPERINTENDÊNCIA", "ACAMPAMENTO", "ASSENTAMENTO", "COMUNIDADE", "COMUNIDADE RIBEIRINHA",
                "FLONA", "FLORESTA NACIONAL", "QUILOMBOLA", "RDS", "RESEX", "OUTRO", "NÃO PREENCHIDO", "NÃO INFORMADO");

            array_push($xls, $titles);

            foreach ($result as $row) {
                $row['id'] = "SR - " . $this->leading_zeros($row['id'], 2);
                array_push($xls, $row);
            }

            $this->barchart->set_include_charts(false); // hide charts

            $this->barchart->set_chart_data($xls);
            $this->barchart->set_filename('TERRITORIO-EDUCANDOS-SUPERINTENDENCIA.xls'); // filename

            $this->barchart->create_chart();
        }
    }

    public function idade_educandos_modalidade() {

        if ($result = $this->relatorio_geral_m_pnera2->idade_educandos_modalidade($this->session->userdata('access_level'))) {

            $xls = array();
            $xls = $this->create_header("Idade média dos educandos por modalidade", 2);
            $titles = array("MODALIDADE", "MÉDIA DE IDADE (ANOS)");

            array_push($xls, $titles);

            foreach ($result as $row) {
                array_push($xls, $row);
            }

            // Set the position where the chart should appear in the worksheet
            $this->barchart->set_topLeftCell('I1');
            $this->barchart->set_bottomRightCell('Q28');

            $this->barchart->set_number_format('0.0');                                    // number format

            $this->barchart->set_chart_colors(array('CDC9C9'));                     // array - colors
            $this->barchart->set_title("IDADE MÉDIA DOS EDUCANDOS POR MODALIDADE"); // string

            $this->barchart->set_chart_data($xls);                                  // data array
            $this->barchart->set_filename('IDADE-EDUCANDOS-MODALIDADE.xls');        // filename

            $this->barchart->create_chart();
        }
    }

    public function genero_educandos_modalidade() {

        if ($result = $this->relatorio_geral_m_pnera2->genero_educandos_modalidade($this->session->userdata('access_level'))) {

            $xls = array();
            $xls = $this->create_header("Participação de homens e mulheres como educandos nos cursos por modalidade", 2);
            $titles = array("MODALIDADE", "% MASCULINO", "% FEMININO");

            array_push($xls, $titles);

            foreach ($result as $row) {
                array_push($xls, $row);
            }

            // Set the position where the chart should appear in the worksheet
            $this->barchart->set_topLeftCell('I1');
            $this->barchart->set_bottomRightCell('Q28');

            $this->barchart->set_chartType('stacked');                                 // stacked
            $this->barchart->set_number_format('0.0');                           // decimal format

            $this->barchart->set_chart_colors(array('87CEEB','EE5C42'));         // array - colors
            $this->barchart->set_title("EDUCANDOS POR GÊNERO E MODALIDADE");     // string

            $this->barchart->set_chart_data($xls);                               // data array
            $this->barchart->set_filename('EDUCANDOS-GENERO-MODALIDADE.xls');    // filename

            $this->barchart->create_chart();
        }
    }

    public function localizacao_instituicoes_ensino() {

        if ($result = $this->relatorio_geral_m_pnera2->localizacao_instituicoes_ensino($this->session->userdata('access_level'))) {

            $xls = array();
            $xls = $this->create_header("Localização das instituições de ensino", 1);
            $titles = array("ESTADO", "MUNICÍPIO", "CÓD MUNICÍPIO", "INSTITUIÇÃO DE ENSINO");

            array_push($xls, $titles);

            foreach ($result as $row) {
                array_push($xls, $row);
            }

            $this->barchart->set_include_charts(false); // hide charts

            $this->barchart->set_chart_data($xls);
            $this->barchart->set_filename('LOCALIZACAO-INSTITUICOES-ENSINO.xls'); // filename

            $this->barchart->create_chart();
        }
    }

    public function instituicoes_ensino_modalidade() {

        if ($result = $this->relatorio_geral_m_pnera2->instituicoes_ensino_modalidade($this->session->userdata('access_level'))) {

            $xls = array();
            $xls = $this->create_header("Instituições de ensino que realizaram cursos por modalidade", 2);
            $titles = array("MODALIDADE", "INSTITUIÇÕES DE ENSINO");

            array_push($xls, $titles);

            foreach ($result as $row) {
                array_push($xls, $row);
            }

            // Set the position where the chart should appear in the worksheet
            $this->barchart->set_topLeftCell('I1');
            $this->barchart->set_bottomRightCell('Q28');

            $this->barchart->set_chart_colors(array('4F94CD'));                     // array - colors
            $this->barchart->set_title("INSTITUIÇÕES DE ENSINO POR MODALIDADE");    // string

            $this->barchart->set_chart_data($xls);                                  // data array
            $this->barchart->set_filename('INSTITUICOES-ENSINO-MODALIDADE.xls');    // filename

            $this->barchart->create_chart();
        }
    }

    public function instituicoes_ensino_nivel() {

        if ($result = $this->relatorio_geral_m_pnera2->instituicoes_ensino_nivel($this->session->userdata('access_level'))) {

            $xls = array();
            $xls = $this->create_header("Instituições de ensino que realizaram cursos por nível", 2);
            $titles = array("NÍVEL", "INSTITUIÇÕES DE ENSINO");

            array_push($xls, $titles);

            foreach ($result as $row) {
                array_push($xls, $row);
            }

            // Set the position where the chart should appear in the worksheet
            $this->barchart->set_topLeftCell('I1');
            $this->barchart->set_bottomRightCell('Q28');

            $this->barchart->set_chart_colors(array('4F94CD'));                     // array - colors
            $this->barchart->set_title("INSTITUIÇÕES DE ENSINO POR NÍVEL");    // string

            $this->barchart->set_chart_data($xls);                                  // data array
            $this->barchart->set_filename('INSTITUICOES-ENSINO-NIVEL.xls');    // filename

            $this->barchart->create_chart();
        }
    }

    public function instituicoes_ensino_superintendencia() {

        if ($result = $this->relatorio_geral_m_pnera2->instituicoes_ensino_superintendencia()) {

            $xls = array();
            $xls = $this->create_header("Instituições de ensino que realizaram cursos por superintendência", 1);
            $titles = array("CÓDIGO", "SUPERINTENDÊNCIA", "INSTITUIÇÕES DE ENSINO");

            array_push($xls, $titles);

            foreach ($result as $row) {
                $row['id'] = "SR - " . $this->leading_zeros($row['id'], 2);
                array_push($xls, $row);
            }

            // Set the position where the chart should appear in the worksheet
            $this->barchart->set_topLeftCell('I1');
            $this->barchart->set_bottomRightCell('Q35');

            $this->barchart->set_chart_colors(array('CDC9C9'));                           // array - colors
            $this->barchart->set_title("INSTITUIÇÕES DE ENSINO POR SUPERINTENDÊNCIA");    // string

            $this->barchart->set_chart_data($xls);                                        // data array
            $this->barchart->set_filename('INSTITUIÇÕES-ENSINO-SUPERINTENDENCIA.xls');    // filename

            $this->barchart->create_chart();
        }
    }

    public function instituicoes_ensino_municipio() {

        if ($result = $this->relatorio_geral_m_pnera2->instituicoes_ensino_municipio($this->session->userdata('access_level'))) {

            $xls = array();
            $xls = $this->create_header("Instituições de ensino que realizaram cursos por municípios", 2);
            $titles = array("ESTADO", "CÓD. MUNICÍPIO", "MUNICÍPIO", "INSTITUIÇÕES DE ENSINO");

            array_push($xls, $titles);

            foreach ($result as $row) {
                array_push($xls, $row);
            }

            // Set the position where the chart should appear in the worksheet
            $this->barchart->set_topLeftCell('I1');
            $this->barchart->set_bottomRightCell('Q35');

            $this->barchart->set_legend_col('C');
            $this->barchart->set_num_legend_columns(3);

            $this->barchart->set_chart_colors(array('CDC9C9'));                           // array - colors
            $this->barchart->set_title("INSTITUIÇÕES DE ENSINO POR MUNICÌPIO");    // string

            $this->barchart->set_chart_data($xls);                                        // data array
            $this->barchart->set_filename('INSTITUIÇÕES-ENSINO-MUNICIPIO.xls');    // filename

            $this->barchart->create_chart();
        }
    }

    public function instituicoes_ensino_estado() {

        if ($result = $this->relatorio_geral_m_pnera2->instituicoes_ensino_estado()) {

            $xls = array();
            $xls = $this->create_header("Instituições de ensino que realizaram cursos por estados", 2);
            $titles = array("ESTADO", "INSTITUIÇÕES DE ENSINO");

            array_push($xls, $titles);

            foreach ($result as $row) {
                array_push($xls, $row);
            }

            // Set the position where the chart should appear in the worksheet
            $this->barchart->set_topLeftCell('I1');
            $this->barchart->set_bottomRightCell('Q35');

            $this->barchart->set_chart_colors(array('CDC9C9'));                           // array - colors
            $this->barchart->set_title("INSTITUIÇÕES DE ENSINO POR ESTADO");    // string

            $this->barchart->set_chart_data($xls);                                        // data array
            $this->barchart->set_filename('INSTITUIÇÕES-ENSINO-ESTADO.xls');    // filename

            $this->barchart->create_chart();
        }
    }

    public function cursos_natureza_inst_ensino() {

        if ($result = $this->relatorio_geral_m_pnera2->cursos_natureza_inst_ensino($this->session->userdata('access_level'))) {

            $xls = array();
            $xls = $this->create_header("Natureza das instituições de ensino e número de cursos realizados", 2);
            $titles = array("NATUREZA", "CURSOS");

            array_push($xls, $titles);

            foreach ($result as $row) {
                array_push($xls, $row);
            }

            // Set the position where the chart should appear in the worksheet
            $this->barchart->set_topLeftCell('I1');
            $this->barchart->set_bottomRightCell('Q28');

            $this->barchart->set_chart_colors(array('00CDCD'));                                        // array - colors
            $this->barchart->set_title("NATUREZA DAS INSTITUIÇÕES DE ENSINO\nE CURSOS REALIZADOS");    // string

            $this->barchart->set_chart_data($xls);                                                     // data array
            $this->barchart->set_filename('INSTITUIÇÕES-ENSINO-CURSOS-NATUREZA.xls');                  // filename

            $this->barchart->create_chart();
        }
    }

    public function instituicao_ensino_cursos() {

        if ($result = $this->relatorio_geral_m_pnera2->instituicao_ensino_cursos($this->session->userdata('access_level'))) {

            $xls = array();
            $xls = $this->create_header("Lista das instituições de ensino e número de cursos realizados", 1);
            $titles = array("INSTITUIÇÃO DE ENSINO", "CURSOS");

            array_push($xls, $titles);

            foreach ($result as $row) {
                array_push($xls, $row);
            }

            $this->barchart->set_include_charts(false); // hide charts

            $this->barchart->set_chart_data($xls);
            $this->barchart->set_filename('INSTITUICAO-ENSINO-CURSOS.xls'); // filename

            $this->barchart->create_chart();
        }
    }

    public function organizacoes_demandantes_modalidade() {

        if ($result = $this->relatorio_geral_m_pnera2->organizacoes_demandantes_modalidade($this->session->userdata('access_level'))) {

            $xls = array();
            $xls = $this->create_header("Organizações demandantes por modalidade", 2);
            $titles = array("MODALIDADE", "ORGANIZAÇÕES DEMANDANTES");

            array_push($xls, $titles);

            foreach ($result as $row) {
                array_push($xls, $row);
            }

            // Set the position where the chart should appear in the worksheet
            $this->barchart->set_topLeftCell('I1');
            $this->barchart->set_bottomRightCell('Q28');

            $this->barchart->set_chart_colors(array('CD950C'));                       // array - colors
            $this->barchart->set_title("ORGANIZAÇÕES DEMANDANTES POR MODALIDADE");    // string

            $this->barchart->set_chart_data($xls);                                    // data array
            $this->barchart->set_filename('ORGANIZAÇÕES-DEMANDANTES-MODALIDADE.xls'); // filename

            $this->barchart->create_chart();
        }
    }

    public function membros_org_demandantes_modalidade() {

        if ($result = $this->relatorio_geral_m_pnera2->membros_org_demandantes_modalidade($this->session->userdata('access_level'))) {

            $xls = array();
            $xls = $this->create_header("Porcentagem dos membros das organizações demandantes participantes de cursos do PRONERA por modalidade", 2);
            $titles = array("MODALIDADE", "% ESTUDARAM NO PRONERA", "% NÃO ESTUDARAM NO PRONERA");

            array_push($xls, $titles);

            foreach ($result as $row) {
                array_push($xls, $row);
            }

            // Set the position where the chart should appear in the worksheet
            $this->barchart->set_topLeftCell('I1');
            $this->barchart->set_bottomRightCell('S28');

            $this->barchart->set_chartType('stacked');                                 // stacked
            $this->barchart->set_number_format('0.0');                           // decimal format

            $this->barchart->set_chart_colors(array('87CEEB','EE5C42'));         // array - colors
            $this->barchart->set_title("
                MEMBROS DAS ORGANIZAÇÕES DEMANDANTES (%)\n
                PARTICIPANTES DOS CURSOS DO PRONERA\n
                POR MODALIDADE"
            ); // string

            $this->barchart->set_chart_data($xls);                               // data array
            $this->barchart->set_filename('MEMBROS-ORG-DEMANDANTES-MODALIDADE.xls');    // filename

            $this->barchart->create_chart();
        }
    }

    public function organizacao_demandante_cursos() {

        if ($result = $this->relatorio_geral_m_pnera2->organizacao_demandante_cursos($this->session->userdata('access_level'))) {

            $xls = array();
            $xls = $this->create_header("Lista das organizações demandantes e número de cursos demandados", 1);
            $titles = array("ORGANIZAÇÃO DEMANDANTE", "CURSOS");

            array_push($xls, $titles);

            foreach ($result as $row) {
                array_push($xls, $row);
            }

            $this->barchart->set_include_charts(false); // hide charts

            $this->barchart->set_chart_data($xls);
            $this->barchart->set_filename('ORGANIZACAO-DEMANDANTE-CURSOS.xls'); // filename

            $this->barchart->create_chart();
        }
    }

    public function localizacao_parceiros() {

        if ($result = $this->relatorio_geral_m_pnera2->localizacao_parceiros($this->session->userdata('access_level'))) {

            $xls = array();
            $xls = $this->create_header("Localização dos parceiros", 1);
            $titles = array("ESTADO", "CÓD. MUNICÍPIO", "MUNICÍPIO", "PARCEIRO");

            array_push($xls, $titles);

            foreach ($result as $row) {
                array_push($xls, $row);
            }

            $this->barchart->set_include_charts(false); // hide charts

            $this->barchart->set_chart_data($xls);
            $this->barchart->set_filename('LOCALIZACAO-PARCEIROS.xls'); // filename

            $this->barchart->create_chart();
        }
    }

    public function parceiros_modalidade() {

        if ($result = $this->relatorio_geral_m_pnera2->parceiros_modalidade($this->session->userdata('access_level'))) {

            $xls = array();
            $xls = $this->create_header("Parceiros por modalidade", 2);
            $titles = array("MODALIDADE", "PARCEIROS");

            array_push($xls, $titles);

            foreach ($result as $row) {
                array_push($xls, $row);
            }

            // Set the position where the chart should appear in the worksheet
            $this->barchart->set_topLeftCell('I1');
            $this->barchart->set_bottomRightCell('R28');

            $this->barchart->set_chart_colors(array('8B4513'));        // array - colors
            $this->barchart->set_title("PARCEIROS POR MODALIDADE");    // string

            $this->barchart->set_chart_data($xls);                     // data array
            $this->barchart->set_filename('PARCEIROS-MODALIDADE.xls'); // filename

            $this->barchart->create_chart();
        }
    }

    public function parceiros_superintendencia() {

        if ($result = $this->relatorio_geral_m_pnera2->parceiros_superintendencia()) {

            $xls = array();
            $xls = $this->create_header("Parceiros por superintendência", 1);
            $titles = array("CÓDIGO", "SUPERINTENDÊNCIA", "PARCEIROS");

            array_push($xls, $titles);

            foreach ($result as $row) {
                $row['id'] = "SR - " . $this->leading_zeros($row['id'], 2);
                array_push($xls, $row);
            }

            // Set the position where the chart should appear in the worksheet
            $this->barchart->set_topLeftCell('I1');
            $this->barchart->set_bottomRightCell('Q35');

            $this->barchart->set_chart_colors(array('8B4513'));               // array - colors
            $this->barchart->set_title("PARCEIROS POR SUPERINTENDÊNCIA");     // string

            $this->barchart->set_chart_data($xls);                            // data array
            $this->barchart->set_filename('PARCEIROS-SUPERINTENDENCIA.xls');  // filename

            $this->barchart->create_chart();
        }
    }

    public function parceiros_natureza() {

        if ($result = $this->relatorio_geral_m_pnera2->parceiros_natureza($this->session->userdata('access_level'))) {

            $xls = array();
            $xls = $this->create_header("Parceiros por natureza da parceria", 2);
            $titles = array("NATUREZA", "PARCEIROS");

            array_push($xls, $titles);

            foreach ($result as $row) {
                array_push($xls, $row);
            }

            // Set the position where the chart should appear in the worksheet
            $this->barchart->set_topLeftCell('I1');
            $this->barchart->set_bottomRightCell('V28');

            $this->barchart->set_chart_colors(array('CD661D'));        // array - colors
            $this->barchart->set_title("PARCEIROS POR NATUREZA");      // string

            $this->barchart->set_chart_data($xls);                     // data array
            $this->barchart->set_filename('PARCEIROS-NATUREZA.xls');   // filename

            $this->barchart->create_chart();
        }
    }

    public function lista_parceiros() {

        if ($result = $this->relatorio_geral_m_pnera2->lista_parceiros($this->session->userdata('access_level'))) {

            $xls = array();
            $xls = $this->create_header("Lista dos parceiros", 1);
            $titles = array("PARCEIRO");

            array_push($xls, $titles);

            foreach ($result as $row) {
                array_push($xls, $row);
            }

            $this->barchart->set_include_charts(false); // hide charts

            $this->barchart->set_chart_data($xls);
            $this->barchart->set_filename('LISTA-PARCEIROS.xls'); // filename

            $this->barchart->create_chart();
        }
    }

    public function producoes_estado() {

        if ($result = $this->relatorio_geral_m_pnera2->producoes_estado()) {

            $xls = array();
            $xls = $this->create_header("Produções por tipo de produção", 1);
            $titles = array("ESTADO", "PRODUÇÕES GERAIS", "TRABALHOS", "ARTIGOS", "MEMÓRIAS", "LIVROS");

            array_push($xls, $titles);

            foreach ($result as $row) {
                array_push($xls, $row);
            }

            $this->barchart->set_include_charts(false); // hide charts

            $this->barchart->set_chart_data($xls);
            $this->barchart->set_filename('PRODUCOES-ESTADO.xls'); // filename

            $this->barchart->create_chart();
        }
    }

    public function producoes_superintendencia() {

        if ($result = $this->relatorio_geral_m_pnera2->producoes_superintendencia()) {

            $xls = array();
            $xls = $this->create_header("Produções por tipo de produção", 1);
            $titles = array("CÓDIGO", "SUPERINTENDÊNCIA", "PRODUÇÕES GERAIS", "TRABALHOS", "ARTIGOS", "MEMÓRIAS", "LIVROS");

            array_push($xls, $titles);

            foreach ($result as $row) {
                $row['id'] = "SR - " . $this->leading_zeros($row['id'], 2);
                array_push($xls, $row);
            }

            $this->barchart->set_include_charts(false); // hide charts

            $this->barchart->set_chart_data($xls);
            $this->barchart->set_filename('PRODUCOES-SUPERINTENDENCIA.xls'); // filename

            $this->barchart->create_chart();
        }
    }

    public function producoes_tipo() {

        if ($result = $this->relatorio_geral_m_pnera2->producoes_tipo($this->session->userdata('access_level'))) {

            $xls = array();
            $xls = $this->create_header("Produções por tipo de produção", 2);
            $titles = array("TIPO", "PRODUÇÕES");

            array_push($xls, $titles);

            foreach ($result as $row) {
                array_push($xls, $row);
            }

            // Set the position where the chart should appear in the worksheet
            $this->barchart->set_topLeftCell('I1');
            $this->barchart->set_bottomRightCell('V28');

            $this->barchart->set_chart_colors(array('9370DB'));    // array - colors
            $this->barchart->set_title("PRODUÇÕES POR TIPO");      // string

            $this->barchart->set_chart_data($xls);                 // data array
            $this->barchart->set_filename('PRODUCOES-TIPO.xls');   // filename

            $this->barchart->create_chart();
        }
    }

    public function pesquisa_estado() {

        if ($result = $this->relatorio_geral_m_pnera2->pesquisa_estado()) {

            $xls = array();
            $xls = $this->create_header("Produções por tipo de produção", 1);
            $titles = array("ESTADO", "MONOGRAFIAS/DISSERTAÇÕES", "LIVROS/COLETÂNEAS", "CAP. LIVROS", "ARTIGOS", "VÍDEOS/DOCUMENTÁRIOS", "PERIÓDICOS", "EVENTOS");

            array_push($xls, $titles);

            foreach ($result as $row) {
                array_push($xls, $row);
            }

            $this->barchart->set_include_charts(false); // hide charts

            $this->barchart->set_chart_data($xls);
            $this->barchart->set_filename('PRODUCOES-PRONERA-ESTADO.xls'); // filename

            $this->barchart->create_chart();
        }
    }

    public function pesquisa_superintendencia() {

        if ($result = $this->relatorio_geral_m_pnera2->pesquisa_superintendencia()) {

            $xls = array();
            $xls = $this->create_header("Produções por tipo de produção", 1);
            $titles = array("CÓDIGO", "SUPERINTENDÊNCIA", "MONOGRAFIAS/DISSERTAÇÕES", "LIVROS/COLETÂNEAS", "CAP. LIVROS", "ARTIGOS", "VÍDEOS/DOCUMENTÁRIOS", "PERIÓDICOS", "EVENTOS");

            array_push($xls, $titles);

            foreach ($result as $row) {
                $row['id'] = "SR - " . $this->leading_zeros($row['id'], 2);
                array_push($xls, $row);
            }

            $this->barchart->set_include_charts(false); // hide charts

            $this->barchart->set_chart_data($xls);
            $this->barchart->set_filename('PRODUCOES-PRONERA-SUPERINTENDENCIA.xls'); // filename

            $this->barchart->create_chart();
        }
    }

    public function pesquisa_tipo() {

        if ($result = $this->relatorio_geral_m_pnera2->pesquisa_tipo($this->session->userdata('access_level'))) {

            $xls = array();
            $xls = $this->create_header("Produções por tipo de produção", 2);
            $titles = array("TIPO", "PRODUÇÕES");

            array_push($xls, $titles);

            foreach ($result as $row) {
                array_push($xls, $row);
            }

            // Set the position where the chart should appear in the worksheet
            $this->barchart->set_topLeftCell('I1');
            $this->barchart->set_bottomRightCell('Q28');

            $this->barchart->set_chart_colors(array('B03060'));                 // array - colors
            $this->barchart->set_title("PRODUÇÕES SOBRE O PRONERA POR TIPO");   // string

            $this->barchart->set_chart_data($xls);                              // data array
            $this->barchart->set_filename('PRODUCOES-PRONERA-TIPO.xls');        // filename

            $this->barchart->create_chart();
        }
    }

}