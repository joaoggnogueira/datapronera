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

    .li-tipo{
        margin-bottom: 20px;
    }
</style>
<form>
    <fieldset>
        <legend><h3>Relat&oacute;rios de Pesquisas (Produ&ccedil;&otilde;es sobre o Datapronera)</h3></legend>
        <div class="alert alert-success">
            <i class="glyphicon glyphicon-alert"></i> Gerar em <b>PDF</b> pode demorar 5x mais que <b>XLS</b>
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        </div>
        <ul class="li-rel">
            <li>
                <h4>Pesquisas (Realizadas sobre o Pronera)</h4>
                <ul>
                    <li class="li-tipo">
                        <h5>PESQUISAS ACAD&Ecirc;MICAS</h5>
                        <ul>
                            <li class="li-rel">
                                <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_pesquisas/pesquisas_academica/XLS'); ?>">XLS</a> 
                                <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_pesquisas/pesquisas_academica/PDF'); ?>">PDF</a>
                                PRODU&Ccedil;&Otilde;ES
                            </li>
                            <li class="li-rel">
                                <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_pesquisas/pesquisas_autores_academica/XLS'); ?>">XLS</a> 
                                <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_pesquisas/pesquisas_autores_academica/PDF'); ?>">PDF</a>
                                AUTORES
                            </li>
                        </ul>
                    </li>
                    <li class="li-tipo">
                        <h5>LIVROS</h5>
                        <ul>
                            <li class="li-rel">
                                <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_pesquisas/pesquisas_livro/XLS'); ?>">XLS</a> 
                                <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_pesquisas/pesquisas_livro/PDF'); ?>">PDF</a>
                                PRODU&Ccedil;&Otilde;ES
                            </li>
                            <li class="li-rel">
                                <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_pesquisas/pesquisas_autores_livro/XLS'); ?>">XLS</a> 
                                <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_pesquisas/pesquisas_autores_livro/PDF'); ?>">PDF</a>
                                AUTORES
                            </li>
                        </ul>
                    </li>
                    <li class="li-tipo">
                        <h5>COLET&Acirc;NEAS</h5>
                        <ul>
                            <li class="li-rel">
                                <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_pesquisas/pesquisas_coletaneas/XLS'); ?>">XLS</a> 
                                <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_pesquisas/pesquisas_coletaneas/PDF'); ?>">PDF</a>
                                PRODU&Ccedil;&Otilde;ES
                            </li>
                        </ul>
                    </li>
                    <li class="li-tipo">
                        <h5>CAP&Iacute;TULOS DE LIVRO</h5>
                        <ul>
                            <li class="li-rel">
                                <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_pesquisas/pesquisas_capitulo_livro/XLS'); ?>">XLS</a> 
                                <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_pesquisas/pesquisas_capitulo_livro/PDF'); ?>">PDF</a>
                                PRODU&Ccedil;&Otilde;ES
                            </li>
                            <li class="li-rel">
                                <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_pesquisas/pesquisas_autores_capitulo_livro/XLS'); ?>">XLS</a> 
                                <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_pesquisas/pesquisas_autores_capitulo_livro/PDF'); ?>">PDF</a>
                                AUTORES
                            </li>
                        </ul>
                    </li>
                    <li class="li-tipo">
                        <h5>ARTIGOS</h5>
                        <ul>
                            <li class="li-rel">
                                <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_pesquisas/pesquisas_artigo/XLS'); ?>">XLS</a> 
                                <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_pesquisas/pesquisas_artigo/PDF'); ?>">PDF</a>
                                PRODU&Ccedil;&Otilde;ES
                            </li>
                            <li class="li-rel">
                                <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_pesquisas/pesquisas_autores_artigo/XLS'); ?>">XLS</a> 
                                <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_pesquisas/pesquisas_autores_artigo/PDF'); ?>">PDF</a>
                                AUTORES
                            </li>
                        </ul>
                    </li>
                    <li class="li-tipo">
                        <h5>V&Iacute;DEOS/DOCUMENT&Aacute;RIOS</h5>
                        <ul>
                            <li class="li-rel">
                                <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_pesquisas/pesquisas_video/XLS'); ?>">XLS</a> 
                                <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_pesquisas/pesquisas_video/PDF'); ?>">PDF</a>
                                PRODU&Ccedil;&Otilde;ES
                            </li>
                            <li class="li-rel">
                                <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_pesquisas/pesquisas_autores_video/XLS'); ?>">XLS</a> 
                                <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_pesquisas/pesquisas_autores_video/PDF'); ?>">PDF</a>
                                AUTORES
                            </li>
                        </ul>
                    </li>
                    <li class="li-tipo">
                        <h5>PERI&Oacute;DICOS</h5>
                        <ul>
                            <li class="li-rel">
                                <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_pesquisas/pesquisas_periodicos/XLS'); ?>">XLS</a> 
                                <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_pesquisas/pesquisas_periodicos/PDF'); ?>">PDF</a>
                                PRODU&Ccedil;&Otilde;ES
                            </li>
                            <li class="li-rel">
                                <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_pesquisas/pesquisas_autores_periodicos/XLS'); ?>">XLS</a> 
                                <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_pesquisas/pesquisas_autores_periodicos/PDF'); ?>">PDF</a>
                                AUTORES
                            </li>
                        </ul>
                    </li>
                    <li class="li-tipo">
                        <h5>EVENTOS</h5>
                        <ul>
                            <li class="li-rel">
                                <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_pesquisas/pesquisas_eventos/XLS'); ?>">XLS</a> 
                                <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_pesquisas/pesquisas_eventos/PDF'); ?>">PDF</a>
                                REALIZA&Ccedil;&Otilde;ES
                            </li>
                            <li class="li-rel">
                                <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_pesquisas/pesquisas_organizadores_eventos/XLS'); ?>">XLS</a> 
                                <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_pesquisas/pesquisas_organizadores_eventos/PDF'); ?>">PDF</a>
                                ORGANIZADORES
                            </li>
                            <li class="li-rel">
                                <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_pesquisas/pesquisas_realizadores_eventos/XLS'); ?>">XLS</a> 
                                <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_pesquisas/pesquisas_realizadores_eventos/PDF'); ?>">PDF</a>
                                REALIZADORES
                            </li>
                            <li class="li-rel">
                                <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_pesquisas/pesquisas_documentacao_eventos/XLS'); ?>">XLS</a> 
                                <a class="btn btn-success" target="_blank" href="<?php echo site_url('relatorio_pesquisas/pesquisas_documentacao_eventos/PDF'); ?>">PDF</a>
                                DOCUMENTA&Ccedil;&Atilde;O
                            </li>
                        </ul>
                    </li>
                </ul>
                <hr/>
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