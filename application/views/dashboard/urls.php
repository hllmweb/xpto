<?php foreach($list_urls as $row): ?>
<div class="item-box">
    <div class="title">  
        <a href="javascript:void(0);" onclick="del_url('<?= $row['IdUrl']; ?>');" class="del"><i class="fa-solid fa-circle-xmark"></i></a> 
    </div>
    <div class="description">
        <span>
            <strong><i class="fa-solid fa-globe"></i> Url</strong>
            <a href="<?= $row['Url'] ?>" target="_blank">
                <?= $row['Url'] ?>
            </a> 
        </span>

        <span>
            <strong><i class="fa-solid fa-calendar-days"></i> Última Atualização</strong>
            <?= $row['DtHrMonitoring'] ?>

            <div class="status">
                <span class="s-<?= ($row['StatusCode'] == 200) ? '200' : '300' ?> blink"> 
                 
                <?= $row['StatusCode']?>
                </span>
            </div>
        </span>
    </div>
</div>
<?php endforeach; ?>