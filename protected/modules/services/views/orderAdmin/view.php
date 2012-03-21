<?php

$this->tabs = array(
    'управление заказами' => $this->createUrl('manage')
);

$this->widget('DetailView', array(
	'data' => $model,
	'attributes' => array(
		array('name' => 'name'),
		array('name' => 'email'),
        array(
            'name'   => 'product_id',
            'value'  => $model->product->name
        ),
		array('name' => 'action_code'),
        array('name' => 'date_create'),
		array('name' => 'comment'),
	),
)); 


