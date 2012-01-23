<?php

$this->tabs = array(
    'добавить' => $this->createUrl('create')
);

$this->widget('GridView', array(
	'id' => 'ymarket-ip-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'template' => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
	'columns' => array(
		'ip',
		'last_date_use',
		array(
			'class'=>'CButtonColumn',
            'template' =>'{update} {delete}'
		),
	),
)); 

