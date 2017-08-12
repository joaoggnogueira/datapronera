<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
} else if (!$this->system->is_logged_in()) {
    echo index_page();
}
?>

<script type="text/javascript">
    $(document).ready(function () {
        loadMenuFeatures('all');
    });
</script>
<li class="dropdown <?= (($this->session->userdata('curr_content') == 'gerenciar_conta') ? 'active' : '') ?>">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <b> <?= $this->session->userdata('name'); ?> </b>
        <b class="caret"></b>
    </a>
    <ul class="dropdown-menu drop">
        <li><a href="#" onclick="
                request('<?php echo site_url('acesso_publico/gerenciar_index'); ?>', null, 'hide');
               ">Gerenciar conta</a></li>
        <li><a href="<?php echo site_url('ctrl_login/sign_out'); ?>">Sair</a></li>
    </ul>
</li>
<li class="dropdown <?=((strpos($this->session->userdata('curr_content'),'rel_') !== false)?'active':'')?>">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		Relat&oacute;rios
		<b class="caret"></b>
	</a>
	<ul class="dropdown-menu drop">
		<li><a href="#" onclick="
			request('<?php echo site_url('relatorio_mapas/index'); ?>', null, 'hide');
		">Mapas</a></li>
	</ul>
</li>
<li <?= ($this->session->userdata('curr_content') == 'inicio_publico'?'class="active"':'')?>>
    <a href="#" onclick="request('<?php echo site_url('acesso_publico/index'); ?>', null, 'hide');
">Inicio</a></li>