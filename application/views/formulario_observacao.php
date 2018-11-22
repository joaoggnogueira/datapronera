<?php
    if (empty($data)) {
        echo "<script> request('".site_url('observacao/index/')."', null, 'hide'); </script>";
        exit();
    }
?>

<script type="text/javascript">

 	$(document).ready(function() {

        var id = "<?php echo $this->session->userdata('id_curso'); ?>";

        $('#salvar').click(function () {

            var formData = {
                id : id,
                obs : $('#obs').val()
            };

            var urlRequest = "<?php echo site_url('observacao/update/'); ?>";

            request(urlRequest, formData);

        });

        $('#reset').click(function () {

            var urlRequest = "<?php echo site_url('observacao/index/'); ?>";

            request(urlRequest, null, 'hide');
        });
	});


</script>

<form>
	<fieldset>
        <legend>Observações do Curso</legend>

        <div class="form-group controles">
            <?php

                // II PNERA
                if ($this->session->userdata('status_curso') != '2P' &&
                        $this->session->userdata('status_curso') != 'CC') {
                    echo '<input type="button" id="salvar" class="btn btn-success" value="Salvar">
                          <hr/>';
                }

            ?>
            <input type="button" id="reset" class="btn btn-default" value="Cancelar">
        </div>

		<div class="form-group">
			<label>1. Descrever </label>
			<div>
				<textarea class="form-control tamanho-exlg" id="obs" rows="30" name="obs"><?php echo $data[0]->obs; ?></textarea>
                <label class="control-label form" for="obs"></label>
			</div>
		</div>

	</fieldset>
</form>