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
        //Antigo Campos:
        //Responsável pela pesquisa
<?PHP if ($operacao != 'add'): ?>
    <?PHP if ($dados[0]->id_pesquisador): ?>
                $.get("<?php echo site_url('requisicao/get_pesquisador_nome') . '/' . $dados[0]->id_pesquisador; ?>", function (nome) {
                    $("#pesquisador").val(nome);
                });
    <?PHP endif; ?>
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
                        'extra': null
                    },
                    {
                        'id': 'nprocesso',
                        'message': 'Informe o numero do processo',
                        'extra': null
                    },
                    {
                        'id': 'ninstrumento',
                        'message': 'Informe o numero do instrumento',
                        'extra': null
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


        <!--<div class="radio form-group">
            <div class="radio"> <label> <input type="radio" name="rmodalidade" id="rmodalidade_01" value="EJA ALFABETIZACAO" <?php //if ($operacao != 'add' && $modalidade[0]->modalidade_curso == "EJA ALFABETIZACAO") echo "checked";                                          ?>>
                    Eja alfabetiza&ccedil;&atilde;o </label> </div>
            <div class="radio"> <label> <input type="radio" name="rmodalidade" id="rmodalidade_02" value="EJA ANOS INICIAIS" <?php //if ($operacao != 'add' && $modalidade[0]->modalidade_curso == "EJA ANOS INICIAIS") echo "checked";                                          ?>>
                    Eja anos iniciais </label> </div>
            <div class="radio"> <label> <input type="radio" name="rmodalidade" id="rmodalidade_03" value="EJA ANOS FINAIS" <?php //if ($operacao != 'add' && $modalidade[0]->modalidade_curso == "EJA ANOS FINAIS") echo "checked";                                          ?>>
                    Eja anos finais </label> </div>
            <div class="radio"> <label> <input type="radio" name="rmodalidade" id="rmodalidade_04" value="EJA NIVEL MEDIO (MAGISTERIO/FORMAL)" <?php //if ($operacao != 'add' && $modalidade[0]->modalidade_curso == "EJA NIVEL MEDIO (MAGISTERIO/FORMAL)") echo "checked";                                          ?>>
                    Eja n&iacute;vel m&eacute;dio (magist&eacute;rio/formal) </label> </div>
            <div class="radio"> <label> <input type="radio" name="rmodalidade" id="rmodalidade_05" value="EJA NIVEL MEDIO (NORMAL)" <?php //if ($operacao != 'add' && $modalidade[0]->modalidade_curso == "EJA NIVEL MEDIO (NORMAL)") echo "checked";                                          ?>>
                    Eja n&iacute;vel m&eacute;dio </label> </div>
            <div class="radio"> <label> <input type="radio" name="rmodalidade" id="rmodalidade_06" value="NIVEL MEDIO/TECNICO (CONCOMITANTE)" <?php //if ($operacao != 'add' && $modalidade[0]->modalidade_curso == "NIVEL MEDIO/TECNICO (CONCOMITANTE)") echo "checked";                                          ?>>
                    N&iacute;vel m&eacute;dio/t&eacute;cnico (concomitante) </label> </div>
            <div class="radio"> <label> <input type="radio" name="rmodalidade" id="rmodalidade_07" value="NIVEL MEDIO/TECNICO (INTEGRADO)" <?php //if ($operacao != 'add' && $modalidade[0]->modalidade_curso == "NIVEL MEDIO/TECNICO (INTEGRADO)") echo "checked";                                          ?>>
                    N&iacute;vel m&eacute;dio/t&eacute;cnico (integrado) </label> </div>
            <div class="radio"> <label> <input type="radio" name="rmodalidade" id="rmodalidade_08" value="NIVEL MEDIO PROFISSIONAL (POS-MEDIO)" <?php //if ($operacao != 'add' && $modalidade[0]->modalidade_curso == "NIVEL MEDIO PROFISSIONAL (POS-MEDIO)") echo "checked";                                          ?>>
                    N&iacute;vel m&eacute;dio profissional (p&oacute;s-m&eacute;dio) </label> </div>
            <div class="radio"> <label> <input type="radio" name="rmodalidade" id="rmodalidade_09" value="GRADUACAO" <?php //if ($operacao != 'add' && $modalidade[0]->modalidade_curso == "GRADUACAO") echo "checked";                                          ?>>
                    Gradua&ccedil;&atilde;o </label> </div>
            <div class="radio"> <label> <input type="radio" name="rmodalidade" id="rmodalidade_10" value="ESPECIALIZACAO" <?php //if ($operacao != 'add' && $modalidade[0]->modalidade_curso == "ESPECIALIZACAO") echo "checked";                                          ?>>
                    Especializa&ccedil;&atilde;o </label> </div>
            <div class="radio"> <label> <input type="radio" name="rmodalidade" id="rmodalidade_11" value="RESIDENCIA AGRARIA" <?php //if ($operacao != 'add' && $modalidade[0]->modalidade_curso == "RESIDENCIA AGRARIA") echo "checked";                                          ?>>
                    Residencia agr&aacute;ria </label> </div>
            <div class="radio"> <label> <input type="radio" name="rmodalidade" id="rmodalidade_12" value="MESTRADO" <?php //if ($operacao != 'add' && $modalidade[0]->modalidade_curso == "MESTRADO") echo "checked";                                          ?>>
                    Mestrado </label> </div>
            <div class="radio"> <label> <input type="radio" name="rmodalidade" id="rmodalidade_13" value="DOUTORADO" <?php //if ($operacao != 'add' && $modalidade[0]->modalidade_curso == "DOUTORADO") echo "checked";                                          ?>>
                    Doutorado </label> </div>
            <div class="radio"> <label> <input type="radio" name="rmodalidade" id="rmodalidade_14" value="OUTROS" <?php //if ($operacao != 'add' && $modalidade[0]->modalidade_curso == "OUTROS") echo "checked";                                          ?>>
                    Outros </label> </div>
                            <input type="text" class="form-control" id="modalidade_outros" name="modalidade_outros" value="<?php //if ($operacao != 'add' && $modalidade[0]->modalidade_curso == "OUTROS") echo $modalidade[0]->modalidade_curso_descr;                                         ?>" />
        </div>
</div>-->
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
            <label>4. Numero do Processo</label>
            <div>
                <input maxlength="9" style="width:100px" class="form-control tamanho-exlg" id="nprocesso" name="nprocesso" value="<?php if ($operacao != 'add') echo $dados[0]->nprocesso; ?>"/>
                <label class="control-label form bold" for="nprocesso"></label>
            </div>
        </div>
        <div class="form-group">
            <label>5. Numero do Instrumento</label>
            <div>
                <input maxlength="9" style="width:100px" class="form-control tamanho-exlg" id="ninstrumento" name="ninstrumento" value="<?php if ($operacao != 'add') echo $dados[0]->ninstrumento; ?>"/>
                <label class="control-label form bold" for="ninstrumento"></label>
            </div>
        </div>
        <div class="form-group">
            <label>6. Instrumento do curso</label>
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
            <label>7. Data de criação do curso<br><small>dd/mm/aaaa</small></label>
            <div class="form-group">
                <div>
                    <input type="date" name="data" id="data" class="form-control tamanho-sm2" value="<?php if ($operacao != 'add') echo $dados[0]->data; ?>"/>
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