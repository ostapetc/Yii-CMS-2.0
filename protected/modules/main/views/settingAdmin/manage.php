<?php
if (isset($module_name))
{
    $this->page_title.= " :: {$module_name}";
}

$this->widget('AdminGrid', array(
	'id' => 'settings-grid',
	'dataProvider' => $model->search(isset($module_id) ? $module_id : null),
	'filter' => $model,
	'columns' => array(
        array('name' => 'module_id', 'value' => 'AppManager::getModuleName($data->module_id)'),
		'name',
        array('name' => 'value', 'value' => 'Yii::app()->text->cut($data->value, 50);', 'type' => 'raw'),

		array(
			'class'=>'CButtonColumn',
			'template' => '{view}{update}'
		),
	),
));

