<?php 
    $this->session->set_userdata('curr_content', 'rel_quantitativo');
?>
<script type="text/javascript">    

    //var oTable;

    $(document).ready(function() {

        var url = "<?php echo site_url('relatorio_quantitativo').'/'; ?>";
        
       // recupera estados e municipios selecionando que estão no banco de dados
        $.get("<?php echo site_url('requisicao/get_superintendencias_cursos'); ?>", function(superintendencias) {
            $('#sel_superintendencia').html(superintendencias);
        });

        var urlCursos = "<?php echo site_url('requisicao/get_cursos_by_super'); ?>";
        var urlModalidade = "<?php echo site_url('requisicao/get_modalidade_by_super'); ?>";

        // Lista de Municípios
        $('#sel_superintendencia').listCourses(urlCursos, 'sel_curso');
        $('#sel_superintendencia').listModality(urlModalidade, 'sel_modalidade');

        $('#rtipo_01').click( function() {
            $('#super').css('display', 'block');
            $('#modalidade').css('display', 'none');
            $('#educando_curso').css('display', 'none');
        });

        $('#rtipo_02').click( function() {
            $('#super').css('display', 'block');
            $('#modalidade').css('display', 'block');
            $('#educando_curso').css('display', 'none');
        });

        $('#rtipo_03').click( function() {
            $('#super').css('display', 'block');
            $('#modalidade').css('display', 'none');
            $('#educando_curso').css('display', 'block');
        });

        $('#rtipo_04').click( function() {
            $('#super').css('display', 'block');
            $('#modalidade').css('display', 'block');
            $('#educando_curso').css('display', 'none');
        });

        $('#gerar').click( function() {
            
            tipo_relatorio = $("input:radio[name=rtipo]:checked").val();

            if (tipo_relatorio == 'superintendencia')
            {
                super_id = $('#sel_superintendencia').val();
                window.open(url + "superintendencia/"+super_id, '_blank'); 
            } 
            else if (tipo_relatorio == 'modalidade')
            {
                super_id = $('#sel_superintendencia').val();
                modalidade_id = $('#sel_modalidade').val();
                window.open(url + "modalidade/"+super_id+"/"+modalidade_id, '_blank'); 
            } 
            else if (tipo_relatorio == 'edu_curso')
            {
                curso_id = $('#sel_curso').val();
                window.open(url + "educando_municipio_curso/"+curso_id, '_blank'); 
            } 
            else if (tipo_relatorio == 'edu_modalidade')
            {
                super_id = $('#sel_superintendencia').val();
                modalidade_id = $('#sel_modalidade').val();
                window.open(url + "educando_municipio_modalidade/"+super_id+"/"+modalidade_id, '_blank'); 
            }               
        });

    });

</script>
  <form>
    <fieldset>
        <legend> Relatórios Quantitativos </legend>

        <p>Tipo de Relatório:</p>
        <div class="radio form-group">
            <div class="radio"><label> <input type="radio" name="rtipo" id="rtipo_01" value="superintendencia" > Superintendência </label> </div>
            <div class="radio"><label> <input type="radio" name="rtipo" id="rtipo_02" value="modalidade" > Modalidades </label> </div>
            <div class="radio"><label> <input type="radio" name="rtipo" id="rtipo_03" value="edu_curso" > Educando - Curso </label> </div>
            <div class="radio"><label> <input type="radio" name="rtipo" id="rtipo_04" value="edu_modalidade" > Educando - Modalidade </label> </div>
        </div>  
        
        <div id="super" style="display:none;">
            <p> Superintendências: </p>
            <select id="sel_superintendencia" name="sel_superintendencia">           
            </select>
            <br><br>

            <div id="modalidade" style="display:none;">
                <p> Modalidades: </p>
                <select id="sel_modalidade" name="sel_modalidade">           
                </select>
                <br><br>
            </div>

            <div id="educando_curso" style="display:none;">
                <p>Cursos:</p>
                <select id="sel_curso" name="sel_curso">
                </select>
                <br><br>
            </div>
        </div>

        <input type="button" id="gerar" class="btn btn-success" value="Gerar Relatório">
                       
        
    </fieldset>
</form>