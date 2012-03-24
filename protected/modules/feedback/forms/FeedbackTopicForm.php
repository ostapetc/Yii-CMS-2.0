<?php

return array(
    'activeForm' => array(
        'id' => 'feedback-topic-form',
		'enableAjaxValidation' => true,
		'clientOptions' => array(
			'validateOnSubmit' => true,
			'validateOnChange' => true
		)
    ),
    'elements' => array(
        'name'  => array('type' => 'text'),
        'email' => array('type' => 'text'),
    ),
    'buttons' => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => $this->model->isNewRecord ? 'создать' : 'сохранить')
    )
);


