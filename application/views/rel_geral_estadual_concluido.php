<style>
    .modal{
        z-index: 10001;
    }

    .modal-backdrop.fade.in{
        z-index: 10000;
    }

    .select2-container{
        z-index: 10001;
    }

    .badge{
        text-transform: uppercase;
    }

    .badge-alert{
        background: #A55;
    }

    .badge-nominal{
        background: #0078ae;
    }

    .badge-nacional{
        background: #999999;
    }

    .badge-municipio{
        background: #777777;
    }

    .li-rel{
        margin-bottom: 10px;
    }

    .li-rel .btn.btn-success{
        color:black;
    }
</style>
<form>
    <fieldset>
        <legend><h3>Relat&oacute;rios Gerais - Concluído</h3></legend>
        <label>Superintendência: <b class="super-desc"></b></label>
        <ul class="li-rel">
            <li>
                <h4>Cursos</h4>
                <ul>
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/municipios_curso_modalidade/1'); ?>">XLS</a>  
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/municipios_curso_modalidade/2'); ?>">PDF</a>
                        Munic&iacute;pios de realiza&ccedil;&atilde;o dos cursos por modalidade  <span class="badge badge-nominal">nominal</span> 
                    </li>
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/municipios_curso/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/municipios_curso/2'); ?>">PDF</a>
                        Munic&iacute;pios de realiza&ccedil;&atilde;o dos cursos <span class="badge badge-nacional">total nacional</span> 
                    </li>
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/cursos_modalidade/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/cursos_modalidade/2'); ?>">PDF</a>
                        Cursos por modalidade <span class="badge badge-nacional">total nacional</span> 
                    </li>
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/cursos_nivel/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/cursos_nivel/2'); ?>">PDF</a> 
                        Cursos por n&iacute;vel <span class="badge badge-nacional">total nacional</span> 
                    </li>
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/alunos_ingressantes_modalidade/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/alunos_ingressantes_modalidade/2'); ?>">PDF</a> 
                        Alunos ingressantes por modalidade <span class="badge badge-nacional">total nacional</span> 
                    </li>
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/alunos_ingressantes_nivel/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/alunos_ingressantes_nivel/2'); ?>">PDF</a> 
                        Alunos ingressantes por n&iacute;vel <span class="badge badge-nacional">total nacional</span> 
                    </li>
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/alunos_concluintes_modalidade/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/alunos_concluintes_modalidade/2'); ?>">PDF</a> 
                        Alunos concluintes por modalidade <span class="badge badge-nacional">total nacional</span> 
                    </li>
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/alunos_concluintes_nivel/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/alunos_concluintes_nivel/2'); ?>">PDF</a> 
                        Alunos concluintes por n&iacute;vel <span class="badge badge-nacional">total nacional</span> 
                    </li>
                    <!--<li class="li-rel">
                            <a href="<?php //echo site_url('relatorio_geral_concluido/informacoes_relevantes');  ?>"><i>Informa&ccedil;&otilde;es Relevantes:
                                    <ul class="listNone">
                                            <li>Pocentagem (%) da titula&ccedil;&atilde;o dos coordenadores <b>(total da superintend&ecirc;ncia)</b></li>
                                            <li>Dura&ccedil;&atilde;o m&eacute;dia dos cursos em anos <b>(total da superintend&ecirc;ncia)</b></li>
                                            <li>N&uacute;mero de bolsistas que se envolveram nos cursos <b>(total da superintend&ecirc;ncia)</b></li>
                                    </ul></i>
                            </a>
                    </li>-->
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/lista_cursos_modalidade/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/lista_cursos_modalidade/2'); ?>">PDF</a> 
                        Lista de cursos por modalidade <span class="badge badge-nominal">nominal</span> 
                    </li>
                </ul>
                <hr/>
            </li>

            <li>
                <h4>Professores/Educadores</h4>
                <ul>
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/titulacao_educadores/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/titulacao_educadores/2'); ?>">PDF</a> 
                        Escolaridade/titula&ccedil;&atilde;o dos educadores (%) <span class="badge badge-nacional">total nacional</span> 
                    </li>
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/educadores_nivel/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/educadores_nivel/2'); ?>">PDF</a> 
                        Educadores por n&iacute;vel <span class="badge badge-nacional">total nacional</span> 
                    </li>
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/educadores_curso/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/educadores_curso/2'); ?>">PDF</a> 
                        Educadores por curso <span class="badge badge-nacional">total nacional</span> 
                    </li>
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/genero_educadores_modalidade/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/genero_educadores_modalidade/2'); ?>">PDF</a> 
                        Participa&ccedil;&atilde;o (%) de homens e mulheres como educadores dos cursos por modalidade <span class="badge badge-nacional">total nacional</span> 
                    </li>
                </ul>
                <hr/>
            </li>

            <li>
                <h4>Educandos</h4>
                <ul>
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/municipio_origem_educandos/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/municipio_origem_educandos/2'); ?>">PDF</a> 
                        Munic&iacute;pio de origem dos educandos <span class="badge badge-nacional">total nacional</span> 
                    </li>
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/territorio_educandos_modalidade/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/territorio_educandos_modalidade/2'); ?>">PDF</a> 
                        Territ&oacute;rio de origem dos educandos por modalidade <span class="badge badge-nacional">total nacional</span> 
                    </li>
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/idade_educandos_modalidade/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/idade_educandos_modalidade/2'); ?>">PDF</a> 
                        Idade m&eacute;dia dos educandos por modalidade <span class="badge badge-nacional">total nacional</span> 
                    </li>
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/genero_educandos_modalidade/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/genero_educandos_modalidade/2'); ?>">PDF</a> 
                        Participa&ccedil;&atilde;o (%) de homens e mulheres como educandos nos cursos por modalidade <span class="badge badge-nacional">total nacional</span> 
                    </li>
                </ul>
                <hr/>
            </li>

            <li>
                <h4>Institui&ccedil;&otilde;es de Ensino</h4>
                <ul>
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/localizacao_instituicoes_ensino/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/localizacao_instituicoes_ensino/2'); ?>">PDF</a> 
                        Localiza&ccedil;&atilde;o das institui&ccedil;&otilde;es de ensino <span class="badge badge-municipio">por munic&iacute;pios</span>
                    </li>
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/instituicoes_ensino_modalidade/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/instituicoes_ensino_modalidade/2'); ?>">PDF</a> 
                        Institui&ccedil;&otilde;es de ensino que realizaram cursos por modalidade <span class="badge badge-nacional">total nacional</span> 
                    </li>
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/instituicoes_ensino_nivel/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/instituicoes_ensino_nivel/2'); ?>">PDF</a> 
                        Institui&ccedil;&otilde;es de ensino que realizaram cursos por n&iacute;vel <span class="badge badge-nacional">total nacional</span> 
                    </li>
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/instituicoes_ensino_municipio/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/instituicoes_ensino_municipio/2'); ?>">PDF</a> 
                        Institui&ccedil;&otilde;es de ensino que realizaram cursos por munic&iacute;pios <span class="badge badge-nacional">total nacional</span> 
                    </li>
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/instituicoes_ensino_estado/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/instituicoes_ensino_estado/2'); ?>">PDF</a> 
                        Institui&ccedil;&otilde;es de ensino que realizaram cursos por estados <span class="badge badge-nacional">total nacional</span> 
                    </li>
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/cursos_natureza_inst_ensino/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/cursos_natureza_inst_ensino/2'); ?>">PDF</a> 
                        Natureza das institui&ccedil;&otilde;es de ensino e n&uacute;mero de cursos realizados <span class="badge badge-nacional">total nacional</span> 
                    </li>
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/instituicao_ensino_cursos/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/instituicao_ensino_cursos/2'); ?>">PDF</a> 
                        Lista das institui&ccedil;&otilde;es de ensino e n&uacute;mero de cursos realizados <span class="badge badge-nominal">nominal</span> 
                    </li>
                </ul>
                <hr/>
            </li>

            <li>
                <h4>Organiza&ccedil;&otilde;es Demandantes</h4>
                <ul>
                        <!--<li class="li-rel"><a href="<?php //echo site_url('relatorio_geral_concluido/principais_organizacoes');  ?>"><i>Seis principais organiza&ccedil;&otilde;es demandantes e respectivos cursos <b>(superintend&ecirc;ncia - por munic&iacute;pios)</b></i></a></li>-->
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/organizacoes_demandantes_modalidade/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/organizacoes_demandantes_modalidade/2'); ?>">PDF</a> 
                        Organiza&ccedil;&otilde;es demandantes por modalidade <span class="badge badge-nacional">total nacional</span> 
                    </li>
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/membros_org_demandantes_modalidade/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/membros_org_demandantes_modalidade/2'); ?>">PDF</a> 
                        Porcentagem dos membros das organiza&ccedil;&otilde;es demandantes participantes de cursos por modalidade
                            <span class="badge badge-nacional">total nacional</span> 
                    </li>
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/organizacao_demandante_cursos/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/organizacao_demandante_cursos/2'); ?>">PDF</a> 
                        Lista das organiza&ccedil;&otilde;es demandantes e n&uacute;mero de cursos demandados <span class="badge badge-nominal">nominal</span> 
                    </li>
                </ul>
                <hr/>
            </li>

            <li>
                <h4>Parceiros</h4>
                <ul>
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/localizacao_parceiros/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/localizacao_parceiros/2'); ?>">PDF</a> 
                        Localiza&ccedil;&atilde;o dos parceiros <span class="badge badge-municipio">por munic&iacute;pios</span>
                    </li>
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/parceiros_modalidade/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/parceiros_modalidade/2'); ?>">PDF</a> 
                        Parceiros por modalidade <span class="badge badge-nacional">total nacional</span> 
                    </li>
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/parceiros_natureza/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/parceiros_natureza/2'); ?>">PDF</a> 
                        Parceiros por natureza da parceria <span class="badge badge-nacional">total nacional</span> 
                    </li>
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/lista_parceiros/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/lista_parceiros/2'); ?>">PDF</a> 
                        Lista dos parceiros <span class="badge badge-nominal">nominal</span> 
                    </li>
                </ul>
                <hr/>
            </li>

            <li>
                <h4>Produ&ccedil;&otilde;es Bibliogr&aacute;ficas do PRONERA</h4>
                <ul>
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/producoes_tipo/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/producoes_tipo/2'); ?>">PDF</a> 
                        Produ&ccedil;&otilde;es por tipo de produ&ccedil;&atilde;o <span class="badge badge-nacional">total nacional</span> 
                    </li>
                </ul>
                <hr/>
            </li>

            <li>
                <h4>Produ&ccedil;&otilde;es Bibliogr&aacute;ficas sobre o PRONERA</h4>
                <ul>
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/pesquisa_tipo/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/pesquisa_tipo/2'); ?>">PDF</a> 
                        Produ&ccedil;&otilde;es por tipo de produ&ccedil;&atilde;o <span class="badge badge-nacional">total nacional</span> 
                    </li>
                </ul>
            </li>
        </ul>
    </fieldset>
</form>
<script>

    $(document).ready(function () {
        $(".badge-nominal").each(function () {
            this.innerHTML = '<i class="glyphicon glyphicon-list"></i> ' + this.innerHTML;
        });
        $(".badge-alert").each(function () {
            this.innerHTML = '<i class="glyphicon glyphicon-time"></i> ' + this.innerHTML;
        });
        $(".badge-municipio").each(function () {
            this.innerHTML = '<i class="glyphicon glyphicon-map-marker"></i> ' + this.innerHTML;
        });

    });

</script>
<script>

    $(document).ready(function () {

        $.get("<?php echo site_url('requisicao/echo_get_superintendencias_nome'); ?>/1/<?= $this->session->userdata('id_superintendencia') ?>", function (result) {
            $(".super-desc").html(result);
        });

    });

</script>