<script type="text/javascript">    

    //var oTable;

    $(document).ready(function() { 
        var url = "<?php echo site_url('request/get_pesquisa_coletanea'); ?>";

        var tableElem = $('#producao_table');

        var table = new Table(tableElem, url);

        table.hideColumns([0]);

        
        /* Init the table 
        oTable = $('#producao_table').dataTable( {
                "bProcessing": true,
                "sPaginationType": "bootstrap",
                "sAjaxSource": url  + "/request/get_pesquisa_coletanea/"
            } );


        /* Add a click handler to select the rows 
        $("#producao_table tbody").click(function(event) {
            $(oTable.fnSettings().aoData).each(function (){
                $(this.nTr).removeClass('active');
            });
            $(event.target.parentNode).addClass('active');
        });*/

        //TABLE CONTROLS

            // HANDLER TO ADD A NEW producao
            $('#inserir').click(function () {

                var formData = {
                   id_producao9b_coletanea : null,
                   operacao : 'add'
                };
                
                var urlRequest = "<?php echo site_url('producao9b_col/index_add'); ?>";

                request(urlRequest, formData, 'hide');
            });
            
            // HANDLER TO UPDATE A producao
            $('#alterar').click(function () { 

                var codigo = table.getSelectedByIndex(0);//get_code();

                var formData = {
                   id_producao9b_coletanea :  codigo,
                   operacao : 'update'
                };

                var urlRequest = "<?php echo site_url('producao9b_col/index_update'); ?>";

                request(urlRequest, formData, 'hide');   
            });
            
            // HANDLER TO REMOVE A producao
            $('#remover').click(function () {  

                $('#dialog').dialogInit(function () {

                    var codigo = table.getSelectedByIndex(0);

                    var formData = {
                       id_producao9b_coletanea : codigo
                    };

                    var urlRequest = "<?php echo site_url('producao9b_col/remove/'); ?>";

                    request(urlRequest, formData);

                    return true;
                });
            });
            
            // HANDLER TO VIEW A producao
            $('#visualizar').click(function () {  

                var codigo = table.getSelectedByIndex(0);//get_code();

                var formData = {
                   id_producao9b_coletanea : codigo,
                   operacao : 'view'
                };

                var urlRequest = "<?php echo site_url('producao9b_col/index_update'); ?>";

                request(urlRequest, formData, 'hide');   
            });

        // END OF TABLE CONTROLS

        //oTable.fnSetColumnVis( 0, false );
    });

    /*
    function get_code(){      
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

<div id="grid">
    <ul id="botoes" class="nav nav-pills">        
        <li style="float:left;margin-left: 3px;"><button type="button" class="btn btn-primary" id="inserir">Inserir</button></li>
        <li style="float:left;margin-left: 3px;"><button type="button" class="btn btn-primary" id="alterar">Alterar</button></li>
        <li style="float:left;margin-left: 3px;"><button type="button" class="btn btn-primary" id="remover">Remover</button></li>
        <li style="float:left;margin-left: 13px;"><button type="button" class="btn btn-primary" id="visualizar">Visualizar</button></li>
    </ul>    

    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="producao_table">
        <thead>
            <tr>
                <th width="10px; " > CÓDIGO </th>
                <th width="700px"> TÍTULO </th>
            </tr>
        </thead>

        <tbody>
        </tbody>
    </table>
</div>