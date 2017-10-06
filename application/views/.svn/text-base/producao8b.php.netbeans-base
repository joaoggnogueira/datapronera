<script type="text/javascript">
    //var oTable;

    $(document).ready(function() {

        var table = new Table({
            url      : "<?php echo site_url('request/get_producao8b'); ?>",
            table    : $('#paper_table'),
            controls : $('#paper_controls')
        });

        table.hideColumns([0]);

        //$('#producao_table').tableInit(url);
        //$('#producao_table').hideColumns([0]);

        /* Init the table 
        oTable = $('#producao_table').dataTable( {
                "bProcessing": true,
                "sPaginationType": "bootstrap",
                "sAjaxSource": url  + "/request/get_producao8b/"
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
                   id_producao8b : null,
                   operacao : 'add'
                };
                
                var urlRequest = "<?php echo site_url('producao8b/index_add'); ?>";

                request(urlRequest, formData, 'hide');
            });
            
            // HANDLER TO UPDATE A producao
            $('#alterar').click(function () { 

                codigo = table.getSelectedByIndex(0);//get_code();

                var formData = {
                   id_producao8b :  codigo,
                   operacao : 'update'
                };

                var urlRequest = "<?php echo site_url('producao8b/index_update'); ?>";

                request(urlRequest, formData, 'hide');   
            });
            
            // HANDLER TO REMOVE A producao
            $('#remover').click(function () {  

                $('#dialog').dialogInit(function () {

                    var codigo = table.getSelectedByIndex(0);

                    var formData = {
                       id_producao8b : codigo
                    };

                    var urlRequest = "<?php echo site_url('producao8b/remove/'); ?>";

                    request(urlRequest, formData);

                    return true;
                });
            });
            
            // HANDLER TO VIEW A producao
            $('#visualizar').click(function () {  

                codigo = table.getSelectedByIndex(0);//get_code();

                var formData = {
                   id_producao8b : codigo,
                   operacao : 'view'
                };

                var urlRequest = "<?php echo site_url('producao8b/index_update'); ?>";

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
    <ul id="paper_controls" class="nav nav-pills buttons">        
    <?php if ($this->session->userdata('status_curso') != '2P' && $this->session->userdata('status_curso') != 'CC') { ?>
        <li class+"buttons"><button type="button" class="btn btn-primary" id="inserir">Inserir</button></li>
        <li class+"buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="alterar">Alterar</button></li>
        <li class+"buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="remover">Remover</button></li>
    <?php } ?>
        <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="visualizar">Visualizar</button></li>
    </ul>    

    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="paper_table">
        <thead>
            <tr>
                <th width="10px; " > CÓDIGO </th>
                <th width="650px"> TÍTULO </th>
                <th width="60px">  ANO </th>
            </tr>
        </thead>

        <tbody>
        </tbody>
    </table>
    
    <div id="dialog" name="dialog" class="dialog" title="Confirmar remo&ccedil;&atilde;o">
        <br />
        <h4>Deseja remover o registro selecionado?</h4>
    </div>
</div>