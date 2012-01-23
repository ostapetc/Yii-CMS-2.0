<?php

$roles = AuthItem::model()->findAllByAttributes(array('type' => AuthItem::TYPE_ROLE));

return array(
    'activeForm'     => array(
        'id'                   => 'user-form',
        'class'                => 'CActiveForm',
        'enableAjaxValidation' => true,
    ),
    'elements'       => array(
        'email'      => array('type' => 'text'),
        'first_name' => array('type' => 'text'),
        'last_name'  => array('type' => 'text'),
        'patronymic' => array('type' => 'text'),
        'phone'      => array('type' => 'text'),
        'birthdate'  => array('type' => 'date'),
        'gender'     => array(
            'type'  => 'dropdownlist',
            'items' => User::$gender_list
        ),
        'status'     => array(
            'type'  => 'dropdownlist',
            'items' => User::$status_list
        ),
        'role'       => array(
            'type'  => 'dropdownlist',
            'items' => CHtml::listData($roles, 'name', 'description')
        ),
        'password'   => array('type' => 'password'),
        'password_c' => array('type' => 'password'),
        'captcha'    => array(
            'type' => 'captcha'
        ),
    ),
    'buttons'        => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => 'сохранить'
        )
    )
);


