<?php

return array(
    'activeForm' => array(
        'id' => 'certificate-type-form',
		'enableAjaxValidation' => true,
    ),
    'elements' => array(
        'name' => array('type' => 'text'),

    ),
    'buttons' => array(
        'submit' => array('type'  => 'submit', 'value' => $this->model->isNewRecord ? 'создать' : 'сохранить'),
    )
);


