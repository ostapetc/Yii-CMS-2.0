<?php

$this->tabs = array(
    'добавить' => $this->createUrl('create')
);

$this->widget('GridView', array(
	'id' => 'ymarket-product-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'template' => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
	'columns' => array(
		array('name' => 'brand_id', 'value' => '$data->brand->name'),
		'name',
		array(
            'name' => 'image',
            'value'    => '$data->getImageHtml(true)',
            'type'     => 'raw',
            'sortable' => false,
            'filter'   => false
        ),
		array(
            'name'   => 'date_create',
            'filter' => false
        ),
		array(
            'name'   => 'date_update',
            'filter' => false
        ),
		array(
			'class'=>'CButtonColumn',
            'template' => '{view}'
		),
	),
)); 

