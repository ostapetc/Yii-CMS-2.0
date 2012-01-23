<?php
$this->page_title = 'Просмотр определения';

$this->tabs = array(
    "управление определениями" => $this->createUrl('manage'),
    "редактировать"        => $this->createUrl('update', array('id' => $model->id))
);

$this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
		array('name' => 'title'),
		array(
			'name'  => 'state', 
			'value' => Glossary::$states[$model->state]
		),
		array(
			'name' => 'text', 
			'type' => 'raw'
		)
	),
)); 
?>
