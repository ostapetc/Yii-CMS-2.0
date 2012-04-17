<? $this->page_title = "Запрос на активацию аккаунта"; ?>

<? if (Yii::app()->user->hasFlash('done')): ?>
	<? echo $this->msg(Yii::t('UsersModule.main', Yii::app()->user->getFlash('done')), 'ok'); ?>
<? else: ?>

	<? if ($error): ?>
	    <? echo $this->msg(Yii::t('UsersModule.main', $error), 'error'); ?>
	<? endif ?>
	
	<? echo $form; ?>
	
<? endif; ?>


