<?php
$this->page_title = 'Просмотр';

$this->tabs = array(
    "управление документами" => $this->createUrl('manage'),
    "редактировать"          => $this->createUrl('update', array('id' => $model->id))
);

$this->widget('DetailView', array(
	'data' => $model,
	'attributes' => array(
		'name',
		array('name' => 'lang', 'value' => $model->language->name),		
		array('name' => 'is_published', 'value' => $model->is_published ? 'Да' : 'Нет'),
		'date_publish',
		'date_create',
		array('name' => 'desc', 'type' => 'raw')
	),
)); 
?>

