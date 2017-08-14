<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
} else if (!$this->system->is_logged_in()) {
    echo index_page();
} else {
    
}
?>
<style>
    .label-margin{
        margin-left: 20px;
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {

        $('#salvar').click(function () {
            var form = Array({
                'id': 'nome',
                'message': 'Informe o nome',
                'extra': null
            });
            if (isFormComplete(form)) {
                if (!$("#municipio").val()) {
                    alert("Selecione seu municipio");
                    return;
                }
                var formData = {
                    nome: $('#nome').val().toUpperCase(),
                    municipio: $('#municipio').val()
                };

                var urlRequest = "<?php echo site_url('acesso_publico/update'); ?>";

                request(urlRequest, formData);
            }

        });

        $('#atualizar_senha').click(function () {

            // Dados para verificação do formulário
            var form = Array(
                    {
                        'id': 'nova_senha',
                        'message': 'Informe a nova senha',
                        'extra': {
                            'operation': 'password',
                            'message': 'Senha é inválida'
                        }
                    },
                    {
                        'id': 'confirmar_senha',
                        'message': 'Confirme a nova senha',
                        'extra': {
                            'operation': 'match',
                            'message': 'Senhas não coincidem',
                            'value': $('#nova_senha').val()
                        }
                    },
                    {
                        'id': 'senha_atual',
                        'message': 'Informe a senha atual',
                        'extra': null
                    }
            );

            // Verifica se os campos do formulário foram preenchidos e são válidos
            if (isFormComplete(form)) {

                var formData = {
                    senha_atual: $('#senha_atual').val(),
                    nova_senha: $('#nova_senha').val()
                };

                var urlRequest = "<?php echo site_url('acesso_publico/password_reset'); ?>";

                request(urlRequest, formData);
            }
        });

        $('#atualizar_email').click(function () {

            // Dados para verificação do formulário
            var form = Array(
                    {
                        'id': 'novo_email',
                        'message': 'Informe o novo endereço de email',
                        'extra': {
                            'operation': 'email',
                            'message': 'Endereço de email inválido'
                        }
                    },
                    {
                        'id': 'confirmar_email',
                        'message': 'Confirme o novo endereço de email',
                        'extra': {
                            'operation': 'match',
                            'message': 'Endereços de email não coincidem',
                            'value': $('#novo_email').val()
                        }
                    },
                    {
                        'id': 'senha_atual_email',
                        'message': 'Informe a senha atual',
                        'extra': null
                    }
            );

            // Verifica se os campos do formulário foram preenchidos e são válidos
            if (isFormComplete(form)) {

                var formData = {
                    senha_atual_email: $('#senha_atual_email').val(),
                    novo_email: $('#novo_email').val()
                };

                var urlRequest = "<?php echo site_url('acesso_publico/email_reset'); ?>";

                request(urlRequest, formData);
            }
        });
        var estadooriginal = null;
        $.get("<?php echo site_url('requisicao/get_estados'); ?>", function (estados) {
            $('#uf').html(estados).change(function () {
                var value = this.value;
                $.get("<?= site_url('requisicao/get_municipios/') . '/'; ?>" + value, function (cidades) {
                    $('#municipio').html(cidades).select2();
                    if (estadooriginal === value) {
                        $("#municipio").val('<?= $this->session->userdata('id_cidade') ?>').select2();
                    }
                });
            });
            $("#uf").find("option[value='0']").remove();
            $.get("<?= site_url('requisicao/get_estado_do_municipio') ?>/<?= $this->session->userdata('id_cidade') ?>", function (id) {
                            estadooriginal = id;
                            $("#uf").val(id).change().select2();
                        });
                    });
                });
</script>
<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#tab1">Senha e Email</a></li>
    <li><a data-toggle="tab" href="#tab2">Informações Pessoais</a></li>
</ul>

<div class="tab-content">
    <div id="tab1" class="tab-pane fade in active" style="height: 500px">
        <div class="col-md-6">
            <div style="padding: 20px;padding-bottom: 0px">
                <h2><strong><i class="fa fa-lock"></i> Redefini&ccedil;&atilde;o de senha</strong></h2>
                <form class="form-horizontal spacer">
                    <div class="form-group">
                        <div class="col-lg-12">
                            <label class="label-margin">Nova senha</label>
                            <small>No mínimo 5 caracteres</small>
                            <input type="password" class="form-control center" id="nova_senha" >
                            <label class="control-label center" for="nova_senha"></label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-12">
                            <label class="label-margin">Redigite a nova senha</label>
                            <input type="password" class="form-control center" id="confirmar_senha">
                            <label class="control-label center" for="confirmar_senha"></label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-12">
                            <label class="label-margin">Senha atual</label>
                            <input type="password" class="form-control center" id="senha_atual">
                            <label class="control-label" for="senha_atual"></label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-lg-12">
                                <button type="button" class="btn btn-success center" id="atualizar_senha">ATUALIZAR SENHA</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-6" style="border-left: 1px solid #ccc;">
            <div style="padding: 20px;padding-bottom: 0px">
                <h2><strong><i class="fa fa-at"></i> Redefini&ccedil;&atilde;o de email</strong></h2>
                <form class="form-horizontal">

                    <div class="form-group">
                        <div class="col-lg-12">
                            <p class="center">Seu endere&ccedil;o de email atual &eacute;:</p>
                            <p class="email"><strong><?php echo $this->session->userdata('email'); ?></strong></p>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-12">
                            <label class="label-margin">Novo email</label>
                            <input type="email" class="form-control center" id="novo_email">
                            <label class="control-label center" for="novo_email"></label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-12">
                            <label class="label-margin">Redigite o novo email</label>
                            <input type="email" class="form-control center" id="confirmar_email">
                            <label class="control-label center" for="confirmar_email"></label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-12">
                            <label class="label-margin">Senha atual</label>
                            <input type="password" class="form-control center" id="senha_atual_email">
                            <label class="control-label" for="senha_atual_email"></label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-lg-12">
                                <button type="button" class="btn btn-success center" id="atualizar_email">ATUALIZAR EMAIL</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <div id="tab2" class="tab-pane fade">
        <div class="col-md-6">
            <div style="padding: 20px;padding-bottom: 0px">
                <form class="form-horizontal">
                    <div class="form-group">
                        <div class="col-lg-12">
                            <label class="label-margin">Nome</label>
                            <input type="text" name="nome" class="form-control center" value="<?= $this->session->userdata('name') ?>" id="nome" >
                            <label class="control-label center" for="nome"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group" style="margin:10px;">
                                <label>UF</label>
                                <select id="uf" class="form-control" style="width: 80px;margin: 0px;">
                                </select>
                                <label class="control-label center" for="uf"></label>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group" style="margin:10px;">
                                <label>Múnicipio</label>
                                <select id="municipio" class="form-control" style="width: 100%;margin: 0px;">
                                </select>
                                <label class="control-label center" for="municipio"></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <button type="button" class="btn btn-success center" id="salvar">SALVAR</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>