<script type="text/javascript">

    $(document).ready(function() {

        var tableRunning = new Table({
            url      : "<?php echo site_url('request/get_pesquisa_evento/AN'); ?>",
            table    : $('#running-table'),
            controls : $('#running-controls')
        });

        tableRunning.hideColumns([0]);

        //TABLE CONTROLS

            // HANDLER TO ADD A NEW producao
            $('#running-add').click(function () {

                var formData = {
                   id_producao9g : null,
                   operacao : 'add'
                };
                
                var urlRequest = "<?php echo site_url('producao9g/index_add'); ?>";

                request(urlRequest, formData, 'hide');
            });
            
            // HANDLER TO UPDATE A producao
            $('#running-update').click(function () { 

                var codigo = tableRunning.getSelectedByIndex(0);//get_code();

                var formData = {
                   id_producao9g :  codigo,
                   operacao : 'update'
                };

                var urlRequest = "<?php echo site_url('producao9g/index_update'); ?>";

                request(urlRequest, formData, 'hide');   
            });
            
            // HANDLER TO REMOVE A producao
            $('#running-delete').click(function () {  

                $('#running-dialog').dialogInit(function () {

                    var codigo = tableRunning.getSelectedByIndex(0);

                    var formData = {
                       id_producao9g : codigo
                    };

                    var urlRequest = "<?php echo site_url('producao9g/remove/'); ?>";

                    request(urlRequest, formData);

                    return true;
                });
            });
            
            // HANDLER TO VIEW A producao
            $('#running-view').click(function () {  

                var codigo = tableRunning.getSelectedByIndex(0);//get_code();

                var formData = {
                   id_producao9g : codigo,
                   operacao : 'view'
                };

                var urlRequest = "<?php echo site_url('producao9g/index_update'); ?>";

                request(urlRequest, formData, 'hide');   
            });

        // END OF TABLE CONTROLS

        var tableIIPnera = new Table({
            url      : "<?php echo site_url('request/get_pesquisa_evento/2P'); ?>",
            table    : $('#ii-pnera-table'),
            controls : $('#ii-pnera-controls')
        });

        tableIIPnera.hideColumns([0]);

        //TABLE CONTROLS

            /* HANDLER TO ADD A NEW producao
            $('#ii-pnera-add').click(function () {

                var formData = {
                   id_producao9g : null,
                   operacao : 'add'
                };
                
                var urlRequest = "<?php echo site_url('producao9g/index_add'); ?>";

                request(urlRequest, formData, 'hide');
            });
            
            // HANDLER TO UPDATE A producao
            $('#ii-pnera-update').click(function () { 

                var codigo = tableIIPnera.getSelectedByIndex(0);//get_code();

                var formData = {
                   id_producao9g :  codigo,
                   operacao : 'update'
                };

                var urlRequest = "<?php echo site_url('producao9g/index_update'); ?>";

                request(urlRequest, formData, 'hide');   
            });
            
            // HANDLER TO REMOVE A producao
            $('#ii-pnera-delete').click(function () {  

                $('#ii-pnera-dialog').dialogInit(function () {

                    var codigo = tableIIPnera.getSelectedByIndex(0);

                    var formData = {
                       id_producao9g : codigo
                    };

                    var urlRequest = "<?php echo site_url('producao9g/remove/'); ?>";

                    request(urlRequest, formData);

                    return true;
                });
            });*/
            
            // HANDLER TO VIEW A producao
            $('#ii-pnera-view').click(function () {  

                var codigo = tableIIPnera.getSelectedByIndex(0);//get_code();

                var formData = {
                   id_producao9g : codigo,
                   operacao : 'view'
                };

                var urlRequest = "<?php echo site_url('producao9g/index_update'); ?>";

                request(urlRequest, formData, 'hide');   
            });

        // END OF TABLE CONTROLS

        // Navigation tabs
        $('#paper-tab a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        });

    });

</script>

<ul class="nav nav-tabs" id="paper-tab">
    <li class="active"><a href="#running">Em andamento</a></li>
    <li><a href="#ii-pnera">II PNERA</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="running">

        <div id="grid">
            <ul id="running-controls" class="nav nav-pills buttons">        
                <li class="buttons"><button type="button" class="btn btn-primary" id="running-add">Inserir</button></li>
                <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="running-update">Alterar</button></li>
                <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="running-delete">Remover</button></li>
                <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="running-view">Visualizar</button></li>
            </ul>    

            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="running-table">
                <thead>
                    <tr>
                        <th width=" 10px;"> CÓDIGO </th>
                        <th width="620px;"> TÍTULO </th>
                        <th width="150px;"> ABRANGÊNCIA </th>
                        <th width=" 60px;"> DATA </th>
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table>

            <div id="running-dialog" name="running-dialog" class="dialog" title="Confirmar remo&ccedil;&atilde;o">
                <br />
                <h4>Deseja remover o registro selecionado?</h4>
            </div>
        </div>

    </div>

    <div class="tab-pane" id="ii-pnera">

        <div id="grid">
            <ul id="ii-pnera-controls" class="nav nav-pills buttons">        
                <!--<li class="buttons"><button type="button" class="btn btn-primary" id="ii-pnera-add">Inserir</button></li>
                <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="ii-pnera-update">Alterar</button></li>
                <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="ii-pnera-delete">Remover</button></li>-->
                <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="ii-pnera-view">Visualizar</button></li>
            </ul>    

            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="ii-pnera-table">
                <thead>
                    <tr>
                        <th width=" 10px;"> CÓDIGO </th>
                        <th width="620px;"> TÍTULO </th>
                        <th width="150px;"> ABRANGÊNCIA </th>
                        <th width=" 60px;"> DATA </th>
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table>

            <div id="ii-pnera-dialog" name="ii-pnera-dialog" class="dialog" title="Confirmar remo&ccedil;&atilde;o">
                <br />
                <h4>Deseja remover o registro selecionado?</h4>
            </div>
        </div>

    </div>
</div>