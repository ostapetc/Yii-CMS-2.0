<?php

return array(
    'activeForm'=>array(
        'id' => 'page-form',
        'class' => 'CActiveForm',
        'enableAjaxValidation' => true,
        'clientOptions'=>array('validateOnSubmit'=>true)
    ),
    'elements' => array(
        'title' => array(
            'type' => 'text'
        ),
        'url' => array(
            'type'   => 'alias',
            'source' => 'title'
        ),
        'left_menu_id' => array(
            'type'  => 'dropdownlist',
            'items' => CHtml::listData(Menu::model()->findAll("code != '" . TopMenu::CODE ."'"), 'id', 'name'),
            'empty' => 'не отображать',
            'label' => 'Отображать на этой странице слева меню'
        ),
        'widget' => array(
            'type'   => 'dropdownlist',
            'prompt' => 'не выводить',
            'items'  => Page::$widgets
        ),
        'is_published' => array(
            'type' => 'checkbox'
        ),
        'on_main' => array(
            'type' => 'checkbox'),
        'short_text' => array(
            'type' => 'editor'
        ),
        'text' => array(
            'type' => 'editor'
        ),
        'meta_tags' => array(
            'type' => 'meta_tags'
        )
    ),
    'buttons' => array(
        'submit' => array('type' => 'submit', 'value' => t('сохранить'))
    )
);

