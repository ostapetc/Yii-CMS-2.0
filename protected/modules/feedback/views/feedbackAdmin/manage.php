<?php

$this->widget('AdminGridView', array(
	'id' => 'feedback-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		array('name' => 'name'),
		array('name' => 'email'),
		array(
            'name'  => 'text',
            'value' => 'TextHelper::cut($data->text, 80)'
        ),
        array(
            'name'  => 'topic_id',
            'value' => '$data->topic->name'
        ),
		array(
			'class'    => 'CButtonColumn',
            'template' => '{view} {delete}'
		),
	),
));
?>

