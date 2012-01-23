<?php

return array(
    'activeForm' => array(
        'id'                   => 'country-form',
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