<?php
$this->session->set_userdata('curr_content', 'cadastro_pessoa');
?>

<script type="text/javascript">

    $(document).ready(function () {
        var id = "<?php echo $pessoa['id']; ?>";

        $.get("<?php echo site_url('requisicao/get_estados'); ?>", function (estados) {
            $('#estado').html(estados);

            var estado = "<?php if ($operacao != 'add') echo $dados[0]->id_estado; ?>";
            $('#estado option[value="' + estado + '"]').attr("selected", true);

            $.get("<?php echo site_url('requisicao/get_municipios/') . '/'; ?>" + estado, function (cidades) {
                $('#municipio').html(cidades);

                var cidade = "<?php if ($operacao != 'add') echo $dados[0]->id_cidade; ?>";
                $('#municipio option[value="' + cidade + '"]').attr("selected", true);
            });
        });

        $.get("<?php echo site_url('requisicao/get_superintendencias'); ?>", function (superintendencias) {
            $('#superintendencia').html(superintendencias);

            var superintendencia = "<?php if ($operacao != 'add') echo $dados[0]->id_superintendencia; ?>";
            $('#superintendencia option[value="' + superintendencia + '"]').attr("selected", true);
            $("#superintendencia").change();
        });

        $.get("<?php echo site_url('requisicao/get_funcoes'); ?>", function (funcoes) {
            $('#funcao').html(funcoes);
            var funcao = "<?php if ($operacao != 'add') echo $dados[0]->id_funcao; ?>";
            $('#funcao option[value="' + funcao + '"]').attr("selected", true);
            $("#funcao").change();
        });
    
        var urlMunicipios = "<?php echo site_url('requisicao/get_municipios'); ?>";

        $('#estado').listCities(urlMunicipios, 'municipio');

        /* Lista de Municípios
         $("#estado").change(function () {
         var state_id = $("#estado").val();
         
         $("#municipio").html("<option>Aguarde...</option>");
         
         $.get( url + 'requisicao/get_municipios/'+state_id, function(cidades) {
         $('#municipio').html(cidades);
         });
         }).change();*/

        /* Máscara para inputs */
        //$('#cpf').mask("999.999.999-99");
        $('#data_nascimento').mask("99/99/9999");
        $('#telefone1').mask("(99)9999-9999");
        $('#telefone2').mask("(99)9999-9999");
        $('#cep').mask("99.999-999");

        /* Não informados */
        $('#ckNumero').niCheck({'id': ['numero']});
        $('#ckPessoa_tel2').niCheck({'id': ['telefone2']});

        $('#salvar').click(function () {

            var form = Array(
                    {
                        'id': 'nome',
                        'message': 'Informe o nome',
                        'extra': null
                    },
                    {
                        'name': 'sexo',
                        'message': 'Informe o sexo',
                        'extra': null
                    },
                    {
                        'id': 'cpf',
                        'message': 'Informe o CPF',
                        'extra': {
                            'operation': 'cpf',
                            'message': 'CPF digitado é inválido'
                        }
                    },
                    {
                        'id': 'rg',
                        'message': 'Informe o RG',
                        'extra': null
                    },
                    {
                        'id': 'rg_emissor',
                        'message': 'Informe o órgão emissor do RG',
                        'extra': null
                    },
                    {
                        'id': 'data_nascimento',
                        'message': 'Informe a data de nascimento',
                        'extra': {
                            'operation': 'date',
                            'message': 'Data digitada é inválida'
                        }
                    },
                    {
                        'id': 'telefone1',
                        'message': 'Informe o número de telefone',
                        'extra': null
                    },
                    {
                        'id': 'telefone2',
                        'ni': $('#ckPessoa_tel2').prop("checked"),
                        'message': 'Informe o número de telefone',
                        'extra': null
                    },
                    {
                        'id': 'email',
                        'message': 'Informe o e-mail',
                        'extra': {
                            'operation': 'email',
                            'message': 'E-mail digitado é inválido'
                        }
                    },
                    {
                        'id': 'rua',
                        'message': 'Informe o nome da rua/avenida do logradouro',
                        'extra': null
                    },
                    {
                        'id': 'numero',
                        'ni': $('#ckNumero').prop("checked"),
                        'message': 'Informe, caso possua, o número referente ao logradouro, <br />' +
                                'caso contrário selecione a opção "S/N"',
                        'extra': null
                    },
                    {
                        'id': 'bairro',
                        'message': 'Informe o nome do bairro do logradouro ',
                        'extra': null
                    },
                    {
                        'id': 'cep',
                        'message': 'Informe o CEP referente ao logradouro',
                        'extra': null
                    },
                    {
                        'id': 'estado',
                        'message': 'Selecione o estado',
                        'extra': null
                    },
                    {
                        'id': 'municipio',
                        'message': 'Selecione o município',
                        'extra': null
                    },
                    {
                        'id': 'funcao',
                        'message': 'Informe a ocupação',
                        'extra': null
                    },
                    {
                        'id': 'superintendencia',
                        'message': 'Informe a superintendência',
                        'extra': null
                    }
            );

            if (isFormComplete(form)) {

                var formData = {
                    id: id,
                    nome: $('#nome').val().toUpperCase(),
                    sexo: $("input:radio[name=sexo]:checked").val(),
                    cpf: $('#cpf').val(),
                    rg: $('#rg').val(),
                    rg_emissor: $('#rg_emissor').val().toUpperCase(),
                    data_nascimento: $('#data_nascimento').val(),
                    telefone1: $('#telefone1').val(),
                    ckTelefone2: $('#ckPessoa_tel2').prop("checked"),
                    telefone2: $('#telefone2').val(),
                    email: $('#email').val().toLowerCase(),
                    rua: $('#rua').val().toUpperCase(),
                    numero: $('#numero').val(),
                    complemento: $('#complemento').val().toUpperCase(),
                    bairro: $('#bairro').val().toUpperCase(),
                    cep: $('#cep').val(),
                    //estado : $('#estado').val(),
                    municipio: $('#municipio').val(),
                    funcao: $('#funcao').val(),
                    superintendencia: $('#superintendencia').val()
                };

                var urlRequest = "<?php if ($operacao == 'add')
                    echo site_url('pessoa/add/');
                else if ($operacao == 'update')
                    echo site_url('pessoa/update');
                ?>";

                request(urlRequest, formData);
            }
        });

        $('#reset').click(function () {

            var urlRequest = "<?php echo site_url('pessoa/index/'); ?>";

            request(urlRequest, null, 'hide');
        });

        $("#cpf").keypress(function (e) {
            preventChar(e);
        });
        $("#numero").keypress(function (e) {
            preventChar(e);
        });
<?PHP if ($operacao == 'view'): ?>
            function preventAll(e) {
                e.preventDefault();
            }
            $("input").on('keydown', preventAll).on('keyup', preventAll);
            $("textarea").on('keydown', preventAll).on('keyup', preventAll);
            $("select").each(function (key, object) {
                const select = $(object);
                var atual_value = select.val();
                select.change(function (event) {
                    console.log(event);
                    if (atual_value !== null) {
                        $(event.target).val(atual_value);
                    } else {
                        atual_value = $(event.target).val();
                    }
                });
            });
            $("#equipe_superintendencia_controls").hide();
            $("input").click(preventAll);
<?PHP endif; ?>
    });
</script>

<form>
    <fieldset>
        <legend> Cadastro de Usu&aacute;rio </legend>

        <div class="form-group controles">
            <?php
            if ($operacao != 'view') {
                echo "<input type=\"button\" id=\"salvar\" class=\"btn btn-success\" value=\"Salvar\"> <hr/>";
            } else {
                echo "<h4>Visualizando<h4/>";
            }
            ?>
            <input type="button" id="reset" class="btn btn-default" value="Voltar">
        </div>

        <div class="form-group">
            <label>1. Nome </label>
            <div>
                <input type="text" class="form-control tamanho-lg" id="nome" name="nome"
                       value="<?php if ($operacao != 'add') echo $dados[0]->nome; ?>">
                <label class="control-label form bold" for="nome"></label>
            </div>
        </div>

        <div class="form-group">
            <label>2. G&ecirc;nero</label>
            <div class="radio">
                <div class="radio"> <label> <input type="radio" name="sexo" id="sexo_01" value="M" <?php if ($operacao != 'add' && $dados[0]->genero == 'M') echo "checked"; ?> > Masculino </label> </div>
                <div class="radio"> <label> <input type="radio" name="sexo" id="sexo_02" value="F" <?php if ($operacao != 'add' && $dados[0]->genero == 'F') echo "checked"; ?> > Feminino</label> </div>
                <p class="text-danger"><label for="sexo"><label></p>
                            </div>
                            </div>

                            <div class="form-group">
                                <label>3. CPF (somente n&uacute;meros)</label>
                                <div>
                                    <input type="text" class="form-control tamanho-small" id="cpf" name="cpf" onkeypress="return preventChar('A')" maxlength="11"
                                           value="<?php if ($operacao != 'add') echo $dados[0]->cpf; ?>">
                                    <label class="control-label form bold" for="cpf"></label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>4. RG</label>
                                <div>
                                    <input type="text" class="form-control tamanho-small" id="rg" name="rg" maxlength="25"
                                           value="<?php if ($operacao != 'add') echo $dados[0]->rg; ?>">
                                    <label class="control-label form bold" for="rg"></label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>5. Emissor do RG</label>
                                <div>
                                    <input type="text" class="form-control tamanho-small" id="rg_emissor" name="rg_emissor" maxlength="25"
                                           value="<?php if ($operacao != 'add') echo $dados[0]->rg_emissor; ?>">
                                    <label class="control-label form bold" for="rg_emissor"></label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>6. Data de Nascimento</label>
                                <div>
                                    <input type="text" class="form-control tamanho-small" id="data_nascimento" name="data_nascimento"
                                           value="<?php if ($operacao != 'add') echo $dados[0]->data_nascimento; ?>">
                                    <label class="control-label form bold" for="data_nascimento"></label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>7. Telefone(s)</label>
                                <div class="form-group interno">
                                    <label> a. Telefone 1 </label>
                                    <div>
                                        <input type="text" class="form-control tamanho-small" id="telefone1" name="telefone1"
                                               value="<?php if ($operacao != 'add') echo $dados[0]->telefone_1; ?>">
                                        <label class="control-label form bold" for="telefone1"></label>
                                    </div>
                                </div>
                                <div class="form-group interno">
                                    <label class="negacao"> b. Telefone 2 </label>

                                    <div class="checkbox negacao-sm">
                                        <label> <input type="checkbox" name="ckPessoa_tel2" id="ckPessoa_tel2"
<?php if ($operacao != 'add' && $dados[0]->telefone_2 == 'NAOINFORMADO') echo 'checked'; ?> > N&atilde;o informado </label>
                                    </div>

                                    <div class="form-group">
                                        <div>
                                            <input type="text" class="form-control tamanho-small" id="telefone2" name="telefone2"
                                                   value="<?php if ($operacao != 'add') echo $dados[0]->telefone_2; ?>">
                                            <label class="control-label form bold" for="telefone2"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label> 8. E-mail </label>
                                <div>
                                    <input type="email" class="form-control tamanho-lg" id="email" name="email"
                                           value="<?php if ($operacao != 'add') echo $dados[0]->email; ?>">
                                    <label class="control-label form bold" for="email"></label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>9. Logradouro</label>
                                <div class="form-group interno">
                                    <label> a. Rua, Avenida, etc. </label>
                                    <div>
                                        <input type="text" class="form-control tamanho-lg" id="rua" name="rua"
                                               value="<?php if ($operacao != 'add') echo $dados[0]->logradouro; ?>">
                                        <label class="control-label form bold" for="rua"></label>
                                    </div>
                                </div>
                                <div class="form-group interno">
                                    <label class="negacao"> b. N&uacute;mero </label>

                                    <div class="checkbox negacao-sm">
                                        <label> <input type="checkbox" name="ckNumero" id="ckNumero"
<?php if ($operacao != 'add' && $dados[0]->numero == 0) echo 'checked'; ?> > S/N </label>
                                    </div>

                                    <div class="form-group">
                                        <div>
                                            <input type="text" class="form-control tamanho-smaller" id="numero" name="numero" maxlength="6"
                                                   value="<?php if ($operacao != 'add') echo $dados[0]->numero; ?>">
                                            <label class="control-label form bold" for="numero"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group interno">
                                    <label> c. Complemento </label>
                                    <input type="text" class="form-control tamanho-lg" id="complemento" name="complemento"
                                           value="<?php if ($operacao != 'add') echo $dados[0]->complemento; ?>">
                                </div>
                                <div class="form-group interno">
                                    <label> d. Bairro </label>
                                    <div>
                                        <input type="text" class="form-control" id="bairro" name="bairro"
                                               value="<?php if ($operacao != 'add') echo $dados[0]->bairro; ?>">
                                        <label class="control-label form bold" for="bairro"></label>
                                    </div>
                                </div>
                                <div class="form-group interno">
                                    <label> e. CEP 	</label>
                                    <div>
                                        <input type="text" class="form-control tamanho-small" id="cep" name="cep"
                                               value="<?php if ($operacao != 'add') echo $dados[0]->cep; ?>">
                                        <label class="control-label form bold" for="cep"></label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>10. Estado / Munic&iacute;pio </label>
                                <div class="form-group">
                                    <div class="negacao">
                                        <select class="form-control select_estado" id="estado" name="estado"></select>
                                        <p class="text-danger select estado2"><label for="estado"><label></p>
                                                    </div>
                                                    <div class="negacao">
                                                        <select class="form-control select_municipio negacao" id="municipio" name="municipio"></select>
                                                        <p class="text-danger select municipio"><label for="municipio"><label></p>
                                                                    </div>
                                                                    </div>
                                                                    <div class="form-group"></div> <!-- CORRIGIR ESPAÇAMENTO DO FLOAT LEFT ACIMA -->
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label> 11. Nível de Acesso </label>
                                                                        <div>
                                                                            <select class="form-control select_municipio" id="funcao" name="funcao"></select>
                                                                            <p class="text-danger select"><label for="funcao"><label></p>
                                                                                        </div>
                                                                                        </div>

                                                                                        <div class="form-group">
                                                                                            <label>12. Superintendência</label>
                                                                                            <div>
                                                                                                <select class="form-control select_municipio" id="superintendencia" name="superintendencia"></select>
                                                                                                <p class="text-danger select"><label for="superintendencia"><label></p>
                                                                                                            </div>
                                                                                                            </div>

                                                                                                            </fieldset>
                                                                                                            </form>