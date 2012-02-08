<?php
$this->page_title = 'Просмотр настройки';

$this->widget('AdminDetailView', array(
	'data' => $model,
	'attributes' => array(
        'name',
		'code',
        array('label' => 'Значение', 'value' => $model->value, 'type' => 'raw')
	),
));
?>
