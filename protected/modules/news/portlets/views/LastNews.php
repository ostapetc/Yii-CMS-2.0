<?php
$i = 0;
foreach ($news_list as $news)
{
    if ($i++ % 3 == 0)
    {
        echo '<div class="row-fluid">';
    }
    ?>


<div class="span4">
    <h3><?php echo $news->title ?></h3>
    <?php
    if ($news->photo)
    {
        $thumb = ImageHelper::thumb(News::PHOTOS_DIR, $news->photo, News::$photo_small_size, true);
        echo  CHtml::link($thumb, $news->href);
    }
    ?>

    <p><?php echo Yii::app()->text->cut($news->text, 200, "."); ?></p>

    <p><?php echo CHtml::link(t('View details') . '&raquo;', $news->href, array('class'=> 'btn')) ?></p>
</div>


<?php
    if ($i % 3 == 0)
    {
        echo '</div>';
    }
} ?>

<?php echo CHtml::link(Yii::t('NewsModule.main', 'Все новости'), array('/news/news/index')) ?>

