<?php 

	if (! defined('BASEPATH')) {
        exit('No direct script access allowed');

    } else if (! $this->system->is_logged_in()) {
        echo index_page();

    } else {
    	$encrypted_cpf = $this->encrypt->encode($this->session->userdata('cpf'));
		$encrypted_cpf = str_replace(array('+','/','='),array('-','_',''),$encrypted_cpf);
    }

?>

<script type="text/javascript">
	$(document).ready(function () {

		$('#atualizar_senha').click(function () {

			// Dados para verificação do formulário
			var form = Array(
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
 				},

 				{
					'id' 	  : 'senha_atual',
					'message' : 'Informe a senha atual',
					'extra'	  : null
				}
			);

			// Verifica se os campos do formulário foram preenchidos e são válidos
			if (isFormComplete(form)) {

				var formData = {
					cpf : $('#cpf').val(),
					senha_atual : $('#senha_atual').val(),
					nova_senha : $('#nova_senha').val()
				};

				var urlRequest = "<?php echo site_url('ctrl_conta/password_reset'); ?>";

				request(urlRequest, formData);
			}
		});

		$('#atualizar_email').click(function () {

			// Dados para verificação do formulário
			var form = Array(
				{
					'id'	  : 'novo_email',
					'message' : 'Informe o novo endereço de email',
					'extra'	  : {
						'operation' : 'email',
						'message'   : 'Endereço de email inválido'
					}
				},

				{
					'id'	  : 'confirmar_email',
					'message' : 'Confirme o novo endereço de email',
					'extra'	  : {
						'operation' : 'match',
						'message'   : 'Endereços de email não coincidem',
						'value'     : $('#novo_email').val()
					}
 				},

 				{
					'id' 	  : 'senha_atual_email',
					'message' : 'Informe a senha atual',
					'extra'	  : null
				}
			);

			// Verifica se os campos do formulário foram preenchidos e são válidos
			if (isFormComplete(form)) {

				var formData = {
					cpf : $('#cpf').val(),
					senha_atual_email : $('#senha_atual_email').val(),
					novo_email : $('#novo_email').val()
				};

				var urlRequest = "<?php echo site_url('ctrl_conta/email_reset'); ?>";

				request(urlRequest, formData);
			}
		});

	});
</script>

<div class="box-control box-inline">
	<h2><strong>Redefini&ccedil;&atilde;o de senha</strong></h2>
	<form class="form-horizontal spacer">

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
	      		<input type="password" class="form-control center" id="senha_atual" placeholder="Senha atual">
	      		<label class="control-label" for="senha_atual"></label>
	    	</div>
	  	</div>

	  	<div class="form-group">
	    	<div class="col-lg-12">
	      		<button type="button" class="btn btn-success center" id="atualizar_senha">ATUALIZAR SENHA</button>
	    	</div>
	  	</div>

	</form>
</div>

<div class="box-control box-inline">
	<h2><strong>Redefini&ccedil;&atilde;o de email</strong></h2>
	<form class="form-horizontal">

		<div class="form-group">
	    	<div class="col-lg-12">
				<p class="center">Seu endere&ccedil;o de email atual &eacute;:</p>
				<p class="email"><strong><?php echo $this->session->userdata('email'); ?></strong></p>
			</div>
		</div>

	  	<div class="form-group">
	    	<div class="col-lg-12">
	      		<input type="email" class="form-control center" id="novo_email" placeholder="Novo email">
	      		<label class="control-label center" for="novo_email"></label>
	    	</div>
	  	</div>

	  	<div class="form-group">
	    	<div class="col-lg-12">
	      		<input type="email" class="form-control center" id="confirmar_email" placeholder="Confirme o novo email">
	      		<label class="control-label center" for="confirmar_email"></label>
	    	</div>
	  	</div>

	  	<div class="form-group">
	    	<div class="col-lg-12">
	      		<input type="password" class="form-control center" id="senha_atual_email" placeholder="Senha atual">
	      		<label class="control-label" for="senha_atual_email"></label>
	    	</div>
	  	</div>

	  	<div class="form-group">
	    	<div class="col-lg-12">
	      		<button type="button" class="btn btn-success center" id="atualizar_email">ATUALIZAR EMAIL</button>
	    	</div>
	  	</div>

	</form>
</div>

<input type="hidden" id="cpf" name="cpf" value="<?php echo $encrypted_cpf; ?>" />
