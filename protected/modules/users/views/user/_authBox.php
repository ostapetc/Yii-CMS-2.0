<? if (Yii::app()->user->isGuest): ?>
    <li><?= CHtml::link('Войти', '/login'); ?></li>
    <li><?= CHtml::link('Регистрация', '/registration'); ?></li>
<? else: ?>
    <li><?= CHtml::link(Yii::app()->user->model->name, '/users/user/profile', array('style' => 'text-decoration: underline !important; color: #FFFFFF')); ?></li>
    <li><?= CHtml::link('выйти', '/users/user/logout'); ?></li>
    <li style="padding-top: 9px"><?= Yii::app()->user->model->photo_link ?></li>
<? endif ?>