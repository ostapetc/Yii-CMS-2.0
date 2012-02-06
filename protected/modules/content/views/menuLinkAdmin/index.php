<?php
Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl() . '/js/menuTreeView.js');

$this->page_title = $this->page_title . ' :: ' . $menu->name;

$this->widget('TreeView',array(
    'url' => '/content/menuLinkAdmin/AjaxFillTree?menu_id=' . $menu->id,
    'collapsed' => true
));
?>
