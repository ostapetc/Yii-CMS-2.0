<div class="infopanel-wrapper">
    <div class="infopanel">
        <div class="voting">
            <? $this->widget('social.portlets.RatingPortlet', array('model' => $page)); ?>
        </div>

        <div class="published"><?= Yii::app()->dateFormatter->formatDateTime($page->date_create, 'long', 'short') ?></div>

        <? $this->widget('social.portlets.FavoritePortlet', array('model' => $page)); ?>

        <div class="author" >
            <a href="<?= $page->user->url ?>" title="Автор текста"><span class="glyphicon-user"></span><?= $page->user->name ?></a>
            <span title="рейтинг пользователя" class="rating"><?= $page->user->rating ?></span>
        </div>

        <div class="comments">
            <?
            $title = $page->comments_count ? 'Читать комментарии' : 'Комментировать';
            ?>

            <a href="<?= $page->url ?>#comments" title="<?= $title ?>">
                <span class="glyphicon-comments"></span>&nbsp;
                <span class="all"><?= $page->comments_count ? $page->comments_count : $title ?></span>
            </a>
        </div>

        <? if (isset($preview)): ?>
            <span class="label label-inverse">
                <?= CHtml::link('читать далее', $page->url, array('class' => 'read-more badge')) ?>
            </span>
        <? endif ?>
    </div>
</div>