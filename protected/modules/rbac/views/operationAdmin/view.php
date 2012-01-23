<?php
$this->page_title = 'Просмотр операции';

$this->tabs = array(
    'операции'      => $this->createUrl('manage'),
    'редактировать' => $this->createUrl('update', array('id' => $model->name)),
    'добавить'      => $this->createUrl('create')
);

$this->widget('DetailView', array(
    'data' => $model,
    'attributes' => array(
        'name',
        'description',
        array('name' => 'allow_for_all', 'value' => $model->allow_for_all ? 'Да' : 'Нет'),
        'bizrule',
        'data'
    )
));
