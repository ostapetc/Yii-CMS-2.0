<div class="news_item">
    <h2><a href="<?php echo $data->url; ?>"><?php echo $data->title; ?></a></h2>

    <?php if ($data->photo): ?>
        <?php echo ImageHelper::thumb(
            News::PHOTOS_DIR,
            $data->photo,
            News::PHOTO_SMALL_WIDTH,
            News::PHOTO_SMALL_HEIGHT,
            true,
            'class="news_preview_image"'
        );
        ?>

        <?php echo Yii::app()->text->cut($data->text, 700, '.', '...'); ?>

        <a href="<?php echo $data->url; ?>">далее</a>

    <?php endif ?>
</div>
