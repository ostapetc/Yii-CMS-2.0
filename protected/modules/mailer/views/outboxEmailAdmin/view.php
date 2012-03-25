<?php

$this->tabs = array(
    'исходящие письма' => $this->createUrl('manage'),

);

$this->widget('DetailView', array(
	'data' => $model,
	'attributes' => array(
		array('name' => 'email'),
		array('name' => 'user_name'),
		array('name' => 'solution'),
		array('name' => 'subject'),
        array(
            'name'  => 'date_create',
            'value' => $model->date_create != '0000-00-00 00:00:00' ? date('d.m.Y H:i', strtotime($model->date_create)) : null
        ),
      	array(
              'name'  => 'date_send',
              'value' => $model->date_send != '0000-00-00 00:00:00' ? date('d.m.Y H:i', strtotime($model->date_send)) : null
        ),
        array(
            'name'  => 'status',
            'value' => $model->status_caption
        ),
        array('name' => 'log'),
		array(
            'name' => 'text',
            'type' => 'raw'
        ),
	),
)); 


