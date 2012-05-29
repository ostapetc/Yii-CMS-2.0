<?
$form = include "UserForm.php";

$form['activeForm']['id'] = 'registration-form';

unset($form['elements']['status']);
unset($form['elements']['role']);
unset($form['elements']['captcha']);
unset($form['elements']['birthdate']);
unset($form['elements']['gender']);

$form['buttons']['submit']['value'] = 'Зарегистрироваться';

return $form;
