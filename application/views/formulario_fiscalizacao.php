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
                $('#superintendencia option[value="' + super_curso + '"]').html(value+" (SR do CURSO)");
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
                var url = "<?php echo site_url('/request/get_funcao').'/'; ?>"+cod_pesquisador;
                
                $.get(url, function (funcao) {
                    var node = ['N', cod_pesquisador, "SR - "+superintendencia, pesquisador, funcao];
                    if (!table.nodeExistsById(node,1)) {
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
            
            var fiscalizacao_tipo = "<?php echo ($retrivial?$dados[0]->id_tipo:0); ?>";

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
                var node = ['N', cod_pesquisador, "SR - "+superintendencia, pesquisador, "Carregando"];
                
                if (!table.nodeExistsById(node,1)) {

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

            if (isFormComplete(form)) {

                var formData = {
                    id: id,
                    tipo: $('#tipo').val(),
                    tipo_descricao: $('#tipo_descricao').val().toUpperCase(),
                    resumo: $("#resumo").val(),
                    data: $('#data').val(),
                    membros: table.getAll(),
                    membros_excluidos: table.getDeletedRows(1)
                };

                var urlRequest = "<?php
                    if ($operacao == 'add')
                        echo site_url('fiscalizacao/add/');
                    if ($operacao == 'update')
                        echo site_url('fiscalizacao/update/');
                ?>";

                request(urlRequest, formData);
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

<form id="form"	method="post">
    <fieldset>
        <legend>Caracteriza&ccedil;&atilde;o de Acompanhamento/Fiscalização</legend>

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
            <label><?= ++$countInput; ?>. Anexo<br></label>
            <div class="form-group">
                <div>
                    <div class="col-lg-6 col-sm-6 col-12">
                        <div class="input-group">
                            <label class="input-group-btn">
                                <span class="btn btn-success">
                                    Escolher <input type="file" style="display: none;" multiple>
                                </span>
                            </label>
                            <input type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <p class="text-danger select"><label for="file"><label></label></label></p>
                </div>
            </div>
        </div>
    </fieldset>
</form>