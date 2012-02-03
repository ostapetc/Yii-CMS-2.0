<?php
$form = include "UserForm.php";

$form['activeForm']['enableAjaxValidation'] = true;

unset($form['elements']['status']);
unset($form['elements']['role']);

$form['buttons']['submit']['value'] = 'Зарегистрироваться';

return $form;
