<script type="text/javascript">    

    //var oTable;

    $(document).ready(function() {

        var table = new Table({
            url      : "<?php echo site_url('request/get_producao8a'); ?>",
            table    : $('#paper_table'),
            controls : $('#paper_controls')
        });

        table.hideColumns([0]);

        //TABLE CONTROLS

            // HANDLER TO ADD A NEW producao
            $('#inserir').click(function () {

                var formData = {
                   id_producao8a : null,
                   operacao : 'add'
                };
                
                var urlRequest = "<?php echo site_url('producao8a/index_add'); ?>";

                request(urlRequest, formData, 'hide');
            });
            
            // HANDLER TO UPDATE A producao
            $('#alterar').click(function () { 

                codigo = table.getSelectedByIndex(0);//get_code();

                var formData = {
                   id_producao8a :  codigo,
                   operacao : 'update'
                };

                var urlRequest = "<?php echo site_url('producao8a/index_update'); ?>";

                request(urlRequest, formData, 'hide');   
            });
            
            // HANDLER TO REMOVE A producao
            $('#remover').click(function () {  

                $('#dialog').dialogInit(function () {

                    var codigo = table.getSelectedByIndex(0);

                    var formData = {
                       id_producao8a : codigo
                    };

                    var urlRequest = "<?php echo site_url('producao8a/remove/'); ?>";

                    request(urlRequest, formData);

                    return true;
                });
            });
            
            // HANDLER TO VIEW A producao
            $('#visualizar').click(function () {  

                codigo = table.getSelectedByIndex(0);//get_code();

                var formData = {
                   id_producao8a : codigo,
                   operacao : 'view'
                };

                var urlRequest = "<?php echo site_url('producao8a/index_update'); ?>";

                request(urlRequest, formData, 'hide');   
            });

        // END OF TABLE CONTROLS
    });

</script>
<h2>Produções/Pesquisas sobre o Pronera</h2>
<h4>8A - Geral</h4>
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
                <th width=" 10px;"> CÓDIGO </th>
                <th width="450px;"> TÍTULO </th>
                <th width="250px;"> NATUREZA </th>
                <th width="130px;"> ANO </th>
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