<?

return array(
    'activeForm' => array(
        'id'                   => 'quizTopic-form',
        'clientOptions'        => array(
            'validateOnSubmit'=> true
        ),
    ),
    'elements'  => array(
        'name' => array(
            'type' => 'text',
        ),
        'parent_id' => array(
            'type'  => 'dropdownlist',
            'items' => QuizTopic::model()->optionsTree('name', $this->model->isNewRecord ? null : $this->model->id),
            'empty' => ''
        )
    ),
    'buttons'   => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => 'сохранить'
        )
    )
);

