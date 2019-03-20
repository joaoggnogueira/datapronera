<?php
$this->session->set_userdata('curr_content', 'professor');
if ($operacao == 'add')
    $retrivial = false;
else
    $retrivial = true;
?>
<style>
    .ui-autocomplete {
        max-width: 400px;
        max-height: 200px;
        overflow-y: auto;
        overflow-x: hidden;
    }
    
    #middle{
        margin-top: 170px;
    }
</style>
<script type="text/javascript">

    //var excluido = new Array ();

    $(document).ready(function () {

        var id = "<?php echo $professor['id']; ?>";
        var url = "<?php echo site_url('request/get_disciplinas') . '/' ?>" + id;

        var table = new Table({
            url: url,
            table: $('#disciplines_table'),
            controls: $('#disciplines_controls')
        });

        table.hideColumns([0, 1]);

        $('#adicionar').click(function () {

            var form = Array(
                    {
                        'id': 'professor_disc',
                        'message': 'Informe a disciplina / matéria lecionada',
                        'extra': null
                    }
            );

            if (isFormComplete(form)) {
                var nome = $('#professor_disc').val().toUpperCase();

                var node = ['N', 0, nome];

                if (!table.nodeExists(node)) {

                    //$('#disciplinas_table').dataTable().fnAddData(node);
                    table.addData(node);
                    $('#professor_disc').val('');

                } else {
                    $('#professor_disc').showErrorMessage('Disciplina já cadastrada');
                }
            }
        });

        /* NAO INFORMADOS */
        $('#ckDisciplinas_ni').niCheck({
            'id': ['professor_disc', 'adicionar'],
            'class': ['delete-row']
        });

        $('#ckCPF_ni').niCheck({
            'id': ['professor_cpf', 'ckCPF_na']
        });

        $('#ckCPF_na').niCheck({
            'id': ['professor_cpf', 'ckCPF_ni']
        });

        $('#ckRg_ni').niCheck({
            'id': ['professor_rg', 'ckRg_na']
        });

        $('#ckRg_na').niCheck({
            'id': ['professor_rg', 'ckRg_ni']
        });

        $('#ckSexo_ni').niCheck({
            'name': ['rprof_sexo']
        });

        $('#ckTitulacao_ni').niCheck({
            'name': ['rprof_escola']
        });
        <?PHP if ($retrivial): ?>
            $("#desc-course").fadeIn(400).find(".navbar-brand").text("Editando professor(a) <?= $dados[0]->nome ?>");
        <?PHP endif; ?>
        $('#salvar').click(function () {

            var form = Array({
                'id': 'professor_nome',
                'message': 'Informe o nome do(a) professor(a) / educador(a)',
                'extra': {
                    'operation': 'pattern',
                    'message': 'O nome possui caracteres inválidos'
                }
            }, {
                'id': 'professor_cpf',
                'ni': ($('#ckCPF_ni').prop('checked') ||
                        $('#ckCPF_na').prop('checked')),
                'message': 'Informe o CPF do(a) professor(a) / educador(a)',
                'extra': null
            }, {
                'id': 'professor_rg',
                'ni': ($('#ckRg_ni').prop('checked') ||
                        $('#ckRg_na').prop('checked')),
                'message': 'Informe o RG do(a) professor(a) / educador(a)',
                'extra': null
            }, {
                'name': 'rprof_sexo',
                'ni': $('#ckSexo_ni').prop('checked'),
                'message': 'Informe o sexo do(a) professor(a) / educador(a)',
                'extra': null
            }, {
                'name': 'rprof_escola',
                'ni': $('#ckTitulacao_ni').prop('checked'),
                'message': 'Informe o grau de escolaridade / titulação do(a) professor(a) / educador(a)',
                'extra': null
            }
            );

            if (isFormComplete(form)) {

                var urlRequest = "<?php if ($operacao == 'add')
    echo site_url('professor/add/');
if ($operacao == 'update')
    echo site_url('professor/update/');
?>";

                var formData = {
                    id: id,
                    professor_nome: $('#professor_nome').val().toUpperCase(),
                    ckDisciplinas_ni: $('#ckDisciplinas_ni').prop('checked'), // true
                    ckSexo_ni: $('#ckSexo_ni').prop('checked'),
                    ckCPF_ni: $('#ckCPF_ni').prop('checked'),
                    ckCPF_na: $('#ckCPF_na').prop('checked'),
                    professor_cpf: $('#professor_cpf').val().toUpperCase(),
                    ckRg_ni: $('#ckRg_ni').prop('checked'),
                    ckRg_na: $('#ckRg_na').prop('checked'),
                    professor_rg: $('#professor_rg').val().toUpperCase(),
                    rprof_sexo: $("input:radio[name=rprof_sexo]:checked").val(),
                    ckTitulacao_ni: $('#ckTitulacao_ni').prop('checked'),
                    rprof_escola: $("input:radio[name=rprof_escola]:checked").val(),
                    disciplinas: table.getAll(),
                    disc_excluidas: table.getDeletedRows(1)
                };

                // Faz requisição de login ao servidor (retorna um objeto JSON)
                request(urlRequest, formData);
            }
        });

        $("#professor_disc").autocomplete({
            source: function (request, response) {
                $.get("<?php echo site_url('professor/sugestao_disciplina') ?>/" + request.term.toUpperCase(), function (data) {
                    var json = JSON.parse(data);
                    console.log(json);
                    response(json);
                });
            },
            minLength: 3
        });

        //SUGESTÃO DO GENÊRO A PARTIR DO NOME
        $("#professor_nome").blur(function () {
            var value = $("input:radio[name=rprof_sexo]:checked").val();
            if (this.value !== "") {
                $.get("<?php echo site_url('professor/sugestao_genero') ?>/" + this.value, function (response) {
                    if (response == "I") {
                        $('input:radio[name=rprof_sexo][value="M"]')[0].checked = false;
                        $('input:radio[name=rprof_sexo][value="F"]')[0].checked = false;
                    } else {
                        $('input:radio[name=rprof_sexo][value="' + response + '"]')[0].checked = true;
                    }
                });
            }
        });

        $('#reset').click(function () {
            var urlRequest = "<?php echo site_url('professor/index/'); ?>";

            // Faz requisição de login ao servidor (retorna um objeto JSON)
            request(urlRequest, null, 'hide');
        });
        $("#professor_cpf").keypress(function (e) {
            preventChar(e);
        });
    });

</script>



<form id="form"	method="post">
    <fieldset>
        <legend>Caracteriza&ccedil;&atilde;o do(a) Professor(a) / Educador(a)</legend>

        <div class="form-group controles">
            <?php
            if ($this->session->userdata('status_curso') != '2P' && $this->session->userdata('status_curso') != 'CC' && $operacao != 'view') {
                echo "<input type=\"button\" id=\"salvar\" class=\"btn btn-success\" value=\"Salvar\"> <hr/>";
            }
            ?>
            <input type="button" id="reset" class="btn btn-default" value="Voltar">
        </div>

        <div class="form-group">
            <label>1. Nome Completo do(a) professor(a) / educador(a)</label>
            <div>
                <input type="text" class="form-control tamanho-lg" pattern="^[^-\s][a-zA-ZÀ-ú ]*" id="professor_nome" name="professor_nome" value="<?php if ($retrivial) echo $dados[0]->nome; ?>">
                <label class="control-label form" for="professor_nome"></label>
            </div>
        </div>

        <div class="table-box table-box-small">
            <label class="negacao">2. Disciplina(s) / Mat&eacute;ria(s) lecionada(s)</label>

            <div class="checkbox negacao-smaller">
                <label> <input type="checkbox" name="ckDisciplinas_ni" id="ckDisciplinas_ni" <?php if ($retrivial && $dados[0]->disciplina_ni == 'V') echo "checked"; ?>> N&atilde;o Informado </label>
            </div>

<?php if ($this->uri->segment(2) != 'index_view') { ?>

                <ul id="disciplines_controls" class="nav nav-pills buttons">
                    <li>
                        <input type="text" class="form-control negacao" id="professor_disc" name="professor_disc">
                    </li>
                    <li>
                        <button type="button" class="btn btn-default" id="adicionar" name="adicionar"> Adicionar </button>
                    </li>
                    <li class="buttons">
                        <button type="button" class="btn btn-default btn-disabled disabled delete-row" id="deletar" name="deletar"> Remover Selecionada </button>
                    </li>
                    <li>
                        <label class="control-label form" for="professor_disc"></label>
                    </li>
                </ul>
<?php } ?>

            <div class="table-size">
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="disciplines_table">
                    <thead>
                        <tr>
                            <th style="width: 10px;"> FLAG </th>
                            <th style="width: 10px;"> CÓDIGO </th>
                            <th style="width: 250px"> DISCIPLINA </th>
                        </tr>
                    </thead>

                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="form-group">
            <label class="negacao">3. CPF (somente n&uacute;meros)</label>

            <div class="checkbox">
                <label class="negacao-sm"> <input type="checkbox" name="ckCPF_ni" id="ckCPF_ni"  value="NAOINFORMADO" <?php if ($retrivial && $dados[0]->cpf == "NAOINFORMADO") echo "checked"; ?>> N&atilde;o encontrado </label>
                <label class="negacao-sm"> <input type="checkbox" name="ckCPF_na" id="ckCPF_na"  value="NAOAPLICA" <?php if ($retrivial && $dados[0]->cpf == "NAOAPLICA") echo "checked"; ?>> Não se aplica </label>
            </div>
            <div>
                <input type="text" class="form-control tamanho-small" id="professor_cpf" name="professor_cpf" maxlength="11"
                       value="<?php if ($retrivial && $dados[0]->cpf != "NAOAPLICA" && $dados[0]->cpf != "NAOINFORMADO") echo $dados[0]->cpf; ?>">
                <label class="control-label form" for="professor_cpf"></label>
            </div>
        </div>

        <div class="form-group">
            <label class="negacao">4. R.G.</label>

            <div class="checkbox">
                <label class="negacao-sm"> <input type="checkbox" name="ckRg_ni" id="ckRg_ni"  value="NAOINFORMADO" <?php if ($retrivial && $dados[0]->rg == "NAOINFORMADO") echo "checked"; ?>> N&atilde;o encontrado </label>
                <label class="negacao-sm"> <input type="checkbox" name="ckRg_na" id="ckRg_na"  value="NAOAPLICA" <?php if ($retrivial && $dados[0]->rg == "NAOAPLICA") echo "checked"; ?>> Não se aplica </label>
            </div>
            <div>
                <input type="text" class="form-control tamanho-small" id="professor_rg" name="professor_rg"  maxlength="25"
                       value="<?php if ($retrivial && $dados[0]->rg != "NAOAPLICA" && $dados[0]->rg != "NAOINFORMADO") echo $dados[0]->rg; ?>">
                <label class="control-label form" for="professor_rg"></label>
            </div>
        </div>

        <div class="form-group">
            <label class="negacao">5. G&ecirc;nero</label>

            <div class="checkbox negacao-smaller">
                <label> <input type="checkbox" name="ckSexo_ni" id="ckSexo_ni" <?php if ($retrivial && $dados[0]->genero == 'N') echo "checked"; ?>> N&atilde;o informado </label>
            </div>

            <div class="radio form-group">
                <div class="radio"><label> <input type="radio" name="rprof_sexo" id="rprof_sexo_01" value="M" <?php if ($retrivial && $dados[0]->genero == 'M') echo "checked"; ?>> Masculino </label> </div>
                <div class="radio"><label> <input type="radio" name="rprof_sexo" id="rprof_sexo_02" value="F" <?php if ($retrivial && $dados[0]->genero == 'F') echo "checked"; ?>> Feminino</label> </div>
                <p class="text-danger"><label for="rprof_sexo"><label></p>
                            </div>
                            </div>

                            <div class="form-group">
                                <label class="negacao">6. Grau de escolaridade / titula&ccedil;&atilde;o do(a) professor(a) / educador(a) quando o curso foi realizado</label>

                                <div class="checkbox negacao-sm">
                                    <label> <input type="checkbox" name="ckTitulacao_ni" id="ckTitulacao_ni" <?php if ($retrivial) if ($dados[0]->titulacao == 'NAOINFORMADO') echo "checked"; ?>> N&atilde;o informado </label>
                                </div>

                                <div class="radio form-group">
                                    <div class="radio"><label> <input type="radio" name="rprof_escola" id="rprof_escola_01" value="ENSINO FUNDAMENTAL COMPLETO" <?php if ($retrivial && $dados[0]->titulacao == 'ENSINO FUNDAMENTAL COMPLETO') echo "checked"; ?>> Ensino Fundamental Completo </label></div>
                                    <div class="radio"><label> <input type="radio" name="rprof_escola" id="rprof_escola_02" value="ENSINO FUNDAMENTAL INCOMPLETO" <?php if ($retrivial && $dados[0]->titulacao == 'ENSINO FUNDAMENTAL INCOMPLETO') echo "checked"; ?>> Ensino Fundamental Incompleto</label></div>
                                    <div class="radio"><label> <input type="radio" name="rprof_escola" id="rprof_escola_03" value="ENSINO MEDIO COMPLETO" <?php if ($retrivial && $dados[0]->titulacao == 'ENSINO MEDIO COMPLETO') echo "checked"; ?>> Ensino M&eacute;dio Completo </label></div>
                                    <div class="radio"><label> <input type="radio" name="rprof_escola" id="rprof_escola_04" value="ENSINO MEDIO INCOMPLETO" <?php if ($retrivial && $dados[0]->titulacao == 'ENSINO MEDIO INCOMPLETO') echo "checked"; ?>> Ensino M&eacute;dio Incompleto </label></div>
                                    <div class="radio"><label> <input type="radio" name="rprof_escola" id="rprof_escola_05" value="GRADUADO(A)" <?php if ($retrivial && $dados[0]->titulacao == 'GRADUADO(A)') echo "checked"; ?>> Graduado(a)</label></div>
                                    <div class="radio"><label> <input type="radio" name="rprof_escola" id="rprof_escola_06" value="ESPECIALISTA" <?php if ($retrivial && $dados[0]->titulacao == 'ESPECIALISTA') echo "checked"; ?>> Especialista </label></div>
                                    <div class="radio"><label> <input type="radio" name="rprof_escola" id="rprof_escola_07" value="MESTRE(A)" <?php if ($retrivial && $dados[0]->titulacao == 'MESTRE(A)') echo "checked"; ?>> Mestre(a) </label></div>
                                    <div class="radio"><label> <input type="radio" name="rprof_escola" id="rprof_escola_08" value="DOUTOR(A)" <?php if ($retrivial && $dados[0]->titulacao == 'DOUTOR(A)') echo "checked"; ?>> Doutor(a) </label></div>
                                    <p class="text-danger"><label for="rprof_escola"><label></p>
                                                </div>
                                                </div>

        <!--<input type="text" id="disciplinas_objeto" name="disciplinas_objeto" hidden/>-->

                                                </fieldset>
<?php echo form_close(); ?>