<?php
$this->page_title = 'Просмотр материала';

$this->tabs = array(
    "управление материалами" => $this->createUrl('manage'),
    "редактировать"          => $this->createUrl('update', array('id' => $model->id))
);

$this->widget('DetailView', array(
	'data' => $model,
	'attributes' => array(
		array('name' => 'title'),
		array('name' => 'lang', 'value' => $model->language->name),		
        array('name' => 'section_id', 'value' => $model->section->name),
		'date',
		'date_create',
		array(
			'name' => 'text', 
			'type' => 'raw'
		)
	),
)); 
?>
