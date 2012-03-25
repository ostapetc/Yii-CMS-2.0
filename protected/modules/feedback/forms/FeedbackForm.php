<?php

return array(
    'action' => '/feedback/feedback/create',
    'activeForm' => array(
        'id'                   => 'feedback-form',
		'enableAjaxValidation' => true,
		'clientOptions' => array(
			'validateOnSubmit' => true,
			'validateOnChange' => true
		)
    ),
    'elements' => array(
        'name' => array(
            'type' => 'text'
        ),
        'email' => array(
            'type' => 'text'
        ),
        'topic_id' => array(
            'type'  => 'dropdownlist',
            'items' => CHtml::listData(FeedbackTopic::model()->findAll(), 'id', 'name')
        ),
        'text' => array(
            'type' => 'textarea'
        ),
        'from' => array(
            'type'  => 'hidden',
            'value' => base64_encode($_SERVER['REQUEST_URI'])
        ),
        'captcha'=>array(
            'type'  => 'captcha'
        ),
    ),
    'buttons' => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => 'Отправить сообщение')
    )
);


