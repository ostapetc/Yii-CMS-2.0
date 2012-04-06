<?

return array(
    'activeForm' => array(
        'id'    => 'menu-form',
    ),
    'elements' => array(
        'name'         => array('type' => 'text'),
        'code'         => array('type' => 'text'),
        'is_published' => array('type' => 'checkbox')
    ),
    'buttons' => array(
        'submit' => array('type' => 'submit', 'value' =>  $this->model->isNewRecord ? 'Далее' : 'Сохранить'),
    )
);