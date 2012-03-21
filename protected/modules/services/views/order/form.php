<?php

return array(
    'activeForm' => array(
        'id' => 'order-form',
		//'enableAjaxValidation' => true,
		//'clientOptions' => array(
		//	'validateOnSubmit' => true,
		//	'validateOnChange' => true
		//)
    ),
    'elements' => array(
        'product_id' => array('type' => 'text'),
        'name' => array('type' => 'textarea'),
        'email' => array('type' => 'textarea'),
        'action_code' => array('type' => 'textarea'),
        'comment' => array('type' => 'text'),

    ),
    'buttons' => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => $this->model->isNewRecord ? 'создать' : 'сохранить')
    )
);


