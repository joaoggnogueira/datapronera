
<script type="text/javascript">    

    //var oTable;

    $(document).ready(function () {

        var table = new Table({
            url      : "<?php echo site_url('request/get_professor'); ?>",
            table    : $('#professor_table'),
            controls : $('#professor_controls')
        });

        table.hideColumns([0]);

        //TABLE CONTROLS

            // HANDLER TO ADD A NEW PARTNER
            $('#inserir').click(function () {

                var formData = {
                   id_professor : null,
                   operacao : 'add'
                };

                var urlRequest = "<?php echo site_url('professor/index_add/'); ?>";

                request(urlRequest, formData, 'hide');
            });
            
            // HANDLER TO UPDATE A PARTNER
            $('#alterar').click(function () { 
                codigo = table.getSelectedByIndex(0);

                var formData = {
                   id_professor : codigo,
                   operacao : 'update'
                };

                var urlRequest = "<?php echo site_url('professor/index_update/'); ?>";

                request(urlRequest, formData, 'hide');
            });
            
            // HANDLER TO REMOVE A PARTNER
            $('#remover').click(function () {
                $('#dialog').dialogInit(function () {
                    codigo = table.getSelectedByIndex(0);

                    var formData = {
                       id_professor : codigo
                    };

                    var urlRequest = "<?php echo site_url('professor/remove/'); ?>";

                    request(urlRequest, formData);

                    return true;
                });
            });
            
            // HANDLER TO VIEW A PARTNER
            $('#visualizar').click(function () {  
                codigo = table.getSelectedByIndex(0);

                var formData = {
                   id_professor :  codigo,
                   operacao : 'view'
                };

                var urlRequest = "<?php echo site_url('professor/index_update/'); ?>";

                request(urlRequest, formData, 'hide');
            });

        // END OF TABLE CONTROLS

        //oTable.fnSetColumnVis( 0, false );
    });

    /*function get_code(){      
        var anSelected = fnGetSelected( oTable );
        var data = oTable.fnGetData( anSelected[0]);
        return data[0];
    }*/

</script>

<div id="grid">
    <ul id="professor_controls" class="nav nav-pills buttons">        
    <?php if ($this->session->userdata('status_curso') != '2P' && $this->session->userdata('status_curso') != 'CC') { ?>
        <li class+"buttons"><button type="button" class="btn btn-primary" id="inserir">Inserir</button></li>
        <li class+"buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="alterar">Alterar</button></li>
        <li class+"buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="remover">Remover</button></li>
    <?php } ?>
        <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="visualizar">Visualizar</button></li>
    </ul>    

    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="professor_table">
        <thead>
            <tr>
                <th style="width:  10px;"> CÓDIGO </th>
                <th style="width: 350px;"> PROFESSOR </th>
                <th style="width: 180px;"> GÊNERO </th>
                <th style="width: 200px;"> TITULAÇÃO </th>
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