<?php
$form = include "UserForm.php";

$form['activeForm']['enableAjaxValidation'] = false;

$form['elements'] = array(
    'password'   => $form['elements']['password'],
    'password_c' => $form['elements']['password_c']
);

return $form;