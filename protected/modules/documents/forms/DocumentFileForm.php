<?php

return array(
    'activeForm' => array(
        'id'                   => 'document-file-form',
        'class'                => 'CActiveForm',
        'htmlOptions'          => array('enctype'=> 'multipart/form-data'),
        'enableAjaxValidation' => true,
    ),
    'elements'   => array(
        'title'       => array('type' => 'text'),
        'file'        => array('type' => 'file'),
        'document_id' => array('type' => 'hidden')
    ),
    'buttons'    => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => $this->model->isNewRecord ? 'Создать' : 'Сохранить'
        )
    )
);