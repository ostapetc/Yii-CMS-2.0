<?
return array(
    'activeForm' => array(
        'id'                   => 'login-form',
        'enableAjaxValidation' => true,
        'clientOptions'        => array(
            'validateOnSubmit' => true,
            'validateOnChange' => true
        )
    ),
    'elements' => array(
        'email' => array(
            'type' => 'text',
            'id'   => 'login_email_input'
        ),
        'password' => array(
            'type' => 'password',
            'id'   => 'login_password_input'
        ),
//        'remember_me' => array(
//            'type' => 'checkbox'
//        )
    ),
    'buttons' => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => t('Войти')
        )
    )
);


