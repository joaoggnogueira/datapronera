            assentamentos = $.unique(assentamentos);

        //ORDENA JSON DOS ASSENTAMENTOS
        function sortJSON(data, key, way) {
            return data.sort(function(a, b) {
                var x = a[key]; var y = b[key];
                if (way === '123' ) { return ((x < y) ? -1 : ((x > y) ? 1 : 0)); }
                if (way === '321') { return ((x > y) ? -1 : ((x < y) ? 1 : 0)); }
            });
        }
        assentamentos = sortJSON(assentamentos,'Nome', '123'); // 123 or 321
        var nome_assentamentos = '';
        $.each( assentamentos, function( key, value ) {
          nome_assentamentos  += '<option value="'+assentamentos[key].Nome+'">'+assentamentos[key].Nome+'</option>';
        });
        //CASO FOR ASSENTAMENTO, CRIA SELECTBOX
        $( "#educando_tipo_terr" ).change(function() {
            console.log(assentamentos);
            if($(this).val() == "ASSENTAMENTO"){
                $("#educando_nome_terr").remove();
                $("#educando_territorio").append(
                    $('<select class="form-control" name="educando_nome_terr" id="educando_nome_terr">')
                        .append('<option selected disabled value="">Selecione</option>')
                        .append(nome_assentamentos)
                )
                $('#educando_nome_terr').select2();
            }else{
                $("#educando_nome_terr").select2('destroy'); 
                $("#educando_nome_terr").remove();
                $("#educando_territorio").append('<input type="text" class="form-control tamanho-n" id="educando_nome_terr" name="educando_nome_terr">')
            }
        });
        //ATUALIZA ASSENTAMENTOS CONFORME ESTADO
        $( "#educando_sel_est" ).change(function() {
            var urlAssentamentos = "http://pronera.incra.gov.br/datapronera/index.php/requisicao/get_assentamentos/" + $('#educando_sel_est option:selected').text();
            if($("#educando_tipo_terr").val() == "ASSENTAMENTO"){
                $.get(urlAssentamentos, function(assentamentos) {
                    $("#educando_nome_terr").select2('destroy');
                    $("#educando_nome_terr").remove();
                    $("#educando_territorio").append(
                        $('<select class="form-control" name="educando_nome_terr" id="educando_nome_terr">')
                            .append('<option selected disabled value="">Selecione</option>')
                            .append(assentamentos)
                    )
                    $('#educando_nome_terr').select2();
                });
            }
        });