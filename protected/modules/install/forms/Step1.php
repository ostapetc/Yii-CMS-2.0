<?
return array(
    'inputElementClass' => 'AdminFormInputElement',
    'activeForm' => array(
        'id' => 'step1',
    ),
    'elements'   => array(
        '<b>Настройки базы данных:</b>',
        'db_host'               => array('type' => 'text', 'hint' => 'В большинстве случаев localhost'),
        'db_name'               => array('type' => 'text', 'hint' => 'Если не существует будет создана'),
        'db_login'              => array('type' => 'text'),
        'db_pass'               => array('type' => 'password'),
    ),
    'buttons'    => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => 'Продолжить',
            'id'    => 'feedback_button'
        )
    )
);
