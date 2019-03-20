<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
} else if (!$this->system->is_logged_in()) {
    echo index_page();
}
?>

<script type="text/javascript">

    $(document).ready(function () {

        var tableActive = new Table({
            url: "<?php echo site_url('request/get_assentamento_cadastro'); ?>",
            table: $('#active_assentamento_table'),
            controls: $('#active_assentamento_controls')
        });

        tableActive.hideColumns([0]);

    });
</script>
<style>
    #active_assentamento_table tr > th:nth-child(1),
    #active_assentamento_table tr > td:nth-child(1){
        width: 10%;
    }
    #active_assentamento_table tr > th:nth-child(2),
    #active_assentamento_table tr > td:nth-child(2){
        width: 50%;
    }
    #active_assentamento_table tr > th:nth-child(3),
    #active_assentamento_table tr > td:nth-child(3){
        width: 10%;
    }
    #active_assentamento_table tr > th:nth-child(4),
    #active_assentamento_table tr > td:nth-child(4){
        width: 30%;
    }
</style>
<div class="tab-pane active" id="active">

    <div id="grid">
        <ul id="active_assentamento_controls" class="nav nav-pills buttons">        
            <li class="buttons"><button type="button" class="btn btn-success" id="update">Verificar atualização</button></li>
        </ul> 

        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="active_assentamento_table">
            <thead>
                <tr>
                    <th style="width: 0%"> ID </th>
                    <th style="width: 10%"> COD. SIPRA </th>
                    <th style="width: 50%"> ASSENTAMENTO </th>
                    <th style="width: 10%"> UF </th>
                    <th style="width: 30%"> SR </th>
                </tr>
            </thead>

            <tbody>
            </tbody>
        </table>
    </div>
</div>