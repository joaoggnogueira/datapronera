<?php 
	
class Relatorio_qualitativo extends CI_Controller {

	public function __construct() {
        parent::__construct(); 

        $this->load->database();		    // Loading Database 
        $this->load->library('session');    // Loading Session
        $this->load->helper('url'); 	    // Loading Helper        
    }

    function index()
    {

        $this->session->set_userdata('curr_content', 'rel_qualitativo');
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

    function all ()
    {
        $this->load->model('responsavel_m');
        
        $this->load->library('pdf');            
        $pdf = $this->pdf->load(); 
        $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   '); 
        
        $data['titulo_relatorio'] = 'Responsáveis pela Pesquisa';
        $html = $this->load->view('include/header_pdf', $data, true); 

        $pdf->WriteHTML($html); 

        $this->db->select('p.cpf, p.nome');
        $this->db->from('curso_assegurador ca');
        $this->db->join('pessoa p', 'ca.id_pessoa = p.id', 'left');
        $this->db->where('ca.id_curso', $this->uri->segment(3));
        $query = $this->db->get();

        $dados = $query->result();

         /** Output **/
        $insurers = array();

        foreach ($dados as $item) 
        {
            $row = array();     

            $row[0] = utf8_encode($item->cpf);
            $row[1] = ($item->nome);

            $insurers[] = $row;
        }       

        $valores['data'] = $this->responsavel_m->get_record($this->uri->segment(3));   
        $valores['insurers'] = $insurers;
        $valores['informer'] = $this->responsavel_m->get_informers($this->uri->segment(3));
        
        $html = $this->load->view('relatorio/qualitativo/rel_responsavel', $valores, true); 
        $pdf->WriteHTML($html); 

        //--------------------------------------------------------------------------------------------
        $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);

        $data['titulo_relatorio'] = 'Caracterização do Curso';
        $html = $this->load->view('include/header_pdf', $data, true); // render the view into HTML

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $this->db->select('c.nome curso, cr.*');
        $this->db->where('id_curso', $this->uri->segment(3));
        $this->db->from('caracterizacao cr');
        $this->db->join('curso c', 'c.id = cr.id_curso', 'left');
        $query = $this->db->get();
        $curso = $query->result();


        $curso[0]->data_fundacao_nacional =
            implode("-", array_reverse(explode("/", $curso[0]->data_fundacao_nacional),true));

        $curso[0]->data_fundacao_estadual =
            implode("-", array_reverse(explode("/", $curso[0]->data_fundacao_estadual),true));

        $this->db->select('e.sigla estado, c.nome cidade');
        $this->db->from('caracterizacao_cidade cc');
        $this->db->join('caracterizacao ca', 'ca.id = cc.id_caracterizacao', 'left');
        $this->db->join('cidade c', 'c.id = cc.id_cidade', 'left');
        $this->db->join('estado e', 'c.id_estado = e.id', 'left');
        $this->db->where('ca.id_curso', $this->uri->segment(3));
        $this->db->order_by('c.id_estado, cc.id_cidade');
        $query = $this->db->get();

        $dados = $query->result();

        $municipios = array();

        foreach ($dados as $item) 
        {
            $row = array();     

            $row[0] = $item->cidade;
            $row[1] = $item->estado;

            $municipios[] = $row;
        }       

        $valores['dados'] = $curso;
        $valores['municipios'] = $municipios;
        
        $html = $this->load->view('relatorio/qualitativo/rel_caracterizacao', $valores, true); 
        $pdf->WriteHTML($html); 

        //--------------------------------------------------------------------------------------------
        $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);

        $data['titulo_relatorio'] = 'Professor(a)(s)';
        $html = $this->load->view('include/header_pdf', $data, true); // render the view into HTML

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $this->db->select('p.id');
        $this->db->from('professor p');
        $this->db->where('p.id_curso',  $this->uri->segment(3));
        $query = $this->db->get();

        $dado_professor = $query->result();

        $variavel = "";
        $contador=1;

        foreach ($dado_professor as $item) 
        {   
            $variavel .= $this->professor($item->id);
            $contador++;
            if ($contador ==1 || $contador ==2) $variavel .= '<hr style="margin: 0px 0px;">';
            if ($contador == 2) $contador =0;
        }  
        $pdf->WriteHTML($variavel);    

        //--------------------------------------------------------------------------------------------
        $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);

        $data['titulo_relatorio'] = 'Educando(a)(s)';
        $html = $this->load->view('include/header_pdf', $data, true); // render the view into HTML

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $this->db->select('e.id');
        $this->db->from('educando e');
        $this->db->where('e.id_curso',  $this->uri->segment(3));
        $query = $this->db->get();

        $dado_educando = $query->result();

        $variavel = "";
        $contador = 1;

        foreach ($dado_educando as $item) 
        {   
            $variavel = $this->educando($item->id);
            $pdf->WriteHTML($variavel); 
            $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        }  

        //--------------------------------------------------------------------------------------------
        $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);

        $data['titulo_relatorio'] = 'Instituicão de Ensino';
        $html = $this->load->view('include/header_pdf', $data, true); // render the view into HTML

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $this->db->select('i.*, c.nome cidade, e.sigla estado');
        $this->db->where('i.id_curso', $this->uri->segment(3));
        $this->db->from('instituicao_ensino i');
        $this->db->join('cidade c', 'c.id = i.id_cidade', 'left');
        $this->db->join('estado e', 'c.id_estado = e.id', 'left');
        $query = $this->db->get();

        $dados = $query->result();
        $valores['dados'] = $dados;
        
        $html = $this->load->view('relatorio/qualitativo/rel_instituicao', $valores, true); 
        $pdf->WriteHTML($html); 

        //--------------------------------------------------------------------------------------------
        $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);

        $data['titulo_relatorio'] = 'Organização Demandante';
        $html = $this->load->view('include/header_pdf', $data, true); // render the view into HTML

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $this->db->select('o.id');
        $this->db->from('organizacao_demandante o');
        $this->db->where('o.id_curso',  $this->uri->segment(3));
        $query = $this->db->get();

        $dado_organizacao = $query->result();

        $variavel = "";

        foreach ($dado_organizacao as $item) 
        {   
            $variavel = $this->organizacao($item->id);
            $variavel .= '<hr>';
            $pdf->WriteHTML($variavel); 
            // $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        }  

        //--------------------------------------------------------------------------------------------
        $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        
        $data['titulo_relatorio'] = 'Parceiro';
        $html = $this->load->view('include/header_pdf', $data, true); // render the view into HTML

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $this->db->select('p.id');
        $this->db->from('parceiro p');
        $this->db->where('p.id_curso',  $this->uri->segment(3));
        $query = $this->db->get();

        $dado_parceiro = $query->result();

        $variavel = "";

        foreach ($dado_parceiro as $item) 
        {   
            $variavel = $this->parceiro($item->id);
            $variavel .= '<hr>';
            $pdf->WriteHTML($variavel); 
            // $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        }  

        //--------------------------------------------------------------------------------------------
        $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        
        $data['titulo_relatorio'] = 'Produção 8A - Geral<br>Vídeo / Cartilha - Apostila / Texto / Música / Caderno / Outros';
        $html = $this->load->view('include/header_pdf', $data, true); // render the view into HTML

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $this->db->select('o.id');
        $this->db->from('producao_geral o');
        $this->db->where('o.id_curso',  $this->uri->segment(3));
        $query = $this->db->get();

        $dado_producao = $query->result();

        $variavel = "";

        foreach ($dado_producao as $item) 
        {   
            $variavel = $this->producao8a($item->id);
            $variavel .= '<hr>';
            $pdf->WriteHTML($variavel); 
            // $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        }  

        //--------------------------------------------------------------------------------------------
        $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        
        $data['titulo_relatorio'] = 'Produção 8B - Trabalho<br>TRABALHO dos educandos(as) elaborado durante o curso';
        $html = $this->load->view('include/header_pdf', $data, true); // render the view into HTML

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $this->db->select('o.id');
        $this->db->from('producao_trabalho o');
        $this->db->where('o.id_curso',  $this->uri->segment(3));
        $query = $this->db->get();

        $dado_producao = $query->result();

        $variavel = "";

        foreach ($dado_producao as $item) 
        {   
            $variavel = $this->producao8b($item->id);
            $variavel .= '<hr>';
            $pdf->WriteHTML($variavel); 
            // $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        }  

        //--------------------------------------------------------------------------------------------
        $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        
        $data['titulo_relatorio'] = 'Produção 8C - Artigo<br>Artigo elaborado pelo(a)(s) educandos(as) durante o curso';
        $html = $this->load->view('include/header_pdf', $data, true); // render the view into HTML

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $this->db->select('o.id');
        $this->db->from('producao_artigo o');
        $this->db->where('o.id_curso',  $this->uri->segment(3));
        $query = $this->db->get();

        $dado_producao = $query->result();

        $variavel = "";

        foreach ($dado_producao as $item) 
        {   
            $variavel = $this->producao8c($item->id);
            $variavel .= '<hr>';
            $pdf->WriteHTML($variavel); 
            // $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        }  

        //--------------------------------------------------------------------------------------------
        $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        
        $data['titulo_relatorio'] = 'Produção 8D - Memória<br>MEMÓRIA produzida pelos educandos(as) durante o curso';
        $html = $this->load->view('include/header_pdf', $data, true); // render the view into HTML

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $this->db->select('o.id');
        $this->db->from('producao_memoria o');
        $this->db->where('o.id_curso',  $this->uri->segment(3));
        $query = $this->db->get();

        $dado_producao = $query->result();

        $variavel = "";

        foreach ($dado_producao as $item) 
        {   
            $variavel = $this->producao8d($item->id);
            $variavel .= '<hr>';
            $pdf->WriteHTML($variavel); 
            // $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        }  

        //--------------------------------------------------------------------------------------------
        $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        
        $data['titulo_relatorio'] = 'Produção 8E - Livro<br>Livro / Coletânea';
        $html = $this->load->view('include/header_pdf', $data, true); // render the view into HTML

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $this->db->select('o.id');
        $this->db->from('producao_livro o');
        $this->db->where('o.id_curso',  $this->uri->segment(3));
        $query = $this->db->get();

        $dado_producao = $query->result();

        $variavel = "";

        foreach ($dado_producao as $item) 
        {   
            $variavel = $this->producao8e($item->id);
            $variavel .= '<hr>';
            $pdf->WriteHTML($variavel); 
            // $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        }  
        
        // Param    I -> See on the browser         //          D -> Download File         //           F -> Save on the server
        $pdf->Output($pdfFilePath, 'I'); 
    }

    function responsavel ()
    {
        $this->load->model('responsavel_m');
        
        $this->load->library('pdf');            
        $pdf = $this->pdf->load(); 
        $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   '); 
        
        $data['titulo_relatorio'] = 'Responsáveis pela Pesquisa';
        $html = $this->load->view('include/header_pdf', $data, true); 

        $pdf->WriteHTML($html); 

        $this->db->select('p.cpf, p.nome');
        $this->db->from('curso_assegurador ca');
        $this->db->join('pessoa p', 'ca.id_pessoa = p.id', 'left');
        $this->db->where('ca.id_curso', $this->uri->segment(3));
        $query = $this->db->get();

        $dados = $query->result();

         /** Output **/
        $insurers = array();

        foreach ($dados as $item) 
        {
            $row = array();     

            $row[0] = utf8_encode($item->cpf);
            $row[1] = ($item->nome);

            $insurers[] = $row;
        }       

        $valores['data'] = $this->responsavel_m->get_record($this->uri->segment(3));   
        $valores['insurers'] = $insurers;
        $valores['informer'] = $this->responsavel_m->get_informers($this->uri->segment(3));
        
        $html = $this->load->view('relatorio/qualitativo/rel_responsavel', $valores, true); 
        $pdf->WriteHTML($html); 
        
        // Param    I -> See on the browser         //          D -> Download File         //           F -> Save on the server
        $pdf->Output($pdfFilePath, 'I'); 
    }

    function caracterizacao ()
    {
        $this->load->library('pdf');            
        $pdf = $this->pdf->load(); 
        $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   '); 
        
        $data['titulo_relatorio'] = 'Caracterização do Curso';
        $html = $this->load->view('include/header_pdf', $data, true); // render the view into HTML

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $this->db->select('c.nome curso, cr.*');
        $this->db->where('id_curso', $this->uri->segment(3));
        $this->db->from('caracterizacao cr');
        $this->db->join('curso c', 'c.id = cr.id_curso', 'left');
        $query = $this->db->get();
        $curso = $query->result();

        $this->db->select('e.sigla estado, c.nome cidade');
        $this->db->from('caracterizacao_cidade cc');
        $this->db->join('caracterizacao ca', 'ca.id = cc.id_caracterizacao', 'left');
        $this->db->join('cidade c', 'c.id = cc.id_cidade', 'left');
        $this->db->join('estado e', 'c.id_estado = e.id', 'left');
        $this->db->where('ca.id_curso', $this->uri->segment(3));
        $this->db->order_by('c.id_estado, cc.id_cidade');
        $query = $this->db->get();

        $dados = $query->result();

        $municipios = array();

        foreach ($dados as $item) 
        {
            $row = array();     

            $row[0] = $item->cidade;
            $row[1] = $item->estado;

            $municipios[] = $row;
        }       

        $valores['dados'] = $curso;
        $valores['municipios'] = $municipios;
        
        $html = $this->load->view('relatorio/qualitativo/rel_caracterizacao', $valores, true); 
        $pdf->WriteHTML($html); 
        
        // Param    I -> See on the browser         //          D -> Download File         //           F -> Save on the server
        $pdf->Output($pdfFilePath, 'I'); 
    }

    function curso_professor()
    {
        
        $this->load->library('pdf');            
        $pdf = $this->pdf->load(); 
        $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   '); 
        $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        
        $data['titulo_relatorio'] = 'Professor(a)(s)';
        $html = $this->load->view('include/header_pdf', $data, true); // render the view into HTML

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $this->db->select('p.id');
        $this->db->from('professor p');
        $this->db->where('p.id_curso',  $this->uri->segment(3));
        $query = $this->db->get();

        $dado_professor = $query->result();

        $variavel = "";
        $contador=1;

        foreach ($dado_professor as $item) 
        {   
            $variavel .= $this->professor($item->id);
            $contador++;
            if ($contador ==1 || $contador ==2) $variavel .= '<hr style="margin: 0px 0px;">';
            if ($contador == 2) $contador =0;
        }  
        $pdf->WriteHTML($variavel);       

        // Param    I -> See on the browser         //          D -> Download File         //           F -> Save on the server
        $pdf->Output($pdfFilePath, 'I'); 
    }

    function professor ($id)
    {
        $this->db->where('id', $id);
        $this->db->from('professor');
        $query = $this->db->get();

        $dados = $query->result();
        $valores['dados'] = $dados;

        $this->db->select('d.nome disciplina');
        $this->db->from('disciplina d');
        $this->db->where('d.id_professor', $id);
        $this->db->order_by('d.nome');
        $query = $this->db->get();

        $disciplinas = $query->result();
        $disciplina = array();

        foreach ($disciplinas as $item) 
        {
            $row = array();     

            $row[0] = ($item->disciplina);

            $disciplina[] = $row;
        }       
        $valores['disciplina'] =  $disciplina;
        
        $html = $this->load->view('relatorio/qualitativo/rel_professor', $valores, true); 
        
        return ($html);        
    }

    function curso_educando()
    {
        
        $this->load->library('pdf');            
        $pdf = $this->pdf->load(); 
        $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   '); 
        $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        
        $data['titulo_relatorio'] = 'Educando(a)(s)';
        $html = $this->load->view('include/header_pdf', $data, true); // render the view into HTML

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $this->db->select('e.id');
        $this->db->from('educando e');
        $this->db->where('e.id_curso',  $this->uri->segment(3));
        $query = $this->db->get();

        $dado_educando = $query->result();

        $variavel = "";
        $contador = 1;

        foreach ($dado_educando as $item) 
        {   
            $variavel = $this->educando($item->id);
            $pdf->WriteHTML($variavel); 
            $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        }  
              

        // Param    I -> See on the browser         //          D -> Download File         //           F -> Save on the server
        $pdf->Output($pdfFilePath, 'I'); 
    }

	function educando($id) 
    {
            
        $this->db->select('e.*, cr.inicio_realizado inicio_curso');
        $this->db->from('educando e');
        $this->db->join('caracterizacao cr', 'cr.id_curso = e.id_curso', 'left');
        $this->db->where('e.id', $id);
        $query = $this->db->get();

        $dados = $query->result();
        $dados[0]->data_nascimento = implode("/", array_reverse(explode("-", $dados[0]->data_nascimento),true));
        $valores['dados'] = $dados;

        $this->db->select('c.nome cidade, e.sigla estado');
        $this->db->from('educando_cidade ec');
        $this->db->join('cidade c', 'c.id = ec.id_cidade', 'left');
        $this->db->join('estado e', 'c.id_estado = e.id', 'left');
        $this->db->where('ec.id_educando', $id);
        $this->db->order_by('c.id_estado,ec.id_cidade');
        $query = $this->db->get();

        $educando_has_cidades = $query->result();
        $municipios = array();

        foreach ($educando_has_cidades as $item) 
        {
            $row = array();     

            $row[0] = ($item->estado);
            $row[1] = ($item->cidade);

            $municipios[] = $row;
        }       
        $valores['municipios'] =  $municipios;
        
        $html = $this->load->view('relatorio/qualitativo/rel_educando', $valores, true); 

        return ($html);
	}	

    function instituicao ()
    {
        $this->load->library('pdf');            
        $pdf = $this->pdf->load(); 
        $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   '); 
        
        $data['titulo_relatorio'] = 'Instituicão de Ensino';
        $html = $this->load->view('include/header_pdf', $data, true); // render the view into HTML

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $this->db->select('i.*, c.nome cidade, e.sigla estado');
        $this->db->where('i.id_curso', $this->uri->segment(3));
        $this->db->from('instituicao_ensino i');
        $this->db->join('cidade c', 'c.id = i.id_cidade', 'left');
        $this->db->join('estado e', 'c.id_estado = e.id', 'left');
        $query = $this->db->get();

        $dados = $query->result();
        $valores['dados'] = $dados;
        
        $html = $this->load->view('relatorio/qualitativo/rel_instituicao', $valores, true); 
        $pdf->WriteHTML($html); 
        
        // Param    I -> See on the browser         //          D -> Download File         //           F -> Save on the server
        $pdf->Output($pdfFilePath, 'I'); 
    }

    function curso_organizacao()
    {
        
        $this->load->library('pdf');            
        $pdf = $this->pdf->load(); 
        $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   '); 
        $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        
        $data['titulo_relatorio'] = 'Organização Demandante';
        $html = $this->load->view('include/header_pdf', $data, true); // render the view into HTML

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $this->db->select('o.id');
        $this->db->from('organizacao_demandante o');
        $this->db->where('o.id_curso',  $this->uri->segment(3));
        $query = $this->db->get();

        $dado_organizacao = $query->result();

        $variavel = "";

        foreach ($dado_organizacao as $item) 
        {   
            $variavel = $this->organizacao($item->id);
            $variavel .= '<hr>';
            $pdf->WriteHTML($variavel); 
            // $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        }  
              
        // Param    I -> See on the browser         //          D -> Download File         //           F -> Save on the server
        $pdf->Output($pdfFilePath, 'I'); 
    }

    function organizacao ($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('organizacao_demandante');
        $dados = $query->result();

        $dados[0]->data_fundacao_nacional =
            implode("/", array_reverse(explode("-", $dados[0]->data_fundacao_nacional),true));

        $dados[0]->data_fundacao_estadual =
            implode("/", array_reverse(explode("-", $dados[0]->data_fundacao_estadual),true));

        $this->db->where('id_organizacao_demandante', $id);
        $query = $this->db->get('organizacao_demandante_coordenador');
        $coord = $query->result();

        $valores['dados'] = $dados;
        $valores['coord'] = $coord;
        
        $html = $this->load->view('relatorio/qualitativo/rel_organizacao', $valores, true); 
        
        return ($html);
    }

    function curso_parceiro()
    {
        $this->load->library('pdf');            
        $pdf = $this->pdf->load(); 
        $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   '); 
        $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        
        $data['titulo_relatorio'] = 'Parceiro';
        $html = $this->load->view('include/header_pdf', $data, true); // render the view into HTML

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $this->db->select('p.id, e.sigla estado');
        $this->db->from('parceiro p');
        $this->db->join('cidade c', 'c.id = p.id_cidade', 'left');
        $this->db->join('estado e', 'c.id_estado = e.id', 'left');
        $this->db->where('p.id_curso',  $this->uri->segment(3));
        $query = $this->db->get();

        $dado_parceiro = $query->result();

        $variavel = "";

        foreach ($dado_parceiro as $item) 
        {   
            $variavel = $this->parceiro($item->id);
            $variavel .= '<hr>';
            $pdf->WriteHTML($variavel); 
            // $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        }  
              
        // Param    I -> See on the browser         //          D -> Download File         //           F -> Save on the server
        $pdf->Output($pdfFilePath, 'I'); 
    }

    function parceiro ($id)
    {
        $this->db->select('p.*, c.nome cidade, e.sigla estado');
        $this->db->where('p.id', $id);
        $this->db->from('parceiro p');
        $this->db->join('cidade c', 'c.id = p.id_cidade', 'left');
        $this->db->join('estado e', 'c.id_estado = e.id', 'left');
        $query = $this->db->get();
        $dados = $query->result();

        $this->db->where('id_parceiro', $id);
        $query = $this->db->get('parceiro_parceria');
        $has_parceria = $query->result();

        $valores['dados'] = $dados;
        $valores['has_parceria'] = $has_parceria;
        
        $html = $this->load->view('relatorio/qualitativo/rel_parceiro', $valores, true); 
        return ($html);
    }

    function curso_producao8a()
    {
        $this->load->library('pdf');            
        $pdf = $this->pdf->load(); 
        $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   '); 
        $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        
        $data['titulo_relatorio'] = 'Produção 8A - Geral<br>Vídeo / Cartilha - Apostila / Texto / Música / Caderno / Outros';
        $html = $this->load->view('include/header_pdf', $data, true); // render the view into HTML

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $this->db->select('o.id');
        $this->db->from('producao_geral o');
        $this->db->where('o.id_curso',  $this->uri->segment(3));
        $query = $this->db->get();

        $dado_producao = $query->result();

        $variavel = "";

        foreach ($dado_producao as $item) 
        {   
            $variavel = $this->producao8a($item->id);
            $variavel .= '<hr>';
            $pdf->WriteHTML($variavel); 
            // $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        }  
              
        // Param    I -> See on the browser         //          D -> Download File         //           F -> Save on the server
        $pdf->Output($pdfFilePath, 'I'); 
    }

    function producao8a ($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('producao_geral');
        $dados = $query->result();

        $valores['dados'] = $dados;

        $this->db->select('a.nome, a.tipo');
        $this->db->from('autor a');
        $this->db->join('producao_geral_autor o', 'o.id_autor = a.id', 'left');
        $this->db->where('o.id_producao_geral', $id);
        $this->db->order_by('a.nome');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output **/
        $autores = array();

        foreach ($dados as $item) 
        {
            $row = array();     

            $row[0] = ($item->nome);
            $row[1] = ($item->tipo);

            $autores[] = $row;
        }       

        $valores['autores'] = $autores;
        
        $html = $this->load->view('relatorio/qualitativo/rel_producao8a', $valores, true); 
        return($html);  
    }

    function curso_producao8b()
    {
        $this->load->library('pdf');            
        $pdf = $this->pdf->load(); 
        $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   '); 
        $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        
        $data['titulo_relatorio'] = 'Produção 8B - Trabalho<br>TRABALHO dos educandos(as) elaborado durante o curso';
        $html = $this->load->view('include/header_pdf', $data, true); // render the view into HTML

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $this->db->select('o.id');
        $this->db->from('producao_trabalho o');
        $this->db->where('o.id_curso',  $this->uri->segment(3));
        $query = $this->db->get();

        $dado_producao = $query->result();

        $variavel = "";

        foreach ($dado_producao as $item) 
        {   
            $variavel = $this->producao8b($item->id);
            $variavel .= '<hr>';
            $pdf->WriteHTML($variavel); 
            // $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        }  
              
        // Param    I -> See on the browser         //          D -> Download File         //           F -> Save on the server
        $pdf->Output($pdfFilePath, 'I'); 
    }

    function producao8b ($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('producao_trabalho');
        $dados = $query->result();

        $valores['dados'] = $dados;

        $this->db->select('a.nome');
        $this->db->from('autor a');
        $this->db->join('producao_trabalho_autor o', 'o.id_autor = a.id', 'left');
        $this->db->where('o.id_producao_trabalho', $id);
        $this->db->order_by('a.nome');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output **/
        $autores = array();

        foreach ($dados as $item) 
        {
            $row = array();     

            $row[0] = ($item->nome);

            $autores[] = $row;
        }       

        $valores['autores'] = $autores;
        
        $html = $this->load->view('relatorio/qualitativo/rel_producao8b', $valores, true); 
        return($html);  
    }

    function curso_producao8c()
    {
        $this->load->library('pdf');            
        $pdf = $this->pdf->load(); 
        $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   '); 
        $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        
        $data['titulo_relatorio'] = 'Produção 8C - Artigo<br>Artigo elaborado pelo(a)(s) educandos(as) durante o curso';
        $html = $this->load->view('include/header_pdf', $data, true); // render the view into HTML

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $this->db->select('o.id');
        $this->db->from('producao_artigo o');
        $this->db->where('o.id_curso',  $this->uri->segment(3));
        $query = $this->db->get();

        $dado_producao = $query->result();

        $variavel = "";

        foreach ($dado_producao as $item) 
        {   
            $variavel = $this->producao8c($item->id);
            $variavel .= '<hr>';
            $pdf->WriteHTML($variavel); 
            // $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        }  
              
        // Param    I -> See on the browser         //          D -> Download File         //           F -> Save on the server
        $pdf->Output($pdfFilePath, 'I'); 
    }

    function producao8c ($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('producao_artigo');
        $dados = $query->result();

        $valores['dados'] = $dados;

        $this->db->select('a.nome');
        $this->db->from('autor a');
        $this->db->join('producao_artigo_autor o', 'o.id_autor = a.id', 'left');
        $this->db->where('o.id_producao_artigo', $id);
        $this->db->order_by('a.nome');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output **/
        $autores = array();

        foreach ($dados as $item) 
        {
            $row = array();     

            $row[0] = ($item->nome);

            $autores[] = $row;
        }       

        $valores['autores'] = $autores;
        
        $html = $this->load->view('relatorio/qualitativo/rel_producao8c', $valores, true); 
        return($html); 
    }

    function curso_producao8d()
    {
        $this->load->library('pdf');            
        $pdf = $this->pdf->load(); 
        $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   '); 
        $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        
        $data['titulo_relatorio'] = 'Produção 8D - Memória<br>MEMÓRIA produzida pelos educandos(as) durante o curso';
        $html = $this->load->view('include/header_pdf', $data, true); // render the view into HTML

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $this->db->select('o.id');
        $this->db->from('producao_memoria o');
        $this->db->where('o.id_curso',  $this->uri->segment(3));
        $query = $this->db->get();

        $dado_producao = $query->result();

        $variavel = "";

        foreach ($dado_producao as $item) 
        {   
            $variavel = $this->producao8d($item->id);
            $variavel .= '<hr>';
            $pdf->WriteHTML($variavel); 
            // $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        }  
              
        // Param    I -> See on the browser         //          D -> Download File         //           F -> Save on the server
        $pdf->Output($pdfFilePath, 'I'); 
    }

    function producao8d ($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('producao_memoria');
        $dados = $query->result();

        $valores['dados'] = $dados;
        
        $html = $this->load->view('relatorio/qualitativo/rel_producao8d', $valores, true); 
        return($html); 
    }

    function curso_producao8e()
    {
        $this->load->library('pdf');            
        $pdf = $this->pdf->load(); 
        $pdf->SetFooter('   Relatório Extraído do Sistema DataPronera'.'|Página {PAGENO}|'.date("d.m.Y").'   '); 
        $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        
        $data['titulo_relatorio'] = 'Produção 8E - Livro<br>Livro / Coletânea';
        $html = $this->load->view('include/header_pdf', $data, true); // render the view into HTML

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $this->db->select('o.id');
        $this->db->from('producao_livro o');
        $this->db->where('o.id_curso',  $this->uri->segment(3));
        $query = $this->db->get();

        $dado_producao = $query->result();

        $variavel = "";

        foreach ($dado_producao as $item) 
        {   
            $variavel = $this->producao8e($item->id);
            $variavel .= '<hr>';
            $pdf->WriteHTML($variavel); 
            // $pdf->AddPage('L','','','','',0,0,4,10,0,6,3);
        }  
              
        // Param    I -> See on the browser         //          D -> Download File         //           F -> Save on the server
        $pdf->Output($pdfFilePath, 'I'); 
    }

    function producao8e ($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('producao_livro');
        $dados = $query->result();

        $valores['dados'] = $dados;

        $this->db->select('a.nome, a.tipo');
        $this->db->from('autor a');
        $this->db->join('producao_livro_autor o', 'o.id_autor = a.id', 'left');
        $this->db->where('o.id_producao_livro', $id);
        $this->db->order_by('a.nome');
        $query = $this->db->get();

        $dados = $query->result();

        /** Output **/
        $autores = array();

        foreach ($dados as $item) 
        {
            $row = array();     

            $row[0] = ($item->nome);
            $row[1] = ($item->tipo);

            $autores[] = $row;
        }       

        $valores['autores'] = $autores;
        
        $html = $this->load->view('relatorio/qualitativo/rel_producao8e', $valores, true); 
        return($html); 
    }
}