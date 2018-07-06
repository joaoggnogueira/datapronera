<?php $this->session->set_userdata('curr_content', 'rel_dinamico'); ?>

<style type="text/css">
    .tab-pane{
        padding:30px;
    }
</style>

<script type="text/javascript">

    $(document).ready(function() {

        $('#reset').click(function(){
            $('#superintendencias-select').prop('selectedIndex',0);
            $('#cursos-select').prop('selectedIndex',0);
            $('#modalidades-select').prop('selectedIndex',0);
            $('#municipios-select').prop('selectedIndex',0);
            $('#estados-select').prop('selectedIndex',0);
            $('#genero_educando').prop('selectedIndex',0);
            $('#genero_professor').prop('selectedIndex',0);
            $('#nascimento').val('');
            $('#modalidades').css('display', 'block');
            $('#municipios').css('display', 'block');
        });

        var url = "<?php echo site_url('relatorio_dinamico').'/'; ?>";

        // Carrega os selects para filtro
        $.get("<?php echo site_url('requisicao/get_superintendencias_cursos_rel'); ?>", function(data) {
            $('#superintendencias-select').html(data).css("width","300px").select2();
        });

        $('#superintendencias-select').change(function(){
            var url = "<?php echo site_url('requisicao/get_cursos_by_super_rel').'/'; ?>" + $('#superintendencias-select option:selected').val();
            $.get(url, function(cursos) {
                $('#cursos-select').html(cursos);
            });
        });

        $('#cursos-select').change(function(){
            if($('#cursos-select option:selected').val() == 0){
                $('#modalidades').css('display', 'block');
                $('#municipios').css('display', 'block');
            }else{
                $('#modalidades').css('display', 'none');
                $('#municipios').css('display', 'none');
            }
        });

        //niveis e modalidades
        $('#niveis-select').change(function(){
            if($('#niveis-select option:selected').val() == 0){
                $('#modalidades').css('display', 'block');
            }else{
                $('#modalidades').css('display', 'none');
            }
        });

        $('#modalidades-select').change(function(){
            if($('#modalidades-select option:selected').val() == 0){
                $('#niveis').css('display', 'block');
            }else{
                $('#niveis').css('display', 'none');
            }
        });

        $.get("<?php echo site_url('requisicao/get_modalidades_rel'); ?>", function(modalidades) {
            $('#modalidades-select').html(modalidades);
        });
        
        $('#modalidades-select').css("width","300px").select2();
        $('#status_curso').css("width","300px").select2();
        /* MUNICIPIOS */

        $.get("<?php echo site_url('requisicao/get_estados_rel'); ?>", function(data) {
            $('#estados-select').html(data);
        });

        $('#estados-select').change(function(){
            var url = "<?php echo site_url('requisicao/get_municipios_rel').'/'; ?>" + $('#estados-select option:selected').val();
            $.get(url, function(data) {
                $('#municipios-select').html(data).select2();
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
            // CAST(RIGHT(termino_realizado, 4) as SIGNED) BETWEEN 2005 AND 2010
 
            /** FILTROS DOS CURSOS **/
            var superintendencia = $('#superintendencias-select').val();
            var curso            = $('#cursos-select').val();
            var status_curso     = $('#status_curso').val();
            var modalidade       = $('#modalidades-select').val();
            var municipio        = $('#municipios-select').val();

            var nivel            = $('#niveis-select').val();

            var inicio0_realizado = $('#inicio0-realizado').val();
            var inicio1_realizado = $('#inicio1-realizado').val();
            var termino0_realizado = $('#termino0-realizado').val();
            var termino1_realizado = $('#termino1-realizado').val();

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

            /* WHERE NIVEIS */
            if(nivel != null && nivel != 0){
                if(nivel == 'EJA'){
                    where_curso                 += ' AND (cm.nome = "EJA ALFABETIZACAO" OR cm.nome = "EJA ANOS INICIAIS" OR cm.nome = "EJA ANOS FINAIS")';
                    where_cidade_cursos         += ' AND (cm.nome = "EJA ALFABETIZACAO" OR cm.nome = "EJA ANOS INICIAIS" OR cm.nome = "EJA ANOS FINAIS")';
                    where_educandos             += ' AND (cm.nome = "EJA ALFABETIZACAO" OR cm.nome = "EJA ANOS INICIAIS" OR cm.nome = "EJA ANOS FINAIS")';
                    where_cidade_educandos      += ' AND (cm.nome = "EJA ALFABETIZACAO" OR cm.nome = "EJA ANOS INICIAIS" OR cm.nome = "EJA ANOS FINAIS")';
                    where_professores           += ' AND (cm.nome = "EJA ALFABETIZACAO" OR cm.nome = "EJA ANOS INICIAIS" OR cm.nome = "EJA ANOS FINAIS")';
                    where_disciplinas           += ' AND (cm.nome = "EJA ALFABETIZACAO" OR cm.nome = "EJA ANOS INICIAIS" OR cm.nome = "EJA ANOS FINAIS")';
                    where_ie                    += ' AND (cm.nome = "EJA ALFABETIZACAO" OR cm.nome = "EJA ANOS INICIAIS" OR cm.nome = "EJA ANOS FINAIS")';
                    where_cidades_ie            += ' AND (cm.nome = "EJA ALFABETIZACAO" OR cm.nome = "EJA ANOS INICIAIS" OR cm.nome = "EJA ANOS FINAIS")';
                    where_org_demandantes       += ' AND (cm.nome = "EJA ALFABETIZACAO" OR cm.nome = "EJA ANOS INICIAIS" OR cm.nome = "EJA ANOS FINAIS")';
                    where_coord_org_demandantes += ' AND (cm.nome = "EJA ALFABETIZACAO" OR cm.nome = "EJA ANOS INICIAIS" OR cm.nome = "EJA ANOS FINAIS")';
                    where_parceiros             += ' AND (cm.nome = "EJA ALFABETIZACAO" OR cm.nome = "EJA ANOS INICIAIS" OR cm.nome = "EJA ANOS FINAIS")';
                    where_cidades_parceiros     += ' AND (cm.nome = "EJA ALFABETIZACAO" OR cm.nome = "EJA ANOS INICIAIS" OR cm.nome = "EJA ANOS FINAIS")';
                    where_tipos_parceiros       += ' AND (cm.nome = "EJA ALFABETIZACAO" OR cm.nome = "EJA ANOS INICIAIS" OR cm.nome = "EJA ANOS FINAIS")';
                }

                if(nivel == "EM"){
                    where_curso                 += ' AND (cm.nome = "EJA NIVEL MEDIO (MAGISTERIO/FORMAL)" OR cm.nome = "EJA NIVEL MEDIO (NORMAL)" OR cm.nome = "NIVEL MEDIO/TECNICO (CONCOMITANTE)" OR cm.nome = "NIVEL MEDIO/TECNICO (INTEGRADO)" OR cm.nome = "NIVEL MEDIO PROFISSIONAL (POS-MEDIO)")';
                    where_cidade_cursos         += ' AND (cm.nome = "EJA NIVEL MEDIO (MAGISTERIO/FORMAL)" OR cm.nome = "EJA NIVEL MEDIO (NORMAL)" OR cm.nome = "NIVEL MEDIO/TECNICO (CONCOMITANTE)" OR cm.nome = "NIVEL MEDIO/TECNICO (INTEGRADO)" OR cm.nome = "NIVEL MEDIO PROFISSIONAL (POS-MEDIO)")';
                    where_educandos             += ' AND (cm.nome = "EJA NIVEL MEDIO (MAGISTERIO/FORMAL)" OR cm.nome = "EJA NIVEL MEDIO (NORMAL)" OR cm.nome = "NIVEL MEDIO/TECNICO (CONCOMITANTE)" OR cm.nome = "NIVEL MEDIO/TECNICO (INTEGRADO)" OR cm.nome = "NIVEL MEDIO PROFISSIONAL (POS-MEDIO)")';
                    where_cidade_educandos      += ' AND (cm.nome = "EJA NIVEL MEDIO (MAGISTERIO/FORMAL)" OR cm.nome = "EJA NIVEL MEDIO (NORMAL)" OR cm.nome = "NIVEL MEDIO/TECNICO (CONCOMITANTE)" OR cm.nome = "NIVEL MEDIO/TECNICO (INTEGRADO)" OR cm.nome = "NIVEL MEDIO PROFISSIONAL (POS-MEDIO)")';
                    where_professores           += ' AND (cm.nome = "EJA NIVEL MEDIO (MAGISTERIO/FORMAL)" OR cm.nome = "EJA NIVEL MEDIO (NORMAL)" OR cm.nome = "NIVEL MEDIO/TECNICO (CONCOMITANTE)" OR cm.nome = "NIVEL MEDIO/TECNICO (INTEGRADO)" OR cm.nome = "NIVEL MEDIO PROFISSIONAL (POS-MEDIO)")';
                    where_disciplinas           += ' AND (cm.nome = "EJA NIVEL MEDIO (MAGISTERIO/FORMAL)" OR cm.nome = "EJA NIVEL MEDIO (NORMAL)" OR cm.nome = "NIVEL MEDIO/TECNICO (CONCOMITANTE)" OR cm.nome = "NIVEL MEDIO/TECNICO (INTEGRADO)" OR cm.nome = "NIVEL MEDIO PROFISSIONAL (POS-MEDIO)")';
                    where_ie                    += ' AND (cm.nome = "EJA NIVEL MEDIO (MAGISTERIO/FORMAL)" OR cm.nome = "EJA NIVEL MEDIO (NORMAL)" OR cm.nome = "NIVEL MEDIO/TECNICO (CONCOMITANTE)" OR cm.nome = "NIVEL MEDIO/TECNICO (INTEGRADO)" OR cm.nome = "NIVEL MEDIO PROFISSIONAL (POS-MEDIO)")';
                    where_cidades_ie            += ' AND (cm.nome = "EJA NIVEL MEDIO (MAGISTERIO/FORMAL)" OR cm.nome = "EJA NIVEL MEDIO (NORMAL)" OR cm.nome = "NIVEL MEDIO/TECNICO (CONCOMITANTE)" OR cm.nome = "NIVEL MEDIO/TECNICO (INTEGRADO)" OR cm.nome = "NIVEL MEDIO PROFISSIONAL (POS-MEDIO)")';
                    where_org_demandantes       += ' AND (cm.nome = "EJA NIVEL MEDIO (MAGISTERIO/FORMAL)" OR cm.nome = "EJA NIVEL MEDIO (NORMAL)" OR cm.nome = "NIVEL MEDIO/TECNICO (CONCOMITANTE)" OR cm.nome = "NIVEL MEDIO/TECNICO (INTEGRADO)" OR cm.nome = "NIVEL MEDIO PROFISSIONAL (POS-MEDIO)")';
                    where_coord_org_demandantes += ' AND (cm.nome = "EJA NIVEL MEDIO (MAGISTERIO/FORMAL)" OR cm.nome = "EJA NIVEL MEDIO (NORMAL)" OR cm.nome = "NIVEL MEDIO/TECNICO (CONCOMITANTE)" OR cm.nome = "NIVEL MEDIO/TECNICO (INTEGRADO)" OR cm.nome = "NIVEL MEDIO PROFISSIONAL (POS-MEDIO)")';
                    where_parceiros             += ' AND (cm.nome = "EJA NIVEL MEDIO (MAGISTERIO/FORMAL)" OR cm.nome = "EJA NIVEL MEDIO (NORMAL)" OR cm.nome = "NIVEL MEDIO/TECNICO (CONCOMITANTE)" OR cm.nome = "NIVEL MEDIO/TECNICO (INTEGRADO)" OR cm.nome = "NIVEL MEDIO PROFISSIONAL (POS-MEDIO)")';
                    where_cidades_parceiros     += ' AND (cm.nome = "EJA NIVEL MEDIO (MAGISTERIO/FORMAL)" OR cm.nome = "EJA NIVEL MEDIO (NORMAL)" OR cm.nome = "NIVEL MEDIO/TECNICO (CONCOMITANTE)" OR cm.nome = "NIVEL MEDIO/TECNICO (INTEGRADO)" OR cm.nome = "NIVEL MEDIO PROFISSIONAL (POS-MEDIO)")';
                    where_tipos_parceiros       += ' AND (cm.nome = "EJA NIVEL MEDIO (MAGISTERIO/FORMAL)" OR cm.nome = "EJA NIVEL MEDIO (NORMAL)" OR cm.nome = "NIVEL MEDIO/TECNICO (CONCOMITANTE)" OR cm.nome = "NIVEL MEDIO/TECNICO (INTEGRADO)" OR cm.nome = "NIVEL MEDIO PROFISSIONAL (POS-MEDIO)")';
                }

                if(nivel == 'ES'){
                    where_curso                 += ' AND (cm.nome = "GRADUACAO" OR cm.nome = "ESPECIALIZACAO" OR cm.nome = "RESIDENCIA AGRARIA" OR cm.nome = "MESTRADO" OR cm.nome = "DOUTORADO")';
                    where_cidade_cursos         += ' AND (cm.nome = "GRADUACAO" OR cm.nome = "ESPECIALIZACAO" OR cm.nome = "RESIDENCIA AGRARIA" OR cm.nome = "MESTRADO" OR cm.nome = "DOUTORADO")';
                    where_educandos             += ' AND (cm.nome = "GRADUACAO" OR cm.nome = "ESPECIALIZACAO" OR cm.nome = "RESIDENCIA AGRARIA" OR cm.nome = "MESTRADO" OR cm.nome = "DOUTORADO")';
                    where_cidade_educandos      += ' AND (cm.nome = "GRADUACAO" OR cm.nome = "ESPECIALIZACAO" OR cm.nome = "RESIDENCIA AGRARIA" OR cm.nome = "MESTRADO" OR cm.nome = "DOUTORADO")';
                    where_professores           += ' AND (cm.nome = "GRADUACAO" OR cm.nome = "ESPECIALIZACAO" OR cm.nome = "RESIDENCIA AGRARIA" OR cm.nome = "MESTRADO" OR cm.nome = "DOUTORADO")';
                    where_disciplinas           += ' AND (cm.nome = "GRADUACAO" OR cm.nome = "ESPECIALIZACAO" OR cm.nome = "RESIDENCIA AGRARIA" OR cm.nome = "MESTRADO" OR cm.nome = "DOUTORADO")';
                    where_ie                    += ' AND (cm.nome = "GRADUACAO" OR cm.nome = "ESPECIALIZACAO" OR cm.nome = "RESIDENCIA AGRARIA" OR cm.nome = "MESTRADO" OR cm.nome = "DOUTORADO")';
                    where_cidades_ie            += ' AND (cm.nome = "GRADUACAO" OR cm.nome = "ESPECIALIZACAO" OR cm.nome = "RESIDENCIA AGRARIA" OR cm.nome = "MESTRADO" OR cm.nome = "DOUTORADO")';
                    where_org_demandantes       += ' AND (cm.nome = "GRADUACAO" OR cm.nome = "ESPECIALIZACAO" OR cm.nome = "RESIDENCIA AGRARIA" OR cm.nome = "MESTRADO" OR cm.nome = "DOUTORADO")';
                    where_coord_org_demandantes += ' AND (cm.nome = "GRADUACAO" OR cm.nome = "ESPECIALIZACAO" OR cm.nome = "RESIDENCIA AGRARIA" OR cm.nome = "MESTRADO" OR cm.nome = "DOUTORADO")';
                    where_parceiros             += ' AND (cm.nome = "GRADUACAO" OR cm.nome = "ESPECIALIZACAO" OR cm.nome = "RESIDENCIA AGRARIA" OR cm.nome = "MESTRADO" OR cm.nome = "DOUTORADO")';
                    where_cidades_parceiros     += ' AND (cm.nome = "GRADUACAO" OR cm.nome = "ESPECIALIZACAO" OR cm.nome = "RESIDENCIA AGRARIA" OR cm.nome = "MESTRADO" OR cm.nome = "DOUTORADO")';
                    where_tipos_parceiros       += ' AND (cm.nome = "GRADUACAO" OR cm.nome = "ESPECIALIZACAO" OR cm.nome = "RESIDENCIA AGRARIA" OR cm.nome = "MESTRADO" OR cm.nome = "DOUTORADO")';
                }
            }

            /* WHERE SUPERINTENDENCIA */
            if(superintendencia != null && superintendencia != 0){
                where_superintendencias += 'AND s.id ='+superintendencia;
                where_curso += ' AND c.id_superintendencia ='+superintendencia;
                where_cidade_cursos += ' AND c.id_superintendencia ='+superintendencia;
                where_cidade_educandos += ' AND cs.id_superintendencia ='+superintendencia;
                where_professores += ' AND c.id_superintendencia ='+superintendencia;
                where_disciplinas += ' AND c.id_superintendencia ='+superintendencia;
                where_ie += ' AND c.id_superintendencia ='+superintendencia;
                where_cidades_ie += ' AND cs.id_superintendencia ='+superintendencia;
                where_org_demandantes += ' AND c.id_superintendencia ='+superintendencia;
                where_coord_org_demandantes += ' AND cs.id_superintendencia ='+superintendencia;
                where_parceiros += ' AND c.id_superintendencia ='+superintendencia;
                where_cidades_parceiros += ' AND cp.id_superintendencia ='+superintendencia;
                where_tipos_parceiros += ' AND c.id_superintendencia ='+superintendencia;
            }

            /* WHERE CAMPO CURSO */
            if(curso != null && curso != 0){
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

            /* WHERE CAMPO PERIODO INICIO */
            if(inicio0_realizado != null && inicio0_realizado != 0 && inicio1_realizado != null && inicio1_realizado != 0){
                where_curso                 += ' AND CAST(RIGHT(cr.inicio_realizado, 4) as SIGNED) BETWEEN '+inicio0_realizado+' AND '+inicio1_realizado;
                where_cidade_cursos         += ' AND CAST(RIGHT(cr.inicio_realizado, 4) as SIGNED) BETWEEN '+inicio0_realizado+' AND '+inicio1_realizado;
                where_educandos             += ' AND CAST(RIGHT(cr.inicio_realizado, 4) as SIGNED) BETWEEN '+inicio0_realizado+' AND '+inicio1_realizado;
                where_cidade_educandos      += ' AND CAST(RIGHT(cr.inicio_realizado, 4) as SIGNED) BETWEEN '+inicio0_realizado+' AND '+inicio1_realizado;
                where_professores           += ' AND CAST(RIGHT(cr.inicio_realizado, 4) as SIGNED) BETWEEN '+inicio0_realizado+' AND '+inicio1_realizado;
                where_disciplinas           += ' AND CAST(RIGHT(cr.inicio_realizado, 4) as SIGNED) BETWEEN '+inicio0_realizado+' AND '+inicio1_realizado;
                where_ie                    += ' AND CAST(RIGHT(cr.inicio_realizado, 4) as SIGNED) BETWEEN '+inicio0_realizado+' AND '+inicio1_realizado;
                where_cidades_ie            += ' AND CAST(RIGHT(cr.inicio_realizado, 4) as SIGNED) BETWEEN '+inicio0_realizado+' AND '+inicio1_realizado;
                where_org_demandantes       += ' AND CAST(RIGHT(cr.inicio_realizado, 4) as SIGNED) BETWEEN '+inicio0_realizado+' AND '+inicio1_realizado;
                where_coord_org_demandantes += ' AND CAST(RIGHT(cr.inicio_realizado, 4) as SIGNED) BETWEEN '+inicio0_realizado+' AND '+inicio1_realizado;
                where_parceiros             += ' AND CAST(RIGHT(cr.inicio_realizado, 4) as SIGNED) BETWEEN '+inicio0_realizado+' AND '+inicio1_realizado;
                where_cidades_parceiros     += ' AND CAST(RIGHT(cr.inicio_realizado, 4) as SIGNED) BETWEEN '+inicio0_realizado+' AND '+inicio1_realizado;
                where_tipos_parceiros       += ' AND CAST(RIGHT(cr.inicio_realizado, 4) as SIGNED) BETWEEN '+inicio0_realizado+' AND '+inicio1_realizado;
            }

            /* WHERE CAMPO PERIODO TÉRMINO */
            if(termino0_realizado != null && termino0_realizado != 0 && termino1_realizado != null && termino1_realizado != 0){
                where_curso                 += ' AND CAST(RIGHT(cr.termino_realizado, 4) as SIGNED) BETWEEN '+termino0_realizado+' AND '+termino1_realizado;
                where_cidade_cursos         += ' AND CAST(RIGHT(cr.termino_realizado, 4) as SIGNED) BETWEEN '+termino0_realizado+' AND '+termino1_realizado;
                where_educandos             += ' AND CAST(RIGHT(cr.termino_realizado, 4) as SIGNED) BETWEEN '+termino0_realizado+' AND '+termino1_realizado;
                where_cidade_educandos      += ' AND CAST(RIGHT(cr.termino_realizado, 4) as SIGNED) BETWEEN '+termino0_realizado+' AND '+termino1_realizado;
                where_professores           += ' AND CAST(RIGHT(cr.termino_realizado, 4) as SIGNED) BETWEEN '+termino0_realizado+' AND '+termino1_realizado;
                where_disciplinas           += ' AND CAST(RIGHT(cr.termino_realizado, 4) as SIGNED) BETWEEN '+termino0_realizado+' AND '+termino1_realizado;
                where_ie                    += ' AND CAST(RIGHT(cr.termino_realizado, 4) as SIGNED) BETWEEN '+termino0_realizado+' AND '+termino1_realizado;
                where_cidades_ie            += ' AND CAST(RIGHT(cr.termino_realizado, 4) as SIGNED) BETWEEN '+termino0_realizado+' AND '+termino1_realizado;
                where_org_demandantes       += ' AND CAST(RIGHT(cr.termino_realizado, 4) as SIGNED) BETWEEN '+termino0_realizado+' AND '+termino1_realizado;
                where_coord_org_demandantes += ' AND CAST(RIGHT(cr.termino_realizado, 4) as SIGNED) BETWEEN '+termino0_realizado+' AND '+termino1_realizado;
                where_parceiros             += ' AND CAST(RIGHT(cr.termino_realizado, 4) as SIGNED) BETWEEN '+termino0_realizado+' AND '+termino1_realizado;
                where_cidades_parceiros     += ' AND CAST(RIGHT(cr.termino_realizado, 4) as SIGNED) BETWEEN '+termino0_realizado+' AND '+termino1_realizado;
                where_tipos_parceiros       += ' AND CAST(RIGHT(cr.termino_realizado, 4) as SIGNED) BETWEEN '+termino0_realizado+' AND '+termino1_realizado;
            }

            /* WHERE CAMPO MODALIDADE */
            if(modalidade != null && modalidade != 0){
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
            if(municipio != null && municipio != 0){
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
            if(genero_educando != null && genero_educando != 0){
                where_educandos += ' AND e.genero = "'+genero_educando+'"';
            }

            /* WHERE CAMPO GENERO_PROFESSOR */
            if(genero_professor != null && genero_professor != 0){
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
                where_parceiros         += ' AND p.id IN (SELECT a.id_parceiro FROM `parceiro_parceria` a, `parceiro` b, `curso` d WHERE a.id_parceiro = b.id AND b.id_curso = d.id AND d.ativo_inativo = "A" '+where_aux+')';
                where_cidades_parceiros += ' AND p.id IN (SELECT a.id_parceiro FROM `parceiro_parceria` a, `parceiro` b, `curso` d WHERE a.id_parceiro = b.id AND b.id_curso = d.id AND d.ativo_inativo = "A" '+where_aux+')';
            }

            /* WHERE CAMPO STATUS */
            if(status_curso != null && status_curso != 0){
                where_curso                 += ' AND c.status ="' + status_curso+'"';
                where_cidade_cursos         += ' AND c.status ="'+status_curso+'"';
                where_educandos             += ' AND c.status ="'+status_curso+'"';
                where_cidade_educandos      += ' AND cs.status ="'+status_curso+'"';
                where_professores           += ' AND c.status ="'+status_curso+'"';
                where_disciplinas           += ' AND c.status ="'+status_curso+'"';
                where_ie                    += ' AND c.status ="'+status_curso+'"';
                where_cidades_ie            += ' AND cs.status ="'+status_curso+'"';
                where_org_demandantes       += ' AND c.status ="'+status_curso+'"';
                where_coord_org_demandantes += ' AND cs.status ="'+status_curso+'"';
                where_parceiros             += ' AND c.status ="'+status_curso+'"';
                where_cidades_parceiros     += ' AND cp.status ="'+status_curso+'"';
                where_tipos_parceiros       += ' AND c.status ="'+status_curso+'"';
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
        $("#estados-select").css("width","300px").select2();
        $("#municipios-select").css("width","300px").select2();
        $("#genero_educando").css("width","200px").select2();
        $("#genero_professor").css("width","200px").select2();	
		
		$(".data-inicio").blur(function(){			
			$(this).next(".data-fim").attr( "min", $(this).val() );
			
			if( $(this).val() < 1998 )
				$(this).val( 1998 );
				
			if( $(this).val() > <?= date("Y") ?> )
				$(this).val( <?= date("Y") ?> );
			
			if( $(this).val() > $(this).next(".data-fim").val() )
				$(this).next(".data-fim").val( $(this).val() );
		});
		
		$(".data-fim").blur(function(){
			if( $(this).val() < $(this).prev(".data-inicio").val() )
				$(this).val( $(this).prev(".data-inicio").val() );		
			
			if( $(this).val() < 1998 )
				$(this).val( 1998 );
				
			if( $(this).val() > <?= date("Y") ?> )
				$(this).val( <?= date("Y") ?> );			
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
        <h3>Curso</h3>
        <p><b>Superintendência:</b> <select id="superintendencias-select"></select></p>
        <p><b>Cursos:</b> <select id="cursos-select"><option value="0" selected>Todos os cursos</option></select></p>
        <hr/>
        <h3>Status do Cadastro do Curso</h3>
        <select id="status_curso">
            <option value="0" selected>Todos os status</option>
            <option value="CC">Concluídos</option>
            <option value="AN">Em andamento</option>
            <option value="2P">II PNERA</option>
        </select>
        <hr/>
        <h3>Período de Início Realizado (Ano)</h3>
        <p><input type="number" id="inicio0-realizado" class="form-control data-inicio" style="max-width: 102px; display: inline;" min = "1998" placeholder="Ex: 2010"> à <input type="number" min="1998" id="inicio1-realizado" class="form-control data-fim" style="max-width: 102px; display: inline;" placeholder="Ex: 2010"></p>
        <h3>Período de Término Realizado (Ano)</h3>
        <p><input type="number" id="termino0-realizado" class="form-control data-inicio" style="max-width: 102px; display: inline;" min = "1998" placeholder="Ex: 2010"> à <input type="number" min="1998" id="termino1-realizado" class="form-control data-fim" style="max-width: 102px; display: inline;" placeholder="Ex: 2010"></p>
        <hr/>
        <div id="modalidades">
            <h3>Modalidade</h3>
            <p><b>Modalidades:</b> <select id="modalidades-select"><option value="0" selected>Todas as modalidades</option></select></p>
        </div>
        <div id="niveis">
            <h3>Nível</h3>
            <p><b>Nível:</b> 
            <select id="niveis-select">
                <option value="0" selected>Todos os Níveis</option>
                <option value="EJA">EJA FUNDAMENTAL</option>
                <option value="EM">ENSINO MÉDIO</option>
                <option value="ES">ENSINO SUPERIOR</option>
            </select>
            </p>
        </div>
        <hr/>
        <div id="municipios">
            <h3>Município</h3>
            <p><b>Estados:</b> <select id="estados-select"><option>Selecione um Estado</option></select></p>
            <p><b>Municípios:</b> <select id="municipios-select"><option value="0" selected>Todos os municípios</option></select></p>
        </div>
    </div>
   <div role="tabpanel" class="tab-pane fade" id="educandos">
       <h3>Gênero</h3>
       <select id="genero_educando">
           <option value="0" selected>Todos os gêneros</option>
           <option value="M">Masculino</option>
           <option value="F">Feminino</option>
           <option value="N">Não Informado</option>
       </select>
       <h3>Ano de nascimento</h3>
       <input type="text" name="nascimento" id="nascimento" placeholder="Ex: 1990" class="form-control">
   </div>
   <div role="tabpanel" class="tab-pane fade" id="professores">
       <h3>Gênero</h3>
       <select id="genero_professor">
           <option value="0" selected>Todos os gêneros</option>
           <option value="M">Masculino</option>
           <option value="F">Feminino</option>
           <option value="N">Não Informado</option>
       </select>
   </div>
   <div role="tabpanel" class="tab-pane fade" id="parceiros">
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

<input type="button" id="gerar" class="btn btn-success" value="Gerar Planilha">
<input type="button" id="reset" class="btn btn-warning" value="Resetar filtros">
