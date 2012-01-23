<?php foreach ($articles as $article): ?>   
    <div class="search_list">
            <!--<div class="add_favour">
                <span class="favour_star"></span>
                <a href="">добавить в избранное</a>
            </div>-->
            <a href="<?php echo $this->url("/articles/{$article->id}"); ?>" class="search_title">
                <?php echo $article->title; ?>
            </a>
            <p>
			    <?php echo Text::cut($article->text, 250, ' ', '...'); ?>
            </p>
            <a href="<?php echo $this->url("/articles/{$article->id}"); ?>" class="more_info">
                <?php echo Yii::t('ArticlesModule.main', 'Подробнее'); ?>
            </a>
     </div>	              
<?php endforeach ?>
