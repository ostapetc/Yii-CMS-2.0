<?
$this->tabs = array(
    'Добавить параметр' => $this->createUrl('create')
);

$this->widget('AdminGridView', array(
	'id' => 'settings-grid',
	'dataProvider' => $model->search(isset($module_id) ? $module_id : null),
	'filter' => $model,
	'columns' => array(
        array('name' => 'module_id', 'value' => 'AppManager::getModuleName($data->module_id)'),
		'name',
        array('name' => 'value', 'value' => '$data->formated_value;', 'type' => 'raw'),

		array(
			'class'=>'CButtonColumn',
			'template' => '{updateValue} {view} {update}',
            'buttons'  => array(
                'updateValue' => array(
                    'imageUrl' => '/img/icons/floppy.png',
                    'label'    => 'Изменить значение',
                    'url'      => 'Yii::app()->controller->createUrl("update", array("id" => $data->id, "scenario" => "value_update"))'
                )
            )
		),
	),
));



