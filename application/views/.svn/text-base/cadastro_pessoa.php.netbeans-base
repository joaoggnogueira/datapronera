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
            url      : "<?php echo site_url('request/get_pessoa_cadastro/A'); ?>",
            table    : $('#active_users_table'),
            controls : $('#active_users_controls')
        });

        var tableInactive = new Table({
            url      : "<?php echo site_url('request/get_pessoa_cadastro/I'); ?>",
            table    : $('#inactive_users_table'),
            controls : $('#inactive_users_controls')
        });

        tableActive.hideColumns([0]);
        tableInactive.hideColumns([0]);

        /* Add a click handler to select the rows 
        $("#pessoas_table tbody").click(function(event) {
            $(oTable.fnSettings().aoData).each(function (){
                $(this.nTr).removeClass('active');
            });
            $(event.target.parentNode).addClass('active');
        });
        
        /* Init the table 
        oTable = $('#pessoas_table').dataTable( {
                "bProcessing": true,
                "sPaginationType": "bootstrap",
                "sAjaxSource": url  + "request/get_pessoa_cadastro/"
            } );
        oTable.fnSetColumnVis( 0, false );*/

        // TABLE CONTROLS

            // HANDLER TO ADD A NEW USER
            $('#inserir').click(function () {

                var formData = {
                   id_pessoa : 0,
                   operacao : 'add'
                };
                
                var urlRequest = "<?php echo site_url('pessoa/index_add'); ?>";

                request(urlRequest, formData, 'hide');
            });
            
            // HANDLER TO UPDATE A USER
            $('#alterar').click(function () { 

                codigo = tableActive.getSelectedByIndex(0);

                var formData = {
                   id_pessoa :  codigo,
                   operacao : 'update'
                };

                var urlRequest = "<?php echo site_url('pessoa/index_update'); ?>";

                request(urlRequest, formData, 'hide');
            });
            
            // HANDLER TO REMOVE A USER
            $('#desativar').click(function () { 
                $('#deactivate-dialog').dialogInit(function () {

                    codigo = tableActive.getSelectedByIndex(0);

                    var formData = {
                       id_pessoa : codigo
                    };

                    var urlRequest = "<?php echo site_url('pessoa/deactivate/'); ?>";

                    request(urlRequest, formData);

                    return true;

                });                
            });

            // HANDLER TO VISUALIZE A USER
            $('#visualizar').click(function () { 

                codigo = tableActive.getSelectedByIndex(0);

                var formData = {
                   id_pessoa :  codigo,
                   operacao : 'view'
                };

                var urlRequest = "<?php echo site_url('pessoa/index_update'); ?>";

                request(urlRequest, formData, 'hide');
            });

            // HANDLER TO REACTIVATE A USER
            $('#reativar').click(function () { 
                $('#reactivate-dialog').dialogInit(function () {

                    codigo = tableInactive.getSelectedByIndex(0);

                    var formData = {
                       id_pessoa : codigo
                    };

                    var urlRequest = "<?php echo site_url('pessoa/reactivate/'); ?>";

                    request(urlRequest, formData);

                    return true;

                });                
            });

            // HANDLER TO REMOVE A USER
            $('#resetar_senha').click(function () { 
                $('#reset-pass-dialog').dialogInit(function () {

                    codigo = tableActive.getSelectedByIndex(1);

                    var formData = {
                       cpf : codigo
                    };

                    var urlRequest = "<?php echo site_url('pessoa/reset_password/'); ?>";

                    request(urlRequest, formData);

                    return true;

                });                
            });


        // Navigation tabs
        $('#user-tab a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        });
    });

    /*function get_code(){      
        var anSelected = fnGetSelected( oTable );
        var data = oTable.fnGetData( anSelected[0]);
        return data[0];
    }


    /* Get the rows which are currently selected 
    function fnGetSelected( oTableLocal ) {

        var aReturn = new Array();
        var aTrs = oTableLocal.fnGetNodes();
        
        for ( var i=0 ; i<aTrs.length ; i++ ) {
            if ( $(aTrs[i]).hasClass('active') ) {
                aReturn.push( aTrs[i] );
                i = aTrs.length + 1;
            }
        }
        return aReturn;
    }*/
</script>

<ul class="nav nav-tabs" id="user-tab">
    <li class="active"><a href="#active">Ativos</a></li>
    <li><a href="#inactive">Inativos</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="active">

        <div id="grid">
            <ul id="active_users_controls" class="nav nav-pills buttons">        
                <li class="buttons"><button type="button" class="btn btn-primary" id="inserir">Inserir</button></li>
                <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="alterar">Alterar</button></li>
                <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="desativar">Desativar</button></li>
                <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="visualizar">Visualizar</button></li>

                <?php 

                    // ADMINISTRADOR
                    if ($this->session->userdata('access_level') > 4) {

                        echo '<li class="buttons">
                                <button type="button" class="btn btn-success btn-disabled disabled" id="resetar_senha">Resetar Senha</button>
                              </li>';
                    }
                ?>
            </ul> 

            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="active_users_table">
                <thead>
                    <tr>
                        <th width= "10px"> ID </th>
                        <th width= "120px"> CPF </th>
                        <th width= "350px"> NOME </th>
                        <th width= "150px"> RG </th>
                        <th width= "190px"> FUNÇÃO </th>
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table>

            <div id="deactivate-dialog" name="deactivate-dialog" class="dialog" title="Confirmar desativa&ccedil;&atilde;o">
                <br />
                <h4>Deseja desativar o registro selecionado?</h4>
            </div>
            <div id="reset-pass-dialog" name="reset-pass-dialog" class="dialog" title="Confirmar desativa&ccedil;&atilde;o">
                <br />
                <h4>Deseja resetar a senha do usuário selecionado?</h4>
            </div>
        </div>

    </div>

    <div class="tab-pane" id="inactive">

        <div id="grid">            
            <ul id="inactive_users_controls" class="nav nav-pills buttons">        
                <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="reativar">Reativar</button></li>
            </ul> 

            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="inactive_users_table">
                <thead>
                    <tr>
                        <th width= "10px"> ID </th>
                        <th width= "120px"> CPF </th>
                        <th width= "350px"> NOME </th>
                        <th width= "150px"> RG </th>
                        <th width= "190px"> FUNÇÃO </th>
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