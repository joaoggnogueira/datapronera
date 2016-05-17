<?php
    $this->session->set_userdata('curr_content', 'producao8d');
?>
<script type="text/javascript">

    //var oTable;

    $(document).ready(function() {

        var id = "<?php echo $producao['id']; ?>";

        /* Máscara para inputs */
        $('#memoria_ano').mask("9999");

        /* Opções complementares */
        $('input:radio[name=rmemoria]').optionCheck({
            'id' : ['memoria_site']

        }, "ON-LINE");

        $('#salvar').click(function () {

            var form = Array(
                {
                    'id'      : 'memoria_titulo',
                    'message' : 'Informe o título da produção',
                    'extra'   : null
                },

                {
                    'id'      : 'memoria_local',
                    'message' : 'Informe o local da produção',
                    'extra'   : null
                },

                {
                    'id'      : 'memoria_ano',
                    'message' : 'Informe o ano da produção',
                    'extra'   : null
                },

                {
                    'name'    : 'rmemoria',
                    'message' : 'Informe o formato da produção',
                    'next'    : false,
                    'extra'   : null
                },

                {
                    'id'      : 'memoria_site',
                    'ni'      : !$('#rmemoria_03').prop('checked'),
                    'message' : 'Informe o endereço web da produção',
                    'extra'   : null
                },

                {
                    'id'      : 'memoria_disponivel',
                    'message' : 'Informe onde a produção está disponível',
                    'extra'   : null
                }
            );

            if (isFormComplete(form)) {

                var formData = {
                    id_producao : id,
                    memoria_titulo : $('#memoria_titulo').val().toUpperCase(),
    				memoria_local : $('#memoria_local').val().toUpperCase(),
    				memoria_ano : $('#memoria_ano').val().toUpperCase(),
    				rmemoria : $("input:radio[name=rmemoria]:checked").val(),
    				memoria_site : $('#memoria_site').val().toUpperCase(),
    				memoria_disponivel : $('#memoria_disponivel').val().toUpperCase()
                };

                urlRequest = "<?php if ($operacao == 'add') echo site_url('producao8d/add/'); if ($operacao == 'update') echo site_url('producao8d/update/'); ?>";

                request(urlRequest, formData);
            }
        });

        $('#reset').click(function () {

            urlRequest = "<?php echo site_url('producao8d/index/'); ?>";

            request(urlRequest, null, 'hide');
        });

    });

</script>
<form>
  	<fieldset>
	    <legend>Caracterização da Produção Bibliográfica/Artística/Tecnológica do PRONERA <br /><br />
       			MEMÓRIA produzida pelos educandos(as) durante o curso</legend>

        <div class="form-group controles">
            <?php
                if ($this->session->userdata('status_curso') != '2P' && $this->session->userdata('status_curso') != 'CC' && $operacao != 'view') {
                    echo "<input type=\"button\" id=\"salvar\" class=\"btn btn-success\" value=\"Salvar\"> <hr/>";
                }
            ?>
            <input type="button" id="reset" class="btn btn-default" value="Voltar">
        </div>

	    <div class="form-group">
	      	<label>1. Titulo</label>
            <div>
                <input type="text" class="form-control tamanho-lg" id="memoria_titulo" name="memoria_titulo"
                    value="<?php if($operacao != 'add') echo $dados[0]->titulo; ?>">
                <label class="control-label form bold" for="memoria_titulo"></label>
            </div>
		</div>

	    <div class="form-group">
	      	<label>2. Local</label>
            <div>
                <input type="text" class="form-control tamanho-n" id="memoria_local" name="memoria_local"
                    value="<?php if($operacao != 'add') echo $dados[0]->local_producao; ?>">
                <label class="control-label form bold" for="memoria_local"></label>
            </div>
		</div>

	    <div class="form-group">
	      	<label>3. Ano</label>
            <div>
                <input type="text" class="form-control tamanho-smaller" id="memoria_ano" name="memoria_ano"
                    value="<?php if($operacao != 'add') echo $dados[0]->ano ?>">
                <label class="control-label form bold" for="memoria_ano"></label>
            </div>
		</div>

	    <div class="form-group">
	      	<label>4. Formato</label>

	     	<div class="radio form-group">
				<div class="radio"> <label> <input type="radio" name="rmemoria" id="rmemoria_01" value="DIGITAL / CD"
				<?php if($operacao != 'add' && $dados[0]->formato == 'DIGITAL / CD') echo "checked"; ?> > Digital / CD </label> </div>

				<div class="radio"> <label> <input type="radio" name="rmemoria" id="rmemoria_02" value="IMPRESSO"
				<?php if($operacao != 'add' && $dados[0]->formato == 'IMPRESSO') echo "checked"; ?> > Impresso </label> </div>

				<div class="radio"> <label> <input type="radio" name="rmemoria" id="rmemoria_03" value="ON-LINE"
				<?php if($operacao != 'add' && $dados[0]->formato == 'ON-LINE') echo "checked"; ?> > On-line </label> </div>

	      		<div>
                   <input type="text" class="form-control tamanho-lg url" id="memoria_site" name="memoria_site" placeHolder="Informe o endereço web"
                        <?php
                            if ($operacao != 'add' && $dados[0]->formato == 'ON-LINE') {
                                echo 'value="'.$dados[0]->pagina_web.'"';

                            } else {
                                echo "style=\"display:none\";";
                            }
                        ?>
                    >
                    <p class="text-danger"><label for="rmemoria"><label></p>
                    <label class="control-label form bold" for="memoria_site"></label>
               </div>
	     	</div>
	    </div>

	    <div class="form-group">
	      	<label>5. Onde está disponível</label>
            <div>
                <input type="text" class="form-control tamanho-lg" id="memoria_disponivel" name="memoria_disponivel"
                    value="<?php if($operacao != 'add') echo $dados[0]->disponibilidade; ?>">
                <label class="control-label form bold" for="memoria_disponivel"></label>
            </div>
		</div>

  	</fieldset>
</form