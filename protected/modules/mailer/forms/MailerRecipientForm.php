<?php

return array(
    'activeForm' => array(
        'id'                   => 'mailer-recipient-form',
        'enableAjaxValidation' => true,
    ),
    'elements'   => array(
        'letter_id' => array('type' => 'text'),
        'status'    => array('type' => 'text'),

    ),
    'buttons'    => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => $this->model->isNewRecord ? 'создать' : 'сохранить'
        )
    )
);


