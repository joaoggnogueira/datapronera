<script type="text/javascript">    

    //var oTable;

    $(document).ready(function() {

        var table = new Table({
            url      : "<?php echo site_url('request/get_educando'); ?>",
            table    : $('#students_table'),
            controls : $('#students_controls')
        });

        table.hideColumns([0]);
        
        $("#export").click(function(){
            var url = "<?php echo site_url('relatorio_dinamico') . '/'; ?>";
           $('<form target="_blank" action="' + url + 'gerarRelatorio" method="POST">' +
                    "<textarea name='format'>XLSX</textarea>" +
                    "<textarea name='curso'><?= $this->session->userdata('id_curso') ?></textarea>" +
                    "<textarea name='check_educando'>true</textarea>" +
                "</form>").appendTo('body').submit().remove(); 
        });
        
        //$('#educando_table').tableInit(url);
        //$('#educando_table').hideColumns([0]);
        /*var url="<?php echo site_url(''); ?>/";

        
        /* Init the table 
        oTable = $('#educando_table').dataTable( {
                "bProcessing": true,
                "sPaginationType": "bootstrap",
                "sAjaxSource": url  + "/request/get_educando/"
            } );


        /* Add a click handler to select the rows 
        $("#educando_table tbody").click(function(event) {
            $(oTable.fnSettings().aoData).each(function (){
                $(this.nTr).removeClass('active');
            });
            $(event.target.parentNode).addClass('active');
        });*/

        // TABLE CONTROLS

            // HANDLER TO ADD A NEW PARTNER
            $('#inserir').click(function () {

                var formData = {
                   id_educando : null,
                   operacao : 'add'
                };

                var urlRequest = "<?php echo site_url('educando/index_add/'); ?>";

                request(urlRequest, formData, 'hide');
            });
            
            // HANDLER TO UPDATE A PARTNER
            $('#alterar').click(function () { 
                var codigo = table.getSelectedByIndex(0);

                var formData = {
                   id_educando :  codigo,
                   operacao : 'update'
                };

                var urlRequest = "<?php echo site_url('educando/index_update/'); ?>";

                request(urlRequest, formData, 'hide');
            });
            
            // HANDLER TO REMOVE A PARTNER
            $('#remover').click(function () {  
                $('#dialog').dialogInit(function () {
                    var codigo = table.getSelectedByIndex(0);

                    var formData = {
                       id_educando : codigo
                    };

                    var urlRequest = "<?php echo site_url('educando/remove/'); ?>";

                    request(urlRequest, formData);

                    return true;
                });
            });
            
            // HANDLER TO VIEW A PARTNER
            $('#visualizar').click(function () {  
                var codigo = table.getSelectedByIndex(0);

                var formData = {
                   id_educando :  codigo,
                   operacao : 'view'
                };

                var urlRequest = "<?php echo site_url('educando/index_update/'); ?>";

                request(urlRequest, formData, 'hide');
            });

        // END OF TABLE CONTROLS

        //oTable.fnSetColumnVis( 0, false );
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

<div id="grid">
    <ul id="students_controls" class="nav nav-pills buttons">  
    <?php if ($this->session->userdata('status_curso') != '2P' && $this->session->userdata('status_curso') != 'CC') { ?>
        <li class=buttons"><button type="button" class="btn btn-primary" id="inserir">Inserir</button></li>
        <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="alterar">Alterar</button></li>
        <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="remover">Remover</button></li>
    <?php } ?>
        <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="visualizar">Visualizar</button></li>
        <li class="buttons" style="float: right"><button type="button" class="btn btn-success" id="export">Exportar XSLX</button></li>
    </ul>    
    
    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="students_table">
        <thead>
            <tr>
                <th width="  0px;"> CÓDIGO </th>
                <th width="250px;"> EDUCANDO </th>
                <th width="120px;"> MUNICÍPIO </th>
                <th width="120px;"> DATA NASC. </th>
                <th width="200px;"> NOME DO TERRITÓRIO </th>
            </tr>
        </thead>

        <tbody>
        </tbody>
    </table>

    <div id="dialog" class="dialog" title="Confirmar remo&ccedil;&atilde;o">
        <br />
        <h4>Deseja remover o registro selecionado?</h4>
    </div>
</div>