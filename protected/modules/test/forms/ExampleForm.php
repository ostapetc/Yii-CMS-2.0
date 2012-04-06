<?

return array(
    'enctype'    => 'multipart/form-data',
    'activeForm' => array(
        'id'                   => 'exampleModel-form',
        'enableAjaxValidation' => true,
        'clientOptions'        => array(
            'validateOnSubmit'=> true
        ),
    ),
    'elements'  => array(
        'first_name' => array(
            'type' => 'text',
        ),
        'last_name' => array(
            'type' => 'text',
        ),
        'patronymic' => array(
            'type' => 'text',
        ),
        'email' => array(
            'type' => 'textarea',
        ),
        'phone' => array(
            'type' => 'text',
        ),
        'password' => array(
            'type' => 'text',
        ),
        'birthdate' => array(
            'type' => 'date',
        ),
        'photo' => array(
            'type' => 'file',
        ),
        'file' => array(
            'type' => 'file',
        ),
        'is_published' => array(
            'type' => 'checkbox',
        ),
        'is_active' => array(
            'type' => 'checkbox',
        ),
        'gender' => array(
            'type' => 'dropdownlist',
            'items' => ExampleModel::$gender_oprions,
            'empty' => 'не выбрано',
        ),
        'status' => array(
            'type' => 'dropdownlist',
            'items' => ExampleModel::$status_oprions,
            'empty' => 'не выбрано',
        ),
        'activate_code' => array(
            'type' => 'text',
        ),
        'activate_date' => array(
            'type' => 'date',
        ),
        'password_recover_code' => array(
            'type' => 'text',
        ),
        'password_recover_date' => array(
            'type' => 'date',
        ),
    ),
    'buttons'   => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => 'сохранить'
        )
    )
);

