<div class="infopanel">
    <div class="voting">
<!--        --><?// $this->widget('social.portlets.RatingPortlet', array('model' => $page)); ?>
    </div>

    <div class="published"><?= Yii::app()->dateFormatter->formatDateTime($page->date_create, 'long', 'short') ?></div>

    <? $this->widget('social.portlets.FavoritePortlet', array('model' => $page)); ?>

    <?
    $user = $page->getParentModel();
    if ($user instanceof User)  {
    ?>
        <div class="author" >
            <a href="<?= $user->url ?>" title="Автор текста"><span class="glyphicon-user"></span><?= $user->name ?></a>
            <span title="рейтинг пользователя" class="rating"><?= $user->rating ?></span>
        </div>
    <? } ?>

    <div class="comments">
        <?
        $title = $page->comments_count ? 'Читать комментарии' : 'Комментировать';
        ?>

        <a href="<?= $page->url ?>#comments" title="<?= $title ?>">
            <span class="glyphicon-comments"></span>&nbsp;
            <span class="all"><?= $page->comments_count ? $page->comments_count : $title ?></span>
        </a>
    </div>

    <? $this->widget('CommentsPortlet', array('model' => $page)); ?>

</div>