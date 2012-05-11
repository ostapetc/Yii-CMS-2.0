<?
$form = include "UserForm.php";

$form['activeForm'] = array(
    'id'                   => 'login-form',
    'enableAjaxValidation' => false,
    'clientOptions'        => array('validateOnSubmit' => false)
);

$form['elements'] = array(
    'email'    => array(
        'type' => 'text',
        'id'   => 'login_email_input'
    ),
    'password' => array(
        'type' => 'password',
        'id'   => 'login_password_input'
    )
);

$form['buttons']['submit']['value'] = t('Войти');

return $form;