<div class="gray_block">
    <div class="gray_block_title">
        <a href="<?php echo $this->url("/articles"); ?>" class="more right"><?php echo Yii::t("ArticlesModule.main", "Все материалы"); ?></a>
        <?php echo $section->name; ?>
    </div>

    <?php foreach ($articles as $article):?>
        <div class="item_list">
            <a href="<?php echo $this->url("/articles/{$article->id}"); ?>" class="link_14">
                <?php echo $article->title; ?>
            </a>

            <div>
                <?php echo Yii::t("ArticlesModule.main", "Дата создания"); ?>:
                <span class="create_date">
                    <?php echo Yii::app()->dateformatter->format('dd MMMM yyyy', $article->date); ?>
                </span>
            </div>
            <br clear="all"/>
        </div>
    <?php endforeach ?>

</div>

<div class="gray_block_bottom"></div>

