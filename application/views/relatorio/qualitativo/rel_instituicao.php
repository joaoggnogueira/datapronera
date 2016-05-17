<div style="margin: 30px 0px 0px 100px;">

    <b>1. Nome da Institui&ccedil;&atilde;o de Ensino</b>
    <div style="margin-left: 20px;" ><?php echo $dados[0]->nome; ?> </div>
    <br>

    <b>2. Sigla</b>
    <div style="margin-left: 20px;" ><?php echo $dados[0]->sigla; ?> </div>
    <br>

    <b>3. Unidade: (Pr&oacute;-reitoria, Faculdade, Instituto, Centro, etc)</b>
    <div style="margin-left: 20px;" ><?php echo $dados[0]->unidade; ?> </div>
    <br>

    <b>4. Departamento, Se&ccedil;&atilde;o, etc</b>
    <div style="margin-left: 20px;" ><?php echo $dados[0]->departamento; ?> </div>
    <br>

    <b>5. Logradouro</b>
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
    <br> <br> <br> <br>  <br> <br>

    <b>6. Munic&iacute;pio</b>
    <div style="margin-left: 20px;" >
        <?php
            if ($dados[0]->cidade != '' && $dados[0]->estado != '')
                echo $dados[0]->cidade.'  -  '.$dados[0]->estado;
        ?>
    </div>
    <br>

    <b>7. Telefone(s)</b>
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

    <b>8. Campus</b>
    <div style="margin-left: 20px;" >
        <?php
            if($dados[0]->campus == 'NAOINFORMADO') echo 'NÃO INFORMADO';
            else echo $dados[0]->campus;
        ?>
    </div>
    <br>

    <b>9. P&aacute;gina da web</b>
    <div style="margin-left: 20px;" ><?php echo $dados[0]->pagina_web; ?> </div>
    <br>

    <b>10. Natureza da Institui&ccedil;&atilde;o</b>
    <div style="margin-left: 20px;" ><?php echo $dados[0]->natureza_instituicao; ?> </div>
    <br>
</div>