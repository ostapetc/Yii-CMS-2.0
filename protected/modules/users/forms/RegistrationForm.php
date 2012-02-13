<?php
$form = include "UserForm.php";

$form['activeForm']['id'] = 'registration-form';

unset($form['elements']['status']);
unset($form['elements']['role']);

$form['buttons']['submit']['value'] = 'Зарегистрироваться';

$form['action'] = Yii::app()->controller->createUrl('/users/user/registration');

return $form;
