<? $this->page_title = 'Восстановление пароля'; ?>

<? if (Yii::app()->user->hasFlash('done')): ?>

	<? echo Yii::t('UsersModule.main', $this->msg(Yii::app()->user->getFlash('done'), 'ok')); ?>

<? else: ?>

	<? if (isset($error)): ?>
	    <? echo $this->msg($error, 'error'); ?>
	<? endif ?>
	
	<? echo $form; ?>

<? endif ?>

