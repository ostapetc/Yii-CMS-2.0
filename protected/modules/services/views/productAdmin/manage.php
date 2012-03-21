<?php

$this->tabs = array(
    'добавить продукт' => $this->createUrl('create')
);

$this->widget('AdminGridView', array(
	'id'           => 'product-grid',
	'dataProvider' => $model->search(),
	'filter'       => $model,
    'sortable'     => true,
	'columns'      => array(
		array('name' => 'name'),
		array(
            'name'  => 'is_published',
            'value' => '$data->is_published ? "Да" : "Нет"'
        ),
		array(
            'name'  => 'date_create',
            'value' => 'date("d.m.Y H:i", strtotime($data->date_create))'
        ),
		array(
			'class' => 'CButtonColumn',
		),
	),
)); 

