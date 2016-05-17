<?php 
	
class Relatorio_estatistico extends CI_Controller {

	public function __construct() {
        parent::__construct(); 

        $this->load->database();		    // Loading Database 
        $this->load->library('session');    // Loading Session
        $this->load->helper('url'); 	    // Loading Helper        
    }

    function index()
    {

        $this->session->set_userdata('curr_content', 'rel_estatistico');
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

    function superintendencia()
    {
        $super_id = $this->uri->segment(3);

        $this->load->model('requisicao_m');

        $nome_super = $this->requisicao_m->get_superintendencias_nome(1, $super_id);

        $this->load->library('pdf');            
        $pdf = $this->pdf->load(); 
        $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   '); 
        
        $data['titulo_relatorio'] = 'Relatório Estatístico por Superintendência<br><br><b>Superintendência:</b> '.$nome_super;
        $html = $this->load->view('include/header_pdf', $data, true); 

        $pdf->WriteHTML($html);

        $this->db->select('c.id');
        $this->db->from('curso c');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id_superintendencia', $super_id);
        $query = $this->db->get();

        $dados = $query->result();

        $caracterizacao = array();
        $professor = array();
        $educando = array();
        $instituicao = array();
        $organizacao = array();
        $parceiro = array();

        foreach ($dados as $item) {
            $caracterizacao =   $this->somar_caracterizacao($caracterizacao,    $this->caracterizacao($item->id)    );
            $professor =        $this->somar_professor (    $professor,         $this->professor($item->id)         );
            $educando =         $this->somar_educando (     $educando,          $this->educando($item->id)          );
            $instituicao =      $this->somar_instituicao (  $instituicao,       $this->instituicao($item->id)       );
            $organizacao =      $this->somar_organizacao (  $organizacao,       $this->organizacao($item->id)       );
            $parceiro =         $this->somar_parceiro (     $parceiro,          $this->parceiro($item->id)          );
        }

        $valores['caracterizacao'] = $caracterizacao;
        $valores['professor'] = $professor;
        $valores['educando'] = $educando;
        $valores['instituicao'] = $instituicao;
        $valores['organizacao'] = $organizacao;
        $valores['parceiro'] = $parceiro;
        
        $html = $this->load->view('relatorio/estatistico/relatorio', $valores, true); 
        $pdf->WriteHTML($html); 
        
        // Param    I -> See on the browser         //          D -> Download File         //           F -> Save on the server
        $pdf->Output($pdfFilePath, 'I');         
    }

    function curso()
    {
        $curso_id = $this->uri->segment(3);

        $this->load->model('requisicao_m');
        $curso_nome = $this->requisicao_m->get_cursos_nome($curso_id);

        $this->load->library('pdf');            
        $pdf = $this->pdf->load(); 
        $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   '); 
        
        $data['titulo_relatorio'] = 'Relatório Estatístico por Curso<br><br><b>Curso:</b> '.$curso_nome;
        $html = $this->load->view('include/header_pdf', $data, true); 

        $pdf->WriteHTML($html);

        $caracterizacao = $this->caracterizacao($curso_id);
        $professor = $this->professor($curso_id);
        $educando = $this->educando($curso_id);
        $instituicao = $this->instituicao($curso_id);
        $organizacao = $this->organizacao($curso_id);
        $parceiro = $this->parceiro($curso_id);

        $valores['caracterizacao'] = $caracterizacao;
        $valores['professor'] = $professor;
        $valores['educando'] = $educando;
        $valores['instituicao'] = $instituicao;
        $valores['organizacao'] = $organizacao;
        $valores['parceiro'] = $parceiro;
        
        $html = $this->load->view('relatorio/estatistico/relatorio', $valores, true); 
        $pdf->WriteHTML($html); 
        
        // Param    I -> See on the browser         //          D -> Download File         //           F -> Save on the server
        $pdf->Output($pdfFilePath, 'I');         
    }

    function modalidade()
    {
        $super_id = $this->uri->segment(3);
        $modalidade = $this->uri->segment(4);

        $this->load->model('requisicao_m');

        $nome_super = $this->requisicao_m->get_superintendencias_nome(1, $super_id);
        $nome_modalidade = $this->requisicao_m->get_modalidade_nome($modalidade);

        $this->load->library('pdf');            
        $pdf = $this->pdf->load(); 
        $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   '); 
        
        $data['titulo_relatorio'] = 'Relatório Estatístico por Modalidade<br><br> <b>Superintendência:</b> '.$nome_super.' - <b>Modalidade:</b> '.$nome_modalidade;
        $html = $this->load->view('include/header_pdf', $data, true); 

        $pdf->WriteHTML($html);

        $this->db->select('c.id');
        $this->db->from('curso c');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id_modalidade', $modalidade);
        $this->db->where('c.id_superintendencia', $super_id);
        $query = $this->db->get();

        $dados = $query->result();

        $caracterizacao = array();
        $professor = array();
        $educando = array();
        $instituicao = array();
        $organizacao = array();
        $parceiro = array();

        foreach ($dados as $item) {
            $caracterizacao =   $this->somar_caracterizacao($caracterizacao,    $this->caracterizacao($item->id)    );
            $professor =        $this->somar_professor (    $professor,         $this->professor($item->id)         );
            $educando =         $this->somar_educando (     $educando,          $this->educando($item->id)          );
            $instituicao =      $this->somar_instituicao (  $instituicao,       $this->instituicao($item->id)       );
            $organizacao =      $this->somar_organizacao (  $organizacao,       $this->organizacao($item->id)       );
            $parceiro =         $this->somar_parceiro (     $parceiro,          $this->parceiro($item->id)          );
        }

        $valores['caracterizacao'] = $caracterizacao;
        $valores['professor'] = $professor;
        $valores['educando'] = $educando;
        $valores['instituicao'] = $instituicao;
        $valores['organizacao'] = $organizacao;
        $valores['parceiro'] = $parceiro;
        
        $html = $this->load->view('relatorio/estatistico/relatorio', $valores, true); 
        $pdf->WriteHTML($html); 
        
        // Param    I -> See on the browser         //          D -> Download File         //           F -> Save on the server
        $pdf->Output($pdfFilePath, 'I');          
    }

    function caracterizacao ($curso)
    {
        $resultado = array();

        $this->db->select('count(ca.id) as total');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['total_ca'] = $data[0]->total;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.area_conhecimento IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['area_np'] = $data[0]->num;

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.area_conhecimento', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['area_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.area_conhecimento IS NOT NULL', null);
        $this->db->where('ca.area_conhecimento <>', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['area_p'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.nome_coordenador_geral IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['coordgeral_np'] = $data[0]->num;

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.nome_coordenador_geral', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['coordgeral_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.nome_coordenador_geral IS NOT NULL', null);
        $this->db->where('ca.nome_coordenador_geral <>', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['coordgeral_p'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.titulacao_coordenador_geral IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['tit_coordgeral_np'] = $data[0]->num;

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.titulacao_coordenador_geral', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['tit_coordgeral_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.titulacao_coordenador_geral IS NOT NULL', null);
        $this->db->where('ca.titulacao_coordenador_geral <>', '');
        $this->db->where('ca.titulacao_coordenador_geral <>', 'NAOINFORMADO');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['tit_coordgeral_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.titulacao_coordenador_geral', 'NAOINFORMADO');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['tit_coordgeral_ni'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.nome_coordenador IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['coordproj_np'] = $data[0]->num;

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.nome_coordenador', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['coordproj_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.nome_coordenador IS NOT NULL', null);
        $this->db->where('ca.nome_coordenador <>', '');
        $this->db->where('ca.nome_coordenador <>', 'NAOAPLICA');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['coordproj_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.nome_coordenador', 'NAOAPLICA');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['coordproj_na'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.titulacao_coordenador IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['tit_coordprojeto_np'] = $data[0]->num;

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.titulacao_coordenador', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['tit_coordprojeto_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.titulacao_coordenador IS NOT NULL', null);
        $this->db->where('ca.titulacao_coordenador <>', '');
        $this->db->where('ca.titulacao_coordenador <>', 'NAOAPLICA');
        $this->db->where('ca.titulacao_coordenador <>', 'NAOINFORMADO');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['tit_coordprojeto_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.titulacao_coordenador', 'NAOINFORMADO');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['tit_coordprojeto_ni'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.titulacao_coordenador', 'NAOAPLICA');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['tit_coordprojeto_na'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.nome_vice_coordenador IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['vicecoordproj_np'] = $data[0]->num;

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.nome_vice_coordenador', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['vicecoordproj_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.nome_vice_coordenador IS NOT NULL', null);
        $this->db->where('ca.nome_vice_coordenador <>', '');
        $this->db->where('ca.nome_vice_coordenador <>', 'NAOAPLICA');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['vicecoordproj_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.nome_vice_coordenador', 'NAOAPLICA');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['vicecoordproj_na'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.titulacao_vice_coordenador IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['tit_vicecoordprojeto_np'] = $data[0]->num;

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.titulacao_vice_coordenador', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['tit_vicecoordprojeto_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.titulacao_vice_coordenador IS NOT NULL', null);
        $this->db->where('ca.titulacao_vice_coordenador <>', '');
        $this->db->where('ca.titulacao_vice_coordenador <>', 'NAOAPLICA');
        $this->db->where('ca.titulacao_vice_coordenador <>', 'NAOINFORMADO');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['tit_vicecoordprojeto_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.titulacao_vice_coordenador', 'NAOINFORMADO');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['tit_vicecoordprojeto_ni'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.titulacao_vice_coordenador', 'NAOAPLICA');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['tit_vicecoordprojeto_na'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.nome_coordenador_pedagogico IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['coordproj_pedag_np'] = $data[0]->num;

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.nome_coordenador_pedagogico', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['coordproj_pedag_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.nome_coordenador_pedagogico IS NOT NULL', null);
        $this->db->where('ca.nome_coordenador_pedagogico <>', '');
        $this->db->where('ca.nome_coordenador_pedagogico <>', 'NAOAPLICA');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['coordproj_pedag_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.nome_coordenador_pedagogico', 'NAOAPLICA');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['coordproj_pedag_na'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.titulacao_coordenador_pedagogico IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['tit_coordproj_pedag_np'] = $data[0]->num;

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.titulacao_coordenador_pedagogico', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['tit_coordproj_pedag_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.titulacao_coordenador_pedagogico IS NOT NULL', null);
        $this->db->where('ca.titulacao_coordenador_pedagogico <>', '');
        $this->db->where('ca.titulacao_coordenador_pedagogico <>', 'NAOAPLICA');
        $this->db->where('ca.titulacao_coordenador_pedagogico <>', 'NAOINFORMADO');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['tit_coordproj_pedag_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.titulacao_coordenador_pedagogico', 'NAOINFORMADO');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['tit_coordproj_pedag_ni'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.titulacao_coordenador_pedagogico', 'NAOAPLICA');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['tit_coordproj_pedag_na'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.duracao_curso IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['duracao_np'] = $data[0]->num;

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.duracao_curso', '');
        $this->db->where('ca.duracao_curso IS NOT NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['duracao_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.duracao_curso IS NOT NULL', null);
        $this->db->where('ca.duracao_curso <>', '');
        $this->db->where('ca.duracao_curso <>', -1);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['duracao_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.duracao_curso', -1);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['duracao_ni'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.inicio_previsto IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['ini_previsto_np'] = $data[0]->num;

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.inicio_previsto', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['ini_previsto_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.inicio_previsto IS NOT NULL', null);
        $this->db->where('ca.inicio_previsto <>', '');
        $this->db->where('ca.inicio_previsto <>', 'NI');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['ini_previsto_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.inicio_previsto', 'NI');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['ini_previsto_ni'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.termino_previsto IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['ter_previsto_np'] = $data[0]->num;

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.termino_previsto', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['ter_previsto_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.termino_previsto IS NOT NULL', null);
        $this->db->where('ca.termino_previsto <>', '');
        $this->db->where('ca.termino_previsto <>', 'NI');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['ter_previsto_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.termino_previsto', 'NI');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['ter_previsto_ni'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.inicio_realizado IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['ini_realizado_np'] = $data[0]->num;

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.inicio_realizado', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['ini_realizado_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.inicio_realizado IS NOT NULL', null);
        $this->db->where('ca.inicio_realizado <>', '');
        $this->db->where('ca.inicio_realizado <>', 'NI');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['ini_realizado_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.inicio_realizado', 'NI');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['ini_realizado_ni'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.termino_realizado IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['ter_realizado_np'] = $data[0]->num;

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.termino_realizado', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['ter_realizado_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.termino_realizado IS NOT NULL', null);
        $this->db->where('ca.termino_realizado <>', '');
        $this->db->where('ca.termino_realizado <>', 'NI');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['ter_realizado_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.termino_realizado', 'NI');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['ter_realizado_ni'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.numero_turmas IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['num_turmas_np'] = $data[0]->num;

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.numero_turmas', '');
        $this->db->where('ca.numero_turmas IS NOT NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['num_turmas_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.numero_turmas IS NOT NULL', null);
        $this->db->where('ca.numero_turmas <>', '');
        $this->db->where('ca.numero_turmas <>', -1);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['num_turmas_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.numero_turmas', -1);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['num_turmas_ni'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.numero_ingressantes IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['num_ingressantes_np'] = $data[0]->num;

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.numero_ingressantes', '');
        $this->db->where('ca.numero_ingressantes IS NOT NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['num_ingressantes_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.numero_ingressantes IS NOT NULL', null);
        $this->db->where('ca.numero_ingressantes <>', '');
        $this->db->where('ca.numero_ingressantes <>', -1);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['num_ingressantes_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.numero_ingressantes', -1);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['num_ingressantes_ni'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.numero_concluintes IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['num_concluintes_np'] = $data[0]->num;

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.numero_concluintes', '');
        $this->db->where('ca.numero_concluintes IS NOT NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['num_concluintes_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.numero_concluintes IS NOT NULL', null);
        $this->db->where('ca.numero_concluintes <>', '');
        $this->db->where('ca.numero_concluintes <>', -1);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['num_concluintes_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.numero_concluintes', -1);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['num_concluintes_ni'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.id NOT IN (select distinct id_caracterizacao from caracterizacao_cidade)',NULL,FALSE);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['municipio_np'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.id IN (select distinct id_caracterizacao from caracterizacao_cidade)',NULL,FALSE);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['municipio_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $resultado['municipio_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.impedimento_curso IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['impedimento_np'] = $data[0]->num;

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.impedimento_curso', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['impedimento_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.impedimento_curso IS NOT NULL', null);
        $this->db->where('ca.impedimento_curso <>', '');
        $this->db->where('ca.impedimento_curso <>', "NI");
        $query = $this->db->get();
        $data = $query->result();
        $resultado['impedimento_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.impedimento_curso', "NI");
        $query = $this->db->get();
        $data = $query->result();
        $resultado['impedimento_ni'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.referencia_curso IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['referencia_np'] = $data[0]->num;

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.referencia_curso', '');
        $this->db->where('ca.referencia_curso IS NOT NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['referencia_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.referencia_curso IS NOT NULL', null);
        $this->db->where('ca.referencia_curso <>', '');
        $this->db->where('ca.referencia_curso <>', -1);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['referencia_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.referencia_curso', -1);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['referencia_ni'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.matriz_curricular_curso IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['matriz_curricular_np'] = $data[0]->num;

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.matriz_curricular_curso', '');
        $this->db->where('ca.matriz_curricular_curso IS NOT NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['matriz_curricular_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.matriz_curricular_curso IS NOT NULL', null);
        $this->db->where('ca.matriz_curricular_curso <>', '');
        $this->db->where('ca.matriz_curricular_curso <>', -1);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['matriz_curricular_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.matriz_curricular_curso', -1);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['matriz_curricular_ni'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.desdobramento IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['desdobramento_np'] = $data[0]->num;

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.desdobramento', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['desdobramento_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.desdobramento IS NOT NULL', null);
        $this->db->where('ca.desdobramento <>', '');
        $this->db->where('ca.desdobramento <>', 'NI');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['desdobramento_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.desdobramento', 'NI');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['desdobramento_ni'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.documentos_normativos IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['documento_np'] = $data[0]->num;

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.documentos_normativos', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['documento_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.documentos_normativos IS NOT NULL', null);
        $this->db->where('ca.documentos_normativos <>', '');
        $this->db->where('ca.documentos_normativos <>', 'NI');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['documento_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.documentos_normativos', 'NI');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['documento_ni'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.espaco_especifico IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['espaco_np'] = $data[0]->num;

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.espaco_especifico', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['espaco_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.espaco_especifico IS NOT NULL', null);
        $this->db->where('ca.espaco_especifico <>', '');
        $this->db->where('ca.espaco_especifico <>', 'NI');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['espaco_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.espaco_especifico', 'NI');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['espaco_ni'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.avaliacao_mec IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['avaliacao_np'] = $data[0]->num;

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.avaliacao_mec', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['avaliacao_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.avaliacao_mec IS NOT NULL', null);
        $this->db->where('ca.avaliacao_mec <>', '');
        $this->db->where('ca.avaliacao_mec <>', 'NI');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['avaliacao_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.avaliacao_mec', 'NI');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['avaliacao_ni'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.numero_bolsistas IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['num_bolsistas_np'] = $data[0]->num;

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.numero_bolsistas', '');
        $this->db->where('ca.numero_bolsistas IS NOT NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['num_bolsistas_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.numero_bolsistas IS NOT NULL', null);
        $this->db->where('ca.numero_bolsistas <>', '');
        $this->db->where('ca.numero_bolsistas <>', -1);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['num_bolsistas_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ca.id) as num');
        $this->db->from('caracterizacao ca');
        $this->db->join('curso c', 'c.id = ca.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ca.numero_bolsistas', -1);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['num_bolsistas_ni'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++    

        
        return $resultado;
    }

    function somar_caracterizacao ($array1, $array2)
    {
        $resultado = $array2;

        $resultado['total_ca'] += $array1['total_ca'];
        $resultado['area_np'] += $array1['area_np'];
        $resultado['area_p'] += $array1['area_p'];
        $resultado['coordgeral_np'] += $array1['coordgeral_np'];
        $resultado['coordgeral_p'] += $array1['coordgeral_p'];
        $resultado['tit_coordgeral_np'] += $array1['tit_coordgeral_np'];
        $resultado['tit_coordgeral_p'] += $array1['tit_coordgeral_p'];
        $resultado['tit_coordgeral_ni'] += $array1['tit_coordgeral_ni'];
        $resultado['coordproj_np'] += $array1['coordproj_np'];
        $resultado['coordproj_p'] += $array1['coordproj_p'];
        $resultado['coordproj_na'] += $array1['coordproj_na'];
        $resultado['tit_coordprojeto_np'] += $array1['tit_coordprojeto_np'];
        $resultado['tit_coordprojeto_p'] += $array1['tit_coordprojeto_p'];
        $resultado['tit_coordprojeto_ni'] += $array1['tit_coordprojeto_ni'];
        $resultado['tit_coordprojeto_na'] += $array1['tit_coordprojeto_na'];
        $resultado['vicecoordproj_np'] += $array1['vicecoordproj_np'];
        $resultado['vicecoordproj_p'] += $array1['vicecoordproj_p'];
        $resultado['vicecoordproj_na'] += $array1['vicecoordproj_na'];
        $resultado['tit_vicecoordprojeto_np'] += $array1['tit_vicecoordprojeto_np'];
        $resultado['tit_vicecoordprojeto_p'] += $array1['tit_vicecoordprojeto_p'];
        $resultado['tit_vicecoordprojeto_ni'] += $array1['tit_vicecoordprojeto_ni'];
        $resultado['tit_vicecoordprojeto_na'] += $array1['tit_vicecoordprojeto_na'];
        $resultado['coordproj_pedag_np'] += $array1['coordproj_pedag_np'];
        $resultado['coordproj_pedag_p'] += $array1['coordproj_pedag_p'];
        $resultado['coordproj_pedag_na'] += $array1['coordproj_pedag_na'];
        $resultado['tit_coordproj_pedag_np'] += $array1['tit_coordproj_pedag_np'];
        $resultado['tit_coordproj_pedag_p'] += $array1['tit_coordproj_pedag_p'];
        $resultado['tit_coordproj_pedag_ni'] += $array1['tit_coordproj_pedag_ni'];
        $resultado['tit_coordproj_pedag_na'] += $array1['tit_coordproj_pedag_na'];
        $resultado['duracao_np'] += $array1['duracao_np'];
        $resultado['duracao_p'] += $array1['duracao_p'];
        $resultado['duracao_ni'] += $array1['duracao_ni'];
        $resultado['ini_previsto_np'] += $array1['ini_previsto_np'];
        $resultado['ini_previsto_p'] += $array1['ini_previsto_p'];
        $resultado['ini_previsto_ni'] += $array1['ini_previsto_ni'];
        $resultado['ter_previsto_np'] += $array1['ter_previsto_np'];
        $resultado['ter_previsto_p'] += $array1['ter_previsto_p'];
        $resultado['ter_previsto_ni'] += $array1['ter_previsto_ni'];
        $resultado['ini_realizado_np'] += $array1['ini_realizado_np'];
        $resultado['ini_realizado_p'] += $array1['ini_realizado_p'];
        $resultado['ini_realizado_ni'] += $array1['ini_realizado_ni'];
        $resultado['ter_realizado_np'] += $array1['ter_realizado_np'];
        $resultado['ter_realizado_p'] += $array1['ter_realizado_p'];
        $resultado['ter_realizado_ni'] += $array1['ter_realizado_ni'];
        $resultado['num_turmas_np'] += $array1['num_turmas_np'];
        $resultado['num_turmas_p'] += $array1['num_turmas_p'];
        $resultado['num_turmas_ni'] += $array1['num_turmas_ni'];
        $resultado['num_ingressantes_np'] += $array1['num_ingressantes_np'];
        $resultado['num_ingressantes_p'] += $array1['num_ingressantes_p'];
        $resultado['num_ingressantes_ni'] += $array1['num_ingressantes_ni'];
        $resultado['num_concluintes_np'] += $array1['num_concluintes_np'];
        $resultado['num_concluintes_p'] += $array1['num_concluintes_p'];
        $resultado['num_concluintes_ni'] += $array1['num_concluintes_ni'];
        $resultado['municipio_np'] += $array1['municipio_np'];
        $resultado['municipio_p'] += $array1['municipio_p'];
        $resultado['municipio_ni'] += $array1['municipio_ni'];
        $resultado['impedimento_np'] += $array1['impedimento_np'];
        $resultado['impedimento_p'] += $array1['impedimento_p'];
        $resultado['impedimento_ni'] += $array1['impedimento_ni'];
        $resultado['referencia_np'] += $array1['referencia_np'];
        $resultado['referencia_p'] += $array1['referencia_p'];
        $resultado['referencia_ni'] += $array1['referencia_ni'];
        $resultado['matriz_curricular_np'] += $array1['matriz_curricular_np'];
        $resultado['matriz_curricular_p'] += $array1['matriz_curricular_p'];
        $resultado['matriz_curricular_ni'] += $array1['matriz_curricular_ni'];
        $resultado['desdobramento_np'] += $array1['desdobramento_np'];
        $resultado['desdobramento_p'] += $array1['desdobramento_p'];
        $resultado['desdobramento_ni'] += $array1['desdobramento_ni'];
        $resultado['documento_np'] += $array1['documento_np'];
        $resultado['documento_p'] += $array1['documento_p'];
        $resultado['documento_ni'] += $array1['documento_ni'];
        $resultado['espaco_np'] += $array1['espaco_np'];
        $resultado['espaco_p'] += $array1['espaco_p'];
        $resultado['espaco_ni'] += $array1['espaco_ni'];
        $resultado['avaliacao_np'] += $array1['avaliacao_np'];
        $resultado['avaliacao_p'] += $array1['avaliacao_p'];
        $resultado['avaliacao_ni'] += $array1['avaliacao_ni'];
        $resultado['num_bolsistas_np'] += $array1['num_bolsistas_np'];
        $resultado['num_bolsistas_p'] += $array1['num_bolsistas_p'];
        $resultado['num_bolsistas_ni'] += $array1['num_bolsistas_ni'];
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++    

        
        return $resultado;
    }

    function professor ($curso)
    {
        $resultado = array();

        $this->db->select('count(p.id) as total');
        $this->db->from('professor p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['total_p'] = $data[0]->total;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(p.id) as num');
        $this->db->from('professor p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.nome IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['nome_np'] = $data[0]->num;

        $this->db->select('count(p.id) as num');
        $this->db->from('professor p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.nome', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['nome_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(p.id) as num');
        $this->db->from('professor p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.nome IS NOT NULL', null);
        $this->db->where('p.nome <>', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['nome_p'] = $data[0]->num;
        //-----------------------------------------------------------------
        $resultado['nome_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(p.id) as num');
        $this->db->from('professor p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.cpf IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['cpf_np'] = $data[0]->num;

        $this->db->select('count(p.id) as num');
        $this->db->from('professor p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.cpf', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['cpf_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(p.id) as num');
        $this->db->from('professor p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.cpf IS NOT NULL', null);
        $this->db->where('p.cpf <>', '');
        $this->db->where('p.cpf <>', 'NAOINFORMADO');
        $this->db->where('p.cpf <>', 'NAOAPLICA');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['cpf_p'] = $data[0]->num;
        //-----------------------------------------------------------------  

        $this->db->select('count(p.id) as num');
        $this->db->from('professor p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.cpf', 'NAOAPLICA');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['cpf_na'] = $data[0]->num;
        //-----------------------------------------------------------------  

        $this->db->select('count(p.id) as num');
        $this->db->from('professor p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.cpf', 'NAOINFORMADO');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['cpf_ni'] = $data[0]->num;       
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(p.id) as num');
        $this->db->from('professor p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.rg IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['rg_np'] = $data[0]->num;

        $this->db->select('count(p.id) as num');
        $this->db->from('professor p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.rg', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['rg_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(p.id) as num');
        $this->db->from('professor p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.rg IS NOT NULL', null);
        $this->db->where('p.rg <>', '');
        $this->db->where('p.rg <>', 'NAOINFORMADO');
        $this->db->where('p.rg <>', 'NAOAPLICA');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['rg_p'] = $data[0]->num;
        //-----------------------------------------------------------------  

        $this->db->select('count(p.id) as num');
        $this->db->from('professor p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.rg', 'NAOAPLICA');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['rg_na'] = $data[0]->num;
        //-----------------------------------------------------------------  

        $this->db->select('count(p.id) as num');
        $this->db->from('professor p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.rg', 'NAOINFORMADO');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['rg_ni'] = $data[0]->num;       
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(p.id) as num');
        $this->db->from('professor p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.disciplina_ni', 0);
        $this->db->where('p.id NOT IN (select id_professor from disciplina where id_curso = '. $curso.')',NULL,FALSE);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['disciplina_np'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(p.id) as num');
        $this->db->from('professor p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.disciplina_ni', 0);
        $this->db->where('p.id IN (select id_professor from disciplina where id_curso = '. $curso.')',NULL,FALSE);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['disciplina_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(p.id) as num');
        $this->db->from('professor p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('p.disciplina_ni', 1);
        $this->db->where('c.id', $curso);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['disciplina_ni'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(p.id) as num');
        $this->db->from('professor p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.genero', 0);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['sexo_np'] = $data[0]->num;
        //-----------------------------------------------------------------
        $opcao  = array( "1", "2" );

        $this->db->select('count(p.id) as num');
        $this->db->from('professor p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where_in('p.genero', $opcao);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['sexo_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(p.id) as num');
        $this->db->from('professor p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.genero', -1);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['sexo_ni'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(p.id) as num');
        $this->db->from('professor p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.titulacao IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['titulacao_np'] = $data[0]->num;

        $this->db->select('count(p.id) as num');
        $this->db->from('professor p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.titulacao', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['titulacao_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(p.id) as num');
        $this->db->from('professor p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.titulacao IS NOT NULL', null);
        $this->db->where('p.titulacao <>', '');
        $this->db->where('p.titulacao <>', 'NAOINFORMADO');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['titulacao_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(p.id) as num');
        $this->db->from('professor p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.titulacao', 'NAOINFORMADO');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['titulacao_ni'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        
        return $resultado;
    }

    function somar_professor ($array1, $array2)
    {
        $resultado = $array2;

        $resultado['total_p'] += $array1['total_p'];
        $resultado['nome_np'] += $array1['nome_np'];
        $resultado['nome_p'] += $array1['nome_p'];
        $resultado['nome_ni'] += $array1['nome_ni'];
        $resultado['cpf_np'] += $array1['cpf_np'];
        $resultado['cpf_p'] += $array1['cpf_p'];
        $resultado['cpf_ni'] += $array1['cpf_ni'];
        $resultado['cpf_na'] += $array1['cpf_na'];
        $resultado['rg_np'] += $array1['rg_np'];
        $resultado['rg_p'] += $array1['rg_p'];
        $resultado['rg_ni'] += $array1['rg_ni'];
        $resultado['rg_na'] += $array1['rg_na'];
        $resultado['disciplina_np'] += $array1['disciplina_np'];
        $resultado['disciplina_p'] += $array1['disciplina_p'];
        $resultado['disciplina_ni'] += $array1['disciplina_ni'];
        $resultado['sexo_np'] += $array1['sexo_np'];
        $resultado['sexo_p'] += $array1['sexo_p'];
        $resultado['sexo_ni'] += $array1['sexo_ni'];
        $resultado['titulacao_np'] += $array1['titulacao_np'];
        $resultado['titulacao_p'] += $array1['titulacao_p'];
        $resultado['titulacao_ni'] += $array1['titulacao_ni'];
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        
        return $resultado;
    }

    function educando  ($curso)
    {
        $resultado = array();

        $this->db->select('count(e.id) as total');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['total_p'] = $data[0]->total;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(e.id) as num');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('e.nome IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['nome_np'] = $data[0]->num;

        $this->db->select('count(e.id) as num');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('e.nome', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['nome_np'] += $data[0]->num;
        //-----------------------------------------------------------------
        $opcao  = array( "0", "-1" );

        $this->db->select('count(e.id) as num');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('e.nome <>', '');
        $this->db->where('e.nome IS NOT NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['nome_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $resultado['nome_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(e.id) as num');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('e.cpf IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['cpf_np'] = $data[0]->num;

        $this->db->select('count(e.id) as num');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('e.cpf', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['cpf_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(e.id) as num');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('e.cpf IS NOT NULL', null);
        $this->db->where('e.cpf <>', '');
        $this->db->where('e.cpf <>', 'NAOINFORMADO');
        $this->db->where('e.cpf <>', 'NAOAPLICA');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['cpf_p'] = $data[0]->num;
        //-----------------------------------------------------------------  

        $this->db->select('count(e.id) as num');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('e.cpf', 'NAOAPLICA');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['cpf_na'] = $data[0]->num;
        //-----------------------------------------------------------------  

        $this->db->select('count(e.id) as num');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('e.cpf', 'NAOINFORMADO');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['cpf_ni'] = $data[0]->num;       
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(e.id) as num');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('e.rg IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['rg_np'] = $data[0]->num;

        $this->db->select('count(e.id) as num');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('e.rg', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['rg_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(e.id) as num');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('e.rg IS NOT NULL', null);
        $this->db->where('e.rg <>', '');
        $this->db->where('e.rg <>', 'NAOINFORMADO');
        $this->db->where('e.rg <>', 'NAOAPLICA');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['rg_p'] = $data[0]->num;
        //-----------------------------------------------------------------  

        $this->db->select('count(e.id) as num');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('e.rg', 'NAOAPLICA');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['rg_na'] = $data[0]->num;
        //-----------------------------------------------------------------  

        $this->db->select('count(e.id) as num');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('e.rg', 'NAOINFORMADO');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['rg_ni'] = $data[0]->num;       
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $opcao  = array( "-1",  "0", "1" );

        $this->db->select('count(e.id) as num');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where_not_in('e.genero', $opcao);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['sexo_np'] = $data[0]->num;
        //-----------------------------------------------------------------
        $opcao  = array( "0", "1" );

        $this->db->select('count(e.id) as num');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where_in('e.genero', $opcao);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['sexo_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(e.id) as num');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('e.genero', -1);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['sexo_ni'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(e.id) as num');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('e.data_nascimento', '00/00/0000');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['datanasc_np'] = $data[0]->num;
        //-----------------------------------------------------------------
        $opcao  = array( "1", "2" );

        $this->db->select('count(e.id) as num');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('e.data_nascimento <>', '01/01/1900');
        $this->db->where('e.data_nascimento <>', '00/00/0000');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['datanasc_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(e.id) as num');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('e.data_nascimento', '01/01/1900');
        $this->db->where('c.id', $curso);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['datanasc_ni'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(e.id) as num');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('e.idade', 0);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['idade_np'] = $data[0]->num;
        //-----------------------------------------------------------------
        $opcao  = array( "0", "-1" );

        $this->db->select('count(e.id) as num');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where_not_in('e.idade', $opcao);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['idade_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(e.id) as num');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('e.idade', -1);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['idade_ni'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(e.id) as num');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('e.tipo_territorio IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['tipo_as_np'] = $data[0]->num;

        $this->db->select('count(e.id) as num');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('e.tipo_territorio', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['tipo_as_np'] += $data[0]->num;
        //-----------------------------------------------------------------
        $opcao  = array( "0", "-1" );

        $this->db->select('count(e.id) as num');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('e.tipo_territorio <>', '');
        $this->db->where('e.tipo_territorio IS NOT NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['tipo_as_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $resultado['tipo_as_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(e.id) as num');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('e.nome_territorio IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['nome_territorio_np'] = $data[0]->num;

        $this->db->select('count(e.id) as num');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('e.nome_territorio', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['nome_territorio_np'] += $data[0]->num;
        //-----------------------------------------------------------------
        $opcao  = array( "0", "-1" );

        $this->db->select('count(e.id) as num');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('e.nome_territorio <>', '');
        $this->db->where('e.nome_territorio IS NOT NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['nome_territorio_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $resultado['nome_territorio_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(e.id) as num');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('e.id NOT IN (select distinct id_educando from educando_cidade)',NULL,FALSE);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['municipio_np'] = $data[0]->num;
        //-----------------------------------------------------------------
        $opcao  = array( "1", "2" );

        $this->db->select('count(e.id) as num');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('e.id IN (select distinct id_educando from educando_cidade)',NULL,FALSE);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['municipio_p'] = $data[0]->num;
        //-----------------------------------------------------------------
        $resultado['municipio_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $opcao  = array( "-1",  "0", "1" );

        $this->db->select('count(e.id) as num');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where_not_in('e.genero', $opcao);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['concluinte_np'] = $data[0]->num;
        //-----------------------------------------------------------------
        $opcao  = array( "0", "1" );

        $this->db->select('count(e.id) as num');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where_in('e.genero', $opcao);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['concluinte_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(e.id) as num');
        $this->db->from('educando e');
        $this->db->join('curso c', 'c.id = e.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('e.genero', -1);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['concluinte_ni'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        
        return $resultado;
    }

    function somar_educando  ($array1, $array2)
    {
        $resultado = $array2;

        $resultado['total_p'] += $array1['total_p'];
        $resultado['nome_np'] += $array1['nome_np'];
        $resultado['nome_p'] += $array1['nome_p'];
        $resultado['sexo_np'] += $array1['sexo_np'];
        $resultado['sexo_p'] += $array1['sexo_p'];
        $resultado['sexo_ni'] += $array1['sexo_ni'];
        $resultado['cpf_np'] += $array1['cpf_np'];
        $resultado['cpf_p'] += $array1['cpf_p'];
        $resultado['cpf_ni'] += $array1['cpf_ni'];
        $resultado['cpf_na'] += $array1['cpf_na'];
        $resultado['rg_np'] += $array1['rg_np'];
        $resultado['rg_p'] += $array1['rg_p'];
        $resultado['rg_ni'] += $array1['rg_ni'];
        $resultado['rg_na'] += $array1['rg_na'];
        $resultado['datanasc_np'] += $array1['datanasc_np'];
        $resultado['datanasc_p'] += $array1['datanasc_p'];
        $resultado['datanasc_ni'] += $array1['datanasc_ni'];
        $resultado['idade_np'] += $array1['idade_np'];
        $resultado['idade_p'] += $array1['idade_p'];
        $resultado['idade_ni'] += $array1['idade_ni'];
        $resultado['tipo_as_np'] += $array1['tipo_as_np'];
        $resultado['tipo_as_p'] += $array1['tipo_as_p'];
        $resultado['nome_territorio_np'] += $array1['nome_territorio_np'];
        $resultado['nome_territorio_p'] += $array1['nome_territorio_p'];
        $resultado['municipio_np'] += $array1['municipio_np'];
        $resultado['municipio_p'] += $array1['municipio_p'];
        $resultado['concluinte_np'] += $array1['concluinte_np'];
        $resultado['concluinte_p'] += $array1['concluinte_p'];
        $resultado['concluinte_ni'] += $array1['concluinte_ni'];
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        
        return $resultado;
    }

    function instituicao ($curso)
    {
        $resultado = array();

        $this->db->select('count(ie.id) as total');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['total_p'] = $data[0]->total;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.nome IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['nome_np'] = $data[0]->num;

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.nome', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['nome_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.nome IS NOT NULL', null);
        $this->db->where('ie.nome <>', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['nome_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $resultado['nome_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.sigla IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['sigla_np'] = $data[0]->num;

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.sigla', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['sigla_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.sigla IS NOT NULL', null);
        $this->db->where('ie.sigla <>', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['sigla_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $resultado['sigla_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.unidade IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['unidade_np'] = $data[0]->num;

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.unidade', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['unidade_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.unidade IS NOT NULL', null);
        $this->db->where('ie.unidade <>', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['unidade_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $resultado['unidade_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.departamento IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['departamento_np'] = $data[0]->num;

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.departamento', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['departamento_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.departamento IS NOT NULL', null);
        $this->db->where('ie.departamento <>', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['departamento_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $resultado['departamento_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.rua IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['rua_np'] = $data[0]->num;

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.rua', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['rua_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.rua IS NOT NULL', null);
        $this->db->where('ie.rua <>', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['rua_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $resultado['rua_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.numero IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['numero_np'] = $data[0]->num;

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.numero', '');
        $this->db->where('ie.numero IS NOT NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['numero_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.numero IS NOT NULL', null);
        $this->db->where('ie.numero <>', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['numero_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $resultado['numero_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.complemento IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['complemento_np'] = $data[0]->num;

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.complemento', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['complemento_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.complemento IS NOT NULL', null);
        $this->db->where('ie.complemento <>', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['complemento_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $resultado['complemento_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.bairro IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['bairro_np'] = $data[0]->num;

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.bairro', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['bairro_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.bairro IS NOT NULL', null);
        $this->db->where('ie.bairro <>', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['bairro_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $resultado['bairro_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.cep IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['cep_np'] = $data[0]->num;

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.cep', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['cep_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.cep IS NOT NULL', null);
        $this->db->where('ie.cep <>', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['cep_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $resultado['cep_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.id_cidade IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['cidade_np'] = $data[0]->num;

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.id_cidade', '');
        $this->db->where('ie.id_cidade IS NOT NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['cidade_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.id_cidade IS NOT NULL', null);
        $this->db->where('ie.id_cidade <>', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['cidade_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $resultado['cidade_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.telefone1 IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['telefone1_np'] = $data[0]->num;

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.telefone1', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['telefone1_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.telefone1 IS NOT NULL', null);
        $this->db->where('ie.telefone1 <>', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['telefone1_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $resultado['telefone1_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.telefone2 IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['telefone2_np'] = $data[0]->num;

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.telefone2', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['telefone2_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.telefone2 IS NOT NULL', null);
        $this->db->where('ie.telefone2 <>', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['telefone2_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $resultado['telefone2_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.pagina_web IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['pagina_web_np'] = $data[0]->num;

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.pagina_web', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['pagina_web_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.pagina_web IS NOT NULL', null);
        $this->db->where('ie.pagina_web <>', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['pagina_web_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $resultado['pagina_web_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.campus IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['campus_np'] = $data[0]->num;

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.campus', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['campus_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.campus IS NOT NULL', null);
        $this->db->where('ie.campus <>', '');
        $this->db->where('ie.campus <>', 'NAOINFORMADO');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['campus_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.campus', 'NAOINFORMADO');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['campus_ni'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.natureza_instituicao IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['natureza_np'] = $data[0]->num;

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.natureza_instituicao', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['natureza_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(ie.id) as num');
        $this->db->from('instituicao_ensino ie');
        $this->db->join('curso c', 'c.id = ie.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('ie.natureza_instituicao IS NOT NULL', null);
        $this->db->where('ie.natureza_instituicao <>', '');
        $this->db->where('ie.natureza_instituicao <>', 'NAOINFORMADO');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['natureza_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $resultado['natureza_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        
        return $resultado;
    }

    function somar_instituicao  ($array1, $array2)
    {
        $resultado =  $array2;

        $resultado['total_p'] += $array1['total_p'];
        $resultado['nome_np'] += $array1['nome_np'];
        $resultado['nome_p'] += $array1['nome_p'];
        $resultado['sigla_np'] += $array1['sigla_np'];
        $resultado['sigla_p'] += $array1['sigla_p'];
        $resultado['unidade_np'] += $array1['unidade_np'];
        $resultado['unidade_p'] += $array1['unidade_p'];
        $resultado['departamento_np'] += $array1['departamento_np'];
        $resultado['departamento_p'] += $array1['departamento_p'];
        $resultado['rua_np'] += $array1['rua_np'];
        $resultado['rua_p'] += $array1['rua_p'];
        $resultado['numero_np'] += $array1['numero_np'];
        $resultado['numero_p'] += $array1['numero_p'];
        $resultado['complemento_np'] += $array1['complemento_np'];
        $resultado['complemento_p'] += $array1['complemento_p'];
        $resultado['bairro_np'] += $array1['bairro_np'];
        $resultado['bairro_p'] += $array1['bairro_p'];
        $resultado['cep_np'] += $array1['cep_np'];
        $resultado['cep_p'] += $array1['cep_p'];
        $resultado['cidade_np'] += $array1['cidade_np'];
        $resultado['cidade_p'] += $array1['cidade_p'];
        $resultado['telefone1_np'] += $array1['telefone1_np'];
        $resultado['telefone1_p'] += $array1['telefone1_p'];
        $resultado['telefone2_np'] += $array1['telefone2_np'];
        $resultado['telefone2_p'] += $array1['telefone2_p'];
        $resultado['pagina_web_np'] += $array1['pagina_web_np'];
        $resultado['pagina_web_p'] += $array1['pagina_web_p'];
        $resultado['campus_np'] += $array1['campus_np'];
        $resultado['campus_p'] += $array1['campus_p'];
        $resultado['campus_ni'] += $array1['campus_ni'];
        $resultado['natureza_np'] += $array1['natureza_np'];
        $resultado['natureza_p'] += $array1['natureza_p'];
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        
        return $resultado;
    }

    function organizacao ($curso)
    {
        $resultado = array();

        $this->db->select('count(o.id) as total');
        $this->db->from('organizacao_demandante o');
        $this->db->join('curso c', 'c.id = o.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['total_p'] = $data[0]->total;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(o.id) as num');
        $this->db->from('organizacao_demandante o');
        $this->db->join('curso c', 'c.id = o.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('o.nome IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['nome_np'] = $data[0]->num;

        $this->db->select('count(o.id) as num');
        $this->db->from('organizacao_demandante o');
        $this->db->join('curso c', 'c.id = o.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('o.nome', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['nome_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(o.id) as num');
        $this->db->from('organizacao_demandante o');
        $this->db->join('curso c', 'c.id = o.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('o.nome IS NOT NULL', null);
        $this->db->where('o.nome <>', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['nome_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $resultado['nome_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(o.id) as num');
        $this->db->from('organizacao_demandante o');
        $this->db->join('curso c', 'c.id = o.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('o.abrangencia IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['abrangencia_np'] = $data[0]->num;

        $this->db->select('count(o.id) as num');
        $this->db->from('organizacao_demandante o');
        $this->db->join('curso c', 'c.id = o.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('o.abrangencia', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['abrangencia_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(o.id) as num');
        $this->db->from('organizacao_demandante o');
        $this->db->join('curso c', 'c.id = o.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('o.abrangencia IS NOT NULL', null);
        $this->db->where('o.abrangencia <>', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['abrangencia_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $resultado['abrangencia_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(o.id) as num');
        $this->db->from('organizacao_demandante o');
        $this->db->join('curso c', 'c.id = o.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('o.data_fundacao_nacional', '0000-00-00');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['data_fundacao_nacional_np'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(o.id) as num');
        $this->db->from('organizacao_demandante o');
        $this->db->join('curso c', 'c.id = o.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('o.data_fundacao_nacional <>', '0000-00-00');
        $this->db->where('o.data_fundacao_nacional <>', '1900-01-01');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['data_fundacao_nacional_p'] = $data[0]->num;
        //-----------------------------------------------------------------
        $resultado['data_fundacao_nacional_ni'] = 0;
        //-----------------------------------------------------------------

        $this->db->select('count(o.id) as num');
        $this->db->from('organizacao_demandante o');
        $this->db->join('curso c', 'c.id = o.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('o.data_fundacao_nacional', '1900-01-01');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['data_fundacao_nacional_na'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(o.id) as num');
        $this->db->from('organizacao_demandante o');
        $this->db->join('curso c', 'c.id = o.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('o.data_fundacao_estadual', '0000-00-00');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['data_fundacao_estadual_np'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(o.id) as num');
        $this->db->from('organizacao_demandante o');
        $this->db->join('curso c', 'c.id = o.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('o.data_fundacao_estadual <>', '0000-00-00');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['data_fundacao_estadual_p'] = $data[0]->num;
        //-----------------------------------------------------------------
        $resultado['data_fundacao_estadual_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(o.id) as num');
        $this->db->from('organizacao_demandante o');
        $this->db->join('curso c', 'c.id = o.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('o.numero_acampamentos IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['numero_acampamentos_np'] = $data[0]->num;

        $this->db->select('count(o.id) as num');
        $this->db->from('organizacao_demandante o');
        $this->db->join('curso c', 'c.id = o.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('o.numero_acampamentos', '');
        $this->db->where('o.numero_acampamentos IS NOT NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['numero_acampamentos_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(o.id) as num');
        $this->db->from('organizacao_demandante o');
        $this->db->join('curso c', 'c.id = o.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('o.numero_acampamentos IS NOT NULL', null);
        $this->db->where('o.numero_acampamentos <>', '');
        $this->db->where('o.numero_acampamentos <>', -1);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['numero_acampamentos_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(o.id) as num');
        $this->db->from('organizacao_demandante o');
        $this->db->join('curso c', 'c.id = o.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('o.numero_acampamentos', -1);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['numero_acampamentos_ni'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(o.id) as num');
        $this->db->from('organizacao_demandante o');
        $this->db->join('curso c', 'c.id = o.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('o.numero_assentamentos IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['numero_assentamentos_np'] = $data[0]->num;

        $this->db->select('count(o.id) as num');
        $this->db->from('organizacao_demandante o');
        $this->db->join('curso c', 'c.id = o.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('o.numero_assentamentos', '');
        $this->db->where('o.numero_assentamentos IS NOT NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['numero_assentamentos_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(o.id) as num');
        $this->db->from('organizacao_demandante o');
        $this->db->join('curso c', 'c.id = o.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('o.numero_assentamentos IS NOT NULL', null);
        $this->db->where('o.numero_assentamentos <>', '');
        $this->db->where('o.numero_assentamentos <>', -1);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['numero_assentamentos_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(o.id) as num');
        $this->db->from('organizacao_demandante o');
        $this->db->join('curso c', 'c.id = o.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('o.numero_assentamentos', -1);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['numero_assentamentos_ni'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(o.id) as num');
        $this->db->from('organizacao_demandante o');
        $this->db->join('curso c', 'c.id = o.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('o.numero_familias_assentadas IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['numero_familias_assentadas_np'] = $data[0]->num;

        $this->db->select('count(o.id) as num');
        $this->db->from('organizacao_demandante o');
        $this->db->join('curso c', 'c.id = o.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('o.numero_familias_assentadas', '');
        $this->db->where('o.numero_familias_assentadas IS NOT NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['numero_familias_assentadas_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(o.id) as num');
        $this->db->from('organizacao_demandante o');
        $this->db->join('curso c', 'c.id = o.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('o.numero_familias_assentadas IS NOT NULL', null);
        $this->db->where('o.numero_familias_assentadas <>', '');
        $this->db->where('o.numero_familias_assentadas <>', -1);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['numero_familias_assentadas_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(o.id) as num');
        $this->db->from('organizacao_demandante o');
        $this->db->join('curso c', 'c.id = o.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('o.numero_familias_assentadas', -1);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['numero_familias_assentadas_ni'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(o.id) as num');
        $this->db->from('organizacao_demandante o');
        $this->db->join('curso c', 'c.id = o.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('o.numero_pessoas IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['numero_pessoas_np'] = $data[0]->num;

        $this->db->select('count(o.id) as num');
        $this->db->from('organizacao_demandante o');
        $this->db->join('curso c', 'c.id = o.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('o.numero_pessoas', '');
        $this->db->where('o.numero_pessoas IS NOT NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['numero_pessoas_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(o.id) as num');
        $this->db->from('organizacao_demandante o');
        $this->db->join('curso c', 'c.id = o.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('o.numero_pessoas IS NOT NULL', null);
        $this->db->where('o.numero_pessoas <>', '');
        $this->db->where('o.numero_pessoas <>', -1);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['numero_pessoas_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(o.id) as num');
        $this->db->from('organizacao_demandante o');
        $this->db->join('curso c', 'c.id = o.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('o.numero_pessoas', -1);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['numero_pessoas_ni'] = $data[0]->num;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(o.id) as num');
        $this->db->from('organizacao_demandante o');
        $this->db->join('curso c', 'c.id = o.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('o.fonte_informacao IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['fonte_informacao_np'] = $data[0]->num;

        $this->db->select('count(o.id) as num');
        $this->db->from('organizacao_demandante o');
        $this->db->join('curso c', 'c.id = o.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('o.fonte_informacao', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['fonte_informacao_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(o.id) as num');
        $this->db->from('organizacao_demandante o');
        $this->db->join('curso c', 'c.id = o.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('o.fonte_informacao IS NOT NULL', null);
        $this->db->where('o.fonte_informacao <>', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['fonte_informacao_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $resultado['fonte_informacao_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        
        return $resultado;
    }

    function somar_organizacao ($array1, $array2)
    {
        $resultado = $array2;

        $resultado['total_p'] += $array1['total_p'];
        $resultado['nome_np'] += $array1['nome_np'];
        $resultado['nome_p'] += $array1['nome_p'];
        $resultado['abrangencia_np'] += $array1['abrangencia_np'];
        $resultado['abrangencia_p'] += $array1['abrangencia_p'];
        $resultado['data_fundacao_nacional_np'] += $array1['data_fundacao_nacional_np'];
        $resultado['data_fundacao_nacional_p']  += $array1['data_fundacao_nacional_p'];
        $resultado['data_fundacao_nacional_na'] += $array1['data_fundacao_nacional_na'];
        $resultado['data_fundacao_estadual_np'] += $array1['data_fundacao_estadual_np'];
        $resultado['data_fundacao_estadual_p']  += $array1['data_fundacao_estadual_p'];
        $resultado['numero_acampamentos_np'] += $array1['numero_acampamentos_np'];
        $resultado['numero_acampamentos_p'] += $array1['numero_acampamentos_p'];
        $resultado['numero_acampamentos_ni'] += $array1['numero_acampamentos_ni'];
        $resultado['numero_assentamentos_np'] += $array1['numero_assentamentos_np'];
        $resultado['numero_assentamentos_p'] += $array1['numero_assentamentos_p'];
        $resultado['numero_assentamentos_ni'] += $array1['numero_assentamentos_ni'];
        $resultado['numero_familias_assentadas_np'] += $array1['numero_familias_assentadas_np'];
        $resultado['numero_familias_assentadas_p'] += $array1['numero_familias_assentadas_p'];
        $resultado['numero_familias_assentadas_ni'] += $array1['numero_familias_assentadas_ni'];
        $resultado['numero_pessoas_np'] += $array1['numero_pessoas_np'];
        $resultado['numero_pessoas_p'] += $array1['numero_pessoas_p'];
        $resultado['numero_pessoas_ni'] += $array1['numero_pessoas_ni'];
        $resultado['fonte_informacao_np'] += $array1['fonte_informacao_np'];
        $resultado['fonte_informacao_p'] += $array1['fonte_informacao_p'];
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        
        return $resultado;
    }

    function parceiro ($curso)
    {
        $resultado = array();

        $this->db->select('count(p.id) as total');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['total_p'] = $data[0]->total;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.nome IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['nome_np'] = $data[0]->num;

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.nome', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['nome_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.nome IS NOT NULL', null);
        $this->db->where('p.nome <>', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['nome_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $resultado['nome_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.sigla IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['sigla_np'] = $data[0]->num;

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.sigla', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['sigla_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.sigla IS NOT NULL', null);
        $this->db->where('p.sigla <>', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['sigla_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $resultado['sigla_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.rua IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['rua_np'] = $data[0]->num;

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.rua', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['rua_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.rua IS NOT NULL', null);
        $this->db->where('p.rua <>', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['rua_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $resultado['rua_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.numero IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['numero_np'] = $data[0]->num;

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.numero', '');
        $this->db->where('p.numero IS NOT NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['numero_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.numero IS NOT NULL', null);
        $this->db->where('p.numero <>', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['numero_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $resultado['numero_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.complemento IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['complemento_np'] = $data[0]->num;

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.complemento', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['complemento_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.complemento IS NOT NULL', null);
        $this->db->where('p.complemento <>', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['complemento_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $resultado['complemento_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.bairro IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['bairro_np'] = $data[0]->num;

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.bairro', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['bairro_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.bairro IS NOT NULL', null);
        $this->db->where('p.bairro <>', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['bairro_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $resultado['bairro_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.cep IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['cep_np'] = $data[0]->num;

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.cep', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['cep_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.cep IS NOT NULL', null);
        $this->db->where('p.cep <>', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['cep_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $resultado['cep_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.id_cidade IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['cidade_np'] = $data[0]->num;

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.id_cidade', '');
        $this->db->where('p.id_cidade IS NOT NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['cidade_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.id_cidade IS NOT NULL', null);
        $this->db->where('p.id_cidade <>', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['cidade_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $resultado['cidade_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.telefone1 IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['telefone1_np'] = $data[0]->num;

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.telefone1', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['telefone1_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.telefone1 IS NOT NULL', null);
        $this->db->where('p.telefone1 <>', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['telefone1_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $resultado['telefone1_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.telefone2 IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['telefone2_np'] = $data[0]->num;

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.telefone2', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['telefone2_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.telefone2 IS NOT NULL', null);
        $this->db->where('p.telefone2 <>', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['telefone2_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $resultado['telefone2_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.pagina_web IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['pagina_web_np'] = $data[0]->num;

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.pagina_web', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['pagina_web_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.pagina_web IS NOT NULL', null);
        $this->db->where('p.pagina_web <>', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['pagina_web_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $resultado['pagina_web_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.abrangencia IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['abrangencia_np'] = $data[0]->num;

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.abrangencia', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['abrangencia_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.abrangencia IS NOT NULL', null);
        $this->db->where('p.abrangencia <>', '');
        $this->db->where('p.abrangencia <>', 'NAOINFORMADO');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['abrangencia_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $resultado['abrangencia_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.natureza IS NULL', null);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['natureza_np'] = $data[0]->num;

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.natureza', '');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['natureza_np'] += $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.natureza IS NOT NULL', null);
        $this->db->where('p.natureza <>', '');
        $this->db->where('p.natureza <>', 'NAOINFORMADO');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['natureza_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $resultado['natureza_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->join('parceiro_parceria pp', 'p.id = pp.id_parceiro', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('pp.realizacao', 0);
        $this->db->where('pp.certificacao', 0);
        $this->db->where('pp.gestao', 0);
        $this->db->where('pp.outros', 0);
        $query = $this->db->get();
        $data = $query->result();
        $resultado['tipo_np'] = $data[0]->num;
        //-----------------------------------------------------------------

        $this->db->select('count(p.id) as num');
        $this->db->from('parceiro p');
        $this->db->join('curso c', 'c.id = p.id_curso', 'left');
        $this->db->where('c.ativo_inativo', 'A');
        $this->db->where('c.id', $curso);
        $this->db->where('p.id in (select id_parceiro from parceiro_parceria pp where pp.realizacao = 1 or pp.certificacao = 1 or pp.gestao = 1
            or pp.outros = 1)');
        $query = $this->db->get();
        $data = $query->result();
        $resultado['tipo_p'] = $data[0]->num;
        //-----------------------------------------------------------------

        $resultado['tipo_ni'] = 0;
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        
        return $resultado;
    }

    function somar_parceiro ($array1, $array2)
    {
        $resultado = $array2;

        $resultado['total_p'] += $array1['total_p'];
        $resultado['nome_np'] += $array1['nome_np'];
        $resultado['nome_p'] += $array1['nome_p'];
        $resultado['sigla_np'] += $array1['sigla_np'];
        $resultado['sigla_p'] += $array1['sigla_p'];
        $resultado['rua_np'] += $array1['rua_np'];
        $resultado['rua_p'] += $array1['rua_p'];
        $resultado['numero_np'] += $array1['numero_np'];
        $resultado['numero_p'] += $array1['numero_p'];
        $resultado['complemento_np'] += $array1['complemento_np'];
        $resultado['complemento_p'] += $array1['complemento_p'];
        $resultado['bairro_np'] += $array1['bairro_np'];
        $resultado['bairro_p'] += $array1['bairro_p'];
        $resultado['cep_np'] += $array1['cep_np'];
        $resultado['cep_p'] += $array1['cep_p'];
        $resultado['cidade_np'] += $array1['cidade_np'];
        $resultado['cidade_p'] += $array1['cidade_p'];
        $resultado['telefone1_np'] += $array1['telefone1_np'];
        $resultado['telefone1_p'] += $array1['telefone1_p'];
        $resultado['telefone2_np'] += $array1['telefone2_np'];
        $resultado['telefone2_p'] += $array1['telefone2_p'];
        $resultado['pagina_web_np'] += $array1['pagina_web_np'];
        $resultado['pagina_web_p'] += $array1['pagina_web_p'];
        $resultado['abrangencia_np'] += $array1['abrangencia_np'];
        $resultado['abrangencia_p'] += $array1['abrangencia_p'];
        $resultado['natureza_np'] += $array1['natureza_np'];
        $resultado['natureza_p'] += $array1['natureza_p'];
        $resultado['tipo_np'] += $array1['tipo_np'];
        $resultado['tipo_p'] += $array1['tipo_p'];
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        
        return $resultado;
    }

}