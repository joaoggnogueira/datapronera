<?php $this->session->set_userdata('curr_content', 'rel_dinamico'); ?>

<style type="text/css">
    .tab-pane{
        padding:30px;
    }
</style>

<script type="text/javascript">

    $(document).ready(function() {

        var url = "<?php echo site_url('relatorio_dinamico').'/'; ?>";

        // Carrega os selects para filtro
        $.get("<?php echo site_url('requisicao/get_superintendencias_cursos'); ?>", function(data) {
            $('#superintendencias-select').html(data);
        });

        $('#superintendencias-select').change(function(){
            var url = "<?php echo site_url('requisicao/get_cursos_by_super').'/'; ?>" + $('#superintendencias-select option:selected').val();
            $.get(url, function(cursos) {
                $('#cursos-select').html(cursos);
            });
        });

        $.get("<?php echo site_url('requisicao/get_modalidades'); ?>", function(modalidades) {
            $('#modalidades-select').html(modalidades);
        });

        /* MUNICIPIOS */

        $.get("<?php echo site_url('requisicao/get_estados'); ?>", function(data) {
            $('#estados-select').html(data);
        });

        $('#estados-select').change(function(){
            var url = "<?php echo site_url('requisicao/get_municipios').'/'; ?>" + $('#estados-select option:selected').val();
            $.get(url, function(data) {
                $('#municipios-select').html(data);
            });
        });

        $('#filtros_tipo_parceria').css('display', 'none');
        $('#tipo_parceria').change(function() {
            if($(this).is(":checked")) {
                $('#filtros_tipo_parceria').css('display', 'block');
                $(this).attr("checked", true);
            }else{
                $('#filtros_tipo_parceria').css('display', 'none');
            }     
        });

        $('#gerar').click(function(){
            /** FILTROS DOS CURSOS **/
            var superintendencia = $('#superintendencias-select').val();
            var curso            = $('#cursos-select').val();
            var modalidade       = $('#modalidades-select').val();
            var municipio        = $('#municipios-select').val();

            /** FILTROS EDUCANDOS **/
            var genero_educando = $('#genero_educando').val();
            var nascimento      = $('#nascimento').val();

            /** FILTROS PROFESSORES **/
            var genero_professor = $('#genero_professor').val();

            /* WHERE DAS CONSULTAS **/
            var where_superintendencias = '';
            var where_curso = '';
            var where_cidade_cursos = '';
            var where_educandos = '';
            var where_cidade_educandos = '';
            var where_professores = '';
            var where_disciplinas = '';
            var where_ie = '';
            var where_cidades_ie = '';
            var where_org_demandantes = '';
            var where_coord_org_demandantes = '';
            var where_parceiros = '';
            var where_cidades_parceiros = '';
            var where_tipos_parceiros = '';

            /* WHERE CAMPO CURSO */
            if(curso != null){
                where_curso                 += ' AND c.id =' + curso;
                where_cidade_cursos         += ' AND cr.id_curso ='+curso;
                where_educandos             += ' AND e.id_curso ='+curso;
                where_cidade_educandos      += ' AND ed.id_curso ='+curso;
                where_professores           += ' AND p.id_curso ='+curso;
                where_disciplinas           += ' AND d.id_curso ='+curso;
                where_ie                    += ' AND ie.id_curso ='+curso;
                where_cidades_ie            += ' AND ie.id_curso ='+curso;
                where_org_demandantes       += ' AND od.id_curso ='+curso;
                where_coord_org_demandantes += ' AND o.id_curso ='+curso;
                where_parceiros             += ' AND p.id_curso ='+curso;
                where_cidades_parceiros     += ' AND cp.id ='+curso;
                where_tipos_parceiros       += ' AND c.id ='+curso;
            }

            /* WHERE CAMPO MODALIDADE */
            if(modalidade != null){
                where_curso += ' AND cm.id =' + modalidade;
                where_cidade_cursos += ' AND cr.id_curso IN (select a.id FROM curso a, curso_modalidade b where a.id_modalidade = b.id AND b.id = '+modalidade+')';
                where_educandos             += ' AND e.id_curso IN (select a.id FROM curso a, curso_modalidade b where a.id_modalidade = b.id AND b.id = '+modalidade+')';
                where_cidade_educandos      += ' AND ed.id_curso IN (select a.id FROM curso a, curso_modalidade b where a.id_modalidade = b.id AND b.id = '+modalidade+')';
                where_professores           += ' AND p.id_curso IN (select a.id FROM curso a, curso_modalidade b where a.id_modalidade = b.id AND b.id = '+modalidade+')';
                where_disciplinas           += ' AND d.id_curso IN (select a.id FROM curso a, curso_modalidade b where a.id_modalidade = b.id AND b.id = '+modalidade+')';
                where_ie                    += ' AND ie.id_curso IN (select a.id FROM curso a, curso_modalidade b where a.id_modalidade = b.id AND b.id = '+modalidade+')';
                where_cidades_ie            += ' AND ie.id_curso IN (select a.id FROM curso a, curso_modalidade b where a.id_modalidade = b.id AND b.id = '+modalidade+')';
                where_org_demandantes       += ' AND od.id_curso IN (select a.id FROM curso a, curso_modalidade b where a.id_modalidade = b.id AND b.id = '+modalidade+')';
                where_coord_org_demandantes += ' AND o.id_curso IN (select a.id FROM curso a, curso_modalidade b where a.id_modalidade = b.id AND b.id = '+modalidade+')';
                where_parceiros             += ' AND p.id_curso IN (select a.id FROM curso a, curso_modalidade b where a.id_modalidade = b.id AND b.id = '+modalidade+')';
                where_cidades_parceiros     += ' AND cp.id IN (select a.id FROM curso a, curso_modalidade b where a.id_modalidade = b.id AND b.id = '+modalidade+')';
                where_tipos_parceiros       += ' AND c.id IN (select a.id FROM curso a, curso_modalidade b where a.id_modalidade = b.id AND b.id = '+modalidade+')';
            }

            /* WHERE CAMPO MUNICIPIO */
            if(municipio != null){
                where_curso += ' AND c.id IN (SELECT a.id_curso FROM `caracterizacao_cidade` b, `caracterizacao` a, `cidade` ci, `estado` x, `curso` c WHERE a.id_curso = c.id AND b.id_caracterizacao = a.id AND b.id_cidade = ci.id AND ci.id_estado = x.id AND ci.id = '+municipio+')';
                where_cidade_cursos += ' AND ci.id = '+municipio;
                where_educandos             += ' AND e.id_curso IN (SELECT a.id_curso FROM `caracterizacao_cidade` b, `caracterizacao` a, `cidade` ci, `estado` x, `curso` c WHERE a.id_curso = c.id AND b.id_caracterizacao = a.id AND b.id_cidade = ci.id AND ci.id_estado = x.id AND ci.id = '+municipio+')';
                where_cidade_educandos      += ' AND ed.id_curso IN (select a.id FROM curso a, curso_modalidade b where a.id_modalidade = b.id AND b.id = '+modalidade+')';
                where_professores           += ' AND p.id_curso IN (SELECT a.id_curso FROM `caracterizacao_cidade` b, `caracterizacao` a, `cidade` ci, `estado` x, `curso` c WHERE a.id_curso = c.id AND b.id_caracterizacao = a.id AND b.id_cidade = ci.id AND ci.id_estado = x.id AND ci.id = '+municipio+')';
                where_disciplinas           += ' AND d.id_curso IN (select a.id FROM curso a, curso_modalidade b where a.id_modalidade = b.id AND b.id = '+municipio+')';
                where_ie                    += ' AND ie.id_curso IN (SELECT a.id_curso FROM `caracterizacao_cidade` b, `caracterizacao` a, `cidade` ci, `estado` x, `curso` c WHERE a.id_curso = c.id AND b.id_caracterizacao = a.id AND b.id_cidade = ci.id AND ci.id_estado = x.id AND ci.id = '+municipio+')';
                where_cidades_ie            += ' AND ie.id_curso IN (SELECT a.id_curso FROM `caracterizacao_cidade` b, `caracterizacao` a, `cidade` ci, `estado` x, `curso` c WHERE a.id_curso = c.id AND b.id_caracterizacao = a.id AND b.id_cidade = ci.id AND ci.id_estado = x.id AND ci.id = '+municipio+')';
                where_org_demandantes       += ' AND od.id_curso IN (SELECT a.id_curso FROM `caracterizacao_cidade` b, `caracterizacao` a, `cidade` ci, `estado` x, `curso` c WHERE a.id_curso = c.id AND b.id_caracterizacao = a.id AND b.id_cidade = ci.id AND ci.id_estado = x.id AND ci.id = '+municipio+')';
                where_coord_org_demandantes += ' AND o.id_curso IN (SELECT a.id_curso FROM `caracterizacao_cidade` b, `caracterizacao` a, `cidade` ci, `estado` x, `curso` c WHERE a.id_curso = c.id AND b.id_caracterizacao = a.id AND b.id_cidade = ci.id AND ci.id_estado = x.id AND ci.id = '+municipio+')';
                where_parceiros             += ' AND p.id_curso IN (SELECT a.id_curso FROM `caracterizacao_cidade` b, `caracterizacao` a, `cidade` ci, `estado` x, `curso` c WHERE a.id_curso = c.id AND b.id_caracterizacao = a.id AND b.id_cidade = ci.id AND ci.id_estado = x.id AND ci.id = '+municipio+')';
                where_cidades_parceiros     += ' AND cp.id IN (SELECT a.id_curso FROM `caracterizacao_cidade` b, `caracterizacao` a, `cidade` ci, `estado` x, `curso` c WHERE a.id_curso = c.id AND b.id_caracterizacao = a.id AND b.id_cidade = ci.id AND ci.id_estado = x.id AND ci.id = '+municipio+')';
                where_tipos_parceiros       += ' AND c.id IN (SELECT a.id_curso FROM `caracterizacao_cidade` b, `caracterizacao` a, `cidade` ci, `estado` x, `curso` c WHERE a.id_curso = c.id AND b.id_caracterizacao = a.id AND b.id_cidade = ci.id AND ci.id_estado = x.id AND ci.id = '+municipio+')';
            }

            /* WHERE CAMPO GENERO_EDUCANDO */
            if(genero_educando != null){
                where_educandos += ' AND e.genero = "'+genero_educando+'"';
            }

            /* WHERE CAMPO GENERO_PROFESSOR */
            if(genero_professor != null){
                where_professores += ' AND p.genero = "'+genero_professor+'"';
            }

            /* WHERE CAMPO NASCIMENTO */
            if(nascimento.length != 0){
                where_educandos += ' AND YEAR(e.data_nascimento) ='+nascimento;
            }

            /* WHERE PARCEIROS */
            if($('#tipo_parceria').is(":checked")) {
                var where_aux = '';
                $('#filtros_tipo_parceria input:checked').each(function(){
                    where_aux += $(this).attr('value');
                });

                where_tipos_parceiros   += where_aux;
                where_parceiros         += ' AND p.id IN (SELECT a.id_parceiro FROM `parceiro_parceria` a, `parceiro` b, `curso` d WHERE a.id_parceiro = b.id AND b.id_curso = d.id AND d.ativo_inativo = "A" AND d.status = "2P" '+where_aux+')';
                where_cidades_parceiros += ' AND p.id IN (SELECT a.id_parceiro FROM `parceiro_parceria` a, `parceiro` b, `curso` d WHERE a.id_parceiro = b.id AND b.id_curso = d.id AND d.ativo_inativo = "A" AND d.status = "2P" '+where_aux+')';
            }

            $('<form target="_blank" action="'+url+'gerarRelatorio" method="POST">' + 
            "<textarea id='where_superintendencias' name='where_superintendencias'>" + where_superintendencias + "</textarea>" +
            "<textarea id='where_curso' name='where_curso'>" + where_curso + "</textarea>" +
            "<textarea id='where_cidade_cursos' name='where_cidade_cursos'>" + where_cidade_cursos + "</textarea>" +
            "<textarea id='where_educandos' name='where_educandos'>" + where_educandos + "</textarea>" +
            "<textarea id='where_cidade_educandos' name='where_cidade_educandos'>" + where_cidade_educandos + "</textarea>" +
            "<textarea id='where_professores' name='where_professores'>" + where_professores + "</textarea>" +
            "<textarea id='where_disciplinas' name='where_disciplinas'>" + where_disciplinas + "</textarea>" +
            "<textarea id='where_ie' name='where_ie'>" + where_ie + "</textarea>" +
            "<textarea id='where_cidades_ie' name='where_cidades_ie'>" + where_cidades_ie + "</textarea>" +
            "<textarea id='where_org_demandantes' name='where_org_demandantes'>" + where_org_demandantes + "</textarea>" +
            "<textarea id='where_coord_org_demandantes' name='where_coord_org_demandantes'>" + where_coord_org_demandantes + "</textarea>" +
            "<textarea id='where_parceiros' name='where_parceiros'>" + where_parceiros + "</textarea>" +
            "<textarea id='where_cidades_parceiros' name='where_cidades_parceiros'>" + where_cidades_parceiros + "</textarea>" +
            "<textarea id='where_tipos_parceiros' name='where_tipos_parceiros'>" + where_tipos_parceiros + "</textarea>" +
            '</form>').appendTo('body').submit().remove();
        });

    });   
</script>

<h1>Relatório Dinâmico</h1>
<p>Abaixo se encontram-se os filtros que podem ser realizados no relatório geral do pronera.</p>
<!-- Nav tabs -->
 <ul class="nav nav-tabs" role="tablist">
   <li role="presentation" class="active"><a href="#cursos" aria-controls="cursos" role="tab" data-toggle="tab">Cursos</a></li>
   <li role="presentation"><a href="#educandos" aria-controls="educandos" role="tab" data-toggle="tab">Educandos</a></li>
   <li role="presentation"><a href="#professores" aria-controls="professores" role="tab" data-toggle="tab">Professores</a></li>
   <li role="presentation"><a href="#parceiros" aria-controls="parceiros" role="tab" data-toggle="tab">Parceiros</a></li>
 </ul>

 <!-- Tab panes -->
 <div class="tab-content">
    <div role="tabpanel" class="tab-pane fade in active" id="cursos">
        <div class="alert alert-warning" role="alert"><b>Cuidado!</b> Essa operação pode demorar para gerar o relatório. Portanto ao clicar em gerar, aguarde o tempo que for necessário.</div>
        <p>Possíveis filtros dos cursos:</p>
        <h3>Curso</h3>
        <p><b>Superintendência:</b> <select id="superintendencias-select"></select></p>
        <p><b>Cursos:</b> <select id="cursos-select"><option value="0" disabled selected>Todos os cursos</option></select></p>

        <h3>Modalidade</h3>
        <p><b>Modalidades:</b> <select id="modalidades-select"><option value="0" disabled selected>Todas as modalidades</option></select></p>

        <h3>Município</h3>
        <p><b>Estados:</b> <select id="estados-select"><option>Selecione um Estado</option></select></p>
        <p><b>Municípios:</b> <select id="municipios-select"><option value="0" disabled selected>Todos os municípios</option></select></p>
    </div>
   <div role="tabpanel" class="tab-pane fade" id="educandos">
       <div class="alert alert-warning" role="alert"><b>Cuidado!</b> Essa operação pode demorar para gerar o relatório. Portanto ao clicar em gerar, aguarde o tempo que for necessário.</div>
       <p>Possíveis filtros dos educandos:</p>
       <h3>Gênero</h3>
       <select id="genero_educando">
           <option value="0" disabled selected>Todos os gêneros</option>
           <option value="M">Masculino</option>
           <option value="F">Feminino</option>
           <option value="N">Não Informado</option>
       </select>
       <h3>Nascimento</h3>
       <b>Nascimento:</b> <input type="text" name="nascimento" id="nascimento" placeholder="Ex: 1990">
   </div>
   <div role="tabpanel" class="tab-pane fade" id="professores">
       <div class="alert alert-warning" role="alert"><b>Cuidado!</b> Essa operação pode demorar para gerar o relatório. Portanto ao clicar em gerar, aguarde o tempo que for necessário.</div>
       <p>Possíveis filtros dos professores:</p>
       <h3>Gênero</h3>
       <select id="genero_professor">
           <option value="0" disabled selected>Todos os gêneros</option>
           <option value="M">Masculino</option>
           <option value="F">Feminino</option>
           <option value="N">Não Informado</option>
       </select>
   </div>
   <div role="tabpanel" class="tab-pane fade" id="parceiros">
       <div class="alert alert-warning" role="alert"><b>Cuidado!</b> Essa operação pode demorar para gerar o relatório. Portanto ao clicar em gerar, aguarde o tempo que for necessário.</div>
       <p>Possíveis filtros dos parceiros:</p>
       <h3>Tipo de Parceria:</h3>
       <input type="checkbox" id="tipo_parceria" value="1">
       <label for="tipo_parceria">Usar Filtro?</label>

       <div id="filtros_tipo_parceria">
           <p>Para cada situação, se selecionado, quer dizer SIM e caso contrário NÃO.</p>
           <input type="checkbox" id="realizacao_curso" value=" AND realizacao = 1">
           <label for="realizacao_curso">Realização do Curso</label>
           <br>
           <input type="checkbox" id="certificacao_curso" value=" AND certificacao = 1">
           <label for="certificacao_curso">Certificação do Curso</label>
           <br>
           <input type="checkbox" id="gestao_orcamentaria" value=" AND gestao = 1">
           <label for="gestao_orcamentaria">Gestão Orçamentária</label>
           <br>
           <input type="checkbox" id="outras" value=" AND outros = 1">
           <label for="outras">Outras</label>
       </div>
   </div>
 </div>

<br>

<input type="button" id="gerar" class="btn btn-success" value="Gerar Relatório">
