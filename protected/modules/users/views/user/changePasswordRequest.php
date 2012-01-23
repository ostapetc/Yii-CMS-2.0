<?php $this->page_title = 'Восстановление пароля'; ?>

<?php if (Yii::app()->user->hasFlash('done')): ?>

	<?php echo Yii::t('UsersModule.main', $this->msg(Yii::app()->user->getFlash('done'), 'ok')); ?>

<?php else: ?>

	<?php if (isset($error)): ?>
	    <?php echo $this->msg($error, 'error'); ?>
	<?php endif ?>
	
	<?php echo $form; ?>

<?php endif ?>

