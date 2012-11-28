<?

return array(
    'activeForm' => array(
        'id'                   => 'mailerOutbox-form',
        'enableAjaxValidation' => false,
        'clientOptions' => array(
            'validateOnType'   => false,
            'validateOnSubmit' => false,
        ),
    ),
    'elements' => array(
        'template_id' => array(
            'type'  => 'dropdownlist',
            'items' => CHtml::listData(MailerTemplate::model()->findAll('', array('order' => 'id DESC')), 'id', 'name'),
            'empty' => 'не выбран'
        ),
        'email' => array(
            'type' => 'text'
        ),
        'user_id' => array(
            'type'  => 'dropdownlist',
            'items' =>  CHtml::listData(User::model()->findAll(), 'id', 'name'),
            'empty' => 'не выбран'
        )
    ),
    'buttons' => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => $this->model->isNewRecord ? 'создать' : 'сохранить'
        )
    )
);


