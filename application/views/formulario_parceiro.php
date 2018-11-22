<?php
$this->session->set_userdata('curr_content', 'parceiro');
?>

<script type="text/javascript">

    var id_parceiro = "<?php echo $parceiro['id']; ?>";

    //recupera estados e municipios selecionando oque está no banco de dados
    $.get("<?php echo site_url('requisicao/get_estados'); ?>", function (estados) {
        $('#parceiro_sel_est').html(estados);

        if (id_parceiro != 0) {

            $.get("<?php echo site_url('parceiro/get_estado') . '/'; ?>" + id_parceiro, function (id_estado) {
                $('#parceiro_sel_est option[value="' + id_estado + '"]').attr("selected", true);

                $.get("<?php echo site_url('requisicao/get_municipios') . '/'; ?>" + id_estado, function (cidades) {
                    $('#parceiro_sel_mun').html(cidades);

                    $.get("<?php echo site_url('parceiro/get_municipio') . '/'; ?>" + id_parceiro, function (cidade) {
                        $('#parceiro_sel_mun option[value="' + cidade + '"]').attr("selected", true);
                    });
                });
            });
        }
    });

    $(document).ready(function () {

        var urlMunicipios = "<?php echo site_url('requisicao/get_municipios'); ?>";

        // Lista de Municípios
        $('#parceiro_sel_est').listCities(urlMunicipios, 'parceiro_sel_mun');

        /* Lista de Municípios
         $("#parceiro_sel_est").change(function () {
         var state_id = $("#parceiro_sel_est").val();
         
         $("#parceiro_sel_mun").html("<option>Aguarde...</option>");
         
         $.get( url  + 'requisicao/get_municipios/'+state_id, function(cidades) {
         $('#parceiro_sel_mun').html(cidades);
         });
         }).change();
         
         // Tipo de parceria : Outros
         $('#ckparceiro_tipo_04').click(function () {
         if ($(this).is(":checked")) {
         $('#parceiro_tipo_outros').css("display","block");
         } else {
         $('#parceiro_tipo_outros').val("");
         $('#parceiro_tipo_outros').css("display","none");
         }
         });*/

        /* Máscara para inputs */
//        $('#parceiro_cep').mask("99.999-999");
//        $('#parceiro_tel1').mask("(99)9999-9999");
//        $('#parceiro_tel2').mask("(99)9999-9999");
        
        
        /* Não informados */
        $('#ckParceiro_numero').niCheck({
            'id': ['parceiro_numero']
        });

        $('#ckParceiro_tel2').niCheck({
            'id': ['parceiro_tel2','radioTel21','radioTel22','radioTel23']
        });

        $('#ckParceiro_site').niCheck({
            'id': ['parceiro_site']
        });

        /* Opções complementares */
        $('input[name=rparceiro_natureza]').optionCheck({
            'id': ['parceiro_natureza_outros']

        }, "OUTROS");

        $('#ckparceiro_tipo_outro').optionCheck({
            'id': ['parceiro_tipo_outros']
        });

        $('#salvar').click(function () {

            var form = Array(
                    {
                        'id': 'parceiro_nome',
                        'message': 'Informe o nome do parceiro',
                        'extra': null
                    },
                    {
                        'id': 'parceiro_sigla',
                        'message': 'Informe a sigla do parceiro',
                        'extra': null
                    },
                    {
                        'id': 'parceiro_rua',
                        'message': 'Informe o nome da rua/avenida do logradouro do parceiro',
                        'extra': null
                    },
                    {
                        'id': 'parceiro_numero',
                        'ni': $('#ckParceiro_numero').prop('checked'),
                        'message': 'Informe, caso possua, o número referente ao logradouro do parceiro, <br />' +
                                'caso contrário selecione a opção "S/N"',
                        'extra': null
                    },
                    {
                        'id': 'parceiro_bairro',
                        'message': 'Informe o nome do bairro do logradouro do parceiro',
                        'extra': null
                    },
                    {
                        'id': 'parceiro_cep',
                        'message': 'Informe o CEP referente ao logradouro do parceiro',
                        'extra': null
                    },
                    {
                        'id': 'parceiro_sel_mun',
                        'message': 'Selecione o município',
                        'extra': null
                    },
                    {
                        'id': 'parceiro_sel_est',
                        'message': 'Selecione o estado',
                        'extra': null
                    },
                    {
                        'id': 'parceiro_tel1',
                        'message': 'Informe o número de telefone do parceiro',
                        'extra': null
                    },
                    {
                        'id': 'parceiro_tel2',
                        'ni': $('#ckParceiro_tel2').prop('checked'),
                        'message': 'Informe o número de telefone do parceiro',
                        'extra': null
                    },
                    {
                        'id': 'parceiro_site',
                        'ni': $('#ckParceiro_site').prop('checked'),
                        'message': 'Informe o endereço web do parceiro',
                        'extra': null
                    },
                    {
                        'name': 'rparceiro_natureza',
                        'message': 'Informe a natureza do parceiro',
                        'next': false,
                        'extra': null
                    },
                    {
                        'id': 'parceiro_natureza_outros',
                        'ni': !$('#rparceiro_natureza_08').prop('checked'),
                        'message': 'Especifique a natureza do parceiro',
                        'extra': null
                    },
                    {
                        'name': 'rparceiro_abrangencia',
                        'message': 'Informe a abrangência do parceiro',
                        'extra': null
                    },
                    {
                        'name': 'ckparceiro_tipo',
                        'message': 'Informe o tipo da parceria',
                        'next': false,
                        'extra': null
                    },
                    {
                        'id': 'parceiro_tipo_outros',
                        'ni': !$('#ckparceiro_tipo_outro').prop('checked'),
                        'message': 'Especifique o tipo de parceria',
                        'extra': null
                    }
            );

            if (isFormComplete(form)) {

                var formData = {
                    id: id_parceiro,
                    parceiro_nome: $('#parceiro_nome').val().toUpperCase(),
                    parceiro_sigla: $('#parceiro_sigla').val().toUpperCase(),
                    parceiro_rua: $('#parceiro_rua').val().toUpperCase(),
                    parceiro_numero: $('#parceiro_numero').val().toUpperCase(),
                    parceiro_complemento: $('#parceiro_complemento').val().toUpperCase(),
                    parceiro_bairro: $('#parceiro_bairro').val().toUpperCase(),
                    parceiro_cep: $('#parceiro_cep').val().toUpperCase(),
                    parceiro_sel_mun: $('#parceiro_sel_mun').val().toUpperCase(),
                    parceiro_tel1: $('#parceiro_tel1').val().toUpperCase(),
                    parceiro_tel2: $('#parceiro_tel2').val().toUpperCase(),
                    ckParceiro_tel2: $('#ckParceiro_tel2').prop('checked'),
                    ckParceiro_site: $('#ckParceiro_site').prop('checked'),
                    parceiro_site: $('#parceiro_site').val().toUpperCase(),
                    rparceiro_natureza: $("input:radio[name=rparceiro_natureza]:checked").val(),
                    rparceiro_abrangencia: $("input:radio[name=rparceiro_abrangencia]:checked").val(),
                    ckparceiro_tipo_01: $('#ckparceiro_tipo_01').prop('checked'),
                    ckparceiro_tipo_02: $('#ckparceiro_tipo_02').prop('checked'),
                    ckparceiro_tipo_03: $('#ckparceiro_tipo_03').prop('checked'),
                    ckparceiro_tipo_04: $('#ckparceiro_tipo_04').prop('checked'),
                    ckparceiro_tipo_05: $('#ckparceiro_tipo_05').prop('checked'),
                    ckparceiro_tipo_outro: $('#ckparceiro_tipo_outro').prop('checked'),
                    parceiro_tipo_outros: $('#parceiro_tipo_outros').val().toUpperCase()
                };

                var urlRequest = "<?php
if ($operacao == 'add')
    echo site_url('parceiro/add/');
if ($operacao == 'update')
    echo site_url('parceiro/update/');
?>";

                request(urlRequest, formData);
            }
        });

        $('#reset').click(function () {

            var urlRequest = "<?php echo site_url('parceiro/index/'); ?>";

            request(urlRequest, null, 'hide');
        });
        $("#parceiro_numero").keypress(function (e) {
            preventChar(e);
        });
    });

</script>

<?php
if ($operacao == 'add')
    $retrivial = false;
else
    $retrivial = true;
?>

<form id="form"	method="post">
    <fieldset>		
        <legend>Caracteriza&ccedil;&atilde;o do Parceiro</legend>

        <div class="form-group controles">
            <?php
            if ($this->session->userdata('status_curso') != '2P' && $this->session->userdata('status_curso') != 'CC' && $operacao != 'view') {
                echo "<input type=\"button\" id=\"salvar\" class=\"btn btn-success\" value=\"Salvar\"> <hr/>";
            }
            ?>
            <input type="button" id="reset" class="btn btn-default" value="Voltar">
        </div>

        <div class="form-group">
            <label>1. Nome Completo do Parceiro</label>
            <div>
                <input type="text" class="form-control tamanho-lg" id="parceiro_nome" name="parceiro_nome"
                       value="<?php if ($retrivial) echo $dados[0]->nome; ?>"> 
                <label class="control-label form" for="parceiro_nome"></label>
            </div>
        </div>

        <div class="form-group">
            <label>2. Sigla</label>
            <div>
                <input type="text" class="form-control tamanho-sm" id="parceiro_sigla" name="parceiro_sigla"
                       value="<?php if ($retrivial) echo $dados[0]->sigla; ?>">
                <label class="control-label form" for="parceiro_sigla"></label>
            </div>
        </div>

        <div class="form-group">
            <label>3. Logradouro</label>
            <div class="form-group interno">
                <label> a. Rua, Avenida, etc. </label>
                <div>
                    <input type="text" class="form-control tamanho-lg" id="parceiro_rua" name="parceiro_rua"
                           value="<?php if ($retrivial) echo $dados[0]->rua; ?>">
                    <label class="control-label form" for="parceiro_rua"></label>
                </div>
            </div> 
            <div class="form-group interno">
                <label class="negacao"> b. N&uacute;mero </label>

                <div class="checkbox negacao-sm"> 
                    <label> <input type="checkbox" name="ckParceiro_numero" id="ckParceiro_numero" 
                                   <?php if ($retrivial && $dados[0]->numero == 0) echo 'checked'; ?> > S/N </label>		      
                </div>

                <div class="form-group">
                    <div>
                        <input type="text" class="form-control tamanho-smaller" id="parceiro_numero" name="parceiro_numero"
                               value="<?php if ($retrivial) echo $dados[0]->numero; ?>" maxLength="5">
                        <label class="control-label form" for="parceiro_numero"></label>
                    </div>
                </div>
            </div> 
            <div class="form-group interno">
                <label> c. Complemento </label>
                <div>
                    <input type="text" class="form-control" id="parceiro_complemento" name="parceiro_complemento"
                           value="<?php if ($retrivial) echo $dados[0]->complemento; ?>">
                    <label class="control-label form" for="parceiro_complemento"></label>
                </div>
            </div> 
            <div class="form-group interno">
                <label> d. Bairro </label>
                <div>
                    <input type="text" class="form-control" id="parceiro_bairro" name="parceiro_bairro"
                           value="<?php if ($retrivial) echo $dados[0]->bairro; ?>">
                    <label class="control-label form" for="parceiro_bairro"></label>
                </div>
            </div> 
            <div class="form-group interno">
                <label> e. CEP 	</label>
                <div>
                    <input type="text" class="form-control tamanho-small" id="parceiro_cep" name="parceiro_cep"
                           value="<?php if ($retrivial) echo $dados[0]->cep; ?>">
                    <label class="control-label form" for="parceiro_cep"></label>
                </div>
            </div> 
        </div> 

        <div class="form-group">
            <label>4. Munic&iacute;pio</label>
            <div class="form-group">
                <div class="negacao">
                    <select class="form-control select_estado negacao" id="parceiro_sel_est" name="parceiro_sel_est"></select>
                    <p class="text-danger select estado"><label for="parceiro_sel_est"></label></p>
                </div>
                <div class="negacao">
                    <select class="form-control select_municipio negacao" id="parceiro_sel_mun" name="parceiro_sel_mun"></select>
                    <p class="text-danger select municipio"><label for="parceiro_sel_mun"></label></p>
                </div>
            </div>
            <div class="form-group"></div> <!-- CORRIGIR ESPAÇAMENTO DO FLOAT LEFT ACIMA -->
        </div>   

        <div class="form-group">
            <label>5. Telefone(s)</label>
            <div class="form-group interno">
                <label> a. Telefone 1 </label>
                <div>
                    <input type="text" class="form-control tamanho-small" id="parceiro_tel1" maxlength="13" name="parceiro_tel1" value="<?php if ($retrivial) echo $dados[0]->telefone1; ?>">
                    <label class="control-label form" for="parceiro_tel1"></label>
                </div>
            </div> 
            <div class="form-group interno">
                <label class="negacao"> b. Telefone 2 </label>
                <div class="checkbox negacao-sm"> 
                    <label> <input type="checkbox" name="ckParceiro_tel2" id="ckParceiro_tel2" <?php if ($retrivial && $dados[0]->telefone2 == 'NAOAPLICA') echo "checked" ?>> Não se aplica </label>		      
                </div>
                <div class="form-group">
                    <div>
                        <input type="text" class="form-control tamanho-small" id="parceiro_tel2" name="parceiro_tel2" maxlength="13" value="<?php if ($retrivial && $dados[0] != 'NAOAPLICA') echo $dados[0]->telefone2; ?>">
                        <label class="control-label form" for="parceiro_tel2"></label>
                    </div>
                </div>
            </div> 
        </div>

        <div class="form-group">
            <label class="negacao">6. P&aacute;gina Web</label>

            <div class="checkbox negacao-sm"> 
                <label> <input type="checkbox" name="ckParceiro_site" id="ckParceiro_site" <?php if ($retrivial && $dados[0]->pagina_web == "NAOINFORMADO") echo "checked" ?>> Não informado </label>		      
            </div>

            <div class="form-group">
                <div>
                    <input type="text" class="form-control tamanho-lg url" id="parceiro_site" name="parceiro_site"
                           value="<?php if ($retrivial && $dados[0]->pagina_web != "NAOINFORMADO") echo $dados[0]->pagina_web; ?>">
                    <label class="control-label form" for="parceiro_site"></label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label> 7. Natureza do Parceiro </label>

            <div class="radio"> 
                <div class="radio"> <label> <input type="radio" name="rparceiro_natureza" id="rparceiro_natureza_01" value="MOVIMENTO SOCIAL/SINDICAL" <?php if ($retrivial && $dados[0]->natureza == "MOVIMENTO SOCIAL/SINDICAL") echo "checked" ?>> 
                        Movimento Social/Sindical </label> </div>

                <div class="radio"> <label> <input type="radio" name="rparceiro_natureza" id="rparceiro_natureza_02" value="SECRETARIA MUNICIPAL DE EDUCACAO" <?php if ($retrivial && $dados[0]->natureza == "SECRETARIA MUNICIPAL DE EDUCACAO") echo "checked" ?>> 
                        Secretaria Municipal de Educa&ccedil;&atilde;o </label> </div>

                <div class="radio"> <label> <input type="radio" name="rparceiro_natureza" id="rparceiro_natureza_03" value="SECRETARIA ESTADUAL DE EDUCACAO" <?php if ($retrivial && $dados[0]->natureza == "SECRETARIA ESTADUAL DE EDUCACAO") echo "checked" ?>> 
                        Secretaria Estadual de Educa&ccedil;&atilde;o </label> </div>

                <div class="radio"> <label> <input type="radio" name="rparceiro_natureza" id="rparceiro_natureza_04" value="INSTITUTOS FEDERAIS" <?php if ($retrivial && $dados[0]->natureza == "INSTITUTOS FEDERAIS") echo "checked" ?>> 
                        Institutos Federais </label> </div>

                <div class="radio"> <label> <input type="radio" name="rparceiro_natureza" id="rparceiro_natureza_05" value="ESCOLAS TECNICAS" <?php if ($retrivial && $dados[0]->natureza == "ESCOLAS TECNICAS") echo "checked" ?>>
                        Escolas T&eacute;cnicas </label> </div>

                <div class="radio"> <label> <input type="radio" name="rparceiro_natureza" id="rparceiro_natureza_06" value="REDES CEFFAS" <?php if ($retrivial && $dados[0]->natureza == "REDES CEFFAS") echo "checked" ?>> 
                        Redes CEFFAS </label> </div>

                <div class="radio"> <label> <input type="radio" name="rparceiro_natureza" id="rparceiro_natureza_07" value="FUNDACAO" <?php if ($retrivial && $dados[0]->natureza == "FUNDACAO") echo "checked" ?>> 
                        Funda&ccedil;&atilde;o </label> </div>

                <div class="radio"> <label> <input type="radio" name="rparceiro_natureza" id="rparceiro_natureza_08" value="OUTROS"  <?php if ($retrivial && $dados[0]->natureza == "OUTROS") echo "checked" ?>> 
                        Outros </label> </div>
                <div>
                    <input type="text" class="form-control" id="parceiro_natureza_outros" name="parceiro_natureza_outros" placeHolder="Especificar"
                    <?php
                    if ($retrivial && $dados[0]->natureza == 'OUTROS') {
                        echo "value=\"$dados[0]->natureza_descricao\"";
                    } else {
                        echo "style=\"display:none\";";
                    }
                    ?>

                           />
                    <p class="text-danger"><label for="rparceiro_natureza"></label></p>
                    <label class="control-label form bold" for="parceiro_natureza_outros"></label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>8. Abrang&ecirc;ncia</label>
            <div class="radio"> 
                <div class="radio"> <label> <input type="radio" name="rparceiro_abrangencia" id="rparceiro_abrangencia_01" value="MUNICIPAL" <?php if ($retrivial && $dados[0]->abrangencia == "MUNICIPAL") echo "checked" ?>> Municipal </label> </div>
                <div class="radio"> <label> <input type="radio" name="rparceiro_abrangencia" id="rparceiro_abrangencia_02" value="NACIONAL" <?php if ($retrivial && $dados[0]->abrangencia == "NACIONAL") echo "checked" ?>> Nacional </label> </div>
                <div class="radio"> <label> <input type="radio" name="rparceiro_abrangencia" id="rparceiro_abrangencia_03" value="REGIONAL" <?php if ($retrivial && $dados[0]->abrangencia == "REGIONAL") echo "checked" ?>> Regional </label> </div>
                <div class="radio"> <label> <input type="radio" name="rparceiro_abrangencia" id="rparceiro_abrangencia_04" value="ESTADUAL" <?php if ($retrivial && $dados[0]->abrangencia == "ESTADUAL") echo "checked" ?>> Estadual </label> </div>

                <p class="text-danger"><label for="rparceiro_abrangencia"></label></p>
            </div>
        </div>

        <div class="form-group">
            <label>9. Tipo de Parceria</label>

            <div class="checkbox"> 
                <div class="checkbox"><label> <input type="checkbox" name="ckparceiro_tipo" id="ckparceiro_tipo_01" value="REALIZACAO" <?php if ($retrivial && $dados[0]->realizacao == 1) echo "checked" ?>> 
                        Realiza&ccedil;&atilde;o do curso </label> </div>
                <div class="checkbox"><label> <input type="checkbox" name="ckparceiro_tipo" id="ckparceiro_tipo_02" value="CERTIFICACAO" <?php if ($retrivial && $dados[0]->certificacao == 1) echo "checked" ?>> 
                        Certifica&ccedil;&atilde;o </label> </div>
                <div class="checkbox"><label> <input type="checkbox" name="ckparceiro_tipo" id="ckparceiro_tipo_03" value="GESTAO" <?php if ($retrivial && $dados[0]->gestao == 1) echo "checked" ?>> 
                        Gest&atilde;o or&ccedil;ament&aacute;ria </label> </div>
                <div class="checkbox"><label> <input type="checkbox" name="ckparceiro_tipo" id="ckparceiro_tipo_04" value="DEMANDANTE" <?php if ($retrivial && $dados[0]->demandante == 1) echo "checked" ?>> 
                        Demandante </label> </div>
                <div class="checkbox"><label> <input type="checkbox" name="ckparceiro_tipo" id="ckparceiro_tipo_05" value="COLEGIADO" <?php if ($retrivial && $dados[0]->colegiado == 1) echo "checked" ?>> 
                        Participação no Colegiado  </label> </div>
                <div class="checkbox"><label> <input type="checkbox" name="ckparceiro_tipo" id="ckparceiro_tipo_outro" value="OUTROS" <?php if ($retrivial && $dados[0]->outros == 1) echo "checked" ?>> 
                        Outros </label></div>
                <div>
                    <input type="text" class="form-control" id="parceiro_tipo_outros" name="parceiro_tipo_outros" placeHolder="Especificar"
                    <?php
                    if ($retrivial && $dados[0]->outros == 1) {
                        echo "value=\"" . $dados[0]->parc_complemento . "\"";
                    } else {
                        echo "style=\"display:none\";";
                    }
                    ?>
                           >
                    <p class="text-danger"><label for="ckparceiro_tipo"></label></p>
                    <label class="control-label form bold" for="parceiro_tipo_outros"></label>
                </div>
            </div>
        </div>
    </fieldset>

    <?php echo form_close(); ?>