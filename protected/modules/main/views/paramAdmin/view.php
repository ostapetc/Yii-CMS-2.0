<?
$this->page_title = 'Просмотр параметра';

$this->tabs = array(
    'Все параметры'          => $this->createUrl('manage'),
    'Редактировать значение' => $this->createUrl('update', array('id' => $model->id, 'scenario' => Param::SCENARIO_VALUE_UPDATE)),
    'Редактировать св-ва'    => $this->createUrl('update', array('id' => $model->id)),
);

$this->widget('BootDetailView', array(
	'data' => $model,
	'attributes' => array(
        'name',
		'code',
        array(
            'name'  => 'element',
            'value' => Param::$elements[$model->element]
        ),
        array('label' => 'Значение', 'value' => $model->formated_value, 'type' => 'raw')
	),
));
?>
