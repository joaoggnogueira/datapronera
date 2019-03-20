<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
} else if (!$this->system->is_logged_in()) {
    echo index_page();
}
?>
<style>
    .row_checkbox{
        display: flex;
        flex-direction: row;
        align-items: center;
    }
    .row_checkbox label{
        margin-left: 10px;
        display: flex;
        flex-direction: column;
    }
    .row_checkbox:hover label{
        color: #003bb3;
    }
    .check_vigencia{
        margin: -5px 0px 0px !important;
    }
    .group_checkbox{
        flex-direction: column;
        justify-content: space-between;
        display: flex;
        padding: 0px 5px;
        background: white;
        width: 960px;
        margin-bottom: 10px;
    }
    
    #scrollingDiv{
        cursor: pointer;
    }
    
    .label-title{
        font-weight: bold;
    }
    
    .label-subtitle{
        font-weight: 500;
    }
</style>

<script type="text/javascript">

    function access(cod, name) {

        var value = cod.split(".");
        var id = parseInt(value[1]);

        var formData = {
            id_curso: id,
            codigo: cod,
            nome: name
        };

        var urlRequest = "<?php echo site_url('request/acessar_curso'); ?>";

        request(urlRequest, formData, 'hide');
    }

    $(document).ready(function () {

        function date_to_number(value, nullvalue) {
            var string;
            if (value && value != "###" && value != "NI" && value != "" && value != false && value != undefined) {
                string = value;
            } else {
                string = nullvalue;
            }
            var array = string.split("/");
            var mes = parseInt(array[0]);
            var ano = parseInt(array[1]);
            return (ano - 1900) * 12 + mes;
        }

        var dateObj = new Date();
        var month = dateObj.getUTCMonth() + 1;
        var year = dateObj.getUTCFullYear();

        var atualdate = date_to_number(month + "/" + year);
        var tableRunning = new Table({
            url: "<?php echo site_url('request/get_curso/AN/CO'); ?>",
            table: $('#running-courses'),
            controls: $('#running-controls')
        });

        var tableFinished = new Table({
            url: "<?php echo site_url('request/get_curso/CC'); ?>",
            table: $('#finished-courses'),
            controls: $('#finished-controls')
        });

        var tableIIPnera = new Table({
            url: "<?php echo site_url('request/get_curso/2P'); ?>",
            table: $('#ii-pnera-courses'),
            controls: $('#ii-pnera-controls')
        });

        $(".check_vigencia").on('change', function () {
            tableRunning.update();
            tableFinished.update();
            tableIIPnera.update();
        });

        $.fn.dataTableExt.afnFiltering.push(function (oSettings, aData, iDataIndex) {
            if (['running-courses', 'finished-courses', 'ii-pnera-courses'].indexOf(oSettings.nTable.getAttribute('id')) !== -1) {
                var ini = date_to_number(aData[3], "01/1950");
                var fim = date_to_number(aData[4], "12/2028");

                var result_inner = ((ini <= atualdate) && (atualdate <= fim)); //verifica se está dentro da vigência
                var result_outset = ((atualdate <= ini) || (atualdate >= fim)); //verifica se está fora da vigência 

                var checked_an = document.getElementById("vigencia_checkbox_an").checked;
                var checked_cc = document.getElementById("vigencia_checkbox_cc").checked;

                return (result_inner && checked_an) || (result_outset && checked_cc);
            } else {
                return true;
            }
        });

        /* Add a click handler to leave users able to access the courses (row) */

        $("#finalizar_cadastro").click(function () {
            $('#dialog-fin-cs').dialogInit(function () {
                var cod = parseInt(tableRunning.getSelectedByIndex(0).split(".")[1]);
                var urlRequest = "<?php echo site_url('curso/toogle_status_by_cod/'); ?>" + "/CC/" + cod;
                $.ajax({
                    url: urlRequest,
                    type: 'POST',
                    dataType: 'json',
                    timeout: 20000,
                    success: function (data) {
                        if (data.success) {
                            var selected = tableRunning.getSelectedData();
                            tableFinished.addData(selected);
                            tableRunning.deleteSelectedRow();
                        }
                        console.log(data);
                        showMessage('status', data);
                    },
                    error: function (data) {

                        // Falha na requisição
                        var error = {
                            'success': false,
                            'message': 'Falha na requisição. Tente novamente em instantes.'
                        };

                        showMessage('status', error); // Exibe mensagem de erro
                    }

                });
                return true;
            }, [500, 220]);
        });

        $('#running-access').click(function () {

            var cod = tableRunning.getSelectedByIndex(0);
            var nome = tableRunning.getSelectedByIndex(1);

            access(cod, nome);
        });

        $('#finished-access').click(function () {

            var cod = tableFinished.getSelectedByIndex(0);
            var nome = tableFinished.getSelectedByIndex(1);

            access(cod, nome);
        });

        $('#ii-pnera-access').click(function () {

            var cod = tableIIPnera.getSelectedByIndex(0);
            var nome = tableIIPnera.getSelectedByIndex(1);

            access(cod, nome);
        });

        $('#return-status').click(function () {
            $('#dialog').dialogInit(function () {

                var data = tableFinished.getSelectedByIndex(0);
                var value = data.split(".");

                var codigo = parseInt(value[1]);

                var formData = {
                    id_curso: codigo
                };

                var urlRequest = "<?php echo site_url('curso/toogle_status/AN'); ?>";

                request(urlRequest, formData);

                return true;

            }, [450, 220]);
        });

        // Navigation tabs
        $('#course-tab a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        });
    });
</script>

<details class="group_checkbox" id="scrollingDiv">
    <summary>Opções</summary>
    <h3>Mostrar cursos: </h3>
    <div class="row_checkbox form-check">
        <input checked type="checkbox" name="status" class="check_vigencia" value="AN" id="vigencia_checkbox_an"/>
        <label for="vigencia_checkbox_an"> 
            <div class="label-title">
                Em progresso
            </div>
            <div class="label-subtitle">
                Cursos que possivelmente estão ocorrendo neste momento
            </div>
        </label>
    </div>
    <div class="row_checkbox form-check">
        <input checked type="checkbox" name="status" class="check_vigencia" value="CC" id="vigencia_checkbox_cc"/>
        <label for="vigencia_checkbox_cc"> 
            <div class="label-title">
                Concluído ou aguardando início
            </div>
            <div class="label-subtitle">
                Cursos que ainda não iniciaram ou já foram finalizados
            </div>
        </label>
    </div>
</details>

<ul class="nav nav-tabs" id="course-tab">
    <li class="active"><a href="#running">Cadastro em andamento</a></li>
    <li><a href="#finished">Cadastro concluído</a></li>
    <li><a href="#ii-pnera">Cadastro do PNERA II</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="running">
        <div id="grid">

            <ul id="running-controls" class="nav nav-pills buttons">        
                <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="running-access">Acessar Curso</button></li>                
                <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="finalizar_cadastro">Finalizar Cadastro</button></li>
            </ul> 
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="running-courses">
                <thead>
                    <tr>
                        <th style="width:  50px"> CÓDIGO </th>
                        <th style="width: 300px"> CURSO </th>
                        <th style="width: 150px"> SEI OU SICONV </th>
                        <th style="width: 50px"> INÍCIO </th>
                        <th style="width: 50px"> TERMINO </th>
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table>
        </div>

    </div>

    <div class="tab-pane" id="finished">

        <div id="grid">
            <ul id="finished-controls" class="nav nav-pills buttons">        
                <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="finished-access">Acessar Curso</button></li>


                <!-- SEM RESTRIÇÃO!!!! -->
                <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="return-status">Reabilitar Cadastro</button></li>

                <?php
// SUPERVISOR, COORD. GERAL, ADMINISTRADOR 
                /* if ($this->session->userdata('access_level') > 2) {
                  echo '<li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="return-status">Reabilitar Cadastro</button></li>';
                  } */
                ?>

            </ul> 

            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="finished-courses">
                <thead>
                    <tr>
                        <th style="width:  50px"> CÓDIGO </th>
                        <th style="width: 300px"> CURSO </th>
                        <th style="width: 150px"> SEI OU SICONV </th>
                        <th style="width: 50px"> INÍCIO </th>
                        <th style="width: 50px"> TERMINO </th>
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table>
        </div>

        <div id="dialog" name="dialog" class="dialog" title="Confirmar reabilita&ccedil;&atilde;o">
            <br />
            <h4>Ao reabilitar o cadastro os dados do curso poderão ser alterados. Deseja proseguir?</h4>
        </div>

    </div>

    <div class="tab-pane" id="ii-pnera">

        <div id="grid">
            <ul id="ii-pnera-controls" class="nav nav-pills buttons">        
                <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="ii-pnera-access">Acessar Curso</button></li>
            </ul> 
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="ii-pnera-courses">
                <thead>
                    <tr>
                        <th style="width:  50px"> CÓDIGO </th>
                        <th style="width: 300px"> CURSO </th>
                        <th style="width: 150px"> SEI OU SICONV </th>
                        <th style="width: 50px"> INÍCIO </th>
                        <th style="width: 50px"> TERMINO </th>
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table>
        </div>

    </div>
</div>

<div id="dialog-fin-cs" name="dialog-fin-cs" class="dialog" title="Confirmar submiss&atilde;o">
    <br />
    <h4>Ao finalizar o cadastro os dados do curso não poderão mais ser alterados. Deseja proseguir?</h4>
</div>