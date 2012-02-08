<?php

$form = include "UserForm.php";

$form['activeForm']['id'] = 'login-form';

$form['elements'] = array(
    'email'    => array('type' => 'text','inputID'=>'login_email_input'),
    'password' => array('type' => 'password','inputID'=>'login_password_input'),
);

$form['action']                     = Yii::app()->controller->createUrl('/users/user/login');
$form['buttons']['submit']['value'] = t('Войти');

return $form;