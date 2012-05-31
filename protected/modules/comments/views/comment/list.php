<? if ($comments): ?>
    <? foreach ($comments as $comment): ?>
        <div class="well" style="margin-left: <?= (20 * ($comment->level - 1)) ?>px">
            <a href="" class="comment-answer" comment_id="<?= $comment->id ?>" user_name="<?= $comment->user->name ?>">ответить</a>
            <br/>
            <?= CHtml::encode($comment->text); ?>
        </div>
    <? endforeach ?>
<? else: ?>
    <?= $this->msg('Еще никто не добавлял комментарии!', 'info'); ?>
<? endif ?>

