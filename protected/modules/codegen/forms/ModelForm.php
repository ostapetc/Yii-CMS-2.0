<?

return array(
    'activeForm'=>array(
        'id' => 'model-form',
    ),
    'elements' => array(
        'table' => array(
            'type' => 'text'
        ),
        'class' => array(
            'type' => 'text'
        ),
        'name' => array(
            'type' => 'text'
        ),
        'module' => array(
            'type'  => 'dropdownlist',
            'items' => CHtml::listData(AppManager::getModulesData(), 'dir', 'name'),
            'empty' => 'не выбран'
        ),
        'behaviors' => array(
            'type' => 'multi_select',
            'data' => array_flip(Model::$extra_behaviors),
        )
    ),
    'buttons' => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => t('Создать')
        ),
        'preview' => array(
            'type'  => 'button',
            'value' => 'Предпросмотр'
        )
    )
);

