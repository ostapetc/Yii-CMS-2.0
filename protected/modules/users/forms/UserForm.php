<?

$roles = AuthItem::model()->findAllByAttributes(array('type' => CAuthItem::TYPE_ROLE));

return array(
    'activeForm'     => array(
        'id'                   => 'user-form',
        'enableAjaxValidation' => true,
        'clientOptions' => array('validateOnSubmit' => true)
    ),
    'elements'       => array(
        'email'      => array('type' => 'text'),
        'name'       => array('type' => 'text'),
        'birthdate'  => array('type' => 'date'),
        'gender'     => array(
            'type'  => 'dropdownlist',
            'items' => User::$gender_options
        ),
        'status'     => array(
            'type'  => 'dropdownlist',
            'items' => User::$status_options
        ),
        'role'       => array(
            'type'  => 'dropdownlist',
            'items' => CHtml::listData($roles, 'name', 'description')
        ),
        'password'   => array('type' => 'password'),
        'password_c' => array('type' => 'password'),
        'captcha'    => array(
            'type'  => 'captcha',
            'class' => 'captcha'
        ),
    ),
    'buttons'        => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => 'сохранить'
        )
    )
);


