<?
$form = include "UserForm.php";

$form['activeForm']['enableAjaxValidation'] = false;

$form['elements'] = array(
    'email'    => $form['elements']['email'],
    'captcha'  => $form['elements']['captcha']
);

$form['buttons']['submit']['value'] = 'Далее';

return $form;