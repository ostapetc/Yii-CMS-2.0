<?php

$this->model->roles = array_keys(CHtml::listData($this->model->roles, 'name', 'description'));

$pages = Page::model()->published()->findAll("", array('order' => 'title'));

return array(
    'activeForm' => array(
        'id'                   => 'banner-form',
        'htmlOptions'          => array(
            'enctype' => 'multipart/form-data'
        ),
        'enableAjaxValidation' => true,
    ),
    'elements'   => array(
        'name'        => array('type' => 'text'),
        'page_id'     => array(
            'type'   => 'dropdownlist',
            'prompt' => 'нет',
            'items'  => CHtml::listData($pages, 'id', 'title')
        ),
        'url'         => array(
            'type' => 'text',
            'hint' => 'например: http://website.ru'
        ),
        'image'       => array('type' => 'file'),
        'roles'       => array(
            'type'  => 'multi_select',
            'items' => CHtml::listData(AuthItem::model()->roles, 'name', 'description'),
        ),

        'is_active'   => array('type' => 'checkbox'),
        'date_active' => array(
            'type'    => 'checkbox',
            'label'   => 'Активировать по заданной дате',
            'checked' => (bool)$this->model->date_active || $this->model->date_start || $this->model->date_end
        ),
        'date_start'  => array(
            'type'  => 'date',
            'range' => 'show_banner_period'
        ),
        'date_end'    => array(
            'type'  => 'date',
            'range' => 'show_banner_period'
        ),
        'src'         => array(
            'type'  => 'hidden',
            'value' => $this->model->render(true)
        )

    ),
    'buttons'    => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => $this->model->isNewRecord ? 'создать' : 'сохранить'
        )
    )
);


