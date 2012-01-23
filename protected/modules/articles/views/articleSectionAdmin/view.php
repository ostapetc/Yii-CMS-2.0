<?php
$this->page_title = 'Просмотр раздела';

$this->tabs = array(
    "управление разделами"  => $this->createUrl('manage'),
    "редактировать" => $this->createUrl('update', array('id' => $model->id))
);

$this->widget('DetailView', array(
	'data' => $model,
	'attributes' => array(
		'name',
		array('name' => 'lang', 'value' => $model->language->name),		
		array('name' => 'parent_id', 'value' =>  $model->parent ? $model->parent->name : null),
		array('name' => 'in_sidebar', 'value' => $model->in_sidebar ? "Да" : "Нет"),
		'date_create',
	),
)); 
?>

