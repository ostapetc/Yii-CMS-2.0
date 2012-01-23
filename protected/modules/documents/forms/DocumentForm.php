<?php

if (!$this->model->date_publish)
{
    $this->model->date_publish = Yii::app()->dateFormatter->format('dd.MM.y', time());
}

return array(
    'activeForm' => array(
        'id'                   => 'document-form',
        'enableAjaxValidation' => true,
    ),
    'elements'   => array(
        'name'         => array('type' => 'text'),
        'desc'         => array('type' => 'application.extensions.tiny_mce.TinyMCE'),
        'date_publish' => array('type' => 'date'),
        'is_published' => array('type' => 'checkbox')
    ),
    'buttons'    => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => $this->model->isNewRecord ? 'Добавить' : 'Сохранить'
        )
    )
);
