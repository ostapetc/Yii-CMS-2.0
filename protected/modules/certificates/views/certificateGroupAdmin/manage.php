<?php

$this->tabs = array(
    'добавить группу' => $this->createUrl('create')
);

$this->widget('AdminGrid', array(
	'id' => 'certificate-group-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		'name',
        array('name' => 'date_create', 'filter' => false),
		array(
			'class'    => 'CButtonColumn',
            'template' => '{update} {delete}'
		),
	),
)); 

