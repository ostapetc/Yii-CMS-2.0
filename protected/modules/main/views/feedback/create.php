<? $this->page_title = Yii::t('MainModule.main', 'Обратная связь'); ?>

<? if (Yii::app()->user->hasFlash('feedback_done')): ?>
    <? echo $this->msg(Yii::app()->user->getFlash('feedback_done'), 'ok'); ?>
<? endif ?>

<? echo $form; ?>





