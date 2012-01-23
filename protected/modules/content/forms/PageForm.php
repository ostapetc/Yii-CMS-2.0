<?php

return array(
    'activeForm'=>array(
        'id' => 'page-form',
        'class' => 'CActiveForm',
        'enableAjaxValidation' => false,
        'clientOptions' => array('validateOnSubmit' => true, 'validateOnChange' => true)
    ),
    'elements' => array(
        'title'        => array('type' => 'text'),
        'url'          => array('type' => 'AliasField', 'source'=>'title'),
        'text'         => array('type' => 'editor'),
        'is_published' => array('type' => 'checkbox'),
        'meta_tags'    => array('type' => 'MetaTags')
    ),
    'buttons' => array(
        'submit' => array('type' => 'submit', 'value' => 'сохранить')
    )
);

