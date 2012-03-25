<? $this->page_title = 'Активация аккаунта'; ?>

<? if (isset($activate_error)): ?>
	<? echo $this->msg(Yii::t('UsersModule.main', $activate_error), 'error'); ?>
<? endif ?>