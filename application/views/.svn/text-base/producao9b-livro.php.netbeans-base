<script type="text/javascript">    

    function initTables (value) {

        tableBook = new Table({
            url      : "<?php echo site_url('request/get_pesquisa_livro/"+value+"'); ?>",
            table    : $('#books_table'),
            controls : $('#books_controls')
        });

        tableCollection = new Table({
            url      : "<?php echo site_url('request/get_pesquisa_coletanea/"+value+"'); ?>",
            table    : $('#collections_table'),
            controls : $('#collections_controls')
        });

        tableBook.hideColumns([0]);
        tableCollection.hideColumns([0]);

        tableBook.disableControls();
        tableCollection.disableControls();
    }

    $(document).ready(function() {

        initTables("AN");

        $('#buttons').click(function (event) {

            if ( $(event.target).is( $(this) ) ) return;

            $(this).children().each(function () {

                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                }
            });

            $(event.target).addClass('active');

            initTables($(event.target).val());
            
        });

        // BOOK'S TABLE CONTROLS

            // HANDLER TO ADD A NEW BOOK
            $('#inserir_livro').click(function () {

                var formData = {
                   id_producao9b_livro : null,
                   operacao : 'add'
                };
                
                var urlRequest = "<?php echo site_url('producao9b_livro/index_add'); ?>";

                request(urlRequest, formData, 'hide');
            });
            
            // HANDLER TO UPDATE A BOOK
            $('#alterar_livro').click(function () { 

                var codigo = tableBook.getSelectedByIndex(0);//get_code();

                var formData = {
                   id_producao9b_livro :  codigo,
                   operacao : 'update'
                };

                var urlRequest = "<?php echo site_url('producao9b_livro/index_update'); ?>";

                request(urlRequest, formData, 'hide');   
            });
            
            // HANDLER TO REMOVE A BOOK
            $('#remover_livro').click(function () {  

                $('#books-dialog').dialogInit(function () {

                    var codigo = tableBook.getSelectedByIndex(0);

                    var formData = {
                       id_producao9b_livro : codigo
                    };

                    var urlRequest = "<?php echo site_url('producao9b_livro/remove/'); ?>";

                    request(urlRequest, formData);

                    return true;
                });
            });
            
            // HANDLER TO VIEW A BOOK
            $('#visualizar_livro').click(function () {  

                var codigo = tableBook.getSelectedByIndex(0);//get_code();

                var formData = {
                   id_producao9b_livro : codigo,
                   operacao : 'view'
                };

                var urlRequest = "<?php echo site_url('producao9b_livro/index_update'); ?>";

                request(urlRequest, formData, 'hide');   
            });

        // END OF BOOK'S TABLE CONTROLS

        // COLLECTION'S TABLE CONTROL

            // HANDLER TO ADD A NEW COLLECTION
            $('#inserir_coletanea').click(function () {

                var formData = {
                   id_producao9b_coletanea : null,
                   operacao : 'add'
                };
                
                var urlRequest = "<?php echo site_url('producao9b_col/index_add'); ?>";

                request(urlRequest, formData, 'hide');
            });
            
            // HANDLER TO UPDATE A COLLECTION
            $('#alterar_coletanea').click(function () { 

                var codigo = tableCollection.getSelectedByIndex(0);//get_code();

                var formData = {
                   id_producao9b_coletanea :  codigo,
                   operacao : 'update'
                };

                var urlRequest = "<?php echo site_url('producao9b_col/index_update'); ?>";

                request(urlRequest, formData, 'hide');   
            });
            
            // HANDLER TO REMOVE A COLLECTION
            $('#remover_coletanea').click(function () {  

                $('#collections-dialog').dialogInit(function () {

                    var codigo = tableCollection.getSelectedByIndex(0);

                    var formData = {
                       id_producao9b_coletanea : codigo
                    };

                    var urlRequest = "<?php echo site_url('producao9b_col/remove/'); ?>";

                    request(urlRequest, formData);

                    return true;
                });
            });
            
            // HANDLER TO VIEW A COLLECTION
            $('#visualizar_coletanea').click(function () {  

                var codigo = tableCollection.getSelectedByIndex(0);//get_code();

                var formData = {
                   id_producao9b_coletanea : codigo,
                   operacao : 'view'
                };

                var urlRequest = "<?php echo site_url('producao9b_col/index_update'); ?>";

                request(urlRequest, formData, 'hide');   
            });

        // END OF COLLECTION'S TABLE CONTROLS

        // Navigation tabs
        $('#production-tab a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        });

    });

</script>

<p id="buttons">
    <button type="button" class="btn btn-default active" value="AN">Em Andamento</button>
    <button type="button" class="btn btn-default" value="2P">II PNERA</button>
</p>

<br />

<ul class="nav nav-tabs" id="production-tab">
    <li class="active"><a href="#books">Livros</a></li>
    <li><a href="#collections">Coletâneas</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="books">

        <div id="grid">
            <ul id="books_controls" class="nav nav-pills buttons">        
                <li class="buttons"><button type="button" class="btn btn-primary" id="inserir_livro">Inserir</button></li>
                <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="alterar_livro">Alterar</button></li>
                <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="remover_livro">Remover</button></li>
                <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="visualizar_livro">Visualizar</button></li>
            </ul>

            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="books_table" style="width: 900px;"> 
                <thead>
                    <tr>
                        <th> ID </th>
                        <th width="620px;"> TÍTULO </th>
                        <th width="150px;"> EDITORA </th>
                        <th width=" 60px;"> ANO </th>
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table>

            <div id="books-dialog" name="books-dialog" class="dialog" title="Confirmar remo&ccedil;&atilde;o">
                <br />
                <h4>Deseja remover o registro selecionado?</h4>
            </div>
        </div>
    </div>

    <div class="tab-pane" id="collections">

        <div id="grid">
            <ul id="collections_controls" class="nav nav-pills buttons">        
                <li class="buttons"><button type="button" class="btn btn-primary" id="inserir_coletanea">Inserir</button></li>
                <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="alterar_coletanea">Alterar</button></li>
                <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="remover_coletanea">Remover</button></li>
                <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="visualizar_coletanea">Visualizar</button></li>
            </ul> 

            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="collections_table" style="width: 900px;">
                <thead>
                    <tr>
                        <th> ID </th>
                        <th width="600px"> TÍTULO </th>
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table>

            <div id="collections-dialog" name="collections-dialog" class="dialog" title="Confirmar remo&ccedil;&atilde;o">
                <br />
                <h4>Deseja remover o registro selecionado?</h4>
            </div>
        </div>
    </div>

</div>