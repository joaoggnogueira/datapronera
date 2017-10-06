<?php
    $this->session->set_userdata('curr_content', 'cadastro_super');
?>

<script type="text/javascript">

 	$.get("<?php echo site_url('requisicao/get_estados'); ?>", function (estados) {
		$('#estado').html(estados);

		var estado = "<?php if ($operacao != 'add') echo $dados[0]->id_estado; ?>";
		$('#estado option[value="'+estado+'"]').attr("selected", true);
	});

 	$(document).ready(function () {

        var id = "<?php echo $superintendencia['id']; ?>";

        $('#salvar').click(function () {

            var form = Array(
                {
                    'id'      : 'nome',
                    'message' : 'Informe o nome da superintendência',
                    'extra'   : null
                },

                {
                    'id'      : 'responsavel',
                    'message' : 'Informe o nome do responsável pela superintendência',
                    'extra'   : null
                },

                {
                    'id'      : 'estado',
                    'message' : 'Selecione o estado a qual a superintendência pertence',
                    'extra'   : null
                }
            );

            if (isFormComplete(form)) {

                var formData = {
                    id : id,
                    nome : $('#nome').val().toUpperCase(),
                    responsavel: $("#responsavel").val().toUpperCase(),
                    estado : $('#estado').val()
                };

                var urlRequest = "<?php if ($operacao == 'add') echo site_url('superintendencia/add/'); else if ($operacao == 'update') echo site_url('superintendencia/update/'); ?>";

                request(urlRequest, formData);
            }
        });

        $('#reset').click(function () {

            var urlRequest = "<?php echo site_url('superintendencia/index/'); ?>";

            request(urlRequest, null, 'hide');
        });

	});
</script>

<form>
  	<fieldset>
	    <legend> Cadastro de Superintendência </legend>

	    <div class="form-group controles">
            <?php
                if ($operacao != 'view') {
                    echo "<input type=\"button\" id=\"salvar\" class=\"btn btn-success\" value=\"Salvar\"> <hr/>";
                }
            ?>
            <input type="button" id="reset" class="btn btn-default" value="Voltar">
        </div>

	    <div class="form-group">
	        <label>1. Nome da Superintendência</label>
            <div>
                <input type="text" class="form-control tamanho-lg" id="nome" name="nome"
                    value="<?php if ($operacao != 'add') echo $dados[0]->nome; ?>">
                <label class="control-label form bold" for="nome"></label>
            </div>
	    </div>

	    <div class="form-group">
	        <label>2. Nome do Responsável</label>
            <div>
                <input type="text" class="form-control tamanho-lg" id="responsavel" name="responsavel"
                    value="<?php if ($operacao != 'add') echo $dados[0]->nome_responsavel; ?>">
                <label class="control-label form bold" for="responsavel"></label>
            </div>
	    </div>

	    <div class="form-group">
	      	<label>3. Estado</label>
            <div>
                <select class="form-control select_estado" id="estado" name="estado"></select>
                <p class="text-danger select"><label for="estado"><label></p>
            </div>
	    </div>

  	</fieldset>
</form>