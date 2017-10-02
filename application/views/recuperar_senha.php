<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>

<script type="text/javascript">
    $(document).ready(function () {

        $('#enviar').click(function () {

            // Dados para verificação do formulário
            var form = Array(
                    {
                        'id': 'cpf',
                        'type': 'text',
                        'message': 'Informe o CPF',
                        'extra': {
                            'operation': 'cpf',
                            'message': 'Número de CPF inválido'
                        }
                    }
            );

            // Verifica se os campos do formulário foram preenchidos e são válidos
            if (isFormComplete(form)) {

                var formData = {
                    cpf: $('#cpf').val()
                };

                var urlRequest = "<?php echo site_url('ctrl_conta/password_retrieval'); ?>";

                request(urlRequest, formData);
            }
        });
        $("#cpf").keypress(function (e) {
            preventChar(e);
        });
    });
</script>

<div class="box-control">
    <h2><strong>Recuperar senha</strong></h2>

    <form class="form-horizontal">

        <div class="form-group">
            <div class="col-lg-12">
                <p>Um link ser&aacute; enviado ao seu email para redefini&ccedil;&atilde;o de senha</p>
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-12">
                <input class="form-control center" id="cpf" name="cpf" placeholder="CPF" maxlength="11" autofocus>
                <label class="control-label center" for="cpf"></label>
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-12">
                <button type="button" class="btn btn-success btn-inline center" id="enviar">ENVIAR</button>
                <a href="<?php echo index_page(); ?>" type="button" class="btn btn-default btn-inline center">VOLTAR</a>
            </div>
        </div>

    </form>
</div>
<div class="logo">
    <img src="<?php echo base_url(); ?>css/img/logo2.png">
</div>