<?

return array(
    'activeForm' => array(
        'id'                   => 'quiz-form',
        'clientOptions'        => array(
            'validateOnSubmit'=> true
        ),
    ),
    'elements'  => array(
        'name' => array(
            'type' => 'text'
        ),
        'topics_ids' => array(
            'type'       => 'application.components.formElements.TreeCheckboxSelect.TreeCheckboxSelect',
            'tree_model' => QuizTopic::model(),
            'label'      => t('Тематики')
        )
    ),
    'buttons'   => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => 'сохранить'
        )
    )
);

