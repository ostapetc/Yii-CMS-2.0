<div class="comment"  style="margin-left: <?= (20 * ($comment->level - 1)) ?>px">
    <div class="head">
        <a name="comment_<?= $comment->id ?>"></a>
        <?= $comment->user->getPhotoLink(); ?>
        <?= $comment->user->getLink('commet-user') ?>
        <span class="date"><?= $comment->value('date_create') ?></span>
        <a class="hash" href="#comment_<?= $comment->id ?>">#</a>
        <a class="answer" href="" comment_id="<?= $comment->id ?>" user_name="<?= $comment->user->name ?>">ответить</a>

        <?= $this->widget('RatingPortlet', array('model' => $comment)); ?>
    </div>

    <div class="well">
        <?= CHtml::encode($comment->text); ?>
    </div>
</div>

