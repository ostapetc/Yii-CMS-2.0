<? $this->page_title = $page->title; ?>
<br/>

<? if (Yii::app()->user->hasFlash('success')): ?>
    <? echo $this->msg(t(Yii::app()->user->getFlash('success')), 'success'); ?>
<? endif ?>

<? echo $page->content; ?>

