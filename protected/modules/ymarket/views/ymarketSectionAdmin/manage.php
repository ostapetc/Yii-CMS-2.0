<?php

$this->tabs = array(
    'добавить' => $this->createUrl('create')
);

$this->widget('GridView', array(
	'id' => 'ymarket-section-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'template' => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
	'columns' => array(
		'name',
		'yandex_name',
		'date_create',
        'date_update',
        'date_brand_update',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); 

