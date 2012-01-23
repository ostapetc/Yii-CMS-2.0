<?php

$this->tabs = array(
    'добавить мета-тег' => $this->createUrl('create')
);

$this->widget('GridView', array(
	'id' => 'meta-tag-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		array(
            'name'   => 'model_id',
            'value'  => '$data->model_name',
            'filter' => false,
            'type'   => 'raw'
        ),
		array(
            'name'   => 'object_id',
            'header' => 'Объект',
            'value'  => '$data->object',
            'filter' => false,
            'type'   => 'raw'
        ),
		array('name' => 'title'),
        array('name' => 'description'),
        array('name' => 'keywords'),
		array(
            'name'   => 'date_create',
            'filter' => false
        ),
		array(
			'class' => 'CButtonColumn',
		),
	),
)); 

