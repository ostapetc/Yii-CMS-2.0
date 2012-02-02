<?php
$this->page_title = 'Управление';

$this->widget('AdminGrid', array(
	'id' => 'language-grid',
	'dataProvider' => $model->search(),
	'filter'   => $model,
	'columns'  => array(
	    'id',
		'name',
		array(
			'class' => 'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); 

