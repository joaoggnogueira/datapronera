<?php

class Relatorio_geral_pnera2 extends CI_Controller
{

    private $access_level;

    public function __construct()
    {
        parent::__construct();

        $this->load->database();            // Loading Database
        $this->load->library('session');    // Loading Session
        $this->load->helper('url');         // Loading Helper

        $this->load->model('relatorio_geral_m_pnera2');     // Loading Model
        $this->load->model('requisicao_m');     // Loading Model
        $this->load->model('barchart');              // Loading Model
    }

    public function index()
    {
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

    private function create_header($name, $title_status)
    {
        $xls = array();
        $access_level = $this->session->userdata('access_level');
        if ($access_level <= 3) {
            $nomeSR = $this->requisicao_m->get_superintendencias_nome(1, $this->session->userdata('id_superintendencia'));
        }
        if ($title_status == false) {
            $title_status = "Todos Cursos";
        }
        $cabe = array("------------------------------------------------------------------------------------------", "", "", "", "", "", "", "", "", "");
        array_push($xls, $cabe);
        $cabe = array("Programa Nacional de Educa????o na Reforma Agr??ria (Pronera)", "", "", "", "", "", "", "", "", "");
        array_push($xls, $cabe);
        $cabe = array("Cursos - $title_status", "", "", "", "", "", "", "", "", "");
        array_push($xls, $cabe);
        $cabe = array($name, "", "", "", "", "", "");
        array_push($xls, $cabe);
        if ($access_level <= 3) {
            $cabe = array("Relat??rio: " . $name, " - Superintend??ncia: " . $nomeSR, "", "", "", "", "", "", "", "");
            array_push($xls, $cabe);
        } else {
            $cabe = array("Relat??rio: " . $name, "", "", "", "", "", "", "", "", "");
            array_push($xls, $cabe);
        }
        $cabe = array("Data de Emiss??o: " . date('d/m/y'), "", "", "", "", "", "", "", "", "");
        array_push($xls, $cabe);
        $cabe = array("------------------------------------------------------------------------------------------", "", "", "", "", "", "", "", "");
        array_push($xls, $cabe);
        $cabe = array("", "", "", "", "", "", "", "", "", "");
        array_push($xls, $cabe);

        return $xls;
    }

    private function append_xls_data($xls, $data, $header)
    {
        array_push($xls, $header);

        foreach ($data as $row) {
            array_push($xls, $row);
        }

        return $xls;
    }

    private function write_pdf($titulo, $result, $title_status, $model)
    {
        error_reporting(E_ALL ^ E_DEPRECATED);
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $data['titulo_relatorio'] = $titulo;
        $data['title_status'] = $title_status;
        $access_level = $this->session->userdata('access_level');
        if ($access_level <= 3) {
            $data['nomeSR'] = $this->requisicao_m->get_superintendencias_nome(1, $this->session->userdata('id_superintendencia'));
        }
        $header = $this->load->view('relatorio/2pnera/header_pdf', $data, true);
        $pdf->SetHTMLHeader($header);
        $pdf->SetFooter('   Relat??rio Extra??do do Sistema DataPronera' . '|P??gina {PAGENO}|' . date("d.m.Y") . '   ');

        $dataResult['result'] = $result;
        $pdf->WriteHTML($this->load->view($model, $dataResult, true));
        $pdf->Output($pdfFilePath, 'I');
    }

    private function write_html($titulo, $result, $title_status, $model)
    {
        $data = array();
        $data['titulo_relatorio'] = $titulo;
        $data['title_status'] = $title_status;
        $access_level = $this->session->userdata('access_level');
        if ($access_level <= 3) {
            $data['nomeSR'] = $this->requisicao_m->get_superintendencias_nome(1, $this->session->userdata('id_superintendencia'));
        }

        echo utf8_decode($this->load->view('relatorio/2pnera/header_html', $data, true));
        echo utf8_decode('   Relat??rio Extra??do do Sistema DataPronera ' . date("d.m.Y"));

        $dataResult['result'] = $result;
        echo utf8_decode($this->load->view($model, $dataResult, true));
    }

    private function write_xls($xls_data, $title)
    {
        $this->barchart->set_chart_data($xls_data);
        $this->barchart->set_filename($title);
        $this->barchart->set_excelFile();

        $this->barchart->create_chart();
    }

    private function handle_error()
    {
        echo $this->load->view('relatorio/2pnera/error', array(), true);
    }

    private function handle_empty()
    {
        echo $this->load->view('relatorio/2pnera/empty', array(), true);
    }

    private function get_status()
    {
        $status = $this->input->get("status");
        if ($status == false) {
            return array("AN", "CC", "2P");
        }
        return $status;
    }

    private function get_vigencia()
    {
        return $this->input->get("vigencia");
    }

    private function switch_status($stat)
    {
        switch ($stat) {
            case "AN":
                return "Em Andamento";
            case "CC":
                return "Conclu??do";
            case "2P":
                return "II PNERA";
        }
    }

    private function title_status($status)
    {
        $title = false;
        foreach ($status as $stat) {
            if ($title == false) {
                $title = $this->switch_status($stat);
            } else {
                $title .= ", " . $this->switch_status($stat);
            }
        }
        return $title;
    }

    public function municipios_curso_modalidade($tipo)
    {

        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->municipios_curso_modalidade($this->session->userdata('access_level'), $vigencia, $status);

        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {

                    $xls = $this->create_header("Munic??pios de realiza????o dos cursos por modalidade", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("MODALIDADE", "ESTADO", "C??D. MUNIC??PIO", "MUNIC??PIO", "C??D. CURSO", "CURSO"));

                    $this->barchart->set_include_charts(false); // hide charts

                    $this->barchart->set_number_format("00.000");

                    $this->write_xls($xls, 'MUNICIPIOS-CURSO-MODALIDADE.xls');
                } else if ($tipo == 2) {
                    $this->write_pdf('Munic??pios de realiza????o dos cursos por modalidade', $result, $title_status, 'relatorio/2pnera/municipios_curso_modalidade');
                } else if ($tipo == 3) {
                    $this->write_html('Munic??pios de realiza????o dos cursos por modalidade', $result, $title_status, 'relatorio/2pnera/municipios_curso_modalidade');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function municipios_curso($tipo)
    {

        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->municipios_curso($this->session->userdata('access_level'), $vigencia, $status);

        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Munic??pios de realiza????o dos cursos", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("ESTADO", "MUNIC??PIO", "C??D. MUNIC??PIO", "CURSOS"));

                    $this->barchart->set_include_charts(false); // hide charts

                    $this->write_xls($xls, 'MUNICIPIOS-CURSO.xls');
                } else if ($tipo == 2) {
                    $this->write_pdf('Munic??pios de realiza????o dos cursos', $result, $title_status, 'relatorio/2pnera/municipios_curso');
                } else if ($tipo == 3) {
                    $this->write_html('Munic??pios de realiza????o dos cursos', $result, $title_status, 'relatorio/2pnera/municipios_curso');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function cursos_modalidade($tipo)
    {

        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->cursos_modalidade($this->session->userdata('access_level'), $vigencia, $status);

        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Cursos por modalidade", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("MODALIDADE", "CURSOS"));

                    $this->barchart->set_topLeftCell('K1');
                    $this->barchart->set_bottomRightCell('Q35');

                    $this->barchart->set_chart_colors(array('8B1A1A'));
                    $this->barchart->set_title("CURSOS POR MODALIDADE");

                    $this->write_xls($xls, 'CURSOS-MODALIDADE.xls');
                } else if ($tipo == 2) {
                    $this->write_pdf('Cursos por modalidade', $result, $title_status, 'relatorio/2pnera/cursos_modalidade');
                } else if ($tipo == 3) {
                    $this->write_html('Cursos por modalidade', $result, $title_status, 'relatorio/2pnera/cursos_modalidade');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function cursos_nivel($tipo)
    {

        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->cursos_nivel($this->session->userdata('access_level'), $vigencia, $status);

        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Cursos por n??vel", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("N??VEL", "CURSOS"));

                    $this->barchart->set_topLeftCell('K1');
                    $this->barchart->set_bottomRightCell('Q10');

                    $this->barchart->set_chart_colors(array('8B1A1A'));             // array - colors
                    $this->barchart->set_title("CURSOS POR N??VEL");                 // string

                    $this->write_xls($xls, 'CURSOS-NIVEL.xls');
                } else if ($tipo == 2) {
                    $this->write_pdf('Cursos por nivel', $result, $title_status, 'relatorio/2pnera/cursos_nivel');
                } else if ($tipo == 3) {
                    $this->write_html('Cursos por nivel', $result, $title_status, 'relatorio/2pnera/cursos_nivel');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function cursos_nivel_superintendencia($tipo)
    {

        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->cursos_nivel_superintendencia($vigencia, $status);

        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Cursos por n??vel e superintend??ncia", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("C??DIGO", "SUPERINTEND??NCIA", "EJA FUNDAMENTAL", "ENSINO M??DIO", "ENSINO SUPERIOR", "TOTAL"));

                    $this->barchart->set_include_charts(false);

                    $this->write_xls($xls, 'CURSOS-NIVEL-SUPERINTENDENCIA.xls');
                } else if ($tipo == 2) {
                    $this->write_pdf('Cursos por nivel e superintend??ncia', $result, $title_status, 'relatorio/2pnera/cursos_nivel_superintendencia');
                } else if ($tipo == 3) {
                    $this->write_html('Cursos por nivel e superintend??ncia', $result, $title_status, 'relatorio/2pnera/cursos_nivel_superintendencia');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function cursos_superintendencia($tipo)
    {

        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->cursos_superintendencia($this->session->userdata('access_level'), $vigencia, $status);

        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Cursos por superintend??ncia", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("C??DIGO", "SUPERINTEND??NCIA", "CURSOS"));

                    $this->barchart->set_topLeftCell('K1');
                    $this->barchart->set_bottomRightCell('Q35');

                    $this->barchart->set_legend_col('B');
                    $this->barchart->set_num_legend_columns(2);

                    $this->barchart->set_chart_colors(array('8B1A1A'));
                    $this->barchart->set_title("CURSOS POR SUPERINTEND??NCIA");

                    $this->write_xls($xls, 'CURSOS-SUPERINTENDENCIA.xls');
                } else if ($tipo == 2) {
                    $this->write_pdf('Cursos por superintend??ncia', $result, $title_status, 'relatorio/2pnera/cursos_superintendencia');
                } else if ($tipo == 3) {
                    $this->write_html('Cursos por superintend??ncia', $result, $title_status, 'relatorio/2pnera/cursos_superintendencia');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function alunos_ingressantes_modalidade($tipo)
    {

        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->alunos_ingressantes_modalidade($this->session->userdata('access_level'), $vigencia, $status);

        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Alunos ingressantes por modalidade", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("MODALIDADE", "ALUNOS INGRESSANTES"));

                    $this->barchart->set_topLeftCell('K1');
                    $this->barchart->set_bottomRightCell('R35');

                    $this->barchart->set_number_format('_(* #,##0_);_(* (#,##0);_(* "-"??_);_(@_)');

                    $this->barchart->set_chart_colors(array('8B5742'));                  // array - colors
                    $this->barchart->set_title("ALUNOS INGRESSANTES POR MODALIDADE");    // string

                    $this->write_xls($xls, 'ALUNOS-INGRESSANTES-MODALIDADE.xls');
                } else if ($tipo == 2) {
                    $this->write_pdf('Alunos ingressantes por modalidade', $result, $title_status, 'relatorio/2pnera/alunos_ingressantes_modalidade');
                } else if ($tipo == 3) {
                    $this->write_html('Alunos ingressantes por modalidade', $result, $title_status, 'relatorio/2pnera/alunos_ingressantes_modalidade');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function alunos_ingressantes_nivel($tipo)
    {

        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->alunos_ingressantes_nivel($this->session->userdata('access_level'), $vigencia, $status);

        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Alunos ingressantes por n??vel", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("N??VEL", "ALUNOS INGRESSANTES"));

                    $this->barchart->set_topLeftCell('K1');
                    $this->barchart->set_bottomRightCell('R35');

                    $this->barchart->set_number_format('_(* #,##0_);_(* (#,##0);_(* "-"??_);_(@_)');

                    $this->barchart->set_chart_colors(array('8B5742'));                  // array - colors
                    $this->barchart->set_title("ALUNOS INGRESSANTES POR N??VEL");    // string

                    $this->write_xls($xls, 'ALUNOS-INGRESSANTES-NIVEL.xls');
                } else if ($tipo == 2) {
                    $this->write_pdf('Alunos ingressantes por n??vel', $result, $title_status, 'relatorio/2pnera/alunos_ingressantes_nivel');
                } else if ($tipo == 3) {
                    $this->write_html('Alunos ingressantes por n??vel', $result, $title_status, 'relatorio/2pnera/alunos_ingressantes_nivel');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function alunos_ingressantes_superintendencia($tipo)
    {

        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->alunos_ingressantes_superintendencia($vigencia, $status);

        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Alunos ingressantes por superintend??ncia", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("C??DIGO", "SUPERINTEND??NCIA", "ALUNOS INGRESSANTES"));

                    $this->barchart->set_topLeftCell('K1');
                    $this->barchart->set_bottomRightCell('R35');

                    $this->barchart->set_legend_col('B');
                    $this->barchart->set_num_legend_columns(2);

                    $this->barchart->set_number_format('_(* #,##0_);_(* (#,##0);_(* "-"??_);_(@_)');

                    $this->barchart->set_chart_colors(array('8B5742'));                        // array - colors
                    $this->barchart->set_title("ALUNOS INGRESSANTES POR SUPERINTEND??NCIA");    // string

                    $this->write_xls($xls, 'ALUNOS-INGRESSANTES-SUPERINTENDENCIA.xls');
                } else if ($tipo == 2) {
                    $this->write_pdf('Alunos ingressantes por superintend??ncia', $result, $title_status, 'relatorio/2pnera/alunos_ingressantes_superintendencia');
                } else if ($tipo == 3) {
                    $this->write_html('Alunos ingressantes por superintend??ncia', $result, $title_status, 'relatorio/2pnera/alunos_ingressantes_superintendencia');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function alunos_ingressantes_nivel_sr($tipo)
    {

        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->alunos_ingressantes_nivel_sr($vigencia, $status);

        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Alunos ingressantes por n??vel e superintend??ncia", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("C??DIGO", "SUPERINTEND??NCIA", "EJA FUNDAMENTAL", "ENSINO M??DIO", "ENSINO SUPERIOR", "TOTAL"));

                    $this->barchart->set_include_charts(false); // hide charts

                    $this->write_xls($xls, 'INGRESSANTES-NIVEL-SUPERINTENDENCIA.xls');
                } else if ($tipo == 2) {
                    $this->write_pdf('Alunos ingressantes por n??vel e superintend??ncia', $result, $title_status, 'relatorio/2pnera/alunos_ingressantes_nivel_sr');
                } else if ($tipo == 3) {
                    $this->write_html('Alunos ingressantes por n??vel e superintend??ncia', $result, $title_status, 'relatorio/2pnera/alunos_ingressantes_nivel_sr');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function alunos_concluintes_modalidade($tipo)
    {
        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->alunos_concluintes_modalidade($this->session->userdata('access_level'), $vigencia, $status);
        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Alunos concluintes por modalidade", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("MODALIDADE", "ALUNOS CONCLUINTES"));

                    $this->barchart->set_topLeftCell('K1');
                    $this->barchart->set_bottomRightCell('R10');

                    $this->barchart->set_number_format('_(* #,##0_);_(* (#,##0);_(* "-"??_);_(@_)');

                    $this->barchart->set_chart_colors(array('8B5742'));                  // array - colors
                    $this->barchart->set_title("ALUNOS CONCLUINTES POR MODALIDADE");    // string

                    $this->write_xls($xls, 'ALUNOS-CONCLUINTES-MODALIDADE.xls');
                } else if ($tipo == 2) {
                    $this->write_pdf('Alunos concluintes por modalidade', $result, $title_status, 'relatorio/2pnera/alunos_concluintes_modalidade');
                } else if ($tipo == 3) {
                    $this->write_html('Alunos concluintes por modalidade', $result, $title_status, 'relatorio/2pnera/alunos_concluintes_modalidade');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function alunos_concluintes_nivel($tipo)
    {

        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->alunos_concluintes_nivel($this->session->userdata('access_level'), $vigencia, $status);

        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Alunos concluintes por n??vel", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("N??VEL", "ALUNOS CONCLUINTES"));

                    $this->barchart->set_topLeftCell('K1');
                    $this->barchart->set_bottomRightCell('R10');

                    $this->barchart->set_number_format('_(* #,##0_);_(* (#,##0);_(* "-"??_);_(@_)');

                    $this->barchart->set_chart_colors(array('8B5742'));                  // array - colors
                    $this->barchart->set_title("ALUNOS CONCLUINTES POR N??VEL");    // string

                    $this->write_xls($xls, 'ALUNOS-CONCLUINTES-NIVEL.xls');
                } else if ($tipo == 2) {
                    $this->write_pdf('Alunos concluintes por n??vel', $result, $title_status, 'relatorio/2pnera/alunos_concluintes_nivel');
                } else if ($tipo == 3) {
                    $this->write_html('Alunos concluintes por n??vel', $result, $title_status, 'relatorio/2pnera/alunos_concluintes_nivel');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function alunos_concluintes_superintendencia($tipo)
    {

        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->alunos_concluintes_superintendencia($this->session->userdata('access_level'), $vigencia, $status);
        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Alunos concluintes por superintend??ncia", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("C??DIGO", "SUPERINTEND??NCIA", "ALUNOS CONCLUINTES"));

                    $this->barchart->set_topLeftCell('K1');
                    $this->barchart->set_bottomRightCell('R35');

                    $this->barchart->set_legend_col('B');
                    $this->barchart->set_num_legend_columns(2);

                    $this->barchart->set_number_format('_(* #,##0_);_(* (#,##0);_(* "-"??_);_(@_)');

                    $this->barchart->set_chart_colors(array('8B5742'));                        // array - colors
                    $this->barchart->set_title("ALUNOS CONCLUINTES POR SUPERINTEND??NCIA");    // string
                    $this->write_xls($xls, 'ALUNOS-CONCLUINTES-SUPERINTENDENCIA.xls');
                } else if ($tipo == 2) {
                    $this->write_pdf('Alunos concluintes por superintend??ncia', $result, $title_status, 'relatorio/2pnera/alunos_concluintes_superintendencia');
                } else if ($tipo == 3) {
                    $this->write_html('Alunos concluintes por superintend??ncia', $result, $title_status, 'relatorio/2pnera/alunos_concluintes_superintendencia');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function alunos_concluintes_nivel_sr($tipo)
    {

        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->alunos_concluintes_nivel_sr($vigencia, $status);
        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Alunos concluintes por n??vel e superintend??ncia", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("C??DIGO", "SUPERINTEND??NCIA", "EJA FUNDAMENTAL", "ENSINO M??DIO", "ENSINO SUPERIOR", "TOTAL"));

                    $this->barchart->set_include_charts(false);

                    $this->write_xls($xls, 'CONCLUINTES-NIVEL-SUPERINTENDENCIA.xls');
                } else if ($tipo == 2) {
                    $this->write_pdf('Alunos concluintes por n??vel e superintend??ncia', $result, $title_status, 'relatorio/2pnera/alunos_concluintes_nivel_sr');
                } else if ($tipo == 3) {
                    $this->write_html('Alunos concluintes por n??vel e superintend??ncia', $result, $title_status, 'relatorio/2pnera/alunos_concluintes_nivel_sr');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function alunos_cadastrados_curso($tipo)
    {
        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->alunos_cadastrados_curso($this->session->userdata('access_level'), $vigencia, $status);
        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Rela????o de Total de alunos cadastrados, ingressantes e concluintes por curso", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("COD", "NOME", "CADASTRADO", "INGRESSANTE", "CONCLU??NTES"));

                    $this->barchart->set_include_charts(false);

                    $this->write_xls($xls, 'ALUNOS-CADASTRADOS-INGRESSANTES-CONCLUINTES-CURSO.xls');
                } else if ($tipo == 2) {
                    $this->write_pdf('Rela????o de Total de alunos cadastrados, ingressantes e concluintes por curso', $result, $title_status, 'relatorio/2pnera/alunos_cadastrados_curso');
                } else if ($tipo == 3) {
                    $this->write_html('Rela????o de Total de alunos cadastrados, ingressantes e concluintes por curso', $result, $title_status, 'relatorio/2pnera/alunos_cadastrados_curso');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function lista_cursos_cadastrados($tipo)
    {
        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->lista_cursos_cadastrados($this->session->userdata('access_level'), $vigencia, $status);
        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Lista de Cursos cadastrados", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("C??digo", "Nome", "Modalidade", "Superintendencia", "N?? do Processo", "N?? do Instrumento", "Tipo de Instrumento", "Inicio Realizado", "T??rmino Realizado"));

                    $this->barchart->set_include_charts(false);

                    $this->write_xls($xls, 'CURSO_CADASTRADOS.xls');
                } else if ($tipo == 2) {
                    $this->write_pdf('Lista de Cursos cadastrados', $result, $title_status, 'relatorio/2pnera/lista_cursos_cadastrados');
                } else if ($tipo == 3) {
                    $this->write_html('Lista de Cursos cadastrados', $result, $title_status, 'relatorio/2pnera/lista_cursos_cadastrados');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function lista_cursos_modalidade($tipo)
    { //nominal
        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->lista_cursos_modalidade($this->session->userdata('access_level'), $vigencia, $status);

        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Lista de cursos por modalidade", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("MODALIDADE", "C??DIGO", "CURSO"));

                    $this->barchart->set_include_charts(false); // hide charts

                    $this->write_xls($xls, 'LISTA-CURSOS-MODALIDADE.xls');
                } else if ($tipo == 2) {
                    $this->write_pdf('Lista de cursos por modalidade', $result, $title_status, 'relatorio/2pnera/lista_cursos_modalidade');
                } else if ($tipo == 3) {
                    $this->write_html('Lista de cursos por modalidade', $result, $title_status, 'relatorio/2pnera/lista_cursos_modalidade');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function lista_cursos_modalidade_sr($tipo)
    {
        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->lista_cursos_modalidade_sr($this->session->userdata('access_level'), $vigencia, $status);
        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Lista de cursos por modalidade e superintend??ncia", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("C??DIGO", "SUPERINTEND??NCIA", "MODALIDADE", "C??DIGO", "CURSO"));

                    $this->barchart->set_include_charts(false); // hide charts

                    $this->write_xls($xls, 'LISTA-CURSOS-MODALIDADE-SR.xls');
                } else if ($tipo == 2) {
                    $this->write_pdf('Lista de cursos por modalidade e superintend??ncia', $result, $title_status, 'relatorio/2pnera/lista_cursos_modalidade_sr');
                } else if ($tipo == 3) {
                    $this->write_html('Lista de cursos por modalidade e superintend??ncia', $result, $title_status, 'relatorio/2pnera/lista_cursos_modalidade_sr');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function alunos_curso($tipo, $idsr)
    {
        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->alunos_curso($idsr, $vigencia, $status);

        if (is_array($result)) {
            if (count($result) != 0) {
                $nomesr = $this->requisicao_m->get_superintendencias_nome(1, $idsr);
                if ($tipo == 1) {
                    $xls = $this->create_header("Lista de alunos por curso da superintend??ncia - " . $nomesr, $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("C??DIGO", "CURSO", "EDUCANDO"));

                    $this->barchart->set_include_charts(false); // hide charts

                    $this->write_xls($xls, "LISTA-CURSOS-ALUNO-SR-$idsr.xls");
                } else if ($tipo == 2) {
                    $this->write_pdf("Lista de alunos por curso da superintend??ncia - " . $nomesr, $result, $title_status, 'relatorio/2pnera/alunos_curso');
                } else if ($tipo == 3) {
                    $this->write_html("Lista de alunos por curso da superintend??ncia - " . $nomesr, $result, $title_status, 'relatorio/2pnera/alunos_curso');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function titulacao_educadores($tipo)
    {
        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->titulacao_educadores($this->session->userdata('access_level'), $vigencia, $status);
        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Total de educadores por Escolaridade/titula????o", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("TITULA????O", "% EDUCADORES"));

                    $this->barchart->set_topLeftCell('K1');
                    $this->barchart->set_bottomRightCell('R28');

                    $this->barchart->set_number_format('0.0');                           // decimal format

                    $this->barchart->set_chart_colors(array('6B8E23'));                  // array - colors
                    $this->barchart->set_title("ESCOLARIDADE/TITULA????O DOS EDUCADORES"); // string

                    $this->write_xls($xls, "TITULACAO-EDUCADORES.xls");
                } else if ($tipo == 2) {
                    $this->write_pdf("Total de educadores por Escolaridade/titula????o", $result, $title_status, 'relatorio/2pnera/titulacao_educadores');
                } else if ($tipo == 3) {
                    $this->write_html("Total de educadores por Escolaridade/titula????o", $result, $title_status, 'relatorio/2pnera/titulacao_educadores');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function titulacao_educadores_superintendencia($tipo)
    {
        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->titulacao_educadores_superintendencia($vigencia, $status);

        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Total de educadores por Escolaridade/titula????o e superintend??ncia", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array(
                        "C??DIGO", "SUPERINTEND??NCIA", "% ENSINO FUNDAMENTAL COMPLETO", "% ENSINO FUNDAMENTAL INCOMPLETO",
                        "% ENSINO M??DIO COMPLETO", "% ENSINO M??DIO INCOMPLETO", "% GRADUADO(A)", "% ESPECIALISTA", "% MESTRE(A)", "% DOUTOR(A)", "% N/A"
                    ));

                    $this->barchart->set_include_charts(false); // hide charts

                    $this->barchart->set_number_format('0.0');                           // decimal format

                    $this->write_xls($xls, "TITULACAO-EDUCADORES-SUPERINTENDENCIA.xls");
                } else if ($tipo == 2) {
                    $this->write_pdf("Total de educadores por Escolaridade/titula????o e superintend??ncia", $result, $title_status, 'relatorio/2pnera/titulacao_educadores_superintendencia');
                } else if ($tipo == 3) {
                    $this->write_html("Total de educadores por Escolaridade/titula????o e superintend??ncia", $result, $title_status, 'relatorio/2pnera/titulacao_educadores_superintendencia');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function educadores_nivel($tipo)
    {
        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->educadores_nivel($this->session->userdata('access_level'), $vigencia, $status);
        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Total de Educadores por n??vel", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("N??VEL", "EDUCADORES"));

                    $this->barchart->set_topLeftCell('K1');
                    $this->barchart->set_bottomRightCell('Q10');

                    $this->barchart->set_number_format('_(* #,##0_);_(* (#,##0);_(* "-"??_);_(@_)');

                    $this->barchart->set_chart_colors(array('8B5742'));
                    $this->barchart->set_title("EDUCADORES POR N??VEL");

                    $this->write_xls($xls, "EDUCADORES-NIVEL.xls");
                } else if ($tipo == 2) {
                    $this->write_pdf('Total de Educadores por n??vel', $result, $title_status, 'relatorio/2pnera/educadores_nivel');
                } else if ($tipo == 3) {
                    $this->write_html('Total de Educadores por n??vel', $result, $title_status, 'relatorio/2pnera/educadores_nivel');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function educadores_curso($tipo)
    {
        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->educadores_curso($this->session->userdata('access_level'), $vigencia, $status);

        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Total de Educadores por curso", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("C??DIGO", "CURSO", "EDUCADORES"));

                    $this->barchart->set_include_charts(false);

                    $this->write_xls($xls, "EDUCADORES-CURSO.xls");
                } else if ($tipo == 2) {
                    $this->write_pdf("Total de Educadores por curso", $result, $title_status, 'relatorio/2pnera/educadores_curso');
                } else if ($tipo == 3) {
                    $this->write_html("Total de Educadores por curso", $result, $title_status, 'relatorio/2pnera/educadores_curso');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function educadores_superintendencia($tipo)
    {
        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->educadores_superintendencia($vigencia, $status);

        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Total de Educadores por superintend??ncia", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("C??DIGO", "SUPERINTEND??NCIA", "EDUCADORES"));

                    $this->barchart->set_topLeftCell('K1');
                    $this->barchart->set_bottomRightCell('Q50');

                    $this->barchart->set_legend_col('B');
                    $this->barchart->set_num_legend_columns(2);

                    $this->barchart->set_number_format('_(* #,##0_);_(* (#,##0);_(* "-"??_);_(@_)');

                    $this->barchart->set_chart_colors(array('006400'));                   // array - colors
                    $this->barchart->set_title("EDUCADORES POR SUPERINTEND??NCIA");        // string

                    $this->write_xls($xls, "EDUCADORES-SUPERINTENDENCIA.xls");
                } else if ($tipo == 2) {
                    $this->write_pdf("Total de Educadores por superintend??ncia", $result, $title_status, 'relatorio/2pnera/educadores_superintendencia');
                } else if ($tipo == 3) {
                    $this->write_html("Total de Educadores por superintend??ncia", $result, $title_status, 'relatorio/2pnera/educadores_superintendencia');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function genero_educadores_modalidade($tipo)
    {
        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->genero_educadores_modalidade($this->session->userdata('access_level'), $vigencia, $status);
        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Participa????o de homens e mulheres como educadores dos cursos por modalidade", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("MODALIDADE", "% MASCULINO", "% FEMININO"));

                    $this->barchart->set_topLeftCell('K1');
                    $this->barchart->set_bottomRightCell('Q28');

                    $this->barchart->set_chartType('stacked');                                 // stacked
                    $this->barchart->set_number_format('0.0');                           // decimal format

                    $this->barchart->set_chart_colors(array('87CEEB', 'EE5C42'));         // array - colors
                    $this->barchart->set_title("EDUCADORES POR G??NERO E MODALIDADE");    // string

                    $this->write_xls($xls, "EDUCADORES-GENERO-MODALIDADE.xls");
                } else if ($tipo == 2) {
                    $this->write_pdf('Participa????o de homens e mulheres como educadores dos cursos por modalidade', $result, $title_status, 'relatorio/2pnera/genero_educadores_modalidade');
                } else if ($tipo == 3) {
                    $this->write_html('Participa????o de homens e mulheres como educadores dos cursos por modalidade', $result, $title_status, 'relatorio/2pnera/genero_educadores_modalidade');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function educandos_superintendencia($tipo)
    {
        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->educandos_superintendencia($vigencia, $status);
        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Total de Educandos por superintend??ncia", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("C??DIGO", "SUPERINTEND??NCIA", "EDUCANDOS"));

                    $this->barchart->set_topLeftCell('K1');
                    $this->barchart->set_bottomRightCell('Q50');

                    $this->barchart->set_legend_col('B');
                    $this->barchart->set_num_legend_columns(2);

                    $this->barchart->set_number_format('_(* #,##0_);_(* (#,##0);_(* "-"??_);_(@_)');

                    $this->barchart->set_chart_colors(array('006400'));                   // array - colors
                    $this->barchart->set_title("EDUCANDOS POR SUPERINTEND??NCIA");        // string

                    $this->write_xls($xls, "EDUCANDOS-SUPERINTENDENCIA.xls");
                } else if ($tipo == 2) {
                    $this->write_pdf('Total de Educandos por superintend??ncia', $result, $title_status, 'relatorio/2pnera/educandos_superintendencia');
                } else if ($tipo == 3) {
                    $this->write_html('Total de Educandos por superintend??ncia', $result, $title_status, 'relatorio/2pnera/educandos_superintendencia');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function municipio_origem_educandos($tipo)
    {
        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->municipio_origem_educandos($this->session->userdata('access_level'), $vigencia, $status);
        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Total de Educandos por Munic??pio de origem", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("ESTADO", "MUNIC??PIO", "C??D MUNIC??PIO", "EDUCANDOS"));

                    $this->barchart->set_include_charts(false); // hide charts

                    $this->write_xls($xls, "MUNICIPIO-ORIGEM-EDUCANDOS.xls");
                } else if ($tipo == 2) {
                    $this->write_pdf('Total de Educandos por Munic??pio de origem', $result, $title_status, 'relatorio/2pnera/municipio_origem_educandos');
                } else if ($tipo == 3) {
                    $this->write_html('Total de Educandos por Munic??pio de origem', $result, $title_status, 'relatorio/2pnera/municipio_origem_educandos');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function territorio_educandos_modalidade($tipo)
    {
        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->territorio_educandos_modalidade($this->session->userdata('access_level'), $vigencia, $status);
        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Total de Educandos por Territ??rio de origem e modalidade do curso", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array(
                        "MODALIDADE", "ACAMPAMENTO", "ASSENTAMENTO", "COMUNIDADE", "COMUNIDADE RIBEIRINHA",
                        "FLONA", "FLORESTA NACIONAL", "QUILOMBOLA", "RDS", "RESEX", "OUTRO", "N??O PREENCHIDO", "N??O INFORMADO"
                    ));

                    $this->barchart->set_include_charts(false);

                    $this->write_xls($xls, "TERRITORIO-EDUCANDOS-MODALIDADE.xls");
                } else if ($tipo == 2) {
                    $this->write_pdf('Total de Educandos por Territ??rio de origem e modalidade do curso', $result, $title_status, 'relatorio/2pnera/territorio_educandos_modalidade');
                } else if ($tipo == 3) {
                    $this->write_html('Total de Educandos por Territ??rio de origem e modalidade do curso', $result, $title_status, 'relatorio/2pnera/territorio_educandos_modalidade');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function territorio_educandos_superintendencia($tipo)
    {
        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->territorio_educandos_superintendencia($vigencia, $status);
        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Total de Educandos por Territ??rio de origem e superintend??ncia do curso", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array(
                        "C??DIGO", "SUPERINTEND??NCIA", "ACAMPAMENTO", "ASSENTAMENTO", "COMUNIDADE", "COMUNIDADE RIBEIRINHA",
                        "FLONA", "FLORESTA NACIONAL", "QUILOMBOLA", "RDS", "RESEX", "OUTRO", "N??O PREENCHIDO", "N??O INFORMADO"
                    ));

                    $this->barchart->set_include_charts(false); // hide charts

                    $this->write_xls($xls, "TERRITORIO-EDUCANDOS-SUPERINTENDENCIA.xls");
                } else if ($tipo == 2) {
                    $this->write_pdf('Territ??rio de origem dos educandos por superintend??ncia', $result, $title_status, 'relatorio/2pnera/territorio_educandos_superintendencia');
                } else if ($tipo == 3) {
                    $this->write_html('Territ??rio de origem dos educandos por superintend??ncia', $result, $title_status, 'relatorio/2pnera/territorio_educandos_superintendencia');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function idade_educandos_modalidade($tipo)
    {
        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->idade_educandos_modalidade($this->session->userdata('access_level'), $vigencia, $status);
        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Idade m??dia dos educandos por modalidade", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("MODALIDADE", "M??DIA DE IDADE (ANOS)"));

                    $this->barchart->set_topLeftCell('K1');
                    $this->barchart->set_bottomRightCell('Q28');

                    $this->barchart->set_number_format('0.0');                                    // number format

                    $this->barchart->set_chart_colors(array('CDC9C9'));                     // array - colors

                    $this->barchart->set_title("IDADE M??DIA DOS EDUCANDOS POR MODALIDADE"); // string

                    $this->write_xls($xls, "IDADE-EDUCANDOS-MODALIDADE.xls");
                } else if ($tipo == 2) {
                    $this->write_pdf('Idade m??dia dos educandos por modalidade', $result, $title_status, 'relatorio/2pnera/idade_educandos_modalidade');
                } else if ($tipo == 3) {
                    $this->write_html('Idade m??dia dos educandos por modalidade', $result, $title_status, 'relatorio/2pnera/idade_educandos_modalidade');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function genero_educandos_modalidade($tipo)
    {
        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->genero_educandos_modalidade($this->session->userdata('access_level'), $vigencia, $status);
        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Participa????o de homens e mulheres como educandos nos cursos por modalidade", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("MODALIDADE", "% MASCULINO", "% FEMININO"));

                    $this->barchart->set_topLeftCell('K1');
                    $this->barchart->set_bottomRightCell('Q28');

                    $this->barchart->set_chartType('stacked');                                 // stacked
                    $this->barchart->set_number_format('0.0');                           // decimal format

                    $this->barchart->set_chart_colors(array('87CEEB', 'EE5C42'));         // array - colors
                    $this->barchart->set_title("EDUCANDOS POR G??NERO E MODALIDADE");     // string

                    $this->write_xls($xls, "EDUCANDOS-GENERO-MODALIDADE.xls");
                } else if ($tipo == 2) {
                    $this->write_pdf('Participa????o de homens e mulheres como educandos nos cursos por modalidade', $result, $title_status, 'relatorio/2pnera/genero_educandos_modalidade');
                } else if ($tipo == 3) {
                    $this->write_html('Participa????o de homens e mulheres como educandos nos cursos por modalidade', $result, $title_status, 'relatorio/2pnera/genero_educandos_modalidade');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function educandos_assentamento_modalidade($tipo)
    {

        // GAMBIARRRA para aumentar a ??rea de mem??ria 
        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        ini_set('memory_limit', '2048M');
        $result = $this->relatorio_geral_m_pnera2->educandos_assentamento_modalidade($this->session->userdata('access_level'), $vigencia, $status);
        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Total de Educandos por assentamento e modalidade de curso", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array(
                        "NOME TERRIT??RIO / ASSENTAMENTO", "EJA ALFABETIZACAO", "EJA ANOS INICIAIS", "EJA ANOS FINAIS",
                        "EJA NIVEL MEDIO (MAGISTERIO/FORMAL)", "EJA NIVEL MEDIO (NORMAL)", "NIVEL MEDIO/TECNICO (CONCOMITANTE)",
                        "NIVEL MEDIO/TECNICO (INTEGRADO)", "NIVEL MEDIO PROFISSIONAL (POS-MEDIO)", "GRADUACAO", "ESPECIALIZACAO",
                        "RESIDENCIA AGRARIA", "MESTRADO", "DOUTORADO"
                    ));

                    $this->barchart->set_include_charts(false); // hide charts

                    $this->write_xls($xls, "EDUCANDOS-ASSENTAMENTO-MODALIDADE.xls");
                } else if ($tipo == 2) {
                    $this->write_pdf('Total de Educandos por assentamento e modalidade de curso', $result, $title_status, 'relatorio/2pnera/educandos_assentamento_modalidade');
                } else if ($tipo == 3) {
                    $this->write_html('Total de Educandos por assentamento e modalidade de curso', $result, $title_status, 'relatorio/2pnera/educandos_assentamento_modalidade');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function educandos_assentamento_nivel($tipo)
    {

        // GAMBIARRRA para aumentar a ??rea de mem??ria 
        ini_set('memory_limit', '2048M');
        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->educandos_assentamento_nivel($this->session->userdata('access_level'), $vigencia, $status);

        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Total de Educandos por assentamento e n??vel de curso", 1, $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("NOME TERRIT??RIO / ASSENTAMENTO", "EJA FUNDAMENTAL", "ENSINO M??DIO", "ENSINO SUPERIOR"));

                    $this->barchart->set_include_charts(false); // hide charts

                    $this->write_xls($xls, "EDUCANDOS-ASSENTAMENTO-NIVEL.xls");
                } else if ($tipo == 2) {
                    $this->write_pdf('Total de Educandos por assentamento e n??vel de curso', $result, $title_status, 'relatorio/2pnera/educandos_assentamento_nivel');
                } else if ($tipo == 3) {
                    $this->write_html('Total de Educandos por assentamento e n??vel de curso', $result, $title_status, 'relatorio/2pnera/educandos_assentamento_nivel');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function lista_educandos_cursos_sr($tipo, $sr)
    {

        ini_set('memory_limit', '1024M');
        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->lista_educandos_cursos_sr($sr, $vigencia, $status);
        if (is_array($result)) {
            if (count($result) != 0) {
                $nomesr = $this->requisicao_m->get_superintendencias_nome(1, $sr);
                if ($tipo == 1) {
                    $xls = $this->create_header("Educandos, superintend??ncia e curso - $nomesr", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("NOME EDUCANDO", "TIPO TERRIT??RIO", "NOME TERRIT??RIO", "C??D. CURSO", "NOME CURSO", "MODALIDADE CURSO"));

                    $this->barchart->set_include_charts(false); // hide charts

                    $this->write_xls($xls, "LISTA-EDUCANDOS-CURSOS-SR-$sr.xls");
                } else if ($tipo == 2) {
                    $this->write_pdf("Educandos por superintend??ncia e curso - $nomesr", $result, $title_status, 'relatorio/2pnera/lista_educandos_cursos_sr');
                } else if ($tipo == 3) {
                    $this->write_html("Educandos por superintend??ncia e curso - $nomesr", $result, $title_status, 'relatorio/2pnera/lista_educandos_cursos_sr');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function localizacao_instituicoes_ensino($tipo)
    {

        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->localizacao_instituicoes_ensino($this->session->userdata('access_level'), $vigencia, $status);
        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Localiza????o das institui????es de ensino", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("ESTADO", "MUNIC??PIO", "C??D MUNIC??PIO", "INSTITUI????O DE ENSINO"));

                    $this->barchart->set_include_charts(false); // hide charts

                    $this->write_xls($xls, "LOCALIZACAO-INSTITUICOES-ENSINO.xls");
                } else if ($tipo == 2) {
                    $this->write_pdf("Localiza????o das institui????es de ensino", $result, $title_status, 'relatorio/2pnera/localizacao_instituicoes_ensino');
                } else if ($tipo == 3) {
                    $this->write_html("Localiza????o das institui????es de ensino", $result, $title_status, 'relatorio/2pnera/localizacao_instituicoes_ensino');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function instituicoes_ensino_modalidade($tipo)
    {

        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->instituicoes_ensino_modalidade($this->session->userdata('access_level'), $vigencia, $status);

        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Total de Institui????es de ensino que realizaram cursos por modalidade", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("MODALIDADE", "INSTITUI????ES DE ENSINO"));

                    $this->barchart->set_topLeftCell('K1');
                    $this->barchart->set_bottomRightCell('Q28');

                    $this->barchart->set_chart_colors(array('4F94CD'));                     // array - colors
                    $this->barchart->set_title("INSTITUI????ES DE ENSINO POR MODALIDADE");    // string

                    $this->write_xls($xls, "INSTITUICOES-ENSINO-MODALIDADE.xls");
                } else if ($tipo == 2) {
                    $this->write_pdf('Total de Institui????es de ensino que realizaram cursos por modalidade', $result, $title_status, 'relatorio/2pnera/instituicoes_ensino_modalidade');
                } else if ($tipo == 3) {
                    $this->write_html('Total de Institui????es de ensino que realizaram cursos por modalidade', $result, $title_status, 'relatorio/2pnera/instituicoes_ensino_modalidade');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function instituicoes_ensino_nivel($tipo)
    {

        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->instituicoes_ensino_nivel($this->session->userdata('access_level'), $vigencia, $status);

        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Total de Institui????es de ensino que realizaram cursos por n??vel", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("N??VEL", "INSTITUI????ES DE ENSINO"));

                    $this->barchart->set_topLeftCell('K1');
                    $this->barchart->set_bottomRightCell('Q28');

                    $this->barchart->set_chart_colors(array('4F94CD'));                     // array - colors
                    $this->barchart->set_title("INSTITUI????ES DE ENSINO POR N??VEL");    // string

                    $this->write_xls($xls, "INSTITUICOES-ENSINO-NIVEL.xls");
                } else if ($tipo == 2) {
                    $this->write_pdf('Total de Institui????es de ensino que realizaram cursos por n??vel', $result, $title_status, 'relatorio/2pnera/instituicoes_ensino_nivel');
                } else if ($tipo == 3) {
                    $this->write_html('Total de Institui????es de ensino que realizaram cursos por n??vel', $result, $title_status, 'relatorio/2pnera/instituicoes_ensino_nivel');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function instituicoes_ensino_superintendencia($tipo)
    {

        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->instituicoes_ensino_superintendencia($vigencia, $status);

        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Total de Institui????es de ensino que realizaram cursos por superintend??ncia", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("C??DIGO", "SUPERINTEND??NCIA", "INSTITUI????ES DE ENSINO"));

                    $this->barchart->set_topLeftCell('K1');
                    $this->barchart->set_bottomRightCell('Q35');

                    $this->barchart->set_chart_colors(array('CDC9C9'));                           // array - colors
                    $this->barchart->set_title("INSTITUI????ES DE ENSINO POR SUPERINTEND??NCIA");    // string

                    $this->write_xls($xls, "INSTITUI????ES-ENSINO-SUPERINTENDENCIA.xls");
                } else if ($tipo == 2) {
                    $this->write_pdf('Total de Institui????es de ensino que realizaram cursos por superintend??ncia', $result, $title_status, 'relatorio/2pnera/instituicoes_ensino_superintendencia');
                } else if ($tipo == 3) {
                    $this->write_html('Total de Institui????es de ensino que realizaram cursos por superintend??ncia', $result, $title_status, 'relatorio/2pnera/instituicoes_ensino_superintendencia');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function instituicoes_ensino_municipio($tipo)
    {

        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->instituicoes_ensino_municipio($this->session->userdata('access_level'), $vigencia, $status);

        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Total de Institui????es de ensino que realizaram cursos por munic??pios", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("ESTADO", "C??D. MUNIC??PIO", "MUNIC??PIO", "INSTITUI????ES DE ENSINO"));

                    $this->barchart->set_include_charts(false); // hide charts

                    $this->write_xls($xls, "INSTITUI????ES-ENSINO-MUNICIPIO.xls");
                } else if ($tipo == 2) {
                    $this->write_pdf('Total de Institui????es de ensino que realizaram cursos por munic??pios', $result, $title_status, 'relatorio/2pnera/instituicoes_ensino_municipio');
                } else if ($tipo == 3) {
                    $this->write_html('Total de Institui????es de ensino que realizaram cursos por munic??pios', $result, $title_status, 'relatorio/2pnera/instituicoes_ensino_municipio');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function instituicoes_ensino_estado($tipo)
    {

        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->instituicoes_ensino_estado($vigencia, $status);
        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Total de Institui????es de ensino que realizaram cursos por estados", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("ESTADO", "INSTITUI????ES DE ENSINO"));

                    $this->barchart->set_topLeftCell('K1');
                    $this->barchart->set_bottomRightCell('Q30');

                    $this->barchart->set_chart_colors(array('CDC9C9'));                           // array - colors
                    $this->barchart->set_title("INSTITUI????ES DE ENSINO POR ESTADO");    // string

                    $this->write_xls($xls, "INSTITUI????ES-ENSINO-ESTADO.xls");
                } else if ($tipo == 2) {
                    $this->write_pdf('Total de Institui????es de ensino que realizaram cursos por Estado', $result, $title_status, 'relatorio/2pnera/instituicoes_ensino_estado');
                } else if ($tipo == 3) {
                    $this->write_html('Total de Institui????es de ensino que realizaram cursos por Estado', $result, $title_status, 'relatorio/2pnera/instituicoes_ensino_estado');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function cursos_natureza_inst_ensino($tipo)
    {

        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->cursos_natureza_inst_ensino($this->session->userdata('access_level'), $vigencia, $status);

        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Total de Cursos por Natureza da institui????o de ensino", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("NATUREZA", "CURSOS"));

                    $this->barchart->set_topLeftCell('K1');
                    $this->barchart->set_bottomRightCell('Q10');

                    $this->barchart->set_chart_colors(array('00CDCD'));                                        // array - colors
                    $this->barchart->set_title("NATUREZA DAS INSTITUI????ES DE ENSINO\nE CURSOS REALIZADOS");    // string

                    $this->write_xls($xls, 'INSTITUI????ES-ENSINO-CURSOS-NATUREZA.xls');
                } else if ($tipo == 2) {
                    $this->write_pdf('Natureza das institui????es de ensino e n??mero de cursos realizados', $result, $title_status, 'relatorio/2pnera/cursos_natureza_inst_ensino');
                } else if ($tipo == 3) {
                    $this->write_html('Natureza das institui????es de ensino e n??mero de cursos realizados', $result, $title_status, 'relatorio/2pnera/cursos_natureza_inst_ensino');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function instituicao_ensino_cursos($tipo)
    {

        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->instituicao_ensino_cursos($this->session->userdata('access_level'), $vigencia, $status);
        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Total de Cursos realizados por Institui????o de ensino", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("INSTITUI????O DE ENSINO", "CURSOS"));

                    $this->barchart->set_include_charts(false);

                    $this->write_xls($xls, 'INSTITUI????ES-ENSINO-CURSOS.xls');
                } else if ($tipo == 2) {
                    $this->write_pdf('Total de Cursos realizados por Institui????o de ensino', $result, $title_status, 'relatorio/2pnera/instituicao_ensino_cursos');
                } else if ($tipo == 3) {
                    $this->write_html('Total de Cursos realizados por Institui????o de ensino', $result, $title_status, 'relatorio/2pnera/instituicao_ensino_cursos');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function organizacoes_demandantes_modalidade($tipo)
    {
        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->organizacoes_demandantes_modalidade($this->session->userdata('access_level'), $vigencia, $status);
        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Total de Organiza????es demandantes por modalidade", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("MODALIDADE", "ORGANIZA????ES DEMANDANTES"));

                    $this->barchart->set_topLeftCell('K1');
                    $this->barchart->set_bottomRightCell('Q28');

                    $this->barchart->set_chart_colors(array('CD950C'));                       // array - colors
                    $this->barchart->set_title("ORGANIZA????ES DEMANDANTES POR MODALIDADE");    // string

                    $this->write_xls($xls, 'ORGANIZA????ES-DEMANDANTES-MODALIDADE.xls');
                } else if ($tipo == 2) {
                    $this->write_pdf('Total de Organiza????es demandantes por modalidade', $result, $title_status, 'relatorio/2pnera/organizacoes_demandantes_modalidade');
                } else if ($tipo == 3) {
                    $this->write_html('Total de Organiza????es demandantes por modalidade', $result, $title_status, 'relatorio/2pnera/organizacoes_demandantes_modalidade');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function membros_org_demandantes_modalidade($tipo)
    {
        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->membros_org_demandantes_modalidade($this->session->userdata('access_level'), $vigencia, $status);
        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Porcentagem dos membros das organiza????es demandantes participantes de cursos do PRONERA por modalidade", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("MODALIDADE", "% ESTUDARAM NO PRONERA", "% N??O ESTUDARAM NO PRONERA", "% N??O INFORMADO"));

                    $this->barchart->set_topLeftCell('K1');
                    $this->barchart->set_bottomRightCell('S28');

                    $this->barchart->set_chartType('stacked');                                 // stacked
                    $this->barchart->set_number_format('0.0');                           // decimal format

                    $this->barchart->set_chart_colors(array('87CEEB', 'EE5C42'));         // array - colors
                    $this->barchart->set_title(
                        "
                    MEMBROS DAS ORGANIZA????ES DEMANDANTES (%)\n
                    PARTICIPANTES DOS CURSOS DO PRONERA\n
                    POR MODALIDADE"
                    );

                    $this->write_xls($xls, 'MEMBROS-ORG-DEMANDANTES-MODALIDADE.xls');
                } else if ($tipo == 2) {
                    $this->write_pdf('Porcentagem dos membros das organiza????es demandantes participantes de cursos do PRONERA por modalidade', $result, $title_status, 'relatorio/2pnera/membros_org_demandantes_modalidade');
                } else if ($tipo == 3) {
                    $this->write_html('Porcentagem dos membros das organiza????es demandantes participantes de cursos do PRONERA por modalidade', $result, $title_status, 'relatorio/2pnera/membros_org_demandantes_modalidade');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function organizacao_demandante_cursos($tipo)
    {
        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->organizacao_demandante_cursos($this->session->userdata('access_level'), $vigencia, $status);
        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Lista das organiza????es demandantes e n??mero de cursos demandados", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("ORGANIZA????O DEMANDANTE", "CURSOS"));

                    $this->barchart->set_include_charts(false); // hide charts

                    $this->write_xls($xls, 'ORGANIZACAO-DEMANDANTE-CURSOS.xls');
                } else if ($tipo == 2) {
                    $this->write_pdf('Lista das organiza????es demandantes e n??mero de cursos demandados', $result, $title_status, 'relatorio/2pnera/organizacao_demandante_cursos');
                } else if ($tipo == 3) {
                    $this->write_html('Lista das organiza????es demandantes e n??mero de cursos demandados', $result, $title_status, 'relatorio/2pnera/organizacao_demandante_cursos');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function localizacao_parceiros($tipo)
    {
        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->localizacao_parceiros($this->session->userdata('access_level'), $vigencia, $status);

        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Localiza????o dos parceiros", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("ESTADO", "C??D. MUNIC??PIO", "MUNIC??PIO", "PARCEIRO"));

                    $this->barchart->set_include_charts(false);

                    $this->write_xls($xls, 'LOCALIZACAO-PARCEIROS.xls');
                } else if ($tipo == 2) {
                    $this->write_pdf('Localiza????o dos parceiros', $result, $title_status, 'relatorio/2pnera/localizacao_parceiros');
                } else if ($tipo == 3) {
                    $this->write_html('Localiza????o dos parceiros', $result, $title_status, 'relatorio/2pnera/localizacao_parceiros');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function parceiros_modalidade($tipo)
    {
        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->parceiros_modalidade($this->session->userdata('access_level'), $vigencia, $status);
        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Total de Parceiros por modalidade", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("MODALIDADE", "PARCEIROS"));

                    $this->barchart->set_topLeftCell('K1');
                    $this->barchart->set_bottomRightCell('R28');

                    $this->barchart->set_chart_colors(array('8B4513'));        // array - colors
                    $this->barchart->set_title("PARCEIROS POR MODALIDADE");    // string

                    $this->write_xls($xls, 'PARCEIROS-MODALIDADE.xls');
                } else if ($tipo == 2) {
                    $this->write_pdf('Total de Parceiros por modalidade', $result, $title_status, 'relatorio/2pnera/parceiros_modalidade');
                } else if ($tipo == 3) {
                    $this->write_html('Total de Parceiros por modalidade', $result, $title_status, 'relatorio/2pnera/parceiros_modalidade');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function parceiros_superintendencia($tipo)
    {
        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->parceiros_superintendencia($vigencia, $status);
        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Total de Parceiros por superintend??ncia", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("C??DIGO", "SUPERINTEND??NCIA", "PARCEIROS"));

                    $this->barchart->set_topLeftCell('K1');
                    $this->barchart->set_bottomRightCell('Q35');

                    $this->barchart->set_chart_colors(array('8B4513'));               // array - colors
                    $this->barchart->set_title("PARCEIROS POR SUPERINTEND??NCIA");     // string

                    $this->write_xls($xls, 'PARCEIROS-SUPERINTENDENCIA.xls');
                } else if ($tipo == 2) {
                    $this->write_pdf('Total de Parceiros por superintend??ncia', $result, $title_status, 'relatorio/2pnera/parceiros_superintendencia');
                } else if ($tipo == 3) {
                    $this->write_html('Total de Parceiros por superintend??ncia', $result, $title_status, 'relatorio/2pnera/parceiros_superintendencia');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function parceiros_natureza($tipo)
    {
        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->parceiros_natureza($this->session->userdata('access_level'), $vigencia, $status);
        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Total de Parceiros por natureza da parceria", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("NATUREZA", "PARCEIROS"));

                    $this->barchart->set_include_charts(false);

                    $this->write_xls($xls, 'PARCEIROS-NATUREZA.xls');
                } else if ($tipo == 2) {
                    $this->write_pdf('Total de Parceiros por natureza da parceria', $result, $title_status, 'relatorio/2pnera/parceiros_natureza');
                } else if ($tipo == 3) {
                    $this->write_html('Total de Parceiros por natureza da parceria', $result, $title_status, 'relatorio/2pnera/parceiros_natureza');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function lista_parceiros($tipo)
    {
        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->lista_parceiros($this->session->userdata('access_level'), $vigencia, $status);

        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Lista dos parceiros", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("PARCEIRO", "SIGLA", 'ABRANG??NCIA'));

                    $this->barchart->set_topLeftCell('K1');
                    $this->barchart->set_bottomRightCell('V28');

                    $this->barchart->set_chart_colors(array('CD661D'));        // array - colors
                    $this->barchart->set_include_charts(false); // hide charts

                    $this->write_xls($xls, 'LISTA-PARCEIROS.xls');
                } else if ($tipo == 2) {
                    $this->write_pdf('Lista dos parceiros', $result, $title_status, 'relatorio/2pnera/lista_parceiros');
                } else if ($tipo == 3) {
                    $this->write_html('Lista dos parceiros', $result, $title_status, 'relatorio/2pnera/lista_parceiros');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function producoes_estado($tipo)
    {
        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->producoes_estado($vigencia, $status);

        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Total de Produ????es por tipo e Estado", $vigencia, $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("ESTADO", "PRODU????ES GERAIS", "TRABALHOS", "ARTIGOS", "MEM??RIAS", "LIVROS"));

                    $this->barchart->set_include_charts(false); // hide charts

                    $this->write_xls($xls, 'PRODUCOES-ESTADO.xls');
                } else if ($tipo == 2) {
                    $this->write_pdf('Total de Produ????es por tipo e Estado', $result, $title_status, 'relatorio/2pnera/producoes_estado');
                } else if ($tipo == 3) {
                    $this->write_html('Total de Produ????es por tipo e Estado', $result, $title_status, 'relatorio/2pnera/producoes_estado');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function producoes_superintendencia($tipo)
    {
        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->producoes_superintendencia($vigencia, $status);
        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Total de Produ????es por tipo e Superintend??ncia", $vigencia, $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("C??DIGO", "SUPERINTEND??NCIA", "PRODU????ES GERAIS", "TRABALHOS", "ARTIGOS", "MEM??RIAS", "LIVROS"));

                    $this->barchart->set_include_charts(false); // hide charts

                    $this->write_xls($xls, 'PRODUCOES-SUPERINTENDENCIA.xls');
                } else if ($tipo == 2) {
                    $this->write_pdf('Total de Produ????es por tipo e Superintend??ncia', $result, $title_status, 'relatorio/2pnera/producoes_superintendencia');
                } else if ($tipo == 3) {
                    $this->write_html('Total de Produ????es por tipo e Superintend??ncia', $result, $title_status, 'relatorio/2pnera/producoes_superintendencia');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function producoes_tipo($tipo)
    {
        $status = $this->get_status();
        $vigencia = $this->get_vigencia();
        $title_status = $this->title_status($status);
        $result = $this->relatorio_geral_m_pnera2->producoes_tipo($this->session->userdata('access_level'), $vigencia, $status);
        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Produ????es por tipo de produ????o", $title_status);
                    $xls = $this->append_xls_data($xls, $result, array("TIPO", "PRODU????ES"));

                    // Set the position where the chart should appear in the worksheet
                    $this->barchart->set_topLeftCell('K1');
                    $this->barchart->set_bottomRightCell('V10');

                    $this->barchart->set_chart_colors(array('9370DB'));    // array - colors
                    $this->barchart->set_title("PRODU????ES POR TIPO");      // string

                    $this->write_xls($xls, 'PRODUCOES-TIPO.xls');
                } else if ($tipo == 2) {
                    $this->write_pdf('Total de Produ????es por tipo', $result, $title_status, 'relatorio/2pnera/producoes_tipo');
                } else if ($tipo == 3) {
                    $this->write_html('Total de Produ????es por tipo', $result, $title_status, 'relatorio/2pnera/producoes_tipo');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function pesquisa_estado($tipo)
    {
        $result = $this->relatorio_geral_m_pnera2->pesquisa_estado();

        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Produ????es sobre o Pronera por tipo de produ????o e estado", false);
                    $xls = $this->append_xls_data($xls, $result, array("ESTADO", "MONOGRAFIAS/DISSERTA????ES", "LIVROS/COLET??NEAS", "CAP. LIVROS", "ARTIGOS", "V??DEOS/DOCUMENT??RIOS", "PERI??DICOS", "EVENTOS"));

                    $this->barchart->set_include_charts(false); // hide charts

                    $this->write_xls($xls, 'PRODUCOES-PRONERA-ESTADO.xls');
                } else if ($tipo == 2) {
                    $this->write_pdf('Produ????es sobre o Pronera por tipo e Estado', $result, "Todos Cursos", 'relatorio/2pnera/pesquisa_estado');
                } else if ($tipo == 3) {
                    $this->write_html('Produ????es sobre o Pronera por tipo e Estado', $result, "Todos Cursos", 'relatorio/2pnera/pesquisa_estado');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function pesquisa_superintendencia($tipo)
    {

        $result = $this->relatorio_geral_m_pnera2->pesquisa_superintendencia();
        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Produ????es sobre o Pronera por tipo de produ????o e superintendencia", false);
                    $xls = $this->append_xls_data($xls, $result, array("C??DIGO", "SUPERINTEND??NCIA", "MONOGRAFIAS/DISSERTA????ES", "LIVROS/COLET??NEAS", "CAP. LIVROS", "ARTIGOS", "V??DEOS/DOCUMENT??RIOS", "PERI??DICOS", "EVENTOS"));

                    $this->barchart->set_include_charts(false); // hide charts

                    $this->write_xls($xls, 'PRODUCOES-PRONERA-SUPERINTENDENCIA.xls');
                } else if ($tipo == 2) {
                    $this->write_pdf('Produ????es sobre o Pronera por tipo e Superintendencia', $result, "Todos Cursos", 'relatorio/2pnera/pesquisa_superintendencia');
                } else if ($tipo == 3) {
                    $this->write_html('Produ????es sobre o Pronera por tipo e Superintendencia', $result, "Todos Cursos", 'relatorio/2pnera/pesquisa_superintendencia');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }

    public function pesquisa_tipo($tipo)
    {

        $result = $this->relatorio_geral_m_pnera2->pesquisa_tipo($this->session->userdata('access_level'));
        if (is_array($result)) {
            if (count($result) != 0) {
                if ($tipo == 1) {
                    $xls = $this->create_header("Total nacional de produ????es por tipo de produ????o", false);
                    $xls = $this->append_xls_data($xls, $result, array("TIPO", "PRODU????ES"));

                    $this->barchart->set_topLeftCell('K1');
                    $this->barchart->set_bottomRightCell('Q28');

                    $this->barchart->set_chart_colors(array('B03060'));                 // array - colors
                    $this->barchart->set_title("PRODU????ES SOBRE O PRONERA POR TIPO");   // string

                    $this->write_xls($xls, 'PRODUCOES-PRONERA-TIPO.xls');
                } else if ($tipo == 2) {
                    $this->write_pdf('Total nacional de produ????es por tipo de produ????o', $result, "Todos Cursos", 'relatorio/2pnera/pesquisa_tipo');
                } else if ($tipo == 3) {
                    $this->write_html('Total nacional de produ????es por tipo de produ????o', $result, "Todos Cursos", 'relatorio/2pnera/pesquisa_tipo');
                }
            } else {
                $this->handle_empty();
            }
        } else {
            $this->handle_error();
        }
    }
}
