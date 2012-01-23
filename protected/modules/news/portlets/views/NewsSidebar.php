<div class="gadget">
    <h2 class="star"><span><?php echo Yii::t('NewsModule.main', 'Новости'); ?></span></h2>

    <div class="clr"></div>

    <ul class="ex_menu">

        <?php foreach ($news_list as $news): ?>

            <?php
            if ($news->photo)
            {
                $thumb = ImageHelper::thumb(
                    News::PHOTOS_DIR,
                    $news->photo,
                    News::PHOTO_SMALL_WIDTH,
                    News::PHOTO_SMALL_HEIGHT,
                    true
                );
            }
            ?>

            <li>
                <a href="<?php echo $news->url; ?>"><?php echo $news->title; ?></a> <br/>
                <?php if (isset($thumb)): ?>
                    <a href="<?php echo $news->url; ?>"><?php echo $thumb; ?></a>  <br/>
                <?php endif ?>

                <?php echo Yii::app()->text->cut($news->text, 200, "."); ?>

                <br/>
                <br/>
            </li>

        <?php endforeach ?>

    </ul>

    <a href="<?php echo $this->url('/news'); ?>"><?php echo Yii::t('NewsModule.main', 'Все новости'); ?></a>→
</div>



