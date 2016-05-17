<?php

    if (! defined('BASEPATH')) {
        exit('No direct script access allowed');

    } else if (! $this->system->is_logged_in()) {
        echo index_page();        
    }
    
?>

<script type="text/javascript">

    //var oTable;

    $(document).ready(function() {

        var tableActive = new Table({
            url      : "<?php echo site_url('request/get_curso_cadastro/A'); ?>",
            table    : $('#active_courses_table'),
            controls : $('#active_courses_controls')
        });

        var tableInactive = new Table({
            url      : "<?php echo site_url('request/get_curso_cadastro/I'); ?>",
            table    : $('#inactive_courses_table'),
            controls : $('#inactive_courses_controls')
        });

        tableActive.hideColumns([0]);
        tableInactive.hideColumns([0]);

        //TABLE CONTROLS

            // HANDLER TO ADD A NEW COURSE
            $('#inserir').click(function () {

                var formData = {
                   id_curso : null,
                   operacao : 'add'
                };

                var urlRequest = "<?php echo site_url('curso/index_add/'); ?>";

                request(urlRequest, formData, 'hide');

            });
            
            // HANDLER TO UPDATE A COURSE
            $('#alterar').click(function () { 

                var codigo = tableActive.getSelectedByIndex(0);

                var formData = {
                   id_curso :  codigo,
                   operacao : 'update'
                };

                var urlRequest = "<?php echo site_url('curso/index_update/'); ?>";

                request(urlRequest, formData, 'hide');
            });
            
            // HANDLER TO DEACTIVATE A COURSE
            $('#desativar').click(function () {
                 $('#deactivate-dialog').dialogInit(function () {

                    var codigo = tableActive.getSelectedByIndex(0);

                    var formData = {
                       id_curso :  codigo
                    };

                    var urlRequest = "<?php echo site_url('curso/deactivate/'); ?>";

                    request(urlRequest, formData);

                    return true;
                });
            });

            // HANDLER TO VIEW A COURSE
            $('#visualizar').click(function () {  

                var codigo = tableActive.getSelectedByIndex(0);

                var formData = {
                   id_curso :  codigo,
                   operacao : 'view'
                };

                var urlRequest = "<?php echo site_url('curso/index_update/'); ?>";

                request(urlRequest, formData, 'hide');
            });

            // HANDLER TO REACTIVATE A COURSE
            $('#reativar').click(function () {
                 $('#reactivate-dialog').dialogInit(function () {

                    codigo = tableInactive.getSelectedByIndex(0);

                    var formData = {
                       id_curso :  codigo
                    };

                    var urlRequest = "<?php echo site_url('curso/reactivate/'); ?>";

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
            <ul id="active_courses_controls" class="nav nav-pills buttons">        
                <li class="buttons"><button type="button" class="btn btn-primary" id="inserir">Inserir</button></li>
                <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="alterar">Alterar</button></li>
                <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="desativar">Desativar</button></li>
                <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="visualizar">Visualizar</button></li>
            </ul>

            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="active_courses_table"> 
                <thead>
                    <tr>
                        <th width=" 50px"> ID </th>
                        <th width=" 50px"> CÓDIGO </th>
                        <th width="350px"> CURSO </th>
                        <th width="200px"> SUPERINTENDÊNCIA </th>
                        <th width="290px"> RESPONSÁVEL </th>
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
            <ul id="inactive_courses_controls" class="nav nav-pills buttons">        
                <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="reativar">Reativar</button></li>
            </ul> 

            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="inactive_courses_table">
                <thead>
                    <tr>
                        <th width=" 50px"> ID </th>
                        <th width=" 50px"> CÓDIGO </th>
                        <th width="350px"> CURSO </th>
                        <th width="200px"> SUPERINTENDENCIA </th>
                        <th width="290px"> RESPONSÁVEL </th>
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