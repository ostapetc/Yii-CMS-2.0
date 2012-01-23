<?php

$this->widget('GridView', array(
    'id' => 'ymarket-cron-grid',
    'template' => '{summary}<br/>{pager}<br/>{items}<br/>{pager}',
    'dataProvider' => $model->search(),
    'filter' => $model,
	'columns' => array(
		'name',
        array(
            'name'   => 'is_active',
            'value'  => '$data->is_active ? "Да" : "Нет"',
            'filter' => false
        ),
        array(
            'name'   => 'priority',
            'filter' => false
        ),
        array(
            'name'   => 'interval',
            'filter' => false
        ),
        array(
            'name'   => 'date_of',
            'filter' => false
        ),
		array(
			'class'=>'CButtonColumn',
            'template' =>'{update}',

		),

	),
));