<?php

$this->tabs = array(
    'управление банерами' => $this->createUrl('manage'),
    'редактировать'       => $this->createUrl('update', array('id' => $model->id))
);

$this->widget('DetailView', array(
	'data' => $model,
	'attributes' => array(
		array('name' => 'name'),
        array('name' => 'page_id', 'value' => $model->page ? $model->page->title : null),
        array('name' => 'url'),
		array('name' => 'is_active', 'value' => $model->is_active ? "Да" : "Нет"),
		array('name' => 'date_start'),
		array('name' => 'date_end'),
        array(
            'name'  => 'Роли',
            'value' => implode("<br/>", CHtml::listData($model->roles, "name", "description")),
            'type'  => 'raw'
        ),
        array(
            'name'  => 'image',
            'value' => $model->render(1),
            'type'  => 'raw'
        ),
	),
)); 


