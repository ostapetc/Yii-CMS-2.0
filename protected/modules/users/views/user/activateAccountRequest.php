<?php $this->page_title = "Запрос на активацию аккаунта"; ?>

<?php if (Yii::app()->user->hasFlash('done')): ?>
	<?php echo $this->msg(Yii::t('UsersModule.main', Yii::app()->user->getFlash('done')), 'ok'); ?>
<?php else: ?>

	<?php if ($error): ?>
	    <?php echo $this->msg(Yii::t('UsersModule.main', $error), 'error'); ?>
	<?php endif ?>
	
	<?php echo $form; ?>
	
<?php endif; ?>


