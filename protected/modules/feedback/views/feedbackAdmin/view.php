<?php

$this->tabs = array(
    'Полученные сообщения' => $this->createUrl('manage'),
);

$this->widget('DetailView', array(
	'data' => $model,
	'attributes' => array(
		array(
            'name'  => 'topic_id',
            'value' => $model->topic->name
        ),
		array('name' => 'name'),
		array('name' => 'email'),
		array('name' => 'text'),
	),
)); 


