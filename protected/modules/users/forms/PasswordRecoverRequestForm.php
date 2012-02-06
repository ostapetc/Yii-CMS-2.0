<?php

$form = include "UserForm.php";

$form['activeForm']['enableAjaxValidation'] = true;

$form['elements'] = array(
    'email'    => $form['elements']['email'],
    'captcha'    => array('type' => 'captcha', 'id'=>'recovery_captcha_input'),
);

return $form;