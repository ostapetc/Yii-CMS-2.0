<?
$form = include "UserForm.php";

$form['activeForm']['id'] = 'registration-form';
$form['action'] = Yii::app()->controller->createUrl('/users/user/registration');

unset($form['elements']['status']);
unset($form['elements']['role']);
unset($form['elements']['captcha']);
unset($form['elements']['birthdate']);

$form['buttons']['submit']['value'] = 'Зарегистрироваться';

return $form;
