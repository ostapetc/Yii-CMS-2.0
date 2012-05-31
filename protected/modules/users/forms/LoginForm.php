<?
$form = include "UserForm.php";

$form['action'] = Yii::app()->createUrl('/users/user/login');

$form['activeForm'] = array(
    'id'                   => 'login-form',
    'enableAjaxValidation' => true,
    'clientOptions'        => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true
    )
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