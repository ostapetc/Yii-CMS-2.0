<?php
$this->page_title = 'Просмотр настройки';

$this->widget('BootDetailView', array(
	'data' => $model,
	'attributes' => array(
        'name',
		'code',
        array('label' => 'Значение', 'value' => $model->value, 'type' => 'raw')
	),
));
?>
