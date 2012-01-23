<?php

Yii::app()->clientScript->registerScriptFile(Yii::app()->getModule('rbac')->assetsUrl() . '/js/rbac.js');

$operations = AuthItem::model()
    ->findAllByAttributes(array('type'  => AuthItem::TYPE_OPERATION), array('order' => 'name'));


if (isset($_POST['AuthItem']['operations']))
{
    $this->model->operations = $_POST['AuthItem']['operations'];
}
else if (!$this->model->isNewRecord)
{
    $model_operations = $this->model->operations;
    $operations_names = array();

    foreach ($model_operations as $operation)
    {
        $operations_names[] = $operation->name;
    }

    $this->model->operations = $operations_names;
}

return array(
    'activeForm' => array(
        'id'                   => 'rbac-task-form',
        'enableAjaxValidation' => true,
    ),
    'elements'   => array(
        'name'          => array('type' => 'text'),
        'description'   => array('type' => 'text'),
        'allow_for_all' => array('type' => 'checkbox'),
        'operations'    => array(
            'type'   => 'multi_select',
            'items'  => CHtml::listData($operations, 'name', 'description'),
            'params' => array('height' => '400px'),
        ),
        'childs'        => array(
            'type'  => 'hidden',
            'value' => CJSON::encode(AuthItemChild::model()->findAll()),
            'id'    => 'childs'
        ),
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
