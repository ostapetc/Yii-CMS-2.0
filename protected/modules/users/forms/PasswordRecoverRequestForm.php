<?php

$form = include "UserForm.php";

$form['activeForm']['id'] = 'password-recovery-form';

$form['elements'] = array(
    'email'    => $form['elements']['email'],
    'captcha'  => array('type' => 'captcha', 'id'=>'recovery_captcha_input'),
);
$form['action'] = Yii::app()->controller->createUrl('/users/user/changePasswordRequest');

return $form;