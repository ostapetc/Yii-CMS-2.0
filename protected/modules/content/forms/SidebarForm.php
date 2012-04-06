<?

return array(
    'activeForm' => array(
        'id' => 'sidebar-form',
    ),
    'elements' => array(
        'title'        => array('type' => 'text'),
        'html'         => array('type' => 'editor'),
        'is_published' => array('type' => 'checkbox'),

    ),
    'buttons' => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => $this->model->isNewRecord ? 'создать' : 'сохранить'
        )
    )
);


