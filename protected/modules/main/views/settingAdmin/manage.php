<?
if (isset($module_name))
{
    $this->page_title.= " :: {$module_name}";
}
//
//$this->tabs = array(
//    'Добавить настройку' => $this->createUrl('create')
//);




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
			'template' => '{view} {update}'
		),
	),
));



