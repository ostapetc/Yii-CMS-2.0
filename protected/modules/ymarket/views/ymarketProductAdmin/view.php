<?php
$this->tabs = array(
    'все продукты'  => $this->createUrl('manage')
);

$this->widget('DetailView', array(
	'data' => $model,
	'attributes' => array(
		array('name' => 'brand_id', 'value' => $model->brand->name),
		'name',
		array('name' => 'image', 'value' => $model->getImageHtml(), 'type' => 'raw'),
		'date_create',
		'date_update',
	),
)); 


