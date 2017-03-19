<script type="text/javascript">    

    //var oTable;

    $(document).ready(function() {

        var table = new Table({
            url      : "<?php echo site_url('request/get_fiscalizacao'); ?>",
            table    : $('#fiscalizacao_table'),
            controls : $('#fiscalizacao_controls')
        });

        table.hideColumns([0]);

        //TABLE CONTROLS

            // HANDLER TO ADD A NEW PARTNER
            $('#inserir').click(function () {

                var formData = {
                   id_fiscalizacao : null,
                   operacao : 'add'
                };

                var urlRequest = "<?php echo site_url('fiscalizacao/index_add/'); ?>";

                request(urlRequest, formData, 'hide');
            });
            
            // HANDLER TO UPDATE A PARTNER
            $('#alterar').click(function () { 

                codigo = table.getSelectedByIndex(0);

                var formData = {
                   id_fiscalizacao :  codigo,
                   operacao : 'update'
                };

                var urlRequest = "<?php echo site_url('fiscalizacao/index_update/'); ?>";

                request(urlRequest, formData, 'hide');   
            });
            
             // HANDLER TO REMOVE A PARTNER
            $('#remover').click(function () {
                $('#dialog').dialogInit(function () {
                    codigo = table.getSelectedByIndex(0);

                    var formData = {
                       id_fiscalizacao : codigo
                    };

                    var urlRequest = "<?php echo site_url('fiscalizacao/remove/'); ?>";

                    request(urlRequest, formData);

                    return true;
                });
            });
            
            // HANDLER TO VIEW A PARTNER
            $('#visualizar').click(function () {  

                codigo = table.getSelectedByIndex(0);

                var formData = {
                   id_fiscalizacao :  codigo,
                   operacao : 'view'
                };

               var urlRequest = "<?php echo site_url('fiscalizacao/index_update/'); ?>";

                request(urlRequest, formData, 'hide');
            });

    });


</script>

<div id="grid">
    <ul id="fiscalizacao_controls" class="nav nav-pills buttons">        
    <?php if ($this->session->userdata('status_curso') != '2P' && $this->session->userdata('status_curso') != 'CC') { ?>
        <li class="buttons"><button type="button" class="btn btn-primary" id="inserir">Inserir</button></li>
        <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="alterar">Alterar</button></li>
        <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="remover">Remover</button></li>
    <?php } ?>
        <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="visualizar">Visualizar</button></li>
    </ul>    

    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="fiscalizacao_table">
        <thead>
            <tr>
                <th width=  "10px;"> CÓDIGO </th>
                <th width= "380px"> TITULO </th>
                <th width= "140px"> DATA </th>
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