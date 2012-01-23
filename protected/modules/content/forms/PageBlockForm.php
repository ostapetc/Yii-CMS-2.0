<?php

return array(
    'activeForm' => array(
        'id'                   => 'page-part-form',
        'class'                => 'CActiveForm',
        'enableAjaxValidation' => true,
    ),
    'elements'   => array(
        'title' => array('type' => 'text'),
        'name'  => array('type' => 'text'),
        'text'  => array('type' => 'editor')
    ),
    'buttons'    => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => 'Сохранить'
        )
    )
);
