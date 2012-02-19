<?php
Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl() . '/js/menuTreeView.js');

$this->page_title = $this->page_title . ' :: ' . $menu->name;

$this->tabs = array(
    "управление меню" => $this->createUrl("menuAdmin/manage"),
    "добавить раздел" => $this->createUrl('create', array('menu_id' => $menu->id))
);

$this->widget('application.components.TreeView',array(
    'url' => '/content/MenuSectionAdmin/AjaxFillTree?menu_id=' . $menu->id,
    'collapsed' => true
));
?>
