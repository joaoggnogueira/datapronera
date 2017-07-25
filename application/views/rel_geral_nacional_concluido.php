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
        <legend><h3>Relat&oacute;rios Gerais - Concluido</h3></legend>
        <div class="alert alert-success">
            <i class="glyphicon glyphicon-alert"></i> Gerar em <b>PDF</b> pode demorar 5x mais que <b>XLS</b>
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        </div>
        <ul class="li-rel">
            <!--<li>
                    <h4>Informa&ccedil;&otilde;es da Pesquisa</h4>
                    <ul>
                            <li class="li-rel"><a href="relatorio/geral_pnera2/andamento_cursos.php">Andamento dos cursos por superintend&ecirc;ncia <span class="badge badge-nacional">total nacional</span></a></li>
                            <li class="li-rel"><a href="relatorio/geral_pnera2/formularios_superintendencia.php">Situa&ccedil;&atilde;o de preenchimento dos formul&aacute;rios por superintend&ecirc;ncia <span class="badge badge-nacional">total nacional</span></a></li>
                            <li class="li-rel"><a href="relatorio/geral_pnera2/formularios_modalidade.php">Situa&ccedil;&atilde;o de preenchimento dos formul&aacute;rios por modalidade <span class="badge badge-nacional">total nacional</span></a></li>
                    </ul>
                </li>

                    </br>-->

            <!--
                    <a class="btn btn-success" target="_blank" href="">XLS</a> 
                <a class="btn btn-success" target="_blank" href="">PDF</a>
            -->

            <li>
                <h4>Cursos</h4>
                <ul>
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/municipios_curso_modalidade/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/municipios_curso_modalidade/2'); ?>">PDF</a>
                        Munic&iacute;pios de realiza&ccedil;&atilde;o dos cursos por modalidade <span class="badge badge-nominal">nominal</span>
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
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/cursos_nivel_superintendencia/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/cursos_nivel_superintendencia/2'); ?>">PDF</a> 
                        Cursos por n&iacute;vel e superintend&ecirc;ncia <span class="badge badge-nacional">total nacional</span> 
                    </li>
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/cursos_superintendencia/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/cursos_superintendencia/2'); ?>">PDF</a> 
                        Cursos por superintend&ecirc;ncia <span class="badge badge-nacional">total nacional</span> 
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
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/alunos_ingressantes_superintendencia/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/alunos_ingressantes_superintendencia/2'); ?>">PDF</a> 
                        Alunos ingressantes por superintend&ecirc;ncia <span class="badge badge-nacional">total nacional</span>
                    </li>
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/alunos_ingressantes_nivel_sr/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/alunos_ingressantes_nivel_sr/2'); ?>">PDF</a> 
                        Alunos ingressantes por n&iacute;vel e superintend&ecirc;ncia <span class="badge badge-nacional">total nacional</span>
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
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/alunos_concluintes_superintendencia/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/alunos_concluintes_superintendencia/2'); ?>">PDF</a> 
                        Alunos concluintes por superintend&ecirc;ncia <span class="badge badge-nacional">total nacional</span>
                    </li>
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/alunos_concluintes_nivel_sr/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/alunos_concluintes_nivel_sr/2'); ?>">PDF</a> 
                        Alunos concluintes por n&iacute;vel e superintend&ecirc;ncia <span class="badge badge-nacional">total nacional</span>
                    </li>
                    <!--<li class="li-rel">
                            <a href="<?php //echo site_url('relatorio_geral_concluido/informacoes_relevantes');    ?>"><i>Informa&ccedil;&otilde;es Relevantes:
                                    <ul class="listNone">
                                            <li>Pocentagem (%) da titula&ccedil;&atilde;o dos coordenadores <span class="badge badge-nacional">total nacional</span></li>
                                            <li>Dura&ccedil;&atilde;o m&eacute;dia dos cursos em anos <span class="badge badge-nacional">total nacional</span></li>
                                            <li>N&uacute;mero de bolsistas que se envolveram nos cursos <span class="badge badge-nacional">total nacional</span></li>
                                    </ul></i>
                            </a>
                    </li>-->
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/lista_cursos_modalidade/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/lista_cursos_modalidade/2'); ?>">PDF</a> 
                        Lista de cursos por modalidade <span class="badge badge-nominal">nominal</span>
                    </li>
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/lista_cursos_modalidade_sr/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/lista_cursos_modalidade_sr/2'); ?>">PDF</a> 
                        Lista de cursos por modalidade e superintendência <span class="badge badge-nominal">nominal</span>
                    </li>
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/alunos_curso/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/alunos_curso/2'); ?>" disabled>PDF</a> 
                        Lista de alunos por curso <span class="badge badge-nominal">nominal</span>
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
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/titulacao_educadores_superintendencia/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/titulacao_educadores_superintendencia/2'); ?>">PDF</a> 
                        Escolaridade/titula&ccedil;&atilde;o dos educadores (%) por superintend&ecirc;ncia <span class="badge badge-nacional">total nacional</span>
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
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/educadores_superintendencia/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/educadores_superintendencia/2'); ?>">PDF</a> 
                        Educadores por superintend&ecirc;ncia <span class="badge badge-nacional">total nacional</span>
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
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/educandos_superintendencia/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/educandos_superintendencia/2'); ?>">PDF</a> 
                        Educandos por superintend&ecirc;ncia <span class="badge badge-nacional">total nacional</span>
                    </li>
                    
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
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/territorio_educandos_superintendencia/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/territorio_educandos_superintendencia/2'); ?>">PDF</a> 
                        Territ&oacute;rio de origem dos educandos por superintend&ecirc;ncia <span class="badge badge-nacional">total nacional</span>
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
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/educandos_assentamento_modalidade/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/educandos_assentamento_modalidade/2'); ?>">PDF</a> 
                        Educandos por assentamento e modalidade de curso <span class="badge badge-nacional">total nacional</span>
                    </li>
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/educandos_assentamento_nivel/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/educandos_assentamento_nivel/2'); ?>">PDF</a> 
                        Educandos por assentamento e n&iacute;vel de curso <span class="badge badge-nacional">total nacional</span>
                    </li>
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/lista_educandos_cursos_sr/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/lista_educandos_cursos_sr/2'); ?>">PDF</a> 
                        Educandos, superintendência e curso <span class="badge badge-nominal">nominal</span>
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
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/instituicoes_ensino_superintendencia/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/instituicoes_ensino_superintendencia/2'); ?>">PDF</a> 
                        Institui&ccedil;&otilde;es de ensino que realizaram cursos por superintend&ecirc;ncia <span class="badge badge-nacional">total nacional</span>
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
                    <li class="li-rel">
                        <a disabled class="btn btn-success" target="_blank" href="<?php //echo site_url('relatorio_geral_concluido/principais_organizacoes');    ?>">XLS</a> 
                        <a disabled class="btn btn-success" target="_blank" href="<?php //echo site_url('relatorio_geral_concluido/principais_organizacoes');    ?>">PDF</a> 
                        Seis principais organiza&ccedil;&otilde;es demandantes e respectivos cursos <span class="badge badge-nacional">total nacional</span> <span class="badge badge-municipio">por munic&iacute;pios</span>
                    </li>
                    
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
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/parceiros_superintendencia/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/parceiros_superintendencia/2'); ?>">PDF</a> 
                        Parceiros por superintend&ecirc;ncia <span class="badge badge-nacional">total nacional</span>
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
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/producoes_estado/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/producoes_estado/2'); ?>">PDF</a> 
                        Produ&ccedil;&otilde;es por tipo de produ&ccedil;&atilde;o <span class="badge badge-municipio">por estados</span> 
                    </li>
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/producoes_superintendencia/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/producoes_superintendencia/2'); ?>">PDF</a> 
                        Produ&ccedil;&otilde;es por tipo de produ&ccedil;&atilde;o <span class="badge">por superintend&ecirc;ncias</span> 
                    </li>
                    
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
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/pesquisa_estado/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/pesquisa_estado/2'); ?>">PDF</a> 
                        Produ&ccedil;&otilde;es por tipo de produ&ccedil;&atilde;o <span class="badge badge-municipio">por estados</span> 
                    </li>
                    
                    <li class="li-rel">
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/pesquisa_superintendencia/1'); ?>">XLS</a> 
                        <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_geral_concluido/pesquisa_superintendencia/2'); ?>">PDF</a> 
                        Produ&ccedil;&otilde;es por tipo de produ&ccedil;&atilde;o <span class="badge">por superintend&ecirc;ncias</span> 
                    </li>
                    
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