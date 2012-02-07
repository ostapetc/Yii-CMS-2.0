<?php

$form = include "UserForm.php";

unset($form['activeForm']['enableAjaxValidation']);
unset($form['activeForm']['clientOptions']);

$form['elements'] = array(
    'email'    => array('type' => 'text','id'=>'login_email_input'),
    'password' => array('type' => 'password','id'=>'login_password_input'),
);

$form['action']                     = Yii::app()->controller->createUrl('/users/user/login');
$form['buttons']['submit']['value'] = t('Войти');

return $form;