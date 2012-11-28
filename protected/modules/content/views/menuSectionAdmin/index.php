<?
Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl() . '/js/menuTreeView.js');

$this->page_title = $this->page_title . ' :: ' . $menu->name;

$this->tabs = [
    "управление меню" => $this->createUrl("menuAdmin/manage"),
    "добавить раздел" => $this->createUrl('create', ['menu_id' => $menu->id])
];

$this->widget('application.components.TreeView',[
    'url' => '/content/MenuSectionAdmin/AjaxFillTree?menu_id=' . $menu->id,
    'collapsed' => true
]);
