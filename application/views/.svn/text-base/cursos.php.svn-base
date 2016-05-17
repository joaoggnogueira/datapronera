<?php

    if (! defined('BASEPATH')) {
        exit('No direct script access allowed');

    } else if (! $this->system->is_logged_in()) {
        echo index_page();        
    }
    
?>

<script type="text/javascript">

    function access (cod, name) {

        var value = cod.split(".");
        var id = parseInt(value[1]);

        var formData = {
           id_curso     : id,
           codigo       : cod,
           nome         : name 
        };

        var urlRequest = "<?php echo site_url('request/acessar_curso'); ?>";

        request(urlRequest, formData, 'hide');
    }

    $(document).ready(function () {

        var tableRunning = new Table({
            url      : "<?php echo site_url('request/get_curso/AN/CO'); ?>",
            table    : $('#running-courses'),
            controls : $('#running-controls')
        });

        var tableFinished = new Table({
            url      : "<?php echo site_url('request/get_curso/CC'); ?>",
            table    : $('#finished-courses'),
            controls : $('#finished-controls')
        });

        var tableIIPnera = new Table({
            url      : "<?php echo site_url('request/get_curso/2P'); ?>",
            table    : $('#ii-pnera-courses'),
            controls : $('#ii-pnera-controls')
        });
        
        /* Add a click handler to leave users able to access the courses (row) */
        $('#running-access').click(function () {

            var cod  = tableRunning.getSelectedByIndex(0);
            var nome = tableRunning.getSelectedByIndex(1);

            access(cod, nome);
        });

        $('#finished-access').click(function () {

            var cod  = tableFinished.getSelectedByIndex(0);
            var nome = tableFinished.getSelectedByIndex(1);

            access(cod, nome);
        });

        $('#ii-pnera-access').click(function () {

            var cod  = tableIIPnera.getSelectedByIndex(0);
            var nome = tableIIPnera.getSelectedByIndex(1);

            access(cod, nome);
        });

        $('#return-status').click(function () {
            $('#dialog').dialogInit(function () {

                var data = tableFinished.getSelectedByIndex(0);
                var value = data.split(".");

                var codigo = parseInt(value[1]);

                var formData = {
                   id_curso : codigo
                };

                var urlRequest = "<?php echo site_url('curso/toogle_status/AN'); ?>";

                request(urlRequest, formData);

                return true;

            }, [450,220]);
        });

        // Navigation tabs
        $('#course-tab a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        });

    });

</script>

<ul class="nav nav-tabs" id="course-tab">
    <li class="active"><a href="#running">Cadastro em andamento</a></li>
    <li><a href="#finished">Cadastro concluído</a></li>
    <li><a href="#ii-pnera">II PNERA</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="running">
        <div id="grid">
            <ul id="running-controls" class="nav nav-pills buttons">        
                <li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="running-access">Acessar Curso</button></li>                
            </ul> 
            
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="running-courses">
                <thead>
                    <tr>
                        <th style="width:  50px"> CÓDIGO </th>
                        <th style="width: 400px"> CURSO </th>
                        <th style="width: 300px"> RESPONSÁVEL PELA INFORMAÇÃO </th>
                        <th style="width: 150px"> INÍCIO CURSO </th>
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
                    /*if ($this->session->userdata('access_level') > 2) {
                        echo '<li class="buttons"><button type="button" class="btn btn-primary btn-disabled disabled" id="return-status">Reabilitar Cadastro</button></li>';
                    }*/
                    
                ?>

            </ul> 
            
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="finished-courses">
                <thead>
                    <tr>
                        <th style="width:  50px"> CÓDIGO </th>
                        <th style="width: 400px"> CURSO </th>
                        <th style="width: 300px"> RESPONSÁVEL PELA INFORMAÇÃO </th>
                        <th style="width: 150px"> INÍCIO CURSO </th>
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
                        <th style="width: 400px"> CURSO </th>
                        <th style="width: 300px"> RESPONSÁVEL PELA INFORMAÇÃO </th>
                        <th style="width: 150px"> INÍCIO CURSO </th>
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table>
        </div>

    </div>
</div>