<div class="infopanel-wrapper">
    <div class="infopanel">
        <div class="voting">
            <? $this->widget('social.portlets.RatingWidget', array('model' => $model)); ?>
        </div>

        <div class="published"><?= Yii::app()->dateFormatter->formatDateTime($model->date_create, 'long', 'short') ?></div>

        <?= $this->widget('social.portlets.FavoriteWidget', array('model' => $model)); ?>

        <div class="comments">
            <span class="glyphicon-comments"></span>
            <span class="all">(<?= $model->comments_count ?>)</span>
        </div>
        <?
        $user = $model->getParentModel();
        if ($user instanceof User)  {
            ?>
            <div class="author" >
                <a href="<?= $user->url ?>" title="Автор текста"><span class="glyphicon-user"></span><?= $user->name ?></a>
                <span title="рейтинг пользователя" class="rating"><?= $user->rating ?></span>
            </div>
            <? } ?>

    </div>
</div>