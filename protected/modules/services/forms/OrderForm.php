<?php

$criteria = new CDbCriteria();
$criteria->scopes = array('published');
$criteria->order  = '`order` DESC';

$products = Product::model()->findAll($criteria);
$products = CHtml::listData($products, 'id', 'name');

return array(
    'action'     => '/services/order/create',
    'activeForm' => array(
        'id' => 'order-form',
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
        'product_id' => array(
            'type'   => 'dropdownlist',
            'items'  => $products,
            'prompt' => 'не выбран'
        ),
        'action_code' => array(
            'type' => 'text'
        ),
        'comment' => array(
            'type' => 'textarea'
        ),
        'captcha' => array(
            'type' => 'captcha'
        ),
        'from' => array(
            'type'  => 'hidden',
            'value' => base64_encode($_SERVER['REQUEST_URI'])
        ),
    ),
    'buttons' => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => 'Оформить заказ'
        )
    )
);


