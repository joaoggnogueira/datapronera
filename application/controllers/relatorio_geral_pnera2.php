<?php

class Relatorio_geral_pnera2 extends CI_Controller {

    private $access_level;

    public function __construct() {
        parent::__construct();

        $this->load->database();            // Loading Database
        $this->load->library('session');    // Loading Session
        $this->load->helper('url');         // Loading Helper

        $this->load->model('relatorio_geral_m_pnera2');     // Loading Model
        $this->load->model('requisicao_m');     // Loading Model
        $this->load->model('barchart');              // Loading Model
    }

    public function index() {
        $valores = array();
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
            $cabe = array("Relatório: ".$name, "", "", "", "", "", "", "", "", "");
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

    public function municipios_curso_modalidade($tipo){
        
        $result = $this->relatorio_geral_m_pnera2->municipios_curso_modalidade($this->session->userdata('access_level'));
        //var_dump($result);
        if ($result) {
            if($tipo == 1){
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
                $this->barchart->set_excelFile();
                
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Municípios de realização dos cursos por modalidade';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');

                for ($i=0; $i < sizeof($result); $i++) { 
                    $result[$i]['id_curso'] = $this->leading_zeros($result[$i]['id_superintendencia'], 2) . $this->leading_zeros($result[$i]['id_curso'], 3);
                }

                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/municipios_curso_modalidade', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function municipios_curso($tipo) {
        
        if ($result = $this->relatorio_geral_m_pnera2->municipios_curso($this->session->userdata('access_level'))) {
            if($tipo==1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Municípios de realização dos cursos';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/municipios_curso', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function cursos_modalidade($tipo) {
        
        if ($result = $this->relatorio_geral_m_pnera2->cursos_modalidade($this->session->userdata('access_level'))) {
            if($tipo==1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Cursos por modalidade';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/cursos_modalidade', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }
    
    public function cursos_nivel($tipo) {
        
        if ($result = $this->relatorio_geral_m_pnera2->cursos_nivel($this->session->userdata('access_level'))) {
            if($tipo == 1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Cursos por nivel';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/cursos_nivel', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        } else {
            echo "falha ao buscar na base de dados";
        }
    }

    public function cursos_nivel_superintendencia($tipo) {
        if ($result = $this->relatorio_geral_m_pnera2->cursos_nivel_superintendencia()) {
            if($tipo==1){
                $titles = array();
                $titles[0] = "CÓDIGO";
                $titles[1] = "SUPERINTENDÊNCIA";
                $titles[2] = "EJA FUNDAMENTAL";
                $titles[3] = "ENSINO MÉDIO";
                $titles[4] = "ENSINO SUPERIOR";
                $titles[5] = "TOTAL";
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Cursos por nivel e superintendência';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/cursos_nivel_superintendencia', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function cursos_superintendencia($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->cursos_superintendencia()) {
            if($tipo == 1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Cursos por superintendência';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/cursos_superintendencia', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function alunos_ingressantes_modalidade($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->alunos_ingressantes_modalidade($this->session->userdata('access_level'))) {
            if($tipo==1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Alunos ingressantes por modalidade';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/alunos_ingressantes_modalidade', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function alunos_ingressantes_nivel($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->alunos_ingressantes_nivel($this->session->userdata('access_level'))) {
            if($tipo==1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Alunos ingressantes por nível';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/alunos_ingressantes_nivel', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function alunos_ingressantes_superintendencia($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->alunos_ingressantes_superintendencia()) {
            if($tipo==1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Alunos ingressantes por superintendência';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/alunos_ingressantes_superintendencia', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function alunos_ingressantes_nivel_sr($tipo) {
        if ($result = $this->relatorio_geral_m_pnera2->alunos_ingressantes_nivel_sr()) {
            if($tipo==1){
                $titles = array();
                $titles[0] = "CÓDIGO";
                $titles[1] = "SUPERINTENDÊNCIA";
                $titles[2] = "EJA FUNDAMENTAL";
                $titles[3] = "ENSINO MÉDIO";
                $titles[4] = "ENSINO SUPERIOR";
                $titles[5] = "TOTAL";
                $xls = array();
                $xls = $this->create_header("Alunos ingressantes por nível e superintendência", 1);
                array_push($xls, $titles);

                foreach ($result as $row) {
                    $row['id'] = "SR - " . $this->leading_zeros($row['id'], 2);
                    array_push($xls, $row);
                }

                $this->barchart->set_include_charts(false); // hide charts

                $this->barchart->set_chart_data($xls);                              // data array
                $this->barchart->set_filename('INGRESSANTES-NIVEL-SUPERINTENDENCIA.xls'); // filename
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Alunos ingressantes por nível e superintendência';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/alunos_ingressantes_nivel_sr', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function alunos_concluintes_modalidade($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->alunos_concluintes_modalidade($this->session->userdata('access_level'))) {
            if($tipo==1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Alunos concluintes por modalidade';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/alunos_concluintes_modalidade', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function alunos_concluintes_nivel($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->alunos_concluintes_nivel($this->session->userdata('access_level'))) {
            if($tipo==1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Alunos concluintes por nível';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/alunos_concluintes_nivel', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function alunos_concluintes_superintendencia($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->alunos_concluintes_superintendencia()) {
            if($tipo==1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Alunos concluintes por superintendência';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/alunos_concluintes_superintendencia', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function alunos_concluintes_nivel_sr($tipo) {
        if ($result = $this->relatorio_geral_m_pnera2->alunos_concluintes_nivel_sr()) {
            if($tipo==1){
                $titles = array();
                $titles[0] = "CÓDIGO";
                $titles[1] = "SUPERINTENDÊNCIA";
                $titles[2] = "EJA FUNDAMENTAL";
                $titles[3] = "ENSINO MÉDIO";
                $titles[4] = "ENSINO SUPERIOR";
                $titles[5] = "TOTAL";
                $xls = array();
                $xls = $this->create_header("Alunos concluintes por nível e superintendência", 1);
                array_push($xls, $titles);

                foreach ($result as $row) {
                    $row['id'] = "SR - " . $this->leading_zeros($row['id'], 2);
                    array_push($xls, $row);
                }

                $this->barchart->set_include_charts(false); // hide charts

                $this->barchart->set_chart_data($xls);                              // data array
                $this->barchart->set_filename('CONCLUINTES-NIVEL-SUPERINTENDENCIA.xls'); // filename
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Alunos concluintes por nível e superintendência';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/alunos_concluintes_nivel_sr', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function lista_cursos_modalidade($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->lista_cursos_modalidade($this->session->userdata('access_level'))) {
            if($tipo==1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Lista de cursos por modalidade';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                for ($i=0; $i < sizeof($result); $i++) { 
                    $result[$i]['id_curso'] = $this->leading_zeros($result[$i]['id_superintendencia'], 2) . $this->leading_zeros($result[$i]['id_curso'], 3);
                }

                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/lista_cursos_modalidade', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function lista_cursos_modalidade_sr($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->lista_cursos_modalidade_sr($this->session->userdata('access_level'))) {
            if($tipo==1){
                $xls = array();
                $xls = $this->create_header("Lista de cursos por modalidade", 1);
                $titles = array("CÓDIGO", "SUPERINTENDÊNCIA", "MODALIDADE","CÓDIGO", "CURSO");

                array_push($xls, $titles);

                foreach ($result as $row) {

                    
                    $row['id_curso'] = $this->leading_zeros($row['id_superintendencia'], 2) . $this->leading_zeros($row['id_curso'], 3);
                    $row['id_superintendencia'] = "SR - " . $this->leading_zeros($row['id_superintendencia'], 2);
                    array_push($xls, $row);
                }

                $this->barchart->set_include_charts(false); // hide charts

                $this->barchart->set_chart_data($xls);
                $this->barchart->set_filename('LISTA-CURSOS-MODALIDADE-SR.xls'); // filename
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Lista de cursos por modalidade';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                for ($i=0; $i < sizeof($result); $i++) { 
                    $result[$i]['id_curso'] = $this->leading_zeros($result[$i]['id_superintendencia'], 2) . $this->leading_zeros($result[$i]['id_curso'], 3);
                }

                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/lista_cursos_modalidade_sr', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function alunos_curso($tipo,$idsr){

        if ($result = $this->relatorio_geral_m_pnera2->alunos_curso($idsr)) {
            $nomesr = $this->requisicao_m->get_superintendencias_nome(1,$idsr);
            if($tipo==1){
                $xls = array();
                $xls = $this->create_header("Lista de alunos por curso da superintendência - ".$nomesr, 1);
                $titles = array("CÓDIGO", "CURSO", "EDUCANDO");

                array_push($xls, $titles);

                foreach ($result as $row) {
                    $row['id_curso'] = $this->leading_zeros($row['id_superintendencia'], 2) . $this->leading_zeros($row['id_curso'], 3);
                    unset($row['id_superintendencia']);
                    array_push($xls, $row);
                }

                $this->barchart->set_include_charts(false); // hide charts

                $this->barchart->set_chart_data($xls);
                $this->barchart->set_filename("LISTA-CURSOS-ALUNO-SR-$idsr.xls"); // filename
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = "Lista de alunos por curso da superintendência - ".$nomesr;
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                for ($i=0; $i < sizeof($result); $i++) { 
                    $result[$i]['id_curso'] = $this->leading_zeros($result[$i]['id_superintendencia'], 2) . $this->leading_zeros($result[$i]['id_curso'], 3);
                }

                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/alunos_curso', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function titulacao_educadores($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->titulacao_educadores($this->session->userdata('access_level'))) {
            if($tipo==1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Escolaridade/titulação dos educadores';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/titulacao_educadores', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function titulacao_educadores_superintendencia($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->titulacao_educadores_superintendencia()) {
            if($tipo==1){
                $xls = array();
                $xls = $this->create_header("Escolaridade/titulação dos educadores por superintendência", 1);
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Escolaridade/titulação dos educadores por superintendência';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/titulacao_educadores_superintendencia', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function educadores_nivel($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->educadores_nivel($this->session->userdata('access_level'))) {
            if($tipo==1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Educadores por nível';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/educadores_nivel', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function educadores_curso($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->educadores_curso($this->session->userdata('access_level'))) {
            if($tipo==1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Educadores por curso';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                for ($i=0; $i < sizeof($result); $i++) { 
                    $result[$i]['id_curso'] = $this->leading_zeros($result[$i]['id_superintendencia'], 2) . $this->leading_zeros($result[$i]['id_curso'], 3);
                }

                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/educadores_curso', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function educadores_superintendencia($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->educadores_superintendencia()) {
            if($tipo==1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Educadores por superintendência';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/educadores_superintendencia', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function genero_educadores_modalidade($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->genero_educadores_modalidade($this->session->userdata('access_level'))) {
            if($tipo==1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Participação de homens e mulheres como educadores dos cursos por modalidade';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/genero_educadores_modalidade', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function educandos_superintendencia($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->educandos_superintendencia()) {
            if($tipo==1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Educandos por superintendência';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/educandos_superintendencia', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function municipio_origem_educandos($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->municipio_origem_educandos($this->session->userdata('access_level'))) {
            if($tipo==1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Município de origem dos educandos';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/municipio_origem_educandos', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function territorio_educandos_modalidade($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->territorio_educandos_modalidade($this->session->userdata('access_level'))) {
            if($tipo==1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Território de origem dos educandos por modalidade';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/territorio_educandos_modalidade', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function territorio_educandos_superintendencia($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->territorio_educandos_superintendencia()) {
            if($tipo==1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Território de origem dos educandos por superintendência';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/territorio_educandos_superintendencia', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function idade_educandos_modalidade($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->idade_educandos_modalidade($this->session->userdata('access_level'))) {
            if($tipo==1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Idade média dos educandos por modalidade';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/idade_educandos_modalidade', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function genero_educandos_modalidade($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->genero_educandos_modalidade($this->session->userdata('access_level'))) {
            if($tipo==1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Participação de homens e mulheres como educandos nos cursos por modalidade';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/genero_educandos_modalidade', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function educandos_assentamento_modalidade($tipo) {

        // GAMBIARRRA para aumentar a área de memória 
        ini_set('memory_limit', '1024M');

        if ($result = $this->relatorio_geral_m_pnera2->educandos_assentamento_modalidade()) {
            if($tipo==1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Educandos por assentamento e modalidade de curso';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/educandos_assentamento_modalidade', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function educandos_assentamento_nivel($tipo) {

        // GAMBIARRRA para aumentar a área de memória 
        ini_set('memory_limit', '2048M');

        if ($result = $this->relatorio_geral_m_pnera2->educandos_assentamento_nivel()) {
            if($tipo==1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Educandos por assentamento e nível de curso';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/educandos_assentamento_nivel', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    //não funcional
    public function lista_educandos_cursos_sr($tipo,$sr) {

        // GAMBIARRRA para aumentar a área de memória
        // kkkk^
        // Agora limitei por superintendencia
        ini_set('memory_limit', '1024M');

        if ($result = $this->relatorio_geral_m_pnera2->lista_educandos_cursos_sr($sr)) {
            $nomesr = $this->requisicao_m->get_superintendencias_nome(1,$sr);
            if($tipo==1){
                $xls = array();
                $xls = $this->create_header("Educandos, superintendência e curso - $nomesr", 1);
                $titles = array("NOME EDUCANDO", "TIPO TERRITÓRIO", "NOME TERRITÓRIO", "CÓD. SR", "CÓD. CURSO", "NOME CURSO", "MODALIDADE CURSO");

                array_push($xls, $titles);

                foreach ($result as $row) {

                    array_push($xls, $row);
                }

                $this->barchart->set_include_charts(false); // hide charts

                $this->barchart->set_chart_data($xls);
                $this->barchart->set_filename("LISTA-EDUCANDOS-CURSOS-SR-$sr.xls"); // filename
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = "Educandos, superintendência e curso - $nomesr";
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/lista_educandos_cursos_sr', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        } else {
            echo "ERRO";
        }
    }

    public function localizacao_instituicoes_ensino($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->localizacao_instituicoes_ensino($this->session->userdata('access_level'))) {
            if($tipo == 1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Localização das instituições de ensino';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/localizacao_instituicoes_ensino', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function instituicoes_ensino_modalidade($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->instituicoes_ensino_modalidade($this->session->userdata('access_level'))) {
            if($tipo == 1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Instituições de ensino que realizaram cursos por modalidade';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/instituicoes_ensino_modalidade', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function instituicoes_ensino_nivel($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->instituicoes_ensino_nivel($this->session->userdata('access_level'))) {
            if($tipo==1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Instituições de ensino que realizaram cursos por nível';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/instituicoes_ensino_nivel', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function instituicoes_ensino_superintendencia($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->instituicoes_ensino_superintendencia()) {
            if($tipo==1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Instituições de ensino que realizaram cursos por superintendência';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/instituicoes_ensino_superintendencia', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function instituicoes_ensino_municipio($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->instituicoes_ensino_municipio($this->session->userdata('access_level'))) {
            if($tipo == 1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Instituições de ensino que realizaram cursos por municípios';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/instituicoes_ensino_municipio', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function instituicoes_ensino_estado($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->instituicoes_ensino_estado()) {
            if($tipo == 1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Instituições de ensino que realizaram cursos por estados';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/instituicoes_ensino_estado', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function cursos_natureza_inst_ensino($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->cursos_natureza_inst_ensino($this->session->userdata('access_level'))) {
            if($tipo == 1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Natureza das instituições de ensino e número de cursos realizados';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/cursos_natureza_inst_ensino', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function instituicao_ensino_cursos($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->instituicao_ensino_cursos($this->session->userdata('access_level'))) {
            if($tipo==1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Lista das instituições de ensino e número de cursos realizados';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/instituicao_ensino_cursos', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function organizacoes_demandantes_modalidade($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->organizacoes_demandantes_modalidade($this->session->userdata('access_level'))) {
            if($tipo==1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Organizações demandantes por modalidade';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/organizacoes_demandantes_modalidade', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function membros_org_demandantes_modalidade($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->membros_org_demandantes_modalidade($this->session->userdata('access_level'))) {
            if($tipo==1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Porcentagem dos membros das organizações demandantes participantes de cursos do PRONERA por modalidade';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/membros_org_demandantes_modalidade', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function organizacao_demandante_cursos($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->organizacao_demandante_cursos($this->session->userdata('access_level'))) {
            if($tipo==1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Lista das organizações demandantes e número de cursos demandados';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/organizacao_demandante_cursos', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function localizacao_parceiros($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->localizacao_parceiros($this->session->userdata('access_level'))) {
            if($tipo==1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Localização dos parceiros';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/localizacao_parceiros', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function parceiros_modalidade($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->parceiros_modalidade($this->session->userdata('access_level'))) {
            if($tipo==1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Parceiros por modalidade';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/parceiros_modalidade', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function parceiros_superintendencia($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->parceiros_superintendencia()) {
            if($tipo==1){
                $xls = array();
                $xls = $this->create_header("Parceiros por superintendência", 2);
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Parceiros por superintendência';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/parceiros_superintendencia', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function parceiros_natureza($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->parceiros_natureza($this->session->userdata('access_level'))) {
            if($tipo == 1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Parceiros por natureza da parceria';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/parceiros_natureza', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    //erro na criacao do xls
    public function lista_parceiros($tipo) {
        if ($result = $this->relatorio_geral_m_pnera2->lista_parceiros($this->session->userdata('access_level'))) {
            if($tipo==1){
                $xls = array();
                $xls = $this->create_header("Lista dos parceiros", 1);
                $titles = array("PARCEIRO");
                array_push($xls, $titles);

                foreach ($result as $row) {
                    array_push($xls, $row);
                }
                $this->barchart->set_topLeftCell('I1');
                $this->barchart->set_bottomRightCell('V28');

                $this->barchart->set_chart_colors(array('CD661D'));        // array - colors
                $this->barchart->set_include_charts(false); // hide charts

                $this->barchart->set_chart_data($xls);
                $this->barchart->set_filename('LISTA-PARCEIROS.xls'); // filename
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Lista dos parceiros';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/lista_parceiros', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function producoes_estado($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->producoes_estado()) {
            if($tipo==1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Produções por tipo de produção';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/producoes_estado', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function producoes_superintendencia($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->producoes_superintendencia()) {
            if($tipo==1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Produções por tipo de produção';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/producoes_superintendencia', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function producoes_tipo($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->producoes_tipo($this->session->userdata('access_level'))) {
            if($tipo==1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Produções por tipo de produção';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/producoes_tipo', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function pesquisa_estado($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->pesquisa_estado()) {
            if($tipo==1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Produções por tipo de produção';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/pesquisa_estado', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function pesquisa_superintendencia($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->pesquisa_superintendencia()) {
            if($tipo==1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Produções por tipo de produção';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/pesquisa_superintendencia', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }

    public function pesquisa_tipo($tipo) {

        if ($result = $this->relatorio_geral_m_pnera2->pesquisa_tipo($this->session->userdata('access_level'))) {
            if($tipo==1){
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
                $this->barchart->set_excelFile();
                $this->barchart->create_chart();
            }
            else if($tipo == 2){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->load->library('pdf');            
                $pdf = $this->pdf->load();
                $data['titulo_relatorio'] = 'Produções por tipo de produção';
                $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true); 
                $pdf->SetHTMLHeader($header);
                $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   ');
                
                $dataResult['result'] = $result;
                $pdf->WriteHTML($this->load->view('relatorio/2pnera/pesquisa_tipo', $dataResult, true));
                $pdf->Output($pdfFilePath, 'I'); 
            }
        }
    }
}