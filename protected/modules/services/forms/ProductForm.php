<?php

return array(
    'activeForm' => array(
        'id' => 'product-form',
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
        'is_published' => array(
            'type' => 'checkbox'
        )
    ),
    'buttons' => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => $this->model->isNewRecord ? 'создать' : 'сохранить')
    )
);


