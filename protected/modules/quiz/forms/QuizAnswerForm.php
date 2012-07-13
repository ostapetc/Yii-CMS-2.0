<?

return array(
    'activeForm' => array(
        'id'                   => 'quizAnswer-form',
        'clientOptions'        => array(
            'validateOnSubmit'=> true
        ),
    ),
    'elements'  => array(
        'text' => array(
            'type' => 'editor'
        ),
        'points' => array(
            'type' => 'text'
        ),
        'is_right' => array(
            'type' => 'checkbox',
        ),
    ),
    'buttons'   => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => 'сохранить'
        )
    )
);

