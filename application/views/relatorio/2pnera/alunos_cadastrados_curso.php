<div>
    <table style="width:100%; font-size: 13px;" border="1" cellspacing="0">
        <tr>
            <th style="text-align:right">COD</th>
            <th>NOME</th>
            <th>CADASTRADO</th>
            <th>INGRESSANTE</th>
            <th>CONCLUÍNTES</th>
        </tr>
        <?php
        foreach ($result as $row) {
            ?>
            <tr>
                <td style="text-align:right"><?php echo $row['cod']; ?></td>
                <td><?php echo $row['nome']; ?></td>
                <td style="text-align:center"><?php echo $row['cadastrados']; ?></td>
                <td style="text-align:center"><?php echo ($row['ingressante']=="N/D"?"<span style='color:red'>N/D</span>":$row['ingressante']); ?></td>
                <td style="text-align:center"><?php echo ($row['concluintes']=="N/D"?"<span style='color:red'>N/D</span>":$row['concluintes']); ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>