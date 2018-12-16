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

    .btn.btn-success{
        color:white;
        font-weight: bold;
    }

    .row_checkbox{
        display: flex;
        flex-direction: row;
    }
    .row_checkbox label{
        margin-left: 10px;
    }
    .row_checkbox:hover label{
        color: #003bb3;
    }

    .group_checkbox{
        flex-direction: row;
        justify-content: space-between;
        display: flex;
        align-items: center;
        padding: 0px 5px;
        border-bottom: 1px solid #AAA;
        background: white;
        position: fixed;
        width: 960px;
    }

</style>
<form>
    <fieldset>
        <legend><h3>Relat&oacute;rios Gerais</h3></legend>
        <div class="group_checkbox" id="scrollingDiv">
            <h4>Status do Curso</h4>
            <div class="row_checkbox form-check">
                <input checked type="checkbox" name="status" class="check_status" value="AN" id="status_checkbox_an"/>
                <label for="status_checkbox_an"> Cursos em Andamento</label>
            </div>
            <div class="row_checkbox form-check">
                <input checked type="checkbox" name="status" value="CC" class="check_status" id="status_checkbox_cc"/>
                <label for="status_checkbox_cc"> Cursos Concluídos</label>
            </div>
            <div class="row_checkbox form-check">
                <input checked type="checkbox" name="status" value="2P" class="check_status" id="status_checkbox_2p"/>
                <label for="status_checkbox_2p"> Cursos do PNERA II</label>
            </div>
        </div>
        <ul class="li-rel" style="margin-top: 80px">
            <li>
                <h4>Cursos</h4>
                <ul>
                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/municipios_curso_modalidade/1'); ?>">XLS</a>  
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/municipios_curso_modalidade/2'); ?>">PDF</a>
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/municipios_curso_modalidade/3'); ?>">HTML</a>
                        Munic&iacute;pios de realiza&ccedil;&atilde;o dos cursos por modalidade <span class="badge badge-nominal">nominal</span>  
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/municipios_curso/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/municipios_curso/2'); ?>">PDF</a>
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/municipios_curso/3'); ?>">HTML</a>
                        Munic&iacute;pios de realiza&ccedil;&atilde;o dos cursos <span class="badge badge-nacional">total nacional</span>  
                    </li>
                    
                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/cursos_natureza_inst_ensino/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/cursos_natureza_inst_ensino/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/cursos_natureza_inst_ensino/3'); ?>">HTML</a> 
                        Total de Cursos Realizados por Natureza da Institui&ccedil;&atilde;o de ensino <span class="badge badge-nacional">total nacional</span> 
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/instituicao_ensino_cursos/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/instituicao_ensino_cursos/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/instituicao_ensino_cursos/3'); ?>">HTML</a> 
                        Total de Cursos Realizados por Institui&ccedil;&atilde;o de ensino <span class="badge badge-nacional">total nacional</span> 
                    </li>
                    
                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/organizacao_demandante_cursos/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/organizacao_demandante_cursos/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/organizacao_demandante_cursos/3'); ?>">HTML</a> 
                        Total de Cursos por Organiza&ccedil;&atilde;o Demandante <span class="badge badge-nacional">total nacional</span> 
                    </li>
                    
                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/cursos_modalidade/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/cursos_modalidade/2'); ?>">PDF</a>
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/cursos_modalidade/3'); ?>">HTML</a>
                        Cursos por modalidade <span class="badge badge-nacional">total nacional</span>  
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/cursos_nivel/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/cursos_nivel/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/cursos_nivel/3'); ?>">HTML</a> 
                        Cursos por n&iacute;vel <span class="badge badge-nacional">total nacional</span>  
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/cursos_nivel_superintendencia/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/cursos_nivel_superintendencia/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/cursos_nivel_superintendencia/3'); ?>">HTML</a> 
                        Cursos por n&iacute;vel e superintend&ecirc;ncia <span class="badge badge-nacional">total nacional</span>  
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/cursos_superintendencia/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/cursos_superintendencia/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/cursos_superintendencia/3'); ?>">HTML</a> 
                        Cursos por superintend&ecirc;ncia <span class="badge badge-nacional">total nacional</span> </a> 
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/alunos_ingressantes_modalidade/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/alunos_ingressantes_modalidade/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/alunos_ingressantes_modalidade/3'); ?>">HTML</a> 
                        Alunos ingressantes por modalidade <span class="badge badge-nacional">total nacional</span> </a> 
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/alunos_ingressantes_nivel/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/alunos_ingressantes_nivel/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/alunos_ingressantes_nivel/3'); ?>">HTML</a> 
                        Alunos ingressantes por n&iacute;vel <span class="badge badge-nacional">total nacional</span> </a> 
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/alunos_ingressantes_superintendencia/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/alunos_ingressantes_superintendencia/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/alunos_ingressantes_superintendencia/3'); ?>">HTML</a> 
                        Alunos ingressantes por superintend&ecirc;ncia <span class="badge badge-nacional">total nacional</span> 
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/alunos_ingressantes_nivel_sr/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/alunos_ingressantes_nivel_sr/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/alunos_ingressantes_nivel_sr/3'); ?>">HTML</a> 
                        Alunos ingressantes por n&iacute;vel e superintend&ecirc;ncia <span class="badge badge-nacional">total nacional</span> 
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/alunos_concluintes_modalidade/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/alunos_concluintes_modalidade/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/alunos_concluintes_modalidade/3'); ?>">HTML</a> 
                        Alunos concluintes por modalidade <span class="badge badge-nacional">total nacional</span> 
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/alunos_concluintes_nivel/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/alunos_concluintes_nivel/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/alunos_concluintes_nivel/3'); ?>">HTML</a> 
                        Alunos concluintes por n&iacute;vel <span class="badge badge-nacional">total nacional</span> 
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/alunos_concluintes_superintendencia/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/alunos_concluintes_superintendencia/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/alunos_concluintes_superintendencia/3'); ?>">HTML</a> 
                        Alunos concluintes por superintend&ecirc;ncia <span class="badge badge-nacional">total nacional</span> 
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/alunos_concluintes_nivel_sr/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/alunos_concluintes_nivel_sr/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/alunos_concluintes_nivel_sr/3'); ?>">HTML</a> 
                        Alunos concluintes por n&iacute;vel e superintend&ecirc;ncia <span class="badge badge-nacional">total nacional</span> 
                    </li>
                    <!--<li class="li-rel">
                            <arel="noopener" target="_blank" href="<?php //echo site_url('relatorio_geral_pnera2/informacoes_relevantes');                  ?>"><i>Informa&ccedil;&otilde;es Relevantes:
                                    <ul class="listNone">
                                            <li>Pocentagem (%) da titula&ccedil;&atilde;o dos coordenadores <span class="badge badge-nacional">total nacional</span> </li>
                                            <li>Dura&ccedil;&atilde;o m&eacute;dia dos cursos em anos <span class="badge badge-nacional">total nacional</span> </li>
                                            <li>N&uacute;mero de bolsistas que se envolveram nos cursos <span class="badge badge-nacional">total nacional</span> </li>
                                    </ul></i>
                            </a>
                    </li>-->

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/lista_cursos_modalidade/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/lista_cursos_modalidade/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/lista_cursos_modalidade/3'); ?>">HTML</a> 
                        Lista de cursos por modalidade <span class="badge badge-nominal">nominal</span>  
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/lista_cursos_modalidade_sr/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/lista_cursos_modalidade_sr/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/lista_cursos_modalidade_sr/3'); ?>">HTML</a> 
                        Lista de cursos por modalidade e superintendência <span class="badge badge-nominal">nominal</span>  
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success" style="padding-left: 60px;padding-right:60px;" data-toggle="modal" href="#cursoAlunoModal">Gerar ...</a> 
                        Lista de alunos por curso <span class="badge badge-nominal">nominal</span>  
                    </li>
                </ul>
                <hr/>
            </li>

            <li>
                <h4>Professores/Educadores</h4>
                <ul>
                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/titulacao_educadores/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/titulacao_educadores/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/titulacao_educadores/3'); ?>">HTML</a> 
                        Porcentagem de educadores por Escolaridade/titula&ccedil;&atilde;o <span class="badge badge-nacional">total nacional</span> 
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/titulacao_educadores_superintendencia/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/titulacao_educadores_superintendencia/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/titulacao_educadores_superintendencia/3'); ?>">HTML</a> 
                        Porcentagem de educadores por Escolaridade/titula&ccedil;&atilde;o e superintend&ecirc;ncia <span class="badge badge-nacional">total nacional</span> 
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/educadores_nivel/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/educadores_nivel/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/educadores_nivel/3'); ?>">HTML</a> 
                        Total de Educadores por n&iacute;vel <span class="badge badge-nacional">total nacional</span> 
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/educadores_curso/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/educadores_curso/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/educadores_curso/3'); ?>">HTML</a> 
                        Total de Educadores por curso <span class="badge badge-nacional">total nacional</span> 
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/educadores_superintendencia/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/educadores_superintendencia/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/educadores_superintendencia/3'); ?>">HTML</a> 
                        Total de Educadores por superintend&ecirc;ncia <span class="badge badge-nacional">total nacional</span> 
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/genero_educadores_modalidade/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/genero_educadores_modalidade/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/genero_educadores_modalidade/3'); ?>">HTML</a> 
                        Participa&ccedil;&atilde;o (%) de homens e mulheres como educadores por modalidade <span class="badge badge-nacional">total nacional</span> 
                    </li>
                </ul>
                <hr/>
            </li>

            <li>
                <h4>Educandos</h4>
                <ul>
                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/educandos_superintendencia/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/educandos_superintendencia/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/educandos_superintendencia/3'); ?>">HTML</a> 
                        Total de Educandos por superintend&ecirc;ncia <span class="badge badge-nacional">total nacional</span> 
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/municipio_origem_educandos/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/municipio_origem_educandos/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/municipio_origem_educandos/3'); ?>">HTML</a> 
                        Total de Educandos por Município de origem <span class="badge badge-nacional">total nacional</span> 
                    </li>

<!--                    <li class="li-rel"> NUNCA CHEGOU A SER IMPLEMENTADO POR COMPLETO
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/territorio_educandos_modalidade/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/territorio_educandos_modalidade/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/territorio_educandos_modalidade/3'); ?>">HTML</a> 
                        Territ&oacute;rio de origem dos educandos por modalidade <span class="badge badge-nacional">total nacional</span> 
                    </li>-->

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/territorio_educandos_superintendencia/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/territorio_educandos_superintendencia/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/territorio_educandos_superintendencia/3'); ?>">HTML</a> 
                        Total de Educandos por Territ&oacute;rio de origem e superintend&ecirc;ncia <span class="badge badge-nacional">total nacional</span> 
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/idade_educandos_modalidade/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/idade_educandos_modalidade/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/idade_educandos_modalidade/3'); ?>">HTML</a> 
                        Idade m&eacute;dia dos educandos por modalidade <span class="badge badge-nacional">total nacional</span> 
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/genero_educandos_modalidade/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/genero_educandos_modalidade/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/genero_educandos_modalidade/3'); ?>">HTML</a> 
                        Participa&ccedil;&atilde;o (%) de genêro como educandos nos cursos por modalidade <span class="badge badge-nacional">total nacional</span> 
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/educandos_assentamento_modalidade/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/educandos_assentamento_modalidade/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/educandos_assentamento_modalidade/3'); ?>">HTML</a> 
                        Total de Educandos por assentamento e modalidade de curso <span class="badge badge-nacional">total nacional</span> 
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/educandos_assentamento_nivel/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/educandos_assentamento_nivel/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/educandos_assentamento_nivel/3'); ?>">HTML</a> 
                        Total de Educandos por assentamento e n&iacute;vel de curso <span class="badge badge-nacional">total nacional</span> 
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success" style="padding-left: 60px;padding-right:60px" data-toggle="modal" href="#educandoCursoSRModal">Gerar ...</a>
                        (Problemas no XLS) Educandos por superintendência e curso <span class="badge badge-nominal">nominal</span>  
                    </li>
                </ul>
                <hr/>
            </li>

            <li>
                <h4>Institui&ccedil;&otilde;es de Ensino</h4>
                <ul>
                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/localizacao_instituicoes_ensino/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/localizacao_instituicoes_ensino/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/localizacao_instituicoes_ensino/3'); ?>">HTML</a> 
                        Localiza&ccedil;&atilde;o por município das institui&ccedil;&otilde;es de ensino
                        <span class="badge badge-nominal">nominal</span> 
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/instituicoes_ensino_modalidade/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/instituicoes_ensino_modalidade/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/instituicoes_ensino_modalidade/3'); ?>">HTML</a> 
                        Total de Institui&ccedil;&otilde;es de ensino que realizaram cursos por modalidade <span class="badge badge-nacional">total nacional</span> 
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/instituicoes_ensino_nivel/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/instituicoes_ensino_nivel/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/instituicoes_ensino_nivel/3'); ?>">HTML</a> 
                        Total de Institui&ccedil;&otilde;es de ensino que realizaram cursos por n&iacute;vel <span class="badge badge-nacional">total nacional</span> 
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/instituicoes_ensino_superintendencia/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/instituicoes_ensino_superintendencia/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/instituicoes_ensino_superintendencia/3'); ?>">HTML</a> 
                        Total de Institui&ccedil;&otilde;es de ensino que realizaram cursos por superintend&ecirc;ncia <span class="badge badge-nacional">total nacional</span> 
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/instituicoes_ensino_municipio/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/instituicoes_ensino_municipio/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/instituicoes_ensino_municipio/3'); ?>">HTML</a> 
                        Total de Institui&ccedil;&otilde;es de ensino que realizaram cursos por munic&iacute;pios <span class="badge badge-nacional">total nacional</span> 
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/instituicoes_ensino_estado/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/instituicoes_ensino_estado/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/instituicoes_ensino_estado/3'); ?>">HTML</a> 
                        Total de Institui&ccedil;&otilde;es de ensino que realizaram cursos por Estado <span class="badge badge-nacional">total nacional</span> 
                    </li>
                </ul>
                <hr/>
            </li>

            <li>
                <h4>Organiza&ccedil;&otilde;es Demandantes</h4>
                <ul>
                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/organizacoes_demandantes_modalidade/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/organizacoes_demandantes_modalidade/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/organizacoes_demandantes_modalidade/3'); ?>">HTML</a> 
                        Total de Organiza&ccedil;&otilde;es Demandantes por modalidade <span class="badge badge-nacional">total nacional</span> 
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/membros_org_demandantes_modalidade/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/membros_org_demandantes_modalidade/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/membros_org_demandantes_modalidade/3'); ?>">HTML</a> 
                        Porcentagem dos membros das Organiza&ccedil;&otilde;es Demandantes em cursos por modalidade
                        <span class="badge badge-nacional">total nacional</span> 
                    </li>


                </ul>
                <hr/>
            </li>

            <li>
                <h4>Parceiros</h4>
                <ul>
                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/localizacao_parceiros/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/localizacao_parceiros/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/localizacao_parceiros/3'); ?>">HTML</a> 
                        Localiza&ccedil;&atilde;o dos parceiros por município <span class="badge badge-nominal">nominal</span> 
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/parceiros_modalidade/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/parceiros_modalidade/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/parceiros_modalidade/3'); ?>">HTML</a> 
                        Total de Parceiros por modalidade <span class="badge badge-nacional">total nacional</span> 
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/parceiros_superintendencia/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/parceiros_superintendencia/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/parceiros_superintendencia/3'); ?>">HTML</a> 
                        Total de Parceiros por superintend&ecirc;ncia <span class="badge badge-nacional">total nacional</span> 
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/parceiros_natureza/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/parceiros_natureza/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/parceiros_natureza/3'); ?>">HTML</a> 
                        Total de Parceiros por natureza da parceria <span class="badge badge-nacional">total nacional</span> 
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/lista_parceiros/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/lista_parceiros/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/lista_parceiros/3'); ?>">HTML</a> 
                        Lista dos parceiros <span class="badge badge-nominal">nominal</span>  
                    </li>
                </ul>
                <hr/>
            </li>

            <li>
                <h4>Produ&ccedil;&otilde;es Bibliogr&aacute;ficas do PRONERA</h4>
                <ul>
                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/producoes_estado/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/producoes_estado/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/producoes_estado/3'); ?>">HTML</a> 
                        Total de Produ&ccedil;&otilde;es por tipo e Estado <span class="badge badge-nacional">total nacional</span> 
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/producoes_superintendencia/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/producoes_superintendencia/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/producoes_superintendencia/3'); ?>">HTML</a> 
                        Total de Produ&ccedil;&otilde;es por tipo e Superintedência <span class="badge badge-nacional">total nacional</span> 
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/producoes_tipo/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/producoes_tipo/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/producoes_tipo/3'); ?>">HTML</a> 
                        Total de Produ&ccedil;&otilde;es por tipo <span class="badge badge-nacional">total nacional</span> 
                    </li>
                </ul>
                <hr/>
            </li>

            <li>
                <h4>Produ&ccedil;&otilde;es Bibliogr&aacute;ficas sobre o PRONERA</h4>
                <ul>
                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/pesquisa_estado/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/pesquisa_estado/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/pesquisa_estado/3'); ?>">HTML</a> 
                        Total de Produ&ccedil;&otilde;es por tipo de produ&ccedil;&atilde;o por Estado <span class="badge badge-nacional">total nacional</span> 
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/pesquisa_superintendencia/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/pesquisa_superintendencia/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/pesquisa_superintendencia/3'); ?>">HTML</a> 
                        Total de Produ&ccedil;&otilde;es por tipo de produ&ccedil;&atilde;o por Superintedência <span class="badge badge-nacional">total nacional</span> 
                    </li>

                    <li class="li-rel">
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/pesquisa_tipo/1'); ?>">XLS</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/pesquisa_tipo/2'); ?>">PDF</a> 
                        <a class="btn btn-success a-link" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/pesquisa_tipo/3'); ?>">HTML</a> 
                        Total de Produ&ccedil;&otilde;es por tipo de produ&ccedil;&atilde;o <span class="badge badge-nacional">total nacional</span> 
                    </li>
                </ul>
            </li>
        </ul>
    </fieldset>
</form>
<div class="modal fade" id="cursoAlunoModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content panel panel-success">
            <div class="modal-header panel-heading">
                Listar Alunos por curso <span class="badge badge-nominal">Nominal</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="panel-body">
                <div class="alert alert-info">
                    <i class="glyphicon glyphicon-alert"></i>
                    Dependendo da Superintendência pode levar muito para processar, devido a quantidade de educandos
                </div>
                <select class="superintendencia"></select>
                <hr>
                <div class="calc">
                    <i>Numero de Registros: <b class="bcount">-</b> educandos</i><br/>
                    <i>Tempo estimado XLS: <b class="bxls">-</b> segundos</i><br/>
                    <i>Tempo estimado PDF: <b class="bpdf">-</b> segundos</i><br/>
                    <i>Tempo estimado HTML: <b class="bhtml">-</b> segundos</i>
                </div>
            </div>
            <div class="panel-footer">
                <label>Gerar: </label>
                <a class="btn btn-success a-link xls" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/alunos_curso/1'); ?>">XLS</a> 
                <a class="btn btn-success a-link pdf" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/alunos_curso/2'); ?>">PDF</a> 
                <a class="btn btn-success a-link html" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/alunos_curso/3'); ?>">HTML</a> 
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="educandoCursoSRModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content panel panel-success">
            <div class="modal-header panel-heading">
                Educandos, superintendência e curso <span class="badge badge-nominal">Nominal</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="panel-body">
                <div class="alert alert-info">
                    <i class="glyphicon glyphicon-alert"></i>
                    Dependendo da Superintendência pode levar muito para processar, devido a quantidade de educandos
                </div>
                <select class="superintendencia"></select>
                <hr>
                <div class="calc">
                    <i>Numero de Registros: <b class="bcount">-</b> educandos</i><br>
                    <i>Tempo estimado XLS: <b class="bxls">-</b> segundos</i><br>
                    <i>Tempo estimado PDF: <b class="bpdf">-</b> segundos</i><br/>
                    <i>Tempo estimado HTML: <b class="bhtml">-</b> segundos</i>
                </div>
            </div>
            <div class="panel-footer">
                <label>Gerar: </label>
                <a class="btn btn-success a-link xls" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/lista_educandos_cursos_sr/1'); ?>">XLS</a> 
                <a class="btn btn-success a-link pdf" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/lista_educandos_cursos_sr/2'); ?>">PDF</a> 
                <a class="btn btn-success a-link html" rel="noopener" target="_blank" href="<?php echo site_url('relatorio_geral_pnera2/lista_educandos_cursos_sr/3'); ?>">HTML</a> 
            </div>
        </div>
    </div>
</div>
<script>

    $(document).ready(function () {
        var $scrollingDiv = $("#scrollingDiv");
        
        function scroll_event(){
            var desloc = ($(window).scrollTop());
            if (desloc <= 137) {
                $scrollingDiv.css("margin-top", ((-1)*desloc)+"px");
            } else {
                $scrollingDiv.css("margin-top", "-167px");
            }
        }
        
        $(window).scroll(scroll_event);

        scroll_event();

        var openModal = function (prefix) {
            $(prefix + " .btn").attr("disabled", "disabled");
            $.get("<?php echo site_url('requisicao/get_superintendencias'); ?>", function (superintendencia) {
                $(prefix + ' .superintendencia').html(superintendencia).select2();
            });
        };

        function prepareModal(id) {
            $("#" + id).on('shown.bs.modal', function (e) {
                openModal("#" + id);
            });

        }
        prepareModal("cursoAlunoModal");
        prepareModal("educandoCursoSRModal");

        $("#cursoAlunoModal .superintendencia").change(function () {
            var value = this.value;
            var append = generate_status_url();

            $.get("<?php echo site_url('requisicao/get_totaleducandos'); ?>/" + value, function (result) {
                var count = parseInt(result);
                var modal = $("#cursoAlunoModal");
                modal.find(".bcount").html(count);
                modal.find(".bxls").html(parseInt(count / 250) + 1);
                modal.find(".bpdf").html(parseInt(count / 55) + 1);
                modal.find(".bhtml").html(parseInt(count / 2660) + 1);
            });

            var url = "<?php echo site_url('relatorio_geral_pnera2/alunos_curso'); ?>";

            $("#cursoAlunoModal .btn").each(function (index, obj) {
                if ($(obj).hasClass("xls")) {
                    $(obj).attr("href", url + "/1/" + value + "/" + append);
                } else if ($(obj).hasClass("pdf")) {
                    $(obj).attr("href", url + "/2/" + value + "/" + append);
                } else if ($(obj).hasClass("html")) {
                    $(obj).attr("href", url + "/3/" + value + "/" + append);
                }
            }).removeAttr('disabled');
        });

        $("#educandoCursoSRModal .superintendencia").change(function () {
            var value = this.value;
            var append = generate_status_url();

            $.get("<?php echo site_url('requisicao/get_totaleducandos'); ?>/" + value, function (result) {
                var count = parseInt(result);
                var modal = $("#educandoCursoSRModal");
                modal.find(".bcount").html(count);
                modal.find(".bxls").html(parseInt(count / 105) + 1);
                modal.find(".bpdf").html(parseInt(count / 15) + 1);
                modal.find(".bhtml").html(parseInt(count / 2660) + 1);
            });

            var url = "<?php echo site_url('relatorio_geral_pnera2/lista_educandos_cursos_sr'); ?>";

            $("#educandoCursoSRModal .btn").each(function (index, obj) {
                if ($(obj).hasClass("xls")) {
                    $(obj).attr("href", url + "/1/" + value + "/" + append);
                } else if ($(obj).hasClass("pdf")) {
                    $(obj).attr("href", url + "/2/" + value + "/" + append);
                } else if ($(obj).hasClass("html")) {
                    $(obj).attr("href", url + "/3/" + value + "/" + append);
                }
            }).removeAttr('disabled');
        });

        $(".badge-nominal").each(function () {
            this.innerHTML = '<i class="glyphicon glyphicon-list"></i> ' + this.innerHTML;
        });
        $(".badge-alert").each(function () {
            this.innerHTML = '<i class="glyphicon glyphicon-time"></i> ' + this.innerHTML;
        });
        $(".badge-municipio").each(function () {
            this.innerHTML = '<i class="glyphicon glyphicon-map-marker"></i> ' + this.innerHTML;
        });

        $(".check_status").change(function (e) {
            change_status(this.value, this.checked, e);
        });

        var status = [];

        function generate_status_url() {
            var href = false;
            for (var key in status) {
                if (status[key] === true) {
                    if (href) {
                        href += "&status[]=" + key;
                    } else {
                        href = "?status[]=" + key;
                    }
                }
            }
            return href;
        }

        function update_status(dom) {
            var href = dom.attr("href");
            var index = href.indexOf("?");
            var append = generate_status_url();
            if (append) {
                if (index === -1) {
                    href += "/" + append;
                } else {
                    href = href.substr(0, index);
                    href += append;
                }
            } else {
                href = href.substr(0, index - 1);
            }
            dom.attr("href", href);
        }

        function change_status(value, checked, e) {
            status[value] = checked;
            if (checked === false) {
                var findone = false;
                for (var key in status) {
                    if (status[key] === true) {
                        findone = true;
                        break;
                    }
                }
                if (findone === false) {
                    e.target.checked = true;
                    return;
                }
            }
            $("a.a-link").each(function () {
                update_status($(this));
            });
        }
        change_status("AN", true, null);
        change_status("2P", true, null);
        change_status("CC", true, null);

    });



</script>
