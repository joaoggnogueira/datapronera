<?php

    if (! defined('BASEPATH')) {
        exit('No direct script access allowed');

    } else if (! $this->system->is_logged_in()) {
        echo index_page();        
    }
    
?>

<script type="text/javascript">

    $(document).ready(function() {

        var tableActive = new Table({
            url      : "<?php echo site_url('request/get_super_cadastro/A'); ?>",
            table    : $('#active_super_table'),
            controls : $('#active_super_controls')
        });

        var tableInactive = new Table({
            url      : "<?php echo site_url('request/get_super_cadastro/I'); ?>",
            table    : $('#inactive_super_table'),
            controls : $('#inactive_super_controls')
        });

        tableActive.hideColumns([0]);
        tableInactive.hideColumns([0]);

        //TABLE CONTROLS

            // HANDLER TO ADD A NEW SUPERINTENDENCE
            $('#inserir').click(function () {

                var formData = {
                   id_super : null,
                   operacao : 'add'
                };

                var urlRequest = "<?php echo site_url('superintendencia/index_add/'); ?>";

                request(urlRequest, formData, 'hide');
            });
            
            // HANDLER TO UPDATE A SUPERINTENDENCE
            $('#alterar').click(function () {

                var codigo = tableActive.getSelectedByIndex(0);

                var formData = {
                   id_super :  codigo,
                   operacao : 'update'
                };

                var urlRequest = "<?php echo site_url('superintendencia/index_update/'); ?>";

                request(urlRequest, formData, 'hide');       
            });
            
            // HANDLER TO DEACTIVATE A SUPERINTENDENCE
            $('#desativar').click(function () {
                $('#deactivate-dialog').dialogInit(function () {

                    var codigo = tableActive.getSelectedByIndex(0);

                    var formData = {
                       id_super : codigo
                    };

                    var urlRequest = "<?php echo site_url('superintendencia/deactivate/'); ?>";

                    request(urlRequest, formData);

                    return true;

                });
            });
            
            // HANDLER TO VIEW A PARTNER
            $('#visualizar').click(function () {  

                var codigo = tableActive.getSelectedByIndex(0);

                var formData = {
                   id_super : codigo,
                   operacao : 'view'
                };

                var urlRequest = "<?php echo site_url('superintendencia/index_update/'); ?>";

                request(urlRequest, formData, 'hide');
            }); 

            // HANDLER TO REACTIVATE A SUPERINTENDENCE
            $('#reativar').click(function () {
                $('#reactivate-dialog').dialogInit(function () {

                    var codigo = tableInactive.getSelectedByIndex(0);

                    var formData = {
                       id_super : codigo
                    };

                    var urlRequest = "<?php echo site_url('superintendencia/reactivate/'); ?>";

                    request(urlRequest, formData);

                    return true;

                });
            });

        // Navigation tabs
        $('#course-tab a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        });
    });
</script>

<ul class="nav nav-tabs" id="course-tab">
    <li class="active"><a href="#active">Ativos</a></li>
    <li><a href="#inactive">Inativos</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="active">

        <div id="grid">
            <ul id="active_super_controls" class="nav nav-pills buttons">        
                <li class="buttons"><button type="button" class="btn btn-primary" id="inserir">Inserir</button></li>
                <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="alterar">Alterar</button></li>
                <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="desativar">Desativar</button></li>
                <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="visualizar">Visualizar</button></li>
            </ul> 

            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="active_super_table">
                <thead>
                    <tr>
                        <th style="width:  50px"> ID </th>
                        <th style="width:  50px"> CÓDIGO </th>
                        <th style="width: 200px"> SUPERINTENDÊNCIA </th>
                        <th style="width: 290px"> RESPONSÁVEL </th>
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table>

            <div id="deactivate-dialog" name="deactivate-dialog" class="dialog" title="Confirmar desativa&ccedil;&atilde;o">
                <br />
                <h4>Deseja desativar o registro selecionado?</h4>
            </div>
        </div>
    </div>

    <div class="tab-pane" id="inactive">

        <div id="grid">
            <ul id="inactive_super_controls" class="nav nav-pills buttons">        
                <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="reativar">Reativar</button></li>
            </ul> 

            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="inactive_super_table">
                <thead>
                    <tr>
                        <th style="width:  50px"> ID </th>
                        <th style="width:  50px"> CÓDIGO </th>
                        <th style="width: 200px"> SUPERINTENDÊNCIA </th>
                        <th style="width: 290px"> RESPONSÁVEL </th>
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table>

            <div id="reactivate-dialog" name="reactivate-dialog" class="dialog" title="Confirmar reativa&ccedil;&atilde;o">
                <br />
                <h4>Deseja reativar o registro selecionado?</h4>
            </div>
        </div>
    </div>
</div>