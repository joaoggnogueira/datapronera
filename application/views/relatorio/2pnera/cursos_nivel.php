<div>
    <table style="width:100%; font-size: 13px;" border="1" cellspacing="0">
        <tr>
            <th style="text-align:left">NÍVEL</th>
            <th>CURSOS</th>
        </tr>
        <?php
        foreach ($result as $row) {
            ?>
            <tr>
                <td><?php echo $row['nivel']; ?></td>
                <td style="text-align:center"><?php echo $row['total']; ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>