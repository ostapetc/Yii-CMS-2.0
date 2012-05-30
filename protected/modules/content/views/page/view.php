<? $this->page_title = $page->title; ?>
<br/>

<? if (Yii::app()->user->hasFlash('success')): ?>
    <? echo $this->msg(t(Yii::app()->user->getFlash('success')), 'success'); ?>
<? endif ?>

<? if ($page->status == Page::STATUS_UNPUBLISHED): ?>
    <?= $this->msg('Страница неопубликована!', Controller::MSG_ERROR); ?>
<? elseif ($page->status == Page::STATUS_DRAFT): ?>
    <?= $this->msg('Страница находится в черновике!', Controller::MSG_ERROR); ?>
<? endif ?>

<? if (($page->status == Page::STATUS_PUBLISHED)  || ($page->user_id == Yii::app()->user->id)): ?>
    <?
    $this->renderPartial('_view', array(
        'data'    => $page,
        'preview' => false
    ));
    ?>
<? endif ?>


