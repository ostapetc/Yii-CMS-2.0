<?php
$this->page_title = 'Просмотр настройки';

$this->tabs = array(
    'Все настройки' => $this->createUrl('manage'),
    'Редактировать' => $this->createUrl('update', array('id' => $model->id))
);

$this->widget('BootDetailView', array(
	'data' => $model,
	'attributes' => array(
        'name',
		'code',
        array('label' => 'Значение', 'value' => $model->formated_value, 'type' => 'raw')
	),
));
?>
