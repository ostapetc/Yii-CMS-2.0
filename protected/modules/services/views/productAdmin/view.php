<?php

$this->tabs = array(
    'управление продуктами' => $this->createUrl('manage'),
    'редактировать'         => $this->createUrl('update', array('id' => $model->id))
);

$this->widget('DetailView', array(
	'data' => $model,
	'attributes' => array(
		array('name' => 'name'),
		array(
            'name'  => 'is_published',
            'value' => $model->is_published ? "Да" : "Нет"
        ),
		array(
            'name'  => 'date_create',
            'value' => date('d.m.Y H:i', strtotime($model->date_create))
        ),
	),
)); 


