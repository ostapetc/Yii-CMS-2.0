<?

return array(
    'activeForm' => array(
        'id'                   => 'quizQuestion-form',
        'clientOptions'        => array(
            'validateOnSubmit'=> true
        ),
    ),
    'elements'  => array(
        'topic_id' => array(
            'type'  => 'dropdownlist',
            'items' => QuizTopic::model()->optionsTree(),
            'empty' => ''
        ),
        'text' => array(
            'type' => 'editor'
        ),
    ),
    'buttons'   => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => 'сохранить'
        )
    )
);

