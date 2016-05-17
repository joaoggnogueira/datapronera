<?php 
    if (! defined('BASEPATH')) exit('No direct script access allowed');
?>

<script type="text/javascript">
	$(document).ready(function () {

		$('#redefinir').click(function () {

			// Dados para verificação do formulário
			var form = Array(
				{
					'id' 	  : 'senha_atual',
					'message' : 'Informe a senha atual',
					'extra'	  : null
				},

				{
					'id'	  : 'nova_senha',
					'message' : 'Informe a nova senha',
					'extra'	  : null
				},

				{
					'id'	  : 'confirmar_senha',
					'message' : 'Confirme a nova senha',
					'extra'	  : {
						'operation' : 'match',
						'message'   : 'Senhas não coincidem',
						'value'     : $('#nova_senha').val()
					}
 				}
			);

			// Verifica se os campos do formulário foram preenchidos e são válidos
			if (isFormComplete(form)) {

				var formData = {
					cpf : $('#cpf').val(),
					senha_atual : $('#senha_atual').val(),
					nova_senha : $('#confirmar_senha').val()
				};

				var urlRequest = "<?php echo site_url('ctrl_conta/password_reset'); ?>";

				request(urlRequest, formData);
			}
		});
	});
</script>

<div class="box-control">
	<h2><strong>Redefini&ccedil;&atilde;o de senha</strong></h2>
	<form class="form-horizontal">

		<div class="form-group">
	    	<div class="col-lg-12">
	      		<input type="password" class="form-control center" id="senha_atual" placeholder="Senha atual">
	      		<label class="control-label" for="senha_atual"></label>
	    	</div>
	  	</div>

	  	<div class="form-group">
	    	<div class="col-lg-12">
	      		<input type="password" class="form-control center" id="nova_senha" placeholder="Nova senha">
	      		<label class="control-label center" for="nova_senha"></label>
	    	</div>
	  	</div>

	  	<div class="form-group">
	    	<div class="col-lg-12">
	      		<input type="password" class="form-control center" id="confirmar_senha" placeholder="Confirme a nova senha">
	      		<label class="control-label center" for="confirmar_senha"></label>
	    	</div>
	  	</div>

	  	<div class="form-group">
	    	<div class="col-lg-12">
	      		<button type="button" class="btn btn-success btn-inline center" id="redefinir">REDEFINIR</button>
	      		<a href="<?php echo base_url(); ?>" type="button" class="btn btn-default btn-inline center">VOLTAR</a>
	    	</div>
	  	</div>

	  	<input type="hidden" id="cpf" name="cpf" value="<?php echo $cpf; ?>" />

	</form>
</div>
<div class="logo">
	<img src="<?php echo base_url(); ?>css/img/logo2.png">
</div>