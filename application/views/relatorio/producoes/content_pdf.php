<?PHP
$setkeys = array_keys($result[0]);
$columns = count($setkeys);
$w = (1 / $columns) * 100;
?>
<div>
    <table style="width:100%; font-size: 13px;" border="1" cellspacing="0">
        <tr>
            <?PHP foreach ($setkeys as $key): ?>
                <th><?= str_replace("_", " ", $key) ?></th>
            <?PHP endforeach; ?>
        </tr>
        <?php foreach ($result as $row): ?>
            <tr>
                <?PHP foreach ($row as $value): ?>
                    <td style="text-align: center"><?= $value ?></td>
                <?PHP endforeach; ?> 
            </tr>
        <?php endforeach; ?>
    </table>
</div>