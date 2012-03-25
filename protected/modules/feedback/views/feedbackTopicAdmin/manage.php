<?php
$this->crumbs = array(
    'Список тем'
);

$this->tabs = array(
    'Добавить тему' => $this->createUrl('create')
);

$this->widget('AdminGridView', array(
	'id' => 'feedback-topic-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		array('name' => 'name'),
		array('name' => 'email'),
		array(
			'class'    => 'CButtonColumn',
            'template' => '{update} {delete}'
		),
	),
)); 
?>
