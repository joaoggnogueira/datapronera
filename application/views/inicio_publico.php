<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
} else if (!$this->system->is_logged_in()) {
    echo index_page();
}
?>
<script>
    $(document).ready(function () {

        $.get("<?php echo site_url('requisicao/get_municipio_desc'); ?>/<?= $this->session->userdata('id_cidade') ?>", function (result) {
            $("#municipio-up-label").html(result);
        });

    });
</script>
<h3>Bem-vindo ao Acesso Público!</h3>
<hr/>
<div class="row" style="width:400px;">
    <div class="form-group" style="margin:10px;">
        <label>Seus Dados Cadastrais:</label>
        <br/>
        <br/>
        <div class="row">
            <b class="col-md-3">Email :</b>
            <span class="col-md-9" style="text-align: right" id="email-up-label"><?= $this->session->userdata('email') ?></span>
        </div>
        <hr/>
        <div class="row">                       
            <b class="col-md-4">Nome :</b>
            <span class="col-md-8" style="text-align: right" id="name-up-label"><?= $this->session->userdata('name') ?></span>
        </div>
        <hr/>
        <div class="row">       
            <b class="col-md-5">Município :</b>
            <span class="col-md-7" style="text-align: right" id="municipio-up-label"></span>
        </div>
        <hr/>
    </div>
</div>