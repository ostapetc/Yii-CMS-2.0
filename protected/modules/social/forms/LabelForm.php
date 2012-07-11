<?

return array(
    'enctype'    => 'multipart/form-data',
    'activeForm' => array(
        'id'                   => 'label-form',
        'clientOptions'        => array(
            'validateOnSubmit'=> true
        ),
    ),
    'elements'  => array(
        'desc' => array(
            'type' => 'textarea',
        ),
        'icon' => array(
            'type' => 'file',
        ),
    ),
    'buttons'   => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => 'сохранить'
        )
    )
);

