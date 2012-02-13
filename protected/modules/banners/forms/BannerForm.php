<?php
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
        'image'       => array(
            'type' => 'file',
            'hint' => 'Рекомендованный размер изображения: 275px в ширину'
        ),
        'pages'       => array(
            'type'  => 'multi_select',
            'items' => $this->model->allPages,
        ),
        'is_published'   => array('type' => 'checkbox'),
        'date_active' => array(
            'type'    => 'checkbox',
            'hint'    => 'Вы можете задать даты, в которые баннер будет отображаться.<br/>
<b>Дата начала показа</b> - дата с которой баннер будет отображаться на сайте.<br/>
<b>Дата окончания показа</b> - дата в которую баннер будет скрыт с сайта.',
            'checked' => (bool)$this->model->date_active || $this->model->date_start || $this->model->date_end
        ),
        'date_start'  => array(
            'type' => 'date',
            'range'=> 'banner_activate'
        ),
        'date_end'    => array(
            'type' => 'date',
            'range'=> 'banner_activate'
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


