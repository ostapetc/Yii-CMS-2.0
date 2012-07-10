<?
$form = include "UserForm.php";
$form['activeForm']['id'] = 'cabinet-form';
unset($form['elements']['email']);
unset($form['elements']['status']);
unset($form['elements']['role']);
unset($form['elements']['password']);
unset($form['elements']['password_c']);
return $form;

