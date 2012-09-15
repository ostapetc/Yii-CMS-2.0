<? foreach ($comments as $comment): ?>
    <? $this->renderPartial('_view', array('comment' => $comment)); ?>
<? endforeach ?>

