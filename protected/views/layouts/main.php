<? $this->renderPartial('application.views.layouts._header'); ?>

<div class="span10">
    <? if ($this->page_title): ?>
        <h1><?= $this->page_title ?></h1>
    <? endif ?>

    <? echo $content ?>
</div>

<div class="span4">
    <? $this->widget('sidebarManager'); ?>

    <div class="well">
        standart sidebar
    </div>
</div>

<? $this->renderPartial('application.views.layouts._footer'); ?>
