<ul class="thumbnails video-playlist">
    <?
    /** @var $item YouTubeApi */
    foreach ($data as $item) {
        ?>
        <li class="gallery-item sidebar-galery-item">
            <a href="<?= Yii::app()->createUrl('/media/mediaVideo/view', ['id' => $item->id]) ?>" class="thumbnail">
                <div class="gallery-title">
                    <span>
                        <?= $item->title ? $item->title : '&nbsp;' ?>
                    </span>
                </div>
                <?= $item->getPreview(['width' => 260, 'height' => 200]) ?>
            </a>
        </li>
        <hr/>
    <?
    }
    ?>
</ul>