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

<li class="dropdown
	<?php
		if ($this->session->userdata('curr_content') == 'gerenciar_conta') {
			echo ' active';
		}
	?>
">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<b> <?php echo $this->session->userdata('name'); ?> </b>
		<b class="caret"></b>
	</a>
	<ul class="dropdown-menu drop">
		<li><a href="#" onclick="
			request('<?php echo site_url('ctrl_conta/index'); ?>', null, 'hide');
		">Gerenciar conta</a></li>
		<li><a href="<?php echo site_url('ctrl_login/sign_out'); ?>">Sair</a></li>
	</ul>
</li>
<li
	<?php
		if ($this->session->userdata('curr_content') == 'contato') {
			echo 'class="active"';
		}
	?>
><a href="#" onclick="
	request('<?php echo site_url('contato/index'); ?>', null, 'hide');
">Contatos</a></li>

<li><a href="#">Manual</a></li>
<li class="dropdown
	<?php
		if (
			$this->session->userdata('curr_content') == 'cadastro_pessoa' ||
			$this->session->userdata('curr_content') == 'cadastro_curso'  ||
			$this->session->userdata('curr_content') == 'cadastro_super'
		) {
			echo ' active';
		}
	?>
">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		Cadastros
		<b class="caret"></b>
	</a>
	<ul class="dropdown-menu drop">
		<li><a href="#" onclick="
			request('<?php echo site_url('pessoa/index'); ?>', null, 'hide');
		">Usu&aacute;rios</a></li>

		<li><a href="#" onclick="
			request('<?php echo site_url('curso/index'); ?>', null, 'hide');
		">Curso</a></li>

		<?php

			// SUPERVISOR, COORD. GERAL, ADMINISTRADOR
			if ($this->session->userdata('access_level') > 2) {

				echo '<li><a href="#" onclick="
							request(\''.site_url('superintendencia/index').'\', null, \'hide\');
					  ">Superintend&ecirc;ncia</a></li>';
			}
		?>

	</ul>
</li>
<li class="dropdown
	<?php
		if (strpos($this->session->userdata('curr_content'),'rel_') !== false) {
			echo ' active';
		}
	?>
">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		Relat&oacute;rios
		<b class="caret"></b>
	</a>
	<ul class="dropdown-menu drop">
		<li><a href="#" onclick="
			request('<?php echo site_url('relatorio_qualitativo/index'); ?>', null, 'hide');
		">Qualitativos</a></li>
		<li><a href="#" onclick="
			request('<?php echo site_url('relatorio_quantitativo/index'); ?>', null, 'hide');
		">Quantitativos</a></li>
		<li><a href="#" onclick="
			request('<?php echo site_url('relatorio_estatistico/index'); ?>', null, 'hide');
		">Estat&iacute;sticos</a></li>
		<!--
		<li><a href="#" onclick="
			request('<?php echo site_url('relatorio_geral_andamento/index'); ?>', null, 'hide');
		">Relatórios Gerais - Cadastro em Andamento</a></li>
		<li><a href="#" onclick="
			request('<?php echo site_url('relatorio_geral_concluido/index'); ?>', null, 'hide');
		">Relatórios Gerais - Cadastro Concluídos</a></li>
		-->
		<li><a href="#" onclick="
			request('<?php echo site_url('relatorio_geral_pnera2/index'); ?>', null, 'hide');
		">Relatórios Gerais - II PNERA</a></li>
		<li><a href="#" onclick="
			request('<?php echo site_url('relatorio_dinamico/index'); ?>', null, 'hide');
		">Relatório Dinâmico</a></li>
	</ul>
</li>
<li class="dropdown
	<?php
		if (strpos($this->session->userdata('curr_content'),'producao9') !== false) {
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
			request('<?php echo site_url('producao9a/index'); ?>', null, 'hide');
		">Monografia / TCC / Disserta&ccedil;&atilde;o / Tese</a></li>

		<li><a href="#" onclick="
			request('<?php echo site_url('producao9b_livro/index'); ?>', null, 'hide');
		">Livro / Colet&acirc;nea</a></li>

		<li><a href="#" onclick="
			request('<?php echo site_url('producao9c/index'); ?>', null, 'hide');
		">Cap&iacute;tulo de livro</a></li>

		<li><a href="#" onclick="
			request('<?php echo site_url('producao9d/index'); ?>', null, 'hide');
		">Artigo</a></li>

		<li><a href="#" onclick="
			request('<?php echo site_url('producao9e/index'); ?>', null, 'hide');
		">V&iacute;deo / Document&aacute;rio</a></li>

		<li><a href="#" onclick="
			request('<?php echo site_url('producao9f/index'); ?>', null, 'hide');
		">Peri&oacute;dico</a></li>

		<li><a href="#" onclick="
			request('<?php echo site_url('producao9g/index'); ?>', null, 'hide');
		">Eventos</a></li>
	</ul>
</li>
<li
	<?php
		if ($this->session->userdata('curr_content') == 'cursos') {
			echo 'class="active"';
		}
	?>
><a href="#" onclick="
	request('<?php echo site_url('ctrl_curso/index'); ?>', null, 'hide');
">Cursos</a></li>