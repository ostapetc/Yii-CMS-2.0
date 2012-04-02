<?

return array(
    'activeForm' => array(
        'id' => 'page-form',
		//'enableAjaxValidation' => true,
		//'clientOptions' => array(
		//	'validateOnSubmit' => true,
		//	'validateOnChange' => true
		//)
    ),
    'elements' => array(
        'language' => array('type' => 'text'),
        'title' => array('type' => 'text'),
        'url' => array('type' => 'textarea'),
        'text' => array('type' => 'text'),
        'is_published' => array('type' => 'text'),
        'order' => array('type' => 'text'),

    ),
    'buttons' => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => $this->model->isNewRecord ? 'создать' : 'сохранить')
    )
);


