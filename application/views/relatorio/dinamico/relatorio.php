<div style="padding: 30px 100px 0px 100px;">
    <? foreach($query as $value): ?>
        <? foreach($campos as $campo): ?>
            <b><?= strtoupper($campo); ?></b>
            <div style="margin-left: 20px;" ><?= $value[$campo]; ?></div>
            <br>
        <? endforeach; ?>
        <hr>
    <? endforeach; ?>
</div>