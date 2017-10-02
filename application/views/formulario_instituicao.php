<?php
if (empty($dados)) {
    echo "<script> request('" . site_url('instituicao/index/') . "', null, 'hide'); </script>";
    exit();
}
?>

<script type="text/javascript">

    // recupera estados e municipios selecionando que estão no banco de dados
    $.get("<?php echo site_url('requisicao/get_estados'); ?>", function (estados) {
        $('#instituicao_sel_est').html(estados);

        $.get("<?php echo site_url('instituicao/get_estado'); ?>", function (id_estado) {
            $('#instituicao_sel_est option[value="' + id_estado + '"]').attr("selected", true);

            $.get("<?php echo site_url('requisicao/get_municipios') . '/'; ?>" + id_estado, function (cidades) {
                $('#instituicao_sel_mun').html(cidades);

                $.get("<?php echo site_url('instituicao/get_municipio'); ?>", function (cidade) {
                    $('#instituicao_sel_mun option[value="' + cidade + '"]').attr("selected", true);
                });
            });
        });
    });

    $(document).ready(function () {

        var urlMunicipios = "<?php echo site_url('requisicao/get_municipios'); ?>";

        // Lista de Municípios
        $('#instituicao_sel_est').listCities(urlMunicipios, 'instituicao_sel_mun');
        /*$("#instituicao_sel_est").change(function () {
         var state_id = $("#instituicao_sel_est").val();
         
         $("#instituicao_sel_mun").html("<option>Aguarde...</option>");
         
         $.get("<?php echo site_url('requisicao/get_municipios') . '/'; ?>" + state_id, function(cidades) {
         $('#instituicao_sel_mun').html(cidades);
         });
         
         }).change();*/

        // Máscara para inputs
        $('#instituicao_cep').mask("99.999-999");
        $('#instituicao_tel1').mask("(99)9999-9999");
        $('#instituicao_tel2').mask("(99)9999-9999");

        // Não informado
        $('#ckInstituicao_tel2').niCheck({
            'id': ['instituicao_tel2']
        });

        $('#ckInstituicao_pag_web').niCheck({
            'id': ['instituicao_site']
        });

        $('#ckInstituicao_campus').niCheck({
            'id': ['instituicao_campus']
        });

        $('#ckInstituicao_numero').niCheck({
            'id': ['instituicao_numero']
        });

        $('#salvar').click(function () {

            var form = Array(
                    {
                        'id': 'instituicao_nome',
                        'message': 'Informe o nome da instituição',
                        'extra': null
                    },
                    {
                        'id': 'instituicao_sigla',
                        'message': 'Informe a sigla da instituição',
                        'extra': null
                    },
                    {
                        'id': 'instituicao_unidade',
                        'message': 'Informe a unidade da instituição',
                        'extra': null
                    },
                    {
                        'id': 'instituicao_depto',
                        'message': 'Informe o departamento/seção da instituição',
                        'extra': null
                    },
                    {
                        'id': 'instituicao_rua',
                        'message': 'Informe o nome da rua/avenida do logradouro da instituição',
                        'extra': null
                    },
                    {
                        'id': 'instituicao_numero',
                        'ni': $('#ckInstituicao_numero').prop("checked"),
                        'message': 'Informe, caso possua, o número referente ao logradouro da instituição, <br />' +
                                'caso contrário selecione a opção "S/N"',
                        'extra': null
                    },
                    {
                        'id': 'instituicao_bairro',
                        'message': 'Informe o nome do bairro do logradouro da instituição',
                        'extra': null
                    },
                    {
                        'id': 'instituicao_cep',
                        'message': 'Informe o CEP referente ao logradouro da instituição',
                        'extra': null
                    },
                    {
                        'id': 'instituicao_sel_mun',
                        'message': 'Selecione o município',
                        'extra': null
                    },
                    {
                        'id': 'instituicao_sel_est',
                        'message': 'Selecione o estado',
                        'extra': null
                    },
                    {
                        'id': 'instituicao_tel1',
                        'message': 'Informe o número de telefone da instituição',
                        'extra': null
                    },
                    {
                        'id': 'instituicao_tel2',
                        'ni': $('#ckInstituicao_tel2').prop("checked"),
                        'message': 'Informe o número de telefone da instituição',
                        'extra': null
                    },
                    {
                        'id': 'instituicao_campus',
                        'ni': $('#ckInstituicao_campus').prop("checked"),
                        'message': 'Informe o nome do campus da instituição',
                        'extra': null
                    },
                    {
                        'id': 'instituicao_site',
                        'ni': $('#ckInstituicao_pag_web').prop("checked"),
                        'message': 'Informe o endereço web da instituição',
                        'extra': null
                    },
                    {
                        'name': 'rInstituicao_natureza',
                        'message': 'Informe a natureza da instituição',
                        'extra': null
                    }
            );

            if (isFormComplete(form)) {

                var formData = {
                    instituicao_nome: $('#instituicao_nome').val().toUpperCase(),
                    instituicao_sigla: $('#instituicao_sigla').val().toUpperCase(),
                    instituicao_unidade: $('#instituicao_unidade').val().toUpperCase(),
                    instituicao_depto: $('#instituicao_depto').val().toUpperCase(),
                    instituicao_rua: $('#instituicao_rua').val().toUpperCase(),
                    instituicao_numero: $('#instituicao_numero').val().toUpperCase(),
                    instituicao_complemento: $('#instituicao_complemento').val().toUpperCase(),
                    instituicao_bairro: $('#instituicao_bairro').val().toUpperCase(),
                    instituicao_cep: $('#instituicao_cep').val().toUpperCase(),
                    instituicao_sel_mun: $('#instituicao_sel_mun').val().toUpperCase(),
                    instituicao_tel1: $('#instituicao_tel1').val().toUpperCase(),
                    ckInstituicao_tel2: $('#ckInstituicao_tel2').prop('checked'),
                    instituicao_tel2: $('#instituicao_tel2').val().toUpperCase(),
                    ckInstituicao_campus: $('#ckInstituicao_campus').prop('checked'),
                    instituicao_campus: $('#instituicao_campus').val().toUpperCase(),
                    ckInstituicao_pag_web: $('#ckInstituicao_pag_web').prop('checked'),
                    instituicao_site: $('#instituicao_site').val().toLowerCase(),
                    rInstituicao_natureza: $("input:radio[name=rInstituicao_natureza]:checked").val()
                };

                var urlRequest = "<?php echo site_url('instituicao/update'); ?>";

                // Faz requisição de login ao servidor (retorna um objeto JSON)
                request(urlRequest, formData);
            }
        });

        $('#reset').click(function () {

            urlRequest = "<?php echo site_url('instituicao/index/'); ?>";

            // Faz requisição de login ao servidor (retorna um objeto JSON)
            request(urlRequest, null, 'hide');
        });
        $("#instituicao_numero").keypress(function (e) {
            preventChar(e);
        });
    });

</script>

<form>
    <fieldset>
        <legend>Caracteriza&ccedil;&atilde;o da Institui&ccedil;&atilde;o de Ensino</legend>

        <div class="form-group controles">
<?php
// II PNERA
if ($this->session->userdata('status_curso') != '2P' &&
        $this->session->userdata('status_curso') != 'CC') {
    echo '<input type="button" id="salvar" class="btn btn-success" value="Salvar">
	                      <hr/>';
}
?>
            <input type="button" id="reset" class="btn btn-default" value="Cancelar">
        </div>

        <div class="form-group">
            <label>1. Nome da Institui&ccedil;&atilde;o de Ensino</label>
            <div>
                <input type="text" class="form-control tamanho-lg" id="instituicao_nome" name="instituicao_nome"
                       value="<?php echo $dados[0]->nome; ?>">
                <label class="control-label form" for="instituicao_nome"></label>
            </div>
        </div>

        <div class="form-group">
            <label>2. Sigla</label>
            <div>
                <input type="text" class="form-control tamanho-sm" id="instituicao_sigla" name="instituicao_sigla"
                       value="<?php echo $dados[0]->sigla; ?>">
                <label class="control-label form" for="instituicao_sigla"></label>
            </div>
        </div>

        <div class="form-group">
            <label>3. Unidade: (Pr&oacute;-reitoria, Faculdade, Instituto, Centro, etc)</label>
            <div>
                <input type="text" class="form-control tamanho" id="instituicao_unidade" name="instituicao_unidade"
                       value="<?php echo $dados[0]->unidade; ?> ">
                <label class="control-label form" for="instituicao_unidade"></label>
            </div>
        </div>

        <div class="form-group">
            <label>4. Departamento, Se&ccedil;&atilde;o, etc</label>
            <div>
                <input type="text" class="form-control tamanho-lg" id="instituicao_depto" name="instituicao_depto"
                       value="<?php echo $dados[0]->departamento; ?>">
                <label class="control-label form" for="instituicao_depto"></label>
            </div>
        </div>

        <div class="form-group">
            <label>5. Logradouro</label>
            <div class="form-group interno">
                <label> a. Rua, Avenida, etc. </label>
                <div>
                    <input type="text" class="form-control tamanho-n" id="instituicao_rua" name="instituicao_rua"
                           value="<?php echo $dados[0]->rua; ?>">
                    <label class="control-label form" for="instituicao_rua"></label>
                </div>
            </div>
            <div class="form-group interno">
                <label class="negacao"> b. N&uacute;mero </label>

                <div class="checkbox negacao-sm">
                    <label> <input type="checkbox" name="ckInstituicao_numero" id="ckInstituicao_numero"
<?php if ($dados[0]->numero == 0) echo 'checked'; ?> > S/N </label>
                </div>

                <div class="form-group">
                    <div>
                        <input type="text" class="form-control tamanho-smaller" id="instituicao_numero" name="instituicao_numero"
                               value="<?php echo $dados[0]->numero; ?>" maxLength="5">
                        <label class="control-label form" for="instituicao_numero"></label>
                    </div>
                </div>
            </div>
            <div class="form-group interno">
                <label> c. Complemento </label>
                <div>
                    <input type="text" class="form-control" id="instituicao_complemento" name="instituicao_complemento"
                           value="<?php echo $dados[0]->complemento; ?>">
                    <label class="control-label form" for="instituicao_complemento"></label>
                </div>
            </div>
            <div class="form-group interno">
                <label> d. Bairro </label>
                <input type="text" class="form-control" id="instituicao_bairro" name="instituicao_bairro"
                       value="<?php echo $dados[0]->bairro; ?>">
                <label class="control-label form" for="instituicao_bairro"></label>
            </div>
            <div class="form-group interno">
                <label> e. CEP 	</label>
                <div>
                    <input type="text" class="form-control tamanho-small" id="instituicao_cep" name="instituicao_cep"
                           value="<?php echo $dados[0]->cep; ?>">
                    <label class="control-label form" for="instituicao_cep"></label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>6. Munic&iacute;pio</label>
            <div>
                <div class="negacao">
                    <select class="form-control select_estado negacao" id="instituicao_sel_est" name="instituicao_sel_est"></select>
                    <p class="text-danger select estado"><label for="instituicao_sel_est"><label></p>
                                </div>
                                <div class="negacao">
                                    <select class="form-control select_municipio negacao" id="instituicao_sel_mun" name="instituicao_sel_mun"></select>
                                    <p class="text-danger select municipio"><label for="instituicao_sel_mun"><label></p>
                                                </div>
                                                </div>
                                                <div class="form-group"></div> <!-- CORRIGIR ESPAÇAMENTO DO FLOAT LEFT ACIMA -->
                                                </div>

                                                <div class="form-group">
                                                    <label>7. Telefone(s)</label>
                                                    <div class="form-group interno">
                                                        <label> a. Telefone 1 </label>
                                                        <div>
                                                            <input type="text" class="form-control tamanho-small" id="instituicao_tel1" name="instituicao_tel1"
                                                                   value="<?php echo $dados[0]->telefone1; ?>">
                                                            <label class="control-label form" for="instituicao_tel1"></label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group interno">
                                                        <label class="negacao"> b. Telefone 2 </label>

                                                        <div class="checkbox negacao-sm">
                                                            <label> <input type="checkbox" name="ckInstituicao_tel2" id="ckInstituicao_tel2"
<?php if ($dados[0]->telefone2 == 'NAOINFORMADO') echo 'checked'; ?> > N&atilde;o informado </label>
                                                        </div>

                                                        <div class="form-group">
                                                            <div>
                                                                <input type="text" class="form-control tamanho-small" id="instituicao_tel2" name="instituicao_tel2"
                                                                       value="<?php echo $dados[0]->telefone2; ?>">
                                                                <label class="control-label form" for="instituicao_tel2"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="negacao"> 8. Campus </label>

                                                    <div class="checkbox negacao-sm">
                                                        <label> <input type="checkbox" name="ckInstituicao_campus" id="ckInstituicao_campus"
<?php if ($dados[0]->campus == 'NAOINFORMADO') echo 'checked'; ?> > N&atilde;o informado </label>
                                                    </div>

                                                    <div class="form-group">
                                                        <div>
                                                            <input type="text" class="form-control tamanho-n" id="instituicao_campus" name="instituicao_campus"
                                                                   value="<?php if ($dados[0]->campus != 'NAOINFORMADO') echo $dados[0]->campus; ?>">
                                                            <label class="control-label form" for="instituicao_campus"></label>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="form-group">
                                                    <label class="negacao"> 9. P&aacute;gina da web </label>

                                                    <div class="checkbox negacao-sm">
                                                        <label> <input type="checkbox" name="ckInstituicao_pag_web" id="ckInstituicao_pag_web"
<?php if ($dados[0]->pagina_web == 'naoinformado') echo 'checked'; ?> > N&atilde;o informado </label>
                                                    </div>

                                                    <div class="form-group">
                                                        <div>
                                                            <input type="text" class="form-control tamanho-lg url" id="instituicao_site" name="instituicao_site"
                                                                   value="<?php echo $dados[0]->pagina_web; ?>">
                                                            <label class="control-label form" for="instituicao_site"></label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label>10. Natureza da Institui&ccedil;&atilde;o</label>

                                                    <div>
                                                        <div class="radio"> <label> <input type="radio" name="rInstituicao_natureza" id="rInstituicao_natureza_01"
                                                                                           value="PUBLICA MUNICIPAL" <?php if ($dados[0]->natureza_instituicao == "PUBLICA MUNICIPAL") echo "checked"; ?> > P&uacute;blica Municipal </label> </div>
                                                        <div class="radio"> <label> <input type="radio" name="rInstituicao_natureza" id="rInstituicao_natureza_02"
                                                                                           value="PUBLICA ESTADUAL" <?php if ($dados[0]->natureza_instituicao == "PUBLICA ESTADUAL") echo "checked"; ?> > P&uacute;blica Estadual </label> </div>
                                                        <div class="radio"> <label> <input type="radio" name="rInstituicao_natureza" id="rInstituicao_natureza_03"
                                                                                           value="PUBLICA FEDERAL" <?php if ($dados[0]->natureza_instituicao == "PUBLICA FEDERAL") echo "checked"; ?> > P&uacute;blica Federal </label> </div>
                                                        <div class="radio"> <label> <input type="radio" name="rInstituicao_natureza" id="rInstituicao_natureza_04"
                                                                                           value="PRIVADA SEM FINS LUCRATIVOS" <?php if ($dados[0]->natureza_instituicao == "PRIVADA SEM FINS LUCRATIVOS") echo "checked"; ?> > Privada sem fins lucrativos </label> </div>

                                                        <p class="text-danger"><label for="rInstituicao_natureza"><label></p>
                                                                    </div>
                                                                    </div>

                                                                    </fieldset>

<?php echo form_close(); ?>