<? $this->renderPartial('application.views.layouts._header'); ?>

<? Yii::app()->clientScript->registerCssFile('/css/site/middle.css'); ?>

<div class="span12" style="width: 100%">
    <div class="well middle-well">
        <? if ($this->page_title): ?>
            <h1><?= $this->page_title ?></h1>
        <? endif ?>

        <? foreach (Yii::app()->user->getFlashes() as $type => $message): ?>
            <?= $this->msg($message, $type) ?>
        <? endforeach ?>

        <? echo $content ?>
    </div>
</div>

<? $this->renderPartial('application.views.layouts._footer'); ?>
