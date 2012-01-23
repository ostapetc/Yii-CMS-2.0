<?php $this->page_title = 'Авторизация'; ?>

<?php if (Yii::app()->user->hasFlash('acrivate_done')): ?>

	<?php echo $this->msg(Yii::app()->user->getFlash('acrivate_done'), 'ok'); ?>
	
<?php elseif (Yii::app()->user->hasFlash('change_password_done')): ?>	

	<?php echo $this->msg(Yii::app()->user->getFlash('change_password_done'), 'ok'); ?>
	
<?php endif ?>



<?php if (isset($auth_error)): ?>
    <?php echo $this->msg($auth_error, 'error'); ?>
<?php endif ?>

<?php echo $form; ?>

