<div style="margin: 30px 0px 0px 100px;">

    <b>1. Nome do Parceiro</b>
    <div style="margin-left: 20px;" ><?php echo $dados[0]->nome; ?> </div>
    <br>

    <b>2. Sigla</b>
    <div style="margin-left: 20px;" ><?php echo $dados[0]->sigla; ?> </div>
    <br>

    <b>3. Logradouro</b>
    <br><br>

    <div style="margin-left: 15px;">
        <b>a. Rua, Avenida, etc.</b>
        <div style="margin-left: 20px;" ><?php echo $dados[0]->rua; ?> </div>
    </div>
    <div style="margin-left: 15px;">
        <b>b. N&uacute;mero</b>
        <div style="margin-left: 20px;" >
            <?php
                if($dados[0]->numero == 0) echo 'S/N';
                else echo $dados[0]->numero;
            ?>
        </div>
    </div>
    <div style="margin-left: 15px;">
        <b>c. Complemento</b>
        <div style="margin-left: 20px;" ><?php echo $dados[0]->complemento; ?> </div>
    </div>
    <div style="margin-left: 15px;">
        <b>d. Bairro</b>
        <div style="margin-left: 20px;" ><?php echo $dados[0]->bairro; ?> </div>
    </div>
    <div style="margin-left: 15px;">
        <b> e. CEP </b>
        <div style="margin-left: 20px;" ><?php echo $dados[0]->cep; ?> </div>
    </div>
    <br>

    <b>4. Munic&iacute;pio</b>
    <div style="margin-left: 20px;" ><?php echo $dados[0]->cidade.'  -  '.$dados[0]->estado; ?> </div>
    <br> <br> <br> <br> <br> <br> <br>

    <b>5. Telefone(s)</b>
    <br><br>

    <div style="margin-left: 15px;">
        <b>a. Telefone 1 </b>
        <div style="margin-left: 20px;" ><?php echo $dados[0]->telefone1; ?> </div>
    </div>
    <div style="margin-left: 15px;">
        <b>b. Telefone 2</b>
        <div style="margin-left: 20px;" ><?php echo $dados[0]->telefone2; ?> </div>
    </div>
    <br>

    <b>6. P&aacute;gina Web</b>
    <div style="margin-left: 20px;" >
        <?php
            if($dados[0]->pagina_web == 'NAOINFORMADO') echo 'NÃO INFORMADO';
            else echo $dados[0]->pagina_web;
        ?>
    </div>
    <br>

    <b>7. Natureza do Parceiro</b>
    <div style="margin-left: 20px;" >
        <?php
            if ($dados[0]->natureza != 'OUTROS') echo $dados[0]->natureza;
            else echo $dados[0]->natureza_descricao
        ?>
    </div>
    <br>

    <b>8. Abrang&ecirc;ncia</b>
    <div style="margin-left: 20px;" ><?php echo $dados[0]->abrangencia; ?> </div>
    <br>

    <b>9. Tipo de Parceria</b>
    <div style="margin-left: 20px;" >
        <?php
            if ($has_parceria[0]->realizacao == 1)      echo '<div style="margin-left: 20px;" > REALIZAÇÃO DO CURSO </div>';
            if ($has_parceria[0]->certificacao == 1)    echo '<div style="margin-left: 20px;" > CERTIFICAÇÃO </div>';
            if ($has_parceria[0]->gestao == 1)          echo '<div style="margin-left: 20px;" > GESTÃO ORÇAMENTÁRIA </div>';
            if ($has_parceria[0]->outros == 1)          echo '<div style="margin-left: 20px;" >'.$has_parceria[0]->complemento.'</div>';
        ?>
    </div>
    <br>
</div>