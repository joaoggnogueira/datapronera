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
    #header{
        border-bottom: none;
        max-height: 0px;
        overflow: hidden;
    }
    #middle{
        margin-top: 83px;
        border-top: 10px solid #5cb85c;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }
    #status{
        top: 0px;
    }
    input:-webkit-autofill,
    input:-webkit-autofill:hover, 
    input:-webkit-autofill:focus
    textarea:-webkit-autofill,
    textarea:-webkit-autofill:hover
    textarea:-webkit-autofill:focus,
    select:-webkit-autofill,
    select:-webkit-autofill:hover,
    select:-webkit-autofill:focus {
        -webkit-text-fill-color: black;
        -webkit-box-shadow: 0 0 0px 1000px #EEF inset;
        transition: background-color 5000s ease-in-out 0s;
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

                request(urlResquest, formData, 'hide');
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
                            municipio: $("#municipio-up").val(),
                            captcha: $("#g-recaptcha-response").val()
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
        $("#back-btn").appendTo($(".overflow-menu"));
    });
</script>
<a style="margin-top: 25px !important;position: absolute;font-size: 15px" href="<?php echo index_page(); ?>" type="button" class="btn center" id="back-btn"><i class="fa fa-chevron-left"></i> VOLTAR AO ACESSO RESTRITO</a>
<h2><strong>Acesso Público</strong></h2>
<hr/>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script src="https://apis.google.com/js/api:client.js"></script>

<div class="row">
    <?PHP
//    $key = "e228c23d3a6e078f20e43bb0a6e5bc32";
//    for ($i = 1; $i < 31; $i++) {
//        $plaintext = json_encode(array("mapa" => array("sr" => $i)));
//        $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
//        $iv = substr("token_datapronera", 0, $ivlen);
//        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
//        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);
//        $ciphertext = base64_encode($iv . $hmac . $ciphertext_raw);
//        $ciphertext = urlencode($ciphertext);
//        echo "<br/><br/>".$i." : ".$ciphertext;
//    }
//    $key = "e228c23d3a6e078f20e43bb0a6e5bc32";
//    if (isset($_GET['token'])) {
//        $token = $_GET['token'];
//        $c = base64_decode($token);
//        $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
//        $iv = substr($c, 0, $ivlen);
//        $hmac = substr($c, $ivlen, $sha2len = 32);
//        $ciphertext_raw = substr($c, $ivlen + $sha2len);
//        $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
//        $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);
//        if (hash_equals($hmac, $calcmac)) {
//            echo "<br/>" . $original_plaintext;
//        }
//    }
    ?>
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
                                <input type="email" class="form-control center" id="email" name="email" autofocus>
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
                            <input type="email" class="form-control center" id="email-up" name="email" autofocus>
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
                            <input type="text" class="form-control center" id="name-up" name="name" autofocus>
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
        <hr/>
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
                    <hr/>
                    <div class="col-lg-12">
                        <div style="margin-left: -25px;" class="g-recaptcha" data-sitekey="6LfMWCMTAAAAAKosa3Kly65fvko_BmibtrRraAvS"></div>
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