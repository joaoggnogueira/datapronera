<?php
$this->session->set_userdata('curr_content', 'cadastro_curso');
?>

<script type="text/javascript">

    // Modalidades
    $.get("<?php echo site_url('requisicao/get_modalidades'); ?>", function (modalidade) {
        $('#modalidade').html(modalidade);

        var modalidade_curso = "<?php echo ($operacao != 'add') ? $dados[0]->id_modalidade : 0; ?>";

        if (modalidade_curso != 0) {
            $('#modalidade option[value="' + modalidade_curso + '"]').attr("selected", true);
        }
    });

    // Tipo do Instrumento
    $.get("<?php echo site_url('requisicao/get_tipo_instrumento_curso'); ?>", function (instrumentos_html_options) {
        $('#instrumento').html(instrumentos_html_options);

        var instrumento_curso = "<?php echo ($operacao != 'add') ? $dados[0]->id_instrumento : 0; ?>";

        if (instrumento_curso != 0) {
            $('#instrumento option[value="' + instrumento_curso + '"]').attr("selected", true);
        }
    });

    $(document).ready(function () {
        // Superintendências
        $.get("<?php echo site_url('requisicao/get_superintendencias'); ?>", function (superintendencia) {
            $('#superintendencia').html(superintendencia);

            var super_curso = "<?php echo ($operacao != 'add') ? $dados[0]->id_superintendencia : 0; ?>";
            var urlPesquisadores = "<?php echo site_url('requisicao/get_pesquisadores'); ?>";
            // Lista de Pesquisadores (Reutilizaram listCities para pesquisadores)
            $('#superintendencia').listCities(urlPesquisadores, 'curso_sel_pessoa_equipe');

            if (super_curso != 0) {
                $('#superintendencia option[value="' + super_curso + '"]').attr("selected", true);
                $('#superintendencia').change();
            }
        });
        var id = "<?php echo $curso['id']; ?>";
        $('#data').mask('99/99/9999');
        setPlaceholderNInstrumento = function (value) {
            switch (value) {
                case "1": //CONVÊNIO
                    $("#ninstrumento").attr("placeholder", "XXXXXX/AAAA");
                    $("#ninstrumento").attr("pattern", "[0-9]{6}\/[0-9]{4}");
                    break;
//                case "2": //TED
//                    $("#ninstrumento").attr("placeholder", "XX-MM/AAAA");
//                    $("#ninstrumento").attr("pattern", "[0-9]{2}-[0-9]{2}\/[0-9]{4}");
//                    break;
                default: //OUTROS
                    $("#ninstrumento").removeAttr("pattern", "");
                    $("#ninstrumento").removeAttr("placeholder", "");
            }
        };
        //Antigo Campos:
        //Responsável pela pesquisa
<?PHP if ($operacao != 'add'): ?>
    <?PHP if ($dados[0]->id_pesquisador): ?>
                $.get("<?php echo site_url('requisicao/get_pesquisador_nome') . '/' . $dados[0]->id_pesquisador; ?>", function (nome) {
                    $("#pesquisador").val(nome);
                });
    <?PHP endif; ?>
            setPlaceholderNInstrumento("<?= $dados[0]->id_instrumento ?>");
<?PHP endif; ?>

        /* Opções Complementares */

        $('#modalidade').change(function (e) {
            if (e.target.value == 'OUTRA') {
                $('#modalidade_descricao').show().focus();

            } else {
                $('#modalidade_descricao').hide();
                $('#modalidade_descricao').hideErrorMessage();
            }
        });


        $("#instrumento").change(function (e) {
            if (e.target.value == "OUTRO") {
                $('#instrumento_descricao').show().focus();
            } else {
                $('#instrumento_descricao').hide();
                $('#instrumento_descricao').hideErrorMessage();
            }
            setPlaceholderNInstrumento(e.target.value);
        });

        var table = new Table({
            url: "<?php echo site_url('request/get_curso_pesquisadores') . (($operacao != 'add') ? '/' . $dados[0]->id : '/-1'); ?>",
            table: $('#equipe_superintendencia_table'),
            controls: $('#equipe_superintendencia_controls')
        });
        table.hideColumns([0, 1]);
        $('#curso_botao_pessoa_equipe_add').click(function () {

            var form = Array(
                    {
                        'id': 'superintendencia',
                        'message': 'Selecione a superintendência',
                        'extra': null
                    },
                    {
                        'id': 'curso_sel_pessoa_equipe',
                        'message': 'Selecione o pesquisador',
                        'extra': null
                    }
            );

            if (isFormComplete(form)) {

                var cod_pesquisador = $('#curso_sel_pessoa_equipe').val();
                var pesquisador = $('#curso_sel_pessoa_equipe option:selected').text();

                var node = ['N', cod_pesquisador, pesquisador];

                if (!table.nodeExists(node)) {

                    table.addData(node);

                    $('#curso_sel_pessoa_equipe').val(0);

                } else {
                    $('#curso_sel_pessoa_equipe').showErrorMessage('Pesquisador já adicionado!');
                }
            }
        });

        $('#salvar').click(function () {

            var form = Array(
                    {
                        'id': 'nome',
                        'message': 'Informe o nome do curso',
                        'extra': null
                    },
                    {
                        'id': 'modalidade',
                        'message': 'Informe a modalidade do curso',
                        'extra': null
                    },
                    {
                        'id': 'modalidade_descricao',
                        'ni': (($('#modalidade').val() == 'OUTRA') ? false : true),
                        'message': 'Especifique a modalidade do curso',
                        'extra': null
                    },
                    {
                        'id': 'superintendencia',
                        'message': 'Informe a superintendência a qual o curso pertence',
                        'extra': null
                    },
                    {
                        'id': 'data',
                        'message': 'Informe a data no qual o curso foi criado',
                        'extra': {operation: "pattern", message: "Padrão não corresponde com uma data"}
                    },
                    {
                        'id': 'instrumento',
                        'ni': (($('#instrumento').val() == 'OUTRO') ? false : true),
                        'message': 'Especifique a modalidade do curso',
                        'extra': null
                    }

            /*{
             'id'      : 'pesquisador',
             'message' : 'Informe o nome do pesquisador responsável pelo preenchimento dos dados referente ao curso',
             'extra'   : null
             }*/
            );

            if (document.getElementById("nprocesso").value !== "") {
                form.push({
                    'id': 'nprocesso',
                    'message': 'Informe o numero do processo',
                    'extra': {operation: "pattern", message: "Padrão não corresponde com um número de processo"}
                });
            } else {
                $("#nprocesso").hideErrorMessage();
                
            }
            if (document.getElementById("ninstrumento").value !== "") {
                form.push({
                    'id': 'ninstrumento',
                    'message': 'Informe o numero do instrumento',
                    'extra': {operation: "pattern", message: "Padrão não corresponde com um número de instrumento do tipo selecionado"}
                });
            } else {
                $("#ninstrumento").hideErrorMessage();
            }

            if (isFormComplete(form)) {

                var formData = {
                    id_curso: id,
                    nome: $('#nome').val().toUpperCase(),
                    modalidade: $('#modalidade').val(),
                    modalidade_descricao: $('#modalidade_descricao').val().toUpperCase(),
                    superintendencia: $('#superintendencia').val(),
                    data: $('#data').val(),
                    nprocesso: $('#nprocesso').val(),
                    ninstrumento: $('#ninstrumento').val(),
                    instrumento: $('#instrumento').val(),
                    instrumento_descricao: $('#instrumento_descricao').val().toUpperCase(),
                    pesquisadores: table.getAll(),
                    pesquisadores_excluidos: table.getDeletedRows(1)
//                    pesquisador: $('#pesquisador').val() || null
                };


                urlRequest = "<?php
if ($operacao == 'add') {
    echo site_url('curso/add/');
} else if ($operacao == 'update') {
    echo site_url('curso/update/');
}
?>";
                request(urlRequest, formData);
            }
        });

        $('#reset').click(function () {

            var urlRequest = "<?php echo site_url('curso/index/'); ?>";

            request(urlRequest, null, 'hide');
        });

    });
</script>

<form>
    <fieldset>
        <legend> Cadastro de Curso </legend>

        <div class="form-group controles">
            <?php
            if ($operacao != 'view') {
                echo "<input type=\"button\" id=\"salvar\" class=\"btn btn-success\" value=\"Salvar\"> <hr/>";
            }
            ?>
            <input type="button" id="reset" class="btn btn-default" value="Voltar">
        </div>

        <div class="form-group">
            <label>1. Nome do Curso</label>
            <div>
                <textarea class="form-control tamanho-exlg" id="nome" name="nome"><?php if ($operacao != 'add') echo $dados[0]->nome; ?></textarea>
                <label class="control-label form bold" for="nome"></label>
            </div>
        </div>

        <div class="form-group">
            <label>2. Modalidade/nivel do curso</label>
            <div class="form-group">
                <div>
                    <select class="form-control" id="modalidade" name="modalidade"></select>
                    <p class="text-danger select"><label for="modalidade"></label></p>
                </div>
            </div>
            <div class="form-group">
                <div>
                    <input type="text" class="form-control tamanho-lg" id="modalidade_descricao" name="modalidade_descricao" placeHolder="Especifique" style="display: none;"/>
                    <label class="control-label form bold" for="modalidade_descricao"></label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>3. Superintendência</label>
            <div class="form-group">
                <select class="form-control" id="superintendencia" name="superintendencia"></select>
                <p class="text-danger select"><label for="superintendencia"></label></p>
            </div>
        </div>
        <div class="table-box table-box-lg" id="equipe_superintendencia_form">
            <div class="form-group">
                <label>3.1. Equipe da Superintendência</label>
                <div class="form-group">
                    <ul id="equipe_superintendencia_controls" class="nav nav-pills buttons">
                        <li>
                            <select class="form-control select_equipe_superintendencia negacao" id="curso_sel_pessoa_equipe" name="curso_sel_pessoa_equipe"></select>
                            <p class="text-danger select equipe_superintendencia"><label for="curso_sel_pessoa_equipe"></label></p>
                        </li>
                        <li class="buttons">
                            <button type="button" class="btn btn-default" id="curso_botao_pessoa_equipe_add" name="curso_botao_pessoa_equipe_add">Adicionar</button>
                        </li>
                        <li class="buttons">
                            <button type="button" class="btn btn-default btn-disabled disabled delete-row" id="deletar" name="deletar">Remover Selecionado</button>
                        </li>
                    </ul>
                </div>

                <div class="table-size">
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="equipe_superintendencia_table">
                        <thead>
                            <tr>
                                <th style="width:   0px;"> FLAG </th>
                                <th style="width:   0px;"> CÓDIGO </th>
                                <th style="width:   0px;"> NOME </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div> 
        </div>
        <div class="form-group">
            <label>4. Numero do Processo <span class="badge">Opcional</span></label>
            <div>
                <input placeholder="XXXXX.XXXXXX/AAAA-XX" pattern="[0-9]{5}.[0-9]{6}\/[0-9]{4}-[0-9]{2}" maxlength="20" class="form-control tamanho-sm" id="nprocesso" name="nprocesso" value="<?php if ($operacao != 'add') echo $dados[0]->nprocesso; ?>"/>
                <label class="control-label form bold" for="nprocesso"></label>
            </div>
        </div>
        <div class="form-group">
            <label>5. Instrumento do curso</label>
            <div class="form-group">
                <div>
                    <select class="form-control" id="instrumento" name="instumento"></select>
                    <p class="text-danger select"><label for="instrumento"></label></p>
                </div>
            </div>
            <div class="form-group">
                <div>
                    <input maxlength="22" style="width: 230px;display: none;" type="text" class="form-control" id="instrumento_descricao" name="instrumento_descricao" placeHolder="Especifique"/>
                    <label class="control-label form bold" for="instrumento_descricao"></label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>6. Numero do Instrumento <span class="badge">Opcional</span></label>
            <div>
                <input maxlength="20" class="form-control tamanho-sm" id="ninstrumento" name="ninstrumento" value="<?php if ($operacao != 'add') echo $dados[0]->ninstrumento; ?>"/>
                <label class="control-label form bold" for="ninstrumento"></label>
            </div>
        </div>
        <div class="form-group">
            <label>7. Data de criação do curso<br><small>dd/mm/aaaa</small></label>
            <div class="form-group">
                <div>
                    <input pattern="\d{1,2}/\d{1,2}/\d{4}" placeholder="DD/MM/AAAA" name="data" id="data" class="form-control tamanho-sm2" value="<?php if ($operacao != 'add') echo $dados[0]->data; ?>"/>
                    <p class="text-danger select"><label for="data"><label></label></label></p>
                </div>
            </div>
        </div>

        </div>
        <?PHP if ($operacao != 'add'): ?>
            <?PHP if ($dados[0]->id_pesquisador): ?>
                <div class="form-group">
                    <label>Respons&aacute;vel pela Pesquisa<br><small>Campo da versão antiga</small></label>
                    <div class="form-group">
                        <div>
                            <input disabled="" name="pesquisador" id="pesquisador" class="form-control"/>
                            <p class="text-danger select"><label for="pesquisador"><label></label></label></p>
                        </div>
                    </div>
                </div>
            <?PHP endif; ?>
        <?PHP endif; ?>
    </fieldset>
</form>