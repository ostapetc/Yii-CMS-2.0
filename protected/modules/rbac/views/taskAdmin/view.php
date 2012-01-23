<?php

$this->tabs = array(
    'задачи'        => $this->createUrl('manage'),
    'редактировать' => $this->createUrl('update', array('id' => $model->name)),
    'добавить'      => $this->createUrl('create')
);

$operations = array();

if ($model->operations) 
{
    foreach ($model->operations as $child) 
    {
        $operations[] = $child->description;
    }
}

$operations = implode("<br/>", $operations);

$this->widget('DetailView', array(
    'data' => $model,
    'attributes' => array(
        'name',
        'description',
        array('name' => 'allow_for_all', 'value' => $model->allow_for_all ? 'Да' : 'Нет'),
        'bizrule',
        'data',
        array('label' => 'Операции', 'value' => $operations ? $operations : null, 'type' => 'raw')
    )
));


