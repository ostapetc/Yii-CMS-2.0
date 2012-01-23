<?php
return array(
			'action' => '',
	'activeForm' => array(
		'id'     => 'feedback-form',
		'class'  => 'CActiveForm',
		'enableAjaxValidation' => true,
	),
	'elements' => array(
        'last_name'  => array('type' => 'text'),
        'first_name' => array('type' => 'text'),
        'patronymic' => array('type' => 'text'),
        'company'    => array('type' => 'text'),
        'position'   => array('type' => 'text'),
        'phone'      => array('type' => 'text'),
		'email'      => array('type' => 'text'),
		'comment'    => array('type' => 'textarea')
	),
	'buttons' => array(
		'submit' => array(
			'type'  => 'submit', 
			'value' => Yii::t('main', 'Отправить'),
			'id'    => 'feedback_button'
		)
	)
);
