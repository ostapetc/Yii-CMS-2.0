<?php $this->page_title = Yii::t('MainModule.main', 'Обратная связь'); ?>

<?php if (Yii::app()->user->hasFlash('feedback_done')): ?>
    <?php echo $this->msg(Yii::app()->user->getFlash('feedback_done'), 'ok'); ?>
<?php endif ?>

<?php echo $form; ?>





