<script type="text/javascript">    

    var oTable;

    $(document).ready(function() {
        
       // Exibe mensagem de processamento
        processMessage('status');

        // Faz requisição de login ao servidor (retorna um objeto JSON)
        $.ajax({

            url : "<?php echo site_url('instituicao/index/'); ?>",
            type : 'POST',
            dataType : 'json',
            data : '',
            timeout : 5000,

            success : function (data) {

                // Login autorizado
                if (data.success) {
                    hideMessage('status'); // Esconde mensagem de processamento

                    $('#content').html(data.message.content); // Carrega conteúdo da nova view
                    $('#top_menu').html(data.message.top_menu);   // Carrega conteúdo do menu

                // Login não autorizado
                } else {
                    showMessage('status', data); // Exibe mensagem de erro
                }
            },

            error : function (data) {

                // Falha na requisição
                var error = {
                    'success' : false,
                    'message' : 'Falha na requisição. Tente novamente em instantes.'
                };

                showMessage('status', error); // Exibe mensagem de erro
            }

        }); 
      

    } );

</script>