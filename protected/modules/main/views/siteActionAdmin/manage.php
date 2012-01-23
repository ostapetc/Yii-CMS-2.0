<?php

$this->widget('AdminGrid', array(
	'id' => 'site-action-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		'title',
		array('name' => 'user_id', 'value' => '$data->user ? $data->user->name : null'),
		'object_id',
		'module',
		'controller',
		'action',
		'date_create',
		array(
			'class'=>'CButtonColumn',
			'template' => ''
		),
	),
)); 

