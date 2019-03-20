<?php $this->session->set_userdata('curr_content', 'rel_dinamico'); ?>

<style type="text/css">
    .tab-pane{
        padding:30px;
    }
    .lds-dual-ring {
        display: inline-block;
        width: 32px;
        height: 32px;
    }
    .lds-dual-ring:after {
        content: " ";
        display: block;
        width: 23px;
        height: 23px;
        margin: 1px;
        border-radius: 50%;
        border: 3px solid #333;
        border-color: #333 transparent #333 transparent;
        animation: lds-dual-ring 1.2s linear infinite;
    }
    @keyframes lds-dual-ring {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

    .area{
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 30px;
        margin: 10px;
    }

    .h4{
        display: inline-block;
        margin-top: 10px;
        margin-bottom: 10px;
    }
    .h4, label{
        -webkit-touch-callout: none; /* iOS Safari */
        -webkit-user-select: none; /* Safari */
        -khtml-user-select: none; /* Konqueror HTML */
        -moz-user-select: none; /* Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
        user-select: none; /* Non-prefixed version, currently */
    }
    summary{
        cursor: pointer;
    }
    .table-checkbox tr:first-child th{
        padding-bottom: 20px;
    }
    .table-checkbox tr td:first-child,.table-checkbox tr th:first-child{
        padding-right: 20px;
    }
    #select2-cursos-select-container{
        min-width: 700px;
    }

</style>

<script type="text/javascript">

    $(document).ready(function () {

        function update_list_curso() {
            $("#filter-alert").hide();
            $("#loading-cursos").show();
            $("#gerar").attr("disabled", true);

            var status = [];
            $('#check_status input[type=checkbox]').each(function () {
                if (this.checked) {
                    status.push(this.value);
                }
            });

            $.post("<?php echo site_url('relatorio_dinamico/get_cursos'); ?>", {
                superintendencia: $('#superintendencias-select').val(),
                status_curso: JSON.stringify(status),
                modalidade: $('#modalidades-select').val(),
                municipio: $('#municipios-select').val(),
                nivel: $('#niveis-select').val(),
                estado: $("#estados-select").val(),
                inicio0_realizado: $('#inicio0-realizado').val(),
                inicio1_realizado: $('#inicio1-realizado').val(),
                termino0_realizado: $('#termino0-realizado').val(),
                termino1_realizado: $('#termino1-realizado').val(),
                curso: "0"
            }, function (html) {
                if ($('#cursos-select').data('select2')) {
                    $('#cursos-select').select2('destroy');
                }
                $("#cursos-select").html(html).css("min-width", "500px").css("max-width", "800px").select2();
                $("#loading-cursos").hide();
                if ($('#cursos-select option').length == 1) {
                    $("#filter-alert").show();
                } else {
                    $("#gerar").removeAttr("disabled");
                }
            });
        }

        function check_nivel_modalidade() {
            var modalidade = $('#modalidades-select').val();
            var nivel = $('#niveis-select').val();
            var modalidade_text = $('#modalidades-select option:selected').text();
            if (modalidade != 0 && nivel != 0) {
                switch (nivel) {
                    case 'EJA':
                        if (["17", "19", "23"].indexOf(modalidade) == -1) {
                            $("#alert_modalidade_nivel").html('<i class="fa fa-exclamation-triangle"></i> Modalidade ' + modalidade_text + ' não pertence ao nível EJA FUNDAMENTAL, portanto será desconsiderado o nível');
                        } else {
                            $("#alert_modalidade_nivel").html('');
                        }
                        break;
                    case 'EM':
                        if (["18", "24", "16", "21", "20"].indexOf(modalidade) == -1) {
                            $("#alert_modalidade_nivel").html('<i class="fa fa-exclamation-triangle"></i> Modalidade ' + modalidade_text + ' não pertence ao nível ENSINO MÉDIO, portanto será desconsiderado o nível');
                        } else {
                            $("#alert_modalidade_nivel").html('');
                        }
                        break;
                    case 'ES':
                        if (["15", "25", "22", "30"].indexOf(modalidade) == -1) {
                            $("#alert_modalidade_nivel").html('<i class="fa fa-exclamation-triangle"></i> Modalidade ' + modalidade_text + ' não pertence ao nível ENSINO SUPERIOR, portanto será desconsiderado o nível');
                        } else {
                            $("#alert_modalidade_nivel").html('');
                        }
                        break;
                    default:
                        $("#alert_modalidade_nivel").html('');
                }
            } else {
                $("#alert_modalidade_nivel").html('');
            }
        }

        function parent_checkbox(checkbox_obj_child, checkbox_obj_parent) {
            checkbox_obj_child.click(function () {
                if (this.checked) {
                    checkbox_obj_parent[0].checked = true;
                }
            });
            checkbox_obj_parent.click(function () {
                checkbox_obj_child[0].checked = this.checked;
            });
        }

        parent_checkbox($("#check_municipio_curso"), $("#check_curso"));
        parent_checkbox($("#check_disciplinas"), $("#check_professores"));

        var url = "<?php echo site_url('relatorio_dinamico') . '/'; ?>";

        // Carrega os selects para filtro
        $.get("<?php echo site_url('requisicao/get_superintendencias_cursos_rel'); ?>", function (data) {
            $('#superintendencias-select').html(data).css("width", "350px").select2();
        });
        $.get("<?php echo site_url('requisicao/get_modalidades_rel'); ?>", function (modalidades) {
            $('#modalidades-select').html(modalidades).css("width", "400px").select2();
        });
        $.get("<?php echo site_url('requisicao/get_estados_rel'); ?>", function (data) {
            $('#estados-select').html(data).change(function () {
                if ($('#municipios-select').data('select2')) {
                    $('#municipios-select').select2('destroy');
                }
                update_list_curso();
                if ($("#estados-select").val() !== "0") {
                    var text = estado = $("#estados-select option:selected").text();
                    $.get("<?php echo site_url('requisicao/get_municipios'); ?>/" + this.value, function (data) {
                        $("#municipios-select").html(data).removeAttr("disabled").find("option[value='0']").removeAttr("disabled").text("Todos municípios do(a) " + text);
                        $("#municipios-select").select2().removeAttr("disabled");
                    });
                } else {
                    $("#municipios-select")
                            .html("<option value='0' selected>Todos os municípios</option>")
                            .select2().attr("disabled", "disabled");
                }
            }).css("width", "250px").select2();
        });

        $('#check_status input[type=checkbox]').change(update_list_curso);
        $('#superintendencias-select').change(update_list_curso);
        $('#modalidades-select').change(update_list_curso).change(check_nivel_modalidade);
        $("#municipios-select").change(update_list_curso);
        $(".data-inicio").change(update_list_curso);
        $(".data-fim").change(update_list_curso);

        $('#niveis-select')
                .change(update_list_curso)
                .change(check_nivel_modalidade)
                .change(function () {
                    var nivel = this.value;
                    $("#modalidades-select option").each(function () {
                        var modalidade = this.value;
                        if (modalidade != "0") {
                            switch (nivel) {
                                case 'EJA':
                                    if (["17", "19", "23"].indexOf(modalidade) == -1) {
                                        $(this).attr("disabled", "disabled");
                                    } else {
                                        $(this).removeAttr("disabled");
                                    }
                                    break;
                                case 'EM':
                                    if (["18", "24", "16", "21", "20"].indexOf(modalidade) == -1) {
                                        $(this).attr("disabled", "disabled");
                                    } else {
                                        $(this).removeAttr("disabled");
                                    }
                                    break;
                                case 'ES':
                                    if (["15", "25", "22", "30"].indexOf(modalidade) == -1) {
                                        $(this).attr("disabled", "disabled");
                                    } else {
                                        $(this).removeAttr("disabled");
                                    }
                                    break;
                                default:
                                    $(this).removeAttr("disabled");
                            }
                        }
                    });
                    $("#modalidades-select").select2("");
                });

        $("#municipios-select").css("width", "300px").select2();
        $("#genero_educando").css("width", "200px").select2();
        $("#genero_professor").css("width", "200px").select2();
        $("#niveis-select").css("width", "200px").select2();

        $('#estados-select').change(function () {
            var url = "<?php echo site_url('requisicao/get_municipios_rel') . '/'; ?>" + $('#estados-select option:selected').val();
            $.get(url, function (data) {
                $('#municipios-select').html(data).select2();
            });
        });
        $("#alert_empty,#alert_csv").hide();
        $('#gerar').click(function () {
            var fileformat = $("#format").val();
            var totalfiles = $("input[name='relatorio']:checked").length;
            if (totalfiles === 0) {
                $("#alert_empty").show();
                return;
            } else {
                if (fileformat == "CSV" && totalfiles > 1) {
                    $("#alert_csv").show();
                    return;
                }
            }

            var superintendencia = $('#superintendencias-select').val();
            var curso = $('#cursos-select').val();
            var modalidade = $('#modalidades-select').val();

            var municipio = $('#municipios-select').val();
            var estado = $('#estados-select').val();

            var nivel = $('#niveis-select').val();
            var inicio0_realizado = $('#inicio0-realizado').val();
            var inicio1_realizado = $('#inicio1-realizado').val();
            var termino0_realizado = $('#termino0-realizado').val();
            var termino1_realizado = $('#termino1-realizado').val();

            var genero_educando = $('input[type=radio][name=genero_educando]:checked').val();
            var nascimento = $('#nascimento').val();

            var genero_professor = $('input[type=radio][name=genero_professor]:checked').val();

            var tipo_parceria_aux = {};

            $('#filtros_tipo_parceria .checkbox-parceria').each(function () {
                var name = $(this).attr("name");
                var value = $(this).find('input[type=radio][name=' + name + ']:checked')[0].value;
                tipo_parceria_aux[name] = value;
            });

            var status = [];
            $('#check_status input[type=checkbox]').each(function () {
                if (this.checked) {
                    status.push(this.value);
                }
            });
            var form = false;
            function on_finish() {
                alert("123");
                form.remove();
            }

            form = $('<form target="_blank" rel="noopener" style="display:none;" action="' + url + 'gerarRelatorio" method="POST">' +
                    "<textarea name='format'>" + fileformat + "</textarea>" +
                    "<textarea name='superintendencia'>" + superintendencia + "</textarea>" +
                    "<textarea name='curso'>" + curso + "</textarea>" +
                    "<textarea name='status_curso'>" + JSON.stringify(status) + "</textarea>" +
                    "<textarea name='modalidade'>" + modalidade + "</textarea>" +
                    "<textarea name='municipio'>" + municipio + "</textarea>" +
                    "<textarea name='estado'>" + estado + "</textarea>" +
                    "<textarea name='nivel'>" + nivel + "</textarea>" +
                    "<textarea name='inicio0_realizado'>" + inicio0_realizado + "</textarea>" +
                    "<textarea name='inicio1_realizado'>" + inicio1_realizado + "</textarea>" +
                    "<textarea name='termino0_realizado'>" + termino0_realizado + "</textarea>" +
                    "<textarea name='termino1_realizado'>" + termino1_realizado + "</textarea>" +
                    "<textarea name='genero_educando'>" + genero_educando + "</textarea>" +
                    "<textarea name='nascimento_educando'>" + nascimento + "</textarea>" +
                    "<textarea name='genero_professor'>" + genero_professor + "</textarea>" +
                    "<textarea name='tipo_parceria_aux'>" + JSON.stringify(tipo_parceria_aux) + "</textarea>" +
                    "<textarea name='check_curso'>" + ($('#check_curso').is(":checked") ? "true" : "false") + "</textarea>" +
                    "<textarea name='check_municipio_curso'>" + ($('#check_municipio_curso').is(":checked") ? "true" : "false") + "</textarea>" +
                    "<textarea name='check_educando'>" + ($('#check_educando').is(":checked") ? "true" : "false") + "</textarea>" +
                    "<textarea name='check_professores'>" + ($('#check_professores').is(":checked") ? "true" : "false") + "</textarea>" +
                    "<textarea name='check_disciplinas'>" + ($('#check_disciplinas').is(":checked") ? "true" : "false") + "</textarea>" +
                    "<textarea name='check_instituicao_ensino'>" + ($('#check_instituicao_ensino').is(":checked") ? "true" : "false") + "</textarea>" +
                    "<textarea name='check_organizacao_demandante'>" + ($('#check_organizacao_demandante').is(":checked") ? "true" : "false") + "</textarea>" +
                    "<textarea name='check_coordeandores_organizacao_demandante'>" + ($('#check_coordeandores_organizacao_demandante').is(":checked") ? "true" : "false") + "</textarea>" +
                    "<textarea name='check_parceiros'>" + ($('#check_parceiros').is(":checked") ? "true" : "false") + "</textarea>" +
                    "<textarea name='check_municipio_parceiros'>" + ($('#check_municipio_parceiros').is(":checked") ? "true" : "false") + "</textarea>" +
                    "<textarea name='check_tipo_parceria'>" + ($('#check_tipo_parceria').is(":checked") ? "true" : "false") + "</textarea>" +
                    "</form>").bind('ajax:complete', on_finish).appendTo('body').submit();
        });


        $("#nascimento").blur(function () {
            var value = $(this).val();
            if (value < 1900)
                $(this).val(1900);
            else if (value > <?= date("Y") ?> - 10)
                $(this).val(<?= date("Y") ?> - 10);
        });
        $(".data-inicio").blur(function () {
            if (this.value !== "") {
                $(this).next(".data-fim").attr("min", $(this).val());

                if ($(this).val() < 1998)
                    $(this).val(1998);

                if ($(this).val() > <?= date("Y") ?>)
                    $(this).val(<?= date("Y") ?>);

                if ($(this).val() > $(this).next(".data-fim").val())
                    $(this).next(".data-fim").val($(this).val());
            }
        });

        $(".data-fim").blur(function () {
            if (this.value !== "") {
                if ($(this).val() < $(this).prev(".data-inicio").val())
                    $(this).val($(this).prev(".data-inicio").val());

                if ($(this).val() < 1998)
                    $(this).val(1998);

                if ($(this).val() > <?= date("Y") ?>)
                    $(this).val(<?= date("Y") ?>);
            }
        });

        update_list_curso();

    });

</script>
<details open>
    <summary><div class="h4">Filtrar <b>Cursos</b></div></summary>
    <div role="tabpanel" class='area' id="cursos">
        <p><b>Superintendência:</b><br/> <select id="superintendencias-select"></select></p>
        <hr/>
        <div style="display: flex;flex-direction: row" id="check_status">
            <div><b>Status do Cadastro do Curso: </b></div>
            &nbsp;&nbsp;&nbsp;
            <div>
                <label><input type="checkbox" name='status_curso' value="CC" checked /> Concluídos</label><br/>
                <label><input type="checkbox" name='status_curso' value="AN" checked /> Em andamento</label><br/>
                <label><input type="checkbox" name='status_curso' value="2P" checked /> II PNERA</label>
            </div>
        </div>
        <hr/>
        <p><b>Período de Início Realizado (Ano) de</b><br/> <input type="number" id="inicio0-realizado" class="form-control data-inicio" style="max-width: 102px; display: inline;" min = "1998" placeholder="Ex: 2010"> à <input type="number" min="1998" id="inicio1-realizado" class="form-control data-fim" style="max-width: 102px; display: inline;" placeholder="Ex: 2010"></p>
        <p><b>Período de Término Realizado (Ano) de</b><br/> <input type="number" id="termino0-realizado" class="form-control data-inicio" style="max-width: 102px; display: inline;" min = "1998" placeholder="Ex: 2010"> à <input type="number" min="1998" id="termino1-realizado" class="form-control data-fim" style="max-width: 102px; display: inline;" placeholder="Ex: 2010"></p>
        <hr/>
        <div id="niveis">
            <p><b>Nível de Modalidade:</b> <br/>
                <select id="niveis-select">
                    <option value="0" selected>Todos os Níveis</option>
                    <option value="EJA">EJA FUNDAMENTAL</option>
                    <option value="EM">ENSINO MÉDIO</option>
                    <option value="ES">ENSINO SUPERIOR</option>
                </select>
            </p>
        </div>
        <div id="modalidades">
            <p><b>Ou modalidade específica:</b> <br/><select id="modalidades-select"><option value="0" selected>Todas as modalidades</option></select></p>
        </div>
        <p> <span id="alert_modalidade_nivel"></span></p>
        <hr/>
        <div id="municipios">
            <p><b>Estado (UF) de realização do curso:</b><br/><select id="estados-select"><option value="0">Selecione um Estado</option></select></p>
            <p><b>Ou município de realização do curso:</b><br/><select id="municipios-select" disabled><option value="0" selected>Todos os municípios</option></select></p>
        </div>
        <hr/>
        <div id="loading-cursos" class="lds-dual-ring"></div> <b>Ou selecione um curso:</b><br/> <select id="cursos-select"><option value="0" selected>Cursos de acordo com os filtros acima</option></select>
    </div>
</details>
<details open>
    <summary><div class="h4">Filtrar <b>Educandos</b></div></summary>
    <div class='area' id="educandos" style="display:flex;flex-direction:row;justify-content: space-between;">
        <div>
            <div style="display: flex;flex-direction: row">
                <div><b>Gênero: </b></div>
                &nbsp;&nbsp;&nbsp;
                <div>
                    <label><input type="radio" name='genero_educando' value="0" checked> Todos os gêneros</label><br/>
                    <label><input type="radio" name='genero_educando' value="M" /> Masculino</label><br/>
                    <label><input type="radio" name='genero_educando' value="F" /> Feminino</label><br/>
                    <label><input type="radio" name='genero_educando' value="N" /> Não Informado</label>
                </div>
            </div>
            <br/>
            <p>
                <b>Ano de nascimento:</b>
                <input type="number" name="nascimento" style="max-width: 102px; display: inline;" id="nascimento" placeholder="Ex: 1990" min="1900" max="<?= date("Y") - 10 ?>" class="form-control"/>
            </p>
        </div>
        <div>
            <p><i>A lista de educandos será filtrada pelos cursos</i></p><br/>
        </div>
    </div>
</details>
<details open>
    <summary><div class="h4">Filtrar <b>Professores</b></div></summary>
    <div class='area' id="professores" style="display:flex;flex-direction:row;justify-content: space-between;">
        <div>
            <div style="display: flex;flex-direction: row">
                <div><b>Gênero: </b></div>
                &nbsp;&nbsp;&nbsp;
                <div>
                    <label><input type="radio" name='genero_professor' value="0" checked> Todos os gêneros</label><br/>
                    <label><input type="radio" name='genero_professor' value="M" /> Masculino</label><br/>
                    <label><input type="radio" name='genero_professor' value="F" /> Feminino</label><br/>
                    <label><input type="radio" name='genero_professor' value="N" /> Não Informado</label>
                </div>
            </div>
        </div>
        <div>
            <p><i>A lista de professores será filtrada pelos cursos</i></p><br/>
        </div>
    </div>
</details>
<details open>
    <summary><div class="h4">Filtrar <b>Parceiros</b></div></summary>
    <div class='area' id="parceiros" style="display:flex;flex-direction:row;justify-content: space-between;">
        <div>
            <div id="filtros_tipo_parceria">
                <table class="table-checkbox">
                    <thead>
                        <tr>
                            <th style="text-align: right;">Particição</th>
                            <th style="text-align: center;width: 60px">Ambos</th>
                            <th style="text-align: center;width: 60px">Sim</th>
                            <th style="text-align: center;width: 60px">Não</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="checkbox-parceria" name="realizacao_curso">
                            <td style="text-align: right"><label for="realizacao_curso">Realização do Curso</label></td>
                            <td style="text-align: center"><input type="radio" name="realizacao_curso" value="i" checked></td>
                            <td style="text-align: center"><input type="radio" name="realizacao_curso" value="s"></td>
                            <td style="text-align: center"><input type="radio" name="realizacao_curso" value="n"></td>
                        </tr>
                        <tr class="checkbox-parceria" name="certificacao_curso">
                            <td style="text-align: right"><label for="realizacao_curso">Certificação do Curso</label></td>
                            <td style="text-align: center"><input type="radio" name="certificacao_curso" value="i" checked></td>
                            <td style="text-align: center"><input type="radio" name="certificacao_curso" value="s"></td>
                            <td style="text-align: center"><input type="radio" name="certificacao_curso" value="n"></td>
                        </tr>
                        <tr class="checkbox-parceria" name="gestao_orcamentaria">
                            <td style="text-align: right"><label for="realizacao_curso">Gestão Orçamentária</label></td>
                            <td style="text-align: center"><input type="radio" name="gestao_orcamentaria" value="i" checked></td>
                            <td style="text-align: center"><input type="radio" name="gestao_orcamentaria" value="s"></td>
                            <td style="text-align: center"><input type="radio" name="gestao_orcamentaria" value="n"></td>
                        </tr>
                        <tr class="checkbox-parceria" name="outras">
                            <td style="text-align: right"><label for="realizacao_curso">Outras</label></td>
                            <td style="text-align: center"><input type="radio" name="outras" value="i" checked></td>
                            <td style="text-align: center"><input type="radio" name="outras" value="s"></td>
                            <td style="text-align: center"><input type="radio" name="outras" value="n"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div>
            <p><i>A lista de parceiros será filtrada pelos cursos</i></p><br/>
        </div>
    </div>
</details>
<details open>
    <summary><div class="h4"><b>Configuração</b></div></summary>
    <div role="tabpanel" class='area'>
        <p><b>Relatórios a serem gerados:</b></p>
        <br/>
        <label><input type="checkbox" name='relatorio' id="check_curso" checked/> Curso </label>
        &nbsp;&nbsp;+&nbsp;&nbsp;
        <label><input type="checkbox" name='relatorio' id="check_municipio_curso" checked/> Município de realização de cursos </label>
        <br/> 
        <label><input type="checkbox" name='relatorio' id="check_educando" checked/> Educandos </label>
        <br/>
        <label><input type="checkbox" name='relatorio' id="check_professores" checked/> Professores </label>
        &nbsp;&nbsp;+&nbsp;&nbsp;
        <label><input type="checkbox" name='relatorio' id="check_disciplinas" checked/> Disciplinas </label>
        <br/>
        <label><input type="checkbox" name='relatorio' id="check_instituicao_ensino" checked/> Instituições de Ensino </label>
        <br/>
        <label><input type="checkbox" name='relatorio' id="check_organizacao_demandante" checked/> Organizações Demandantes </label>
        <br/>
        <label><input type="checkbox" name='relatorio' id="check_parceiros" checked/> Parceiros </label>
    </div>
</details> 
<div class="alert alert-block alert-danger fade in" id="alert_empty">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <b>Nenhum relatório selecionado!</b>&nbsp;&nbsp;&nbsp;
    Por favor selecione pelo menos um dos relatórios
</div>
<br>
<p id="filter-alert"><i class="fa fa-exclamation-triangle"></i> Nenhum curso passou nos filtros </p>
<input type="button" id="gerar" class="btn btn-success" value="Gerar Planilha">
<label> &nbsp;&nbsp;&nbsp;&nbsp;Formato de Exportação: </label>
<select class="form-control" id="format" style="display: inline;width: 270px;">
    <option value="XLSX">XLSX - Microsoft Excel</option>
    <option value="ODS">ODS - LibreOffice Calc</option>
    <option value="JSON">JSON - JavaScript Object Notation</option>
</select>
