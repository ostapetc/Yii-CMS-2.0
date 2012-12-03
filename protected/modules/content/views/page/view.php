<?
$this->page_title = $page->title;
if (Yii::app()->user->checkAccess('Page_update'))
{

}
?>

<? if (Yii::app()->user->hasFlash('success')): ?>
    <? echo $this->msg(t(Yii::app()->user->getFlash('success')), 'success'); ?>
<? endif ?>

<? if ($page->status == Page::STATUS_UNPUBLISHED): ?>
    <?= $this->msg('Страница неопубликована!', Controller::MSG_ERROR); ?>
<? elseif ($page->status == Page::STATUS_DRAFT): ?>
    <?= $this->msg('Страница находится в черновике!', Controller::MSG_ERROR); ?>
<? endif ?>

<? if (($page->status == Page::STATUS_PUBLISHED)  || ($page->user_id == Yii::app()->user->id)): ?>
    <div class="page">
        <? if ($page->image_src): ?>
            <?=
            CHtml::link(
                CHtml::image($page->image_src, '', ['class' => 'img-rounded']),
                $page->url,
                [
                    'class' => 'page-img'
                ]
            );
            ?>
        <? endif ?>

        <?= $page->text ?>

        <? $this->renderPartial('application.modules.content.views.page._infoPanel', ['page' => $page, 'preview' => true]); ?>
        <? $this->renderPartial('tags.views._list', ['tags' => $page->tags]); ?>

        <br clear="all" />

        <? $this->widget('comments.portlets.CommentsPortlet', ['model' => $page]); ?>
    </div>
<? endif ?>


