<?php

$elements = array(
    'name'      => array('type' => 'text'),
    'subject'   => array('type' => 'text'),
    'text'      => array('type' => 'editor'),
    //'is_basic'  => array('type' => 'checkbox'),
//    'users_ids' => array('type' => 'UsersCheckboxes'),
);

if (!Yii::app()->user->isRootRole())
{
    unset($elements['is_basic']);
}

return array(
    'activeForm' => array(
        'id' => 'mailer-template-form',
		'enableAjaxValidation' => true
    ),
    'elements' => $elements,
    'buttons' => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => $this->model->isNewRecord ? 'создать' : 'сохранить')
    )
);

