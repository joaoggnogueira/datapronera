<div style="margin: 30px 0px 0px 100px;">

    <b>1. Nome do(a) Pesquisador(a) Estadual</b>
    <div style="margin-left: 20px;" ><?php echo $data->pesquisador; ?> </div>
    <br>

    <b>2. Nome do(a) Auxiliar de Pesquisa</b>
    <div style="margin-left: 20px;" ><?php echo $data->auxiliar; ?> </div>
    <br>

    <b>3. Superintend&ecirc;ncia</b>
    <div style="margin-left: 20px;" ><?php echo $data->superintendencia.'  -  '.$data->uf; ?> </div>
    <br>

    <b>4. Nome do(a)(s) Assegurador(a)(es)(as)</b>
        <?
        foreach ($insurers as $item) {
            echo '<div style="margin-left: 20px;" >'. $item[1] .' </div>';
        }
    ?>
    <br><br>

    <b>5. Fonte(s) das informa&ccedil;&otilde;es</b>
    <div style="margin-left: 20px;" ><?php echo $dados[0]->natureza_instituicao; ?> </div>

        <?php  if ($informer->superintendencia_incra == 1)
                echo '<div style="margin-left: 20px;" >SUPERINTENDÊNCIA DO INCRA </div>';

            if ($informer->univ_facul == 1)
                echo '<div style="margin-left: 20px;" >INSTITUIÇÃO DE ENSINO </div>';

            if ($informer->mov_social_sindical == 1)
                echo '<div style="margin-left: 20px;" >MOVIMENTO SOCIAL/SINDICAL </div>';

            if ($informer->secretaria_mun_educacao == 1)
                echo '<div style="margin-left: 20px;" >SECRETARIA MUNICIPAL DE EDUCAÇÃO </div>';

            if ($informer->secretaria_est_educacao == 1)
                echo '<div style="margin-left: 20px;" >SECRETARIA ESTADUAL DE EDUCAÇÃO </div>';

            if ($informer->inst_federal == 1)
                echo '<div style="margin-left: 20px;" >INSTITUTOS FEDERAIS </div>';

            if ($informer->escola_tec == 1)
                echo ' <div style="margin-left: 20px;" >ESCOLAS TÉCNICAS </div>';

            if ($informer->redes_ceffas == 1)
                echo '<div style="margin-left: 20px;" >REDES CEFAS </div>';

            if ($informer->outras == 1)
                 echo '<div style="margin-left: 20px;" >OUTRAS. '.$informer->complemento.' </div>';
        ?>

    <br>
</div>