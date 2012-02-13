<?php

return array(
	'activeForm' => array(
		'class' => 'CActiveForm',
		'enableAjaxValidation' => true,
	),
	'elements' => array(
		'name' => array('type' => 'text'),
		'is_published' => array('type' => 'checkbox')
	),
	'buttons' => array(
		'submit' => array('type' => 'submit', 'value' => 'Сохранить'),
	)
);
