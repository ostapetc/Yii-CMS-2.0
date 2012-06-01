<? if ($comments): ?>
    <? foreach ($comments as $comment): ?>
        <? $this->renderPartial('_view', array('comment' => $comment)); ?>
    <? endforeach ?>
<? else: ?>
    <?= $this->msg('Еще никто не добавлял комментарии!', 'info'); ?>
<? endif ?>

