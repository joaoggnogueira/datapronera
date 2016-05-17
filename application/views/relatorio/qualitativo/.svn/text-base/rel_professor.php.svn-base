<div style="margin: 17px 0px 0px 100px;">

    <b>1. Nome do(a) professor(a) / educador(a)</b>
    <div style="margin-left: 20px;" ><?php echo $dados[0]->nome; ?> </div>
    <br>

    <b>2. Disciplina(s) / Mat&eacute;ria(s) lecionada(s)</b>
    <?
        if ($dados[0]->disciplina_ni == 'V')
            echo '<div style="margin-left: 20px; width: 300px; " > NÃO INFORMADO </div>';
        else
        {
            $contador = 0;
            foreach ($disciplina as $item) {
                if ($contador % 3 == 0) echo '<br>';
                echo '<div style="margin-left: 20px; width: 300px; float: left;" >'. $item[0] .' </div>';
                $contador++;
            }
            echo '<br>';
        }
    ?>
    <br>

    <b>3. CPF</b>
    <div style="margin-left: 20px;" >
        <?php
            switch ($dados[0]->cpf) {
                case 'NAOINFORMADO':
                    echo 'NÃO ENCONTRADO';
                    break;
                case 'NAOAPLICA':
                    echo 'NÃO SE APLICA';
                    break;
                default :
                    echo $dados[0]->cpf;
                    break;
            }
        ?>
    </div>
    <br>

    <b>4. R.G</b>
    <div style="margin-left: 20px;" >
        <?php
            switch ($dados[0]->rg) {
                case 'NAOINFORMADO':
                    echo 'NÃO ENCONTRADO';
                    break;
                case 'NAOAPLICA':
                    echo 'NÃO SE APLICA';
                    break;
                default :
                    echo $dados[0]->rg;
                    break;
            }
        ?>
    </div>
    <br>

    <b>5. Sexo</b>
    <div style="margin-left: 20px;" >
        <?php
            switch ($dados[0]->genero) {
                case 'N':
                    echo 'NÃO INFORMADO';
                    break;
                case 'M':
                    echo 'MASCULINO';
                    break;
                case 'F':
                    echo 'FEMININO';
                    break;

                default:
                    break;
            }
        ?>
    </div>
    <br>

    <b>6. Grau de escolaridade / titula&ccedil;&atilde;o do(a) professor(a) / educador(a) quando o curso foi realizado</b>
    <div style="margin-left: 20px;" >
        <?php
            if ($dados[0]->titulacao != '###') echo $dados[0]->titulacao;
            else echo 'NÃO INFORMADO';
        ?>
    </div>
    <br>
</div>