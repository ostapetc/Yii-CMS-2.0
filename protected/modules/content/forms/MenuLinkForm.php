<?php

Yii::app()->clientScript->registerScriptFile(
    Yii::app()->getModule('content')->assetsUrl() . '/js/menuLinkForm.js');

$roles = CHtml::listData(AuthItem::model()->roles, 'name', 'description');

return array(
    'activeForm' => array(
        'id'                   => 'menu-link-form',
        'enableAjaxValidation' => true,
    ),
    'elements'   => array(
        'parent_id'      => array(
            'type'   => 'dropdownlist',
            'items'  => MenuLink::model()->optionsTree($this->model->id, $this->model->menu_id),
            'prompt' => 'отсутствует'
        ),
        'page_id'        => array(
            'type'   => 'dropdownlist',
            'items'  => CHtml::listData(Page::model()->findAll(), 'id', 'title'),
            'prompt' => 'отсутствует'
        ),
        'title'          => array('type' => 'text'),
        'url'            => array('type' => 'text'),
        'user_role'      => array(
            'type'   => 'dropdownlist',
            'items'  => $roles,
            'prompt' => 'не указано'
        ),
        'not_user_role'  => array(
            'type'   => 'dropdownlist',
            'items'  => $roles,
            'prompt' => 'не указано'
        ),
        'order'          => array(
            'type'      => 'text',
            'maxlength' => 3,
            'class'     => 'small'
        ),
        'is_visible'     => array('type' => 'checkbox'),
    ),
    'buttons'    => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => $this->model->isNewRecord ? 'Добавить' : 'Сохранить'
        )
    )
);
