<?php $this->page_title = 'Активация аккаунта'; ?>

<?php if (isset($activate_error)): ?>
	<?php echo $this->msg(Yii::t('UsersModule.main', $activate_error), 'error'); ?>
<?php endif ?>