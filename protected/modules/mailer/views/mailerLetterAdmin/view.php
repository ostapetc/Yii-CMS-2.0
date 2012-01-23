<?php
$this->tabs = array(
    'управление рассылками' => $this->createUrl('manage'),
    'редактировать'         => $this->createUrl('update', array('id' => $model->id))
);

$this->widget('DetailView', array(
	'data' => $model,
	'attributes' => array(
        'date_create',
		array('name' => 'template_id', 'value' => $model->template ? $model->template->name : null),
		array('name' => 'subject', 'value' => $model->template ? $model->template->subject : $model->subject),
		array('name' => 'text', 'value' => $model->template ? $model->template->text : $model->text ,'type' => 'raw'),
        array('name' => 'Подписчики', 'value' => $this->widget('Recipients', array('users' => $model->users), 1), 'type' => 'raw')
	),
)); 


