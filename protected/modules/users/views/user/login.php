<? $this->page_title = 'Авторизация'; ?>

<? if (Yii::app()->user->hasFlash('acrivate_done')): ?>

	<? echo $this->msg(Yii::app()->user->getFlash('acrivate_done'), 'ok'); ?>
	
<? elseif (Yii::app()->user->hasFlash('change_password_done')): ?>

	<? echo $this->msg(Yii::app()->user->getFlash('change_password_done'), 'ok'); ?>
	
<? endif ?>



<? if (isset($auth_error)): ?>
    <? echo $this->msg($auth_error, 'error'); ?>
<? endif ?>

<? echo $form; ?>

