<?
$this->page_title = 'Просмотр параметра';

$this->tabs = array(
    'Все параметры'          => $this->createUrl('manage'),
    'Редактировать значение' => $this->createUrl('update', array('id' => $model->id, 'scenario' => Param::SCENARIO_VALUE_UPDATE)),
    'Редактировать параметр' => $this->createUrl('update', array('id' => $model->id)),
);

$attributes = array(
    'name',
    'code',
    array(
        'name'  => 'element',
        'value' => Param::$elements[$model->element]
    ),
    array(
        'label' => 'Значение',
        'value' => $model->formated_value,
        'type'  => 'raw'
    )
);

if ($model->element == Param::ELEMENT_SELECT)
{
    $attributes[] = array(
        'name'  => 'options',
        'value' => nl2br($model->options),
        'type'  => 'raw'
    );
}

$this->widget('BootDetailView', array(
	'data'       => $model,
	'attributes' => $attributes
));
?>
