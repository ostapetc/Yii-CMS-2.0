<div class="news_item">
    <h2><?php echo CHtml::link($data->title, $data->href) ?></h2>

    <?php
    if ($data->photo)
    {
        echo ImageHelper::thumb(News::PHOTOS_DIR, $data->photo, News::PHOTO_SMALL_WIDTH, News::PHOTO_SMALL_HEIGHT, true, 'class="news_preview_image"');
    }

    echo Yii::app()->text->cut($data->text, 700, '.', '...');

    echo CHtml::link('далее', $data->href);
    ?>

</div>
