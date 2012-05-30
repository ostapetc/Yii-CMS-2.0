<? if (!Yii::app()->user->isGuest): ?>
    <?= CHtml::beginForm('/comments/comment/create', 'post', array('id' => 'comment-form')) ?>
    <?= CHtml::label('Комментарий', 'Comment[text]') ?>
    <?= CHtml::textArea('Comment[text]', null, array('style' => 'width: 100%')) ?> <br/>
    <?= CHtml::hiddenField('Comment[root]', $root) ?>
    <?= CHtml::submitButton('Добавить') ?>
    <?= CHtml::endForm() ?>
<? else: ?>
    <?= Controller::msg('Комментировать могут только зарегистрированные пользователи!', 'info') ?>
<? endif ?>