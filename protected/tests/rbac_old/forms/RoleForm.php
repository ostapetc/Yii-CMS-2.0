<?

$roles = Yii::app()->authManager->getRoles();

return array(
    'activeForm' => array(
        'id'                   => 'rbac-role-form',
    ),
    'elements'   => array(
        'name'        => array('type' => 'text'),
        'description' => array('type' => 'text'),
        //'parent' => array(
        //    'label'  => 'Наследуется от',
        //    'type'   => 'dropdownlist',
        //    'prompt' => 'не выбрано',
        //    'items'  => CHtml::listData($roles, 'name', 'description')
        //),
        'bizrule'     => array('type' => 'textarea'),
        'data'        => array('type' => 'textarea')
    ),
    'buttons'    => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => $this->model->isNewRecord ? 'Создать' : 'Сохранить'
        )
    )
);
