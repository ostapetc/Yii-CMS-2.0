<?
return array(
    'activeForm' => array(
        'id'                   => 'registration-form',
        'enableAjaxValidation' => true,
    ),
    'elements' => array(
        'name'  => array(
            'type' => 'text'
        ),
        'email' => array(
            'type' => 'text',
        ),
        'password' => array(
            'type' => 'password',
        ),
        'password_c' => array(
            'type' => 'password',
        ),
    ),
    'buttons' => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => t('Войти')
        )
    )
);


