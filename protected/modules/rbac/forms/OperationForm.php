<?php

Yii::app()->clientScript->registerScriptFile(Yii::app()->getModule('rbac')->assetsUrl() . '/js/rbac.js');

$actions = array();

if (!$this->model->isNewRecord)
{
    $this->model->module = AppManager::getActionModule($this->model->name);

    $actions = AppManager::getModuleActions($this->model->module);
}


$form = array(
    'activeForm' => array(
        'id'                   => 'rbac-operation-form',
        'enableAjaxValidation' => true,
    ),
    'elements'   => array(
        'module'        => array(
            'type'   => 'dropdownlist',
            'items'  => CHtml::listData(AuthItem::model()->getModulesWithActions(), 'class', 'name'),
            'label'  => 'Модуль',
            'prompt' => 'не выбран'
        ),
        'name'          => array(
            'type'   => 'dropdownlist',
            'prompt' => 'не выбрано',
            'items'  => $actions
        ),
        'description'   => array('type' => 'text'),
        'allow_for_all' => array('type' => 'checkbox'),
        'bizrule'       => array('type' => 'textarea'),
        'data'          => array('type' => 'textarea')
    ),
    'buttons'    => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => $this->model->isNewRecord ? 'Создать' : 'Сохранить'
        )
    )
);

if (!$this->model->isNewRecord)
{
    $form["elements"]["module"]["type"]     = "text";
    $form["elements"]["module"]["disabled"] = true;

    $form["elements"]["name"]["type"]     = "text";
    $form["elements"]["name"]["disabled"] = true;
}

return $form;
