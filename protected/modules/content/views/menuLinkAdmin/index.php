<?php
Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl() . '/js/menuTreeView.js');

$this->page_title = $this->page_title . ' :: ' . $menu->name;

$this->tabs = array(
    "управление меню" => $this->createUrl("menuAdmin/manage"),
    "добавить ссылку" => $this->createUrl('create', array('menu_id' => $menu->id))
);

$this->widget('TreeView',array(
    'url' => '/content/menuLinkAdmin/AjaxFillTree?menu_id=' . $menu->id,
    'collapsed' => true
));
?>
