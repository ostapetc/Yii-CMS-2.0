<div class="news_item">
    <h2><?php echo CHtml::link($data->title, $data->href) ?></h2>

    <?php
    if ($data->photo)
    {
        echo ImageHelper::thumb(News::PHOTOS_DIR, $data->photo, News::$photo_small_size, true)
            ->htmlOptions(array('class'=> "news_preview_image"));
    }

    echo Yii::app()->text->cut($data->text, 700, '.', '...');

    echo CHtml::link('далее', $data->href);
    ?>

</div>
