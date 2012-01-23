<?php $this->page_title = "Изменение пароля"; ?>

<?php if (isset($error)): ?>
	<?php echo Yii::t('UsersModule.main', $this->msg($error, 'error')); ?>
<?php else: ?>
	<?php echo $form; ?>		
<?php endif ?>

