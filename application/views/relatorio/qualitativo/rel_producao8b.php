<div style="margin: 30px 0px 0px 100px;">

    <b>1. Tipo de Trabalho</b>
    <div style="margin-left: 20px;" > <?php echo $dados[0]->tipo; ?> </div>
    <br>

    <b>2. Autor(a)(es)(as)</b>
    <br>
    <?
        $contador=1;
        foreach ($autores as $item) {
            if ($contador > 18 ) echo '<br><br><br><br><br>';
            echo '<div style="margin-left: 20px; width: 400px; " >'. $item[0].' </div>';
            $contador++;
        }
    ?>
    <br>

    <?php if ($contador > 17 ) echo '<br><br><br><br>'; ?>
    <b>3. Título(a)</b>
    <div style="margin-left: 20px;" ><?php echo $dados[0]->titulo; ?> </div>
    <br>

    <?php if ($contador > 14 && $contador < 18) echo '<br><br><br><br>'; ?>
    <b>4. Programa / Curso</b>
    <div style="margin-left: 20px;" ><?php echo $dados[0]->programa_curso; ?> </div>
    <br>

    <?php if ($contador > 11 && $contador < 15) echo '<br><br><br><br>'; ?>
    <b>5. Instituição</b>
    <div style="margin-left: 20px;" ><?php echo $dados[0]->instituicao; ?> </div>
    <br>

    <?php if ($contador > 8 && $contador < 12) echo '<br><br><br><br>'; ?>
    <b>6. Local de Defesa / Apresentação</b>
    <div style="margin-left: 20px;" > <?php echo $dados[0]->local_defesa; ?> </div>
    <br>

    <?php if ($contador > 5 && $contador < 9) echo '<br><br><br><br>'; ?>
    <b>7. Local de desenvolvimento do estágio</b>
    <div style="margin-left: 20px;" > <?php echo $dados[0]->local_estagio; ?> </div>
    <br>

    <?php if ($contador > 2 && $contador < 6) echo '<br><br><br><br>'; ?>
    <b>8. Ano de defesa ou apresentação</b>
    <div style="margin-left: 20px;" > <?php echo $dados[0]->ano_defesa; ?> </div>
    <br>

    <?php if ($contador < 3) echo '<br><br><br><br>'; ?>
    <b>9. Orientador(a)</b>
    <div style="margin-left: 20px;" > <?php echo $dados[0]->orientador; ?> </div>
    <br>

    <b>10. Formato</b>
    <div style="margin-left: 20px;" >
        <?php
            if ($dados[0]->formato != 'ON-LINE') echo $dados[0]->formato;
            else 'ON-LINE - '.$dados[0]->pagina_web;
        ?>
    </div>
    <br>

    <b>11. Onde está disponível</b>
    <div style="margin-left: 20px;" > <?php echo $dados[0]->disponibilidade; ?> </div>
    <br>
</div>