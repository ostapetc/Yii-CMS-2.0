<?php

return array(
    'activeForm' => array(
        'id'                   => 'city-form',
        'class'                => 'CActiveForm',
        'enableAjaxValidation' => true,
    ),
    'elements'   => array(
        'name' => array('type' => 'text')
    ),
    'buttons'    => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => 'Сохранить'
        )
    )
);