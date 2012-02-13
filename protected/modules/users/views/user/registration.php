<?php $this->page_title = "Регистрация"; ?>

<?php if (Yii::app()->user->hasFlash('done')): ?>
    <?php echo $this->msg(Yii::app()->user->getFlash('done'), 'ok'); ?>
<?php else: ?>
    <?php echo $form; ?>
<?php endif ?>