<div>
    <table style="width:100%; font-size: 13px;" border="1" cellspacing="0">
        <tr>
            <th>NOME EDUCANDO</th>
            <th style="text-align:left">TIPO TERRITÓRIO</th>
            <th style="text-align:left">NOME TERRITÓRIO</th>
            <th>CÓD. SR</th>
            <th>CÓD. CURSO</th>
            <th style="text-align:left">NOME CURSO</th>
            <th style="text-align:left">MODALIDADE CURSO</th>
        </tr>
        <?php
        foreach ($result as $row) {
            ?>
            <tr>
                <td><?php echo $row['nome']; ?></td>
                <td><?php echo $row['tipo_territorio']; ?></td>
                <td><?php echo $row['nome_territorio']; ?></td>
                <td><?php echo $row['cod_sr']; ?></td>
                <td><?php echo $row['cod_curso']; ?></td>
                <td><?php echo $row['nome_curso']; ?></td>
                <td><?php echo $row['modalidade']; ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>