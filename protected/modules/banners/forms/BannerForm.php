<?php

$pages = Page::model()->published()->findAll("", array('order' => 'title'));

return array(
    'activeForm' => array(
        'id' => 'banner-form',
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data'
        ),
		'enableAjaxValidation' => true,
    ),
    'elements' => array(
        'name' => array('type' => 'text'),
        'page_id' => array(
            'type'   => 'dropdownlist',
            'prompt' => 'нет',
            'items'  => CHtml::listData($pages, 'id', 'title')
        ),
        'url' => array('type' => 'text', 'hint' => 'например: http://website.ru'),
        'image' => array('type' => 'file', 'hint'=>'
            Рекомендованный размер изображений:<br/>
            Для вертикальных баннеров: 272 px в ширину<br/>
            Для горизонатльных баннеров: 1001x242 px'
        ),
        'auth_objects' => array('type'     => 'AuthObjects'),
        'is_active' => array('type' => 'checkbox'),
        'date_active' => array(
            'type' => 'checkbox',
            'label' => 'Активировать по заданной дате',
            'checked' => (bool) $this->model->date_active || $this->model->date_start || $this->model->date_end,
            'hint' => 'Вы можете задать даты, в которые баннер будет отображаться.
                <br/>
                Дата начала показа - дата с которой баннер будет отображаться на сайте;
                <br/>
                Дата окончания показа - дата в которую баннер будет скрыт с сайта.'
        ),
        'date_start' => array('type' => 'date', 'range' => 'show_banner_period'),
        'date_end' => array('type' => 'date', 'range' => 'show_banner_period'),
        'src' => array(
            'type'  => 'hidden',
            'value' => $this->model->render(true)
        )

    ),
    'buttons' => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => $this->model->isNewRecord ? 'создать' : 'сохранить')
    )
);


