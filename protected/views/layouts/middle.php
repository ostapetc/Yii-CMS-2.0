<? $this->renderPartial('application.views.layouts._header'); ?>

<? Yii::app()->clientScript->registerCssFile('/css/site/middle.css'); ?>

<div class="span12">
    <h1><?= $this->page_title ?></h1>

    <? foreach (Yii::app()->user->getFlashes() as $type => $message): ?>
        <?= $this->msg($message, $type) ?>
    <? endforeach ?>

    <? echo $content ?>
</div>

<? $this->renderPartial('application.views.layouts._footer'); ?>
