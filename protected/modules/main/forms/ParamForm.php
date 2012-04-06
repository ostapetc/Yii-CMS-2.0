<?

if ($this->model->scenario == Param::SCENARIO_VALUE_UPDATE)
{
    $elements = array(
        'name'  => array(
            'type'     => 'text',
            'disabled' => true
        ),
        'value' => array('type' => $this->model->element)
    );
}
else
{
    $elements = array(
        'module_id' => array(
            'type'  => 'dropdownlist',
            'items' => CHtml::listData(AppManager::getModulesData(), 'dir', 'name'),
        ),
        'name' => array(
            'type' => 'text'
        ),
        'code' => array(
            'type' => 'text'
        ),
        'element' => array(
            'type'  => 'dropdownlist',
            'items' => Param::$elements
        )
    );
}

return array(
    'enctype'    => 'multipart/form-data',
    'activeForm' => array(
        'id'                   => 'setting-form',
    ),
    'elements' => $elements,
    'buttons'    => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => 'Сохранить'
        )
    )
);