<?php
function getValue($value)
{
    $max_length = 50;

    if (mb_strlen($value, 'utf-8') > $max_length)
    {
        $value = mb_substr($value, 0, $max_length, "utf-8") . '...';
    }

    return $value;
}

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
        array('name' => 'value', 'value' => 'getValue($data->value)', 'type' => 'raw'),
		array(
			'class'=>'CButtonColumn',
			'template' => '{view}{update}'
		),
	),
));

