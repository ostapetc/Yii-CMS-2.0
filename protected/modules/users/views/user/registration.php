<? $this->page_title = "Регистрация"; ?>

<? if (Yii::app()->user->hasFlash('done')): ?>
    <? echo $this->msg(Yii::app()->user->getFlash('done'), 'ok'); ?>
<? else: ?>
    <? echo $form; ?>
<? endif ?>