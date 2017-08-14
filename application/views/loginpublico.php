<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<style>
    .modal{
        z-index: 10001;
    }

    .modal-backdrop.fade.in{
        z-index: 10000;
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {
        
        // Botão de login
        $('#login-btn').click(function () {

            // Dados para verificação do formulário
            var form = Array(
                    {
                        'id': 'email',
                        'message': 'Informe o Email',
                        'extra': {
                            'operation': 'email',
                            'message': 'Email é inválido'
                        }
                    },
                    {
                        'id': 'senha',
                        'message': 'Informe a senha',
                        'extra': null
                    }
            );

            // Verifica se os campos do formulário foram preenchidos e são válidos
            if (isFormComplete(form)) {

                var formData = {
                    email: $('#email').val(),
                    senha: $('#senha').val()
                };

                urlResquest = "<?php echo site_url('acesso_publico/sign_in'); ?>";

                request(urlResquest, formData,'hide');
            }
        });

        function validateData() {
            var form = Array(
                    {
                        'id': 'name-up',
                        'message': 'Informe o nome',
                        'extra': null
                    },
                    {
                        'id': 'email-up',
                        'message': 'Informe o e-mail',
                        'extra': {
                            'operation': 'email',
                            'message': 'E-mail digitado é inválido'
                        }
                    },
                    {
                        'id': 'senha-up',
                        'message': 'Informe uma senha válida',
                        'extra': {
                            'operation': 'password',
                            'message': 'Senha é inválida'
                        }
                    }
            );

            return isFormComplete(form);

        }

        $("#signup-btn").click(function () {

            if (validateData()) {
                if (!$("#municipio-up").val()) {
                    alert("Selecione seu municipio");
                    return;
                }
                $("#signupModal").modal('show');
                $("#senha_up_repeat").focus();
                $("#email-up-label").text($("#email-up").val().toUpperCase());
                $("#name-up-label").text($("#name-up").val().toUpperCase());
                $("#municipio-up-label").text(
                        $("#municipio-up option[value='" + $("#municipio-up").val() + "']").text() + " (" +
                        $("#uf-up option[value='" + $("#uf-up").val() + "']").text() + ")"
                        );
            }

        });

        $("#signup-confirm-btn").click(function () {
            if (validateData()) {
                if ($("#municipio-up").val()) {
                    var form = Array({
                        'id': 'senha-up-repeat',
                        'message': 'Repita a senha inserida anteriormente',
                        'extra': {
                            'value': $("#senha-up").val(),
                            'operation': 'match',
                            'message': 'As senha não correspondem'
                        }
                    });
                    if (isFormComplete(form)) {

                        var formData = {
                            nome: $("#name-up").val().toUpperCase(),
                            email: $("#email-up").val().toUpperCase(),
                            senha: $("#senha-up").val(),
                            municipio: $("#municipio-up").val()
                        };

                        var urlResquest = "<?= site_url('acesso_publico/signup/') ?>";

                        request(urlResquest, formData);
                    }
                } else {
                    alert("Selecione seu municipio");
                }
            }
            $("#signupModal").modal('hide');
        });

        $.get("<?php echo site_url('requisicao/get_estados'); ?>", function (estados) {
            $('#uf-up').html(estados).change(function () {
                $.get("<?php echo site_url('requisicao/get_municipios/') . '/'; ?>" + this.value, function (cidades) {
                    $('#municipio-up').html(cidades).select2();
                });
            });
            $("#uf-up").find("option[value='0']").remove();
            $("#uf-up").val(1).change().select2();
        });

    });
</script>
<h2><strong>Acesso Público</strong></h2>
<hr/>

<div class="row">
    <div class="col-md-7">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#login">Entrar</a></li>
            <li><a data-toggle="tab" href="#signup">Cadastrar-se</a></li>
        </ul>

        <div class="tab-content">
            <div id="login" class="tab-pane fade in active">
                <div class="col-md-2"></div>
                <form class="col-md-8" style="margin-left: auto;margin-right: auto;padding-top: 20px">
                    <div class="form-group" style="margin:10px;margin-top: 0px;">
                        <div class="col-lg-12">
                            <label>E-mail</label>
                            <div class="input-group">
                                <span class="input-group-addon" id="sizing-addon1"><i class="fa fa-at"></i></span>
                                <input type="email" class="form-control center" id="email" name="email" onkeypress="return preventChar();" autofocus>
                            </div>
                            <label class="control-label center" for="email"></label>
                        </div>
                    </div>

                    <div class="form-group" style="margin:10px;">
                        <div class="col-lg-12">
                            <label>Senha</label>

                            <div class="input-group">
                                <span class="input-group-addon" id="sizing-addon1"><i class="fa fa-lock"></i></span>
                                <input type="password" class="form-control center" id="senha" name="senha"/>
                            </div>
                            <label class="control-label center" for="senha"></label>
                        </div>
                    </div>

                    <div class="form-group" style="margin:10px;">
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-success center" id="login-btn">ENTRAR</button>
                        </div>
                    </div>
                </form>
            </div>
            <div id="signup" class="tab-pane fade" style="height: 400px !important">
                <div class="col-md-1"></div>
                <form class="col-md-10">
                    <div class="form-group" style="margin:10px;margin-top: 0px;padding-top: 20px">
                        <label>E-mail</label>
                        <div class="input-group">
                            <span class="input-group-addon" id="sizing-addon1"><i class="fa fa-at"></i></span>
                            <input type="email" class="form-control center" id="email-up" name="email" onkeypress="return preventChar();" autofocus>
                        </div>
                        <label class="control-label center" for="email-up"></label>
                    </div>

                    <div class="form-group" style="margin:10px;">
                        <label>Senha</label>
                        <small>No mínimo 5 caracteres</small>
                        <div class="input-group">
                            <span class="input-group-addon" id="sizing-addon1"><i class="fa fa-lock"></i></span>
                            <input type="password" class="form-control center" id="senha-up" name="senha"/>
                        </div>
                        <label class="control-label center" for="senha-up"></label>
                    </div>
                    <hr>
                    <div class="form-group" style="margin:10px;">
                        <label>Nome</label>
                        <div class="input-group">
                            <span class="input-group-addon" id="sizing-addon1"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control center" id="name-up" name="name" onkeypress="return preventChar();" autofocus>
                        </div>
                        <label class="control-label center" for="name-up"></label>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group" style="margin:10px;">
                            <label>UF</label>
                            <select id="uf-up" class="form-control" style="width: 80px;margin: 0px;">
                            </select>
                            <label class="control-label center" for="uf-up"></label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group" style="margin:10px;">
                            <label>Múnicipio</label>
                            <select id="municipio-up" class="form-control" style="width: 100%;margin: 0px;">
                            </select>
                            <label class="control-label center" for="municipio-up"></label>
                        </div>
                    </div>


                    <div class="form-group" style="margin:10px;">
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-success center" id="signup-btn">Cadastrar</button>
                        </div>
                    </div>
                    <div class="row"></div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="logo">
            <img src="<?php echo base_url(); ?>css/img/logo2.png">
        </div>
    </div>
</div>
<div id="signupModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Confirmar cadastro?</h4>
            </div>
            <div class="row" style="width:400px;margin-right: auto;margin-left: auto;">
                <div class="form-group" style="margin:10px;">
                    <label>Confirme o dados:</label>
                    <br/>
                    <br/>
                    <div class="row">
                        <b class="col-md-3">Email :</b>
                        <span class="col-md-9" style="text-align: right" id="email-up-label"></span>
                    </div>
                    <hr/>
                    <div class="row">                       
                        <b class="col-md-4">Nome :</b>
                        <span class="col-md-8" style="text-align: right" id="name-up-label"></span>
                    </div>
                    <hr/>
                    <div class="row">       
                        <b class="col-md-5">Município :</b>
                        <span class="col-md-7" style="text-align: right" id="municipio-up-label"></span>
                    </div>
                    <hr/>
                </div>
            </div>
            <form id="formlogup" role="form" style="width: 300px;margin-right: auto;margin-left: auto;">

                <div class="form-group" style="margin:10px;">
                    <div class="col-lg-12">
                        <label>Repita a senha!</label>
                        <div class="input-group">
                            <span class="input-group-addon" id="sizing-addon1"><i class="fa fa-lock"></i></span>
                            <input autocomplete="off" type="password" class="form-control center" id="senha-up-repeat" name="senha"/>
                        </div>
                        <label class="control-label center" for="senha-up-repeat"></label>
                    </div>
                </div>
                <button class="btn btn-lg btn-primary btn-block" id="signup-confirm-btn" type="button">Confirmar</button>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
            </div>
        </div>
    </div>
</div>