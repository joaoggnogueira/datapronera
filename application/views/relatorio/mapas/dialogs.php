<div class="modal fade" id="relacao_sr_cursos_modal">
    <div class="modal-dialog" style="width: 90%" role="document">
        <div class="modal-content panel panel-search">
            <div class="modal-header panel-heading">
                <i class="fa fa-graduation-cap"></i> Cursos e Educandos 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="glyphicon glyphicon-remove"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form style="height: 35px;">
                    <div class="row">
                        <div class="form-group no-margin">
                            <label for="sr-select-modal" style="display: inline-block;">&nbsp;&nbsp; Selecione a Superintêndencia: </label>
                            <select class="form-control" id="sr-select-modal" style="display: inline-block;">
                                <?PHP foreach ($superintendencias as $sr): ?>
                                    <option value="<?= $sr->id ?>" <?= ($srAtual == $sr->id ? "selected" : "") ?>>
                                        <?= str_pad($sr->id, 2, "0", STR_PAD_LEFT) ?> - <?= $sr->nome ?>
                                    </option>
                                <?PHP endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <br/>
                </form>
                <hr/>
                <table id="relacao_sr_cursos_table" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 0%"> ID </th>
                            <th style="width: 5%"> COD </th>
                            <th style="width: 10%"> SEI </th>
                            <th style="width: 30%"> CURSO </th>
                            <th style="width: 13%"> MODALIDADE </th>
                            <th style="width: 13%"> VIGÊNCIA </th>
                            <th style="width: 29%"> MUNICÍPIOS DE REALIZAÇÃO </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="helpModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content panel panel-info">
            <div class="modal-header panel-heading">
                Ajuda <i class="glyphicon glyphicon-question-sign"></i>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <ul class="nav nav-tabs" id="tabHelp">
                <li class="active"><a data-toggle="tab" href="#marcadores">Marcadores</a></li>
                <li><a data-toggle="tab" href="#agrupamentos">Agrupamentos</a></li>
                <li><a data-toggle="tab" href="#outros">Outros</a></li>
            </ul>
            <div class="tab-content">
                <div id="marcadores" class="modal-body tab-pane fade in active">
                    <label>Vamos começar com algumas informações básicas</label>
                    <hr/>
                    <div class="input-group desc">
                        <span class="input-group-addon"><img src="<?= base_url('css/images/marker.png') ?>" width="37" height="37"/></span>
                        <label>Esse marcador representa um múnicipio</label>
                    </div>
                    <hr/>
                    <div class="input-group desc">
                        <span class="input-group-addon" style='height: 37px'><img src="<?= base_url('css/images/markerexample.png') ?>" width="40" height="37"/></span>
                        <label>O número representa a quantidade caracterizações no município</label>
                    </div>
                    <hr/>
                    <div class="input-group desc">
                        <span class="input-group-addon" style='height: 37px'><img src="<?= base_url('css/images/circleexample.png') ?>" width="40" height="37"/></span>
                        <label>O tamanho do marcador em circulo representa, para o município no centro dele, a concentração de caracterizações</label>
                    </div>
                    <hr/>
                    <div class="input-group desc">
                        Uma <b>caracterização</b> pode significar (dependendo do mapa selecionado):
                        <ul>
                            <li><b>Um Curso</b>, ou seja, uma realização do curso no município</li>
                            <li>Ou <b>um educando</b>, ou seja, um educando que tem origem no município</li>
                        </ul>
                    </div>
                    <hr/>
                    <?PHP if (!$publico): ?>
                        <div class="alert alert-info"><i class="glyphicon glyphicon-hand-up"></i> Clique no marcador para visualizar informações sobre as caracterizações !</div>
                    <?PHP else: ?>
                        <div class="alert alert-danger"><i class="fa fa-exclamation"></i> No modo de acesso público, não é possível visualizar informações educandos</div>
                    <?PHP endif; ?>
                    <hr/>
                    <div style="text-align: right">
                        <a class="btn btn-primary" onclick="$('#tabHelp > li:nth-child(2) > a').click();">Continuar <i class="glyphicon glyphicon-chevron-right"></i></a>
                    </div>
                </div>
                <div id="agrupamentos" class="modal-body tab-pane fade">
                    <label>Os seguintes símbolos representam agrupamento de marcadores e a cor indica a granularidade em relação aos demais</label>
                    <hr/>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group desc">
                                <span class="input-group-addon"><img src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m1.png" width="37" height="37"/></span>
                                <label>Baixa</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group desc">
                                <span class="input-group-addon"><img src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m2.png" width="37" height="37"/></span>
                                <label>Média</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group desc">
                                <span class="input-group-addon"><img src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m3.png"  width="37" height="37"/></span>
                                <label>Alta</label>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="input-group desc">
                        <span class="input-group-addon"><img src="<?= base_url('css/images/clusterexample.png') ?>"  width="42" height="37"/></span>
                        <label>O número no interior representa a quantidade de marcadores acumulados nele</label>
                    </div>
                    <hr/>
                    <div class="alert alert-info"><i class="glyphicon glyphicon-hand-up"></i> Clique no marcador de agrupamento para ampliar o mapa, e visualizar os marcadores agrupados !</div>
                    <div style="text-align: right">
                        <a class="btn btn-primary" onclick="$('#tabHelp > li:nth-child(3) > a').click();">Continuar <i class="glyphicon glyphicon-chevron-right"></i></a>
                    </div>
                </div>
                <div id="outros" class="modal-body tab-pane fade">
                    <label>Por fim, algumas fucionalidades que podem ajduar na visualização</label>
                    <hr/>
                    <div class="input-group desc">
                        <span class="input-group-addon"><img src="<?= base_url('css/images/mapaselectExample.png') ?>" width="150" height="37"/></span>
                        <label>Selecione o Mapa no canto superior a esquerda</label>
                    </div>
                    <hr/>
                    <div class="input-group desc">
                        <span class="input-group-addon"><a class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></a></span>
                        <label>Use a barra de pesquisa com este ícone para pesquisar um município </label>
                    </div>
                    <hr/>
                    <div class="input-group desc">
                        <span class="input-group-addon"><img src="<?= base_url('css/images/fullscreen.png') ?>" width="37" height="37"></span>
                        <label>Use este ícone abrir o mapa em modo tela cheia</label>
                    </div>
                    <hr/>
                    <div style="text-align: right">
                        <a class="btn btn-primary" data-dismiss="modal">Fechar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="searchCursoModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content panel panel-search">
            <div class="modal-header panel-heading">
                <i class="fa fa-bookmark"></i> Buscar Curso 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="glyphicon glyphicon-remove"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <label>Digite abaixo o nome (ou parte do nome) do curso</label>
                    <div class="row">
                        <div class="col-md-9">
                            <div class="input-group">
                                <span style="height: 34px" class="input-group-addon glyphicon glyphicon-search"></span>
                                <input type="search" name="search" style="text-transform: uppercase;margin: 1px 0px" class="form-control"/>      
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-success">Buscar</button>
                        </div>
                    </div>
                    <br/>
                    <a class="help-a" data-toggle="modal" data-target="#helpSearchCurso">Porque não estou encontrando o curso?</a>
                </form>
                <hr/>
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th> ID_MUN </th>
                            <th> CURSO </th>
                            <th> MUNICÍPIO </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="confirm-normal-mode" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content panel">
            <div class="modal-body">
                <i class="fa fa-exclamation-triangle"></i> Isso pode levar muito tempo para carregar, dependendo da quantidade de marcadores. Continuar?
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-primary" id="confirm-normal-mode-continue">Continuar</button>
                <button type="button" data-dismiss="modal" class="btn" id="confirm-normal-mode-cancel">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="helpSearchCurso">
    <div class="modal-dialog" role="document">
        <div class="modal-content panel panel-search">
            <div class="modal-header panel-heading">
                <i class="fa fa-question-circle"></i> Ajuda com a Busca de Curso
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="glyphicon glyphicon-remove"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <h3>Porque não estou encontrando o curso?</h3>
                <br>
                <p>Supondo que o nome digitado está correto, abaixo a lista de problemas que podem estar causando a dificuldade em encontra-lo:</p>
                <ul>
                    <li>
                        <p>Os <b>filtros</b> selecionados no <b>mapa</b> podem estar ocultando o curso,</p>
                        <p>Tente resetar, cliquando em <button class="btn btn-default">Selecionar Tudo</button> para cada filtro</p>
                    </li>
                    <li>
                        <p>O curso pode estar <b>cadastro</b>, porém:</p>
                        <p>
                        <ul>
                            <li><p>Não foi cadastrado nenhum <b>município de realização</b></li>
                            <li><p>Ou, pode ter sido <b>desativado</b></p></li>
                        </ul>    
                    </li>
                    <li>
                        <p>O nome cadastrado pode estar <b>incorreto</b> ou <b>diferente</b>,</p>
                        <p>Tente utilizar <b>outra palavra</b> do nome</p>
                    </li>
                    <li>
                        <p>O curso não foi cadastrado</p>
                        <p>Se for um curso novo, é possível que ele seja cadastrado <b>posteriormente</b></p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?PHP if (!$publico): ?>
    <div class="modal fade" id="searchEducandoModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content panel panel-search">
                <div class="modal-header panel-heading">
                    <i class="fa fa-graduation-cap"></i> Buscar Município de Origem do Educando 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="glyphicon glyphicon-remove"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <label>Digite abaixo o nome (ou parte do nome) do educando</label>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="input-group">
                                    <span style="height: 34px" class="input-group-addon glyphicon glyphicon-search"></span>
                                    <input type="search" name="search" style="text-transform: uppercase; margin: 1px 0px" class="form-control"/>    
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-success">Buscar</button>
                            </div>
                        </div>
                        <br/>
                        <a class="help-a" data-toggle="modal" data-target="#helpSearchEducando">Porque não estou encontrando o educando?</a>
                    </form>
                    <hr/>
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th> ID_MUN </th>
                                <th> NOME </th>
                                <th> CURSO </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="helpSearchEducando">
        <div class="modal-dialog" role="document">
            <div class="modal-content panel panel-search">
                <div class="modal-header panel-heading">
                    <i class="fa fa-question-circle"></i> Ajuda com a Busca de Educandos
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="glyphicon glyphicon-remove"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3>Porque não estou encontrando o educando?</h3>
                    <br>
                    <p>Supondo que o nome digitado está correto, abaixo a lista de problemas que podem estar causando a dificuldade em encontra-lo:</p>
                    <ul>
                        <li>
                            <p>Os <b>filtros</b> selecionados no <b>mapa</b> podem estar ocultando o educando,</p>
                            <p>Tente resetar, cliquando em <button class="btn btn-default">Selecionar Tudo</button> para cada filtro</p>
                        </li>
                        <li>
                            <p>O educando pode estar <b>cadastro</b>, porém:</p>
                            <p>
                            <ul>
                                <li><p>Não foi cadastrado o seu <b>município</b> de origem</p></li>
                                <li><p>Ou, o <b>curso</b> dele pode ter sido <b>desativado</b></p></li>
                            </ul>    
                        </li>
                        <li>
                            <p>O nome cadastrado pode estar <b>incorreto</b>,</p>
                            <p>Tente utilizar <b>outra palavra</b> do nome</p>
                        </li>
                        <li>
                            <p>O educando não foi cadastrado</p>
                            <p>Se for um curso novo, é possível que ele seja cadastrado <b>posteriormente</b></p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?PHP endif; ?>
<div class="modal fade" id="curso_dimensions_modal">
    <div class="modal-dialog" style="width: 70%" role="document">
        <div class="modal-content panel panel-info">
            <div class="modal-header panel-heading">
                <i class="fa fa-book"></i> Curso <span id="curso_dimensions_modal_name"></span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="glyphicon glyphicon-remove"></i></span>
                </button>
            </div>
            <div class="modal-body" id="nav-dimensions-curso">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#overview-curso-dimension">Visão geral</a></li>
                    <li><a href="#educandos-curso-dimension">Educandos</a></li>
                </ul>
                <div id="overview-curso-dimension" class="tab">
                    <div class="form-group" style="margin: 25px;">
                        <div class="lds-ellipsis loading"><div></div><div></div><div></div><div></div></div>
                        <label class="label-row"><b>Nome do Curso: </b><span class="value" name="nome"></span></label>
                        <label class="label-row"><b>Superintendência: </b><span class="value" name="sr"></span></label>
                        <label class="label-row"><b>Número SEI: </b><span class="value" name="sei"></span></label>
                        <label class="label-row"><b>Instrumento: </b><span class="value" name="instrumento"></span></label>
                        <label class="label-row"><b>Modalidade: </b><span class="value" name="modalidade"></span></label>
                        <label class="label-row"><b>Vigência: </b><span class="value" name="vigencia"></span></label>
                        <label class="label-row"><b>Municípios de Realização: </b><span class="value" name="municipios"></span></label>
                        <label class="label-row"><b>Coordenador Geral: </b><span class="value" name="c_geral"></span></label>
                        <label class="label-row"><b>Coordenador do Projeto/Curso: </b><span class="value" name="c_curso"></span></label>
                        <label class="label-row"><b>Vice-coordenador do Curso: </b><span class="value" name="vc_curso"></span></label>
                        <label class="label-row"><b>Coordenador Pedagógico do Curso: </b><span class="value" name="cp_curso"></span></label>
                    </div>
                </div>
                <div id="educandos-curso-dimension" class="tab">
                    <div class="form-group" style="margin: 25px;">
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="30%">NOME</th>
                                    <th width="15%">CPF</th>
                                    <th width="15%">RG</th>
                                    <th width="25%">Território</th>
                                    <th width="10%">Município</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {

        function funcaoMarotaParaRemoverAcentos(newStringComAcento) {
            newStringComAcento = newStringComAcento.toLowerCase();
            var string = newStringComAcento;
            var mapaAcentosHex = {
                a: /[\xE0-\xE6]/g,
                e: /[\xE8-\xEB]/g,
                i: /[\xEC-\xEF]/g,
                o: /[\xF2-\xF6]/g,
                u: /[\xF9-\xFC]/g,
                c: /\xE7/g,
                n: /\xF1/g
            };

            for (var letra in mapaAcentosHex) {
                var expressaoRegular = mapaAcentosHex[letra];
                string = string.replace(expressaoRegular, letra);
            }
            return string.toUpperCase();
        }

        var searchCursoBtn = document.getElementById('search-curso');
        var searchEducandoBtn = document.getElementById('search-educando');
        searchCursoBtn.style.display = "none";
        searchEducandoBtn.style.display = "none";
        $(document.body).append($("#helpModal"));
        setTimeout(function () {
            if ($("#loading").length !== 0) {
                $("#loading .problem").html("<br/>Esta demorando muito!");
                setTimeout(function () {
                    $("#loading .problem").html("<br/>Esta demorando muito!<br/>Verifique se está conectado com a internet!");
                }, 1000);
            }
        }, 10000);

        var tableSearchCursoModal = null;

        $('#searchCursoModal').on('shown.bs.modal', function () {
            $(this).find("input[type='search']").focus();
            if (tableSearchCursoModal === null) {
                $(this).find("table").hide();
            }
        });

        $("#searchCursoModal form").submit(function (e) {
            e.preventDefault();
        });

        $("#searchCursoModal form").submit(function (e) {
            e.preventDefault($(this).find("input[type='search']").val());
            var term = funcaoMarotaParaRemoverAcentos($(this).find("input[type='search']").val());
            var table = $("#searchCursoModal").find("table").eq(0);

            if (tableSearchCursoModal !== null) {
                tableSearchCursoModal.destroy();
            }
            table.show();
            tableSearchCursoModal = new Table({
                data: {filters: getFilter()},
                url: "<?= site_url("relatorio_mapas/search_curso/") ?>/" + term,
                table: table,
                controls: null
            });
            tableSearchCursoModal.hideColumns([0]);
            tableSearchCursoModal.appendEvent(function (data) {
                var marker = hashMarkers[data[0]];
                map_recenter(marker.getPosition(), 0, 0);
                map.setZoom(15);
                $("#searchCursoModal").modal('hide');
            });
        });

        $('#searchEducandoModal').on('shown.bs.modal', function () {
            $(this).find("input[type='search']").focus();
            if (tableSearchEducandoModal === null) {
                $(this).find("table").hide();
            }
        });

        var tableSearchEducandoModal = null;

        $("#searchEducandoModal form").submit(function (e) {
            e.preventDefault($(this).find("input[type='search']").val());
            var term = funcaoMarotaParaRemoverAcentos($(this).find("input[type='search']").val());
            var table = $("#searchEducandoModal").find("table").eq(0);

            if (tableSearchEducandoModal !== null) {
                tableSearchEducandoModal.destroy();
            }
            table.show();
            tableSearchEducandoModal = new Table({
                data: {filters: getFilter()},
                url: "<?= site_url("relatorio_mapas/search_educando/") ?>/" + term,
                table: table,
                controls: null
            });
            tableSearchEducandoModal.hideColumns([0]);
            tableSearchEducandoModal.appendEvent(function (data) {
                var marker = hashMarkers[data[0]];
                map_recenter(marker.getPosition(), 0, 0);
                map.setZoom(15);
                $("#searchEducandoModal").modal('hide');
            });
        });

        var tableRelacaoSRcurso = false;
        $('#relacao_sr_cursos_modal').on('shown.bs.modal', function () {
            if (tableRelacaoSRcurso === false) {
                $("#sr-select-modal").trigger("change");
            }
        });
        $("#sr-select-modal").change(function () {
            tableRelacaoSRcurso = new Table({
                data: {sr: parseInt($(this).val())},
                url: "<?= site_url("relatorio_mapas/relacao_sr_curso/") ?>/",
                table: $("#relacao_sr_cursos_table").eq(0),
                controls: null
            });
            tableRelacaoSRcurso.hideColumns([0]);
            tableRelacaoSRcurso.appendEvent(function (data) {
                var id = data[0];
                $("#curso_dimensions_modal").modal("show");
                $("#curso_dimensions_modal .loading").show();
                $.ajax({
                    url: "<?= site_url("relatorio_mapas/get_curso_details/") ?>/" + id,
                    type: 'POST',
                    dataType: 'json',
                    data: {},
                    timeout: 20000,
                    success: function (data) {
                        $("#curso_dimensions_modal .loading").hide();

                        for (var key in data) {
                            $("#overview-curso-dimension .value[name='" + key + "']").html(data[key]);
                        }
                    },
                    error: function (data) {
                        $("#curso_dimensions_modal .loading").hide();
                        alert("error");
                    }
                });
                new Table({
                    data: {},
                    url: "<?= site_url("relatorio_mapas/get_educandos_details/") ?>/" + id,
                    table: $("#curso_dimensions_modal").find("table").eq(0),
                    controls: null
                });
            });
        });
        $("#nav-dimensions-curso .nav-tabs a").click(function (e) {
            e.preventDefault();
            $("#nav-dimensions-curso > .tab").hide();
            $("#nav-dimensions-curso > .nav-tabs > li").removeClass("active");
            $(this).parents("li").eq(0).addClass("active");
            $($(this).attr("href")).show();
        }).eq(0).click();
    });
</script>