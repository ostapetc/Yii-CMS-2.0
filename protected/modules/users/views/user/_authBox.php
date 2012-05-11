<? if (Yii::app()->user->isGuest): ?>
    <a href="<?= $this->createUrl('/login'); ?>">Войти</a> &nbsp;
    <a href="<?= $this->createUrl('/registration'); ?>">Регистрация</a>
<? else: ?>
    <a href="<?= $this->createUrl('/users/user/logout'); ?>">Выйти</a>
<? endif ?>