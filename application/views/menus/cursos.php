<?php

    if (! defined('BASEPATH')) {
        exit('No direct script access allowed');

    } else if (! $this->system->is_logged_in()) {
        echo index_page();
    }
    
?>

<script type="text/javascript">
	$(document).ready(function () {
		loadMenuFeatures('all');
	});
</script>

<li><a href="#" onclick="
	request('<?php echo site_url('ctrl_curso/back'); ?>', null, 'hide');
"><b>Voltar</b></a></li>

<li
	<?php
		if ($this->session->userdata('curr_content') == 'formulario_observacao') {
			echo 'class="active"';
		}
	?>
><a href="#" onclick="
	request('<?php echo site_url('observacao/index/'); ?>', null, 'hide');
">Observa&ccedil;&otilde;es</a></li>

<li
	<?php
		if ($this->session->userdata('curr_content') == 'fiscalizacao') {
			echo 'class="active"';
		}
	?>
><a href="#" onclick="
	request('<?php echo site_url('fiscalizacao/index/'); ?>', null, 'hide');
    ">Acompanhamento/Fiscaliza&ccedil;&atilde;o</a></li>

<li class="dropdown
	<?php
		if (strpos($this->session->userdata('curr_content'),'producao8') !== false) {
			echo ' active';
		}
	?>
">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		Produ&ccedil;&otilde;es
		<b class="caret"></b>
	</a>
	<ul class="dropdown-menu drop">
		<li><a href="#" onclick="
			request('<?php echo site_url('producao8a/index/'); ?>', null, 'hide');
		">8A - Geral</a></li>

		<li><a href="#" onclick="
			request('<?php echo site_url('producao8b/index/'); ?>', null, 'hide');
		">8B - Trabalho</a></li>

		<li><a href="#" onclick="
			request('<?php echo site_url('producao8c/index/'); ?>', null, 'hide');
		">8C - Artigo</a></li>

		<li><a href="#" onclick="
			request('<?php echo site_url('producao8d/index/'); ?>', null, 'hide');
		">8D - Mem&oacute;ria</a></li>

		<li><a href="#" onclick="
			request('<?php echo site_url('producao8e/index/'); ?>', null, 'hide');
		">8E - Livro</a></li>
	</ul>
</li>
<li
	<?php
		if ($this->session->userdata('curr_content') == 'parceiro') {
			echo 'class="active"';
		}
	?>
><a href="#" onclick="
	request('<?php echo site_url('parceiro/index/'); ?>', null, 'hide');
">Parceiros</a></li>

<li
	<?php
		if ($this->session->userdata('curr_content') == 'organizacao') {
			echo 'class="active"';
		}
	?>
><a href="#" onclick="
	request('<?php echo site_url('organizacao/index/'); ?>', null, 'hide');
">Org. Demandantes</a></li>

<li
	<?php
		if ($this->session->userdata('curr_content') == 'formulario_instituicao') {
			echo 'class="active"';
		}
	?>
><a href="#" onclick="
	request('<?php echo site_url('instituicao/index/'); ?>', null, 'hide');
">Inst. Ensino</a></li>

<li
	<?php
		if ($this->session->userdata('curr_content') == 'educando') {
			echo 'class="active"';
		}
	?>
><a href="#" onclick="
	request('<?php echo site_url('educando/index/'); ?>', null, 'hide');
">Educandos</a></li>

<li
	<?php
		if ($this->session->userdata('curr_content') == 'professor') {
			echo 'class="active"';
		}
	?>
><a href="#" onclick="
	request('<?php echo site_url('professor/index/'); ?>', null, 'hide');
">Professores</a></li>

<li
	<?php
		if ($this->session->userdata('curr_content') == 'formulario_caracterizacao') {
			echo 'class="active"';
		}
	?>
><a href="#" onclick="
	request('<?php echo site_url('caracterizacao/index/'); ?>', null, 'hide');
">Caracteriza&ccedil;&atilde;o</a></li>

<!--<li
	<?php
		/*if ($this->session->userdata('curr_content') == 'formulario_responsavel') {
			echo 'class="active"';
		}*/
	?>
><a href="#" onclick="
	request('<?php //echo site_url('responsavel/index/'); ?>', null, 'hide');
">Informa&ccedil;&otilde;es</a></li>-->