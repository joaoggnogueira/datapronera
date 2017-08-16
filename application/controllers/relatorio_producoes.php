<?php

class Relatorio_producoes extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->database();            // Loading Database
        $this->load->library('session');    // Loading Session
        $this->load->helper('url');         // Loading Helper

        $this->load->model('requisicao_m');    // Loading Model
        $this->load->model('relatorio_producoes_m');    // Loading Model
        $this->load->model('barchart');                 // Loading Model
    }

    public function index() {

        if ($this->session->userdata('access_level') > 3) {
            $this->session->set_userdata('curr_content', 'rel_producoes');
        } else if ($this->session->userdata('access_level') > 1) {
            $this->session->set_userdata('curr_content', 'rel_producoes');
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

    public function filtradoPorSR() {
        return $this->session->userdata('access_level') <= 3;
    }

    public function getSR() {
        return $this->session->userdata('id_superintendencia');
    }

    public function getTipo() {
        return $this->uri->segment(3);
    }

    public function getStatus() {
        $filters = $this->input->get("filters");
        if (!$filters) {
            $filters = '["AN", "CC", "2P"]';
        }
        $filters = str_replace("[", "(", $filters);
        $filters = str_replace("]", ")", $filters);
        return $filters;
    }

    public function getStatusTitle($code) {
        switch ($code) {
            case "AN": return "Em andamento";
            case "2P": return "PNERA II";
            case "CC": return "Concluído";
            default : return "Desconhecido";
        }
    }

    public function getStatusDesc() {
        $filters = $this->input->get("filters");
        if (!$filters) {
            $filters = array("AN", "CC", "2P");
        } else {
            $filters = json_decode($filters);
        }
        $total = count($filters);

        if ($total == 0) {
            return "Nenhum";
        } else {
            $saida = "";
            for ($i = 0; $i < $total; $i++) {
                if ($i == 0) {
                    $saida .= $this->getStatusTitle($filters[0]);
                } else if ($i == $total - 1) {
                    $saida .= ' e ' . $this->getStatusTitle($filters[$i]);
                } else {
                    $saida .= ', ' . $this->getStatusTitle($filters[$i]);
                }
            }
            return $saida;
        }
    }

    public function dump($titulo, $tipo, $status, $sr, $filtrado) {
        echo "Titulo : <b>$titulo</b><br/>";
        echo "Extensão: <b>$tipo</b><br/>";
        echo "Status do Curso : <b>$status</b><br/>";
        echo "SR : <b>$sr</b><br/>";
        echo "Filtrado por SR: <b>" . ($filtrado ? "SIM" : "NÃO") . "</b>";
    }

    public function dumpEmpty($titulo, $tipo, $status, $sr, $filtrado) {
        echo "Nenhum dado a ser exibido para este relatório.<br/><br/>";
        $this->dump($titulo, $tipo, $status, $sr, $filtrado);
    }

    public function getFilename($titulo) {
        $saida = strtoupper($titulo);
        $saida = str_replace(" ", "_", $saida);
        $saida = str_replace("ã", "A", $saida);
        $saida = str_replace("õ", "O", $saida);
        $saida = str_replace("ç", "C", $saida);
        return $saida;
    }

    public function generatePDF($consulta, $titulo, $status) {
        error_reporting(E_ALL ^ E_DEPRECATED);
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $data['titulo_relatorio'] = $titulo;
        $data['status'] = $status;
        $access_level = $this->session->userdata('access_level');
        if ($access_level <= 3) {
            $nomeSR = $this->requisicao_m->get_superintendencias_nome(1, $this->session->userdata('id_superintendencia'));
            $data['nomeSR'] = $nomeSR;
        }
        $header = $this->load->view('relatorio/producoes/header_pdf', $data, true);
        $pdf->SetHTMLHeader($header);
        $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera' . '|Página {PAGENO}|' . date("d.m.Y") . '   ');

        $dataResult['result'] = $consulta;
        $pdf->WriteHTML($this->load->view('relatorio/producoes/content_pdf', $dataResult, true));
        $pdf->Output($pdfFilePath, 'I');
    }

    public function generateXLS($consulta, $titulo, $status) {
        $access_level = $this->session->userdata('access_level');
        if ($access_level <= 3) {
            $nomeSR = $this->requisicao_m->get_superintendencias_nome(1, $this->session->userdata('id_superintendencia'));
        }
        $xls = array();
        array_push($xls, array("------------------------------------------------------------------------------------------", "", "", "", "", "", "", "", "", ""));
        array_push($xls, array("Programa Nacional de Educação na Reforma Agrária (Pronera)", "", "", "", "", "", "", "", "", ""));
        array_push($xls, array("Relatório: " . $titulo, "", "", "", "", "", "", "", "", ""));
        if ($access_level <= 3) {
            array_push($xls, array("Superintendência: " . $nomeSR, "", "", "", "", "", "", "", "", ""));
        }
        array_push($xls, array("Status do Curso: " . $status, "", "", "", "", "", "", "", "", ""));
        array_push($xls, array("Data de Emissão: " . date('d/m/y'), "", "", "", "", "", "", "", "", ""));
        array_push($xls, array("------------------------------------------------------------------------------------------", "", "", "", "", "", "", "", ""));
        array_push($xls, array("", "", "", "", "", "", "", "", "", ""));

        $titles = array_keys($consulta[0]);

        array_push($xls, $titles);

        foreach ($consulta as $row) {
            array_push($xls, $row);
        }

        $this->barchart->set_include_charts(false);

        $this->barchart->set_chart_data($xls);
        $this->barchart->set_filename($this->getFilename($titulo) . '.xls');
        $this->barchart->set_excelFile();

        $this->barchart->create_chart();
    }

    public function generate($consulta, $titulo, $filtrado) {
        if (is_array($consulta)) {

            $status = $this->getStatusDesc();
            $sr = $this->getSR();
            $tipo = $this->getTipo();

            if (!empty($consulta)) {
//                $this->dump($titulo, $tipo, $status, $sr, $filtrado);
                switch ($tipo) {
                    case 'XLS':$this->generateXLS($consulta, $titulo, $status);
                        break;
                    case 'PDF':$this->generatePDF($consulta, $titulo, $status);
                        break;
                }
            } else {
                $this->dumpEmpty($titulo, $tipo, $status, $sr, $filtrado);
            }
        } else {
            echo "Erro ao buscar dados na banco!";
        }
    }

    //PRODUÇÔES

    public function producoes_8A() {
        $status = $this->getStatus();
        $filtrado = $this->filtradoPorSR();
        $sr = ($filtrado ? $this->getSR() : false);

        $consulta = $this->relatorio_producoes_m->producoes_8A($status, $sr);
        $this->generate($consulta, "Produções 8A - Geral", $filtrado);
    }

    public function producoes_autores_8A() {
        $status = $this->getStatus();
        $filtrado = $this->filtradoPorSR();
        $sr = ($filtrado ? $this->getSR() : false);

        $consulta = $this->relatorio_producoes_m->producoes_autores_8A($status, $sr);
        $this->generate($consulta, "Autores de Produções 8A - Geral", $filtrado);
    }

    public function producoes_8B() {
        $status = $this->getStatus();
        $filtrado = $this->filtradoPorSR();
        $sr = ($filtrado ? $this->getSR() : false);

        $consulta = $this->relatorio_producoes_m->producoes_8B($status, $sr);
        $this->generate($consulta, "Produções 8B - Trabalho", $filtrado);
    }

    public function producoes_8C() {
        $status = $this->getStatus();
        $filtrado = $this->filtradoPorSR();
        $sr = ($filtrado ? $this->getSR() : false);

        $consulta = $this->relatorio_producoes_m->producoes_8C($status, $sr);
        $this->generate($consulta, "Produções 8C - Artigo", $filtrado);
    }

    public function producoes_autores_8C() {
        $status = $this->getStatus();
        $filtrado = $this->filtradoPorSR();
        $sr = ($filtrado ? $this->getSR() : false);

        $consulta = $this->relatorio_producoes_m->producoes_autores_8C($status, $sr);
        $this->generate($consulta, "Autores de Produções 8C - Artigo", $filtrado);
    }

    public function producoes_8D() {
        $status = $this->getStatus();
        $filtrado = $this->filtradoPorSR();
        $sr = ($filtrado ? $this->getSR() : false);

        $consulta = $this->relatorio_producoes_m->producoes_8D($status, $sr);
        $this->generate($consulta, "Produções 8D - Memória", $filtrado);
    }

    public function producoes_8E() {
        $status = $this->getStatus();
        $filtrado = $this->filtradoPorSR();
        $sr = ($filtrado ? $this->getSR() : false);

        $consulta = $this->relatorio_producoes_m->producoes_8E($status, $sr);
        $this->generate($consulta, "Produções 8E - Livro", $filtrado);
    }

    public function producoes_autores_8E() {
        $status = $this->getStatus();
        $filtrado = $this->filtradoPorSR();
        $sr = ($filtrado ? $this->getSR() : false);

        $consulta = $this->relatorio_producoes_m->producoes_autores_8E($status, $sr);
        $this->generate($consulta, "Autores de Produções 8E - Livro", $filtrado);
    }

    //PESQUISAS

    public function pesquisas_academica() {
        $status = $this->getStatus();
        $filtrado = $this->filtradoPorSR();
        $sr = ($filtrado ? $this->getSR() : false);

        $consulta = $this->relatorio_producoes_m->pesquisas_academica($status, $sr);
        $this->generate($consulta, "Pesquisas - Produções Academicas", $filtrado);
    }

    public function pesquisas_autores_academica() {
        $status = $this->getStatus();
        $filtrado = $this->filtradoPorSR();
        $sr = ($filtrado ? $this->getSR() : false);

        $consulta = $this->relatorio_producoes_m->pesquisas_autores_academica($status, $sr);
        $this->generate($consulta, "Autores de Pesquisas - Produções Academicas", $filtrado);
    }

    public function pesquisas_livro() {
        $status = $this->getStatus();
        $filtrado = $this->filtradoPorSR();
        $sr = ($filtrado ? $this->getSR() : false);

        $consulta = $this->relatorio_producoes_m->pesquisas_livro($status, $sr);
        $this->generate($consulta, "Pesquisas - Produções de Livro", $filtrado);
    }

    public function pesquisas_autores_livro() {
        $status = $this->getStatus();
        $filtrado = $this->filtradoPorSR();
        $sr = ($filtrado ? $this->getSR() : false);

        $consulta = $this->relatorio_producoes_m->pesquisas_autores_livro($status, $sr);
        $this->generate($consulta, "Autores de Pesquisas - Produções de Livro", $filtrado);
    }

    public function pesquisas_coletaneas() {
        $status = $this->getStatus();
        $filtrado = $this->filtradoPorSR();
        $sr = ($filtrado ? $this->getSR() : false);

        $consulta = $this->relatorio_producoes_m->pesquisas_coletaneas($status, $sr);
        $this->generate($consulta, "Pesquisas - Produções de Coletaneas", $filtrado);
    }

    public function pesquisas_capitulo_livro() {
        $status = $this->getStatus();
        $filtrado = $this->filtradoPorSR();
        $sr = ($filtrado ? $this->getSR() : false);

        $consulta = $this->relatorio_producoes_m->pesquisas_capitulo_livro($status, $sr);
        $this->generate($consulta, "Pesquisas - Produções de Capitulos de Livro", $filtrado);
    }

    public function pesquisas_autores_capitulo_livro() {
        $status = $this->getStatus();
        $filtrado = $this->filtradoPorSR();
        $sr = ($filtrado ? $this->getSR() : false);

        $consulta = $this->relatorio_producoes_m->pesquisas_autores_capitulo_livro($status, $sr);
        $this->generate($consulta, "Autores de Pesquisas - Produções de Capitulos de Livro", $filtrado);
    }

    public function pesquisas_artigo() {
        $status = $this->getStatus();
        $filtrado = $this->filtradoPorSR();
        $sr = ($filtrado ? $this->getSR() : false);

        $consulta = $this->relatorio_producoes_m->pesquisas_artigo($status, $sr);
        $this->generate($consulta, "Pesquisas - Produções de Artigos", $filtrado);
    }

    public function pesquisas_autores_artigo() {
        $status = $this->getStatus();
        $filtrado = $this->filtradoPorSR();
        $sr = ($filtrado ? $this->getSR() : false);

        $consulta = $this->relatorio_producoes_m->pesquisas_autores_artigo($status, $sr);
        $this->generate($consulta, "Autores de Pesquisas - Produções de Artigos", $filtrado);
    }

    public function pesquisas_video() {
        $status = $this->getStatus();
        $filtrado = $this->filtradoPorSR();
        $sr = ($filtrado ? $this->getSR() : false);

        $consulta = $this->relatorio_producoes_m->pesquisas_autores_artigo($status, $sr);
        $this->generate($consulta, "Pesquisas - Produções de Videos ou Documentarios", $filtrado);
    }

    public function pesquisas_autores_video() {
        $status = $this->getStatus();
        $filtrado = $this->filtradoPorSR();
        $sr = ($filtrado ? $this->getSR() : false);

        $consulta = $this->relatorio_producoes_m->pesquisas_autores_video($status, $sr);
        $this->generate($consulta, "Autores de Pesquisas - Produções de Videos ou Documentarios", $filtrado);
    }

    public function pesquisas_periodicos() {
        $status = $this->getStatus();
        $filtrado = $this->filtradoPorSR();
        $sr = ($filtrado ? $this->getSR() : false);

        $consulta = $this->relatorio_producoes_m->pesquisas_periodicos($status, $sr);
        $this->generate($consulta, "Pesquisas - Produções de Periódicos", $filtrado);
    }

    public function pesquisas_autores_periodicos() {
        $status = $this->getStatus();
        $filtrado = $this->filtradoPorSR();
        $sr = ($filtrado ? $this->getSR() : false);

        $consulta = $this->relatorio_producoes_m->pesquisas_autores_periodicos($status, $sr);
        $this->generate($consulta, "Autores de Pesquisas - Produções de Periódicos", $filtrado);
    }

    public function pesquisas_eventos() {
        $status = $this->getStatus();
        $filtrado = $this->filtradoPorSR();
        $sr = ($filtrado ? $this->getSR() : false);

        $consulta = $this->relatorio_producoes_m->pesquisas_eventos($status, $sr);
        $this->generate($consulta, "Pesquisas - Eventos", $filtrado);
    }

    public function pesquisas_organizadores_eventos() {
        $status = $this->getStatus();
        $filtrado = $this->filtradoPorSR();
        $sr = ($filtrado ? $this->getSR() : false);

        $consulta = $this->relatorio_producoes_m->pesquisas_organizadores_eventos($status, $sr);
        $this->generate($consulta, "Pesquisas - Organizadores de Eventos", $filtrado);
    }

    public function pesquisas_realizadores_eventos() {
        $status = $this->getStatus();
        $filtrado = $this->filtradoPorSR();
        $sr = ($filtrado ? $this->getSR() : false);

        $consulta = $this->relatorio_producoes_m->pesquisas_realizadores_eventos($status, $sr);
        $this->generate($consulta, "Pesquisas - Realizadores de Eventos", $filtrado);
    }

    public function pesquisas_documentacao_eventos() {
        $status = $this->getStatus();
        $filtrado = $this->filtradoPorSR();
        $sr = ($filtrado ? $this->getSR() : false);

        $consulta = $this->relatorio_producoes_m->pesquisas_documentacao_eventos($status, $sr);
        $this->generate($consulta, "Pesquisas - Documentação de Eventos", $filtrado);
    }

}
