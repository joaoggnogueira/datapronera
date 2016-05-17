<div style="margin: 30px 0px 0px 100px;">

    <b>1. Título</b>
    <div style="margin-left: 20px;" ><?php echo $dados[0]->titulo; ?> </div>
    <br>

    <b>2. Local</b>
    <div style="margin-left: 20px;" ><?php echo $dados[0]->local_producao; ?> </div>
    <br>

    <b>3. Ano</b>
    <div style="margin-left: 20px;" > <?php echo $dados[0]->ano; ?> </div>
    <br>

    <b>4. Formato</b>
    <div style="margin-left: 20px;" >
        <?php
            if ($dados[0]->formato != 'ON-LINE') echo $dados[0]->formato;
            else 'ON-LINE - '.$dados[0]->pagina_web;
        ?>
    </div>
    <br>

    <b>5. Onde está disponível</b>
    <div style="margin-left: 20px;" > <?php echo $dados[0]->disponibilidade; ?> </div>
    <br>
</div>