<? $this->page_title = "Изменение пароля"; ?>

<? if (isset($error)): ?>
	<? echo Yii::t('UsersModule.main', $this->msg($error, 'error')); ?>
<? else: ?>
	<? echo $form; ?>
<? endif ?>

