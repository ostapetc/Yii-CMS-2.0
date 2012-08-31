<?

return array(
    'activeForm' => array(
        'id'                   => 'videoAccount-form',
        'clientOptions'        => array(
            'validateOnSubmit' => true
        ),
    ),
    'elements'  => array(
        'api_key' => array(
            'type' => 'text',
        ),
        'api_secret' => array(
            'type' => 'text',
        ),
        'request_url' => array(
            'type' => 'text',
        ),
        'auth_url' => array(
            'type' => 'text',
        ),
        'access_url' => array(
            'type' => 'text',
        ),
        'login' => array(
             'type' => 'text'
        ),
        'password' => array(
            'type' => 'text'
        )
    ),
    'buttons'   => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => 'сохранить'
        )
    )
);

