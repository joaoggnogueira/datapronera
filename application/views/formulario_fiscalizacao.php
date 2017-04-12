<?php
$this->session->set_userdata('curr_content', 'fiscalizacao');
$retrivial = ($operacao != 'add');
?>
<script type="text/javascript">

    //var oTable;

    $(document).ready(function () {

        var id = "<?php echo $fiscalizacao['id']; ?>";
        var url = "<?php echo site_url('/request/get_fiscalizadores') . (($operacao != 'add') ? '/' . $fiscalizacao['id'] : '/-1'); ?>";

        var table = new Table({
            url: url,
            table: $('#members_table'),
            controls: $('#members_controls')
        });

        table.hideColumns([0, 1]);
        $.get("<?php echo site_url('requisicao/get_superintendencias'); ?>", function (superintendencia) {
            $('#superintendencia').html(superintendencia);

            var super_curso = "<?php echo $superintendencia; ?>";
            var urlPesquisadores = "<?php echo site_url('requisicao/get_pesquisadores') ?>";
            // Lista de Pesquisadores (Reutilizaram listCities para pesquisadores)
            $('#superintendencia').listCities(urlPesquisadores, 'fiscalizacao_sel_pessoa_equipe');

            if (super_curso != 0) {
                var value = $('#superintendencia option[value="' + super_curso + '"]').html();
                $('#superintendencia option[value="' + super_curso + '"]').html(value + " (SR do CURSO)");
                $('#superintendencia option[value="' + super_curso + '"]').attr("selected", true);
                $('#superintendencia').change();
            }
        });

        $('#botao_add_memb').click(function () {

            var form = Array(
                    {
                        'id': 'superintendencia',
                        'message': 'Selecione a superintendência',
                        'extra': null
                    },
                    {
                        'id': 'fiscalizacao_sel_pessoa_equipe',
                        'message': 'Selecione o pesquisador',
                        'extra': null
                    }
            );

            if (isFormComplete(form)) {

                var cod_pesquisador = $('#fiscalizacao_sel_pessoa_equipe').val();
                var pesquisador = $('#fiscalizacao_sel_pessoa_equipe option:selected').text();
                var superintendencia = $('#superintendencia').val();
                var url = "<?php echo site_url('/request/get_funcao') . '/'; ?>" + cod_pesquisador;

                $.get(url, function (funcao) {
                    var node = ['N', cod_pesquisador, "SR - " + superintendencia, pesquisador, funcao];
                    if (!table.nodeExistsById(node, 1)) {
                        table.addData(node);
                        $('#fiscalizacao_sel_pessoa_equipe').val(0);
                    } else {
                        $('#fiscalizacao_sel_pessoa_equipe').showErrorMessage('Pesquisador já adicionado!');
                    }
                });
            }
        });
        /* Máscara para inputs */
        $('#data').mask("99/99/9999");

        // Tipo
        $.get("<?php echo site_url('requisicao/get_tipo_fiscalizacao'); ?>", function (modalidade) {
            $('#tipo').html(modalidade);

            var fiscalizacao_tipo = "<?php echo ($retrivial ? $dados[0]->id_tipo : 0); ?>";

            if (fiscalizacao_tipo != 0) {
                $('#tipo option[value="' + fiscalizacao_tipo + '"]').attr("selected", true);
            }
        });

        $('#tipo').change(function (e) {

            if (e.target.value == 'OUTRO') {
                $('#tipo_descricao').show().focus();

            } else {
                $('#tipo_descricao').hide();
                $('#tipo_descricao').hideErrorMessage();
            }
        });



        contador = 0;
        $('#botao_movim_coord').click(function () {

            var form = Array(
                    {
                        'id': 'movimento_nome_membro',
                        'message': 'Informe o nome do membro envolvido no curso',
                        'extra': null
                    },
                    {
                        'id': 'movimento_grau_membro',
                        'message': 'Informe o grau de escolaridade do membro na época do curso',
                        'extra': null
                    },
                    {
                        'name': 'rmovimento_estudo',
                        'message': 'Informe se o membro estudou/estuda em curso do PRONERA',
                        'extra': null
                    }
            );

            if (isFormComplete(form)) {

                var cod_pesquisador = $('#fiscalizacao_sel_pessoa_equipe').val();
                var pesquisador = $('#fiscalizacao_sel_pessoa_equipe option:selected').text();
                var superintendencia = $('#superintendencia').val();
                $.get("<?php echo site_url('requisicao/get_superintendencias'); ?>", function (superintendencia) {

                });
                var node = ['N', cod_pesquisador, "SR - " + superintendencia, pesquisador, "Carregando"];

                if (!table.nodeExistsById(node, 1)) {

                    table.addData(node);

                    $('#fiscalizacao_sel_pessoa_equipe').val(0);
                    $('#funcao').val("");

                } else {
                    $('#fiscalizacao_sel_pessoa_equipe').showErrorMessage('Pesquisador já adicionado!');
                }
            }
        });

        $('#salvar').click(function () {

            var form = Array(
                    {
                        'id': 'tipo',
                        'message': 'Informe o tipo da fiscalização',
                        'extra': null
                    },
                    {
                        'id': 'tipo_descricao',
                        'ni': (($('#tipo').val() == 'OUTRO') ? false : true),
                        'message': 'Especifique o tipo da fiscalização',
                        'extra': null
                    },
                    {
                        'id': 'resumo',
                        'message': 'Descreva detalhes sobre a fiscalização',
                        'extra': null
                    },
                    {
                        'id': 'data',
                        'message': 'Informe a abrangência da organização demandante',
                        'extra': null
                    }
            );
            var fileinput = $("input#file").get(0);
            if (fileinput.files.length != 0 && !fileinput.validate) {
                return;
            }

            if (isFormComplete(form)) {

                var urlRequest = "<?php
if ($operacao == 'add')
    echo site_url('fiscalizacao/add/');
if ($operacao == 'update')
    echo site_url('fiscalizacao/update/');
?>";

                requestMultipart(urlRequest, "form");
            }
        });

        $('#reset').click(function () {

            var urlRequest = "<?php echo site_url('/fiscalizacao/index') ?>";

            request(urlRequest, null, 'hide');
        });
    });

</script>

<?php
$countInput = 0;
$countBoxMembers = 97;
?>


<form id="form"	method="post" enctype="multipart/form-data">
    <fieldset>
        <legend>Caracteriza&ccedil;&atilde;o de Acompanhamento/Fiscalização</legend>
        <?PHP if ($operacao == "update"): ?>
            <input type="hidden" name="id" value="<?php echo $fiscalizacao['id']; ?>"/>
        <?PHP endif; ?>

        <div class="form-group controles">
            <?php
            if ($this->session->userdata('status_curso') != '2P' && $this->session->userdata('status_curso') != 'CC' && $operacao != 'view') {
                echo "<input type=\"button\" id=\"salvar\" class=\"btn btn-success\" value=\"Salvar\"> <hr/>";
            }
            ?>
            <input type="button" id="reset" class="btn btn-default" value="Voltar">
        </div>
        <div class="form-group">
            <label><?= ++$countInput; ?>. Tipo do Acompanhamento/Fiscalização</label>
            <div class="form-group">
                <div>
                    <select class="form-control" id="tipo" name="tipo"></select>
                    <p class="text-danger select"><label for="tipo"></label></p>
                </div>
            </div>
            <div class="form-group">
                <div>
                    <input type="text" class="form-control tamanho-lg" id="tipo_descricao" name="tipo_descricao" placeHolder="Especifique" style="display: none;">
                    <label class="control-label form bold" for="tipo_descricao"></label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label><?= ++$countInput; ?>. Resumo</label>
            <div class="form-group">
                <div>
                    <textarea class="form-control tamanho-exlg" id="resumo" name="resumo"><?php if ($retrivial) echo $dados[0]->resumo; ?></textarea>
                    <label class="control-label form" for="resumo"></label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label><?= ++$countInput; ?>. Data da fiscalização<br><small>dd/mm/aaaa</small></label>
            <div class="form-group">
                <div>
                    <input type="date" name="data" id="data" class="form-control" value="<?php if ($retrivial) echo $dados[0]->data; ?>"/>
                    <p class="text-danger select"><label for="data"><label></label></label></p>
                </div>
            </div>
        </div>

        <div class="table-box table-box-lg">
            <label><?= ++$countInput; ?>. Membros envolvidos</label>
            <div class="form-group interno">
                <label> <?= chr($countBoxMembers++) ?>. Superintendência do membro </label>
                <div>
                    <select class="form-control select_equipe_superintendencia negacao" id="superintendencia" name="superintendencia"></select>
                    <p class="text-danger select equipe_superintendencia"><label for="superintendencia"></label></p>
                </div>
            </div>
            <div class="form-group interno">
                <label> <?= chr($countBoxMembers++) ?>. Nome do membro </label>
                <div>
                    <select class="form-control select_equipe_superintendencia negacao" id="fiscalizacao_sel_pessoa_equipe" name="fiscalizacao_sel_pessoa_equipe"></select>
                    <p class="text-danger select equipe_superintendencia"><label for="fiscalizacao_sel_pessoa_equipe"></label></p>
                </div>
            </div>
            <div class="form-group interno">
                <ul id="members_controls" class="nav nav-pills buttons">
                    <li class="buttons">
                        <button type="button" style="margin-top: 10px" id="botao_add_memb" class="btn btn-default">Adicionar Membro</button>
                    </li>
                    <li class="buttons">
                        <button type="button" style="margin-top: 10px" class="btn btn-default btn-disabled disabled delete-row" id="deletar" name="deletar"> Remover Selecionado </button>
                    </li>
                </ul>
            </div>
            <div class="table-size table-size-lg">
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="members_table">
                    <thead>
                        <tr>
                            <th width="0px;"> FLAG </th>
                            <th width="0px;"> ID PESSOA </th>
                            <th width="0px;"> SR </th>
                            <th width="0px;"> NOME </th>
                            <th width="0px;"> FUNÇÃO </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="form-group">
            <label><?= ++$countInput; ?>. Anexo
                <br><small>Arquivo deve ser menor que <?= $maxSizeFile ?>MB</small>
                <br><small>Somente arquivo do tipo <?= $allowedTypesFile ?></small>
            </label>
            <?PHP if ($retrivial): ?>
                <?PHP if (!empty($arquivos)): ?>
                    <div class="form-group">
                        <label class="input-group-btn" id="file-layout">
                            <span class="btn btn-success" id="download">
                                Baixar arquivo<br><small><?= $arquivos[0]->name ?></small>
                            </span>
                            <?PHP if ($operacao == "update"): ?>
                                <br/>
                                <span class="btn btn-danger" id="removeFile">
                                    Remover arquivo
                                </span>
                            <?PHP endif; ?>
                        </label>
                    </div>
                <?PHP else: ?>
                    <label class="input-group-btn">
                        <span class="btn btn-default">
                            Sem Arquivo
                        </span>
                    </label>
                <?PHP endif; ?>
                <label><?= $countInput; ?>.1 <label id="label-alterar-arquivo"><?= (empty($arquivos)?"Incluir":"Alterar") ?></label> arquivo</label>
            <?PHP endif; ?>
            <?PHP if ($operacao == "add" || $operacao == "update"): ?>
                <div class="form-group">
                    <div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="input-group">
                                <label class="input-group-btn">
                                    <span class="btn btn-success">
                                        Escolher <input id="file" data-allow-file-size="<?= $maxSizeFile * 1024 * 1024 ?>" data-allowed-file-extensions='["pdf","doc","xls","jpg","zip","arj"]' type="file" name="file" style="display: none;">
                                    </span>
                                </label>
                                <input type="text" class="form-control" readonly>
                                <label class="input-group-btn" id="clearfile" style="display: none">
                                    <span class="btn btn-default">
                                        Limpar
                                    </span>
                                </label>
                            </div>
                        </div>
                        <br/>
                        <br/>
                        <p class="text-danger select"><label for="file"><label></label></label></p>
                    </div>
                </div>
            <?PHP else: ?>
                <label class="input-group-btn">
                    <span class="btn btn-default">
                        Sem anexo
                    </span>
                </label>
            <?PHP endif; ?>
        </div>
    </fieldset>
</form>
<script>
    $(function () {
        $("#download").click(function () {
            var form = $("<form method='POST' action='./index.php/fiscalizacao/download'>")
                    .append($("<input name='id'>").val(<?= $fiscalizacao['id'] ?>))
                    .append($("<input name='index'>").val(0));
            $(document.body).append(form);
            form.submit();
            form.remove();
        });


        $("#removeFile").click(function () {
            var data = {id:<?php echo $fiscalizacao['id']; ?>};
            requestWithoutRedirect("<?= site_url("fiscalizacao/removeFile") ?>", data);
            $("#file-layout").html("<label class='input-group-btn'><span class='btn btn-default'>Sem Arquivo</span></label>")
            $("#label-alterar-arquivo").html("Incluir");
        });

        // We can attach the `fileselect` event to all file inputs on the page
        $(document).on('change', ':file', function () {
            var input = $(this), label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            validateFile("file",<?= $maxSizeFile ?> * 1024 * 1024, [
                "application/msword",
                "application/pdf",
                "application/zip",
                "application/x-zip-compressed",
                "application/vnd.oasis.opendocument.text",
                "text/csv",
                "text/plain",
                "image/jpeg",
                "image/png",
                "application/vnd.ms-excel",
                "application/arj"]);

            input.trigger('fileselect', [label]);
            $("#clearfile").fadeIn(400);
        });

        // We can watch for our custom `fileselect` event like this
        $(document).ready(function () {
            $("#clearfile").click(function () {
                var input = $("input#file");
                input.val("");
                $("#clearfile").fadeOut(400);
                input.trigger('fileselect', [""]);
                input.hideErrorMessage();
            });

            $(':file').on('fileselect', function (event, label) {

                var input = $(this).parents('.input-group').find(':text'),
                        log = label;

                if (input.length) {
                    input.val(log);
                } else {
                    if (log)
                        alert(log);
                }

            });
        });

    });

</script>