<?

return array(
    'activeForm' => array(
        'id'                  => 'mailerTemplate-form',
        'clientOptions'       => array(
            'validateOnSubmit'=> true
        ),
    ),
    'elements' => array(
        'name' => array(
            'type' => 'text',
        ),
        'code' => array(
            'type' => 'text',
        ),
        'subject' => array(
            'type' => 'text',
        ),
        'body' => array(
            'type' => 'editor',
        ),
    ),
    'buttons'   => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => 'сохранить'
        )
    )
);

