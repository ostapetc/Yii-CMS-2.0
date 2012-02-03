<?php

$form = include "UserForm.php";

$form['activeForm']['enableAjaxValidation'] = true;

$form['elements'] = array(
    'email'    => $form['elements']['email'],
    'captcha'  => $form['elements']['captcha']
);

return $form;