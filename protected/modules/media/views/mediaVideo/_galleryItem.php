<?
$img = $data->getPreview(['width' => 320, 'height' => 260]);

if ($img) {
?>
<li id="File_<?=$data->id?>" style="width: 331px; height: 340px" class="gallery-item">
    <a class="thumbnail" href="<?= $this->createUrl('/media/mediaVideo/view', ['id' => $data->id]) ?>">
        <div class="gallery-title">
            <span>
                <?= $data->title ? $data->title : '&nbsp;' ?>
            </span>
        </div>
        <?= $img ?>
    </a>
    <? $this->renderPartial('_infoPanel', ['model' => $data]); ?>

</li>
<? } ?>