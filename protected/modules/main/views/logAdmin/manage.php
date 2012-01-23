<?php $this->page_title = 'Просмотр логов'; ?>

<?php
$this->widget('AdminGrid', array(
	'id' => 'grid',
	'dataProvider' => $model->search(),
    'filter' => $model,
	'columns' => array(
		array('name' => 'message'),
		'level',
        array('name' => 'logtime', 'filter' => false),
        array(
            'class'    => 'CButtonColumn',
            'template' => ''
        )
	),
));
?>