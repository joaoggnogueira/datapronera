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
        <?PHP 
            if($this->session->userdata('permissao_publica')): 
                $token = $this->session->userdata('token');
                $record_token = $this->session->userdata('record_token');
            endif; 
        ?>
    });
</script>
<h3>Bem-vindo ao Acesso Público!</h3>
<hr/>
<?PHP if($this->session->userdata('permissao_publica')): ?>
    <div class="row">
        <span class="col-md-9" style="text-align: left">
            O Link utilizado é uma chave para acessar algumas <b>informações protegidas</b>.<br/>
            Tais informações não são acessíveis sem o link, ou seja, <b style="color:red">não compartilhe essa chave sem autorização</b>.
        </span>
    </div>
    <br/>
    <div class="row">
    <?PHP if(isset($token->mapa)): ?>
        <span class="col-md-9" style="text-align: left">
            <button type="button" onclick="request('<?= site_url('relatorio_mapas/index/');?>', {sr:<?= $record_token['sr']->id ?>}, 'hide');"  class="btn btn-primary" id="acessar_token"><i class="fa fa-map"></i> Acessar Mapa da SR <?= $record_token['sr']->id ?> - <?= $record_token['sr']->nome ?></button>
        </span>
    <?PHP endif; ?>
    </div>
<br/>
<?PHP endif; ?>
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