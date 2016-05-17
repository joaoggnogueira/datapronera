<div style="margin: 30px 0px 30px 100px;">

    <b>1. Nome do(a) educando(a)</b>
    <div style="margin-left: 20px;" ><?php echo $dados[0]->nome; ?> </div>
    <br>

    <b>2. Sexo</b>
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

    <b>5. Data de nascimento do(a) educando(a)</b>
    <div style="margin-left: 20px;" ><?php echo $dados[0]->data_nascimento; ?> </div>
    <br>

    <b>6. Idade do(a) educando(a) no ingresso do curso</b>
    <div style="margin-left: 20px;" ><?php echo $dados[0]->idade; ?> </div>
    <br>

	<b>7. Tipo e nome do territ&oacute;rio onde o(a) educando(a) vivia e/ou trabalhava quando ingressou no curso</b>
    <br><br>

    <div style="margin-left: 15px;">
        <b>a. Tipo do territ&oacute;rio:</b>
        <div style="margin-left: 20px;" ><?php echo $dados[0]->tipo_territorio; ?> </div>
    </div>
    <div style="margin-left: 15px;">
        <b>b. Nome do territ&oacute;rio:</b>
        <div style="margin-left: 20px;" ><?php echo $dados[0]->nome_territorio; ?> </div>
    </div>
    <br>

	<b>8. Munic&iacute;pio(s) do territ&oacute;rio onde o(a) educando(a) vivia e/ou trabalhava quando ingressou no curso</b>
    <?
        $contador = 0;
        foreach ($municipios as $item) {
            if ($contador % 3 == 0) echo '<br>';
            echo '<div style="margin-left: 20px; width: 300px; float: left;" >'. $item[1]. ' - ' .$item[0] .' </div>';
            $contador++;
        }
    ?>
    <br><br>

	<b>9. O(a) educando(a) concluiu o curso ?</b>
    <div style="margin-left: 20px;" >
        <?php
            switch ($dados[0]->concluinte) {
                case '0':
                    echo 'NÃO';
                    break;
                case '1':
                    echo 'SIM';
                    break;

                default:
                    echo 'NÃO ENCONTRADO';
                    break;
            }
        ?>
    </div>
</div>