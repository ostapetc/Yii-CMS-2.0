<?php
Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl() . '/js/menuTreeView.js');

$this->page_title = $this->page_title . ' :: ' . $menu->name;

$this->tabs = array(
    $this->t('admin', 'manage')  => $this->createUrl("menuAdmin/manage"),
    $this->t('admin', 'create')  => $this->createUrl('create', array('menu_id' => $menu->id))
);

$this->widget('TreeView',array(
    'url' => '/content/menuLinkAdmin/AjaxFillTree?menu_id=' . $menu->id,
    'collapsed' => true
));
?>
