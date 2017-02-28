<?php
    $this->session->set_userdata('curr_content', 'organizacao');
?>
<script type="text/javascript">

    //var oTable;

    $(document).ready(function() {

        var id  = "<?php echo $organizacao['id']; ?>";
        var url = "<?php echo site_url('/request/get_membros').'/'; ?>" + id;

        var table = new Table({
            url      : url,
            table    : $('#members_table'),
            controls : $('#members_controls')
        });

        table.hideColumns([0,1]);

        /* Máscara para inputs */
        $('#movimento_fundacao_nac').mask("99/99/9999");
        $('#movimento_fundacao_est').mask("99/99/9999");

        /* Não informados */
        $('#ckMovimento_data_naplica').niCheck({
            'id' : ['movimento_fundacao_nac']
        });

        $('#ckMovimento_data_naoinform').niCheck({
            'id' : ['movimento_fundacao_est']
        });

        $('#ckMovimento_num_acamp').niCheck({
            'id' : ['movimento_num_acamp']
        });

        $('#ckMovimento_num_assent').niCheck({
            'id' : ['movimento_num_assent']
        });

        $('#ckMovimento_num_pessoa').niCheck({
            'id' : ['movimento_num_pessoa']
        });

        $('#ckMovimento_num_familia').niCheck({
            'id' : ['movimento_num_familia']
        });

        $('#ckMovimento_fonte_info').niCheck({
            'id' : ['movimento_fonte_inform']
        });

        contador = 0;
        $('#botao_movim_coord').click(function () {

            var form = Array(
                {
                    'id'      : 'movimento_nome_membro',
                    'message' : 'Informe o nome do membro envolvido no curso',
                    'extra'   : null
                },

                {
                    'id'      : 'movimento_grau_membro',
                    'message' : 'Informe o grau de escolaridade do membro na época do curso',
                    'extra'   : null
                },

                {
                    'id'      : 'movimento_grau_atual_membro',
                    'message' : 'Informe o grau de escolaridade atual do membro',
                    'extra'   : null
                },

                {
                    'name'    : 'rmovimento_estudo',
                    'message' : 'Informe se o membro estudou/estuda em curso do PRONERA',
                    'extra'   : null
                }
            );

            if (isFormComplete(form)) {
                var nome = $('#movimento_nome_membro').val().toUpperCase();
                var esc = $('#movimento_grau_membro').val().toUpperCase();
                var escAtual = $('#movimento_grau_atual_membro').val().toUpperCase();
                var estudo = $("input:radio[name=rmovimento_estudo]:checked").val();

                var node = ['N', 0, nome, esc, escAtual, estudo];

                if (! table.nodeExists(node)) {

                    table.addData(node);

                    $('#movimento_nome_membro').val("");
                    $('#movimento_grau_membro').val("");
                    $('#movimento_grau_atual_membro').val("");
                    $('input:radio[name=rmovimento_estudo]').prop('checked', false);

                } else {
                    $('#movimento_nome_membro').showErrorMessage('Membro já cadastrado');
                    $('#movimento_grau_membro').showErrorMessage('');
                    $('#movimento_grau_atual_membro').showErrorMessage('');
                    $('input:radio[name=rmovimento_estudo]').showErrorMessage('');
                }
            }
        });

        $('#salvar').click( function() {
            //var membros = getmembros(oTable);
            //$('#membros_objeto').val(membros);

            var form = Array(
                {
                    'id'      : 'movimento_nome',
                    'message' : 'Informe o nome da organização demandante',
                    'extra'   : null
                },

                {
                    'name'    : 'rmovimento_abrangencia',
                    'message' : 'Informe a abrangência da organização demandante',
                    'extra'   : null
                },

                {
                    'id'      : 'movimento_fundacao_nac',
                    'ni'      : $('#ckMovimento_data_naplica').prop('checked'),
                    'message' : 'Informe a data de fundação nacional da organização demandante',
                    'extra'   : {
                        'operation' : 'date',
                        'message'   : 'A data informada é inválida'
                    }
                },

                {
                    'id'      : 'movimento_fundacao_est',
                    'ni'      : $('#ckMovimento_data_naoinform').prop('checked'),
                    'message' : 'Informe a data de fundação estadual da organização demandante',
                    'extra'   : {
                        'operation' : 'date',
                        'message'   : 'A data informada é inválida'
                    }
                },

                {
                    'id'      : 'movimento_num_acamp',
                    'ni'      : $('#ckMovimento_num_acamp').prop('checked'),
                    'message' : 'Informe o número de acampamentos ligados a organização demandante',
                    'extra'   : null
                },

                {
                    'id'      : 'movimento_num_assent',
                    'ni'      : $('#ckMovimento_num_assent').prop('checked'),
                    'message' : 'Informe o número de assentamentos ligados ao movimento no Estado',
                    'extra'   : null
                },

                {
                    'id'      : 'movimento_num_familia',
                    'ni'      : $('#ckMovimento_num_familia').prop('checked'),
                    'message' : 'Informe o número de famílias assentadas',
                    'extra'   : null
                },

                {
                    'id'      : 'movimento_num_pessoa',
                    'ni'      : $('#ckMovimento_num_pessoa').prop('checked'),
                    'message' : 'Informe o número de pessoas envolvidas no acompanhamento do Curso',
                    'extra'   : null
                },

                {
                    'id'      : 'movimento_fonte_inform',
                    'ni'      : $('#ckMovimento_fonte_info').prop('checked'),
                    'message' : 'Informe a fonte das informações',
                    'extra'   : null
                }
            );

            if (isFormComplete(form)) {

                var formData = {
                    id : id,
                    movimento_nome : $('#movimento_nome').val().toUpperCase(),
                    rmovimento_abrangencia : $("input:radio[name=rmovimento_abrangencia]:checked").val(),
                    ckMovimento_data_naplica :$('#ckMovimento_data_naplica').prop('checked'),
                    movimento_fundacao_nac : $('#movimento_fundacao_nac').val().toUpperCase(),
                    ckMovimento_data_naoinform : $('#ckMovimento_data_naoinform').prop('checked'),
                    movimento_fundacao_est : $('#movimento_fundacao_est').val().toUpperCase(),
                    ckMovimento_num_assent :$('#ckMovimento_num_assent').prop('checked'),
                    movimento_num_assent : $('#movimento_num_assent').val().toUpperCase(),
                    ckMovimento_num_acamp :$('#ckMovimento_num_acamp').prop('checked'),
                    movimento_num_acamp : $('#movimento_num_acamp').val().toUpperCase(),
                    ckMovimento_num_familia :$('#ckMovimento_num_familia').prop('checked'),
                    movimento_num_familia : $('#movimento_num_familia').val().toUpperCase(),
                    ckMovimento_num_pessoa :$('#ckMovimento_num_pessoa').prop('checked'),
                    movimento_num_pessoa : $('#movimento_num_pessoa').val().toUpperCase(),
                    ckMovimento_fonte_info : $('#ckMovimento_fonte_info').prop('checked'),
                    movimento_fonte_inform : $('#movimento_fonte_inform').val().toUpperCase(),
                    membros : table.getAll(),
                    membros_excluidos: table.getDeletedRows(1)
                };

                console.log(formData);

                var urlRequest = url_operacao = "<?php if ($operacao == 'add') echo site_url('organizacao/add/'); if ($operacao == 'update') echo site_url('organizacao/update/'); ?>";

                request(urlRequest, formData);
            }
        });

        $('#reset').click(function () {

            var urlRequest = "<?php echo site_url('/organizacao/index') ?>";

            request(urlRequest, null, 'hide');
        });
    });

    /*function get_code(){
        var anSelected = fnGetSelected( oTable );
        var data = oTable.fnGetData( anSelected[0]);
        return data[0];
    }

    /*
    function getmembros( oTableLocal ) {

        var aReturn = new Array();
        var aTrs = oTableLocal.fnGetNodes();

        for ( var i=0 ; i<aTrs.length ; i++ ) {
    		var data = oTable.fnGetData( aTrs[i]);
            aReturn.push( data[1] );
            aReturn.push( data[2] );
            aReturn.push( data[3] );
            aReturn.push( data[4] );
        }
        return aReturn;
    }

    /* Get the rows which are currently selected
    function fnGetSelected( oTableLocal ) {

        var aReturn = new Array();
        var aTrs = oTableLocal.fnGetNodes();

        for ( var i=0 ; i<aTrs.length ; i++ ) {
            if ( $(aTrs[i]).hasClass('active') ) {
                aReturn.push( aTrs[i] );
                i = aTrs.length + 1;
            }
        }
        return aReturn;
    }*/

</script>

<?php
    if ($operacao == 'add')
        $retrivial = false;
    else
        $retrivial = true;
?>

<form id="form"	method="post">
  	<fieldset>
	    <legend>Caracteriza&ccedil;&atilde;o das Organiza&ccedil;&otilde;es Demandantes</legend>

		<div class="form-group controles">
            <?php
                if ($this->session->userdata('status_curso') != '2P' && $this->session->userdata('status_curso') != 'CC' && $operacao != 'view') {
                    echo "<input type=\"button\" id=\"salvar\" class=\"btn btn-success\" value=\"Salvar\"> <hr/>";
                }
            ?>
            <input type="button" id="reset" class="btn btn-default" value="Voltar">
        </div>

	    <div class="form-group">
	      	<label>1. Nome da Organiza&ccedil;&atilde;o</label>
            <div>
                <input type="text" class="form-control tamanho-lg" id="movimento_nome" name="movimento_nome"
                    value="<?php if ($retrivial) echo $dados[0]->nome; ?>">
                <label class="control-label form" for="movimento_nome"></label>
            </div>
	    </div>

	    <div class="form-group">
	      	<label>2. Abrang&ecirc;ncia da Organiza&ccedil;&atilde;o</label>
			<div class="radio">
		      	<div class="radio"> <label> <input type="radio" name="rmovimento_abrangencia" id="rmovimento_abrangencia_01" value="NACIONAL" <?php if ($retrivial && $dados[0]->abrangencia == 'NACIONAL') echo "checked"; ?>> Nacional </label> </div>
		      	<div class="radio"> <label> <input type="radio" name="rmovimento_abrangencia" id="rmovimento_abrangencia_02" value="REGIONAL" <?php if ($retrivial && $dados[0]->abrangencia == 'REGIONAL') echo "checked"; ?>> Regional </label> </div>
		      	<div class="radio"> <label> <input type="radio" name="rmovimento_abrangencia" id="rmovimento_abrangencia_03" value="ESTADUAL" <?php if ($retrivial && $dados[0]->abrangencia == 'ESTADUAL') echo "checked"; ?>> Estadual </label> </div>
                <p class="text-danger"><label for="rmovimento_abrangencia"><label></p>
		    </div>
	    </div>

	    <div class="form-group">
	      	<label class="negacao">3. Data de Funda&ccedil;&atilde;o Nacional</label>

	      	<div class="checkbox negacao-smaller">
		      	<label> <input type="checkbox" name="ckMovimento_data_naplica" id="ckMovimento_data_naplica" <?php if ($retrivial && $dados[0]->data_fundacao_nacional == '01/01/1900') echo "checked"; ?>> N&atilde;o se aplica </label>
		    </div>

		    <div class="form-group">
                <div>
                    <input type="text" class="form-control tamanho-sm2" id="movimento_fundacao_nac" name="movimento_fundacao_nac"
                        value="<?php if ($retrivial && $dados[0]->data_fundacao_nacional != '01/01/1900') echo $dados[0]->data_fundacao_nacional; ?>">
                    <label class="control-label form" for="movimento_fundacao_nac"></label>
                </div>
	      	</div>
	    </div>

	    <div class="form-group">
	      	<label class="negacao">4. Data de Funda&ccedil;&atilde;o no Estado</label>

            <div class="checkbox negacao-smaller">
                <label> <input type="checkbox" name="ckMovimento_data_naoinform" id="ckMovimento_data_naoinform" <?php if ($retrivial && $dados[0]->data_fundacao_estadual == '00/00/0000') echo "checked"; ?>> N&atilde;o informado </label>
            </div>

            <div class="form-group">
                <div>
                    <input type="text" class="form-control tamanho-sm2" id="movimento_fundacao_est" name="movimento_fundacao_est"
                        value="<?php if ($retrivial) echo $dados[0]->data_fundacao_estadual; ?>">
                    <label class="control-label form" for="movimento_fundacao_est"></label>
                </div>
            </div>
	    </div>

	    <div class="form-group">
	      	<label class="negacao">5. N&uacute;mero de Acampamentos (estadual)</label>
			<div class="checkbox negacao-smaller">
		      	<label> <input type="checkbox" name="ckMovimento_num_acamp" id="ckMovimento_num_acamp" <?php if ($retrivial && $dados[0]->numero_acampamentos == '-1') echo "checked"; ?>> N&atilde;o informado </label>
		    </div>

		    <div class="form-group">
                <div>
                    <input type="text" class="form-control tamanho-smaller" id="movimento_num_acamp" name="movimento_num_acamp"  maxLength="6"
                        value="<?php if ($retrivial && $dados[0]->numero_acampamentos != '-1') echo $dados[0]->numero_acampamentos; ?>">
                    <label class="control-label form" for="movimento_num_acamp"></label>
                </div>
	      	</div>
	    </div>

	    <div class="form-group">
	      	<label class="negacao">6. N&uacute;mero de Assentamentos ligados ao Movimento no Estado</label>

			<div class="checkbox negacao-smaller">
		      	<label> <input type="checkbox" name="ckMovimento_num_assent" id="ckMovimento_num_assent" <?php if ($retrivial && $dados[0]->numero_assentamentos == '-1') echo "checked"; ?>> N&atilde;o informado </label>
		    </div>
		    <div class="form-group">
                <div>
                    <input type="text" class="form-control tamanho-smaller" id="movimento_num_assent" name="movimento_num_assent"  maxLength="6"
                        value="<?php if ($retrivial && $dados[0]->numero_assentamentos != '-1') echo $dados[0]->numero_assentamentos; ?>">
                    <label class="control-label form" for="movimento_num_assent"></label>
                </div>
	      	</div>
	    </div>

	    <div class="form-group">
	      	<label class="negacao">7. N&uacute;mero de Fam&iacute;lias Assentadas</label>

			<div class="checkbox negacao-smaller">
		      	<label> <input type="checkbox" name="ckMovimento_num_familia" id="ckMovimento_num_familia" <?php if ($retrivial && $dados[0]->numero_familias_assentadas == '-1') echo "checked"; ?>> N&atilde;o informado </label>
		    </div>

		    <div class="form-group">
                <div>
	      		   <input type="text" class="form-control tamanho-smaller" id="movimento_num_familia" name="movimento_num_familia"  maxLength="6"
                        value="<?php if ($retrivial && $dados[0]->numero_familias_assentadas != '-1')  echo $dados[0]->numero_familias_assentadas; ?>">
                    <label class="control-label form" for="movimento_num_familia"></label>
                </div>
	      	</div>
	    </div>

	    <div class="form-group">
	      	<label class="negacao">8. N&uacute;mero de Pessoas do Movimento envolvidas no acompanhamento do Curso</label>

			<div class="checkbox negacao-smaller">
		      	<label> <input type="checkbox" name="ckMovimento_num_pessoa" id="ckMovimento_num_pessoa" <?php if ($retrivial && $dados[0]->numero_pessoas == '-1') echo "checked"; ?>> N&atilde;o informado </label>
		    </div>

	      	<div class="form-group">
                <div>
                    <input type="text" class="form-control tamanho-smaller" id="movimento_num_pessoa" name="movimento_num_pessoa"  maxLength="6"
                        value="<?php if ($retrivial && $dados[0]->numero_pessoas != '-1') echo $dados[0]->numero_pessoas; ?>">
                    <label class="control-label form" for="movimento_num_familia"></label>
                </div>
	      	</div>
	    </div>

	    <div class="table-box table-box-lg">
	      	<label>9. Membros envolvidos</label>
	      	<div class="form-group interno">
	      		<label> a. Nome do membro envolvido no curso (Coordenador(a)) </label>
                <div>
                    <input type="text" class="form-control tamanho-n" id="movimento_nome_membro" name="movimento_nome_membro">
                    <label class="control-label form" for="movimento_nome_membro"></label>
                </div>
	    	</div>
	    	<div class="form-group interno">
	      		<label> b. Grau de escolaridade na &eacute;poca da realiza&ccedil;&atilde;o do curso </label>
                <div>
                    <input type="text" class="form-control" id="movimento_grau_membro" name="movimento_grau_membro">
                    <label class="control-label form" for="movimento_grau_membro"></label>
                </div>
	    	</div>
	    	<div class="form-group interno">
	      		<label> c. Grau de escolaridade na atualidade </label>
                <div>
                    <input type="text" class="form-control" id="movimento_grau_atual_membro" name="movimento_grau_atual_membro">
                    <label class="control-label form" for="movimento_grau_atual_membro"></label>
                </div>
	    	</div>
	    	<div class="form-group interno">
	      		<label> d. Estudou/estuda em curso do PRONERA ? </label>
				<div class="radio interno">
			      	<div class="radio"> <label> <input type="radio" name="rmovimento_estudo" id="rmovimento_estudo_01" value="SIM"> Sim </label> </div>
			      	<div class="radio"> <label> <input type="radio" name="rmovimento_estudo" id="rmovimento_estudo_02" value="NAO"> N&atilde;o  </label> </div>
                    <p class="text-danger"><label for="rmovimento_estudo"><label></p>
			    </div>
    		</div>

            <div class="form-group interno">
                <ul id="members_controls" class="nav nav-pills buttons">
                    <li class="buttons">
                        <button type="button" id="botao_movim_coord" class="btn btn-default">Adicionar Membro</button>
                    </li>
                    <li class="buttons">
                        <button type="button" class="btn btn-default btn-disabled disabled delete-row" id="deletar" name="deletar"> Remover Selecionado </button>
                    </li>
                </ul>
            </div>

	    	<div class="table-size table-size-lg">
		    	<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="members_table">
			        <thead>
			            <tr>
                            <th width=" 10px;"> FLAG </th>
                            <th width=" 10px;"> CÓDIGO </th>
			                <th width="250px;"> NOME </th>
			                <th width="200px;"> ESCOLARIZAÇÃO NA ÉPOCA </th>
			                <th width="200px;"> ESCOLARIZAÇÃO ATUAL </th>
			                <th width="200px;"> ESTUDOU NO PRONERA ? </th>
			            </tr>
			        </thead>

			        <tbody>
			        </tbody>
			    </table>
		    </div>
	    </div>

	    <div class="form-group">
	      	<label class="negacao">10. Fonte das informa&ccedil;&otilde;es (nome da pessoa que forneceu os dados)</label>

            <div class="checkbox negacao-sm">
                <label> <input type="checkbox" name="ckMovimento_fonte_info" id="ckMovimento_fonte_info"
                <?php if ($retrivial && $dados[0]->fonte_informacao == 'NAOINFORMADO') echo 'checked'; ?> > N&atilde;o informado </label>
            </div>

            <div class="form-group">
                <div>
                    <input type="text" class="form-control tamanho-lg" id="movimento_fonte_inform" name="movimento_fonte_inform"
                        value="<?php if ($retrivial) echo $dados[0]->fonte_informacao; ?>">
                    <label class="control-label form" for="movimento_fonte_inform"></label>
                </div>
            </div>
	    </div>
		<!--<input type="text" id="membros_objeto" name="membros_objeto" hidden/>-->

  	</fieldset>
</form>