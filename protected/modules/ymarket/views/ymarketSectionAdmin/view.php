<?php

$this->tabs = array(
    'все разделы'   => $this->createUrl('manage'),
    'редактировать' => $this->createUrl('update', array('id' => $model->id))
);

$brands = $model->brands ? implode('<br/> ', ArrayHelper::extract($model->brands, 'name')) : "";

$this->widget('DetailView', array(
	'data' => $model,
	'attributes' => array(
		'name',
		'yandex_name',
		'url',
        'all_models_url',
        'brands_url',
		array('name' => 'breadcrumbs', 'value' => strip_tags($model->breadcrumbs)),
		'date_create',
        'date_update',
        'date_brand_update',
        'date_pages_parse',
        array(
            'name'  => 'brands',
            'value' => $brands,
            'type'  => 'raw'
        ),
	),
)); 


