<div style="margin: 30px 0px 0px 100px;">

    <b>1. Natureza da Produção</b>
    <div style="margin-left: 20px;" >
        <?php
        if ($dados[0]->natureza_producao != 'VIDEO' && $dados[0]->natureza_producao != 'CARTILHA / APOSTILA'
                               && $dados[0]->natureza_producao != 'TEXTO' && $dados[0]->natureza_producao != 'MUSICA'
                               && $dados[0]->natureza_producao != 'CADERNO')
            echo 'OUTROS - ';

        echo $dados[0]->natureza_producao;
        ?>
    </div>
    <br>

    <b>2. Titulo</b>
    <div style="margin-left: 20px;" ><?php echo $dados[0]->titulo ?> </div>
    <br>

    <b>3. O(s) autor(a)(es)(as) / produtor(a)(es)(as) é(são)</b>
    <div style="margin-left: 20px;" ><?php echo $dados[0]->autor_classificacao; ?> </div>
    <br>

    <b>4. Produtor(a)(es)(as) / Autor(a)(es)(as) / Organizador(a)(es)(as)</b>
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

    <?php if ($contador == 7 ) echo '<br>';?>
    <b>5. Local</b>
    <div style="margin-left: 20px;" ><?php echo $dados[0]->local_producao; ?> </div>
    <br>

    <?php  if ($contador == 7 ) echo '<br><br><br>';
        else if ($contador == 9 ) echo '<br><br><br><br><br>';?>

    <b>6. Ano</b>
    <div style="margin-left: 20px;" ><?php echo $dados[0]->ano; ?> </div>
    <br>
</div>