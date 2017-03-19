<script type="text/javascript">
	
	$(document).ready(function () {

//		$('#submit').click(function () {
//            $('#dialog-fin-cs').dialogInit(function () {
//
//            	var urlRequest = "<?php echo site_url('curso/toogle_status/CC'); ?>";
//
//                request(urlRequest, null);
//
//                return true;
//
//            }, [500,220]);
//        });

	});

</script>

<nav class="navbar navbar-default" role="navigation">
  	<div class="container">

	    <div class="navbar-header">
	      	<a class="navbar-brand" href="#"><?php echo $this->session->userdata('cod_course'); ?></a>
	      	<a class="navbar-brand" href="#"><?php echo $this->session->userdata('name_course'); ?></a>
	    </div>

<!--	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	    	<?php

	    		if ($this->session->userdata('status_curso') != '2P' &&
    					$this->session->userdata('status_curso') != 'CC') {
	    			echo '<button id="submit" type="button" class="btn btn-default btn-sm navbar-btn pull-right">Finalizar Cadastro</button>';
	    		}
	    	?>
	    	
	    </div>-->

  	</div>
</nav>

<div id="dialog-fin-cs" name="dialog-fin-cs" class="dialog" title="Confirmar submiss&atilde;o">
    <br />
    <h4>Ao finalizar o cadastro os dados do curso não poderão mais ser alterados. Deseja proseguir?</h4>
</div>