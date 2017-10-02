<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>

<script type="text/javascript">
    $(document).ready(function () {

        // Botão de login
        $('#login').click(function () {

            // Dados para verificação do formulário
            var form = Array(
                    {
                        'id': 'cpf',
                        'message': 'Informe o CPF',
                        'extra': {
                            'operation': 'cpf',
                            'message': 'Número de CPF inválido'
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
                    cpf: $('#cpf').val(),
                    senha: $('#senha').val()
                };

                urlResquest = "<?php echo site_url('ctrl_login/sign_in'); ?>";

                request(urlResquest, formData, 'hide');
            }
        });

        $('#esqueci-senha').click(function () {

            $.ajax({

                url: "<?php echo site_url('ctrl_conta/index_password_retrieval'); ?>",

                success: function (data) {

                    $('#content').html(data);
                }

            });

        });

        $("#acesso-publico").click(function () {

            $.ajax({
                url: "<?php echo site_url('ctrl_conta/index_acesso_publico'); ?>",
                success: function (data) {
                    $('#content').fadeOut(400,function(){
                        $(this).html(data).fadeIn(400);
                    });
                }
            });
        });
        
        $("#cpf").keypress(function(e){preventChar(e);});

    });
</script>

<div class="box-control">
    <h2><strong>Acesso ao Sistema</strong></h2>

    <form class="form-horizontal">
        <div class="form-group">
            <div class="col-lg-12">
                <label>CPF</label>
                <input type="text" class="form-control center" id="cpf" name="cpf" maxlength="11" autofocus>
                <label class="control-label center" for="cpf"></label>
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-12">
                <label>SENHA</label>
                <input type="password" class="form-control center" id="senha" name="senha"/>
                <label class="control-label center" for="senha"></label>
                <label class="center" id="label-esqueci-senha"><a href="#" id="esqueci-senha">Esqueci minha senha</a></label>
                <label class="center" id="label-acesso-publico"><a href="#" id="acesso-publico">Ou ir para o Acesso Público</a></label>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12">
                <button type="button" class="btn btn-success center" id="login">ENTRAR</button>
            </div>
        </div>
    </form>
</div>
<div class="logo">
    <img src="<?php echo base_url(); ?>css/img/logo2.png">
</div>
<?php
/* $client = new SoapClient("http://172.20.0.108/servicosipra/Projeto/SProjeto.svc?wsdl");
  //print_r($client->__getFunctions());
  //print_r($client->ConsultarListaProjetos());
  $assentamentos = $client->ConsultarListaProjetos();
  $assentamentos = $assentamentos->ConsultarListaProjetosResult->ProjetoAssentamento;

  foreach($assentamentos as $singular)
  {
  echo $singular->Nome.", ".$singular->UF."<br>";
  } */
?>
