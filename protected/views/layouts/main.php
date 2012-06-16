<? $this->renderPartial('application.views.layouts._header'); ?>
<div class="span8">
    <? if ($this->page_title): ?>
        <h1><?= $this->page_title ?></h1>
    <? endif ?>

    <? echo $content ?>
</div>
<div class="span4">
    <div class="well">
        <?
            $this->clips['sidebar'] .= $this->widget('sidebarManager', array() , true);
            $this->renderClip('sidebar');
        ?>
    </div>
</div>

<? $this->renderPartial('application.views.layouts._footer'); ?>
