<?

return array(
    'activeForm' => array(
        'id' => 'outbox-email-form',
		//'enableAjaxValidation' => true,
		//'clientOptions' => array(
		//	'validateOnSubmit' => true,
		//	'validateOnChange' => true
		//)
    ),
    'elements' => array(
        'email' => array('type' => 'textarea'),
        'user_name' => array('type' => 'textarea'),
        'solution' => array('type' => 'text'),
        'subject' => array('type' => 'textarea'),
        'text' => array('type' => 'text'),
        'date_send' => array('type' => 'text'),

    ),
    'buttons' => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => $this->model->isNewRecord ? 'создать' : 'сохранить')
    )
);


