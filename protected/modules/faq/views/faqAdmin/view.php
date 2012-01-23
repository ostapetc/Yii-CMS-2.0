<?php
$this->page_title = 'Просмотр вопроса';

$this->tabs = array(
    "управление вопросами и ответами" => $this->createUrl("manage"),
    "редактировать" => $this->createUrl("update", array("id" => $model->id))
);

$this->widget('DetailView', array(
	'data' => $model,
	'attributes'=>array(
		array('name' => 'lang', 'value' => $model->language->name),	
		'first_name',
        'last_name',
        'patronymic',
        'phone',
        'email',
        'company',
        'position',
		array('name' => 'is_published', 'value' => ($model->is_published ? "Да" : "Нет")),
		'date_create',        
		array('name' => 'section_id', 'value' => $model->section->name),
		array('name' => 'question', 'type' => 'raw'),
		array('name' => 'answer', 'type' => 'raw'),
	),
)); 
?>
