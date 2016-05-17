<div style="margin: 30px 0px 0px 100px;">

    <b>1. Tipo</b>
    <div style="margin-left: 20px;" ><?php echo $dados[0]->tipo ?> </div>
    <br>

    <b>2. Autor(a)(es)(as) /  Organizador(a)(es)(as)</b>
    <br><br>
    <div style="margin-left: 20px; width: 400px; float:left;" > <b> NOME </b> </div>
    <div style="margin-left: 20px;" > <b> TIPO </b> </div>
    <br>
        <?
        $contador=1;
        foreach ($autores as $item) {
            if ($contador == 10) echo '<br><br><br><br><br>';
            echo '<div style="margin-left: 20px; width: 400px; float:left;" >'. $item[0].' </div><div style="margin-left: 20px;" >'.$item[1] .' </div>';
            $contador++;
        }
    ?>
    <br>

    <?php if ($contador > 17 ) echo '<br><br><br><br>'; ?>
    <b>3. Titulo</b>
    <div style="margin-left: 20px;" ><?php echo $dados[0]->titulo; ?> </div>
    <br>

    <?php if ($contador > 14 && $contador < 18) echo '<br><br><br><br>'; ?>
    <b>4. Local</b>
    <div style="margin-left: 20px;" ><?php echo $dados[0]->local_producao; ?> </div>
    <br>

    <?php if ($contador > 11 && $contador < 15) echo '<br><br><br><br>'; ?>
    <b>5. Editora</b>
    <div style="margin-left: 20px;" ><?php echo $dados[0]->editora; ?> </div>
    <br>

    <?php if ($contador > 8 && $contador < 12) echo '<br><br><br><br>'; ?>
    <b>5. Ano</b>
    <div style="margin-left: 20px;" > <?php echo $dados[0]->ano; ?> </div>
    <br>

    <?php if ($contador > 5 && $contador < 9) echo '<br><br><br><br>'; ?>
    <b>6. Formato</b>
    <div style="margin-left: 20px;" >
        <?php
            if ($dados[0]->formato != 'ON-LINE') echo $dados[0]->formato;
            else 'ON-LINE - '.$dados[0]->pagina_web;
        ?>
    </div>
    <br>

    <?php if ($contador < 6) echo '<br><br><br><br>'; ?>
    <b>7. Onde está disponível</b>
    <div style="margin-left: 20px;" > <?php echo $dados[0]->disponibilidade; ?> </div>
    <br>
</div>