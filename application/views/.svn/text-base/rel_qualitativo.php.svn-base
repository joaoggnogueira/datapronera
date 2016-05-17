<?php 
    $this->session->set_userdata('curr_content', 'rel_qualitativo');
?>
<script type="text/javascript">    

    //var oTable;

    $(document).ready(function() {

        var url = "<?php echo site_url('relatorio_qualitativo').'/'; ?>";
        
       // recupera estados e municipios selecionando que estão no banco de dados
        $.get("<?php echo site_url('requisicao/get_superintendencias_cursos'); ?>", function(superintendencias) {
            $('#superintendencia').html(superintendencias);
        });

        var urlCursos = "<?php echo site_url('requisicao/get_cursos_by_super'); ?>";

        // Lista de Municípios
        $('#superintendencia').listCourses(urlCursos, 'curso');

        $('#rtipo_01').click( function() {
            $('#formularios').css('display', 'none');
        });

        $('#rtipo_02').click( function() {
            $('#formularios').css('display', 'block');
        });

        $('#gerar').click( function() {
            
            curso = $('#curso').val();
            tipo_relatorio = $("input:radio[name=rtipo]:checked").val();

            if (tipo_relatorio == 'completo'){
                window.open(url + "all/"+curso, '_blank'); 
            }else {
                switch ($('#formularios').val()){
                    case '1': 
                        window.open(url + "responsavel/"+curso, '_blank'); 
                        break;
                    case '2': 
                        window.open(url + "caracterizacao/"+curso, '_blank'); 
                        break;
                    case '3': 
                        window.open(url + "curso_professor/"+curso, '_blank'); 
                        break;
                    case '4': 
                        window.open(url + "curso_educando/"+curso, '_blank'); 
                        break;
                    case '5': 
                        window.open(url + "instituicao/"+curso, '_blank'); 
                        break;
                    case '6': 
                        window.open(url + "curso_organizacao/"+curso, '_blank'); 
                        break;
                    case '7': 
                        window.open(url + "curso_parceiro/"+curso, '_blank'); 
                        break;
                    case '8a': 
                        window.open(url + "curso_producao8a/"+curso, '_blank'); 
                        break;
                    case '8b': 
                        window.open(url + "curso_producao8b/"+curso, '_blank'); 
                        break;
                    case '8c': 
                        window.open(url + "curso_producao8c/"+curso, '_blank'); 
                        break;
                    case '8d': 
                        window.open(url + "curso_producao8d/"+curso, '_blank'); 
                        break;
                    case '8e': 
                        window.open(url + "curso_producao8e/"+curso, '_blank'); 
                        break;
                    default: break;
                }
                
            }
        });

    });

</script>
  <form>
    <fieldset>
        <legend> Relatórios Qualitativos </legend>

        <p> Superintendência(s): </p>
        <select id="superintendencia" name="superintendencia">           
        </select>
        <br><br>

        <p>Curso(s):</p>
        <select id="curso" name="curso">
        </select>
        <br><br>

        <p>Tipo de Relatório:</p>
        <div class="radio form-group">
            <div class="radio"><label> <input type="radio" name="rtipo" id="rtipo_01" value="completo" > Relatório Completo </label> </div>
            <div class="radio"><label> <input type="radio" name="rtipo" id="rtipo_02" value="formulario" > Por Formulários </label> </div>

            <select id="formularios" style="display:none;">
                <option disabled selected>Selecione o Formulário</option>
                <option value="1">1- Responsáveis pela Pesquisa</option>
                <option value="2">2- Caracterização do Curso</option>
                <option value="3">3 - Caracterização do(a) Professor(a)/Educador(a)</option>
                <option value="4">4 - Caracterização do(a) Educando(a)</option>
                <option value="5">5 - Caracterização da Instituição de Ensino</option>
                <option value="6">6 - Organização Demandante</option>
                <option value="7">7 - Caracterização do Parceiro</option>
                <option disabled>Produções</option>
                <option value="8a">8 - A | Produção Geral</option>
                <option value="8b">8 - B | Trabalho</option>
                <option value="8c">8 - C | Artigo</option>
                <option value="8d">8 - D | Memória</option>
                <option value="8e">8 - E | Livro</option>
            </select>
        </div>              
        <input type="button" id="gerar" class="btn btn-success" value="Gerar Relatório">
                       
        
    </fieldset>
</form>