<?php

$this->widget('AdminGridView', array(
	'id' => 'order-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		array('name' => 'name'),
		array('name' => 'email'),
        array(
            'name'   => 'product_id',
            'value'  => '$data->product->name',
            'filter' => CHtml::listData(Product::model()->findAll(), 'id', 'name')
        ),
		array('name' => 'action_code'),
		array('name' => 'comment'),
		array(
            'name'  => 'date_create',
            //'value' => '$dat'
        ),
		array(
			'class'    => 'CButtonColumn',
            'template' => '{view} {delete}'
		),
	),
)); 

