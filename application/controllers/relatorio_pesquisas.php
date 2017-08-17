<?php

class Relatorio_pesquisas extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->database();            // Loading Database
        $this->load->library('session');    // Loading Session
        $this->load->helper('url');         // Loading Helper

        $this->load->model('requisicao_m');    // Loading Model
        $this->load->model('relatorio_pesquisas_m');    // Loading Model
        $this->load->model('barchart');                 // Loading Model
    }

    public function index() {

        if ($this->session->userdata('access_level') > 3) {
            $this->session->set_userdata('curr_content', 'rel_pesquisas');
        } else if ($this->session->userdata('access_level') > 1) {
            $this->session->set_userdata('curr_content', 'rel_pesquisas');
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

    public function getTipo() {
        return $this->uri->segment(3);
    }

    public function dump($titulo, $tipo) {
        echo "Titulo : <b>$titulo</b><br/>";
        echo "Extensão: <b>$tipo</b><br/>";
    }

    public function dumpEmpty($titulo, $tipo) {
        echo "Nenhum dado a ser exibido para este relatório.<br/><br/>";
        $this->dump($titulo, $tipo);
    }

    public function getFilename($titulo) {
        $saida = strtoupper($titulo);
        $saida = str_replace(" ", "_", $saida);
        $saida = str_replace("ã", "A", $saida);
        $saida = str_replace("õ", "O", $saida);
        $saida = str_replace("ç", "C", $saida);
        return $saida;
    }

    public function generatePDF($consulta, $titulo) {
        error_reporting(E_ALL ^ E_DEPRECATED);
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $data['titulo_relatorio'] = $titulo;
        $header = $this->load->view('relatorio/pesquisas/header_pdf', $data, true);
        $pdf->SetHTMLHeader($header);
        $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera' . '|Página {PAGENO}|' . date("d.m.Y") . '   ');

        $dataResult['result'] = $consulta;
        $pdf->WriteHTML($this->load->view('relatorio/pesquisas/content_pdf', $dataResult, true));
        $pdf->Output($pdfFilePath, 'I');
    }

    public function generateXLS($consulta, $titulo) {

        $xls = array();
        array_push($xls, array("------------------------------------------------------------------------------------------", "", "", "", "", "", "", "", "", ""));
        array_push($xls, array("Programa Nacional de Educação na Reforma Agrária (Pronera)", "", "", "", "", "", "", "", "", ""));
        array_push($xls, array("Relatório: " . $titulo, "", "", "", "", "", "", "", "", ""));
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

    public function generate($consulta, $titulo) {
        if (is_array($consulta)) {

            $tipo = $this->getTipo();

            if (!empty($consulta)) {
//                $this->dump($titulo, $tipo);
                switch ($tipo) {
                    case 'XLS':$this->generateXLS($consulta, $titulo);
                        break;
                    case 'PDF':$this->generatePDF($consulta, $titulo);
                        break;
                }
            } else {
                $this->dumpEmpty($titulo, $tipo);
            }
        } else {
            echo "Erro ao buscar dados na banco!";
        }
    }

    public function pesquisas_academica() {
        $consulta = $this->relatorio_pesquisas_m->pesquisas_academica();
        $this->generate($consulta, "Pesquisas - Produções Academicas");
    }

    public function pesquisas_autores_academica() {
        $consulta = $this->relatorio_pesquisas_m->pesquisas_autores_academica();
        $this->generate($consulta, "Autores de Pesquisas - Produções Academicas");
    }

    public function pesquisas_livro() {
        $consulta = $this->relatorio_pesquisas_m->pesquisas_livro();
        $this->generate($consulta, "Pesquisas - Produções de Livro");
    }

    public function pesquisas_autores_livro() {
        $consulta = $this->relatorio_pesquisas_m->pesquisas_autores_livro();
        $this->generate($consulta, "Autores de Pesquisas - Produções de Livro");
    }

    public function pesquisas_coletaneas() {
        $consulta = $this->relatorio_pesquisas_m->pesquisas_coletaneas();
        $this->generate($consulta, "Pesquisas - Produções de Coletaneas");
    }

    public function pesquisas_capitulo_livro() {
        $consulta = $this->relatorio_pesquisas_m->pesquisas_capitulo_livro();
        $this->generate($consulta, "Pesquisas - Produções de Capitulos de Livro");
    }

    public function pesquisas_autores_capitulo_livro() {
        $consulta = $this->relatorio_pesquisas_m->pesquisas_autores_capitulo_livro();
        $this->generate($consulta, "Autores de Pesquisas - Produções de Capitulos de Livro");
    }

    public function pesquisas_artigo() {
        $consulta = $this->relatorio_pesquisas_m->pesquisas_artigo();
        $this->generate($consulta, "Pesquisas - Produções de Artigos");
    }

    public function pesquisas_autores_artigo() {
        $consulta = $this->relatorio_pesquisas_m->pesquisas_autores_artigo();
        $this->generate($consulta, "Autores de Pesquisas - Produções de Artigos");
    }

    public function pesquisas_video() {
        $consulta = $this->relatorio_pesquisas_m->pesquisas_autores_artigo();
        $this->generate($consulta, "Pesquisas - Produções de Videos ou Documentarios");
    }

    public function pesquisas_autores_video() {
        $consulta = $this->relatorio_pesquisas_m->pesquisas_autores_video();
        $this->generate($consulta, "Autores de Pesquisas - Produções de Videos ou Documentarios");
    }

    public function pesquisas_periodicos() {
        $consulta = $this->relatorio_pesquisas_m->pesquisas_periodicos();
        $this->generate($consulta, "Pesquisas - Produções de Periódicos");
    }

    public function pesquisas_autores_periodicos() {
        $consulta = $this->relatorio_pesquisas_m->pesquisas_autores_periodicos();
        $this->generate($consulta, "Autores de Pesquisas - Produções de Periódicos");
    }

    public function pesquisas_eventos() {
        $consulta = $this->relatorio_pesquisas_m->pesquisas_eventos();
        $this->generate($consulta, "Pesquisas - Eventos");
    }

    public function pesquisas_organizadores_eventos() {
        $consulta = $this->relatorio_pesquisas_m->pesquisas_organizadores_eventos();
        $this->generate($consulta, "Pesquisas - Organizadores de Eventos");
    }

    public function pesquisas_realizadores_eventos() {
        $consulta = $this->relatorio_pesquisas_m->pesquisas_realizadores_eventos();
        $this->generate($consulta, "Pesquisas - Realizadores de Eventos");
    }

    public function pesquisas_documentacao_eventos() {
        $consulta = $this->relatorio_pesquisas_m->pesquisas_documentacao_eventos();
        $this->generate($consulta, "Pesquisas - Documentação de Eventos");
    }

}
