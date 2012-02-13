<?php

return array(
    'activeForm' => array(
        'id'                   => 'mailer-field-form',
        'enableAjaxValidation' => true,
    ),
    'elements'   => array(
        'code'  => array('type' => 'text'),
        'name'  => array('type' => 'text'),
        'value' => array('type' => 'text'),
    ),
    'buttons'    => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => $this->model->isNewRecord ? 'создать' : 'сохранить'
        )
    )
);


