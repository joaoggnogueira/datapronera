<div style="margin: 30px 0px 0px 100px;">

    <b>1. Nome da Organiza&ccedil;&atilde;o</b>
    <div style="margin-left: 20px;" ><?php echo $dados[0]->nome; ?> </div>
    <br>

    <b>2. Abrang&ecirc;ncia da Organiza&ccedil;&atilde;o</b>
    <div style="margin-left: 20px;" ><?php echo $dados[0]->abrangencia; ?> </div>
    <br>

    <b>3. Data de Funda&ccedil;&atilde;o Nacional</b>
    <div style="margin-left: 20px;" >
        <?php
            if ($dados[0]->data_fundacao_nacional == '01/01/1900') echo 'NÃO SE APLICA';
            else echo $dados[0]->data_fundacao_nacional;
        ?>
    </div>
    <br>

    <b>4. Data de Funda&ccedil;&atilde;o no Estado</b>
    <div style="margin-left: 20px;" ><?php echo $dados[0]->data_fundacao_estadual; ?> </div>
    <br>

    <b>5. N&uacute;mero de Acampamentos (estadual)</b>
    <div style="margin-left: 20px;" >
        <?php
            if($dados[0]->numero_acampamentos == '-1') echo 'NÃO INFORMADO';
            else echo $dados[0]->numero_acampamentos;
        ?>
    </div>
    <br>

    <b>6. N&uacute;mero de Assentamentos ligados ao Movimento no Estado </b>
    <div style="margin-left: 20px;" >
        <?php
            if($dados[0]->numero_assentamentos == '-1') echo 'NÃO INFORMADO';
            else echo $dados[0]->numero_assentamentos;
        ?>
    </div>
    <br>

    <b>7. N&uacute;mero de Fam&iacute;lias Assentadas</b>
    <div style="margin-left: 20px;" >
        <?php
            if($dados[0]->numero_familias_assentadas == '-1') echo 'NÃO INFORMADO';
            else echo $dados[0]->numero_familias_assentadas;
        ?>
    </div>
    <br>

    <b>8. N&uacute;mero de Pessoas do Movimento envolvidas no acompanhamento do Curso</b>
    <div style="margin-left: 20px;" >
        <?php
            if($dados[0]->numero_pessoas == '-1') echo 'NÃO INFORMADO';
            else echo $dados[0]->numero_pessoas;
        ?>
    </div>
    <br> <br> <br> <br> <br>

    <b>9. Membros envolvidos</b>
    <br><br>

    <?php $contador = 0;
    foreach ($coord as $item ) {
        if ($contador != 0 && $contador % 4 == 0 ) echo '<br> <br> <br> <br> <br> <br>';
    ?>

        <div style="margin-left: 15px;">
            <b>a. Nome do membro envolvido no curso (Coordenador(a))</b>
            <div style="margin-left: 20px;" ><?php echo $item->nome; ?> </div>
        </div>
        <div style="margin-left: 15px;">
            <b>b. Grau de escolaridade na &eacute;poca da realiza&ccedil;&atilde;o do curso</b>
            <div style="margin-left: 20px;" ><?php echo $item->grau_escolaridade_epoca; ?> </div>
        </div>
        <div style="margin-left: 15px;">
            <b>c. Grau de escolaridade na atualidade</b>
            <div style="margin-left: 20px;" ><?php echo $item->grau_escolaridade_atual; ?> </div>
        </div>
        <div style="margin-left: 15px;">
            <b>d. Estudou/estuda em curso do PRONERA ?</b>
            <div style="margin-left: 20px;" >
                <?php
                    if ($item->estuda_pronera == 1) echo 'SIM';
                    else if ($item->estuda_pronera == 2 ) echo 'NÃO';
                ?>
            </div>
        </div>
    <br>
    <br>

    <?php $contador++ ;
        }
    ?>

    <br>

    <b>10. Fonte das informa&ccedil;&otilde;es (nome da pessoa que forneceu os dados)</b>
    <div style="margin-left: 20px;" ><?php echo $dados[0]->fonte_informacao; ?> </div>
    <br>
</div>