<a name="comments" xmlns="http://www.w3.org/1999/html"></a>

<div id="comments-div">

</div>


<?= CHtml::link('', 'comment-form'); ?>
<?= CHtml::beginForm('/comments/comment/create', 'post', array('id' => 'comment-form', 'style' => 'display: ' . (Yii::app()->user->isGuest ? 'none' : 'block'))) ?>
<?= CHtml::label('Комментарий', 'Comment[text]', array('label' => 'Комментарий', 'id' => 'comment-label')) ?>
<?= CHtml::textArea('Comment[text]', null, array('style' => 'width: 100%')) ?> <br/>
<?= CHtml::hiddenField('Comment[object_id]', $object_id); ?>
<?= CHtml::hiddenField('Comment[model_id]', $model_id); ?>
<?= CHtml::hiddenField('Comment[parent_id]'); ?>
<?= CHtml::submitButton('Добавить') ?>
<?= CHtml::endForm() ?>

<? if (Yii::app()->user->isGuest): ?>
    <blockquote>
        <p>Только зарегистрированные пользователи могут оставлять комментарии.</p>
        <p><?= Chtml::link('Войдите', '#', array('class' => 'login-link')) ?>, пожалуйста.</p>
    </blockquote>
<? endif ?>

