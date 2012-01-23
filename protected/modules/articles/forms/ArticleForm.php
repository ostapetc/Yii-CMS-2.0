<?php

return array(
    'activeForm' => array(
        'id'                   => 'article-form',
        'class'                => 'CActiveForm',
        'htmlOptions'          => array('enctype'=> 'multipart/form-data'),
        'enableAjaxValidation' => true,
    ),
    'elements'   => array(
        'section_id' => array(
            'type'  => 'dropdownlist',
            'items' => CHtml::listData(ArticleSection::model()->findAll(), 'id', 'name')
        ),
        'title'      => array(
            'type' => 'text',
            'hint' => 'Подсказка'
        ),
        'text'       => array('type' => 'editor'),
        'date'       => array('type' => 'date'),
        'files'      => array(
            'type'      => 'file_manager',
            'tag'       => 'file',
            'data_type' => 'any',
            'title'     => 'Файлы для скачивания'
        ),
    ),
    'buttons'    => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => $this->model->isNewRecord ? 'Создать' : 'Сохранить'
        ),
    )
);
