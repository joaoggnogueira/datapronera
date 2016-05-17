<?php 
	
class Relatorio_quantitativo extends CI_Controller {

	public function __construct() {
        parent::__construct(); 

        $this->load->database();		    // Loading Database 
        $this->load->library('session');    // Loading Session
        $this->load->helper('url'); 	    // Loading Helper        
    }

    function index()
    {

        $this->session->set_userdata('curr_content', 'rel_quantitativo');
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

    function superintendencia ()
    {
        $this->load->library('pdf');            
        $pdf = $this->pdf->load(); 
        $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   '); 
        
        $data['titulo_relatorio'] = 'Relatório Quantitativo - Superintendências';
        $html = $this->load->view('include/header_pdf', $data, true); 

        $pdf->WriteHTML($html); 

        $this->load->model('requisicao_m');
        $super_id = $this->uri->segment(3);
        $superintendencias = $this->requisicao_m->get_superintendencias_cursos_clear($super_id); 
       
        foreach ($superintendencias as $item) {

            $super = $item->id;
            $valores['dados'][$super]['nome'] = $item->nome;

            $this->db->from('curso_fonte_informacao r');
            $this->db->join('curso c', 'c.id = r.id_curso', 'left');
            $this->db->where('c.ativo_inativo', 'A');
            $this->db->where('c.id_superintendencia', $super);
            $this->db->where('r.superintendencia_incra <> ', 0);
            $this->db->where('r.universidade_faculdade <> ', 0);
            $this->db->where('r.movimento_social_sindical <> ', 0);
            $this->db->where('r.secretaria_municipal_educacao <> ', 0);
            $this->db->where('r.secretaria_estadual_educacao <> ', 0);
            $this->db->where('r.instituto_federal <> ', 0);
            $this->db->where('r.escola_tecnica <> ', 0);
            $this->db->where('r.redes_ceffas <> ', 0);
            $this->db->where('r.outras <> ', 0);
            $query = $this->db->get();
            $valores['dados'][$super]['responsaveis'] = $query->num_rows();

            $this->db->from('caracterizacao ca');
            $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
            $this->db->where('c.ativo_inativo', 'A');
            $this->db->where('c.id_superintendencia', $super);
            $this->db->where('ca.area_conhecimento IS NOT NULL');
            $this->db->where('ca.nome_coordenador_geral IS NOT NULL');
            $this->db->where('ca.titulacao_coordenador_geral IS NOT NULL');
            $this->db->where('ca.nome_coordenador IS NOT NULL');
            $this->db->where('ca.titulacao_coordenador IS NOT NULL');
            $this->db->where('ca.nome_vice_coordenador IS NOT NULL');
            $this->db->where('ca.titulacao_vice_coordenador IS NOT NULL');
            $this->db->where('ca.nome_coordenador_pedagogico IS NOT NULL');
            $this->db->where('ca.titulacao_coordenador_pedagogico IS NOT NULL');
            $this->db->where('ca.duracao_curso IS NOT NULL');
            $this->db->where('ca.inicio_previsto IS NOT NULL');
            $this->db->where('ca.termino_previsto IS NOT NULL');
            $this->db->where('ca.inicio_realizado IS NOT NULL');
            $this->db->where('ca.termino_realizado IS NOT NULL');
            $this->db->where('ca.curso_descricao IS NOT NULL');
            $this->db->where('ca.numero_turmas IS NOT NULL');
            $this->db->where('ca.numero_ingressantes IS NOT NULL');
            $this->db->where('ca.numero_concluintes IS NOT NULL');
            $this->db->where('ca.impedimento_curso IS NOT NULL');
            $this->db->where('ca.impedimento_curso_descricao IS NOT NULL');
            $this->db->where('ca.referencia_curso IS NOT NULL');
            $this->db->where('ca.matriz_curricular_curso IS NOT NULL');
            $this->db->where('ca.desdobramento IS NOT NULL');
            $this->db->where('ca.desdobramento_descricao IS NOT NULL');
            $this->db->where('ca.documentos_normativos IS NOT NULL');
            $this->db->where('ca.documentos_normativos_descricao IS NOT NULL');
            $this->db->where('ca.espaco_especifico IS NOT NULL');
            $this->db->where('ca.espaco_especifico_descricao IS NOT NULL');
            $this->db->where('ca.avaliacao_mec IS NOT NULL');
            $this->db->where('ca.avaliacao_mec_descricao IS NOT NULL');
            $this->db->where('ca.numero_bolsistas IS NOT NULL');
            $query = $this->db->get();

            $valores['dados'][$super]['caracterizacoes'] = $query->num_rows();

            $this->db->from('professor p');
            $this->db->join('curso c', 'c.id = p.id_curso', 'left');
            $this->db->where('c.ativo_inativo', 'A');
            $this->db->where('c.id_superintendencia', $super);
            $query = $this->db->get();
            $valores['dados'][$super]['professor'] = $query->num_rows();

            $this->db->from('educando e');
            $this->db->join('curso c', 'c.id = e.id_curso', 'left');
            $this->db->where('c.ativo_inativo', 'A');
            $this->db->where('c.id_superintendencia', $super);
            $query = $this->db->get();
            $valores['dados'][$super]['educando'] = $query->num_rows();

            $this->db->from('instituicao_ensino ie');
            $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
            $this->db->where('c.ativo_inativo', 'A');
            $this->db->where('c.id_superintendencia', $super);
            $this->db->where('ie.nome IS NOT NULL');
            $this->db->where('ie.sigla IS NOT NULL');
            $this->db->where('ie.unidade IS NOT NULL');
            $this->db->where('ie.departamento IS NOT NULL');
            $this->db->where('ie.rua IS NOT NULL');
            $this->db->where('ie.numero IS NOT NULL');
            $this->db->where('ie.complemento IS NOT NULL');
            $this->db->where('ie.bairro IS NOT NULL');
            $this->db->where('ie.cep IS NOT NULL');
            $this->db->where('ie.telefone1 IS NOT NULL');
            $this->db->where('ie.telefone2 IS NOT NULL');
            $this->db->where('ie.pagina_web IS NOT NULL');
            $this->db->where('ie.campus IS NOT NULL');
            $this->db->where('ie.id_cidade IS NOT NULL');
            $this->db->where('ie.natureza_instituicao IS NOT NULL');
            $query = $this->db->get();
            $valores['dados'][$super]['instituicao'] = $query->num_rows();

            $this->db->from('organizacao_demandante o');
            $this->db->join('curso c', 'c.id = o.id_curso', 'left');
            $this->db->where('c.ativo_inativo', 'A');
            $this->db->where('c.id_superintendencia', $super);
            $query = $this->db->get();
            $valores['dados'][$super]['organizacao'] = $query->num_rows();

            $this->db->from('parceiro p');
            $this->db->join('curso c', 'c.id = p.id_curso', 'left');
            $this->db->where('c.ativo_inativo', 'A');
            $this->db->where('c.id_superintendencia', $super);
            $query = $this->db->get();
            $valores['dados'][$super]['parceiro'] = $query->num_rows();

            $num_producoes = 0;

            $this->db->from('producao_geral o');
            $this->db->join('curso c', 'c.id = o.id_curso', 'left');
            $this->db->where('c.ativo_inativo', 'A');
            $this->db->where('c.id_superintendencia', $super);
            $query = $this->db->get();
            $num_producoes += $query->num_rows();

            $this->db->from('producao_trabalho o');
            $this->db->join('curso c', 'c.id = o.id_curso', 'left');
            $this->db->where('c.ativo_inativo', 'A');
            $this->db->where('c.id_superintendencia', $super);
            $query = $this->db->get();
            $num_producoes += $query->num_rows();

            $this->db->from('producao_artigo o');
            $this->db->join('curso c', 'c.id = o.id_curso', 'left');
            $this->db->where('c.ativo_inativo', 'A');
            $this->db->where('c.id_superintendencia', $super);
            $query = $this->db->get();
            $num_producoes += $query->num_rows();

            $this->db->from('producao_memoria o');
            $this->db->join('curso c', 'c.id = o.id_curso', 'left');
            $this->db->where('c.ativo_inativo', 'A');
            $this->db->where('c.id_superintendencia', $super);
            $query = $this->db->get();
            $num_producoes += $query->num_rows();

            $this->db->from('producao_livro o');
            $this->db->join('curso c', 'c.id = o.id_curso', 'left');
            $this->db->where('c.ativo_inativo', 'A');
            $this->db->where('c.id_superintendencia', $super);
            $query = $this->db->get();
            $num_producoes += $query->num_rows();

            $valores['dados'][$super]['producoes'] = $num_producoes;

        }
        
        $html = $this->load->view('relatorio/quantitativo/rel_superintendencia', $valores, true); 
        $pdf->WriteHTML($html); 
        
        // Param    I -> See on the browser         //          D -> Download File         //           F -> Save on the server
        $pdf->Output($pdfFilePath, 'I'); 
    }

    function modalidade ()
    {
        $modalidade = $this->uri->segment(4);

        $this->load->model('requisicao_m');

        $nome_modalidade = $this->requisicao_m->get_modalidade_nome($modalidade);

        $this->load->library('pdf');            
        $pdf = $this->pdf->load(); 
        $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   '); 
        
        $data['titulo_relatorio'] = 'Relatório Quantitativo <br> Modalidade: '.$nome_modalidade;
        $html = $this->load->view('include/header_pdf', $data, true); 

        $pdf->WriteHTML($html); 

        $this->load->model('requisicao_m');
        $super_id = $this->uri->segment(3);
        $superintendencias = $this->requisicao_m->get_superintendencias_cursos_clear($super_id);  
        

        foreach ($superintendencias as $item) {

            $super = $item->id;
            $valores['dados'][$super]['nome'] = $item->nome;

            $this->db->select('c.id, c.nome, c.id_superintendencia super');
            $this->db->from('curso_fonte_informacao cf');
            $this->db->join('curso c', 'c.id = cf.id_curso', 'left');
            $this->db->where('c.ativo_inativo', 'A');
            $this->db->where('c.id_superintendencia', $super);
            $this->db->where('c.id_modalidade', $modalidade);
            $this->db->where('cf.superintendencia_incra <> ', 0);
            $this->db->where('cf.universidade_faculdade <> ', 0);
            $this->db->where('cf.movimento_social_sindical <> ', 0);
            $this->db->where('cf.secretaria_municipal_educacao <> ', 0);
            $this->db->where('cf.secretaria_estadual_educacao <> ', 0);
            $this->db->where('cf.instituto_federal <> ', 0);
            $this->db->where('cf.escola_tecnica <> ', 0);
            $this->db->where('cf.redes_ceffas <> ', 0);
            $this->db->where('cf.outras <> ', 0);
            $query = $this->db->get();
            $valores['dados'][$super]['responsaveis'] = $query->num_rows();

            $this->db->select('c.id, c.nome, c.id_superintendencia super');
            $this->db->from('caracterizacao ca');
            $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
            $this->db->where('c.ativo_inativo', 'A');
            $this->db->where('c.id_superintendencia', $super);
            $this->db->where('c.id_modalidade', $modalidade);
            $this->db->where('ca.area_conhecimento IS NOT NULL');
            $this->db->where('ca.nome_coordenador_geral IS NOT NULL');
            $this->db->where('ca.titulacao_coordenador_geral IS NOT NULL');
            $this->db->where('ca.nome_coordenador IS NOT NULL');
            $this->db->where('ca.titulacao_coordenador IS NOT NULL');
            $this->db->where('ca.nome_vice_coordenador IS NOT NULL');
            $this->db->where('ca.titulacao_vice_coordenador IS NOT NULL');
            $this->db->where('ca.nome_coordenador_pedagogico IS NOT NULL');
            $this->db->where('ca.titulacao_coordenador_pedagogico IS NOT NULL');
            $this->db->where('ca.duracao_curso IS NOT NULL');
            $this->db->where('ca.inicio_previsto IS NOT NULL');
            $this->db->where('ca.termino_previsto IS NOT NULL');
            $this->db->where('ca.inicio_realizado IS NOT NULL');
            $this->db->where('ca.termino_realizado IS NOT NULL');
            $this->db->where('ca.curso_descricao IS NOT NULL');
            $this->db->where('ca.numero_turmas IS NOT NULL');
            $this->db->where('ca.numero_ingressantes IS NOT NULL');
            $this->db->where('ca.numero_concluintes IS NOT NULL');
            $this->db->where('ca.impedimento_curso IS NOT NULL');
            $this->db->where('ca.impedimento_curso_descricao IS NOT NULL');
            $this->db->where('ca.referencia_curso IS NOT NULL');
            $this->db->where('ca.matriz_curricular_curso IS NOT NULL');
            $this->db->where('ca.desdobramento IS NOT NULL');
            $this->db->where('ca.desdobramento_descricao IS NOT NULL');
            $this->db->where('ca.documentos_normativos IS NOT NULL');
            $this->db->where('ca.documentos_normativos_descricao IS NOT NULL');
            $this->db->where('ca.espaco_especifico IS NOT NULL');
            $this->db->where('ca.espaco_especifico_descricao IS NOT NULL');
            $this->db->where('ca.avaliacao_mec IS NOT NULL');
            $this->db->where('ca.avaliacao_mec_descricao IS NOT NULL');
            $this->db->where('ca.numero_bolsistas IS NOT NULL');
            $query = $this->db->get();

            $valores['dados'][$super]['caracterizacoes'] = $query->num_rows();

            $this->db->select('c.id, c.nome, c.id_superintendencia super');
            $this->db->from('professor p');
            $this->db->join('curso c', 'c.id = p.id_curso', 'left');
            $this->db->where('c.ativo_inativo', 'A');
            $this->db->where('c.id_superintendencia', $super);
            $this->db->where('c.id_modalidade', $modalidade);
            $query = $this->db->get();
            $valores['dados'][$super]['professor'] = $query->num_rows();

            $this->db->select('c.id, c.nome, c.id_superintendencia super');
            $this->db->from('educando e');
            $this->db->join('curso c', 'c.id = e.id_curso', 'left');
            $this->db->where('c.ativo_inativo', 'A');
            $this->db->where('c.id_superintendencia', $super);
            $this->db->where('c.id_modalidade', $modalidade);
            $query = $this->db->get();

            $valores['dados'][$super]['educando'] =  $query->num_rows();

            $this->db->select('c.id, c.nome, c.id_superintendencia super');
            $this->db->from('instituicao_ensino ie');
            $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
            $this->db->where('c.ativo_inativo', 'A');
            $this->db->where('c.id_superintendencia', $super);
            $this->db->where('c.id_modalidade', $modalidade);
            $this->db->where('ie.nome IS NOT NULL');
            $this->db->where('ie.sigla IS NOT NULL');
            $this->db->where('ie.unidade IS NOT NULL');
            $this->db->where('ie.departamento IS NOT NULL');
            $this->db->where('ie.rua IS NOT NULL');
            $this->db->where('ie.numero IS NOT NULL');
            $this->db->where('ie.complemento IS NOT NULL');
            $this->db->where('ie.bairro IS NOT NULL');
            $this->db->where('ie.cep IS NOT NULL');
            $this->db->where('ie.telefone1 IS NOT NULL');
            $this->db->where('ie.telefone2 IS NOT NULL');
            $this->db->where('ie.pagina_web IS NOT NULL');
            $this->db->where('ie.campus IS NOT NULL');
            $this->db->where('ie.id_cidade IS NOT NULL');
            $this->db->where('ie.natureza_instituicao IS NOT NULL');
            $query = $this->db->get();
            $valores['dados'][$super]['instituicao'] = $query->num_rows();

            $this->db->select('c.id, c.nome, c.id_superintendencia super');
            $this->db->from('organizacao_demandante o');
            $this->db->join('curso c', 'c.id = o.id_curso', 'left');
            $this->db->where('c.ativo_inativo', 'A');
            $this->db->where('c.id_superintendencia', $super);
            $this->db->where('c.id_modalidade', $modalidade);
            $query = $this->db->get();
            $valores['dados'][$super]['organizacao'] = $query->num_rows();

            $this->db->select('c.id, c.nome, c.id_superintendencia super');
            $this->db->from('parceiro p');
            $this->db->join('curso c', 'c.id = p.id_curso', 'left');
            $this->db->where('c.ativo_inativo', 'A');
            $this->db->where('c.id_superintendencia', $super);
            $this->db->where('c.id_modalidade', $modalidade);
            $query = $this->db->get();

            $valores['dados'][$super]['parceiro'] = $query->num_rows();

            $num_producoes = 0;

            $this->db->from('producao_geral o');
            $this->db->join('curso c', 'c.id = o.id_curso', 'left');
            $this->db->where('c.ativo_inativo', 'A');
            $this->db->where('c.id_superintendencia', $super);
            $this->db->where('c.id_modalidade', $modalidade);
            $query = $this->db->get();
            $num_producoes += $query->num_rows();

            $this->db->from('producao_trabalho o');
            $this->db->join('curso c', 'c.id = o.id_curso', 'left');
            $this->db->where('c.ativo_inativo', 'A');
            $this->db->where('c.id_superintendencia', $super);
            $this->db->where('c.id_modalidade', $modalidade);
            $query = $this->db->get();
            $num_producoes += $query->num_rows();

            $this->db->from('producao_artigo o');
            $this->db->join('curso c', 'c.id = o.id_curso', 'left'); 
            $this->db->where('c.ativo_inativo', 'A');
            $this->db->where('c.id_superintendencia', $super);
            $this->db->where('c.id_modalidade', $modalidade);
            $query = $this->db->get();
            $num_producoes += $query->num_rows();

            $this->db->from('producao_memoria o');
            $this->db->join('curso c', 'c.id = o.id_curso', 'left'); 
            $this->db->where('c.ativo_inativo', 'A');
            $this->db->where('c.id_superintendencia', $super);
            $this->db->where('c.id_modalidade', $modalidade);
            $query = $this->db->get();
            $num_producoes += $query->num_rows();

            $this->db->from('producao_livro o');
            $this->db->join('curso c', 'c.id = o.id_curso', 'left'); 
            $this->db->where('c.ativo_inativo', 'A');
            $this->db->where('c.id_superintendencia', $super);
            $this->db->where('c.id_modalidade', $modalidade);
            $query = $this->db->get();
            $num_producoes += $query->num_rows();

            $valores['dados'][$super]['producoes'] = $num_producoes;

            // ----------------------------------------------------------------------------------------------------------
            $this->db->select('c.id, count(cf.id) numero, c.nome, c.id_superintendencia super');
            $this->db->from('curso_fonte_informacao cf');
            $this->db->join('curso c', 'c.id = cf.id_curso', 'left'); 
            $this->db->where('c.ativo_inativo', 'A');
            $this->db->where('c.id_superintendencia', $super);
            $this->db->where('c.id_modalidade', $modalidade);
            $this->db->where('cf.superintendencia_incra <> ', 0);
            $this->db->where('cf.universidade_faculdade <> ', 0);
            $this->db->where('cf.movimento_social_sindical <> ', 0);
            $this->db->where('cf.secretaria_municipal_educacao <> ', 0);
            $this->db->where('cf.secretaria_estadual_educacao <> ', 0);
            $this->db->where('cf.instituto_federal <> ', 0);
            $this->db->where('cf.escola_tecnica <> ', 0);
            $this->db->where('cf.redes_ceffas <> ', 0);
            $this->db->where('cf.outras <> ', 0);
            $this->db->group_by('c.id');
            $query = $this->db->get();

            $cursos = $query->result();
            foreach ($cursos as $item) {
                $valores['cursos'][$item->id]['responsaveis'] = $item->numero;
                $valores['cursos'][$item->id]['id'] = $item->id;
                $valores['cursos'][$item->id]['nome'] = $item->nome;
                $valores['cursos'][$item->id]['super'] = $item->super;
            }

            $this->db->select('c.id, count(ca.id) numero, c.nome, c.id_superintendencia super');
            $this->db->from('caracterizacao ca');
            $this->db->join('curso c', 'c.id = ca.id_curso', 'left'); 
            $this->db->where('c.ativo_inativo', 'A');
            $this->db->where('c.id_superintendencia', $super);
            $this->db->where('c.id_modalidade', $modalidade);
            $this->db->group_by('c.id');
            $this->db->where('ca.area_conhecimento IS NOT NULL');
            $this->db->where('ca.nome_coordenador_geral IS NOT NULL');
            $this->db->where('ca.titulacao_coordenador_geral IS NOT NULL');
            $this->db->where('ca.nome_coordenador IS NOT NULL');
            $this->db->where('ca.titulacao_coordenador IS NOT NULL');
            $this->db->where('ca.nome_vice_coordenador IS NOT NULL');
            $this->db->where('ca.titulacao_vice_coordenador IS NOT NULL');
            $this->db->where('ca.nome_coordenador_pedagogico IS NOT NULL');
            $this->db->where('ca.titulacao_coordenador_pedagogico IS NOT NULL');
            $this->db->where('ca.duracao_curso IS NOT NULL');
            $this->db->where('ca.inicio_previsto IS NOT NULL');
            $this->db->where('ca.termino_previsto IS NOT NULL');
            $this->db->where('ca.inicio_realizado IS NOT NULL');
            $this->db->where('ca.termino_realizado IS NOT NULL');
            $this->db->where('ca.curso_descricao IS NOT NULL');
            $this->db->where('ca.numero_turmas IS NOT NULL');
            $this->db->where('ca.numero_ingressantes IS NOT NULL');
            $this->db->where('ca.numero_concluintes IS NOT NULL');
            $this->db->where('ca.impedimento_curso IS NOT NULL');
            $this->db->where('ca.impedimento_curso_descricao IS NOT NULL');
            $this->db->where('ca.referencia_curso IS NOT NULL');
            $this->db->where('ca.matriz_curricular_curso IS NOT NULL');
            $this->db->where('ca.desdobramento IS NOT NULL');
            $this->db->where('ca.desdobramento_descricao IS NOT NULL');
            $this->db->where('ca.documentos_normativos IS NOT NULL');
            $this->db->where('ca.documentos_normativos_descricao IS NOT NULL');
            $this->db->where('ca.espaco_especifico IS NOT NULL');
            $this->db->where('ca.espaco_especifico_descricao IS NOT NULL');
            $this->db->where('ca.avaliacao_mec IS NOT NULL');
            $this->db->where('ca.avaliacao_mec_descricao IS NOT NULL');
            $this->db->where('ca.numero_bolsistas IS NOT NULL');
            $query = $this->db->get();

            $cursos = $query->result();
            foreach ($cursos as $item) {
                $valores['cursos'][$item->id]['caracterizacoes'] = $item->numero;
                $valores['cursos'][$item->id]['id'] = $item->id;
                $valores['cursos'][$item->id]['nome'] = $item->nome;
                $valores['cursos'][$item->id]['super'] = $item->super;
            }

            $this->db->select('c.id, count(p.id) numero, c.nome, c.id_superintendencia super');
            $this->db->from('professor p');
            $this->db->join('curso c', 'c.id = p.id_curso', 'left'); 
            $this->db->where('c.ativo_inativo', 'A');
            $this->db->where('c.id_superintendencia', $super);
            $this->db->where('c.id_modalidade', $modalidade);
            $this->db->group_by('c.id');
            $query = $this->db->get();

            $cursos = $query->result();
            foreach ($cursos as $item) {
                $valores['cursos'][$item->id]['professor'] = $item->numero;
                $valores['cursos'][$item->id]['id'] = $item->id;
                $valores['cursos'][$item->id]['nome'] = $item->nome;
                $valores['cursos'][$item->id]['super'] = $item->super;
            }

            $this->db->select('c.id, count(e.id) numero, c.nome, c.id_superintendencia super');
            $this->db->from('educando e');
            $this->db->join('curso c', 'c.id = e.id_curso', 'left'); 
            $this->db->where('c.ativo_inativo', 'A');
            $this->db->where('c.id_superintendencia', $super);
            $this->db->where('c.id_modalidade', $modalidade);
            $this->db->group_by('c.id');
            $query = $this->db->get();

            $cursos = $query->result();
            foreach ($cursos as $item) {
                $valores['cursos'][$item->id]['educando'] = $item->numero;
                $valores['cursos'][$item->id]['id'] = $item->id;
                $valores['cursos'][$item->id]['nome'] = $item->nome;
                $valores['cursos'][$item->id]['super'] = $item->super;
            }

            $this->db->select('c.id, count(ie.id) numero, c.nome, c.id_superintendencia super');
            $this->db->from('instituicao_ensino ie');
            $this->db->join('curso c', 'c.id = ie.id_curso', 'left'); 
            $this->db->where('c.ativo_inativo', 'A');
            $this->db->where('c.id_superintendencia', $super);
            $this->db->where('c.id_modalidade', $modalidade);
            $this->db->where('ie.nome IS NOT NULL');
            $this->db->where('ie.sigla IS NOT NULL');
            $this->db->where('ie.unidade IS NOT NULL');
            $this->db->where('ie.departamento IS NOT NULL');
            $this->db->where('ie.rua IS NOT NULL');
            $this->db->where('ie.numero IS NOT NULL');
            $this->db->where('ie.complemento IS NOT NULL');
            $this->db->where('ie.bairro IS NOT NULL');
            $this->db->where('ie.cep IS NOT NULL');
            $this->db->where('ie.telefone1 IS NOT NULL');
            $this->db->where('ie.telefone2 IS NOT NULL');
            $this->db->where('ie.pagina_web IS NOT NULL');
            $this->db->where('ie.campus IS NOT NULL');
            $this->db->where('ie.id_cidade IS NOT NULL');
            $this->db->where('ie.natureza_instituicao IS NOT NULL');
            $this->db->group_by('c.id');
            $query = $this->db->get();

            $cursos = $query->result();
            foreach ($cursos as $item) {
                $valores['cursos'][$item->id]['instituicao'] = $item->numero;
                $valores['cursos'][$item->id]['id'] = $item->id;
                $valores['cursos'][$item->id]['nome'] = $item->nome;
                $valores['cursos'][$item->id]['super'] = $item->super;
            }

            $this->db->select('c.id, count(o.id) numero, c.nome, c.id_superintendencia super');
            $this->db->from('organizacao_demandante o');
            $this->db->join('curso c', 'c.id = o.id_curso', 'left'); 
            $this->db->where('c.ativo_inativo', 'A');
            $this->db->where('c.id_superintendencia', $super);
            $this->db->where('c.id_modalidade', $modalidade);
            $this->db->group_by('c.id');
            $query = $this->db->get();

            $cursos = $query->result();
            foreach ($cursos as $item) {
                $valores['cursos'][$item->id]['organizacao'] = $item->numero;
                $valores['cursos'][$item->id]['id'] = $item->id;
                $valores['cursos'][$item->id]['nome'] = $item->nome;
                $valores['cursos'][$item->id]['super'] = $item->super;
            }

            $this->db->select('c.id, count(p.id) numero, c.nome, c.id_superintendencia super');
            $this->db->from('parceiro p');
            $this->db->join('curso c', 'c.id = p.id_curso', 'left'); 
            $this->db->where('c.ativo_inativo', 'A');
            $this->db->where('c.id_superintendencia', $super);
            $this->db->where('c.id_modalidade', $modalidade);
            $this->db->group_by('c.id');
            $query = $this->db->get();

            $cursos = $query->result();
            foreach ($cursos as $item) {
                $valores['cursos'][$item->id]['parceiro'] = $item->numero;
                $valores['cursos'][$item->id]['id'] = $item->id;
                $valores['cursos'][$item->id]['nome'] = $item->nome;
                $valores['cursos'][$item->id]['super'] = $item->super;
            }

            $num_producoes = 0;

            $this->db->select('c.id, count(o.id) numero, c.nome, c.id_superintendencia super');
            $this->db->from('producao_geral o');
            $this->db->join('curso c', 'c.id = o.id_curso', 'left'); 
            $this->db->where('c.ativo_inativo', 'A');
            $this->db->where('c.id_superintendencia', $super);
            $this->db->where('c.id_modalidade', $modalidade);
            $this->db->group_by('c.id');
            $query = $this->db->get();
            $num_producoes += $query->num_rows();

            $cursos = $query->result();
            foreach ($cursos as $item) {
                $valores['cursos'][$item->id]['producoes'] += $item->numero;
                $valores['cursos'][$item->id]['id'] = $item->id;
                $valores['cursos'][$item->id]['nome'] = $item->nome;
                $valores['cursos'][$item->id]['super'] = $item->super;
            }

            $this->db->select('c.id, count(o.id) numero, c.nome, c.id_superintendencia super');
            $this->db->from('producao_trabalho o');
            $this->db->join('curso c', 'c.id = o.id_curso', 'left'); 
            $this->db->where('c.ativo_inativo', 'A');
            $this->db->where('c.id_superintendencia', $super);
            $this->db->where('c.id_modalidade', $modalidade);
            $this->db->group_by('c.id');
            $query = $this->db->get();
            $num_producoes += $query->num_rows();

            $cursos = $query->result();
            foreach ($cursos as $item) {
                $valores['cursos'][$item->id]['producoes'] += $item->numero;
                $valores['cursos'][$item->id]['id'] = $item->id;
                $valores['cursos'][$item->id]['nome'] = $item->nome;
                $valores['cursos'][$item->id]['super'] = $item->super;
            }

            $this->db->select('c.id, count(o.id) numero, c.nome, c.id_superintendencia super');
            $this->db->from('producao_artigo o');
            $this->db->join('curso c', 'c.id = o.id_curso', 'left'); 
            $this->db->where('c.ativo_inativo', 'A');
            $this->db->where('c.id_superintendencia', $super);
            $this->db->where('c.id_modalidade', $modalidade);
            $this->db->group_by('c.id');
            $query = $this->db->get();
            $num_producoes += $query->num_rows();

            $cursos = $query->result();
            foreach ($cursos as $item) {
                $valores['cursos'][$item->id]['producoes'] += $item->numero;
                $valores['cursos'][$item->id]['id'] = $item->id;
                $valores['cursos'][$item->id]['nome'] = $item->nome;
                $valores['cursos'][$item->id]['super'] = $item->super;
            }

            $this->db->select('c.id, count(o.id) numero, c.nome, c.id_superintendencia super');
            $this->db->from('producao_memoria o');
            $this->db->join('curso c', 'c.id = o.id_curso', 'left'); 
            $this->db->where('c.ativo_inativo', 'A');
            $this->db->where('c.id_superintendencia', $super);
            $this->db->where('c.id_modalidade', $modalidade);
            $this->db->group_by('c.id');
            $query = $this->db->get();
            $num_producoes += $query->num_rows();

            $cursos = $query->result();
            foreach ($cursos as $item) {
                $valores['cursos'][$item->id]['producoes'] += $item->numero;
                $valores['cursos'][$item->id]['id'] = $item->id;
                $valores['cursos'][$item->id]['nome'] = $item->nome;
                $valores['cursos'][$item->id]['super'] = $item->super;
            }

            $this->db->select('c.id, count(o.id) numero, c.nome, c.id_superintendencia super');
            $this->db->from('producao_livro o');
            $this->db->join('curso c', 'c.id = o.id_curso', 'left'); 
            $this->db->where('c.ativo_inativo', 'A');
            $this->db->where('c.id_superintendencia', $super);
            $this->db->where('c.id_modalidade', $modalidade);
            $this->db->group_by('c.id');
            $query = $this->db->get();
            $num_producoes += $query->num_rows();

            $cursos = $query->result();
            foreach ($cursos as $item) {
                $valores['cursos'][$item->id]['producoes'] += $item->numero;
                $valores['cursos'][$item->id]['id'] = $item->id;
                $valores['cursos'][$item->id]['nome'] = $item->nome;
                $valores['cursos'][$item->id]['super'] = $item->super;
            }

        }
        
        $html = $this->load->view('relatorio/quantitativo/rel_modalidade', $valores, true); 
        $pdf->WriteHTML($html); 
        
        // Param    I -> See on the browser         //          D -> Download File         //           F -> Save on the server
        $pdf->Output($pdfFilePath, 'I'); 
    }   

    function educando_municipio_curso()
    {
        $this->load->library('pdf');            
        $pdf = $this->pdf->load(); 
        $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   '); 
        
        $data['titulo_relatorio'] = 'Relatório Quantitativo - Educandos por Município';
        $html = $this->load->view('include/header_pdf', $data, true); 
    
        $pdf->WriteHTML($html); 

        $curso_id = $this->uri->segment(3);

        $this->db->select('m.cod_municipio, m.nome municipio, es.nome estado, count(ec.id_educando) educandos');
        $this->db->from('educando_cidade ec');
        $this->db->join('educando e', 'e.id = ec.id_educando', 'left');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->join('cidade m', 'm.id = ec.id_cidade', 'left');
        $this->db->join('estado es', 'es.id = m.id_estado', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso_id);
        $this->db->group_by('c.id, m.nome');
        $query = $this->db->get();

        $valores['dados']= $query->result();

        $this->db->select('count(e.id) educandos');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->where('e.id NOT IN (select id_educando from educando_cidade)',NULL,FALSE);
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso_id);
        $query = $this->db->get();

        $valores['sem']= $query->result();

        $this->db->select('count(e.id) total');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso_id);
        $query = $this->db->get();

        $valores['total']= $query->result();
        
        $html = $this->load->view('relatorio/quantitativo/rel_educando_municipio', $valores, true); 
        $pdf->WriteHTML($html); 
        
        // Param    I -> See on the browser         //          D -> Download File         //           F -> Save on the server
        $pdf->Output($pdfFilePath, 'I'); 
    }   

    function educando_municipio_modalidade()
    {
        $this->load->library('pdf');            
        $pdf = $this->pdf->load(); 
        $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   '); 

        $super = $this->uri->segment(3);
        $modalidade = $this->uri->segment(4);
        
        $data['titulo_relatorio'] = 'Relatório Quantitativo - Educandos por Modalidade<br>Modalidade: '.$modalidade;
        $html = $this->load->view('include/header_pdf', $data, true); 
    
        $pdf->WriteHTML($html); 


        $this->db->select('m.cod_municipio, m.nome municipio, es.nome estado, count(ec.id_educando) educandos');
        $this->db->from('educando_cidade ec');
        $this->db->join('educando e', 'e.id = ec.id_educando', 'left');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left'); 
        $this->db->join('cidade m', 'm.id = ec.id_cidade', 'left');
        $this->db->join('estado es', 'es.id = m.id_estado', 'left');
        $this->db->where('c.id_modalidade', $modalidade);
        $this->db->where('c.id_superintendencia', $super);
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->group_by('c.id, m.nome');
        $query = $this->db->get();

        $valores['dados']= $query->result();

        $this->db->select('count(e.id) educandos');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left'); 
        $this->db->where('e.id NOT IN (select id_educando from educando_cidade)',NULL,FALSE);
        $this->db->where('c.id_modalidade', $modalidade);
        $this->db->where('c.id_superintendencia', $super);
        $this->db->where('c.ativo_inativo', 'A');
        $query = $this->db->get();

        $valores['sem']= $query->result();

        $this->db->select('count(e.id) total');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left'); 
        $this->db->where('c.id_modalidade', $modalidade);
        $this->db->where('c.id_superintendencia', $super);
        $this->db->where('c.ativo_inativo', 'A');
        $query = $this->db->get();

        $valores['total']= $query->result();
        
        $html = $this->load->view('relatorio/quantitativo/rel_educando_municipio', $valores, true); 
        $pdf->WriteHTML($html); 
        
        // Param    I -> See on the browser         //          D -> Download File         //           F -> Save on the server
        $pdf->Output($pdfFilePath, 'I'); 
    }
}