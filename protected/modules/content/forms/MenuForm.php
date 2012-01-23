<?php

return array(
    'activeForm' => array(
        'id'                   => 'menu-form',
        'class'                => 'CActiveForm',
        'enableAjaxValidation' => true,
    ),
    'elements'   => array(
        'name'       => array('type' => 'text'),
        'is_visible' => array('type' => 'checkbox')
    ),
    'buttons'    => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => $this->model->isNewRecord ? 'Далее' : 'Сохранить'
        ),
    )
);