<?php

$type = $this->model->element;

return array(
    'activeForm' => array(
        'id'                   => 'setting-form',
        'class'                => 'CActiveForm',
        'enableAjaxValidation' => true,
    ),
    'elements'   => array(
        'name'  => array('type' => 'text'),
        'value' => array('type' => $type)
    ),
    'buttons'    => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => 'Сохранить'
        )
    )
);