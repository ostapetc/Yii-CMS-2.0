<?php

$this->tabs = array(
    'вертикальные баннеры'   => $this->createUrl('manage', array('is_big' => 0)),
    'горизонтальные баннеры' => $this->createUrl('manage', array('is_big' => 1)),
    'редактировать'          => $this->createUrl('update', array('id' => $model->id))
);

$this->widget('application.components.DetailView', array(
	'data' => $model,
	'attributes' => array(
		array('name' => 'name'),
        array('name' => 'page_id', 'value' => $model->page ? $model->page->title : null),
        array('name' => 'url'),
		array('name' => 'is_active', 'value' => $model->is_active ? "Да" : "Нет"),
		array('name' => 'date_start'),
		array('name' => 'date_end'),
        array(
            'name'  => 'image',
            'value' => $model->render(1),
            'type'  => 'raw'
        ),
	),
)); 


