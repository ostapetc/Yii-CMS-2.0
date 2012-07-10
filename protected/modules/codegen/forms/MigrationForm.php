<?

$tables = Yii::app()->db->schema->tableNames;
$tables = array_combine($tables, $tables);

return array(
    'activeForm'=>array(
        'id'                   => 'migration-form',
        'enableAjaxValidation' => false
    ),
    'elements' => array(
        'module' => array(
            'type'  => 'dropdownlist',
            'items' => AppManager::getModulesNames(),
            'label' => t('Модуль')
        ),
        'table' => array(
            'type'  => 'dropdownlist',
            'items' => $tables,
            'label' => t('Таблица')
        ),
    ),
    'buttons' => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => t('Создать')
        )
    )
);

